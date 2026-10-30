<?php

namespace Source\Core;

use DateTimeImmutable;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
    private string $secretKey = JWT_SECRET_KEY;
    private string $headerJWT = 'HS512';
    private string $url = CONF_URL_BASE;

    public function encode(array $payLoad): string
    {
        $issuedAt = new DateTimeImmutable();
        $tokenId = bin2hex(random_bytes(16));
        $expire = $issuedAt->modify('+90 minutes')->getTimestamp();

        $data = [
            'iat' => $issuedAt->getTimestamp(),
            'jti' => $tokenId,
            'iss' => $this->url,
            'nbf' => $issuedAt->getTimestamp(),
            'exp' => $expire,
            'data' => $payLoad
        ];

        return JWT::encode(
            $data,
            $this->secretKey,
            $this->headerJWT
        );
    }

    public function decode(string $token): bool|object
    {
        try {
            $decoded = JWT::decode(
                $token,
                new Key($this->secretKey, $this->headerJWT)
            );

            $now = time();

            if (
                !isset(
                    $decoded->iss,
                    $decoded->iat,
                    $decoded->nbf,
                    $decoded->exp,
                    $decoded->data
                )
            ) {
                return false;
            }

            if (
                $decoded->iss !== $this->url ||
                !is_numeric($decoded->iat) ||
                !is_numeric($decoded->nbf) ||
                !is_numeric($decoded->exp) ||
                $decoded->iat > $now ||
                $decoded->nbf > $now ||
                $decoded->exp <= $now
            ) {
                return false;
            }

            return $decoded;
        } catch (Exception $e) {
            return false;
        }
    }
}
