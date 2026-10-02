export default class PhotoService {

    constructor() {
        this.url = "http://localhost:8080/carpe-diem/api/photos";
    }

    async list() {

        const response = await fetch(`${this.url}/list`);

        if (!response.ok) {
            throw new Error("Erro ao buscar fotos.");
        }

        return await response.json();
    }

    async select(id) {

        const response = await fetch(`${this.url}/select/${id}`);

        if (!response.ok) {
            throw new Error("Erro ao buscar foto.");
        }

        return await response.json();
    }

    async listByPortfolioId(portfolioId) {

        const response = await fetch(
            `${this.url}/portfolio/${portfolioId}`
        );

        if (!response.ok) {
            throw new Error("Erro ao buscar fotos do portfólio.");
        }

        return await response.json();
    }
}