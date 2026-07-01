function renderizarCards(lista) {
      const container = document.getElementById('lista-portfolios');

      if (lista.length === 0) {
        container.innerHTML = '<p style="color: var(--cor-texto-mudo); text-align: center; padding: 48px 0;">Nenhum fotógrafo encontrado com esses filtros.</p>';
        return;
      }

      container.innerHTML = lista.map(f => `
        <article class="card-comprido" onclick="window.location='portfolio.html?id=${f.id}'">
          <div class="card-comprido-wrap"><img class="card-comprido-imagem" src="${f.fotoCapa}" alt="${f.nome}" /></div>
          <div class="card-comprido-corpo">
            <h3>${f.nome}</h3>
            <p class="meta">${f.cidade}, ${f.estado} · ★ ${f.avaliacao} · ${f.totalAvaliacoes} avaliações</p>
            <p>${f.descricao}</p>
            <div class="card-comprido-tags">
              ${f.tags.map(t => `<span>${t}</span>`).join('')}
            </div>
          </div>
          <div class="card-comprido-acao">
            <span class="botao botao-primario">Ver portfólio</span>
          </div>
        </article>
      `).join('');
    }

    function aplicarFiltros() {
      const nome = document.getElementById('filtro-nome').value.toLowerCase();
      const cidade = document.getElementById('filtro-cidade').value;
      const especialidade = document.getElementById('filtro-especialidade').value;

      const resultado = fotografos.filter(f => {
        const bateNome = !nome || f.nome.toLowerCase().includes(nome);
        const bateCidade = !cidade || f.cidade === cidade;
        const bateEspecialidade = !especialidade || f.especialidade === especialidade || f.tags.includes(especialidade);
        return bateNome && bateCidade && bateEspecialidade;
      });

      renderizarCards(resultado);
    }

    // Filtro em tempo real pelo nome
    document.getElementById('filtro-nome').addEventListener('input', aplicarFiltros);

    // Renderiza todos ao carregar
    renderizarCards(fotografos);
