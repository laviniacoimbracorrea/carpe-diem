<?php 

namespace Source\Controller;

use Source\Controller\Api;
use Source\Models\Faqs\Faq;

class Faqs extends Api
{
    
    public function listAll (array $data): void
    {
        $faq = new Faq();
        $this->call(200,"success","Lista de FAQs","success")->back($faq->selectAll());
    }

    public function insertFaq(array $data): void 
    {

        if(!$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }
      
        // verifica se corresponde o caminho, se está vazio, verifica se é um valor inválido 
        if( !isset($data["faqs_category_id"]) || !isset($data["question"]) || !isset($data["answer"])
            || empty($data["faqs_category_id"]) || empty($data["question"]) || empty($data["answer"])
            || !filter_var($data["faqs_category_id"], FILTER_VALIDATE_INT)) 
            {

            $this->call(
                400,
                "bad_request",
                "Os campos faqs_category_id, question e answer são obrigatórios",
                "error"
            ) ->back(null);
            return;

            }

            //instanciamento do objeto
            $faq = new Faq(null, $data["faqs_category_id"], $data["question"], $data["answer"]);

           // var_dump($photo);

            // persistência de dados
            if(!$faq->insert())
                {
                    $this->call(500, "internal_server_error", "Erro ao salvar a faq no banco de dados. {$photo->getErrorMessage()}", "error")
                    ->back(null);
                    return;
                }
            
                // em caso de sucesso, inserir a foto no banco

                $response = [
                    "id" => $faq->getId(),
                    "faqs_category_id" => $faq->getFaqsCategoryId(),
                    "question" => $faq->getQuestion(),
                    "answer" => $faq->getAnswer()
                ];

                $this->call(201, "success", "Faq inserida com sucesso!", "success")
                ->back($response);
    }

    public function updateFaq(array $data): void 
    {
        $data = json_decode(file_get_contents("php://input"), true) ?? $data;

        if(!isset($data["id"]) ||!isset($data["faqs_category_id"]) || !isset($data["question"]) || !isset($data["answer"])
            || empty($data["id"]) || empty($data["faqs_category_id"]) || empty($data["question"]) || empty($data["answer"])
            || !filter_var($data["id"], FILTER_VALIDATE_INT) || !filter_var($data["faqs_category_id"], FILTER_VALIDATE_INT))
        {

        $this->call(
                400,
                "bad_request",
                "Os campos id (número inteiro), faqs_category_id(número inteiro), question e answer são obrigatórios.",
                "error"
            ) ->back(null);
            return;

        }

        //$photo = new Photo(null, $data["portfolio_id"], $data["link"]); é mais recomendado utilizar set para atualizar um objeto
        $faq = new Faq();
        $faq->setId($data["id"]);
        $faq->setFaqsCategoryId($data["faqs_category_id"]);
        $faq->setQuestion($data["question"]);
        $faq->setAnswer($data["answer"]);

        if(!$faq->updateById($data["id"]))
            {
            $this->call(500, "internal_server_error", "Erro ao atualizar a faq no banco de dados:". $photo->getErrorMessage(),  "error")
            ->back(null);
            return;
            }

         $response = 
         [
                "id" => $faq->getId(),
                "faqs_category_id" => $faq->getFaqsCategoryId(),
                "question" => $faq->getQuestion(),
                "answer" => $faq->getAnswer()
         ];

        $this->call(201, "success", "Faq atualizada com sucesso!", "success")
        ->back($response);
    }

    public function selectFaq(array $data): void 
    {
        if(!isset($data["id"]) || empty($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT))
            {
                $this->call(
                    400,
                    "bad_request",
                    "O campo ID(número inteiro) é obrigatório", 
                    "error"
                )->back(null);
                return;
            }

        $faq = new Faq();

        if(!$faq->selectById((int)$data["id"]))
            {
                $this->call(
                    500,
                    "internal_server_error",
                    "faq não encontrada no sistema". $faq->getErrorMessage(),
                    "error"
                )->back(null);
                return;
            }
        
        $response = 
        [
            "id" => $faq->getId(),
            "faqs_category_id" => $faq->getFaqsCategoryId(),
            "question" => $faq->getQuestion(),
            "answer" => $faq->getAnswer()
        ];

        $this->call(
            201,
            "success",
            "Faq selecionada com sucesso!",
            "success"
        )->back($response);
            
    }

    public function deleteFaq(array $data): void 
    {
        if(!isset($data["id"]) || empty($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT))
        {
            $this->call(
                400,
                "bad_request",
                "o campo ID (número inteiro é obrigatório)",
                "error"
            )->back(null);
            return;

        }

        $faq = new Faq();

        if(!$faq->softDeleteById((int)$data["id"]))
        {
            $this->call(
                500,
                "internal_server_error", 
                "Foto não encontrada no sistema:". $faq->getErrorMessage(),  
                "error")
            ->back(null);
            return;
        }

        $this->call(
            200,
            "success",
            "Faq deletada com sucesso do banco de dados!",
            "success"
        )->back(null);

    }

}