<?php

namespace Source\Controller;

use Source\Models\User;

class Users extends Api
{
   
    public function auth(array $data): void
    {
        if (!$this->validateLoginFields($data)) return;

        $user = new User();
        if (!$user->login($data['email'], $data['password'])) {
            $this->call(401, "unauthorized", $user->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "photo" => $user->getPhoto(),
            "type_id" => $user->getTypeId(),
            "token" => $user->getToken(),
        ];

        $this->call(200, "success", "Usuário logado com sucesso", "success")->back($response);
    }

    public function registerAdmin(array $data): void
    {
        $this->createProfile($data, 1);
    }

    public function updateAdmin(array $data): void
    {
        $this->updateProfile($data, 1, "Administrador");
    }

    public function deleteAdmin(array $data): void
    {
        $this->deleteProfile(1, "Administrador");
    }

    public function registerPhotographer(array $data): void
    {
        $this->createProfile($data, 2, $data['speciality_id'] ?? null);
    }

    public function updatePhotographer(array $data): void
    {
        $this->updateProfile($data, 2, "Fotógrafo");
    }

    public function deletePhotographer(array $data): void
    {
        $this->deleteProfile(2, "Fotógrafo");
    }

    public function registerClient(array $data): void
    {
        $this->createProfile($data, 3);
    }

    public function updateClient(array $data): void
    {
        $this->updateProfile($data, 3, "Cliente");
    }

    public function deleteClient(array $data): void
    {
        $this->deleteProfile(3, "Cliente");
    }

    private function createProfile(array $data, int $typeId, ?int $specialityId = null): void
    {
        if (!$this->validateRequiredFields($data)) return;

        $user = new User(
            null, 
            $typeId, 
            $specialityId, 
            $data['name'], 
            $data['email'], 
            $data['password'], 
            $data['photo'] ?? null, 
            $data['city'] ?? null, 
            $data['state'] ?? null, 
            $data['phone_number'] ?? null
        );

        if (!$user->insert()) {
            $this->call(500, "internal_server_error", $user->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(201, "success", "Usuário cadastrado com sucesso", "created")->back($this->userResponse($user));
    }

    private function updateProfile(array $data, int $typeId, string $roleName): void
    {
        if (!$this->authToken($typeId)) {
            $this->call(401, "unauthorized", "Acesso restrito a {$roleName}s.", "error")->back();
            return;
        }

        if (!isset($data['name'], $data['email']) || empty($data['name']) || empty($data['email'])) {
            $this->call(400, "bad_request", "Nome e e-mail são obrigatórios para atualização.", "error")->back();
            return;
        }

        $user = new User();
        $user->setId($this->userAuthId); 
        $user->setName($data['name']);
        $user->setEmail($data['email']);

        if (!$user->updateById($this->userAuthId)) {
            $this->call(500, "internal_server_error", "Erro ao atualizar os dados do {$roleName}.", "error")->back();
            return;
        }

        $this->call(200, "success", "Dados do {$roleName} atualizados com sucesso", "success")->back();
    }

    private function deleteProfile(int $typeId, string $roleName): void
    {
        if (!$this->authToken($typeId)) {
            $this->call(401, "unauthorized", "Acesso restrito a {$roleName}s.", "error")->back();
            return;
        }

        $user = new User();
        if (!$user->softDeleteById((int)$this->userAuthId)) {
            $this->call(500, "internal_server_error", "Erro ao excluir conta de {$roleName}.", "error")->back();
            return;
        }

        $this->call(200, "success", "Conta de {$roleName} excluída com sucesso!", "success")->back();
    }

    private function validateLoginFields(array $data): bool
    {
        if (!isset($data['email'], $data['password']) || empty($data['email']) || empty($data['password']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->call(400, "bad_request", "E-mail e senha válidos são obrigatórios.", "error")->back();
            return false;
        }
        return true;
    }

    private function validateRequiredFields(array $data): bool
    {
        if (!isset($data['password']) || empty($data['password'])) {
            $this->call(400, "bad_request", "A senha é obrigatória.", "error")->back();
            return false;
        }

        if (!isset($data["name"], $data["email"]) || empty($data["name"]) || empty($data["email"]) || !filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            $this->call(400, "bad_request", "Nome e e-mail válidos são obrigatórios.", "error")->back();
            return false;
        }
        return true;
    }

    private function userResponse(User $user): array
    {
        return [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "email" => $user->getEmail(),
            "photo" => $user->getPhoto(),
            "city" => $user->getCity(),
            "state" => $user->getState(),
            "phoneNumber" => $user->getPhoneNumber(),
            "type_id" => $user->getTypeId()
        ];
    }
}