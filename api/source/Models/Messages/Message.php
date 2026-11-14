<?php

namespace source\Models\Messages; 

use Source\Core\Model; 
use Source\Core\Connect; 

class Message extends Model
{
    private ?int $id;
    private ?int $userPhotographerId;
    private ?int $userId;
    private ?string $message;
    private ?int $active;

public function __construct(
      ?int $id = null,
      ?int $userPhotographerId = null,
      ?int $userId = null,
      ?string $message = null,
      ?int $active = null
){
      $this->id = $id;
      $this->userPhotographerId = $userPhotographerId;
      $this->userId = $userId;
      $this->message = $message;
      $this->active = $active;

      $this->table = 'message';
      $this->primaryKey = 'id';
      $this->fillable = ['userPhotographerId', 'userId', 'message', 'active'];
}

    public function getId(): ?int
{
      return $this->id;
}

    public function setId(?int $id = null): void
{
      $this->id = $id;
}


    public function getUserPhotographerId(): ?int
{
      return $this->userPhotographerId;
}

    public function setUserPhotographerId(?int $userPhotographerId = null): void
{
      $this->userPhotographerId = $userPhotographerId;
}


    public function getUserId(): ?int
{
      return $this->userId;
}

    public function setUserId(?int $userId = null): void
{
      $this->userId = $userId;
}


   public function getMessage(): ?string
{
      return $this->message;
}

    public function setMessage(?string $message = null): void
{
      $this->message = $message;
}

    public function getActive(): ?int 
    {
        return $this->active;
    }

    public function setActive(?int $active = null): void 
    {
        $this->active = $active;
    }

}