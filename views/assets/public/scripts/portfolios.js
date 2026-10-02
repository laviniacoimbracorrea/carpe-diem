console.log("Portfolios carregando...");

import PortfolioService from "../../_common/scripts/services/PortfolioService.js";

const portfolioService = new PortfolioService();

async function fetchPortfolios() {

    try {

        console.log("Buscando portfolios na API...");

        const portfolios = await portfolioService.list();

        console.log("Resposta da API:", portfolios);

        renderizarCards(portfolios.data);

    } catch (error) {

        console.error("Erro ao carregar portfolios:", error);

    }

}


function renderizarCards(lista) {

    const container = document.getElementById("lista-portfolios");

    if (!container) {

        console.error("Elemento #lista-portfolios não encontrado.");

        return;

    }


    if (!lista || lista.length === 0) {

        container.innerHTML = `
            <p style="color: var(--cor-texto-mudo); text-align: center; padding: 48px 0;">
                Nenhum portfólio encontrado.
            </p>
        `;

        return;

    }


    container.innerHTML = lista.map(portfolio => `

        <article class="card-comprido">

            <div class="card-comprido-wrap">

                <img
                    class="card-comprido-imagem"
                    src="${portfolio.cover_link || 'assets/_common/images/placeholder.jpg'}"
                    alt="${portfolio.title || 'Portfólio'}"
                />

            </div>


            <div class="card-comprido-corpo">

                <h3>
                    ${portfolio.title || 'Portfólio sem título'}
                </h3>

                <p>
                    ${portfolio.description || 'Nenhuma descrição disponível.'}
                </p>

            </div>


            <div class="card-comprido-acao">

                <button
                    type="button"
                    class="botao botao-primario"
                    data-portfolio-id="${portfolio.id}"
                >
                    Ver portfólio
                </button>

            </div>

        </article>

    `).join("");


    const botoes = container.querySelectorAll("[data-portfolio-id]");


    botoes.forEach(botao => {

        botao.addEventListener("click", () => {

            const portfolioId = botao.dataset.portfolioId;

            console.log("Abrindo portfólio:", portfolioId);

            window.location.href = `portfolio.html?id=${portfolioId}`;

        });

    });

}


fetchPortfolios();