// ── Navegação ──
    document.querySelectorAll('.admin-nav-link').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelectorAll('.admin-nav-link').forEach(l => l.classList.remove('ativo'));
        this.classList.add('ativo');
        document.querySelectorAll('.app-secao-pagina').forEach(s => s.classList.remove('ativo'));
        document.getElementById('secao-' + this.dataset.secao).classList.add('ativo');
      });
    });

    // ── Renderizar tabelas de fotógrafos ──
    function renderTabelaFotografos(lista, tbodyEl) {
      tbodyEl.innerHTML = `<thead><tr>
        <th>Fotógrafo</th><th>Cidade</th><th>Especialidade</th>
        <th>Avaliação</th><th>Status</th><th>Ações</th>
      </tr></thead><tbody>` +
      lista.map(f => `<tr>
        <td><strong>${f.nome}</strong></td>
        <td>${f.cidade}, ${f.estado}</td>
        <td>${f.especialidade}</td>
        <td style="color:var(--cor-brass);">★ ${f.avaliacao}</td>
        <td><span class="badge badge-aprovado">Ativo</span></td>
        <td><div class="acoes-tabela">
          <button class="btn-acao" onclick="window.open('portfolio.html?id=${f.id}', '_blank')">Ver</button>
          <button class="btn-acao vermelho" onclick="mostrarAviso('Portfólio removido')">Remover</button>
        </div></td>
      </tr>`).join('') + '</tbody>';
    }

    renderTabelaFotografos(fotografos, document.getElementById('tabela-ativos'));
    renderTabelaFotografos(fotografos, document.getElementById('tabela-fotografos-completa'));

    // Busca em tempo real na tabela de fotógrafos
    document.getElementById('busca-fotografos').addEventListener('input', function() {
      const q = this.value.toLowerCase();
      const filtrado = fotografos.filter(f =>
        f.nome.toLowerCase().includes(q) ||
        f.cidade.toLowerCase().includes(q) ||
        f.especialidade.toLowerCase().includes(q)
      );
      renderTabelaFotografos(filtrado, document.getElementById('tabela-fotografos-completa'));
    });

    // ── Aprovar / Recusar fotógrafo ──
    function aprovarFotografo(btn) {
      const tr = btn.closest('tr');
      const nome = tr.querySelector('strong').textContent;
      tr.remove();
      mostrarAviso(`${nome} aprovado com sucesso!`);
    }
    function recusarFotografo(btn) {
      const tr = btn.closest('tr');
      tr.remove();
      mostrarAviso('Requisição recusada', 'erro');
    }

    // ── Adicionar admin ──
    function adicionarAdmin(e) {
      e.preventDefault();
      const nome = document.getElementById('admin-nome').value;
      const email = document.getElementById('admin-email').value;
      const tbody = document.getElementById('tabela-admins');
      const tr = document.createElement('tr');
      tr.innerHTML = `<td><strong>${nome}</strong></td><td>${email}</td>
        <td>${new Date().toLocaleDateString('pt-BR')}</td>
        <td><div class="acoes-tabela">
          <button class="btn-acao vermelho" onclick="this.closest('tr').remove(); mostrarAviso('Admin removido')">Remover</button>
        </div></td>`;
      tbody.appendChild(tr);
      e.target.reset();
      mostrarAviso(`Administrador ${nome} adicionado!`);
    }

    // ── FAQ CRUD ──
    function adicionarFaq(e) {
      e.preventDefault();
      const cat = document.getElementById('faq-categoria').value;
      const perg = document.getElementById('faq-pergunta').value;
      const tbody = document.getElementById('tabela-faqs');
      const tr = document.createElement('tr');
      tr.innerHTML = `<td>${cat}</td><td>${perg}</td>
        <td><span class="badge badge-rascunho">Rascunho</span></td>
        <td><div class="acoes-tabela">
          <button class="btn-acao verde" onclick="toggleFaqStatus(this)">Publicar</button>
          <button class="btn-acao vermelho" onclick="removerFaq(this)">Remover</button>
        </div></td>`;
      tbody.appendChild(tr);
      e.target.reset();
      mostrarAviso('FAQ adicionada!');
    }

    function toggleFaqStatus(btn) {
      const td = btn.closest('tr').querySelector('.badge');
      const publicada = td.classList.contains('badge-publicado');
      td.className = publicada ? 'badge badge-rascunho' : 'badge badge-publicado';
      td.textContent = publicada ? 'Rascunho' : 'Publicada';
      btn.textContent = publicada ? 'Publicar' : 'Despublicar';
      btn.className = publicada ? 'btn-acao verde' : 'btn-acao';
      mostrarAviso(publicada ? 'FAQ despublicada' : 'FAQ publicada!');
    }

    function removerFaq(btn) {
      btn.closest('tr').remove();
      mostrarAviso('FAQ removida', 'erro');
    }
