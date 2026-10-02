import HttpClientBase from "./HttpClientBase.js";

class MessageService {

    constructor() {

        this.http = new HttpClientBase(
            "http://localhost:8080/carpe-diem/api"
        );

    }

    async list() {

        return await this.http.get("/messages/list");

    }

    async select(id) {

        return await this.http.get(`/messages/list/${id}`);

    }

    async insert(data) {

        return await this.http.post("/messages/", data);

    }

    async update(id, data) {

        return await this.http.put(`/messages/${id}`, data);

    }

    async delete(id) {

        return await this.http.delete(`/messages/${id}`);

    }

}

export default MessageService;