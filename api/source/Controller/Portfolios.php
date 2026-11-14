<?php

namespace Source\Controller;

use PDO;
use Source\Core\Connect;
use Source\Models\Portfolios\Portfolio;

class Portfolios extends Api
{
    /** Lista os portfólios públicos junto dos dados do fotógrafo. */
    public function listAll(array $data): void
    {
        try {
            $sql = "SELECT p.id, p.user_id, p.title, p.description, p.cover_link, p.active,
                           u.name AS photographer_name, u.email AS photographer_email,
                           u.city, u.state, u.photo AS photographer_photo, u.specialty_id, s.type AS specialty_name
                    FROM portfolios p
                    INNER JOIN users u ON u.id = p.user_id
                    LEFT JOIN specialty s ON s.id = u.specialty_id
                    WHERE p.active = 1 AND u.active = 1 AND u.type_id = 2
                      AND (u.approval_status = 1 OR u.approval_status IS NULL)
                    ORDER BY p.id DESC";
            $rows = Connect::getInstance()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            $this->call(200, 'success', 'Lista de portfólios', 'success')->back($rows ?: []);
        } catch (\Throwable $e) {
            $this->call(500, 'internal_server_error', 'Não foi possível listar os portfólios.', 'error')->back(null);
        }
    }

    /** Lista somente os portfólios do fotógrafo autenticado. */
    public function listMine(array $data): void
    {
        if (!$this->authToken(2)) {
            $this->call(401, 'unauthorized', 'Faça login como fotógrafo para acessar seus portfólios.', 'error')->back(null);
            return;
        }
        $stmt = Connect::getInstance()->prepare('SELECT * FROM portfolios WHERE user_id = :user_id AND active = 1 ORDER BY id DESC');
        $stmt->execute([':user_id' => $this->userAuthId]);
        $this->call(200, 'success', 'Seus portfólios', 'success')->back($stmt->fetchAll(PDO::FETCH_ASSOC) ?: []);
    }

    public function insertPortfolio(array $data): void
    {
        if (!$this->authToken(2)) {
            $this->call(401, 'unauthorized', 'Apenas fotógrafos autenticados podem criar portfólios.', 'error')->back(null);
            return;
        }
        $data = $this->requestData($data);
        $title = trim((string)($data['title'] ?? ''));
        $description = trim((string)($data['description'] ?? ''));
        $coverLink = null; // Capas só podem ser criadas por POST /photos/cover (upload real).
        if ($title === '') {
            $this->call(400, 'bad_request', 'Informe o título do portfólio.', 'error')->back(null);
            return;
        }
        $portfolio = new Portfolio(null, $this->userAuthId, $title, $description, $coverLink, 1);
        if (!$portfolio->insert()) {
            $this->call(500, 'internal_server_error', 'Erro ao criar portfólio: ' . $portfolio->getErrorMessage(), 'error')->back(null);
            return;
        }
        $this->call(201, 'success', 'Portfólio criado com sucesso.', 'success')->back([
            'id' => $portfolio->getId(), 'user_id' => $this->userAuthId,
            'title' => $title, 'description' => $description, 'cover_link' => $coverLink, 'active' => 1
        ]);
    }

    public function updatePortfolio(array $data): void
    {
        if (!$this->authToken(2)) {
            $this->call(401, 'unauthorized', 'Apenas fotógrafos autenticados podem editar portfólios.', 'error')->back(null);
            return;
        }
        $data = $this->requestData($data);
        $id = filter_var($data['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id || $id < 1) {
            $this->call(400, 'bad_request', 'Informe um ID de portfólio válido.', 'error')->back(null);
            return;
        }
        $pdo = Connect::getInstance();
        $owner = $pdo->prepare('SELECT id FROM portfolios WHERE id = :id AND user_id = :user_id AND active = 1 LIMIT 1');
        $owner->execute([':id' => $id, ':user_id' => $this->userAuthId]);
        if (!$owner->fetchColumn()) {
            $this->call(404, 'not_found', 'Portfólio não encontrado na sua conta.', 'error')->back(null);
            return;
        }
        $portfolio = new Portfolio();
        if (!$portfolio->selectById((int)$id)) {
            $this->call(404, 'not_found', 'Portfólio não encontrado.', 'error')->back(null);
            return;
        }
        if (array_key_exists('title', $data)) $portfolio->setTitle(trim((string)$data['title']));
        if (array_key_exists('description', $data)) $portfolio->setDescription(trim((string)$data['description']));
        // Não permitir editar a capa via JSON: utilizar POST /photos/cover com arquivo multipart.
        if (!$portfolio->updateById((int)$id)) {
            // updateById retorna rowCount 0 quando os valores enviados são iguais aos já salvos.
            $check = $pdo->prepare('SELECT id FROM portfolios WHERE id = :id AND user_id = :user_id AND active = 1');
            $check->execute([':id' => $id, ':user_id' => $this->userAuthId]);
            if (!$check->fetchColumn()) {
                $this->call(500, 'internal_server_error', 'Não foi possível atualizar o portfólio: ' . $portfolio->getErrorMessage(), 'error')->back(null);
                return;
            }
        }
        $this->call(200, 'success', 'Portfólio atualizado com sucesso.', 'success')->back([
            'id' => (int)$id, 'user_id' => $this->userAuthId,
            'title' => $portfolio->getTitle(), 'description' => $portfolio->getDescription(),
            'cover_link' => $portfolio->getCoverLink()
        ]);
    }

    public function selectPortfolio(array $data): void
    {
        $id = filter_var($data['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id || $id < 1) {
            $this->call(400, 'bad_request', 'Informe um ID de portfólio válido.', 'error')->back(null);
            return;
        }
        $stmt = Connect::getInstance()->prepare("SELECT p.*, u.name AS photographer_name, u.city, u.state, u.photo AS photographer_photo, s.type AS specialty_name
            FROM portfolios p INNER JOIN users u ON u.id = p.user_id
            LEFT JOIN specialty s ON s.id = u.specialty_id
            WHERE p.id = :id AND p.active = 1 AND u.active = 1 AND u.type_id = 2
              AND (u.approval_status = 1 OR u.approval_status IS NULL) LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            $this->call(404, 'not_found', 'Portfólio não encontrado.', 'error')->back(null);
            return;
        }
        $this->call(200, 'success', 'Portfólio encontrado.', 'success')->back($row);
    }

    /** Exclusão lógica: preserva o histórico e desativa as fotos relacionadas. */
    public function deletetPortfolio(array $data): void
    {
        if (!$this->authToken(2)) {
            $this->call(401, 'unauthorized', 'Apenas fotógrafos autenticados podem excluir portfólios.', 'error')->back(null);
            return;
        }
        $id = filter_var($data['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id || $id < 1) {
            $this->call(400, 'bad_request', 'Informe um ID de portfólio válido.', 'error')->back(null);
            return;
        }
        $pdo = Connect::getInstance();
        $owner = $pdo->prepare('SELECT id FROM portfolios WHERE id = :id AND user_id = :user_id AND active = 1');
        $owner->execute([':id' => $id, ':user_id' => $this->userAuthId]);
        if (!$owner->fetchColumn()) {
            $this->call(404, 'not_found', 'Portfólio não encontrado na sua conta.', 'error')->back(null);
            return;
        }
        try {
            $filesQuery = $pdo->prepare('SELECT link FROM photos WHERE portfolio_id = :id AND active = 1');
            $filesQuery->execute([':id' => $id]);
            $filesToRemove = $filesQuery->fetchAll(PDO::FETCH_COLUMN);
            $coverQuery = $pdo->prepare('SELECT cover_link FROM portfolios WHERE id = :id');
            $coverQuery->execute([':id' => $id]);
            $coverToRemove = $coverQuery->fetchColumn();
            $pdo->beginTransaction();
            $photos = $pdo->prepare('UPDATE photos SET active = 0 WHERE portfolio_id = :id');
            $photos->execute([':id' => $id]);
            $portfolio = $pdo->prepare('UPDATE portfolios SET active = 0 WHERE id = :id AND user_id = :user_id');
            $portfolio->execute([':id' => $id, ':user_id' => $this->userAuthId]);
            $pdo->commit();
            foreach ($filesToRemove as $path) \Source\Support\Upload::remove((string)$path, 'portfolio');
            if (is_string($coverToRemove)) \Source\Support\Upload::remove($coverToRemove, 'portfolio');
            $this->call(200, 'success', 'Portfólio excluído com sucesso.', 'success')->back(null);
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            $this->call(500, 'internal_server_error', 'Não foi possível excluir o portfólio.', 'error')->back(null);
        }
    }
}
