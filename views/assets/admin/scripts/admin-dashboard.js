let usuariosAdmin = [];

 document.addEventListener('DOMContentLoaded', async () => {
  const user = await validarSessao();
  if (!user || Number(user.type_id) !== 1) {
    window.location.replace('login.html?aba=administrador');
    return;
  }

  inicializarNavegacaoAdmin();
  preencherPerfilAdmin(user);
  await carregarUsuariosAdmin();
  await carregarGestaoFaqs();
  inicializarFormularioPerfilAdmin();
  inicializarBuscaFotografos();
});

function inicializarNavegacaoAdmin() {
  document.querySelectorAll('.admin-nav-link').forEach(link => {
    link.addEventListener('click', event => {
      event.preventDefault();
      document.querySelectorAll('.admin-nav-link').forEach(item => item.classList.remove('ativo'));
      document.querySelectorAll('.app-secao-pagina').forEach(section => section.classList.remove('ativo'));
      link.classList.add('ativo');
      const target = document.getElementById('secao-' + link.dataset.secao);
      if (target) target.classList.add('ativo');
    });
  });
}

function preencherPerfilAdmin(user) {
  const fields = {
    'perfil-admin-nome': user.name || '',
    'perfil-admin-email': user.email || '',
    'perfil-admin-cidade': user.city || '',
    'perfil-admin-estado': user.state || '',
    'perfil-admin-telefone': user.phoneNumber || ''
  };
  Object.entries(fields).forEach(([id, value]) => {
    const el = document.getElementById(id);
    if (el) el.value = value;
  });
}

function inicializarFormularioPerfilAdmin() {
  const form = document.getElementById('form-perfil-admin');
  if (!form) return;
  form.addEventListener('submit', async event => {
    event.preventDefault();
    try {
      const result = await carpeApi('/users/admin', {
        method: 'PUT',
        body: JSON.stringify({
          name: document.getElementById('perfil-admin-nome').value.trim(),
          email: document.getElementById('perfil-admin-email').value.trim(),
          city: document.getElementById('perfil-admin-cidade').value.trim(),
          state: document.getElementById('perfil-admin-estado').value.trim(),
          phone_number: document.getElementById('perfil-admin-telefone').value.trim(),
          password: document.getElementById('perfil-admin-senha').value
        })
      });
      salvarSessao(result.data);
      document.getElementById('perfil-admin-senha').value = '';
      preencherPerfilAdmin(result.data);
      await carregarUsuariosAdmin();
      mostrarAviso(result.message || 'Perfil atualizado.');
    } catch (error) {
      mostrarAviso(error.message, 'erro');
    }
  });
}

async function carregarUsuariosAdmin() {
  try {
    const result = await carpeApi('/users/admin/users');
    usuariosAdmin = result.data?.users || [];
    renderizarUsuarios();
  } catch (error) {
    console.error(error);
    mostrarAviso(error.message, 'erro');
  }
}

function formatarUltimoLogin(value) {
  if (!value) return 'Ainda não entrou';
  const date = new Date(value.replace(' ', 'T'));
  if (Number.isNaN(date.getTime())) return value;
  return date.toLocaleString('pt-BR');
}

function escapeHtml(value) {
  return String(value ?? '').replace(/[&<>'"]/g, char => ({
    '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;'
  }[char]));
}

function acaoStatus(user) {
  const ativo = Number(user.active) === 1;
  return `<button class="btn-acao ${ativo ? 'vermelho' : 'verde'}" onclick="alterarStatusUsuario(${user.id}, ${ativo ? 0 : 1})">${ativo ? 'Desativar' : 'Ativar'}</button>`;
}

function linhaUsuario(user, incluirEspecialidade = false) {
  const ativo = Number(user.active) === 1;
  return `<tr>
    <td><strong>${escapeHtml(user.name)}</strong></td>
    <td>${escapeHtml(user.email)}</td>
    ${incluirEspecialidade ? `<td>${escapeHtml(user.city)}, ${escapeHtml(user.state)}</td><td>${escapeHtml(user.specialty_name || 'Não informado')}</td>` : ''}
    <td>${escapeHtml(formatarUltimoLogin(user.last_login_at))}</td>
    <td><span class="badge ${ativo ? 'badge-aprovado' : 'badge-rascunho'}">${ativo ? 'Ativo' : 'Desativado'}</span></td>
    <td><div class="acoes-tabela">${acaoStatus(user)}</div></td>
  </tr>`;
}

function renderizarUsuarios() {
  const fotografos = usuariosAdmin.filter(u => Number(u.type_id) === 2);
  const clientes = usuariosAdmin.filter(u => Number(u.type_id) === 3);
  const admins = usuariosAdmin.filter(u => Number(u.type_id) === 1);
  const pendentes = fotografos.filter(u => Number(u.approval_status) === 0);
  const fotografosAtivos = fotografos.filter(u => Number(u.approval_status) === 1 && Number(u.active) === 1);
  const logados = usuariosAdmin.filter(u => u.last_login_at);

  document.getElementById('stat-fotografos')?.replaceChildren(document.createTextNode(String(fotografosAtivos.length)));
  document.getElementById('stat-aguardando')?.replaceChildren(document.createTextNode(String(pendentes.length)));
  document.getElementById('stat-clientes')?.replaceChildren(document.createTextNode(String(clientes.length)));
  document.getElementById('stat-logins')?.replaceChildren(document.createTextNode(String(logados.length)));

  const badgePendentes = document.getElementById('badge-pendentes-fotografos');
  if (badgePendentes) badgePendentes.textContent = `${pendentes.length} ${pendentes.length === 1 ? 'pendente' : 'pendentes'}`;

  const tabelaPendentes = document.getElementById('tabela-pendentes-fotografos');
  if (tabelaPendentes) {
    tabelaPendentes.innerHTML = pendentes.map(u => `
      <tr>
        <td><strong>${escapeHtml(u.name)}</strong><br><span style="font-size:0.78rem;color:var(--cor-texto-mudo);">${escapeHtml(u.email)}</span></td>
        <td>${escapeHtml(u.city)}, ${escapeHtml(u.state)}</td>
        <td>${escapeHtml(u.specialty_name || 'Não informado')}</td>
        <td>${escapeHtml(formatarDataCadastro(u.created_at))}</td>
        <td><div class="acoes-tabela">
          <button class="btn-acao verde" onclick="decidirFotografo(${u.id}, 1)">Aprovar</button>
          <button class="btn-acao vermelho" onclick="decidirFotografo(${u.id}, 2)">Recusar</button>
        </div></td>
      </tr>`).join('') || '<tr><td colspan="5">Nenhuma requisição pendente.</td></tr>';
  }

  const tabelaFotografos = document.getElementById('tabela-fotografos-completa');
  if (tabelaFotografos) {
    tabelaFotografos.innerHTML = `<thead><tr><th>Fotógrafo</th><th>E-mail</th><th>Localização</th><th>Especialidade</th><th>Último login</th><th>Status</th><th>Ações</th></tr></thead><tbody>${fotografos.map(u => linhaUsuario(u, true)).join('') || '<tr><td colspan="7">Nenhum fotógrafo cadastrado.</td></tr>'}</tbody>`;
  }

  const tabelaAtivos = document.getElementById('tabela-ativos');
  if (tabelaAtivos) {
    tabelaAtivos.innerHTML = `<thead><tr><th>Fotógrafo</th><th>E-mail</th><th>Localização</th><th>Especialidade</th><th>Último login</th><th>Status</th><th>Ações</th></tr></thead><tbody>${fotografosAtivos.map(u => linhaUsuario(u, true)).join('') || '<tr><td colspan="7">Nenhum fotógrafo ativo.</td></tr>'}</tbody>`;
  }

  const tabelaClientes = document.getElementById('tabela-clientes');
  if (tabelaClientes) {
    tabelaClientes.innerHTML = clientes.map(u => `<tr><td><strong>${escapeHtml(u.name)}</strong></td><td>${escapeHtml(u.email)}</td><td>${escapeHtml(u.city)}, ${escapeHtml(u.state)}</td><td>${escapeHtml(formatarUltimoLogin(u.last_login_at))}</td><td><span class="badge ${Number(u.active) === 1 ? 'badge-aprovado' : 'badge-rascunho'}">${Number(u.active) === 1 ? 'Ativo' : 'Desativado'}</span></td><td><div class="acoes-tabela">${acaoStatus(u)}</div></td></tr>`).join('') || '<tr><td colspan="6">Nenhum cliente cadastrado.</td></tr>';
  }

  const tabelaAdmins = document.getElementById('tabela-admins');
  if (tabelaAdmins) {
    tabelaAdmins.innerHTML = admins.map(u => `<tr><td><strong>${escapeHtml(u.name)}</strong></td><td>${escapeHtml(u.email)}</td><td>${escapeHtml(formatarUltimoLogin(u.last_login_at))}</td><td><span class="badge ${Number(u.active) === 1 ? 'badge-aprovado' : 'badge-rascunho'}">${Number(u.active) === 1 ? 'Ativo' : 'Desativado'}</span></td><td><div class="acoes-tabela">${acaoStatus(u)}</div></td></tr>`).join('') || '<tr><td colspan="5">Nenhum administrador cadastrado.</td></tr>';
  }
}

function formatarDataCadastro(value) {
  if (!value) return 'Data não informada';
  const date = new Date(String(value).replace(' ', 'T'));
  if (Number.isNaN(date.getTime())) return value;
  return date.toLocaleDateString('pt-BR');
}

async function decidirFotografo(id, approval_status) {
  const acao = approval_status === 1 ? 'aprovar' : 'recusar';
  if (!confirm(`Tem certeza que deseja ${acao} este fotógrafo?`)) return;

  try {
    const result = await carpeApi('/users/admin/photographer-approval', {
      method: 'PUT',
      body: JSON.stringify({ id, approval_status })
    });
    mostrarAviso(result.message || 'Decisão registrada.');
    await carregarUsuariosAdmin();
  } catch (error) {
    mostrarAviso(error.message, 'erro');
  }
}

async function alterarStatusUsuario(id, active) {
  const acao = active === 1 ? 'ativar' : 'desativar';
  if (!confirm(`Tem certeza que deseja ${acao} este usuário?`)) return;
  try {
    const result = await carpeApi('/users/admin/user-status', {
      method: 'PUT',
      body: JSON.stringify({ id, active })
    });
    mostrarAviso(result.message || 'Status atualizado.');
    await carregarUsuariosAdmin();
  } catch (error) {
    mostrarAviso(error.message, 'erro');
  }
}

function inicializarBuscaFotografos() {
  const input = document.getElementById('busca-fotografos');
  if (!input) return;
  input.addEventListener('input', () => {
    const q = input.value.toLowerCase().trim();
    const rows = document.querySelectorAll('#tabela-fotografos-completa tbody tr');
    rows.forEach(row => row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none');
  });
}

// Gestão de FAQs integrada à API e ao banco de dados.
let categoriasFaq = [];
let faqsAdmin = [];

async function carregarGestaoFaqs() {
  try {
    const [categoriasResult, faqsResult] = await Promise.all([
      carpeApi('/faqscategories/list'),
      carpeApi('/faqs/admin/list')
    ]);
    categoriasFaq = Array.isArray(categoriasResult.data) ? categoriasResult.data : [];
    faqsAdmin = Array.isArray(faqsResult.data) ? faqsResult.data : [];
    preencherCategoriasFaq();
    renderizarFaqsAdmin();
  } catch (error) {
    console.error('Erro ao carregar gestão de FAQs:', error);
    const tbody = document.getElementById('tabela-faqs');
    if (tbody) tbody.innerHTML = `<tr><td colspan="4">${escapeHtml(error.message || 'Erro ao carregar FAQs.')}</td></tr>`;
    mostrarAviso(error.message || 'Não foi possível carregar as FAQs.', 'erro');
  }
}

function preencherCategoriasFaq() {
  const select = document.getElementById('faq-categoria');
  if (!select) return;
  const ativas = categoriasFaq.filter(c => Number(c.active ?? 1) === 1);
  select.innerHTML = '<option value="">Selecione uma categoria</option>';
  ativas.forEach(categoria => {
    const option = document.createElement('option');
    option.value = categoria.id;
    option.textContent = categoria.name;
    select.appendChild(option);
  });
  if (!ativas.length) {
    select.innerHTML = '<option value="">Nenhuma categoria cadastrada</option>';
  }
}

function renderizarFaqsAdmin() {
  const tbody = document.getElementById('tabela-faqs');
  if (!tbody) return;
  tbody.replaceChildren();
  if (!faqsAdmin.length) {
    tbody.innerHTML = '<tr><td colspan="4">Nenhuma FAQ cadastrada no banco de dados.</td></tr>';
    return;
  }
  faqsAdmin.forEach(faq => {
    const tr = document.createElement('tr');
    const categoria = document.createElement('td'); categoria.textContent = faq.category || 'Sem categoria';
    const pergunta = document.createElement('td'); pergunta.textContent = faq.question || '';
    const status = document.createElement('td');
    const badge = document.createElement('span');
    const ativo = Number(faq.active) === 1;
    badge.className = `badge ${ativo ? 'badge-publicado' : 'badge-rascunho'}`;
    badge.textContent = ativo ? 'Publicada' : 'Rascunho';
    status.appendChild(badge);
    const actions = document.createElement('td');
    const wrap = document.createElement('div'); wrap.className = 'acoes-tabela';
    const toggle = document.createElement('button');
    toggle.className = `btn-acao ${ativo ? '' : 'verde'}`;
    toggle.textContent = ativo ? 'Despublicar' : 'Publicar';
    toggle.addEventListener('click', () => alterarStatusFaq(faq.id, ativo ? 0 : 1));
    const edit = document.createElement('button');
    edit.className = 'btn-acao'; edit.textContent = 'Editar';
    edit.addEventListener('click', () => editarFaq(faq));
    const remove = document.createElement('button');
    remove.className = 'btn-acao vermelho'; remove.textContent = 'Remover';
    remove.addEventListener('click', () => removerFaq(faq.id));
    wrap.append(toggle, edit, remove); actions.appendChild(wrap);
    tr.append(categoria, pergunta, status, actions);
    tbody.appendChild(tr);
  });
}

async function adicionarFaq(event) {
  event.preventDefault();
  const categoria = document.getElementById('faq-categoria').value;
  const pergunta = document.getElementById('faq-pergunta').value.trim();
  const resposta = document.getElementById('faq-resposta').value.trim();
  if (!categoria || !pergunta || !resposta) {
    mostrarAviso('Preencha categoria, pergunta e resposta.', 'erro');
    return;
  }
  try {
    const result = await carpeApi('/faqs/insert', {
      method: 'POST',
      body: JSON.stringify({ faqs_category_id: Number(categoria), question: pergunta, answer: resposta, active: 1 })
    });
    event.target.reset();
    preencherCategoriasFaq();
    await carregarGestaoFaqs();
    mostrarAviso(result.message || 'FAQ cadastrada e publicada.');
  } catch (error) {
    mostrarAviso(error.message || 'Não foi possível cadastrar a FAQ.', 'erro');
  }
}

async function alterarStatusFaq(id, active) {
  try {
    const result = await carpeApi('/faqs/update', {
      method: 'PUT', body: JSON.stringify({ id: Number(id), active: Number(active) })
    });
    await carregarGestaoFaqs();
    mostrarAviso(result.message || 'Status da FAQ atualizado.');
  } catch (error) { mostrarAviso(error.message, 'erro'); }
}

async function editarFaq(faq) {
  const pergunta = prompt('Edite a pergunta:', faq.question || '');
  if (pergunta === null) return;
  const resposta = prompt('Edite a resposta:', faq.answer || '');
  if (resposta === null) return;
  const categoria = prompt('ID da categoria (' + (faq.category || '') + '):', String(faq.faqs_category_id));
  if (categoria === null) return;
  if (!pergunta.trim() || !resposta.trim() || !Number.isInteger(Number(categoria))) {
    mostrarAviso('Informe pergunta, resposta e um ID de categoria válido.', 'erro'); return;
  }
  try {
    const result = await carpeApi('/faqs/update', {
      method: 'PUT', body: JSON.stringify({ id: Number(faq.id), faqs_category_id: Number(categoria), question: pergunta.trim(), answer: resposta.trim() })
    });
    await carregarGestaoFaqs();
    mostrarAviso(result.message || 'FAQ atualizada.');
  } catch (error) { mostrarAviso(error.message, 'erro'); }
}

async function removerFaq(id) {
  if (!confirm('Deseja remover esta FAQ da publicação?')) return;
  try {
    const result = await carpeApi(`/faqs/delete/${Number(id)}`, { method: 'DELETE' });
    await carregarGestaoFaqs();
    mostrarAviso(result.message || 'FAQ removida.');
  } catch (error) { mostrarAviso(error.message, 'erro'); }
}
