import HttpClientBase from "./HttpClientBase.js";

class ContactService {

    constructor() {
        this.http = new HttpClientBase(
            "http://localhost:8080/carpe-diem/api"
        );
    }

    async list() {
        return await this.http.get("/contacts/list");
    }

    async select(id) {
        return await this.http.get(`/contacts/list/${id}`);
    }

    async insert(data) {
        return await this.http.post("/contacts", data);
    }

    async update(id, data) {
        return await this.http.put(`/contacts/${id}`, data);
    }

    async delete(id) {
        return await this.http.delete(`/contacts/${id}`);
    }
}

export default ContactService;