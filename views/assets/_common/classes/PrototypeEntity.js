/**
 * Exemplo funcional de POO baseada em protótipos (Object.create).
 * É separado das classes ES6 para demonstrar os dois modelos de herança.
 */
export function PrototypeEntity(data = {}) {
  Object.assign(this, data);
}
PrototypeEntity.prototype.toObject = function () {
  return { ...this };
};

export function PrototypePortfolio(data = {}) {
  PrototypeEntity.call(this, data);
}
PrototypePortfolio.prototype = Object.create(PrototypeEntity.prototype);
Object.defineProperty(PrototypePortfolio.prototype, 'constructor', {
  value: PrototypePortfolio,
  writable: true,
  configurable: true
});
PrototypePortfolio.prototype.getDisplayTitle = function () {
  return String(this.title || 'Meu portfólio').trim();
};
PrototypePortfolio.prototype.toApi = function () {
  return {
    id: this.id ?? null,
    user_id: this.user_id ?? this.userId ?? null,
    title: this.getDisplayTitle(),
    description: String(this.description || ''),
    cover_link: this.cover_link ?? this.coverLink ?? null
  };
};

export function createPrototypePortfolio(data) {
  return Object.create(PrototypePortfolio.prototype, {
    id: { value: data.id ?? null, writable: true, enumerable: true },
    user_id: { value: data.user_id ?? data.userId ?? null, writable: true, enumerable: true },
    title: { value: data.title || 'Meu portfólio', writable: true, enumerable: true },
    description: { value: data.description || '', writable: true, enumerable: true },
    cover_link: { value: data.cover_link ?? data.coverLink ?? null, writable: true, enumerable: true }
  });
}
