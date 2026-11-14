import AuthenticatedHttpClient from './AuthenticatedHttpClient.js';

/** CRUD de fotografias e upload multipart, sem serializar FormData como JSON. */
export default class PhotoService extends AuthenticatedHttpClient {
  constructor() { super('../api'); }
  async list() { const r = await this.get('/photos/list'); return r.data || []; }
  async listByPortfolioId(portfolioId) {
    const r = await this.get(`/photos/portfolio/${Number(portfolioId)}`);
    return r.data || [];
  }
  async select(id) { const r = await this.get(`/photos/select/${Number(id)}`); return r.data; }
  async create(data) { return this.post('/photos/insert', data); }
  async insert(data) { return this.create(data); }
  async update(data) { return this.put('/photos/update', data); }
  async remove(id) { return this.send('DELETE', `/photos/delete/${Number(id)}`); }
  async delete(id) { return this.remove(id); }
  async uploadCover(file, portfolioId) {
    const form = new FormData();
    form.append("image", file);
    form.append("portfolio_id", String(portfolioId));
    return this.postForm("/photos/cover", form);
  }
  async upload(file, portfolioId = null) {
    const form = new FormData();
    form.append('image', file);
    if (portfolioId) form.append('portfolio_id', String(portfolioId));
    return this.postForm('/photos/upload', form);
  }
}
