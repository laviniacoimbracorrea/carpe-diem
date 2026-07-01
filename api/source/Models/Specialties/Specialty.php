<?php

namespace Source\Models\Specialties;

use Source\Core\Model;
use Source\Core\Connect;

class Specialty extends Model
{
    private ?int $id;
    private ?string $type;
    private ?int $active;

    public function __construct(?int $id = null, ?string $type = null, ?int $active = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->active = $active;

        $this->table = 'specialties';
        $this->primaryKey = 'id';
        $this->fillable = ['type'];
    }

    public function getId(): ?int 
    {
        return $this->id;
    }

    public function setId(?int $id = null): void 
    {
        $this->id = $id;
    }

    public function getType(): ?string 
    {
        return $this->type;
    }

    public function setType(?string $type = null)
    {
        $this->type = $type;
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