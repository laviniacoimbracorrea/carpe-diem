import AuthenticatedHttpClient from './AuthenticatedHttpClient.js';
import { createPrototypePortfolio } from '../../classes/PrototypeEntity.js';

/** CRUD de portfólios. Herda a comunicação HTTP usada pelo projeto de referência. */
export default class PortfolioService extends AuthenticatedHttpClient {
  constructor() { super('../api'); }
  async list() { const r = await this.get('/portfolios/list'); return (r.data || []).map(createPrototypePortfolio); }
  async listMine() { const r = await this.get('/portfolios/mine'); return (r.data || []).map(createPrototypePortfolio); }
  async select(id) { const r = await this.get(`/portfolios/select/${Number(id)}`); return r.data ? createPrototypePortfolio(r.data) : null; }
  async create(data) { return this.post('/portfolios/insert', data); }
  async insert(data) { return this.create(data); }
  async update(data) { return this.put('/portfolios/update', data); }
  async remove(id) { return this.send('DELETE', `/portfolios/delete/${Number(id)}`); }
  async delete(id) { return this.remove(id); }
}
