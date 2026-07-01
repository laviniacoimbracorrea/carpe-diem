// Lê o ?id= da URL
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');
    const fotografo = fotografos.find(f => f.id === id);
    const container = document.getElementById('conteudo-portfolio');

    if (!fotografo) {
      // ID não encontrado — mostra mensagem e redireciona
      container.innerHTML = `
        <div style="text-align: center; padding: 80px 0;">
          <p style="color: var(--cor-texto-mudo); margin-bottom: 20px;">Fotógrafo não encontrado.</p>
          <a href="portfolios.html" class="botao botao-primario">Ver todos os portfólios</a>
        </div>
      `;
    } else {
      // Atualiza o título da aba
      document.title = `${fotografo.nome} — Portfólio | Carpe Diem`;

      // Monta a estrelas de avaliação
      const estrelasFilled = '★'.repeat(Math.round(fotografo.avaliacao));
      const estrelasEmpty = '☆'.repeat(5 - Math.round(fotografo.avaliacao));

      container.innerHTML = `
        <p style="margin-top: 32px;">
          <a href="portfolios.html" style="font-size: 0.8rem; letter-spacing: 0.06em; text-transform: uppercase; color: var(--cor-texto-mudo);">← Portfólios</a>
        </p>

        <div class="cabecalho-fotografo">
          <img class="avatar-fotografo" src="${fotografo.fotoAvatar}" alt="Foto de ${fotografo.nome}" />
          <div class="info-fotografo">
            <h1>${fotografo.nome}</h1>
            <span class="especialidade-grande">${fotografo.especialidade}</span>
            <p class="descricao">${fotografo.descricaoCompleta}</p>
            <div class="dados-extras">
              <span>${fotografo.cidade}, ${fotografo.estado}</span>
              <span>${estrelasFilled}${estrelasEmpty} ${fotografo.avaliacao} · ${fotografo.totalAvaliacoes} avaliações</span>
              <span>${fotografo.experiencia}</span>
            </div>
          </div>
        </div>

        <div class="ornamento" style="margin: 0 0 18px;"><span class="ornamento-texto">galeria de trabalhos</span></div>
        <div class="galeria">
          ${fotografo.galeria.map(src => `<img src="${src}" alt="" />`).join('')}
        </div>

        <div class="bloco-acoes-portfolio">
          <div class="caixa">
            <h3>Avaliar este profissional</h3>
            <div class="estrelas" id="estrelas">☆ ☆ ☆ ☆ ☆</div>
            <textarea placeholder="Escreva uma avaliação sobre este fotógrafo..."></textarea>
            <button class="botao botao-primario" onclick="mostrarAviso('Avaliação enviada!')">Enviar avaliação</button>
          </div>

          <div class="caixa">
            <h3>Enviar mensagem para ${fotografo.nome.split(' ')[0]}</h3>
            <input type="text" placeholder="Assunto" style="margin-bottom: 12px;" />
            <textarea placeholder="Olá, gostaria de saber mais sobre seu trabalho..."></textarea>
            <button class="botao botao-primario" onclick="mostrarAviso('Mensagem enviada com sucesso!')">Enviar mensagem</button>
          </div>
        </div>
      `;

      // Interação das estrelas
      const estrelasEl = document.getElementById('estrelas');
      let nota = 0;
      estrelasEl.addEventListener('click', () => {
        nota = nota === 5 ? 0 : nota + 1;
        estrelasEl.textContent = ('★ '.repeat(nota) + '☆ '.repeat(5 - nota)).trim();
      });
    }
