<?php

namespace Source\Models\Specialties;

use Source\Core\Model;

class Specialty extends Model
{
    public function __construct(
        ?int $id = null,
        ?string $type = null
    ) {
        $this->id = $id;
        $this->type = $type;

        $this->table = 'specialty';
        $this->primaryKey = 'id';

        $this->fillable = [
            'type'
        ];
    }

    private ?int $id;

    private ?string $type;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function setId(?int $id): void
    {
        $this->id = $id;
    }


    public function getType(): ?string
    {
        return $this->type;
    }


    public function setType(?string $type): void
    {
        $this->type = $type;
    }
}