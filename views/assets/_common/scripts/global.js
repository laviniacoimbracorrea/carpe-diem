/* ============================================
   Carpe Diem - utilidades gerais + sessão
   ============================================ */

const CARPE_AUTH = {
  get token() { return localStorage.getItem('token') || ''; },
  get user() {
    try { return JSON.parse(localStorage.getItem('user') || 'null'); }
    catch { return null; }
  },
  set user(value) { localStorage.setItem('user', JSON.stringify(value)); },
  clear() {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
  },
  apiBase() {
    return window.location.pathname.includes('/views/') ? '../api' : 'api';
  },
  dashboard(typeId) {
    return {
      1: 'views/admin.html',
      2: 'views/app-fotografo.html',
      3: 'views/app-client.html'
    }[Number(typeId)] || 'views/login.html';
  }
};

async function carpeApi(path, options = {}) {
  const headers = {
    'Accept': 'application/json',
    ...(options.body ? { 'Content-Type': 'application/json' } : {}),
    ...(options.headers || {})
  };

  if (CARPE_AUTH.token) {
    headers.Authorization = `Bearer ${CARPE_AUTH.token}`;
  }

  const response = await fetch(`${CARPE_AUTH.apiBase()}${path}`, {
    ...options,
    headers
  });

  const text = await response.text();
  let result = {};
  try { result = text ? JSON.parse(text) : {}; }
  catch { throw new Error('A API retornou uma resposta inválida.'); }

  if (!response.ok) {
    const error = new Error(result.message || 'Não foi possível concluir a operação.');
    error.status = response.status;
    throw error;
  }

  return result;
}

function salvarSessao(user) {
  if (user?.token) localStorage.setItem('token', user.token);
  if (user) localStorage.setItem('user', JSON.stringify(user));
  atualizarMenuSessao(user);
}

function encerrarSessao(redirecionar = true) {
  CARPE_AUTH.clear();
  atualizarMenuSessao(null);
  if (redirecionar) {
    const isViews = window.location.pathname.includes('/views/');
    window.location.href = isViews ? '../index.html' : 'index.html';
  }
}

function caminhoAtualParaRetorno() {
  const isViews = window.location.pathname.includes('/views/');
  const file = window.location.pathname.split('/').pop() || 'index.html';
  return isViews ? file + window.location.search : '../index.html' + window.location.search;
}

function atualizarMenuSessao(user) {
  const loginLinks = document.querySelectorAll('a[href*="login.html"]');

  loginLinks.forEach(link => {
    const href = link.getAttribute('href') || '';
    if (!link.closest('.sidebar') && !link.closest('.admin-sidebar')) {
      if (user) {
        link.textContent = user.type_id == 1 ? 'Administração' : 'Minha conta';
        link.classList.add('sessao-logada');
        link.href = user.type_id == 1
          ? (window.location.pathname.includes('/views/') ? 'admin.html' : 'views/admin.html')
          : (window.location.pathname.includes('/views/')
            ? (user.type_id == 2 ? 'app-fotografo.html' : 'app-client.html')
            : (user.type_id == 2 ? 'views/app-fotografo.html' : 'views/app-client.html'));
      } else if (!href.includes('return=')) {
        const separator = href.includes('?') ? '&' : '?';
        link.href = `${href}${separator}return=${encodeURIComponent(caminhoAtualParaRetorno())}`;
      }
    }
  });

  // Cria um botão de sair apenas no menu público, sem mexer nos painéis.
  document.querySelectorAll('.menu').forEach(menu => {
    let logout = menu.querySelector('.link-sair-sessao');
    if (user) {
      if (!logout) {
        const li = document.createElement('li');
        logout = document.createElement('a');
        logout.href = '#';
        logout.className = 'botao botao-secundario link-sair-sessao';
        logout.textContent = 'Sair';
        logout.addEventListener('click', event => {
          event.preventDefault();
          encerrarSessao(true);
        });
        li.appendChild(logout);
        menu.appendChild(li);
      }
    } else if (logout) {
      logout.closest('li')?.remove();
    }
  });
}


function urlFotoUsuario(photo) {
  const fallback = window.location.pathname.includes('/views/')
    ? 'assets/_common/images/default-profile.jpg'
    : 'views/assets/_common/images/default-profile.jpg';
  if (!photo) return fallback;
  let value = String(photo).trim().replace(/\\/g, '/');
  try {
    if (/^https?:\/\//i.test(value)) {
      const url = new URL(value);
      if (url.origin !== window.location.origin) return fallback;
      value = url.pathname;
    }
  } catch { return fallback; }
  const match = value.match(/(?:^|\/)uploads\/profiles\/([a-zA-Z0-9_-]+\.(?:jpg|jpeg|png|webp))(?:[?#].*)?$/i);
  if (!match) return fallback;
  const base = window.location.pathname.includes('/views/')
    ? window.location.pathname.split('/views/')[0] + '/api/'
    : window.location.pathname.replace(/\/[^/]*$/, '/') + 'api/';
  return new URL('uploads/profiles/' + match[1], window.location.origin + base).href;
}

async function configurarUploadFotoPerfil(inputId, imageIds) {
  const input = document.getElementById(inputId);
  if (!input || input.dataset.bound === '1') return;
  input.dataset.bound = '1';
  input.addEventListener('change', async () => {
    const file = input.files?.[0];
    if (!file) return;
    if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type) || file.size > 5 * 1024 * 1024) {
      mostrarAviso('Escolha JPG, PNG ou WEBP de até 5 MB.', 'erro');
      input.value = '';
      return;
    }
    try {
      const { default: ProfilePhotoService } = await import('./services/ProfilePhotoService.js');
      const result = await new ProfilePhotoService().upload(file);
      if (!result.data) throw new Error(result.message || 'Não foi possível atualizar a foto.');
      salvarSessao(result.data);
      const url = `${urlFotoUsuario(result.data.photo)}?t=${Date.now()}`;
      imageIds.forEach(id => { const img = document.getElementById(id); if (img) img.src = url; });
      mostrarAviso('Foto de perfil atualizada!');
    } catch (error) {
      mostrarAviso(error.message, 'erro');
    } finally {
      input.value = '';
    }
  });
}

function verificarPerfilCompleto(usuario, tipo) {
  const faltando = ['city', 'state', 'phoneNumber'].filter(campo => !String(usuario?.[campo] || '').trim());
  if (tipo === 2 && !usuario?.specialty_id) faltando.push('specialty_id');
  return faltando.length === 0;
}

async function validarSessao() {
  if (!CARPE_AUTH.token) {
    atualizarMenuSessao(null);
    return null;
  }

  try {
    const result = await carpeApi('/users/me');
    const user = result.data;
    if (!user?.token) throw new Error('Sessão inválida.');
    salvarSessao(user);
    return user;
  } catch (error) {
    // Token expirado, usuário desativado ou sessão inválida.
    CARPE_AUTH.clear();
    atualizarMenuSessao(null);
    return null;
  }
}

// Marca o link ativo do menu com base na página atual
function marcarMenuAtivo() {
  const paginaAtual = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.menu a').forEach(link => {
    const href = link.getAttribute('href');
    if (href && href.split('?')[0].endsWith(paginaAtual)) link.classList.add('ativo');
  });
}

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

document.addEventListener('DOMContentLoaded', async () => {
  marcarMenuAtivo();
  const user = await validarSessao();
  atualizarMenuSessao(user);
});
