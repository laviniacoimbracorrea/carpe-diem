<?php

namespace Source\Controller;

use Source\Models\User;
use Source\Core\JWTToken;

class Api
{
    protected ?int $userAuthId = null;

    protected function requestData(array $data = []): array
{
    $input = file_get_contents("php://input");

    if (!empty($input)) {
        $json = json_decode($input, true);

        if (is_array($json)) {
            $data = array_merge($data, $json);
        }
    }

    return $data;
}

    protected function authenticatedUser(): ?object
    {
        $header = getallheaders();
        $token = $header["token"] ?? $header['Authorization'] ?? $header['authorization'] ?? null;

        if (!$token) {
            return null;
        }

        if (str_starts_with($token, 'Bearer ')) {
            $token = substr($token, 7);
        }

        $jwt = new JWTToken();
        $decoded = $jwt->decode($token);

        if (!$decoded || !isset($decoded->data->id, $decoded->data->email, $decoded->data->type_id)) {
            return null;
        }

        $user = new User();
        if (!$user->selectById((int)$decoded->data->id)) {
            return null;
        }

        if ((int)$user->getTypeId() !== (int)$decoded->data->type_id || !$user->isActive()) {
            return null;
        }

        $this->userAuthId = (int)$decoded->data->id;
        return $decoded->data;
    }

    public function authToken (int $typeId): bool
    {

        $header = getallheaders();

        $token = $header["token"] ?? $header['Authorization'] ?? $header['authorization'] ?? null;

        if(!$token){
            return false;
        }

        if(str_starts_with($token, 'Bearer ')){
            $token = substr($token, 7);
        }

        $jwt = new JWTToken();

        $jwtToken = $jwt->decode($token);

        if(!$jwtToken){
            return false;
        }

        $user = new User();
        if(!$user->permissionVerify($jwtToken->data->email, $typeId)){
            return false;
        }

        $this->userAuthId = $jwtToken->data->id;

        return true;

    }

    public function authUserData(): ?object
    {
        return $this->authenticatedUser();
    }

    protected function call (int $code, ?string $status = null, ?string $message = null, ?string $type = null): Api
    {
        http_response_code($code);
        if(!empty($status)){
            $this->response = [
                "code" => $code,
                "type" => $type,
                "status" => $status,
                "message" => (!empty($message) ? $message : null)
            ];
        }
        return $this;
    }

    protected function back(object | array $data = null): Api
    {
        header('Content-Type: application/json');
        if ($data !== null) {
            $this->response["data"] = $data;
        }
        echo json_encode($this->response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return $this;
    }

}