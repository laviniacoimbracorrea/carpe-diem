import AuthenticatedHttpClient from './AuthenticatedHttpClient.js';
export default class ContactService extends AuthenticatedHttpClient {
  constructor() { super('../api'); }
  async list() { const r = await this.get('/contacts/list'); return r.data || []; }
  async select(id) { const r = await this.get(`/contacts/list/${Number(id)}`); return r.data; }
  async insert(data) { return this.post('/contacts/', data); }
  async create(data) { return this.insert(data); }
  async update(id, data) { return this.put(`/contacts/${Number(id)}`, data); }
  async remove(id) { return this.send('DELETE', `/contacts/${Number(id)}`); }
  async delete(id) { return this.remove(id); }
}
