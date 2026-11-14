/** Entidade Photo: representa uma imagem pertencente a um portfólio. */
export default class Photo {
  #id; #portfolioId; #link; #active;
  constructor({ id = null, portfolio_id = null, portfolioId = null, link = '', active = 1 } = {}) {
    this.id = id;
    this.portfolioId = portfolioId ?? portfolio_id;
    this.link = link;
    this.active = active;
  }
  get id() { return this.#id; }
  set id(value) { this.#id = value == null ? null : Photo.positiveId(value, 'ID da foto'); }
  get portfolioId() { return this.#portfolioId; }
  set portfolioId(value) { this.#portfolioId = value == null ? null : Photo.positiveId(value, 'ID do portfólio'); }
  get link() { return this.#link; }
  set link(value) { if (typeof value !== 'string' || !value.trim()) throw new TypeError('O caminho da imagem é obrigatório.'); this.#link = value.trim(); }
  get active() { return this.#active; }
  set active(value) { this.#active = Number(value) === 0 ? 0 : 1; }
  static positiveId(value, label) { const n = Number(value); if (!Number.isInteger(n) || n <= 0) throw new TypeError(`${label} inválido.`); return n; }
  toApi() { return { id: this.id, portfolio_id: this.portfolioId, link: this.link, active: this.active }; }
  static fromApi(data) { return new Photo(data); }
}
