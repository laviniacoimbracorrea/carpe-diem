<?php 

namespace Source\Controller; 

use Source\Controller\Api;
use Source\Models\Reviews\Review; 

class Reviews extends Api 
{ 

    public function listAll (array $data): void 
    { 
        $review = new Review(); 
        $this->call(200,"success","Lista de avaliações","success")->back($review->selectAll()); 

    
    }

    public function listById(array $data): void
    {
        $review = new Review();

        if(!$review->selectById($data["review_id"])) 
        {
            $this->call(
            404,
            "error",
            $review->getErrorMessage(),
            "error"
            )->back();

            return;
        }

        $this->call(200,"success","Avaliação encontrada","success")->back($review);
    }

    public function insert(array $data): void
    {

        if(empty($data["user_id"]) || empty($data["portfolio_id"]) || empty($data["evaluate"])) 
        {
            $this->call(
            400,
            "error",
            "Dados obrigatórios não informados",
            "error" )->back();

            return;
        }

        $review = new Review(null, $data["user_id"], $data["portfolio_id"], $data["evaluate"]);

        if(!$review->insert())
        {
            $this->call(
            500,
            "internal_server_error",
            "Erro ao salvar no banco de dados - {$review->getErrorMessage()}",
            "error"
            )->back(null);

            return;
        }

        $response = 
        [
            "id" => $review->getId(),
            "user_id" => $review->getUserId(),
            "portfolio_id" => $review->getPortfolioId(),
            "evaluate" => $review->getEvaluate()
        ];

        $this->call(
        201,
        "success",
        "Avaliação cadastrada",
        "success"
        )->back($response);
    }

    public function deleteById(array $data): void
    {

        if(empty($data["review_id"])) {

            $this->call(
            400,
            "error",
            "ID não informado",
            "error"
            )->back();
            return;
        }

        $review = new Review();

        if(!$review->deleteById($data["review_id"])) 
        {

            $this->call(
            404,
            "error",
            "Avaliação não encontrada",
            "error"
            )->back();
            return;
        }

        $this->call(200, "success","Avaliação removida","success")->back();
    }

    public function updateById(array $data): void
    {
        if(empty($data["review_id"]) || empty($data["user_id"]) || empty($data["portfolio_id"]) || empty($data["evaluate"])) 
        {
            $this->call(
            400,
            "error",
            "Dados obrigatórios não informados",
            "error"
            )->back();

            return;
        }

        $review = new Review(null, $data["user_id"], $data["portfolio_id"], $data["evaluate"]);

        if(!$review->updateById($data["review_id"])) 
        {
            $this->call(
            500,
            "error",
            $review->getErrorMessage(),
            "error"
            )->back();

            return;
        }

        $response = 
        [
            "id" => $review->getId(),
            "user_id" => $review->getUserId(),
            "portfolio_id" => $review->getPortfolioId(),
            "evaluate" => $review->getEvaluate()
        ];

        $this->call(200, "success", "Avaliação atualizada com sucesso", "success")->back($response);
    }
    
}