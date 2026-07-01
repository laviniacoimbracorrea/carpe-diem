<?php

namespace source\Models\Portfolios;

use Source\Core\Model;
use Source\Core\Connect;

class Portfolio extends Model
{

    // portifólio usa 
    // - biografia - perfil fotografo
    // - foto de capa - perfil fotografo
    // - galeria de fotos - perfil fotografo + banco especifico para as fotos


    private ?int $id;
    private ?int $userId;
    private ?string $title;
    private ?string $description;
    private ?string $coverLink;
    private ?int $active;

    public function __construct(?int $id = null, ?int $userId = null , ?string $title = null, ?string $description = null, ?string $coverLink = null, ?int $active = null)
    {
      
    $this->id = $id;
    $this->userId = $userId;
    $this->title = $title;
    $this->description = $description;
    $this->coverLink = $coverLink;
    $this->active = $active;

    $this->table = 'portfolios';
    $this->primaryKey = 'id';
    $this->fillable = ['userId', 'title', 'description','coverLink']; 
    
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getTitle(): ?string 
    {
        return $this->title;
    }

    public function setTitle(?string $title = null): void 
    {
        $this->title = $title;
    }

    public function getDescription(): ?string 
    {
        return $this->description;
    }

    public function setDescription(?string $description = null)
    {
        $this->description = $description;
    }

    public function getCoverLink(): ? string 
    {
        return $this->coverLink;
    }

    public function setCoverLink(?string $coverLink = null)
    {
        $this->coverLink = $coverLink;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): void
    {
        $this->active = $active;
    }

   // public function listById (int $id): object | false
   // {
   //     $query = "SELECT * FROM faqs WHERE id = :id";
   //     $stmt = Connect::getInstance()->prepare($query);
   //     $stmt->bindParam(":id", $id);
   //     $stmt->execute();
   //     return $stmt->fetch();
   // }
}