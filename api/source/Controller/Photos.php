<?php

namespace Source\Controller;

use PDO;
use Source\Core\Connect;
use Source\Models\Photos\Photo;

class Photos extends Api
{
    /** Consulta pública das fotos ativas. */
    public function listAll(array $data): void
    {
        $photo = new Photo();
        $rows = $photo->selectAll(['active = 1'], 'id', 'DESC');
        $this->call(200, 'success', 'Lista de fotos', 'success')->back($rows ?: []);
    }

    /** Lista todas as imagens de um portfólio específico. */
    public function listByPortfolioId(array $data): void
    {
        $portfolioId = filter_var($data['portfolio_id'] ?? null, FILTER_VALIDATE_INT);
        if (!$portfolioId || $portfolioId < 1) {
            $this->call(400, 'bad_request', 'Informe um ID de portfólio válido.', 'error')->back(null);
            return;
        }
        $portfolio = Connect::getInstance()->prepare('SELECT id FROM portfolios WHERE id = :id AND active = 1');
        $portfolio->execute([':id' => $portfolioId]);
        if (!$portfolio->fetchColumn()) {
            $this->call(404, 'not_found', 'Portfólio não encontrado.', 'error')->back(null);
            return;
        }
        $photo = new Photo();
        $this->call(200, 'success', 'Fotos do portfólio', 'success')->back($photo->selectByPortfolioId((int)$portfolioId));
    }

    public function selectPhoto(array $data): void
    {
        $id = filter_var($data['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id || $id < 1) {
            $this->call(400, 'bad_request', 'Informe um ID de foto válido.', 'error')->back(null);
            return;
        }
        $photo = new Photo();
        if (!$photo->selectActiveById((int)$id)) {
            $this->call(404, 'not_found', 'Foto não encontrada.', 'error')->back(null);
            return;
        }
        $this->call(200, 'success', 'Foto encontrada.', 'success')->back([
            'id' => $photo->getId(), 'portfolio_id' => $photo->getPortfolioId(), 'link' => $photo->getLink()
        ]);
    }

    public function insertPhoto(array $data): void
    {
        $this->call(405, 'method_not_allowed', 'Envie imagens pelo upload multipart.', 'error')->back(null);
    }

    public function updatePhoto(array $data): void
    {
        $this->call(405, 'method_not_allowed', 'Envie imagens pelo upload multipart.', 'error')->back(null);
    }

    public function deletePhoto(array $data): void
    {
        if (!$this->authToken(2)) {
            $this->call(401, 'unauthorized', 'Apenas fotógrafos autenticados podem remover fotos.', 'error')->back(null);
            return;
        }
        $id = filter_var($data['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id || $id < 1) {
            $this->call(400, 'bad_request', 'Informe um ID de foto válido.', 'error')->back(null);
            return;
        }
        $pdo = Connect::getInstance();
        $stmt = $pdo->prepare('SELECT ph.link FROM photos ph INNER JOIN portfolios p ON p.id = ph.portfolio_id WHERE ph.id = :id AND ph.active = 1 AND p.user_id = :user_id LIMIT 1');
        $stmt->execute([':id' => $id, ':user_id' => $this->userAuthId]);
        $link = $stmt->fetchColumn();
        if (!$link) {
            $this->call(404, 'not_found', 'Foto não encontrada na sua conta.', 'error')->back(null);
            return;
        }
        $delete = $pdo->prepare('UPDATE photos SET active = 0 WHERE id = :id');
        if (!$delete->execute([':id' => $id])) {
            $this->call(500, 'internal_server_error', 'Não foi possível remover a foto.', 'error')->back(null);
            return;
        }
        \Source\Support\Upload::remove((string)$link, 'portfolio');
        $this->call(200, 'success', 'Foto removida com sucesso.', 'success')->back(null);
    }

    /** Upload multipart de uma imagem, vinculada exclusivamente ao portfólio informado. */
    public function upload(array $data): void
    {
        if (!$this->authToken(2)) {
            $this->call(401, 'unauthorized', 'Entre como fotógrafo.', 'error')->back(null); return;
        }
        $portfolioId = filter_var($_POST['portfolio_id'] ?? null, FILTER_VALIDATE_INT);
        if (!$portfolioId || $portfolioId < 1) {
            $this->call(400, 'bad_request', 'Informe portfolio_id válido.', 'error')->back(null); return;
        }
        if (!$this->ownsPortfolio((int)$portfolioId)) {
            $this->call(403, 'forbidden', 'Portfólio não encontrado na sua conta.', 'error')->back(null); return;
        }
        $relative = null;
        try {
            $relative = \Source\Support\Upload::image($_FILES['image'] ?? [], 'portfolio', 8 * 1024 * 1024);
            $photo = new Photo(null, (int)$portfolioId, $relative, 1);
            if (!$photo->insert()) throw new \RuntimeException('Erro de persistência da imagem: ' . $photo->getErrorMessage());
            $this->call(201, 'success', 'Imagem salva no portfólio.', 'success')->back([
                'id' => $photo->getId(), 'portfolio_id' => (int)$portfolioId, 'link' => $relative, 'active' => 1
            ]);
        } catch (\LengthException $e) {
            $this->call(413, 'file_too_large', $e->getMessage(), 'error')->back(null);
        } catch (\InvalidArgumentException $e) {
            $this->call(400, 'bad_request', $e->getMessage(), 'error')->back(null);
        } catch (\Throwable $e) {
            if ($relative) \Source\Support\Upload::remove($relative, 'portfolio');
            $this->call(500, 'internal_server_error', 'Falha ao gravar a imagem ou seus dados. Verifique permissões de api/uploads/portfolio e a tabela photos.', 'error')->back(null);
        }
    }

    /** Upload de capa, gravando o caminho no portfólio do fotógrafo autenticado. */
    public function uploadCover(array $data): void
    {
        if (!$this->authToken(2)) {
            $this->call(401, 'unauthorized', 'Entre como fotógrafo.', 'error')->back(null); return;
        }
        $id = filter_var($_POST['portfolio_id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id || !$this->ownsPortfolio((int)$id)) {
            $this->call(403, 'forbidden', 'Portfólio não encontrado na sua conta.', 'error')->back(null); return;
        }
        $relative = null;
        try {
            $relative = \Source\Support\Upload::image($_FILES['image'] ?? [], 'portfolio', 8 * 1024 * 1024);
            $pdo = Connect::getInstance();
            $stmt = $pdo->prepare('SELECT cover_link FROM portfolios WHERE id = :id AND user_id = :uid AND active = 1');
            $stmt->execute([':id'=>$id, ':uid'=>$this->userAuthId]);
            $old = $stmt->fetchColumn();
            $update = $pdo->prepare('UPDATE portfolios SET cover_link = :link WHERE id = :id AND user_id = :uid AND active = 1');
            if (!$update->execute([':link'=>$relative, ':id'=>$id, ':uid'=>$this->userAuthId])) throw new \RuntimeException('Falha no banco.');
            if (is_string($old) && $old !== $relative) \Source\Support\Upload::remove($old, 'portfolio');
            $this->call(200, 'success', 'Capa atualizada.', 'success')->back(['portfolio_id'=>(int)$id, 'cover_link'=>$relative]);
        } catch (\LengthException $e) {
            $this->call(413, 'file_too_large', $e->getMessage(), 'error')->back(null);
        } catch (\InvalidArgumentException $e) {
            $this->call(400, 'bad_request', $e->getMessage(), 'error')->back(null);
        } catch (\Throwable $e) {
            if ($relative) \Source\Support\Upload::remove($relative, 'portfolio');
            $this->call(500, 'internal_server_error', 'Falha ao salvar a capa. Verifique api/uploads/portfolio e portfolios.cover_link.', 'error')->back(null);
        }
    }

    private function ownsPortfolio(int $portfolioId): bool
    {
        $stmt = Connect::getInstance()->prepare('SELECT id FROM portfolios WHERE id = :id AND user_id = :user_id AND active = 1 LIMIT 1');
        $stmt->execute([':id' => $portfolioId, ':user_id' => $this->userAuthId]);
        return (bool)$stmt->fetchColumn();
    }

    private function removeLocalFile(string $link): void
    {
        if (!str_starts_with($link, 'uploads/portfolio/')) return;
        $base = realpath(dirname(__DIR__, 2) . '/uploads/portfolio');
        $file = realpath(dirname(__DIR__, 2) . '/' . $link);
        if ($base && $file && str_starts_with($file, $base . DIRECTORY_SEPARATOR) && is_file($file)) @unlink($file);
    }
}
