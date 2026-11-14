<?php

namespace Source\Models;

use PDO;
use Source\Core\Model;
use Source\Core\Connect;
use Source\Core\JWTToken;

class User extends Model
{
    private ?int $id;
    private ?int $typeId;
    private ?int $specialtyId;
    private ?string $name;
    private ?string $email;
    private ?string $password;
    private ?string $photo;
    private ?string $city;
    private ?string $state;
    private ?string $phoneNumber;
    private ?int $active = 1;
    private ?string $lastLoginAt = null;
    private ?string $createdAt = null;
    private ?int $approvalStatus = 1;
    private ?string $token = null;

    public function __construct(
        ?int $id = null,
        ?int $typeId = null,
        ?int $specialtyId = null,
        ?string $name = null,
        ?string $email = null,
        ?string $password = null,
        ?string $photo = null,
        ?string $city = null,
        ?string $state = null,
        ?string $phoneNumber = null
    ) {
        $this->id = $id;
        $this->typeId = $typeId;
        $this->specialtyId = $specialtyId;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->photo = $photo;
        $this->city = $city;
        $this->state = $state;
        $this->phoneNumber = $phoneNumber;

        $this->table = 'users';
        $this->primaryKey = 'id';

        $this->fillable = [
            'typeId',
            'specialtyId',
            'name',
            'email',
            'password',
            'photo',
            'city',
            'state',
            'phoneNumber',
            'approvalStatus'
        ];
    }

// GETTERS E SETTERS
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

    public function getSpecialtyId(): ?int
    {
        return $this->specialtyId;
    }

    public function setSpecialtyId(?int $specialtyId): void
    {
        $this->specialtyId = $specialtyId;
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

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(?int $active): void
    {
        $this->active = $active;
    }

    public function getLastLoginAt(): ?string
    {
        return $this->lastLoginAt;
    }

    public function setLastLoginAt(?string $lastLoginAt): void
    {
        $this->lastLoginAt = $lastLoginAt;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getApprovalStatus(): ?int
    {
        return $this->approvalStatus;
    }

    public function setApprovalStatus(?int $approvalStatus): void
    {
        $this->approvalStatus = $approvalStatus;
    }

    public function isApproved(): bool
    {
        return (int)($this->approvalStatus ?? 0) === 1;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

// CADASTRO
    public function insert(): bool
    {
        $query = " 
            SELECT id
            FROM {$this->table}
            WHERE email = :email
            LIMIT 1";

        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindValue(":email", $this->email);
        $stmt->execute();

        if ($stmt->fetch()) {
            $this->errorMessage = "Este e-mail já está cadastrado.";
            return false;
        }

        $this->password = password_hash(
            $this->password,
            PASSWORD_DEFAULT
        );

       return parent::insert();
    }


// LOGIN
    public function login(string $email, string $password, ?int $expectedTypeId = null): bool {
        $query = "
            SELECT * FROM {$this->table}
            WHERE email = :email
            LIMIT 1";

        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$user) {
            $this->errorMessage = "E-mail não cadastrado.";
            return false;
        }

        // A conta pode existir no banco e ainda assim não estar liberada.
        if ((int)($user->active ?? 1) !== 1) {
            $this->errorMessage = "Esta conta está desativada. Procure o administrador.";
            return false;
        }

        // Fotógrafos novos ficam aguardando a aprovação do administrador.
        if ((int)($user->type_id) === 2 && (int)($user->approval_status ?? 1) === 0) {
            $this->errorMessage = "Seu cadastro de fotógrafo foi recebido e está aguardando aprovação do administrador.";
            return false;
        }

        if ((int)($user->type_id) === 2 && (int)($user->approval_status ?? 1) === 2) {
            $this->errorMessage = "Seu cadastro de fotógrafo foi recusado pelo administrador.";
            return false;
        }

        // if ($stmt->rowCount() == 0) {
        //     $this->errorMessage = "Email não cadastrado";
        //     return false;
        // }
        // $user = $stmt->fetch(PDO::FETCH_OBJ);
        // if (!$user) {
        //     $this->errorMessage = "Usuário não encontrado";
        //     return false;
        // }
        // if (!password_verify($password, $user->password)) {
        //     $this->errorMessage = "Senha incorreta";
        //     return false;
        // }


// VERIFICA O TIPO DE USUÁRIO
  if($expectedTypeId !== null && (int)$user->type_id !== $expectedTypeId)
{
    if ($expectedTypeId === 1) 
    {
        $this->errorMessage = "Este e-mail não pertence a um administrador.";
    } 
    elseif ($expectedTypeId === 2) 
    {
        $this->errorMessage = "Esta conta não é de fotógrafo.";
    } 
    elseif ($expectedTypeId === 3) 
    {
        $this->errorMessage = "Esta conta não é de cliente.";
    } 
    else {
        $this->errorMessage = "Tipo de usuário inválido.";
    }

    return false;
}

// VERIFICA A SENHA
   if (!password_verify($password, $user->password)) {
        $this->errorMessage = "Senha incorreta.";
        return false;
    }

// CARREGA OS DADOS
    $this->id = (int)$user->id;
    $this->typeId = (int)$user->type_id;
    $this->specialtyId = $user->specialty_id !== null ? (int)$user->specialty_id: null;

    $this->name = $user->name;
    $this->email = $user->email;
    $this->password = null;
    $this->city = $user->city;
    $this->state = $user->state;
    $this->phoneNumber = $user->phone_number;
    $this->photo = null;
    $this->active = (int)($user->active ?? 1);
    $this->lastLoginAt = $user->last_login_at ?? null;
    $this->createdAt = $user->created_at ?? null;
    $this->approvalStatus = (int)($user->approval_status ?? 1);

// REGISTRA O ÚLTIMO LOGIN NO BANCO
   $this->markLogin();

// GERA TOKEN
   $jwt = new JWTToken();

   $this->token = $jwt->encode([
       "id" => $this->id,
       "name" => $this->name,
       "email" => $this->email,
       "type_id" => $this->typeId
   ]);
    return true;
}

    public function isActive(): bool
    {
        return (int)($this->active ?? 0) === 1;
    }

    public function refreshToken(): void
    {
        $jwt = new JWTToken();

        $this->token = $jwt->encode([
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "type_id" => $this->typeId
        ]);
    }

    public function markLogin(): bool
    {
        try {
            $query = "UPDATE {$this->table} SET last_login_at = NOW() WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (\PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }

    public function listForAdmin(): array
    {
        try {
            $query = "
                SELECT
                    u.id,
                    u.name,
                    u.email,
                    u.city,
                    u.state,
                    u.phone_number,
                    u.specialty_id,
                    u.type_id,
                    u.active,
                    u.approval_status,
                    u.last_login_at,
                    u.created_at,
                    ut.name AS type_name,
                    s.type AS specialty_name
                FROM users u
                INNER JOIN users_types ut ON ut.id = u.type_id
                LEFT JOIN specialty s ON s.id = u.specialty_id
                ORDER BY u.type_id ASC, u.name ASC
            ";

            $stmt = Connect::getInstance()->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return [];
        }
    }

    public function setActiveStatus(int $id, bool $active): bool
    {
        try {
            $query = "UPDATE {$this->table} SET active = :active WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindValue(':active', $active ? 1 : 0, PDO::PARAM_INT);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() < 1) {
                $this->errorMessage = "Usuário não encontrado ou sem alteração.";
                return false;
            }

            return true;
        } catch (\PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }

    public function setPhotographerApproval(int $id, int $status): bool
    {
        if (!in_array($status, [1, 2], true)) {
            $this->errorMessage = "Status de aprovação inválido.";
            return false;
        }

        try {
            $query = "
                UPDATE {$this->table}
                SET approval_status = :approval_status,
                    active = :active
                WHERE id = :id
                  AND type_id = 2
            ";

            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindValue(':approval_status', $status, PDO::PARAM_INT);
            $stmt->bindValue(':active', $status === 1 ? 1 : 0, PDO::PARAM_INT);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() < 1) {
                $this->errorMessage = "Fotógrafo não encontrado ou já recebeu esta decisão.";
                return false;
            }

            return true;
        } catch (\PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }

// VERIFICA PERMISSÃO
   public function permissionVerify(string $email, $typeId): bool 
   {
        $query = "
             SELECT id 
             FROM {$this->table}
             WHERE email = :email
             AND type_id = :typeId
             AND active = 1
             LIMIT 1
            ";

        $stmt = Connect::getInstance()->prepare($query);

        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":typeId", $typeId, PDO::PARAM_INT);

        $stmt->execute();

        return (bool)$stmt->fetch();
    }
}