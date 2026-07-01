<?php

namespace Source\Controller; 

use Source\Models\Contacts\Contact; 

class Contacts extends Api
{
    public function listAll(array $data):void
    {
        $contacts = new Contact();

        if(empty($contacts))
        {
            $this->call(
            404,
            "error",
            "Nenhum contato encontrada",
            "error"
            )->back();

            return;
        }

        $this->call(
            200, 
            "success", 
            "Lista de Contatos", 
            "success"
        )->back($contacts->selectAll());
    }


    public function listById(array $data):void 
    {
        $contact = new Contact();

        if (!$contact->selectById($data["contact_id"])) 
        {
            $this->call(
            404,
            "error",
            $contact->getErrorMessage(),
            "error"
            )->back();
        return;
        }

        $this->call(
            200, 
            "success", 
            "Mensagem encontrada", 
            "success"
        )->back($contact);
    }


    public function insert(array $data):void 
    {
         if(!$this->authToken(3))
       {
          $this->call(
            401,
            "unauthorized",
            "Usuário não está autenticado (sem token ou token inválido).",
            "error"
            )->back();
        return;
        }

        if(empty($data['user_id']) || empty($data['text']) )
        {
            $this->call(
            400,
            "error",
            "Dados obrigatórios não informados",
            "error"
            )->back();
        return;
        }

        $contact = new Contact(null, $data['user_id'], $data['text']);

        if(!$contact->insert())
        {
            $this->call(
            500,
            "internal_server_error",
            "Erro ao salvar no banco de dados - {$contact->getErrorMessage()}",
            "error"
            )->back();
        return;
        }

        $response = [
           "id" => $contact->getId(),
           "user_id" => $contact->getUserId(),
           "text" => $contact->getText()
        ];

        $this->call(
            200, 
            "success", 
            "Contato inserido", 
            "success"
        )->back($response);
    }


    public function deleteById(array $data):void
    {
         if(!$this->authToken(3))
       {
          $this->call(
            401,
            "unauthorized",
            "Usuário não está autenticado (sem token ou token inválido).",
            "error"
            )->back();
        return;
        }

        if(empty($data["contact_id"])) 
        {
            $this->call(
            400,
            "error",
            "ID não informado",
            "error"
            )->back();
        return;
        }

        $contact = new Contact();

        if(!$contact->deleteById($data["contact_id"])) 
        {

            $this->call(
            404,
            "error",
            "Contato não encontrado",
            "error"
            )->back();
        return;
        }

        $this->call(
            200, 
            "success", 
            "Contato removido", 
            "success"
        )->back(null);
    }

    public function updateById(array $data):void 
    {
         if(!$this->authToken(3))
       {
          $this->call(
            401,
            "unauthorized",
            "Usuário não está autenticado (sem token ou token inválido).",
            "error"
            )->back();
        return;
        }

        if (empty($data["contact_id"]) || empty($data["user_id"]) || empty($data["text"])) 
        {
            $this->call(
            400,
            "error",
            "Dados obrigatórios não informados",
            "error"
            )->back();
        return;
        }

        $contact = new Contact(null, $data["user_id"], $data["text"]);

        if(!$contact->updateById($data["contact_id"])) 
        {
            $this->call(
            500,
            "error",
            $contact->getErrorMessage(),
            "error"
            )->back();
        return;
        }

        $response = 
        [
            "id" => $contact->getId(),
            "user_id" => $contact->getUserId(),
            "text" => $contact->getText()
        ];

    $this->call(
        200, 
        "success", 
        "Contato atualizado com sucesso", 
        "success"
    )->back($response);
    }
    
}