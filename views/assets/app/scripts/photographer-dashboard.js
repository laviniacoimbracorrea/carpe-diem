/*
 * Photographer dashboard
 * Controla a navegação interna, o resumo de mensagens e a galeria editável.
 * A tela usa dados locais para evitar atraso visual causado por imagens externas.
 */
document.addEventListener('DOMContentLoaded', async () => {
  const user = await validarSessao();
  if (!user || Number(user.type_id) !== 2) {
    window.location.replace('login.html?aba=fotografo');
    return;
  }

  carregarPerfilFotografo();
  configurarUploadFotoPerfil('foto-perfil-fotografo', ['perfil-avatar-fotografo', 'sidebar-avatar-fotografo']);

  if (typeof initializeSectionNavigation === 'function') {
    initializeSectionNavigation({ displayMode: 'style' });
  }
  aplicarBloqueioPerfilFotografo(user);

  const dashboardMessagesButton = document.querySelector('.dashboard-open-messages');
  const messagesMenuLink = document.querySelector('.sidebar-nav .nav-link[data-secao="mensagens"]');

  if (dashboardMessagesButton && messagesMenuLink) {
    dashboardMessagesButton.addEventListener('click', event => {
      event.preventDefault();
      messagesMenuLink.click();
    });
  }

  await carregarMensagens();
});

let mensagens = [];

async function carregarMensagens() {
  try {
    const result = await carpeApi('/messages/list');
    mensagens = Array.isArray(result.data) ? result.data : [];
  } catch (error) {
    mensagens = [];
    mostrarAviso(error.message || 'Não foi possível carregar as mensagens.', 'erro');
  }
  renderMessages();
}

function renderMessages() {
  const dashboardBody = document.getElementById('msgs-resumo');
  const inboxBody = document.getElementById('msgs-inbox');

  if (dashboardBody) {
    dashboardBody.innerHTML = mensagens.slice(0, 3).map(message => `
      <tr>
        <td><strong>${message.sender_name || 'Cliente'}</strong></td>
        <td>Mensagem recebida</td>
        <td>${message.created_at ? new Date(message.created_at.replace(' ', 'T')).toLocaleDateString('pt-BR') : 'Sem data'}</td>
        <td></td>
      </tr>
    `).join('');
  }

  if (inboxBody) {
    inboxBody.innerHTML = mensagens.map(message => `
      <tr>
        <td><strong>${message.sender_name || 'Cliente'}</strong></td>
        <td>Mensagem recebida</td>
        <td>${message.message || ''}</td>
        <td>${message.created_at ? new Date(message.created_at.replace(' ', 'T')).toLocaleDateString('pt-BR') : 'Sem data'}</td>
        <td></td>
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


function carregarPerfilFotografo() {
  const usuario = CARPE_AUTH.user;
  if (!usuario) return;
  const avatarUrl = urlFotoUsuario(usuario.photo);
  ['perfil-avatar-fotografo', 'sidebar-avatar-fotografo'].forEach(id => { const img = document.getElementById(id); if (img) img.src = avatarUrl; });

  const inputs = document.querySelectorAll('#form-perfil-fotografo input, #form-perfil-fotografo select');
  const nome = document.getElementById('perfil-fotografo-nome');
  const email = document.getElementById('perfil-fotografo-email');
  const cidade = document.getElementById('perfil-fotografo-cidade');
  const estado = document.getElementById('perfil-fotografo-estado');
  const telefone = document.getElementById('perfil-fotografo-telefone');
  const especialidade = document.getElementById('perfil-fotografo-especialidade');

  if (nome) nome.value = usuario.name || '';
  if (email) email.value = usuario.email || '';
  if (cidade) cidade.value = usuario.city || '';
  if (estado) estado.value = usuario.state || '';
  if (telefone) telefone.value = usuario.phoneNumber || '';
  if (especialidade && usuario.specialty_id) especialidade.value = String(usuario.specialty_id);

  const sidebar = document.querySelector('.sidebar-nome');
  const heading = document.querySelector('#secao-dashboard .app-cabecalho h1');
  if (sidebar) sidebar.textContent = usuario.name || 'Fotógrafo';
  if (heading) heading.textContent = `Olá, ${usuario.name || 'Fotógrafo'}`;

  if (especialidade) {
    fetch('../api/specialties/list')
      .then(response => response.json())
      .then(result => {
        if (!Array.isArray(result.data)) throw new Error('Especialidades indisponíveis.');
        especialidade.innerHTML = '<option value="">Selecione...</option>' + result.data.map(item => `<option value="${item.id}">${item.type}</option>`).join('');
        if (usuario.specialty_id) especialidade.value = String(usuario.specialty_id);
      })
      .catch(error => mostrarAviso(error.message, 'erro'));
  }

  const form = document.getElementById('form-perfil-fotografo');
  if (form && !form.dataset.bound) {
    form.dataset.bound = '1';
    form.addEventListener('submit', async event => {
      event.preventDefault();
      try {
        const result = await carpeApi('/users/photographer', {
          method: 'PUT',
          body: JSON.stringify({
            name: nome.value.trim(),
            email: email.value.trim(),
            city: cidade.value.trim(),
            state: estado.value,
            phone_number: telefone.value.trim(),
            specialty_id: Number(especialidade.value)
          })
        });
        salvarSessao(result.data);
        carregarPerfilFotografo();
        aplicarBloqueioPerfilFotografo(result.data);
        mostrarAviso(result.message || 'Perfil salvo com sucesso!');
      } catch (error) {
        mostrarAviso(error.message, 'erro');
      }
    });
  }

  const senhaForm = document.getElementById('form-senha-fotografo');
  if (senhaForm && !senhaForm.dataset.bound) {
    senhaForm.dataset.bound = '1';
    senhaForm.addEventListener('submit', async event => {
      event.preventDefault();
      const nova = document.getElementById('nova-senha-fotografo').value;
      const confirmar = document.getElementById('confirmar-senha-fotografo').value;
      if (!nova || nova !== confirmar) {
        mostrarAviso('As novas senhas não conferem.', 'erro');
        return;
      }
      try {
        const result = await carpeApi('/users/photographer', {
          method: 'PUT',
          body: JSON.stringify({
            name: nome.value.trim(),
            email: email.value.trim(),
            city: cidade.value.trim(),
            state: estado.value,
            phone_number: telefone.value.trim(),
            specialty_id: Number(especialidade.value),
            password: nova
          })
        });
        salvarSessao(result.data);
        senhaForm.reset();
        mostrarAviso('Senha alterada com sucesso!');
      } catch (error) {
        mostrarAviso(error.message, 'erro');
      }
    });
  }
}


function aplicarBloqueioPerfilFotografo(usuario) {
  const completo = verificarPerfilCompleto(usuario, 2);
  const links = document.querySelectorAll('.sidebar-nav .nav-link[data-secao]');
  if (!completo) {
    const aviso = document.getElementById('aviso-perfil-obrigatorio') || document.createElement('div');
    aviso.id = 'aviso-perfil-obrigatorio';
    aviso.className = 'aviso-tipo';
    aviso.textContent = 'Complete cidade, estado, telefone e especialidade no seu perfil para liberar as demais áreas.';
    document.querySelector('#secao-perfil .app-cabecalho')?.after(aviso);
    links.forEach(link => {
      if (link.dataset.secao !== 'perfil') {
        link.addEventListener('click', bloquearAcessoPerfil, true);
        link.setAttribute('aria-disabled', 'true');
        link.style.opacity = '.5';
      }
    });
    document.querySelector('.sidebar-nav .nav-link[data-secao="perfil"]')?.click();
  } else {
    document.getElementById('aviso-perfil-obrigatorio')?.remove();
    links.forEach(link => {
      link.removeEventListener('click', bloquearAcessoPerfil, true);
      link.removeAttribute('aria-disabled');
      link.style.opacity = '';
    });
  }
}
function bloquearAcessoPerfil(event) {
  event.preventDefault(); event.stopImmediatePropagation();
  mostrarAviso('Antes, complete os dados obrigatórios do seu perfil.', 'erro');
}
