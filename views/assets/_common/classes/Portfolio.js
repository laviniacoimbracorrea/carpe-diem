/** Entidade Portfolio: representa o portfólio público de um fotógrafo. */
export default class Portfolio {
  #id; #userId; #title; #description; #coverLink; #active;
  constructor({ id = null, user_id = null, userId = null, title = 'Meu portfólio', description = '', cover_link = null, coverLink = null, active = 1 } = {}) {
    this.id = id;
    this.userId = userId ?? user_id;
    this.title = title;
    this.description = description;
    this.coverLink = coverLink ?? cover_link;
    this.active = active;
  }
  get id() { return this.#id; }
  set id(value) { this.#id = value == null ? null : Portfolio.positiveId(value, 'ID do portfólio'); }
  get userId() { return this.#userId; }
  set userId(value) { this.#userId = value == null ? null : Portfolio.positiveId(value, 'ID do fotógrafo'); }
  get title() { return this.#title; }
  set title(value) { if (typeof value !== 'string' || !value.trim()) throw new TypeError('O título é obrigatório.'); this.#title = value.trim(); }
  get description() { return this.#description; }
  set description(value) { if (typeof value !== 'string') throw new TypeError('Descrição inválida.'); this.#description = value.trim(); }
  get coverLink() { return this.#coverLink; }
  set coverLink(value) { if (value != null && typeof value !== 'string') throw new TypeError('Capa inválida.'); this.#coverLink = value?.trim() || null; }
  get active() { return this.#active; }
  set active(value) { this.#active = Number(value) === 0 ? 0 : 1; }
  static positiveId(value, label) { const n = Number(value); if (!Number.isInteger(n) || n <= 0) throw new TypeError(`${label} inválido.`); return n; }
  toApi() { return { id: this.id, user_id: this.userId, title: this.title, description: this.description, cover_link: this.coverLink, active: this.active }; }
  static fromApi(data) { return new Portfolio(data); }
}
