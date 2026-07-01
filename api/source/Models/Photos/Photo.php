<?php

namespace Source\Models\Photos;

use Source\Core\Model;
use Source\Core\Connect;

class Photo extends Model 
{
    private ?int $id;
    private ?int $portfolioId;
    private ?string $link;
    private ?int $active;

    public function __construct(?int $id = null, ?int $portfolioId = null, ?string $link = null, ?int $active = null)
    {
        $this->id = $id;
        $this->portfolioId = $portfolioId;
        $this->link = $link;
        $this->active = $active;

        $this->table = 'photos';
        $this->primaryKey = 'id';
        $this->fillable = ['portfolioId', 'link', 'active'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id = null): void 
    {
        $this->id = $id; 
    }

    public function getPortfolioId(): ?int 
    {
        return $this->portfolioId;
    }

    public function setPortfolioId(?int $portfolioId = null): void
    {
        $this->portfolioId = $portfolioId;
    }

    public function getLink(): ?string 
    {
        return $this->link;
    }

    public function setLink(?string $link = null): void 
    {
        $this->link = $link;
    }

    public function getActive(): ?int 
    {
        return $this->active;
    }

    public function setActive(?int $active = null): void 
    {
        $this->active = $active;
    }

    // métodos padrões para inserir fotos e selecionar as de determinado portifolio
/*
    public function insert(): bool
    {

    $query = "INSERT INTO photos VALUES (null, :portfolioId, :link )";
    
    $stmt = Connect::getInstance()->prepare($query);
    $stmt->bindParam(":portfolioId", $this->portfolioId);
    $stmt->bindParam(":link", $this->link);

    // em caso de erro 

    if(!$stmt->execute())
        {
            return false;
        }

    // em caso de sucesso

    $this->id = Connect::getInstance()->lastInsertId();
    return true;
    }
    */

    public function selectByPortfolioId(): array | bool 
    {
        $query = "SELECT * FROM photos WHERE portfolio_id = :portfolioId";
        $stmt = Connect :: getInstance()->prepare($query);
        $stmt->bindParam(":portfolioId", $portfolioId);
        $stmt->execute();

        if($stmt->rowCount() > 0 ) // quantidade de linhas, verifica se tem mais de 0 
            {
                return $stmt->fetchAll(); // devolve todas as fotos que apaecerem 
            }
        return false;
    }

    public function updateByPortfolioId(int $portfolioId): bool
    {
    
    $query = "UPDATE photos SET link = :link WHERE portfolio_id = :portfolioId";
    $stmt = Connect::getInstance()->prepare($query);
    $stmt->bindParam(":link", $this->link);
    $stmt->bindParam(":portfolioId", $portfolioId);
    return $stmt->execute();
    }

}