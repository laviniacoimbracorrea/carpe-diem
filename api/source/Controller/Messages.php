<?php

namespace Source\Controller; 

use Source\Controller\Api;
use Source\Models\Messages\Message; 

class Messages extends Api
{
   public function listAll(array $data): void
   {
      $messages = new Message();

      if(empty($messages))
    {
        $this->call(
          404,
          "error",
          "Nenhuma mensagem encontrada",
          "error"
        )->back();

        return;
      }

      $this->call(200,"success","Lista de Mensagens","success")->back($messages->selectAll());
   }


   public function listById(array $data):void  
   {
        $message = new Message();

        if(!$message->selectById($data["message_id"])) 
        {
            $this->call(
            404,
            "error",
            $review->getErrorMessage(),
            "error"
            )->back();

            return;
        }

        $this->call(200,"success","Mensagem encontrada","success")->back($message->selectAll());
   }


   public function insert(array $data):void 
   {
        if(empty($data['user_photographer_id']) || empty($data['user_id']) || empty($data['message']))
        {
            $this->call(
            400,
            "error",
            "Dados obrigatórios não informados",
            "error"
            )->back();

            return;
        }

        $message = new Message(null, $data['user_photographer_id'], $data['user_id'], $data['message']);

        if(!$message->insert())
        {
            $this->call(
            500,
            "internal_server_error",
            "Erro ao salvar no banco de dados - {$review->getErrorMessage()}",
            "error"
            )->back();

            return;
        }

        $response = 
        [
           "id" => $message->getId(),
           "user_photographer_id" => $message->getUserPhotographerId(),
           "user_id" => $message->getUserId(),
           "message" => $message->getMessage()
        ];

        $this->call(200,"success","Mensagem inserida","success")->back($response);
   }


   public function deleteById(array $data):void 
   {
        if(empty($data["message_id"])) 
        {
            $this->call(
            400,
            "error",
            "ID não informado",
            "error"
            )->back();

            return;
        }

        $message = new Message();

        if (!$message->deleteById($data["message_id"])) 
        {
            $this->call(
            404,
            "error",
            "Avaliação não encontrada",
            "error"
            )->back();

        return;
        }

        $this->call(200,"success","Mensagem removida","success")->back(null);
   }

   
   public function updateById(array $data): void
    {
        if (empty($data["message_id"]) || empty($data["user_photographer_id"]) || empty($data["user_id"]) || empty($data["message"])) 
        {
            $this->call(
            400,
            "error",
            "Dados obrigatórios não informados",
            "error"
            )->back();

            return;
        }

        $message = new Message(null, $data["user_photographer_id"], $data["user_id"], $data["message"]);

        if(!$message->updateById($data["message_id"])) 
        {
            $this->call(
            500,
            "error",
            $message->getErrorMessage(),
            "error"
            )->back();

            return;
        }

        $response =  
        [
            "id" => $message->getId(),
            "user_photographer_id" => $message->getUserPhotographerId(),
            "user_id" => $message->getUserId(),
            "message" => $message->getMessage()
        ];

    $this->call(200,"success","Mensagem atualizada com sucesso","success")->back($response);
}

}