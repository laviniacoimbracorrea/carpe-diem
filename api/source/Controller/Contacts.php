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
                "error",
                "Nenhum contato encontrado.",
                "error"
            )->back();

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
        if (empty($data["contact_id"])) {
            $this->call(
                400,
                "error",
                "ID do contato não informado.",
                "error"
            )->back();

            return;
        }

        $contact = new Contact();

        if (!$contact->selectById((int)$data["contact_id"])) {

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
            "Mensagem encontrada.",
            "success"
        )->back($contact);
    }

    public function insert(array $data): void
    {
        if (!$this->authToken(3)) {

            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error"
            )->back();

            return;
        }

        if (
            empty($data['user_id']) ||
            empty($data['text'])
        ) {

            $this->call(
                400,
                "error",
                "Dados obrigatórios não informados.",
                "error"
            )->back();

            return;
        }

        $contact = new Contact(
            null,
            (int)$data['user_id'],
            $data['text']
        );

        if (!$contact->insert()) {

            $this->call(
                500,
                "internal_server_error",
                "Erro ao salvar no banco de dados: " .
                $contact->getErrorMessage(),
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
            )->back();

            return;
        }

        if (empty($data["contact_id"])) {

            $this->call(
                400,
                "error",
                "ID não informado.",
                "error"
            )->back();

            return;
        }

        $contact = new Contact();

        if (!$contact->deleteById((int)$data["contact_id"])) {

            $this->call(
                404,
                "error",
                "Contato não encontrado.",
                "error"
            )->back();

            return;
        }

        $this->call(
            200,
            "success",
            "Contato removido.",
            "success"
        )->back();
    }

    public function updateById(array $data): void
    {
        if (!$this->authToken(3)) {

            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado.",
                "error"
            )->back();

            return;
        }

        if (
            empty($data["contact_id"]) ||
            empty($data["user_id"]) ||
            empty($data["text"])
        ) {

            $this->call(
                400,
                "error",
                "Dados obrigatórios não informados.",
                "error"
            )->back();

            return;
        }

        $contact = new Contact(
            (int)$data["contact_id"],
            (int)$data["user_id"],
            $data["text"]
        );

        if (!$contact->updateById((int)$data["contact_id"])) {

            $this->call(
                500,
                "error",
                $contact->getErrorMessage(),
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
            "Contato atualizado com sucesso.",
            "success"
        )->back($response);
    }
}