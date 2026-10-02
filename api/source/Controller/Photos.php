<?php

namespace Source\Controller;

use Source\Models\Photos\Photo;

class Photos extends Api
{
    public function listAll(array $data): void
    {
        $photo = new Photo();

        $this->call(
            200,
            "success",
            "Lista de fotos",
            "success"
        )->back($photo->selectAll());
    }


    public function listByPortfolioId(array $data): void
    {
        if (
            !isset($data["portfolio_id"]) ||
            empty($data["portfolio_id"]) ||
            !filter_var($data["portfolio_id"], FILTER_VALIDATE_INT)
        ) {
            $this->call(
                400,
                "bad_request",
                "O campo portfolio_id (número inteiro) é obrigatório.",
                "error"
            )->back(null);

            return;
        }

        $photo = new Photo();

        $photos = $photo->selectByPortfolioId(
            (int)$data["portfolio_id"]
        );

        if (!$photos) {
            $this->call(
                404,
                "not_found",
                "Nenhuma foto encontrada para este portfólio.",
                "error"
            )->back(null);

            return;
        }

        $this->call(
            200,
            "success",
            "Lista de fotos do portfólio",
            "success"
        )->back($photos);
    }


    public function insertPhoto(array $data): void
    {
        if (!$this->authToken(2)) {
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error"
            )->back();

            return;
        }

        if (
            !isset($data["portfolio_id"]) ||
            !isset($data["link"]) ||
            empty($data["portfolio_id"]) ||
            empty($data["link"]) ||
            !filter_var($data["portfolio_id"], FILTER_VALIDATE_INT)
        ) {
            $this->call(
                400,
                "bad_request",
                "Os campos portfolio_id (número inteiro) e link são obrigatórios.",
                "error"
            )->back(null);

            return;
        }

        $photo = new Photo(
            null,
            $data["portfolio_id"],
            $data["link"]
        );

        if (!$photo->insert()) {
            $this->call(
                500,
                "internal_server_error",
                "Erro ao salvar a foto no banco de dados. {$photo->getErrorMessage()}",
                "error"
            )->back(null);

            return;
        }

        $response = [
            "id" => $photo->getId(),
            "portfolio_id" => $photo->getPortfolioId(),
            "link" => $photo->getLink()
        ];

        $this->call(
            201,
            "success",
            "Foto inserida com sucesso!",
            "success"
        )->back($response);
    }


    public function updatePhoto(array $data): void
    {
        $data = json_decode(
            file_get_contents("php://input"),
            true
        ) ?? $data;

        if (
            !isset($data["id"]) ||
            !isset($data["portfolio_id"]) ||
            !isset($data["link"]) ||
            empty($data["id"]) ||
            empty($data["portfolio_id"]) ||
            empty($data["link"]) ||
            !filter_var($data["id"], FILTER_VALIDATE_INT) ||
            !filter_var($data["portfolio_id"], FILTER_VALIDATE_INT)
        ) {
            $this->call(
                400,
                "bad_request",
                "Os campos id, portfolio_id (número inteiro) e link são obrigatórios.",
                "error"
            )->back(null);

            return;
        }

        $photo = new Photo();

        $photo->setId($data["id"]);
        $photo->setPortfolioId($data["portfolio_id"]);
        $photo->setLink($data["link"]);

        if (!$photo->updateById($data["id"])) {
            $this->call(
                500,
                "internal_server_error",
                "Erro ao atualizar o link da foto no banco de dados: " .
                $photo->getErrorMessage(),
                "error"
            )->back(null);

            return;
        }

        $response = [
            "id" => $photo->getId(),
            "portfolio_id" => $photo->getPortfolioId(),
            "link" => $photo->getLink()
        ];

        $this->call(
            200,
            "success",
            "Foto atualizada com sucesso!",
            "success"
        )->back($response);
    }


    public function selectPhoto(array $data): void
    {
        if (
            !isset($data["id"]) ||
            empty($data["id"]) ||
            !filter_var($data["id"], FILTER_VALIDATE_INT)
        ) {
            $this->call(
                400,
                "bad_request",
                "O campo id (número inteiro) é obrigatório.",
                "error"
            )->back(null);

            return;
        }

        $photo = new Photo();

        if (!$photo->selectById((int)$data["id"])) {
            $this->call(
                404,
                "not_found",
                "Foto não encontrada no sistema: " .
                $photo->getErrorMessage(),
                "error"
            )->back(null);

            return;
        }

        $response = [
            "id" => $photo->getId(),
            "portfolio_id" => $photo->getPortfolioId(),
            "link" => $photo->getLink()
        ];

        $this->call(
            200,
            "success",
            "Foto selecionada com sucesso!",
            "success"
        )->back($response);
    }


    public function deletePhoto(array $data): void
    {
        if (
            !isset($data["id"]) ||
            empty($data["id"]) ||
            !filter_var($data["id"], FILTER_VALIDATE_INT)
        ) {
            $this->call(
                400,
                "bad_request",
                "O campo id (número inteiro) é obrigatório.",
                "error"
            )->back(null);

            return;
        }

        $photo = new Photo();

        if (!$photo->deleteById((int)$data["id"])) {
            $this->call(
                404,
                "not_found",
                "Foto não encontrada no sistema: " .
                $photo->getErrorMessage(),
                "error"
            )->back(null);

            return;
        }

        $this->call(
            200,
            "success",
            "Foto deletada com sucesso do banco de dados!",
            "success"
        )->back(null);
    }
}