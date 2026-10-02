import HttpClientBase from "./HttpClientBase.js";

class PortfolioService {

    constructor() {
        this.http = new HttpClientBase(
            "http://localhost:8080/carpe-diem/api"
        );
    }

    async list() {
        return await this.http.get("/portfolios/list");
    }

    async select(id) {
        return await this.http.get(`/portfolios/select/${id}`);
    }

    async insert(data) {
        return await this.http.post("/portfolios/insert", data);
    }

    async update(data) {
        return await this.http.put("/portfolios/update", data);
    }

    async delete(id) {
        return await this.http.delete(`/portfolios/delete/${id}`);
    }
}

export default PortfolioService;