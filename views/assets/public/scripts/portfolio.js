console.log("Portfolio individual carregando...");

import PortfolioService from "../../_common/scripts/services/PortfolioService.js";

const portfolioService = new PortfolioService();


async function carregarPortfolio() {

    try {

        // Pega o id do portfólio na URL
        const params = new URLSearchParams(window.location.search);
        const id = params.get("id");

        console.log("ID do portfólio:", id);


        // Verifica se existe id
        if (!id) {
            mostrarErro("Portfólio não encontrado.");
            return;
        }


        // Busca o portfólio na API
        const resposta = await portfolioService.select(id);

        console.log("Resposta do portfólio:", resposta);


        if (!resposta || !resposta.data) {
            mostrarErro("Portfólio não encontrado.");
            return;
        }


        const portfolio = resposta.data;

        console.log("Portfólio:", portfolio);


        // Busca as fotos desse portfólio
        const respostaFotos = await fetch(
            `http://localhost:8080/carpe-diem/api/photos/portfolio/${id}`
        );

        console.log("Resposta das fotos:", respostaFotos);


        const fotos = await respostaFotos.json();

        console.log("Fotos:", fotos);


        renderizarPortfolio(portfolio, fotos.data || []);


    } catch (error) {

        console.error("Erro ao carregar portfólio:", error);

        mostrarErro("Não foi possível carregar o portfólio.");

    }

}


function renderizarPortfolio(portfolio, fotos) {

    const container = document.getElementById("conteudo-portfolio");

    if (!container) {

        console.error(
            "Elemento #conteudo-portfolio não encontrado."
        );

        return;
    }


    document.title = `${portfolio.title} — Portfólio | Carpe Diem`;


    let galeria = "";


    if (fotos.length > 0) {

        galeria = fotos.map(foto => `

            <img
                src="${foto.link}"
                alt="${portfolio.title}"
            >

        `).join("");


    } else {

        galeria = `

            <p style="
                color: var(--cor-texto-mudo);
                text-align: center;
                padding: 48px 0;
            ">
                Nenhuma foto encontrada neste portfólio.
            </p>

        `;

    }


    container.innerHTML = `

        <p style="margin-top: 32px;">

            <a
                href="portfolios.html"
                style="
                    font-size: 0.8rem;
                    letter-spacing: 0.06em;
                    text-transform: uppercase;
                    color: var(--cor-texto-mudo);
                "
            >
                ← Portfólios
            </a>

        </p>


        <section class="cabecalho-fotografo">

            <article class="info-fotografo">

                <h1>
                    ${portfolio.title}
                </h1>

                <p class="descricao">
                    ${portfolio.description}
                </p>

            </article>

        </section>


        <p
            class="ornamento"
            style="margin: 0 0 18px;"
        >

            <span class="ornamento-texto">
                portfólio
            </span>

        </p>


        <section class="galeria">

            ${galeria}

        </section>

    `;

}


function mostrarErro(mensagem) {

    const container = document.getElementById("conteudo-portfolio");

    if (!container) {
        return;
    }


    container.innerHTML = `

        <section style="
            text-align: center;
            padding: 80px 0;
        ">

            <p
                style="
                    color: var(--cor-texto-mudo);
                    margin-bottom: 20px;
                "
            >
                ${mensagem}
            </p>


            <a
                href="portfolios.html"
                class="botao botao-primario"
            >
                Ver todos os portfólios
            </a>

        </section>

    `;

}


carregarPortfolio();