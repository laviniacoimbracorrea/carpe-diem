<?php

namespace Source\Controller;

use Source\Models\User;
use Source\Core\JWTToken;

class Api
{
   protected ?int $userAuthId = null;

    protected array $response = [];

    public function authToken(int $typeId): bool
    {
        $headers = function_exists('getallheaders')
            ? getallheaders()
            : [];

        $token = null;

        // Procura o token nos cabeçalhos recebidos.
        foreach ($headers as $name => $value) {
            if (
                strtolower($name) === 'authorization' ||
                strtolower($name) === 'token'
            ) {
                $token = $value;
                break;
            }
        }

        // Alternativa para servidores que não disponibilizam getallheaders().
        $token = $token
            ?? $_SERVER['HTTP_AUTHORIZATION']
            ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION']
            ?? null;

        if (!is_string($token) || trim($token) === '') {
            return false;
        }

        // Remove o prefixo Bearer, caso ele tenha sido enviado.
        if (stripos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        }

        $jwt = new JWTToken();
        $decoded = $jwt->decode(trim($token));

        if (
            !$decoded ||
            !isset($decoded->data->id, $decoded->data->email)
        ) {
            return false;
        }

        $userId = filter_var(
            $decoded->data->id,
            FILTER_VALIDATE_INT
        );

        if (!$userId || $userId < 1) {
            return false;
        }

        $user = new User();

        // Confere se o usuário ainda existe, está ativo
        // e possui o tipo de conta autorizado.
        if (!$user->permissionVerify(
            (string) $decoded->data->email,
            $typeId,
            $userId
        )) {
            return false;
        }

        $this->userAuthId = $userId;

        return true;
    }

    protected function call(
        int $code,
        ?string $status = null,
        ?string $message = null,
        ?string $type = null
    ): Api {
        http_response_code($code);

        $this->response = [
            'code' => $code,
            'type' => $type,
            'status' => $status,
            'message' => $message
        ];

        return $this;
    }

    protected function back(
        object|array|null $data = null
    ): Api {
        header('Content-Type: application/json; charset=UTF-8');

        if ($data !== null) {
            $this->response['data'] = $data;
        }

        echo json_encode(
            $this->response,
            JSON_PRETTY_PRINT
            | JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
        );

        return $this;
    }
}
