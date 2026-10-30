class ContactService {

    constructor() {

        this.baseUrl =
            "http://localhost:8080/carpe-diem/api/contacts";

    }


    async insert(data) {

        const token = localStorage.getItem("token");


        const response = await fetch(
            `${this.baseUrl}/`,
            {
                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${token}`
                },

                body: JSON.stringify(data)
            }
        );


        const result = await response.json();


        if (!response.ok) {

            throw new Error(
                result.message ||
                "Erro ao enviar contato."
            );

        }


        return result;
    }

}


export default ContactService;