var servicos = [
    {
        titulo: 'Ensaio de Eficiência e desempenho em bombas centrifugas',
        descricao: 'Somos um laboratório especializado em ensaios de eficiência energética e desempenho em bombas hidráulicas...',
        detalhes: {
            textos: [
                'Somos um laboratório especializado em ensaios de eficiência energética e desempenho em bombas hidráulicas centrífugas. Somos acreditados desde 2015 pela CGCRE com o número CRL0883, em conformidade com a norma ABNT NBR ISO/IEC 17025. Nosso escopo abrange ensaios de eficiência energética em bombas centrífugas, atendendo os requisitos estabelecidos na Portaria do INMETRO Nº 319, de 23 de julho de 2021.',
                'Além dessa especialização, nosso laboratório também está equipado para realizar ensaios de desempenho em bombas hidráulicas submersas e submersíveis, com capacidade de até 50 CV.',
            ],
            imagens: [
                'images/Projetos/projeto1-img1.jpg',
                'images/Projetos/projeto1-img2.jpg',
                'images/Projetos/projeto1-img3.jpg',
            ],
            links: [
                'Link do escopo acreditado: http://www.inmetro.gov.br/laboratorios/rble/docs/CRL0883.pdf',
                'Link Portaria 319/2021: http://www.inmetro.gov.br/LEGISLACAO/resultado_pesquisa.asp?seq_classe=1&ind_publico=&sel_tipo_ato_legal=--&nom_orgao=&sel_tipo_instrumento_medida=&sel_orgao_regulamentador=&descr_marca=&descr_modelo=&sel_categoria=--&num_ato=319&ano_assinatura=2021&palavra_chave=&btnPesquisar=Pesquisar'
            ]
        }
    },
    {
        titulo: 'Elaboração de Curvas para Catálogo de Motobombas Hidráulicas',
        descricao: 'Oferecemos um serviço especializado na elaboração de curvas de desempenho para catálogos técnicos de...',
        detalhes: {
            textos: [
                'Oferecemos um serviço especializado na elaboração de curvas de desempenho para catálogos técnicos de motobombas hidráulicas. Realizamos levantamentos precisos de curvas como Vazão x Altura, Vazão x Potência e Vazão x Rendimento. Nossa expertise garante que as informações essenciais para seleção e especificação das motobombas sejam apresentadas de forma clara e confiável em seus materiais técnicos.',
            ],
            imagens: [],
            links: []
        }

    },
    {
        titulo: 'Ensaio de Cavitação em Bombas Centrífugas',
        descricao: 'Oferecemos serviços de ensaio de cavitação em bombas centrífugas, com o objetivo de determinar...',
        detalhes: {
            textos: [
                'Oferecemos serviços de ensaio de cavitação em bombas centrífugas, com o objetivo de determinar o NPSH (Altura de Sucção Disponível Normalizada) requerido da bomba para diversas vazões. Através desse ensaio, identificamos as condições operacionais seguras e eficientes da bomba, evitando a ocorrência de cavitação que poderia prejudicar o desempenho e a integridade do equipamento.',
            ],
            imagens: [],
            links: []
        }
    },
    {
        titulo: 'Ensaios em Componentes Hidráulicos',
        descricao: 'Realizamos ensaios de desempenho e perda de carga em componentes hidráulicos essenciais...',
        detalhes: {
            textos: [
                'Realizamos ensaios de desempenho e perda de carga em componentes hidráulicos essenciais, como filtros, válvulas entre outros.',
            ],
            imagens: [],
            links: []
        }
    },
    {
        titulo: 'Teste Hidrostático em Bombas Hidráulicas',
        descricao: 'Oferecemos um serviço especializado de teste hidrostático em bombas hidráulicas, com o objetivo de...',
        detalhes: {
            textos: [
                'Oferecemos um serviço especializado de teste hidrostático em bombas hidráulicas, com o objetivo de assegurar a integridade, segurança e desempenho desses equipamentos. Nosso processo visa garantir que as bombas estejam em total conformidade com os padrões regulatórios estabelecidos.',
            ],
            imagens: [],
            links: []
        }
    },
    {
        titulo: 'Consultoria em desenvolvimento de projetos de motobombas centrifugas',
        descricao: 'Oferecemos serviços de consultoria especializada voltados para o desenvolvimento de projetos de motobombas...',
        detalhes: {
            textos: [
                'Oferecemos serviços de consultoria especializada voltados para o desenvolvimento de projetos de motobombas centrífugas. Através da aplicação de técnicas avançadas de Dinâmica dos Fluidos Computacional (CFD), desenvolvemos projetos eficientes e otimizados, garantindo desempenho superior e confiabilidade das motobombas centrífugas.',
            ],
            imagens: [],
            links: []
        }
    },
    {
        titulo: 'Calibração de medidores de vazão',
        descricao: 'Estamos trabalhando para oferecer em breve o serviço de calibração de medidores de vazão...',
        detalhes: {
            textos: [
                'Estamos trabalhando para oferecer em breve o serviço de calibração de medidores de vazão. Fique atento para mais informações e detalhes.',
            ],
            imagens: [],
            links: []
        }
    },
    {
        titulo: 'Ensaio de Eficiência Energética em Condicionadores de Ar e Bombas de Calor',
        descricao: 'Estamos atualmente desenvolvendo o serviço de ensaio de eficiência energética em...',
        detalhes: {
            textos: [
                'Estamos atualmente desenvolvendo o serviço de ensaio de eficiência energética em condicionadores de ar e bombas de calor. Aguarde para obter mais informações.',
            ],
            imagens: [],
            links: []
        }
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
            card.className = "card-servico col-lg-4 col-md-6 col-sm-6 col-xs-12";

            const servicoDiv = document.createElement("div");
            servicoDiv.className = "servico";
            
            const servicoTitle = document.createElement("p");
            servicoTitle.className = "servico-title";
            servicoTitle.textContent = servicos[j].titulo;

            const servicoText = document.createElement("h5");
            servicoText.className = "servico-text";
            servicoText.innerHTML = `${servicos[j].descricao}`;

            const saibaMaisButton = document.createElement("button");
            saibaMaisButton.className = "saiba-mais";
            saibaMaisButton.innerHTML = "Saiba mais";
            saibaMaisButton.onclick = function () {
                viewMore(j);
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
    } else if (window.innerWidth >= 768 && window.innerWidth <= 991) {
        adicionarCardsServico("medium");
    } else if (window.innerWidth >= 992) {
        adicionarCardsServico("large");
    }
}


verificarTamanhoTela(); // Verificar tamanho da tela ao carregar a página

// Verificar tamanho da tela quando a janela for redimensionada
window.addEventListener("resize", verificarTamanhoTela);

function viewMore(i) {
    const modal = document.getElementById('modalProjects');
    const body = modal.getElementsByClassName('modal-body')[0];
    while (body.firstChild) {
        body.removeChild(body.firstChild);
    }

    const titulo = document.getElementById('modalTitulo');
    titulo.className = "modal-servico-titulo";
    titulo.innerHTML = servicos[i].titulo;
    // body.appendChild(titulo);

    if (servicos[i].detalhes.imagens.length > 2) {
        const divImagens = document.createElement('div');
        divImagens.className ='modal-imagens';
        for (let j = 0; j < 2; j++) {
            if (servicos[i].detalhes.imagens[j]) {
                const image = document.getElementById(servicos[i].detalhes.imagens[j]);
                const copy = document.createElement('img')
                copy.src = image.src;
                copy.className = 'd-block';
                copy.width = '180';
                divImagens.appendChild(copy);
            }
        }
        body.appendChild(divImagens);
        const descricao = document.createElement('p');
        descricao.innerHTML = servicos[i].detalhes.textos[0];
        body.appendChild(descricao);

        const divImagens2 = document.createElement('div');
        divImagens2.className ='modal-imagens';
        for (let j = 2; j < 4; j++) {
            if (servicos[i].detalhes.imagens[j]) {
                const image = document.getElementById(servicos[i].detalhes.imagens[j]);
                const copy = document.createElement('img')
                copy.src = image.src;
                copy.className = 'd-block';
                copy.width = '180';
                divImagens2.appendChild(copy);
            }
        }
        body.appendChild(divImagens2);
        const descricao2 = document.createElement('p');
        descricao2.innerHTML = servicos[i].detalhes.textos[1];
        body.appendChild(descricao2);
    } else if (servicos[i].detalhes.imagens.length > 0) {
        const divImagens = document.createElement('div');
        divImagens.className ='modal-imagens';
        for (let j = 0; j < 2; j++) {
            if (servicos[i].detalhes.imagens[j]) {
                const image = document.getElementById(servicos[i].detalhes.imagens[j]);
                const copy = document.createElement('img')
                copy.src = image.src;
                copy.className = 'd-block';
                copy.width = '180';
                divImagens.appendChild(copy);
            }
        }
        body.appendChild(divImagens);
        const descricao = document.createElement('p');
        descricao.innerHTML = servicos[i].detalhes.textos[0];
        body.appendChild(descricao);
    }else{
        const descricao = document.createElement('p');
        descricao.innerHTML = servicos[i].detalhes.textos[0];
        body.appendChild(descricao);
    }


    $('#modalProjects').modal('show');
}