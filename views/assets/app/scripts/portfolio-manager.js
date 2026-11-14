import Portfolio from '../../_common/classes/Portfolio.js';
import Photo from '../../_common/classes/Photo.js';
import PortfolioService from '../../_common/scripts/services/PortfolioService.js';
import PhotoService from '../../_common/scripts/services/PhotoService.js';

const portfolioService = new PortfolioService();
const photoService = new PhotoService();
let activePortfolio = null;

function currentUser() {
  try { return JSON.parse(localStorage.getItem('user') || 'null'); }
  catch { return null; }
}
function imageUrl(link) {
  const fallback = new URL('assets/_common/images/placeholder.jpeg', document.baseURI).href;
  if (!link) return fallback;
  // Compatível com registros antigos: uploads/..., api/uploads/... e URLs locais.
  let value = String(link).trim().replace(/\\/g, '/');
  try {
    if (/^https?:\/\//i.test(value)) {
      const url = new URL(value);
      if (url.origin !== window.location.origin) return fallback;
      value = url.pathname;
    }
  } catch { return fallback; }
  const match = value.match(/(?:^|\/)uploads\/portfolio\/([a-zA-Z0-9_-]+\.(?:jpg|jpeg|png|webp))(?:[?#].*)?$/i);
  if (!match) return fallback;
  const base = window.location.pathname.includes('/views/')
    ? window.location.pathname.split('/views/')[0] + '/api/'
    : window.location.pathname.replace(/\/[^/]*$/, '/') + 'api/';
  return new URL('uploads/portfolio/' + match[1], window.location.origin + base).href;
}
function useImageFallback(img) {
  img.addEventListener('error', () => {
    const fallback = new URL('assets/_common/images/placeholder.jpeg', document.baseURI).href;
    if (img.src !== fallback) img.src = fallback;
  });
}

function validImage(file) {
  return ['image/jpeg', 'image/png', 'image/webp'].includes(file.type) && file.size > 0 && file.size <= 8 * 1024 * 1024;
}
function showCover() {
  const img = document.getElementById('portfolio-cover-preview');
  if (img) { useImageFallback(img); img.src = imageUrl(activePortfolio?.coverLink); }
}
function notice(message, error = false) {
  const status = document.getElementById('photo-upload-status');
  if (status) { status.textContent = message; status.style.color = error ? '#a33' : 'inherit'; }
  const portfolioStatus = document.getElementById('portfolio-data-status');
  if (portfolioStatus) { portfolioStatus.textContent = message; portfolioStatus.style.color = error ? '#a33' : 'inherit'; }
  if (typeof window.mostrarAviso === 'function') window.mostrarAviso(message, error ? 'erro' : undefined);
}

async function ensurePortfolio() {
  const user = currentUser();
  if (!user?.id) throw new Error('Entre novamente para gerenciar seu portfólio.');
  const own = await portfolioService.listMine();
  let row = own[0];
  if (!row) {
    const created = await portfolioService.create({
      title: `Portfólio de ${user.name || 'fotógrafo'}`,
      description: '',
      cover_link: null
    });
    row = created.data;
  }
  activePortfolio = Portfolio.fromApi(row);
  showCover();
  const title = document.getElementById('portfolio-title');
  const description = document.getElementById('campo-bio-completa');
  if (title) title.value = activePortfolio.title || '';
  if (description) description.value = activePortfolio.description || '';
  return activePortfolio;
}

async function loadGallery() {
  const gallery = document.getElementById('galeria-gerenciar');
  if (!gallery) return;
  gallery.textContent = 'Carregando imagens...';
  try {
    const portfolio = activePortfolio || await ensurePortfolio();
    const rows = await photoService.listByPortfolioId(portfolio.id);
    const photos = rows.map(row => Photo.fromApi(row));
    gallery.replaceChildren();
    if (!photos.length) { gallery.textContent = 'Você ainda não adicionou imagens a este portfólio.'; return; }
    for (const photo of photos) {
      const item = document.createElement('div');
      item.className = 'galeria-item';
      const img = document.createElement('img');
      useImageFallback(img);
      img.src = imageUrl(photo.link);
      img.alt = 'Foto do portfólio';
      img.loading = 'lazy';
      const remove = document.createElement('button');
      remove.type = 'button';
      remove.className = 'galeria-item-remover';
      remove.dataset.id = String(photo.id);
      remove.setAttribute('aria-label', 'Remover fotografia');
      remove.setAttribute('title', 'Remover fotografia');
      remove.innerHTML = '<svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 10v7M14 10v7"/></svg>';
      item.append(img, remove);
      gallery.append(item);
    }
  } catch (error) {
    gallery.textContent = error.message || 'Não foi possível carregar a galeria.';
  }
}

async function savePortfolio(event) {
  event.preventDefault();
  try {
    const portfolio = await ensurePortfolio();
    const updated = new Portfolio({
      id: portfolio.id,
      user_id: portfolio.userId,
      title: document.getElementById('portfolio-title').value.trim(),
      description: document.getElementById('campo-bio-completa').value.trim(),
      cover_link: portfolio.coverLink
    });
    await portfolioService.update(updated.toApi());
    activePortfolio = updated;
    notice('Dados do portfólio salvos.');
  } catch (error) { notice(error.message, true); }
}

async function deletePortfolio() {
  if (!activePortfolio) return;
  if (!confirm('Excluir este portfólio? As fotos deixarão de aparecer publicamente.')) return;
  try {
    await portfolioService.remove(activePortfolio.id);
    activePortfolio = null;
    const gallery = document.getElementById('galeria-gerenciar');
    if (gallery) gallery.innerHTML = '<p>Portfólio excluído. Um novo será criado quando você salvar ou enviar imagens.</p>';
    notice('Portfólio excluído.');
  } catch (error) { notice(error.message, true); }
}

document.addEventListener('DOMContentLoaded', async () => {
  const input = document.getElementById('photo-upload');
  const gallery = document.getElementById('galeria-gerenciar');
  const coverInput = document.getElementById('portfolio-cover-upload');
  coverInput?.addEventListener('change', async () => {
    const file = coverInput.files?.[0];
    if (!file) return;
    if (!validImage(file)) { notice('Capa: use JPG, PNG ou WEBP até 8 MB.', true); coverInput.value = ''; return; }
    const preview = document.getElementById('portfolio-cover-preview');
    const previewUrl = URL.createObjectURL(file);
    if (preview) preview.src = previewUrl;
    coverInput.disabled = true;
    notice('Enviando capa...');
    try {
      const portfolio = activePortfolio || await ensurePortfolio();
      const result = await photoService.uploadCover(file, portfolio.id);
      activePortfolio.coverLink = result.data.cover_link;
      showCover();
      notice('Capa atualizada com sucesso.');
    } catch (error) { showCover(); notice(error.message, true); }
    finally { URL.revokeObjectURL(previewUrl); coverInput.disabled = false; coverInput.value = ''; }
  });
  document.getElementById('portfolio-data-form')?.addEventListener('submit', savePortfolio);
  document.getElementById('portfolio-delete')?.addEventListener('click', deletePortfolio);

  try { await ensurePortfolio(); await loadGallery(); }
  catch (error) { notice(error.message, true); }

  if (input) input.addEventListener('change', async () => {
    const files = Array.from(input.files || []);
    if (!files.length) return;
    const previews = document.getElementById('photo-upload-previews');
    const previewUrls = [];
    if (previews) {
      previews.replaceChildren();
      for (const file of files.filter(validImage)) {
        const url = URL.createObjectURL(file);
        previewUrls.push(url);
        const img = document.createElement('img');
        img.src = url; img.alt = 'Prévia da imagem selecionada';
        img.style.cssText = 'width:96px;height:96px;object-fit:cover;border-radius:8px;margin:6px';
        previews.append(img);
      }
    }
    input.disabled = true;
    notice('Enviando imagens...');
    try {
      const portfolio = activePortfolio || await ensurePortfolio();
      for (const file of files) {
        if (!validImage(file)) { notice(`${file.name}: use JPG, PNG ou WEBP até 8 MB.`, true); continue; }
        try { await photoService.upload(file, portfolio.id); notice(`${file.name} enviada com sucesso.`); }
        catch (error) { notice(`${file.name}: ${error.message}`, true); }
      }
    } catch (error) { notice(error.message, true); }
    input.value = '';
    input.disabled = false;
    previewUrls.forEach(url => URL.revokeObjectURL(url));
    if (previews) previews.replaceChildren();
    await loadGallery();
  });

  if (gallery) gallery.addEventListener('click', async event => {
    const removeButton = event.target.closest('.galeria-item-remover');
    const editButton = event.target.closest('.galeria-item-editar');
    if (removeButton) {
      if (!confirm('Deseja remover esta imagem da galeria?')) return;
      try { await photoService.remove(Number(removeButton.dataset.id)); notice('Imagem removida.'); await loadGallery(); }
      catch (error) { notice(error.message, true); }
    }

  });
});
