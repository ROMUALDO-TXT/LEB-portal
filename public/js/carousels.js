var servicos = [
    {
        titulo: 'Ensaio de Eficiência e desempenho em bombas centrifugas',
        descricao: 'Somos um laboratório especializado em ensaios de eficiência energética e desempenho em bombas hidráulicas...',
        detalhes: [
            {
                capa: 'images/LEB.png'
            },
            {
                texto: 'Somos um laboratório especializado em ensaios de eficiência energética e desempenho em bombas hidráulicas centrífugas. Somos acreditados desde 2015 pela CGCRE com o número CRL0883, em conformidade com a norma ABNT NBR ISO/IEC 17025. Nosso escopo abrange ensaios de eficiência energética em bombas centrífugas, atendendo os requisitos estabelecidos na Portaria do INMETRO Nº 319, de 23 de julho de 2021.',
            },
            {
                width: '180',
                imagem: 'images/projetos/projeto1-img1.jpeg'
            },
            {
                texto: '<ul>'
                    + '<li>Acesse o nosso escopo acreditado: <a href="http://www.inmetro.gov.br/laboratorios/rble/docs/CRL0883.pdf">http://www.inmetro.gov.br/laboratorios/rble/docs/CRL0883.pdf</a></li>'
                    + '<li>Acesse a Portaria n° 319 de 23 de julho de 2021: <a href="http://www.inmetro.gov.br/legislacao/rtac/pdf/RTAC002808.pdf">http://www.inmetro.gov.br/legislacao/rtac/pdf/RTAC002808.pdf</a></li>'
                    + '</ul>'
                    + 'Além dessa especialização, nosso laboratório também está equipado para realizar ensaios de desempenho em bombas hidráulicas submersas e submersíveis, com capacidade de até 50 CV.'
            },
            {
                imagem1: 'images/projetos/projeto1-img2.jpg',
                imagem2: 'images/projetos/projeto1-img3.jpg'
            },
        ]
    },
    {
        titulo: 'Elaboração de Curvas para Catálogo de Motobombas Hidráulicas',
        descricao: 'Oferecemos um serviço especializado na elaboração de curvas de desempenho para catálogos técnicos de...',
        detalhes: [
            {
                texto: 'Oferecemos um serviço especializado na elaboração de curvas de desempenho para catálogos técnicos de motobombas hidráulicas. Realizamos levantamentos precisos de curvas como Vazão x Altura, Vazão x Potência e Vazão x Rendimento. Nossa expertise garante que as informações essenciais para seleção e especificação das motobombas sejam apresentadas de forma clara e confiável em seus materiais técnicos.',
            },
            {
                width: '600',
                imagem: 'images/projetos/projeto2-img1.png',
            },
            {
                width: '600',
                imagem: 'images/projetos/projeto2-img2.png'
            },
            {
                width: '600',
                imagem: 'images/projetos/projeto2-img3.png',
            },
            {
                width: '600',
                imagem: 'images/projetos/projeto2-img4.png'
            },
            {
                width: '600',
                imagem: 'images/projetos/projeto2-img5.png',
            },
        ],
    },
    {
        titulo: 'Ensaio de Cavitação em Bombas Centrífugas',
        descricao: 'Oferecemos serviços de ensaio de cavitação em bombas centrífugas, com o objetivo de determinar...',
        detalhes: [
            {
                texto: 'Oferecemos serviços de ensaio de cavitação em bombas centrífugas, com o objetivo de determinar o NPSH (Altura de Sucção Disponível Normalizada) requerido da bomba para diversas vazões. Através desse ensaio, identificamos as condições operacionais seguras e eficientes da bomba, evitando a ocorrência de cavitação que poderia prejudicar o desempenho e a integridade do equipamento.',
            }
        ],
    },
    {
        titulo: 'Ensaios em Componentes Hidráulicos',
        descricao: 'Realizamos ensaios de desempenho e perda de carga em componentes hidráulicos essenciais...',
        detalhes: [
            {
                texto: 'Realizamos ensaios de desempenho e perda de carga em componentes hidráulicos essenciais, como filtros, válvulas entre outros.',
            }
        ],
    },
    {
        titulo: 'Teste Hidrostático em Bombas Hidráulicas',
        descricao: 'Oferecemos um serviço especializado de teste hidrostático em bombas hidráulicas, com o objetivo de...',
        detalhes: [
            {
                texto: 'Oferecemos um serviço especializado de teste hidrostático em bombas hidráulicas, com o objetivo de assegurar a integridade, segurança e desempenho desses equipamentos. Nosso processo visa garantir que as bombas estejam em total conformidade com os padrões regulatórios estabelecidos.',
            }
        ],
    },
    {
        titulo: 'Consultoria em desenvolvimento de projetos de motobombas centrifugas',
        descricao: 'Oferecemos serviços de consultoria especializada voltados para o desenvolvimento de projetos de motobombas...',
        detalhes: [
            {
                texto: 'Oferecemos serviços de consultoria especializada voltados para o desenvolvimento de projetos de motobombas centrífugas. Através da aplicação de técnicas avançadas de Dinâmica dos Fluidos Computacional (CFD), desenvolvemos projetos eficientes e otimizados, garantindo desempenho superior e confiabilidade das motobombas centrífugas.',
            }
        ],
    },
    {
        titulo: 'Calibração de medidores de vazão',
        descricao: 'Estamos trabalhando para oferecer em breve o serviço de calibração de medidores de vazão...',
        detalhes: [
            {
                texto: 'Estamos trabalhando para oferecer em breve o serviço de calibração de medidores de vazão. Fique atento para mais informações e detalhes.',
            }
        ],
    },
    {
        titulo: 'Ensaio de Eficiência Energética em Condicionadores de Ar e Bombas de Calor',
        descricao: 'Estamos atualmente desenvolvendo o serviço de ensaio de eficiência energética em...',
        detalhes: [
            {
                texto: 'Estamos atualmente desenvolvendo o serviço de ensaio de eficiência energética em condicionadores de ar e bombas de calor. Aguarde para obter mais informações.',
            }
        ],
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

    servicos[i].detalhes.forEach((obj) => {
        if (obj.imagem1 && obj.imagem2) {
            const divImagens = document.createElement('div');
            divImagens.className = 'modal-imagens';
            const image1 = document.getElementById(obj.imagem1);
            const copy1 = document.createElement('img')
            copy1.src = image1.src;
            copy1.className = 'd-block';
            copy1.width = '180';
            divImagens.appendChild(copy1);

            const image2 = document.getElementById(obj.imagem2);
            const copy2 = document.createElement('img')
            copy2.src = image2.src;
            copy2.className = 'd-block';
            copy2.width = '180';
            divImagens.appendChild(copy2);
            body.appendChild(divImagens);
        }
        if (obj.texto) {
            const descricao = document.createElement('p');
            descricao.innerHTML = obj.texto;
            body.appendChild(descricao);
        }
        if (obj.imagem) {
            const divImagens = document.createElement('div');
            divImagens.className = 'modal-imagens';
            const image = document.getElementById(obj.imagem);
            const copy = document.createElement('img')
            copy.src = image.src;
            copy.className = 'd-block';
            copy.width = obj.width;
            divImagens.appendChild(copy);
            body.appendChild(divImagens);
        }

    })
    $('#modalProjects').modal('show');
}


