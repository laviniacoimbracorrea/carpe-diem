<?php

namespace Source\Controller;

use Source\Models\User;

class Users extends Api{

// LOGIN
public function auth(array $data): void {
  $data = $this->requestData($data);

  // Aceita type_id, que é o nome enviado pelo JavaScript.
  // Se algum formulário antigo ainda enviar typeId, normaliza para type_id.
  if (isset($data['typeId']) && !isset($data['type_id'])) {
      $data['type_id'] = $data['typeId'];
  }

  if (!$this->validateLoginFields($data)) {
    return;
  }

   $expectedTypeId = isset($data['type_id']) ? (int)$data['type_id'] : null;

   if (!in_array($expectedTypeId, [1, 2, 3], true)) {
         $this->call(
             400,
             "bad_request",
             "Tipo de usuário inválido.",
             "error"
         )->back();
        return;
        }
  
  $user = new User();

  if (!$user->login($data['email'], $data['password'], $expectedTypeId)) {
            $this->call(
                401,
                "unauthorized",
                $user->getErrorMessage(),
                "error"
            )->back();

            return;
        }

        $response = [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "email" => $user->getEmail(),
            "photo" => $user->getPhoto(),
            "city" => $user->getCity(),
            "state" => $user->getState(),
            "phoneNumber" => $user->getPhoneNumber(),
            "specialty_id" => $user->getSpecialtyId(),
            "type_id" => $user->getTypeId(),
            "token" => $user->getToken()
        ];

        $this->call(
            200,
            "success",
            "Usuário logado com sucesso",
            "success"
        )->back($response);
    }


public function me(array $data = []): void
{
    $auth = $this->authenticatedUser();

    if (!$auth) {
        $this->call(401, "unauthorized", "Sessão inválida ou expirada.", "error")->back();
        return;
    }

    $user = new User();
    if (!$user->selectById((int)$auth->id) || !$user->isActive() || !$user->isApproved()) {
        $this->call(401, "unauthorized", "Usuário não encontrado, desativado ou ainda não aprovado.", "error")->back();
        return;
    }

    $user->setId((int)$auth->id);
    $user->setTypeId((int)$auth->type_id);
    $user->refreshToken();

    $this->call(200, "success", "Sessão válida.", "success")->back($this->userResponse($user) + ["token" => $user->getToken()]);
}

// Lista de fotógrafos aprovados para permitir contato pelos portfólios públicos.
public function listPhotographers(array $data = []): void
{
    try {
        $pdo = \Source\Core\Connect::getInstance();
        $stmt = $pdo->query("SELECT u.id, u.name, u.photo, u.city, u.state, u.specialty_id, s.type AS specialty FROM users u LEFT JOIN specialty s ON s.id = u.specialty_id WHERE u.type_id = 2 AND u.active = 1 AND COALESCE(u.approval_status, 1) = 1 ORDER BY u.name");
        $this->call(200, "success", "Fotógrafos disponíveis.", "success")->back($stmt->fetchAll(\PDO::FETCH_ASSOC));
    } catch (\Throwable $e) {
        $this->call(500, "internal_server_error", "Não foi possível carregar os fotógrafos.", "error")->back([]);
    }
}

// Upload da foto de perfil do usuário autenticado (cliente ou fotógrafo).
public function uploadPhoto(array $data = []): void
{
    $auth = $this->authenticatedUser();
    if (!$auth || !in_array((int)$auth->type_id, [1, 2, 3], true)) {
        $this->call(401, 'unauthorized', 'Faça login para atualizar sua foto.', 'error')->back(); return;
    }
    $user = new User();
    if (!$user->selectById((int)$auth->id)) {
        $this->call(404, 'not_found', 'Perfil não encontrado.', 'error')->back(); return;
    }
    $relative = null;
    try {
        $relative = \Source\Support\Upload::image($_FILES['photo'] ?? [], 'profiles', 5 * 1024 * 1024);
        $old = $user->getPhoto();
        $user->setPhoto($relative);
        if (!$user->updateById((int)$auth->id)) {
            throw new \RuntimeException('Falha ao persistir a foto no banco.');
        }
        if ($old && $old !== $relative) \Source\Support\Upload::remove($old, 'profiles');
        $user->setId((int)$auth->id);
        $user->setTypeId((int)$auth->type_id);
        $user->refreshToken();
        $this->call(200, 'success', 'Foto de perfil atualizada.', 'success')->back($this->userResponse($user) + ['token' => $user->getToken()]);
    } catch (\LengthException $e) {
        $this->call(413, 'file_too_large', $e->getMessage(), 'error')->back();
    } catch (\InvalidArgumentException $e) {
        $this->call(400, 'bad_request', $e->getMessage(), 'error')->back();
    } catch (\Throwable $e) {
        if ($relative) \Source\Support\Upload::remove($relative, 'profiles');
        $this->call(500, 'internal_server_error', 'Não foi possível salvar a foto.', 'error')->back();
    }
}

// ADMINISTRADOR
// Administradores NÃO podem ser cadastrados pela tela.
// Eles são previamente cadastrados no banco.

public function registerAdmin(array $data): void {
    $this->call(
        403,
        "forbidden",
        "O cadastro de administradores é restrito.",
        "error"
    )->back();
}

public function adminList(array $data = []): void
{
    if (!$this->authToken(1)) {
        $this->call(401, "unauthorized", "Acesso restrito ao administrador.", "error")->back();
        return;
    }

    $user = new User();
    $users = $user->listForAdmin();

    $this->call(200, "success", "Usuários carregados.", "success")->back([
        "users" => $users
    ]);
}

public function adminSetUserStatus(array $data): void
{
    if (!$this->authToken(1)) {
        $this->call(401, "unauthorized", "Acesso restrito ao administrador.", "error")->back();
        return;
    }

    $data = $this->requestData($data);
    $userId = isset($data['id']) ? (int)$data['id'] : 0;
    $active = isset($data['active']) ? (int)$data['active'] === 1 : null;

    if ($userId <= 0 || $active === null) {
        $this->call(400, "bad_request", "ID e status do usuário são obrigatórios.", "error")->back();
        return;
    }

    if ($userId === (int)$this->userAuthId) {
        $this->call(400, "bad_request", "O administrador atual não pode desativar a própria conta.", "error")->back();
        return;
    }

    $user = new User();
    if (!$user->setActiveStatus($userId, $active)) {
        $this->call(404, "not_found", $user->getErrorMessage() ?? "Usuário não encontrado.", "error")->back();
        return;
    }

    $this->call(200, "success", $active ? "Usuário ativado com sucesso." : "Usuário desativado com sucesso.", "success")->back();
}

public function adminSetPhotographerApproval(array $data): void
{
    if (!$this->authToken(1)) {
        $this->call(401, "unauthorized", "Acesso restrito ao administrador.", "error")->back();
        return;
    }

    $data = $this->requestData($data);
    $userId = isset($data['id']) ? (int)$data['id'] : 0;
    $status = isset($data['approval_status']) ? (int)$data['approval_status'] : 0;

    if ($userId <= 0 || !in_array($status, [1, 2], true)) {
        $this->call(400, "bad_request", "ID e decisão do fotógrafo são obrigatórios.", "error")->back();
        return;
    }

    $user = new User();
    if (!$user->setPhotographerApproval($userId, $status)) {
        $this->call(404, "not_found", $user->getErrorMessage() ?? "Fotógrafo não encontrado.", "error")->back();
        return;
    }

    $message = $status === 1
        ? "Fotógrafo aprovado com sucesso."
        : "Cadastro de fotógrafo recusado.";

    $this->call(200, "success", $message, "success")->back();
}

public function updateAdmin(array $data): void {
     $this->updateProfile(
         $data,
         1,
         "Administrador"
     );
}

public function deleteAdmin(array $data): void {
     $this->deleteProfile(
         $data,
         1,
         "Administrador"
     );
}

 
// FOTÓGRAFO
public function registerPhotographer(array $data): void {
    $data = $this->requestData($data);

    $specialtyId = isset($data['specialty_id']) ? (int)$data['specialty_id'] : null;

    $this->createProfile(
        $data,
        2,
        $specialtyId
    );
}

public function updatePhotographer(array $data): void {
    $this->updateProfile(
        $data, 
        2, 
        "Fotógrafo"
    );
}

public function deletePhotographer(array $data): void {
        $this->deleteProfile(
            $data,
            2, 
            "Fotógrafo"
        );
}

// CLIENTE
public function registerClient(array $data): void {
        $this->createProfile(
            $data, 
            3
        );
}

public function updateClient(array $data): void {
        $this->updateProfile(
            $data, 
            3, 
            "Cliente"
        );
}

public function deleteClient(array $data): void {
        $this->deleteProfile(
            $data,
            3, 
            "Cliente"
        );
}

// CRIAR PERFIL
private function createProfile(array $data, int $typeId, ?int $specialtyId = null): void {
    $data = $this->requestData($data);

    if (!$this->validateRequiredFields($data)) {
        return;
    }
    
// Cliente não pode possuir especialidade
    if ($typeId === 3) {
       $specialtyId = null;
   }

// Fotógrafo precisa de especialidade
    if ($typeId === 2 && empty($specialtyId)) {
       $this->call(
           400,
           "bad_request",
           "A especialidade do fotógrafo é obrigatória.",
           "error"
       )->back();
    return;
    }

        $user = new User(
            null,
            $typeId,
            $specialtyId,
            $data['name'],
            $data['email'],
            $data['password'],
            null,
            $data['city'] ?? '',
            $data['state'] ?? '',
            $data['phone_number'] ?? ''
        );

        // Clientes entram imediatamente. Fotógrafos novos ficam pendentes até o administrador aprovar.
        $user->setApprovalStatus($typeId === 2 ? 0 : 1);

    if (!$user->insert()) {
          $this->call(
          409,
          "conflict",
          $user->getErrorMessage() ?? "Não foi possível cadastrar o usuário.",
          "error"
        )->back();
    return;
    }

        $this->call(
            201,
            "success",
            $typeId === 2
                ? "Cadastro realizado. Aguarde a aprovação do administrador para entrar como fotógrafo."
                : "Usuário cadastrado com sucesso",
            "created"
        )->back(
            $this->userResponse($user)
        );
    }
 
// ATUALIZAR PERFIL
private function updateProfile(array $data, int $typeId, string $roleName): void {
    $data = $this->requestData($data);

    if (!$this->authToken($typeId)) {
        $this->call(401, "unauthorized", "Acesso restrito a {$roleName}s.", "error")->back();
        return;
    }

    $required = ['name', 'email', 'city', 'state', 'phone_number'];
    foreach ($required as $field) {
        if (!isset($data[$field]) || trim((string)$data[$field]) === '') {
            $this->call(400, "bad_request", "Todos os dados do perfil são obrigatórios.", "error")->back();
            return;
        }
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $this->call(400, "bad_request", "Informe um e-mail válido.", "error")->back();
        return;
    }

    $user = new User();
    if (!$user->selectById((int)$this->userAuthId)) {
        $this->call(404, "not_found", "Usuário não encontrado.", "error")->back();
        return;
    }

    $user->setName(trim($data['name']));
    $user->setEmail(trim($data['email']));
    $user->setCity(trim($data['city']));
    $user->setState(trim($data['state']));
    $user->setPhoneNumber(trim($data['phone_number']));

    if ($typeId === 2) {
        if (empty($data['specialty_id'])) {
            $this->call(400, "bad_request", "A especialidade do fotógrafo é obrigatória.", "error")->back();
            return;
        }
        $user->setSpecialtyId((int)$data['specialty_id']);
    } else {
        $user->setSpecialtyId(null);
    }

    if (!empty($data['password'])) {
        if (strlen($data['password']) < 6) {
            $this->call(400, "bad_request", "A nova senha deve possuir pelo menos 6 caracteres.", "error")->back();
            return;
        }
        $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
    }

    if (!$user->updateById((int)$this->userAuthId)) {
        $this->call(500, "internal_server_error", $user->getErrorMessage() ?? "Erro ao atualizar os dados.", "error")->back();
        return;
    }

    $user->setId((int)$this->userAuthId);
    $user->setTypeId($typeId);
    $user->refreshToken();

    $this->call(200, "success", "Dados do {$roleName} atualizados com sucesso.", "success")->back($this->userResponse($user) + [
        "token" => $user->getToken()
    ]);
}

// EXCLUIR PERFIL
private function deleteProfile(array $data, int $typeId, string $roleName): void {
    if (!$this->authToken($typeId)) {
            $this->call(
                401,
                "unauthorized",
                "Acesso restrito a {$roleName}s.",
                "error"
            )->back();
        return;
    }

        $user = new User();

    if (!$user->softDeleteById((int)$this->userAuthId)) {
            $this->call(
                500,
                "internal_server_error",
                $user->getErrorMessage() ??
                "Erro ao excluir conta.",
                "error"
            )->back();
          return;
        }

        $this->call(
            200,
            "success",
            "Conta de {$roleName} excluída com sucesso.",
            "success"
        )->back();
}

// VALIDA LOGIN
private function validateLoginFields(array $data): bool {
   if (!isset($data['email'], $data['password'], $data['type_id']) || empty($data['email']) || empty($data['password']) || empty($data['type_id']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->call(
                400,
                "bad_request",
                "E-mail, senha e tipo de usuário são obrigatórios.",
                "error"
            )->back();

            return false;
        }
        return true;
    }

    
// VALIDA CADASTRO
private function validateRequiredFields(array $data): bool {
     $required = ['name', 'email', 'password'];

    foreach($required as $field) {
        if(!isset($data[$field]) || trim((string)$data[$field]) === '') {
            $this->call(
                400,
                "bad_request",
                "Todos os campos obrigatórios devem ser preenchidos.",
                "error"
            )->back();
          return false;
        }
    }

        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->call(
                400,
                "bad_request",
                "Informe um e-mail válido.",
                "error"
            )->back();

            return false;
        }

        if (strlen($data['password']) < 6) {
            $this->call(
                400,
                "bad_request",
                "A senha deve possuir pelo menos 6 caracteres.",
                "error"
            )->back();

            return false;
        }

        return true;
    }

// RESPOSTA DO USUÁRIO
private function userResponse(User $user): array {
    return [
        "id" => $user->getId(),
        "name" => $user->getName(),
        "email" => $user->getEmail(),
        "photo" => $user->getPhoto(),
        "city" => $user->getCity(),
        "state" => $user->getState(),
        "phoneNumber" => $user->getPhoneNumber(),
        "specialty_id" => $user->getSpecialtyId(),
        "type_id" => $user->getTypeId(),
        "approval_status" => $user->getApprovalStatus(),
        "active" => $user->getActive(),
        "last_login_at" => $user->getLastLoginAt(),
        "created_at" => $user->getCreatedAt()
    ];
  }
}