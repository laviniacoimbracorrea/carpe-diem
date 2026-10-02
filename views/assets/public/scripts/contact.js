console.log("Contato carregando...");

import ContactService from "../../_common/scripts/services/ContactService.js";

const contactService = new ContactService();

const formContato = document.querySelector("#form-contato");

formContato.addEventListener("submit", async function (event) {

    event.preventDefault();

    try {

        const nome = document.querySelector("#nome").value;
        const email = document.querySelector("#email").value;
        const assunto = document.querySelector("#assunto").value;
        const mensagem = document.querySelector("#mensagem").value;

        const usuario = JSON.parse(
            localStorage.getItem("user")
        );

        if (!usuario || !usuario.id) {

            mostrarAviso(
                "É necessário estar logado para enviar uma mensagem."
            );

            return;
        }

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

        const response = await contactService.insert(data);

        console.log("Contato enviado com sucesso!");
        console.log(response);

        mostrarAviso(
            "Mensagem enviada! Retornaremos em breve."
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