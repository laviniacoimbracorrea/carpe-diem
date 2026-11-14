/** Entidade Faq para perguntas frequentes. */
export default class Faq {
  #id;
  #categoryId;
  #question;
  #answer;
  constructor({
    id = null,
    faqs_category_id = null,
    categoryId = null,
    question = '', answer = ''} = {}
  ) {
    this.id = id;
    this.categoryId = categoryId ?? faqs_category_id;
    this.question = question;
    this.answer = answer;
  }
  get id() {
    return this.#id;
  }
  set id(v) {
    this.#id = v === null ? null : Number(v);
  }

  get categoryId() {
    return this.#categoryId;
  }
  set categoryId(v) {
    this.#categoryId = v === null ? null : Number(v);
  }

  get question() {
    return this.#question;
  }
  set question(v) {
    if (typeof v !== 'string' || !v.trim()) throw new TypeError('A pergunta é obrigatória.');
    this.#question = v.trim();
  }
  get answer() {
    return this.#answer;
  }

  set answer(v) {
    if (typeof v !== 'string' || !v.trim()) throw new TypeError('A resposta é obrigatória.');
    this.#answer = v.trim();
  }
  toApi() {
    return {
      id: this.id, faqs_category_id: this.categoryId,
      question: this.question, answer: this.answer
    };
  }
  static fromApi(data) { return new Faq(data); }
}
