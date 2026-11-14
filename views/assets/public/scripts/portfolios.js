let portfoliosAtivos = [];

function escaparHTML(value = '') {
  return String(value).replace(/[&<>"']/g, char => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[char]));
}
function urlImagem(link, fallback = 'assets/public/images/Portfolio - Michael & Melanie Photography.jpg') {
  if (!link) return fallback;
  if (/^(https?:|data:)/i.test(link)) return fallback;
  if (!/^uploads\/(portfolio|profiles)\/[a-zA-Z0-9_-]+\.(jpg|png|webp)$/.test(String(link)) && !String(link).startsWith('assets/')) return fallback;
  if (String(link).startsWith('assets/')) return link;
  return `../api/${String(link).replace(/^\//, '')}`;
}
function converterPortfolio(row) {
  return {
    id: String(row.id),
    nome: row.photographer_name || 'Fotógrafo',
    cidade: row.city || '',
    estado: row.state || '',
    especialidade: row.specialty_name || 'Fotografia',
    descricao: row.description || 'Conheça os trabalhos deste fotógrafo.',
    fotoCapa: urlImagem(row.cover_link || row.photographer_photo),
    tags: [row.specialty_name || 'Fotografia']
  };
}

function renderizarCards(lista) {
  const container = document.getElementById('lista-portfolios');
  if (!container) return;
  if (!lista.length) {
    container.innerHTML = '<p style="color:var(--cor-texto-mudo);text-align:center;padding:48px 0;">Nenhum portfólio encontrado com esses filtros.</p>';
    return;
  }
  container.innerHTML = lista.map(f => `
    <a class="card-comprido" href="portfolio.html?id=${encodeURIComponent(f.id)}" style="text-decoration:none;color:inherit;">
      <div class="card-comprido-wrap"><img class="card-comprido-imagem" src="${escaparHTML(f.fotoCapa)}" alt="Portfólio de ${escaparHTML(f.nome)}" loading="lazy"></div>
      <div class="card-comprido-corpo">
        <h3>${escaparHTML(f.nome)}</h3>
        <p class="meta">${escaparHTML([f.cidade, f.estado].filter(Boolean).join(', '))} · ${escaparHTML(f.especialidade)}</p>
        <p>${escaparHTML(f.descricao)}</p>
        <div class="card-comprido-tags">${f.tags.map(t => `<span>${escaparHTML(t)}</span>`).join('')}</div>
      </div>
      <div class="card-comprido-acao"><span class="botao botao-primario">Ver portfólio</span></div>
    </a>`).join('');
}

function aplicarFiltros() {
  const nome = (document.getElementById('filtro-nome')?.value || '').toLowerCase();
  const cidade = document.getElementById('filtro-cidade')?.value || '';
  const especialidade = document.getElementById('filtro-especialidade')?.value || '';
  const resultado = portfoliosAtivos.filter(f =>
    (!nome || f.nome.toLowerCase().includes(nome)) &&
    (!cidade || f.cidade === cidade) &&
    (!especialidade || f.especialidade === especialidade || f.tags.includes(especialidade))
  );
  renderizarCards(resultado);
}
window.aplicarFiltros = aplicarFiltros;

async function carregarPortfolios() {
  const container = document.getElementById('lista-portfolios');
  if (container) container.textContent = 'Carregando portfólios...';
  try {
    const response = await fetch('../api/portfolios/list', { headers: { Accept: 'application/json' } });
    const result = await response.json();
    if (!response.ok) throw new Error(result.message || 'Não foi possível consultar os portfólios.');
    portfoliosAtivos = (result.data || []).map(converterPortfolio);
  } catch (error) {
    // Os dados demonstrativos continuam disponíveis se a API estiver desligada.
    portfoliosAtivos = typeof fotografos !== 'undefined' ? fotografos : [];
    if (container && !portfoliosAtivos.length) container.textContent = error.message;
  }
  renderizarCards(portfoliosAtivos);
}

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('filtro-nome')?.addEventListener('input', aplicarFiltros);
  document.getElementById('filtro-cidade')?.addEventListener('change', aplicarFiltros);
  document.getElementById('filtro-especialidade')?.addEventListener('change', aplicarFiltros);
  carregarPortfolios();
});
