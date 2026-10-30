<?php

namespace Source\Controller;

use Source\Models\User;

class Users extends Api
{
    private const MAIN_ADMIN_IDS = [8];

    public function auth(array $data): void
    {
        if (!$this->validateLoginFields($data)) {
            return;
        }

        $typeId = filter_var(
            $data['type_id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (!in_array($typeId, [1, 2, 3], true)) {
            $this->call(
                400,
                'bad_request',
                'Tipo de usuário inválido.',
                'error'
            )->back();

            return;
        }

        $user = new User();

        if (!$user->login(
            $data['email'],
            $data['password'],
            $typeId
        )) {
            $this->call(
                401,
                'unauthorized',
                $user->getErrorMessage(),
                'error'
            )->back();

            return;
        }

        $response = [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'photo' => $user->getPhoto(),
            'type_id' => $user->getTypeId(),
            'token' => $user->getToken()
        ];

        $this->call(
            200,
            'success',
            'Usuário logado com sucesso.',
            'success'
        )->back($response);
    }

    // ADMINISTRADORES

    public function registerAdmin(array $data): void
    {
        if (!$this->authToken(1)) {
            $this->call(
                401,
                'unauthorized',
                'Autenticação de administrador necessária.',
                'error'
            )->back();

            return;
        }

        if (!in_array(
            $this->userAuthId,
            self::MAIN_ADMIN_IDS,
            true
        )) {
            $this->call(
                403,
                'forbidden',
                'Somente os administradores principais podem cadastrar administradores.',
                'error'
            )->back();

            return;
        }

        $this->createProfile($data, 1);
    }

    public function updateAdmin(array $data): void
    {
        if (!$this->authToken(1)) {
            $this->call(
                401,
                'unauthorized',
                'Autenticação de administrador necessária.',
                'error'
            )->back();

            return;
        }

        if (!in_array(
            $this->userAuthId,
            self::MAIN_ADMIN_IDS,
            true
        )) {
            $this->call(
                403,
                'forbidden',
                'Somente os administradores principais podem atualizar contas de administrador.',
                'error'
            )->back();

            return;
        }

        $this->updateProfile($data, 1, 'Administrador');
    }

    public function deleteAdmin(array $data): void
    {
        if (!$this->authToken(1)) {
            $this->call(
                401,
                'unauthorized',
                'Autenticação de administrador necessária.',
                'error'
            )->back();

            return;
        }

        if (!in_array(
            $this->userAuthId,
            self::MAIN_ADMIN_IDS,
            true
        )) {
            $this->call(
                403,
                'forbidden',
                'Somente os administradores principais podem excluir contas de administrador.',
                'error'
            )->back();

            return;
        }

        $targetId = filter_var(
            $data['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (!$targetId || in_array(
            $targetId,
            self::MAIN_ADMIN_IDS,
            true
        )) {
            $this->call(
                400,
                'bad_request',
                'ID inválido ou conta principal protegida.',
                'error'
            )->back();

            return;
        }

        $user = new User();

        if (
            !$user->selectById($targetId) ||
            $user->getTypeId() !== 1
        ) {
            $this->call(
                404,
                'not_found',
                'Administrador não encontrado.',
                'error'
            )->back();

            return;
        }

        if (!$user->softDeleteById($targetId)) {
            $this->call(
                500,
                'internal_server_error',
                'Não foi possível desativar o administrador.',
                'error'
            )->back();

            return;
        }

        $this->call(
            200,
            'success',
            'Administrador desativado com sucesso.',
            'success'
        )->back();
    }

    // FOTÓGRAFOS

    public function registerPhotographer(array $data): void
    {
        $specialityId = !empty($data['speciality_id'])
            ? (int) $data['speciality_id']
            : null;

        $this->createProfile($data, 2, $specialityId);
    }

    public function updatePhotographer(array $data): void
    {
        $this->updateProfile($data, 2, 'Fotógrafo');
    }

    public function deletePhotographer(array $data): void
    {
        $this->deleteProfile(2, 'Fotógrafo');
    }

    public function approvePhotographer(array $data): void
    {
        $this->changePhotographerStatus($data, 'aprovado');
    }

    public function rejectPhotographer(array $data): void
    {
        $this->changePhotographerStatus($data, 'rejeitado');
    }

    private function changePhotographerStatus(
        array $data,
        string $status
    ): void {
        if (!$this->authToken(1)) {
            $this->call(
                401,
                'unauthorized',
                'Autenticação de administrador necessária.',
                'error'
            )->back();

            return;
        }

        if (!in_array(
            $this->userAuthId,
            self::MAIN_ADMIN_IDS,
            true
        )) {
            $this->call(
                403,
                'forbidden',
                'Somente o administrador principal pode aprovar ou rejeitar fotógrafos.',
                'error'
            )->back();

            return;
        }

        $targetId = filter_var(
            $data['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (!$targetId) {
            $this->call(
                400,
                'bad_request',
                'ID do fotógrafo inválido.',
                'error'
            )->back();

            return;
        }

        $photographer = new User();

        if (
            !$photographer->selectById($targetId) ||
            $photographer->getTypeId() !== 2
        ) {
            $this->call(
                404,
                'not_found',
                'Fotógrafo não encontrado.',
                'error'
            )->back();

            return;
        }

        $photographer->setStatus($status);

        if (!$photographer->updateById($targetId)) {
            $this->call(
                500,
                'internal_server_error',
                'Não foi possível atualizar o status do fotógrafo.',
                'error'
            )->back();

            return;
        }

        $message = $status === 'aprovado'
            ? 'Fotógrafo aprovado com sucesso.'
            : 'Cadastro do fotógrafo rejeitado.';

        $this->call(
            200,
            'success',
            $message,
            'success'
        )->back();
    }

    // CLIENTES

    public function registerClient(array $data): void
    {
        $this->createProfile($data, 3);
    }

    public function updateClient(array $data): void
    {
        $this->updateProfile($data, 3, 'Cliente');
    }

    public function deleteClient(array $data): void
    {
        $this->deleteProfile(3, 'Cliente');
    }

    // CADASTRO DE USUÁRIOS

    private function createProfile(
        array $data,
        int $typeId,
        ?int $specialityId = null
    ): void {
        if (!$this->validateRequiredFields($data)) {
            return;
        }

        $status = $typeId === 2 ? 'pendente' : 'aprovado';

        $user = new User(
            null,
            $typeId,
            $specialityId,
            trim($data['name']),
            trim($data['email']),
            $data['password'],
            $data['photo'] ?? null,
            $data['city'] ?? null,
            $data['state'] ?? null,
            $data['phone_number'] ?? null,
            $status
        );

        if (!$user->insert()) {
            $message = $user->getErrorMessage()
                ?? 'Não foi possível cadastrar o usuário.';

            $statusCode = $message === 'E-mail já cadastrado.'
                ? 409
                : 400;

            $this->call(
                $statusCode,
                $statusCode === 409 ? 'conflict' : 'bad_request',
                $message,
                'error'
            )->back();

            return;
        }

        $this->call(
            201,
            'success',
            'Usuário cadastrado com sucesso.',
            'created'
        )->back($this->userResponse($user));
    }

    // ATUALIZAÇÃO DE PERFIL

    private function updateProfile(
        array $data,
        int $typeId,
        string $roleName
    ): void {
        if (!$this->authToken($typeId)) {
            $this->call(
                401,
                'unauthorized',
                "Acesso restrito a {$roleName}s.",
                'error'
            )->back();

            return;
        }

        if (
            !isset($data['name'], $data['email']) ||
            trim($data['name']) === '' ||
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
        ) {
            $this->call(
                400,
                'bad_request',
                'Nome e e-mail válidos são obrigatórios.',
                'error'
            )->back();

            return;
        }

        $user = new User();

        if (!$user->selectById($this->userAuthId)) {
            $this->call(
                404,
                'not_found',
                'Usuário não encontrado.',
                'error'
            )->back();

            return;
        }

        $user->setName(trim($data['name']));
        $user->setEmail(trim($data['email']));

        if (!$user->updateById($this->userAuthId)) {
            $this->call(
                400,
                'bad_request',
                $user->getErrorMessage()
                    ?? 'Não foi possível atualizar os dados.',
                'error'
            )->back();

            return;
        }

        $this->call(
            200,
            'success',
            "Dados do {$roleName} atualizados com sucesso.",
            'success'
        )->back();
    }

    // EXCLUSÃO DE PERFIL

    private function deleteProfile(
        int $typeId,
        string $roleName
    ): void {
        if (!$this->authToken($typeId)) {
            $this->call(
                401,
                'unauthorized',
                "Acesso restrito a {$roleName}s.",
                'error'
            )->back();

            return;
        }

        $user = new User();

        if (!$user->softDeleteById($this->userAuthId)) {
            $this->call(
                400,
                'bad_request',
                $user->getErrorMessage()
                    ?? "Não foi possível desativar a conta de {$roleName}.",
                'error'
            )->back();

            return;
        }

        $this->call(
            200,
            'success',
            "Conta de {$roleName} desativada com sucesso.",
            'success'
        )->back();
    }

    // VALIDAÇÕES

    private function validateLoginFields(array $data): bool
    {
        if (
            !isset($data['email'], $data['password']) ||
            !is_string($data['email']) ||
            !is_string($data['password']) ||
            trim($data['email']) === '' ||
            $data['password'] === '' ||
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
        ) {
            $this->call(
                400,
                'bad_request',
                'E-mail e senha válidos são obrigatórios.',
                'error'
            )->back();

            return false;
        }

        return true;
    }

    private function validateRequiredFields(array $data): bool
    {
        if (
            !isset($data['password']) ||
            !is_string($data['password']) ||
            $data['password'] === ''
        ) {
            $this->call(
                400,
                'bad_request',
                'A senha é obrigatória.',
                'error'
            )->back();

            return false;
        }

        if (
            !isset($data['name'], $data['email']) ||
            !is_string($data['name']) ||
            !is_string($data['email']) ||
            trim($data['name']) === '' ||
            !filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL)
        ) {
            $this->call(
                400,
                'bad_request',
                'Nome e e-mail válidos são obrigatórios.',
                'error'
            )->back();

            return false;
        }

        return true;
    }

    // RESPOSTA DO USUÁRIO

    private function userResponse(User $user): array
    {
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'photo' => $user->getPhoto(),
            'city' => $user->getCity(),
            'state' => $user->getState(),
            'phoneNumber' => $user->getPhoneNumber(),
            'type_id' => $user->getTypeId(),
            'status' => $user->getStatus()
        ];
    }
}