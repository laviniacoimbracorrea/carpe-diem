/*
 * Photographer dashboard
 * Controla a navegação interna, o resumo de mensagens e a galeria editável.
 * A tela usa dados locais para evitar atraso visual causado por imagens externas.
 */
document.addEventListener('DOMContentLoaded', () => {
  if (typeof initializeSectionNavigation === 'function') {
    initializeSectionNavigation({ displayMode: 'style' });
  }

  const dashboardMessagesButton = document.querySelector('.dashboard-open-messages');
  const messagesMenuLink = document.querySelector('.sidebar-nav .nav-link[data-secao="mensagens"]');

  if (dashboardMessagesButton && messagesMenuLink) {
    dashboardMessagesButton.addEventListener('click', event => {
      event.preventDefault();
      messagesMenuLink.click();
    });
  }

  renderMessages();
  renderManageGallery();
});

const mensagens = [
  {
    id: 1,
    nome: 'Carlos Henrique',
    assunto: 'Orçamento para casamento em dezembro',
    texto: 'Olá Lavínia! Gostaria de saber sua disponibilidade para um casamento em dezembro de 2026, na Serra Gaúcha. Poderia me passar o pacote de valores?',
    data: '17/05/2026',
    novo: true
  },
  {
    id: 2,
    nome: 'Fernanda Lima',
    assunto: 'Ensaio de gestante — julho',
    texto: 'Adorei seu trabalho! Tenho 6 meses de gestação e adoraria fazer um ensaio externo em julho.',
    data: '16/05/2026',
    novo: true
  },
  {
    id: 3,
    nome: 'Roberto Alves',
    assunto: 'Disponibilidade julho',
    texto: 'Gostaria de fazer um ensaio de família com três crianças. Você teria disponibilidade em julho?',
    data: '14/05/2026',
    novo: true
  },
  {
    id: 4,
    nome: 'Ana Paula',
    assunto: 'Adorei o portfólio!',
    texto: 'Fotos incríveis, já recomendei para três amigas que vão casar esse ano!',
    data: '10/05/2026',
    novo: false
  }
];

function renderMessages() {
  const dashboardBody = document.getElementById('msgs-resumo');
  const inboxBody = document.getElementById('msgs-inbox');

  if (dashboardBody) {
    dashboardBody.innerHTML = mensagens.slice(0, 3).map(message => `
      <tr>
        <td><strong>${message.nome}</strong></td>
        <td>${message.assunto}</td>
        <td>${message.data}</td>
        <td>${message.novo ? '<span class="badge-novo">Novo</span>' : ''}</td>
      </tr>
    `).join('');
  }

  if (inboxBody) {
    inboxBody.innerHTML = mensagens.map(message => `
      <tr>
        <td><strong>${message.nome}</strong></td>
        <td>${message.assunto}</td>
        <td>${message.texto}</td>
        <td>${message.data}</td>
        <td>${message.novo ? '<span class="badge-novo">Novo</span>' : ''}</td>
      </tr>
    `).join('');
  }
}

function renderManageGallery() {
  const galleryElement = document.getElementById('galeria-gerenciar');

  if (!galleryElement || typeof fotografos === 'undefined') return;

  const photographer = fotografos.find(item => item.id === 'lavinia-coimbra');
  if (!photographer || !Array.isArray(photographer.galeria)) return;

  galleryElement.innerHTML = photographer.galeria.map((src, index) => `
    <div class="galeria-item">
      <img src="${src}" alt="Foto ${index + 1}" loading="lazy" />
      <button class="galeria-item-remover" type="button" aria-label="Remover foto">✕</button>
    </div>
  `).join('') + `
    <div class="galeria-add" role="button" tabindex="0">
      <span>+</span><span>Adicionar</span>
    </div>
  `;

  galleryElement.addEventListener('click', event => {
    const removeButton = event.target.closest('.galeria-item-remover');
    const addButton = event.target.closest('.galeria-add');

    if (removeButton) {
      removeButton.closest('.galeria-item').remove();
      mostrarAviso('Foto removida');
    }

    if (addButton) {
      mostrarAviso('Selecione uma imagem para upload');
    }
  });
}
