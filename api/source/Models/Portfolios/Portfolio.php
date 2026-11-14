<?php

namespace Source\Models\Portfolios;

use Source\Core\Model;

/** Um portfólio pertence a um fotógrafo e agrupa seus trabalhos. */
class Portfolio extends Model
{
    private ?int $id;
    private ?int $userId;
    private ?string $title;
    private ?string $description;
    private ?string $coverLink;
    private ?int $active;

    public function __construct(
        ?int $id = null,
        ?int $userId = null,
        ?string $title = null,
        ?string $description = null,
        ?string $coverLink = null,
        ?int $active = 1
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $this->coverLink = $coverLink;
        $this->active = $active;
        $this->table = 'portfolios';
        $this->primaryKey = 'id';
        $this->fillable = ['userId', 'title', 'description', 'coverLink', 'active'];
    }

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }
    public function getUserId(): ?int { return $this->userId; }
    public function setUserId(?int $userId): void { $this->userId = $userId; }
    public function getTitle(): ?string { return $this->title; }
    public function setTitle(?string $title): void { $this->title = $title; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): void { $this->description = $description; }
    public function getCoverLink(): ?string { return $this->coverLink; }
    public function setCoverLink(?string $coverLink): void { $this->coverLink = $coverLink; }
    public function getActive(): ?int { return $this->active; }
    public function setActive(?int $active): void { $this->active = $active; }
}
