console.log("Contato carregando...");

import ContactService from "../../_common/scripts/services/ContactService.js";

const contactService = new ContactService();

const formContato = document.querySelector("#form-contato");


formContato.addEventListener("submit", async function (event) {

    event.preventDefault();

    try {

        const nome = document.querySelector("#nome").value.trim();
        const email = document.querySelector("#email").value.trim();
        const assunto = document.querySelector("#assunto").value.trim();
        const mensagem = document.querySelector("#mensagem").value.trim();


        if (!nome || !email || !assunto || !mensagem) {

            mostrarAviso("Preencha todos os campos.");

            return;
        }


        /*
         * Recupera o usuário que está logado
         */
        const usuario = JSON.parse(
            localStorage.getItem("user")
        );


        if (!usuario || !usuario.id) {

            mostrarAviso(
                "É necessário estar logado para enviar uma mensagem."
            );

            return;
        }


        /*
         * A tabela contacts possui:
         *
         * user_id
         * text
         *
         * Por isso, reunimos as informações do formulário
         * dentro do campo text.
         */
        const data = {

            user_id: usuario.id,

            text:
                `Nome: ${nome}\n` +
                `E-mail: ${email}\n` +
                `Assunto: ${assunto}\n` +
                `Mensagem: ${mensagem}`

        };


        console.log("Enviando contato...");
        console.log(data);


        /*
         * Envia para a API
         */
        const response = await contactService.insert(data);


        console.log("Resposta da API:");
        console.log(response);


        /*
         * Sucesso
         */
        mostrarAviso(
            "Mensagem enviada com sucesso! Retornaremos em breve."
        );


        formContato.reset();


    } catch (error) {

        console.error(
            "Erro ao enviar contato:",
            error
        );


        mostrarAviso(
            error.message ||
            "Não foi possível enviar a mensagem."
        );

    }

});