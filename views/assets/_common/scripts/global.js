/* ============================================
   Carpe-Diem - Funções utilitárias gerais
   ============================================ */

// Marca o link ativo do menu com base na página atual
document.addEventListener('DOMContentLoaded', () => {
  const paginaAtual = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.menu a').forEach(link => {
    const href = link.getAttribute('href');
    if (href && href.endsWith(paginaAtual)) {
      link.classList.add('ativo');
    }
  });
});

// Função simples para mostrar um aviso na tela (toast)
function mostrarAviso(mensagem, tipo = 'sucesso') {
  const aviso = document.createElement('div');
  aviso.textContent = mensagem;
  aviso.style.cssText = `
    position: fixed; bottom: 24px; right: 24px;
    background: ${tipo === 'erro' ? '#8b3a2a' : '#593E1C'};
    color: #F2E6D8; padding: 14px 22px;
    border-radius: 999px; font-family: 'Inter', sans-serif;
    font-size: 0.9rem; box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    z-index: 1000; opacity: 0; transition: opacity 0.3s;
  `;
  document.body.appendChild(aviso);
  requestAnimationFrame(() => (aviso.style.opacity = '1'));
  setTimeout(() => {
    aviso.style.opacity = '0';
    setTimeout(() => aviso.remove(), 300);
  }, 2800);
}
