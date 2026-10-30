<?php

namespace Source\Controller;

use Source\Models\Contacts\Contact;

class Contacts extends Api
{
    public function listAll(array $data): void
    {
        $contacts = new Contact();

        $result = $contacts->selectAll();

        if (empty($result)) {

            $this->call(
                404,
                "not_found",
                "Nenhum contato encontrado.",
                "error"
            )->back(null);

            return;
        }

        $this->call(
            200,
            "success",
            "Lista de contatos.",
            "success"
        )->back($result);
    }


    public function listById(array $data): void
    {
        if (
            !isset($data["contact_id"]) ||
            empty($data["contact_id"]) ||
            !filter_var(
                $data["contact_id"],
                FILTER_VALIDATE_INT
            )
        ) {

            $this->call(
                400,
                "bad_request",
                "O ID do contato é obrigatório.",
                "error"
            )->back(null);

            return;
        }


        $contact = new Contact();


        if (!$contact->selectById((int)$data["contact_id"])) {

            $this->call(
                404,
                "not_found",
                $contact->getErrorMessage(),
                "error"
            )->back(null);

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
            "Contato encontrado.",
            "success"
        )->back($response);
    }


    public function insert(array $data): void
    {
        /*
         * Verifica autenticação
         */
        if (!$this->authToken(3)) {

            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error"
            )->back(null);

            return;
        }


        /*
         * Verifica os dados obrigatórios
         */
        if (
            !isset($data["user_id"]) ||
            !isset($data["text"]) ||
            empty($data["user_id"]) ||
            empty($data["text"]) ||
            !filter_var(
                $data["user_id"],
                FILTER_VALIDATE_INT
            )
        ) {

            $this->call(
                400,
                "bad_request",
                "Os campos user_id e text são obrigatórios.",
                "error"
            )->back(null);

            return;
        }


        /*
         * Cria o contato
         */
        $contact = new Contact(
            null,
            (int)$data["user_id"],
            $data["text"]
        );


        /*
         * Insere no banco
         */
        if (!$contact->insert()) {

            $this->call(
                500,
                "internal_server_error",
                "Erro ao salvar o contato no banco de dados: " .
                $contact->getErrorMessage(),
                "error"
            )->back(null);

            return;
        }


        /*
         * Resposta
         */
        $response = [
            "id" => $contact->getId(),
            "user_id" => $contact->getUserId(),
            "text" => $contact->getText()
        ];


        $this->call(
            201,
            "success",
            "Contato inserido com sucesso.",
            "success"
        )->back($response);
    }


    public function deleteById(array $data): void
    {
        if (!$this->authToken(3)) {

            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado.",
                "error"
            )->back(null);

            return;
        }


        if (
            !isset($data["contact_id"]) ||
            empty($data["contact_id"]) ||
            !filter_var(
                $data["contact_id"],
                FILTER_VALIDATE_INT
            )
        ) {

            $this->call(
                400,
                "bad_request",
                "O ID do contato é obrigatório.",
                "error"
            )->back(null);

            return;
        }


        $contact = new Contact();


        if (!$contact->deleteById((int)$data["contact_id"])) {

            $this->call(
                404,
                "not_found",
                $contact->getErrorMessage(),
                "error"
            )->back(null);

            return;
        }


        $this->call(
            200,
            "success",
            "Contato removido com sucesso.",
            "success"
        )->back(null);
    }


    public function updateById(array $data): void
    {
        if (!$this->authToken(3)) {

            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado.",
                "error"
            )->back(null);

            return;
        }


        if (
            !isset($data["contact_id"]) ||
            !isset($data["user_id"]) ||
            !isset($data["text"]) ||
            empty($data["contact_id"]) ||
            empty($data["user_id"]) ||
            empty($data["text"]) ||
            !filter_var(
                $data["contact_id"],
                FILTER_VALIDATE_INT
            ) ||
            !filter_var(
                $data["user_id"],
                FILTER_VALIDATE_INT
            )
        ) {

            $this->call(
                400,
                "bad_request",
                "Os campos contact_id, user_id e text são obrigatórios.",
                "error"
            )->back(null);

            return;
        }


        $contact = new Contact(
            (int)$data["contact_id"],
            (int)$data["user_id"],
            $data["text"]
        );


        if (
            !$contact->updateById(
                (int)$data["contact_id"]
            )
        ) {

            $this->call(
                500,
                "internal_server_error",
                $contact->getErrorMessage(),
                "error"
            )->back(null);

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
            "Contato atualizado com sucesso.",
            "success"
        )->back($response);
    }
}