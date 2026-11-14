/*
 * Client dashboard
 * Responsabilidade:
 * controlar as seções do cliente,
 * carregar os dados do usuário
 * e mostrar os favoritos.
 */

document.addEventListener('DOMContentLoaded', async () => {

  const user = await validarSessao();
  if (!user || Number(user.type_id) !== 3) {
    window.location.replace('login.html?aba=cliente');
    return;
  }

  initializeClientSections();
  renderClientFavorites();
  carregarDadosDoCliente();
  carregarHistoricoMensagensCliente();
  configurarUploadFotoPerfil('foto-perfil-cliente', ['perfil-avatar-cliente', 'sidebar-avatar-cliente']);
  aplicarBloqueioPerfilIncompleto(user, 3);

});


/*
 * =====================================================
 * SEÇÕES DO CLIENTE
 * =====================================================
 */

function initializeClientSections() {

  const links =
    document.querySelectorAll(
      '.nav-link[data-secao]'
    );

  const sections =
    document.querySelectorAll(
      '.app-secao-pagina'
    );

  if (!links.length || !sections.length) {
    return;
  }

  links.forEach(link => {

    link.addEventListener(
      'click',
      event => {

        event.preventDefault();

        const sectionName =
          link.dataset.secao;

        const targetSection =
          document.getElementById(
            `secao-${sectionName}`
          );

        if (!targetSection) {
          return;
        }

        links.forEach(item => {
          item.classList.remove('ativo');
        });

        sections.forEach(section => {

          section.classList.remove('ativo');

          section.style.display = 'none';

        });

        link.classList.add('ativo');

        targetSection.classList.add('ativo');

        targetSection.style.display = 'block';

      }
    );

  });

  links[0].click();

}


/*
 * =====================================================
 * CARREGAR DADOS DO USUÁRIO
 * =====================================================
 */

function carregarDadosDoCliente() {
  const usuario = CARPE_AUTH.user;
  if (!usuario) return;

  const nome = document.getElementById('perfil-nome');
  const email = document.getElementById('perfil-email');
  const cidade = document.getElementById('perfil-cidade');
  const estado = document.getElementById('perfil-estado');
  const telefone = document.getElementById('perfil-telefone');

  if (nome) nome.value = usuario.name || '';
  if (email) email.value = usuario.email || '';
  if (cidade) cidade.value = usuario.city || '';
  if (estado) estado.value = usuario.state || '';
  if (telefone) telefone.value = usuario.phoneNumber || '';
  const avatar = urlFotoUsuario(usuario.photo);
  ['perfil-avatar-cliente', 'sidebar-avatar-cliente'].forEach(id => { const img = document.getElementById(id); if (img) img.src = avatar; });

  const nomeSidebar = document.querySelector('.sidebar-nome');
  if (nomeSidebar) nomeSidebar.textContent = usuario.name || 'Usuário';

  const formPerfil = document.getElementById('form-perfil-cliente');
  if (formPerfil && !formPerfil.dataset.bound) {
    formPerfil.dataset.bound = '1';
    formPerfil.addEventListener('submit', async event => {
      event.preventDefault();
      try {
        const result = await carpeApi('/users/client', {
          method: 'PUT',
          body: JSON.stringify({
            name: nome.value.trim(),
            email: email.value.trim(),
            city: cidade.value.trim(),
            state: estado.value,
            phone_number: telefone.value.trim()
          })
        });
        salvarSessao(result.data);
        carregarDadosDoCliente();
        aplicarBloqueioPerfilIncompleto(result.data, 3);
        mostrarAviso(result.message || 'Perfil salvo com sucesso!');
      } catch (error) {
        mostrarAviso(error.message, 'erro');
      }
    });
  }

  const formSenha = document.getElementById('form-senha-cliente');
  if (formSenha && !formSenha.dataset.bound) {
    formSenha.dataset.bound = '1';
    formSenha.addEventListener('submit', async event => {
      event.preventDefault();
      const nova = document.getElementById('nova-senha-cliente').value;
      const confirmar = document.getElementById('confirmar-senha-cliente').value;
      if (!nova || nova !== confirmar) {
        mostrarAviso('As novas senhas não conferem.', 'erro');
        return;
      }
      try {
        const result = await carpeApi('/users/client', {
          method: 'PUT',
          body: JSON.stringify({
            name: nome.value.trim(),
            email: email.value.trim(),
            city: cidade.value.trim(),
            state: estado.value,
            phone_number: telefone.value.trim(),
            password: nova
          })
        });
        salvarSessao(result.data);
        formSenha.reset();
        mostrarAviso('Senha alterada com sucesso!');
      } catch (error) {
        mostrarAviso(error.message, 'erro');
      }
    });
  }
}


/*
 * =====================================================
 * FAVORITOS
 * =====================================================
 */

function renderClientFavorites() {

  const favoritesContainer =
    document.getElementById(
      'lista-favoritos'
    );

  if (!favoritesContainer) {
    return;
  }

  if (
    typeof fotografos === 'undefined' ||
    !Array.isArray(fotografos)
  ) {

    favoritesContainer.innerHTML =
      '<p style="color:var(--cor-texto-mudo);">' +
      'Não foi possível carregar seus favoritos.' +
      '</p>';

    return;
  }

  const favoriteIds = [
    'lavinia-coimbra',
    'julia-mendes'
  ];

  const favorites =
    fotografos.filter(
      photographer =>
        favoriteIds.includes(
          photographer.id
        )
    );


  if (!favorites.length) {

    favoritesContainer.innerHTML =
      '<p style="color:var(--cor-texto-mudo);">' +
      'Você ainda não possui fotógrafos favoritos.' +
      '</p>';

    return;
  }


  favoritesContainer.innerHTML =
    favorites
      .map(photographer => `

        <div class="client-favorite-card">

          <img
            class="client-favorite-avatar"
            src="${photographer.fotoAvatar}"
            alt="Foto de ${photographer.nome}"
          />

          <div class="client-favorite-info">

            <strong>
              ${photographer.nome}
            </strong>

            <p>
              ${photographer.cidade},
              ${photographer.estado}
              ·
              ${photographer.especialidade}
            </p>

          </div>

          <a
            href="portfolio.html?id=${photographer.id}"
            class="botao botao-secundario client-favorite-action"
          >
            Ver portfólio
          </a>

        </div>

      `)
      .join('');

}

function aplicarBloqueioPerfilIncompleto(usuario, tipo) {
  const completo = verificarPerfilCompleto(usuario, tipo);
  const links = document.querySelectorAll('.sidebar-nav .nav-link[data-secao]');
  if (!completo) {
    const aviso = document.getElementById('aviso-perfil-obrigatorio') || document.createElement('div');
    aviso.id = 'aviso-perfil-obrigatorio';
    aviso.className = 'aviso-tipo';
    aviso.textContent = 'Complete cidade, estado e telefone no seu perfil para liberar as demais áreas da conta.';
    const perfilSection = document.getElementById('secao-perfil');
    perfilSection?.querySelector('.app-cabecalho')?.after(aviso);
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
  event.preventDefault();
  event.stopImmediatePropagation();
  mostrarAviso('Antes, complete os dados obrigatórios do seu perfil.', 'erro');
}


async function carregarHistoricoMensagensCliente() {
  const tbody = document.getElementById('mensagens-cliente-lista');
  if (!tbody) return;
  try {
    const result = await carpeApi('/messages/list');
    const messages = Array.isArray(result.data) ? result.data : [];
    if (!messages.length) {
      tbody.innerHTML = '<tr><td colspan="3">Você ainda não enviou mensagens.</td></tr>';
      return;
    }
    tbody.innerHTML = '';
    messages.forEach(message => {
      const tr = document.createElement('tr');
      const photographer = document.createElement('td');
      const content = document.createElement('td');
      const date = document.createElement('td');
      photographer.textContent = message.sender_name || 'Fotógrafo';
      content.textContent = message.message || '';
      date.textContent = message.created_at ? new Date(message.created_at.replace(' ', 'T')).toLocaleString('pt-BR') : 'Sem data';
      tr.append(photographer, content, date);
      tbody.appendChild(tr);
    });
  } catch (error) {
    tbody.innerHTML = '<tr><td colspan="3">Não foi possível carregar o histórico.</td></tr>';
  }
}
