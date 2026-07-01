/*
 * Client dashboard
 * Responsibility: control the client area sections and render client favorite photographers.
 */
document.addEventListener('DOMContentLoaded', () => {
  initializeClientSections();
  renderClientFavorites();
});

function initializeClientSections() {
  const links = document.querySelectorAll('.nav-link[data-secao]');
  const sections = document.querySelectorAll('.app-secao-pagina');

  if (!links.length || !sections.length) return;

  links.forEach(link => {
    link.addEventListener('click', event => {
      event.preventDefault();

      const sectionName = link.dataset.secao;
      const targetSection = document.getElementById(`secao-${sectionName}`);

      if (!targetSection) return;

      links.forEach(item => item.classList.remove('ativo'));
      sections.forEach(section => {
        section.classList.remove('ativo');
        section.style.display = 'none';
      });

      link.classList.add('ativo');
      targetSection.classList.add('ativo');
      targetSection.style.display = 'block';
    });
  });

  // abre primeira aba automaticamente
  links[0].click();
}

function renderClientFavorites() {
  const favoritesContainer = document.getElementById('lista-favoritos');

  if (!favoritesContainer) return;

  if (typeof fotografos === 'undefined' || !Array.isArray(fotografos)) {
    favoritesContainer.innerHTML = '<p style="color:var(--cor-texto-mudo);">Não foi possível carregar seus favoritos.</p>';
    return;
  }

  const favoriteIds = ['lavinia-coimbra', 'julia-mendes'];
  const favorites = fotografos.filter(photographer => favoriteIds.includes(photographer.id));

  if (!favorites.length) {
    favoritesContainer.innerHTML = '<p style="color:var(--cor-texto-mudo);">Você ainda não possui fotógrafos favoritos.</p>';
    return;
  }

  favoritesContainer.innerHTML = favorites.map(photographer => `
    <div class="client-favorite-card">
      <img class="client-favorite-avatar" src="${photographer.fotoAvatar}" alt="Foto de ${photographer.nome}" />
      <div class="client-favorite-info">
        <strong>${photographer.nome}</strong>
        <p>${photographer.cidade}, ${photographer.estado} · ${photographer.especialidade}</p>
      </div>
      <a href="portfolio.html?id=${photographer.id}" class="botao botao-secundario client-favorite-action">Ver portfólio</a>
    </div>
  `).join('');
}
