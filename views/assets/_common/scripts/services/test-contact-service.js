import ContactService from "./ContactService.js";

const contactService = new ContactService();

async function testContactService() {

    try {

        const contacts = await contactService.list();

        console.log("API de contatos respondeu com sucesso!");
        console.log(contacts);

    } catch (error) {

        console.error(
            "Erro ao testar ContactService:",
            error
        );

    }

}

testContactService();