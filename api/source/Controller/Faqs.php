<?php

namespace Source\Controller;

use Source\Models\Faqs\Faq;

class Faqs extends Api
{
    // Lista pública: somente perguntas publicadas.
    public function listAll(array $data = []): void
    {
        try {
            $pdo = \Source\Core\Connect::getInstance();
            $columns = array_column($pdo->query("SHOW COLUMNS FROM faqs")->fetchAll(\PDO::FETCH_ASSOC), 'Field');
            $categoryColumn = in_array('faqs_category_id', $columns, true) ? 'faqs_category_id' : 'faqs_categories_id';
            $activeFilter = in_array('active', $columns, true) ? 'f.active = 1' : '1 = 1';
            $categoryActive = "1 = 1";
            try {
                $categoryColumns = array_column($pdo->query("SHOW COLUMNS FROM faqs_categories")->fetchAll(\PDO::FETCH_ASSOC), 'Field');
                if (in_array('active', $categoryColumns, true)) $categoryActive = '(c.active = 1 OR c.active IS NULL)';
            } catch (\Throwable $ignored) {}
            $sql = "SELECT f.id, f.`{$categoryColumn}` AS faqs_category_id, f.question, f.answer, c.name AS category
                    FROM faqs f
                    LEFT JOIN faqs_categories c ON c.id = f.`{$categoryColumn}`
                    WHERE {$activeFilter} AND {$categoryActive}
                    ORDER BY f.`{$categoryColumn}` ASC, f.id ASC";
            $stmt = $pdo->query($sql);
            $this->call(200, "success", "Lista de perguntas frequentes.", "success")
                ->back($stmt->fetchAll(\PDO::FETCH_ASSOC));
        } catch (\Throwable $e) {
            error_log('[Carpe Diem][FAQs listAll] ' . $e->getMessage());
            $this->call(500, "internal_server_error", "Não foi possível carregar as perguntas frequentes. Verifique a tabela faqs e suas colunas.", "error")->back([]);
        }
    }

    // Lista administrativa: inclui publicadas e rascunhos.
    public function adminList(array $data = []): void
    {
        if (!$this->authToken(1)) {
            $this->call(401, "unauthorized", "Somente o administrador pode visualizar a gestão de FAQs.", "error")->back();
            return;
        }
        try {
            $pdo = \Source\Core\Connect::getInstance();
            $columns = array_column($pdo->query("SHOW COLUMNS FROM faqs")->fetchAll(\PDO::FETCH_ASSOC), 'Field');
            $categoryColumn = in_array('faqs_category_id', $columns, true) ? 'faqs_category_id' : 'faqs_categories_id';
            $activeColumn = in_array('active', $columns, true) ? 'f.active' : '1';
            $stmt = $pdo->query("SELECT f.id, f.`{$categoryColumn}` AS faqs_category_id, f.question, f.answer, {$activeColumn} AS active, c.name AS category
                                 FROM faqs f LEFT JOIN faqs_categories c ON c.id = f.`{$categoryColumn}`
                                 ORDER BY f.id DESC");
            $this->call(200, "success", "FAQs cadastradas.", "success")->back($stmt->fetchAll(\PDO::FETCH_ASSOC));
        } catch (\Throwable $e) {
            error_log('[Carpe Diem][FAQs adminList] ' . $e->getMessage());
            $this->call(500, "internal_server_error", "Não foi possível carregar as FAQs cadastradas.", "error")->back([]);
        }
    }

    public function insertFaq(array $data): void
    {
        if (!$this->authToken(1)) {
            $this->call(401, "unauthorized", "Somente o administrador pode cadastrar FAQs.", "error")->back();
            return;
        }
        $data = $this->requestData($data);
        if (empty($data['faqs_category_id']) || empty(trim($data['question'] ?? '')) || empty(trim($data['answer'] ?? '')) || !filter_var($data['faqs_category_id'], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "Categoria, pergunta e resposta são obrigatórias.", "error")->back();
            return;
        }
        $faq = new Faq(null, (int)$data['faqs_category_id'], trim($data['question']), trim($data['answer']), isset($data['active']) ? (int)$data['active'] : 1);
        if (!$faq->insert()) {
            $this->call(500, "internal_server_error", "Erro ao salvar a FAQ: " . $faq->getErrorMessage(), "error")->back();
            return;
        }
        $this->call(201, "success", "FAQ cadastrada.", "success")->back(['id'=>$faq->getId()]);
    }

    public function updateFaq(array $data): void
    {
        if (!$this->authToken(1)) {
            $this->call(401, "unauthorized", "Somente o administrador pode alterar FAQs.", "error")->back();
            return;
        }
        $data = $this->requestData($data);
        $id = (int)($data['id'] ?? 0);
        if ($id <= 0) {
            $this->call(400, "bad_request", "ID da FAQ é obrigatório.", "error")->back();
            return;
        }
        $faq = new Faq();
        if (!$faq->selectById($id)) {
            $this->call(404, "not_found", "FAQ não encontrada.", "error")->back();
            return;
        }
        if (array_key_exists('faqs_category_id', $data)) $faq->setFaqsCategoryId((int)$data['faqs_category_id']);
        if (array_key_exists('question', $data)) $faq->setQuestion(trim($data['question']));
        if (array_key_exists('answer', $data)) $faq->setAnswer(trim($data['answer']));
        if (array_key_exists('active', $data)) $faq->setActive((int)$data['active']);
        if (!$faq->updateById($id)) {
            // Atualizações idempotentes podem retornar rowCount=0 quando o valor já é igual.
            if ($faq->getErrorMessage() !== 'Registro não encontrado ou sem alterações.') {
                $this->call(500, "internal_server_error", "Erro ao atualizar a FAQ: " . $faq->getErrorMessage(), "error")->back();
                return;
            }
        }
        $this->call(200, "success", "FAQ atualizada.", "success")->back(['id'=>$id]);
    }

    public function selectFaq(array $data): void
    {
        $id = (int)($data['id'] ?? 0);
        $faq = new Faq();
        if ($id <= 0 || !$faq->selectById($id)) {
            $this->call(404, "not_found", "FAQ não encontrada.", "error")->back();
            return;
        }
        $this->call(200, "success", "FAQ encontrada.", "success")->back(['id'=>$faq->getId(), 'faqs_category_id'=>$faq->getFaqsCategoryId(), 'question'=>$faq->getQuestion(), 'answer'=>$faq->getAnswer(), 'active'=>$faq->getActive()]);
    }

    public function deleteFaq(array $data): void
    {
        if (!$this->authToken(1)) {
            $this->call(401, "unauthorized", "Somente o administrador pode remover FAQs.", "error")->back();
            return;
        }
        $id = (int)($data['id'] ?? 0);
        $faq = new Faq();
        if ($id <= 0 || !$faq->softDeleteById($id)) {
            $this->call(404, "not_found", "FAQ não encontrada.", "error")->back();
            return;
        }
        $this->call(200, "success", "FAQ removida da publicação.", "success")->back();
    }
}
