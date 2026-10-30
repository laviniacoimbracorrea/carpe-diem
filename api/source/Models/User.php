<?php

namespace Source\Models;


use PDO;
use PDOException;
use Source\Core\Model;
use Source\Core\Connect;
use Source\Core\JWTToken;

class User extends Model
{
    private ?int $id;
    private ?int $typeId;
    private ?int $specialityId;
    private ?string $name;
    private ?string $email;
    private ?string $password;
    private ?string $photo;
    private ?string $city;
    private ?string $state;
    private ?string $phoneNumber;
    private ?string $status;

    private ?string $token = null;

    public function __construct(
        ?int $id = null,
        ?int $typeId = null,
        ?int $specialityId = null,
        ?string $name = null,
        ?string $email = null,
        ?string $password = null,
        ?string $photo = null,
        ?string $city = null,
        ?string $state = null,
        ?string $phoneNumber = null,
        ?string $status = 'aprovado'
    ) {
        $this->id = $id;
        $this->typeId = $typeId;
        $this->specialityId = $specialityId;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->photo = $photo;
        $this->city = $city;
        $this->state = $state;
        $this->phoneNumber = $phoneNumber;
        $this->status = $status;

        $this->table = 'users';
        $this->primaryKey = 'id';

        $this->fillable = [
            'typeId',
            'specialityId',
            'name',
            'email',
            'password',
            'photo',
            'city',
            'state',
            'phoneNumber',
            'status'
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTypeId(): ?int
    {
        return $this->typeId;
    }

    public function setTypeId(?int $typeId): void
    {
        $this->typeId = $typeId;
    }

    public function getSpecialityId(): ?int
    {
        return $this->specialityId;
    }

    public function setSpecialityId(?int $specialityId): void
    {
        $this->specialityId = $specialityId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function insert(): bool
    {
        if (
            $this->email === null ||
            !filter_var($this->email, FILTER_VALIDATE_EMAIL)
        ) {
            $this->errorMessage = 'E-mail inválido.';
            return false;
        }

        if ($this->password === null || $this->password === '') {
            $this->errorMessage = 'A senha é obrigatória.';
            return false;
        }

        try {
            $query = "
                SELECT id
                FROM {$this->table}
                WHERE email = :email
                LIMIT 1
            ";

            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindValue(':email', $this->email);
            $stmt->execute();

            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->errorMessage = 'E-mail já cadastrado.';
                return false;
            }
        } catch (PDOException $e) {
            $this->errorMessage = 'Não foi possível verificar o e-mail.';
            return false;
        }

        $this->password = password_hash(
            $this->password,
            PASSWORD_DEFAULT
        );

        if (!parent::insert()) {
            $this->errorMessage ??=
                'Não foi possível cadastrar o usuário.';

            return false;
        }

        return true;
    }

    public function login(
        string $email,
        string $password,
        int $typeId
    ): bool {
        $query = "
            SELECT *
            FROM {$this->table}
            WHERE email = :email
              AND type_id = :typeId
            LIMIT 1
        ";

        try {
            $stmt = Connect::getInstance()->prepare($query);

            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':typeId', $typeId, PDO::PARAM_INT);

            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$user) {
                $this->errorMessage =
                    'Usuário não encontrado ou tipo de conta incorreto.';

                return false;
            }

            if (
                !isset($user->password) ||
                !password_verify($password, $user->password)
            ) {
                $this->errorMessage = 'E-mail ou senha incorretos.';
                return false;
            }

            if ((int) $user->active !== 1) {
                $this->errorMessage = 'Esta conta está desativada.';
                return false;
            }

            if ($user->status !== 'aprovado') {
                if ($user->status === 'pendente') {
                    $this->errorMessage =
                        'Seu cadastro está aguardando aprovação.';
                } else {
                    $this->errorMessage =
                        'Seu cadastro não foi aprovado.';
                }

                return false;
            }

            $this->id = (int) $user->id;
            $this->typeId = (int) $user->type_id;

            $this->specialityId = isset($user->speciality_id)
                ? (int) $user->speciality_id
                : null;

            $this->name = $user->name;
            $this->email = $user->email;
            $this->photo = $user->photo ?? null;
            $this->city = $user->city ?? null;
            $this->state = $user->state ?? null;
            $this->phoneNumber = $user->phone_number ?? null;
            $this->status = $user->status;

            $jwt = new JWTToken();

            $this->token = $jwt->encode([
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'type_id' => $this->typeId
            ]);

            return true;
        } catch (PDOException $e) {
            $this->errorMessage = 'Não foi possível realizar o login.';
            return false;
        }
    }

    public function permissionVerify(
        string $email,
        int $typeId,
        ?int $userId = null
    ): bool {
        $query = "
            SELECT id
            FROM {$this->table}
            WHERE email = :email
              AND type_id = :typeId
              AND active = 1
              AND status = 'aprovado'
        ";

        if ($userId !== null) {
            $query .= ' AND id = :id';
        }

        $query .= ' LIMIT 1';

        try {
            $stmt = Connect::getInstance()->prepare($query);

            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':typeId', $typeId, PDO::PARAM_INT);

            if ($userId !== null) {
                $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
            }

            $stmt->execute();

            return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->errorMessage =
                'Não foi possível verificar a permissão.';

            return false;
        }
    }
}
