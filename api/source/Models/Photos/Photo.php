<?php

namespace Source\Models\Photos;

use PDO;
use PDOException;
use Source\Core\Connect;
use Source\Core\Model;

/** Foto individual vinculada a um portfólio. */
class Photo extends Model
{
    private ?int $id;
    private ?int $portfolioId;
    private ?string $link;
    private ?int $active;

    public function __construct(?int $id = null, ?int $portfolioId = null, ?string $link = null, ?int $active = 1)
    {
        $this->id = $id;
        $this->portfolioId = $portfolioId;
        $this->link = $link;
        $this->active = $active;
        $this->table = 'photos';
        $this->primaryKey = 'id';
        $this->fillable = ['portfolioId', 'link', 'active'];
    }

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }
    public function getPortfolioId(): ?int { return $this->portfolioId; }
    public function setPortfolioId(?int $portfolioId): void { $this->portfolioId = $portfolioId; }
    public function getLink(): ?string { return $this->link; }
    public function setLink(?string $link): void { $this->link = $link; }
    public function getActive(): ?int { return $this->active; }
    public function setActive(?int $active): void { $this->active = $active; }

    /** Sempre retorna array, inclusive quando ainda não existem fotos. */
    public function selectByPortfolioId(int $portfolioId, bool $activeOnly = true): array
    {
        try {
            $sql = 'SELECT * FROM photos WHERE portfolio_id = :portfolio_id';
            if ($activeOnly) $sql .= ' AND active = 1';
            $sql .= ' ORDER BY id DESC';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->bindValue(':portfolio_id', $portfolioId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return [];
        }
    }

    public function selectActiveById(int $id): bool
    {
        try {
            $stmt = Connect::getInstance()->prepare('SELECT * FROM photos WHERE id = :id AND active = 1 LIMIT 1');
            $stmt->execute([':id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) return false;
            $this->setId((int)$row['id']);
            $this->setPortfolioId((int)$row['portfolio_id']);
            $this->setLink($row['link']);
            $this->setActive((int)$row['active']);
            return true;
        } catch (PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }
}
