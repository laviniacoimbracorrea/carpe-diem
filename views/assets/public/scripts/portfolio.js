const paramsPortfolio = new URLSearchParams(window.location.search);
const portfolioId = paramsPortfolio.get('id');
const portfolioContainer = document.getElementById('conteudo-portfolio');
let portfolioAtual = null;

function escapePortfolio(value = '') {
  return String(value).replace(/[&<>"']/g, char => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[char]));
}
function portfolioImage(link, fallback = 'assets/_common/images/profiles/lavinia.jpg') {
  if (!link) return fallback;
  if (/^(https?:|data:)/i.test(link)) return link;
  if (String(link).startsWith('assets/')) return link;
  return `../api/${String(link).replace(/^\//, '')}`;
}
async function getJson(url, options = {}) {
  const response = await fetch(url, options);
  const result = await response.json();
  if (!response.ok) throw new Error(result.message || 'Não foi possível carregar os dados.');
  return result.data;
}

async function carregarPortfolio() {
  if (!portfolioContainer) return;
  if (!portfolioId) {
    portfolioContainer.innerHTML = '<p>Portfólio não informado. <a href="portfolios.html">Voltar aos portfólios</a></p>';
    return;
  }
  portfolioContainer.innerHTML = '<p style="padding:60px 0;text-align:center;">Carregando portfólio...</p>';
  try {
    portfolioAtual = await getJson(`../api/portfolios/select/${encodeURIComponent(portfolioId)}`);
    const photos = await getJson(`../api/photos/portfolio/${encodeURIComponent(portfolioId)}`).catch(() => []);
    document.title = `${portfolioAtual.photographer_name || 'Fotógrafo'} | Carpe Diem`;
    const name = portfolioAtual.photographer_name || 'Fotógrafo';
    const specialty = portfolioAtual.specialty_name || 'Fotografia';
    const location = [portfolioAtual.city, portfolioAtual.state].filter(Boolean).join(', ');
    const avatar = portfolioImage(portfolioAtual.photographer_photo, 'assets/_common/images/profiles/lavinia.jpg');
    const gallery = photos.length
      ? photos.map(photo => `<img src="${escapePortfolio(portfolioImage(photo.link))}" alt="Fotografia de ${escapePortfolio(name)}" loading="lazy">`).join('')
      : '<p class="galeria-vazia">Este fotógrafo ainda não adicionou imagens ao portfólio.</p>';

    portfolioContainer.innerHTML = `
      <p style="margin-top:32px;"><a href="portfolios.html" style="font-size:.8rem;letter-spacing:.06em;text-transform:uppercase;color:var(--cor-texto-mudo);">← Portfólios</a></p>
      <div class="cabecalho-fotografo">
        <img class="avatar-fotografo" src="${escapePortfolio(avatar)}" alt="Foto de ${escapePortfolio(name)}">
        <div class="info-fotografo">
          <h1>${escapePortfolio(name)}</h1>
          <span class="especialidade-grande">${escapePortfolio(specialty)}</span>
          <p class="descricao">${escapePortfolio(portfolioAtual.description || 'Conheça o trabalho deste fotógrafo.')}</p>
          <div class="dados-extras"><span>${escapePortfolio(location)}</span></div>
        </div>
      </div>
      <div class="ornamento" style="margin:0 0 18px;"><span class="ornamento-texto">galeria de trabalhos</span></div>
      <div class="galeria">${gallery}</div>
      <div class="bloco-acoes-portfolio">
        <div class="caixa">
          <h3>Avaliar este profissional</h3>
          <div class="estrelas" id="estrelas">☆ ☆ ☆ ☆ ☆</div>
          <textarea id="avaliacao-texto" placeholder="Escreva uma avaliação sobre este fotógrafo..."></textarea>
          <button class="botao botao-primario" id="enviar-avaliacao" type="button">Enviar avaliação</button>
          <p id="status-avaliacao" aria-live="polite"></p>
        </div>
        <div class="caixa">
          <h3>Enviar mensagem para ${escapePortfolio(name.split(' ')[0])}</h3>
          <textarea id="mensagem-para-fotografo" placeholder="Olá, gostaria de saber mais sobre seu trabalho..."></textarea>
          <button id="enviar-mensagem-fotografo" class="botao botao-primario" type="button">Enviar mensagem</button>
          <p id="status-mensagem-fotografo" aria-live="polite"></p>
        </div>
      </div>`;
    configurarInteracoes();
  } catch (error) {
    portfolioContainer.innerHTML = `<div style="text-align:center;padding:80px 0;"><p>${escapePortfolio(error.message)}</p><a href="portfolios.html" class="botao botao-primario">Ver todos os portfólios</a></div>`;
  }
}

function configurarInteracoes() {
  const stars = document.getElementById('estrelas');
  let rating = 0;
  stars?.addEventListener('click', () => {
    rating = rating >= 5 ? 1 : rating + 1;
    stars.textContent = `${'★ '.repeat(rating)}${'☆ '.repeat(5 - rating)}`.trim();
  });
  document.getElementById('enviar-mensagem-fotografo')?.addEventListener('click', async () => {
    const status = document.getElementById('status-mensagem-fotografo');
    const message = document.getElementById('mensagem-para-fotografo')?.value.trim();
    const token = localStorage.getItem('token');
    if (!token) { status.textContent = 'Entre como cliente para enviar uma mensagem.'; return; }
    if (!message) { status.textContent = 'Escreva sua mensagem antes de enviar.'; return; }
    try {
      await getJson('../api/messages/', { method: 'POST', headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${token}`, Accept: 'application/json' }, body: JSON.stringify({ user_photographer_id: portfolioAtual.user_id, message }) });
      document.getElementById('mensagem-para-fotografo').value = '';
      status.textContent = 'Mensagem enviada e salva no histórico!';
    } catch (error) { status.textContent = error.message; }
  });
  document.getElementById('enviar-avaliacao')?.addEventListener('click', () => {
    const status = document.getElementById('status-avaliacao');
    status.textContent = 'O envio de avaliações será conectado ao cadastro de avaliações na próxima integração.';
  });
}

document.addEventListener('DOMContentLoaded', carregarPortfolio);
