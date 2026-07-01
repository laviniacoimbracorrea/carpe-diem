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
    private ?int $specialityId;
    private ?string $name;
    private ?string $email;
    private ?string $password;
    private ?string $photo;
    private ?string $city;
    private ?string $state;
    private ?string $phoneNumber;
    private ?string $active;

    private ?string $token = null;

    public function __construct(?int $id = null, ?int $typeId = null, ?int $specialityId = null, ?string $name = null, 
    ?string $email = null, ?string $password = null, ?string $photo = null, ?string $city = null, ?string $state = null, ?string $phoneNumber = null)
    {
        $this->id = $id;
        $this->typeId = $typeId;
        $this->specialityId = $specialityId;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->photo = $photo ?? "";
        $this->city = $city; 
        $this->state = $state; 
        $this->phoneNumber = $phoneNumber;

        $this->table = 'users'; // nome da tabela do banco
        $this->primaryKey = 'id'; // nome da chave primária da tabela
        $this->fillable = ['typeId', 'speciality', 'name', 'email', 'password', 'photo', 'city', 'state', 'phoneNumber']; // camelCase
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
        return $this->speciality;
    }

    public function setSpecialityId(?int $specialityI): void 
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

    // ESTADO E NUMERO

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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function insert (): bool
    {
        $query = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $this->errorMessage = "Email já cadastrado";
            return false;
        }
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        if(!parent::insert()){
            $this->errorMessage = "Algo deu errado";
            return false;
        }
        return true;
    }

    public function login (string $email, string $password, int $typeId = 2): bool
    {
        $query = "SELECT * FROM {$this->table} WHERE email = :email AND type_id = :typeId";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":typeId", $typeId);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            $this->errorMessage = "Email não cadastrado";
            return false;
        }
        $user = $stmt->fetch();
        if(!password_verify($password, $user->password)){
            $this->errorMessage = "Senha incorreta";
            return false;
        }
        $this->id = $user->id;
        $this->typeId = $user->type_id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->photo = $user->photo;
        $jwt = new JWTToken();
        // definir quais informações irão par o payload do token
        $this->token = $jwt->encode([
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email
        ]);
        return true;
    }

    public function permissionVerify (string $email, $typeId): bool
    {
        $query = "SELECT * FROM {$this->table} WHERE email = :email AND type_id = :typeId";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":typeId", $typeId);
        $stmt->execute();
        if($stmt->rowCount() == 0) {
            return false;
        }
        return true;
    }

}