import AuthenticatedHttpClient from './AuthenticatedHttpClient.js';
export default class MessageService extends AuthenticatedHttpClient {
  constructor() { super('../api'); }
  async list() { const r = await this.get('/messages/list'); return r.data || []; }
  async select(id) { const r = await this.get(`/messages/list/${Number(id)}`); return r.data; }
  async insert(data) { return this.post('/messages/', data); }
  async create(data) { return this.insert(data); }
  async update(id, data) { return this.put(`/messages/${Number(id)}`, data); }
  async remove(id) { return this.send('DELETE', `/messages/${Number(id)}`); }
  async delete(id) { return this.remove(id); }
}
