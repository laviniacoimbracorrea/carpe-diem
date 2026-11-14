<?php

namespace Source\Controller;

use Source\Controller\Api;
use Source\Models\Faqs\FaqCategory;

class FaqsCategories extends Api 
{

    
    public function listAll (array $data): void
    {
        $faqCategory = new FaqCategory();
        $this->call(200,"success","Lista de categorias das FAQ","success")->back($faqCategory->selectAll());
    }

    public function insertFaqsCategories(array $data)
    {
        if(!$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }
        
        
        if( !isset($data["name"]) || empty($data["name"])) 
            {

            $this->call(
                400,
                "bad_request",
                "o campo Name é obrigatório",
                "error"
            ) ->back(null);
            return;

            }

            $faqCategory = new FaqCategory(null, $data["name"]);
           
            if(!$faqCategory->insert())
                {
                    $this->call(500, "internal_server_error", "Erro ao salvar a faq category no banco de dados. {$faqCategory->getErrorMessage()}", "error")
                    ->back(null);
                    return;
                }
            
                $response = [
                    "id" => $faqCategory->getId(),
                    "name" => $faqCategory->getName()
                ];

                $this->call(201,
                 "success", 
                 "Faq Category inserida com sucesso!", 
                 "success")
                ->back($response);
    }

    public function updateFaqsCategories(array $data)
    {
        $data = json_decode(file_get_contents("php://input"), true) ?? $data;

        if(!isset($data["id"]) ||!isset($data["name"]) || empty($data["id"]) || empty($data["name"]) || !filter_var($data["id"], FILTER_VALIDATE_INT))
        {

        $this->call(
                400,
                "bad_request",
                "Os campos id (número inteiro) e name são obrigatórios.",
                "error"
            ) ->back(null);
            return;

        }

        $faqCategory = new FaqCategory();
        $faqCategory->setId($data["id"]);
        $faqCategory->setName($data["name"]);

        if(!$faqCategory->updateById($data["id"]))
            {
            $this->call(500, "internal_server_error", "Erro ao atualizar a faq category no banco de dados:". $photo->getErrorMessage(),  "error")
            ->back(null);
            return;
            }

         $response = 
         [
                "id" => $faqCategory->getId(),
                "name" => $faqCategory->getName()
         ];

        $this->call(201, "success", "Faq Category atualizada com sucesso!", "success")
        ->back($response);
    }

    public function selectFaqsCategories(array $data)
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

        $faqCategory = new FaqCategory();

        if(!$faqCategory->selectById((int)$data["id"]))
            {
                $this->call(
                    500,
                    "internal_server_error",
                    "faq category não encontrada no sistema". $faqCategory->getErrorMessage(),
                    "error"
                )->back(null);
                return;
            }
        
        $response = 
        [
            "id" => $faqCategory->getId(),
            "name" => $faqCategory->getName()
        ];

        $this->call(
            201,
            "success",
            "Faq Category selecionada com sucesso!",
            "success"
        )->back($response);
    }

    public function deleteFaqsCategories(array $data)
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

        $faqCategory = new FaqCategory();

        if(!$faqCategory->softDeleteById((int)$data["id"]))
        {
            $this->call(
                500,
                "internal_server_error", 
                "Foto não encontrada no sistema:". $faqCategory->getErrorMessage(),  
                "error")
            ->back(null);
            return;
        }

        $this->call(
            200,
            "success",
            "Faq category deletada com sucesso do banco de dados!",
            "success"
        )->back(null);

    }
}