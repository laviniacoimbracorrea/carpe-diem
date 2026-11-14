<?php

namespace Source\Controller;

use Source\Controller\Api;
use Source\Models\Specialties\Specialty;

class Specialties extends Api
{
        
    public function listAll (array $data): void
    {
        $specialty = new Specialty();
        $this->call(200,"success","Lista de especialidades","success")->back($specialty->selectAll());
    }

    public function insertSpecialty(array $data) : void
    {

         if(!$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }
      
        if( !isset($data["type"]) || empty($data["type"])) 
            {

            $this->call(
                400,
                "bad_request",
                "Os campos portfolio_id (número inteiro) e link são obrigatórios.",
                "error"
            ) ->back(null);
            return;

            }

            $specialty = new Specialty(null, $data["type"]);

            if(!$specialty->insert())
                {
                    $this->call(500, "internal_server_error", "Erro ao salvar a foto no banco de dados. {$specialty->getErrorMessage()}", "error")
                    ->back(null);
                    return;
                }

                $response = [
                    "id" => $specialty->getId(),
                    "type" => $specialty->getType()
                ];

                $this->call(201, "success", "Especialidade inserida com sucesso!", "success")
                ->back($response);

    }

    public function updateSpecialty(array $data) : void 
    {
        $data = json_decode(file_get_contents("php://input"), true) ?? $data;

        if(!isset($data["type"]) || empty($data["type"]))
        {

        $this->call(
                400,
                "bad_request",
                "Os campos type é obrigatório.",
                "error"
            ) ->back(null);
            return;

        }

        $specialty = new Specialty();
        $specialty->setId($data["id"]);
        $specialty->setType($data["type"]);

        if(!$specialty->updateById($data["id"]))
            {
            $this->call(500, "internal_server_error", "Erro ao atualizar a especialidade no banco de dados:". $specialty->getErrorMessage(),  "error")
            ->back(null);
            return;
            }

         $response = 
         [
                "id" => $specialty->getId(),
                "type" => $specialty->getType()
         ];

        $this->call(201, "success", "Especialidade atualizada com sucesso!", "success")
        ->back($response);

    }

    public function selectSpecialty( array $data ): void
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
    
        $specialty = new Specialty(); // no select é recomendado que ele esteja vazio 
    
        if(!$specialty->selectById((int)$data['id']))
            {
                 $this->call(
                    500,
                    "internal_server_error",
                    "Especialidade não encontrada no sistema:". $specialty->getErrorMessage(),
                    "error")
                ->back(null);
                return;
            }
    
        $response = 
        [
            "id" => $specialty->getId(),
            "type" => $specialty->getType()
        ];
    
            $this->call(
                201,
                "success", 
                "Especialidade selecionada com sucesso!", 
                "success")
            ->back($response);
    
    }

    public function deleteSpecialty( array $data ): void
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
    
        $specialty = new Specialty();
    
        if(!$specialty->deleteById((int)$data['id']))
            {
                $this->call(
                    500,
                    "internal_server_error", 
                    "Especialidade não encontrada no sistema:". $specialty->getErrorMessage(),  
                    "error")
                ->back(null);
                return;
            }
        
        $this->call(
            200, 
            "success", 
            "Especialidade deletada com sucesso do banco de dados!", 
            "success")
        ->back(null);
    

    }
    
}