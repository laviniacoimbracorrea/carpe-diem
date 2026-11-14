const destaque = document.getElementById('grade-destaque');
    destaque.innerHTML = fotografos.slice(0, 3).map(f => `
      <article class="card-destaque" onclick="window.location='views/portfolio.html?id=${f.id}'">
        <div class="card-destaque-wrap-imagem">
          <img class="card-destaque-imagem" src="${f.fotoCapa}" alt="${f.nome}" />
        </div>
        <div class="card-destaque-corpo">
          <h3>${f.nome}</h3>
          <p class="cidade">${f.cidade}, ${f.estado}</p>
          <span class="especialidade">${f.especialidade}</span>
        </div>
      </article>
    `).join('');
