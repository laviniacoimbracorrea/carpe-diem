import AuthenticatedHttpClient from './AuthenticatedHttpClient.js';
export default class FaqService extends AuthenticatedHttpClient {
  constructor() { super('../api'); }
  async list() { const r = await this.get('/faqs/list'); return r.data || []; }
  async select(id) { const r = await this.get(`/faqs/select/${Number(id)}`); return r.data; }
  async insert(data) { return this.post('/faqs/insert', data); }
  async create(data) { return this.insert(data); }
  async update(data) { return this.put('/faqs/update', data); }
  async remove(id) { return this.send('DELETE', `/faqs/delete/${Number(id)}`); }
  async delete(id) { return this.remove(id); }
}
