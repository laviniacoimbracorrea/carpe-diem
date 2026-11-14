class HttpClientBase {

    constructor(baseUrl) {
        this.baseUrl = baseUrl;
    }

    async get(endpoint) {
        const response = await fetch(`${this.baseUrl}${endpoint}`);

        return this.handleResponse(response);
    }

    async post(endpoint, data) {
        const response = await fetch(`${this.baseUrl}${endpoint}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        return this.handleResponse(response);
    }

    async put(endpoint, data) {
        const response = await fetch(`${this.baseUrl}${endpoint}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        return this.handleResponse(response);
    }

    async delete(endpoint) {
        const response = await fetch(`${this.baseUrl}${endpoint}`, {
            method: "DELETE"
        });

        return this.handleResponse(response);
    }

    async handleResponse(response) {

        const data = await response.json();

        if (!response.ok) {
            throw new Error(
                data.message || "Erro na requisição."
            );
        }

        return data;
    }
}

export default HttpClientBase;