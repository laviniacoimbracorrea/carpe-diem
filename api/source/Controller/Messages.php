<?php

namespace Source\Controller;

use Source\Core\Connect;
use Source\Models\Messages\Message;

class Messages extends Api
{
    public function listAll(array $data = []): void
    {
        $user = $this->authenticatedUser();
        if (!$user || !in_array((int)$user->type_id, [2, 3], true)) {
            $this->call(401, "unauthorized", "Entre na sua conta para consultar as mensagens.", "error")->back();
            return;
        }
        try {
            $pdo = Connect::getInstance();
            if ((int)$user->type_id === 2) {
                $sql = "SELECT m.id, m.user_photographer_id, m.user_id, m.message, m.created_at, u.name AS sender_name FROM message m INNER JOIN users u ON u.id = m.user_id WHERE m.user_photographer_id = :uid AND m.active = 1 ORDER BY m.created_at DESC, m.id DESC";
            } else {
                $sql = "SELECT m.id, m.user_photographer_id, m.user_id, m.message, m.created_at, p.name AS sender_name FROM message m INNER JOIN users p ON p.id = m.user_photographer_id WHERE m.user_id = :uid AND m.active = 1 ORDER BY m.created_at DESC, m.id DESC";
            }
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':uid' => (int)$user->id]);
            $this->call(200, "success", "Histórico de mensagens.", "success")->back($stmt->fetchAll(\PDO::FETCH_ASSOC));
        } catch (\Throwable $e) {
            $this->call(500, "internal_server_error", "Não foi possível carregar o histórico de mensagens.", "error")->back([]);
        }
    }

    public function listById(array $data): void
    {
        $user = $this->authenticatedUser();
        $id = (int)($data['message_id'] ?? 0);
        if (!$user || $id <= 0) {
            $this->call(400, "bad_request", "Mensagem inválida ou sessão ausente.", "error")->back();
            return;
        }
        $stmt = Connect::getInstance()->prepare("SELECT * FROM message WHERE id = :id AND (user_id = :uid OR user_photographer_id = :uid) LIMIT 1");
        $stmt->execute([':id'=>$id, ':uid'=>(int)$user->id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) { $this->call(404, "not_found", "Mensagem não encontrada.", "error")->back(); return; }
        $this->call(200, "success", "Mensagem encontrada.", "success")->back($row);
    }

    public function insert(array $data): void
    {
        $user = $this->authenticatedUser();
        if (!$user || (int)$user->type_id !== 3) {
            $this->call(401, "unauthorized", "Somente clientes autenticados podem enviar mensagens.", "error")->back();
            return;
        }
        $data = $this->requestData($data);
        $photographerId = (int)($data['user_photographer_id'] ?? 0);
        $text = trim((string)($data['message'] ?? ''));
        if ($photographerId <= 0 || $text === '') {
            $this->call(400, "bad_request", "Selecione um fotógrafo e escreva uma mensagem.", "error")->back();
            return;
        }
        $check = Connect::getInstance()->prepare("SELECT id FROM users WHERE id = :id AND type_id = 2 AND active = 1 AND COALESCE(approval_status, 1) = 1 LIMIT 1");
        $check->execute([':id'=>$photographerId]);
        if (!$check->fetchColumn()) { $this->call(404, "not_found", "Fotógrafo não encontrado ou ainda não aprovado.", "error")->back(); return; }
        $message = new Message(null, $photographerId, (int)$user->id, $text, 1);
        if (!$message->insert()) { $this->call(500, "internal_server_error", "Erro ao salvar a mensagem: " . $message->getErrorMessage(), "error")->back(); return; }
        $this->call(201, "success", "Mensagem enviada e salva no histórico.", "success")->back(['id'=>$message->getId(), 'user_photographer_id'=>$photographerId, 'user_id'=>(int)$user->id, 'message'=>$text]);
    }

    public function deleteById(array $data): void
    {
        $user = $this->authenticatedUser();
        $id = (int)($data['message_id'] ?? 0);
        if (!$user || $id <= 0) { $this->call(401, "unauthorized", "Sessão inválida.", "error")->back(); return; }
        $stmt = Connect::getInstance()->prepare("UPDATE message SET active = 0 WHERE id = :id AND (user_id = :uid OR user_photographer_id = :uid)");
        $stmt->execute([':id'=>$id, ':uid'=>(int)$user->id]);
        if (!$stmt->rowCount()) { $this->call(404, "not_found", "Mensagem não encontrada.", "error")->back(); return; }
        $this->call(200, "success", "Mensagem removida do histórico.", "success")->back();
    }

    public function updateById(array $data): void
    {
        $this->call(405, "method_not_allowed", "As mensagens enviadas não podem ser editadas.", "error")->back();
    }
}
