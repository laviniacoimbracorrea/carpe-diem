<?php

namespace Source\Models\Contacts;

use Source\Core\Model;

class Contact extends Model
{
    private ?int $id;
    private ?int $userId;
    private ?string $text;


    public function __construct(
        ?int $id = null,
        ?int $userId = null,
        ?string $text = null
    ) {

        $this->id = $id;
        $this->userId = $userId;
        $this->text = $text;


        $this->table = 'contacts';
        $this->primaryKey = 'id';

        $this->fillable = [
            'userId',
            'text'
        ];
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function setId(?int $id = null): void
    {
        $this->id = $id;
    }


    public function getUserId(): ?int
    {
        return $this->userId;
    }


    public function setUserId(?int $userId = null): void
    {
        $this->userId = $userId;
    }


    public function getText(): ?string
    {
        return $this->text;
    }


    public function setText(?string $text = null): void
    {
        $this->text = $text;
    }
}