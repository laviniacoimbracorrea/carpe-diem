<?php

namespace Source\Models\Photos;

use Source\Core\Model;
use Source\Core\Connect;
use PDO;
use PDOException;

class Photo extends Model
{
    private ?int $id;
    private ?int $portfolioId;
    private ?string $link;
    private ?int $active;

    public function __construct(
        ?int $id = null,
        ?int $portfolioId = null,
        ?string $link = null,
        ?int $active = null
    ) {
        $this->id = $id;
        $this->portfolioId = $portfolioId;
        $this->link = $link;
        $this->active = $active;

        $this->table = 'photos';
        $this->primaryKey = 'id';

        $this->fillable = [
            'portfolioId',
            'link',
            'active'
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

    /**
     * Busca todas as fotos de um portfólio.
     */
    public function selectByPortfolioId(int $portfolioId): array|bool
    {
        try {
            $query = "
                SELECT *
                FROM photos
                WHERE portfolio_id = :portfolioId
            ";

            $stmt = Connect::getInstance()->prepare($query);

            $stmt->bindValue(
                ':portfolioId',
                $portfolioId,
                PDO::PARAM_INT
            );

            $stmt->execute();

            $photos = $stmt->fetchAll();

            if (empty($photos)) {
                $this->errorMessage = "Nenhuma foto encontrada para este portfólio.";
                return false;
            }

            return $photos;

        } catch (PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }

    /**
     * Atualiza o link das fotos de um portfólio.
     */
    public function updateByPortfolioId(int $portfolioId): bool
    {
        try {
            $query = "
                UPDATE photos
                SET link = :link
                WHERE portfolio_id = :portfolioId
            ";

            $stmt = Connect::getInstance()->prepare($query);

            $stmt->bindValue(
                ':link',
                $this->link
            );

            $stmt->bindValue(
                ':portfolioId',
                $portfolioId,
                PDO::PARAM_INT
            );

            $stmt->execute();

            if ($stmt->rowCount() < 1) {
                $this->errorMessage =
                    "Nenhuma foto encontrada para este portfólio ou nenhum dado foi alterado.";

                return false;
            }

            return true;

        } catch (PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }
}