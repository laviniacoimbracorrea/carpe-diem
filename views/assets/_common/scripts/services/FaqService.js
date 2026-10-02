import HttpClientBase from "./HttpClientBase.js";

class FaqService {

    constructor() {

        this.http = new HttpClientBase(
            "http://localhost:8080/carpe-diem/api"
        );

    }

    async list() {

        return await this.http.get("/faqs/list");

    }

    async select(id) {

        return await this.http.get(`/faqs/select/${id}`);

    }

    async insert(data) {

        return await this.http.post("/faqs/insert", data);

    }

    async update(data) {

        return await this.http.put("/faqs/update", data);

    }

    async delete(id) {

        return await this.http.delete(`/faqs/delete/${id}`);

    }

}

export default FaqService;