var servicos = [
    {
        titulo: 'Ensaio de Eficiência e desempenho em bombas centrifugas',
        descricao: 'Somos um laboratório especializado em ensaios de eficiência energética e desempenho em bombas hidráulicas...'
    },
    {
        titulo: 'Elaboração de Curvas para Catálogo de Motobombas Hidráulicas',
        descricao: 'Oferecemos um serviço especializado na elaboração de curvas de desempenho para catálogos técnicos de...'
    },
    {
        titulo: 'Ensaio de Cavitação em Bombas Centrífugas',
        descricao: 'Oferecemos serviços de ensaio de cavitação em bombas centrífugas, com o objetivo de determinar...'
    },
    {
        titulo: 'Ensaios em Componentes Hidráulicos',
        descricao: 'Realizamos ensaios de desempenho e perda de carga em componentes hidráulicos essenciais...'
    },
    {
        titulo: 'Teste Hidrostático em Bombas Hidráulicas',
        descricao: 'Oferecemos um serviço especializado de teste hidrostático em bombas hidráulicas, com o objetivo de...'
    },
    {
        titulo: 'Consultoria em desenvolvimento de projetos de motobombas centrifugas',
        descricao: 'Oferecemos serviços de consultoria especializada voltados para o desenvolvimento de projetos de motobombas...'
    },
    {
        titulo: 'Calibração de medidores de vazão',
        descricao: 'Estamos trabalhando para oferecer em breve o serviço de calibração de medidores de vazão...'
    },
    {
        titulo: 'Ensaio de Eficiência Energética em Condicionadores de Ar e Bombas de Calor',
        descricao: 'Estamos atualmente desenvolvendo o serviço de ensaio de eficiência energética em...'
    }
];

function adicionarCardsServico(tamanho) {

    const cardContainer = document.getElementById("servicosCarouselInner");
    cardContainer.innerHTML = ""; // Limpar conteúdo atual
    var numCardsPorLinha = 1;
    switch (tamanho) {
        case "giga":
            numCardsPorLinha = 3;
            break;
        case "large":
            numCardsPorLinha = 3;
            break;
        case "medium":
            numCardsPorLinha = 2;
            break;
        case "small":
            numCardsPorLinha = 1;
            break;
    }

    const indicatorsContainer = document.getElementById("servicosCarouselIndicators");
    indicatorsContainer.innerHTML = ""; // Limpar conteúdo atual
    for (let index = 0; index < servicos.length; index++) {
        if (index % numCardsPorLinha === 0) {
            const li = document.createElement("li");
            li.setAttribute("data-bs-target", "#servicosCarousel");
            li.setAttribute("data-bs-slide-to", index / numCardsPorLinha);
            li.className = index === 0 ? "active" : "";
            indicatorsContainer.appendChild(li);
        }
    }

    for (let i = 0; i < servicos.length; i += numCardsPorLinha) {
        const item = document.createElement("div");
        if (i === 0) {
            item.className = "carousel-item active";
        } else {
            item.className = "carousel-item ";
        }

        const row = document.createElement("div");
        row.className = "card-row row";
        item.appendChild(row)

        for (let j = i; j < i + numCardsPorLinha && j < servicos.length; j++) {
            const card = document.createElement("div");
            card.className = "card-servico col-md-4 col-sm-6 col-10";

            const servicoDiv = document.createElement("div");
            servicoDiv.className = "servico";

            const servicoTitle = document.createElement("p");
            servicoTitle.className = "servico-title";
            servicoTitle.textContent = servicos[j].titulo;

            const servicoText = document.createElement("h5");
            servicoText.className = "servico-text";
            servicoText.innerHTML = `${servicos[j].descricao}`;

            const saibaMaisButton = document.createElement("button");
            saibaMaisButton.className ="saiba-mais";
            saibaMaisButton.innerHTML = "Saiba mais";
            saibaMaisButton.onclick = function (i){
                viewMore(i);
            }

            servicoDiv.appendChild(servicoTitle);
            servicoDiv.appendChild(servicoText);
            servicoDiv.appendChild(saibaMaisButton);
            card.appendChild(servicoDiv);
            row.appendChild(card);
        }

        cardContainer.appendChild(item);
    }
}

function verificarTamanhoTela() {
    if (window.innerWidth < 768) {
        adicionarCardsServico("small");
    } else if (window.innerWidth >= 768 && window.innerWidth <= 995) {
        adicionarCardsServico("medium");
    } else if(window.innerWidth >= 996 && window.innerWidth <= 1440) {
        adicionarCardsServico("large");
    }else{
        adicionarCardsServico("giga");
    }
}


verificarTamanhoTela(); // Verificar tamanho da tela ao carregar a página

// Verificar tamanho da tela quando a janela for redimensionada
window.addEventListener("resize", verificarTamanhoTela);