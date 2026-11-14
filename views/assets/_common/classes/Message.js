/** Entidade Message para mensagens entre cliente e fotógrafo. */
export default class Message {
  #id;
  #photographerId;
  #userId;
  #message;
  constructor({
    id = null,
    user_photographer_id = null,
    photographerId = null,
    user_id = null,
    userId = null,
    message = ''
  } = {}) {
    this.id = id;
    this.photographerId = photographerId ?? user_photographer_id;
    this.userId = userId ?? user_id;
    this.message = message;
  }
  get id() {
    return this.#id;
  } set id(v) {
    this.#id = v === null ? null : Number(v);
  }
  get photographerId() {
    return this.#photographerId;
  }
  set photographerId(v) {
    this.#photographerId = v === null ? null : Number(v);
  }
  get userId() {
    return this.#userId;
  }
  set userId(v) {
    this.#userId = v === null ? null : Number(v);
  }
  get message() {
    return this.#message;
  }
  set message(v) {
    if (typeof v !== 'string' || !v.trim()) throw new TypeError('A mensagem não pode ficar vazia.');
    this.#message = v.trim();
  }
  toApi() {
    return {
      id: this.id, user_photographer_id: this.photographerId, user_id: this.userId, message: this.message
    };
  }
  static fromApi(data) {
    return new Message(data);

  }
}
