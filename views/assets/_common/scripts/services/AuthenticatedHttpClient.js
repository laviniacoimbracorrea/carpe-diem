import HttpClientBase from './HttpClientBase.js';

/** Adaptador autenticado: mantém HttpClientBase original e acrescenta o JWT do projeto. */
export default class AuthenticatedHttpClient extends HttpClientBase {
  token() {
    return localStorage.getItem('token') || '';
  }

  async send(method, endpoint, data = null, isFormData = false) {
    const headers = { Accept: 'application/json' };
    const token = this.token();
    if (token) headers.Authorization = `Bearer ${token}`;
    const options = { method, headers };

    if (data !== null) {
      if (isFormData) {
        options.body = data;
      } else {
        headers['Content-Type'] = 'application/json';
        options.body = JSON.stringify(data);
      }
    }

    const response = await fetch(`${this.baseUrl}${endpoint}`, options);
    const raw = await response.text();
    let result;
    try { result = raw ? JSON.parse(raw) : {}; }
    catch { throw new Error(`A API não retornou JSON (HTTP ${response.status}). Confira Apache, .htaccess e endereço ${this.baseUrl}${endpoint}.`); }
    if (!response.ok) throw new Error(result.message || `Erro HTTP ${response.status}`);
    return result;
  }

  get(endpoint) { return this.send('GET', endpoint); }
  post(endpoint, data) { return this.send('POST', endpoint, data); }
  put(endpoint, data) { return this.send('PUT', endpoint, data); }
  delete(endpoint) { return this.send('DELETE', endpoint); }
  postForm(endpoint, formData) { return this.send('POST', endpoint, formData, true); }
}
