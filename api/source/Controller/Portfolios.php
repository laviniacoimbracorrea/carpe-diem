<?php

namespace Source\Controller;

use Source\Controller\Api;
use Source\Models\Portfolios\Portfolio;

class Portfolios extends Api
{
        
    public function listAll (array $data): void
    {
        $portfolio = new Portfolio();
        $this->call(200,"success","Lista de portfolios","success")->back($portfolio->selectAll());
    }

    public function insertPortfolio(array $data) : void
    {
        // autenticação 
        
        if(!$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if( !isset($data["user_id"]) || !isset($data["title"]) || !isset($data["description"]) || !isset($data["cover_link"])
            || empty($data["user_id"]) || empty($data["title"]) ||  empty($data["description"]) ||  empty($data["cover_link"]) 
            || !filter_var($data["user_id"], FILTER_VALIDATE_INT)) 
            {

            $this->call(
                400,
                "bad_request",
                "Os campos user_id, title, description e cover_link são obrigatórios.",
                "error"
            ) ->back(null);
            return;

            }

          
   
            $portfolio = new Portfolio( null, $data["user_id"], $data["title"], $data["description"], $data["cover_link"]);
          
            if(!$portfolio->insert())
                {
                    $this->call(500, "internal_server_error", "Erro ao incluir portfolio no banco de dados. {$portfolio->getErrorMessage()}", "error")
                    ->back(null);
                    return;
                }
            

                $response = [
                    "id" => $portfolio->getId(),
                    "user_id" => $portfolio->getUserId(),
                    "title" => $portfolio->getTitle(),
                    "description" => $portfolio->getDescription(),
                    "cover_id" => $portfolio->getCoverLink()
                ];

                $this->call(201, "success", "Portfolio inserido com sucesso!", "success")
                ->back($response);

    }

    public function updatePortfolio(array $data) : void 
    {
        $data = json_decode(file_get_contents("php://input"), true) ?? $data;

        if(!isset($data["id"]) ||!isset($data["user_id"]) || !isset($data["title"]) || !isset($data["description"]) || !isset($data["cover_link"])
            || empty($data["id"]) || empty($data["user_id"]) || empty($data["title"]) || empty($data["description"]) || empty($data["cover_link"])
            || !filter_var($data["id"], FILTER_VALIDATE_INT) || !filter_var($data["user_id"], FILTER_VALIDATE_INT))
        {

        $this->call(
                400,
                "bad_request",
                "Os campos user_id, title, description, cover_link são obrigatórios.",
                "error"
            ) ->back(null);
            return;

        }

        //$photo = new Photo(null, $data["portfolio_id"], $data["link"]); é mais recomendado utilizar set para atualizar um objeto
        $portfolio = new Portfolio();
        $portfolio->setId($data["id"]);
        $portfolio->setUserId($data["user_id"]);
        $portfolio->setTitle($data["title"]);
        $portfolio->setDescription($data["description"]);
        $portfolio->setCoverLink($data["cover_link"]);

        if(!$portfolio->updateById($data["id"]))
            {
            $this->call(500, "internal_server_error", "Erro ao atualizar o portfolio no banco de dados:". $portfolio->getErrorMessage(),  "error")
            ->back(null);
            return;
            }

         $response = 
         [
                "id" => $portfolio->getId(),
                "user_id" => $portfolio->getUserId(),
                "title" => $portfolio->getTitle(),
                "description" => $portfolio->getDescription(),
                "cover_link" => $portfolio->getCoverLink()
         ];

        $this->call(201, "success", "Portfolio atualizado com sucesso!", "success")
        ->back($response);

    }

    public function selectPortfolio( array $data ): void
    {
    
        if(!isset($data['id']) || empty($data['id']) || !filter_var($data['id'], FILTER_VALIDATE_INT))
        {
        $this->call(
                400,
                "bad_request",
                "O campo id(número interio) é obrigatório.",
                "error"
            ) ->back(null);
            return;
        }
    
        $portfolio = new Portfolio(); // no select é recomendado que ele esteja vazio 
    
        if(!$portfolio->selectById((int)$data['id']))
            {
                 $this->call(500, "internal_server_error", "Portifolio não encontrada no sistema:". $portfolio->getErrorMessage(),  "error")
                ->back(null);
                return;
            }
    
        $response = 
        [
            "id" => $portfolio->getId(),
            "user_id" => $portfolio->getUserId(),
            "title" => $portfolio->getTitle(),
            "description" => $portfolio->getDescription(),
            "cover_link" => $portfolio->getCoverLink()
        ];
    
            $this->call(201, "success", "Portfolio selecionado com sucesso!", "success")
            ->back($response);
    
    }

    public function deletetPortfolio( array $data ): void
    {
         if(!isset($data['id']) || empty($data['id']) || !filter_var($data['id'], FILTER_VALIDATE_INT))
        {
            $this->call(
                    400,
                    "bad_request",
                    "O campo id(número interio) é obrigatório.",
                    "error"
                ) ->back(null);
                return;
        }
    
        $portfolio = new Portfolio();
    
        if(!$portfolio->softDeleteById((int)$data['id']))
            {
                $this->call(500, "internal_server_error", "Portfolio não encontrado no sistema:". $portfolio->getErrorMessage(),  "error")
                ->back(null);
                return;
            }
        
        $this->call(200, "success", "Portfolio deletado com sucesso do banco de dados!", "success")
        ->back(null);
    

    }
    
    
}
