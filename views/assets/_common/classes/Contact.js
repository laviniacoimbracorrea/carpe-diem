/** Entidade Contact para o registro de contatos enviados pelo usuário. */
export default class Contact {
  #id; #userId; #text;
  constructor({ 
    id = null, user_id = null, userId = null, text = '' } = {}
  ) {
    this.id = id == null ? null : Number(id);
    this.userId = userId ?? user_id;
    this.text = text;
  }
  get id() { return this.#id; }
  set id(value) { this.#id = value == null ? null : Number(value); }
  get userId() { return this.#userId; }
  set userId(value) { this.#userId = value == null ? null : Number(value); }
  get text() { return this.#text; }
  set text(value) { if (typeof value !== 'string' || !value.trim()) throw new TypeError('O contato não pode ficar vazio.'); this.#text = value.trim(); }
  toApi() { return { id: this.id, user_id: this.userId, text: this.text }; }
  static fromApi(data) { return new Contact(data); }
}
