<?php
$imagens = [
    'images/projetos/projeto1-img1.jpeg',
    'images/projetos/projeto1-img2.jpg',
    'images/projetos/projeto1-img3.jpg',
    'images/LEB.png',
    'images/projetos/projeto2-img1.png',
    'images/projetos/projeto2-img2.png',
    'images/projetos/projeto2-img3.png',
    'images/projetos/projeto2-img4.png',
    'images/projetos/projeto2-img5.png',
]
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>LEB - Laboratório de Etiquetagem de Bombas</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-LEB.svg') }}">
    <meta name="viewport" content="initial-scale=1, width=device-width">
    <link rel="stylesheet" href="{{ asset('css/welcome/topbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/welcome/contact.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/welcome/footer.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/welcome/home.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/welcome/servicos.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/welcome/sobre.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</head>

<body>
    @foreach($imagens as $i)
    <img src="{{ asset($i) }}" class='d-none' id="{{$i}}">
    @endforeach
        <header>
            <nav class="navbar navbar-expand-lg topbar">
                <a class="title navbar-brand m-lg-auto" href="{{ route('home') }}">
                    <h3>LEB</h3>
                </a>
                <button class=" me-4 navbar-toggler collapsed menu" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars" style="font-size:24px; color:#b9a9a9;"></i>
                </button>
                <div class="collapse navbar-collapse " id="navbarNav">
                    <ul class="navbar-nav topbar-topics">
                        <li class="title"><a href="#sobre-nos">Sobre</a></li>
                        <li class="title"><a href="#servicos-prestados">Serviços</a></li>
                        <li class="title"><a href="#contato">Contato</a></li>
                    </ul>
                    @guest
                    <div>
                        <a class="topbar-login nav-link navbar-text" href="{{ route('redirect') }}">{{ __('Login') }}</a>
                    </div>
                    @else
                    <div class="dropdown">

                        <a id="navbarDropdown" class="nav-link topbar-login navbar-text dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ strtok(Auth::user()->name, " ") }}
                        </a>
                        <div class="dropdown-menu title">
                            @if(Auth::user()->role === 'Cliente')
                            <a class="dropdown-item" href="{{ route('workspace') }}">

                                {{ __('Documentos') }}
                                <i class="fa fa-document" aria-hidden="true"></i>
                            </a>
                            @elseif(Auth::user()->role === 'Admin')
                            <a class="dropdown-item" href="{{ route('dashboard') }}">

                                {{ __('Dashboard') }}
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </a>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                {{ __('Sair') }}
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>

                    </div>
                    @endguest
                </div>
            </nav>
        </header>


    <main class="content">

        <div class="color home" id="home">
            <img class="home-gradient" src="{{ asset('images/fundo-degrade.svg') }}">
            <img class="logo-LEB" src="{{ asset('images/logo-LEB.svg') }}">
        </div>

        <div class='content-background'>
            <div class="sobre-nos" id="sobre-nos">
                <div class="card-missao">
                    <div class="card-missao-text">
                        <h3 class="missao-title">Sobre</h3>
                        <h5 class="missao-text">
                            Criado em 2000, o Laboratório de Etiquetagem de Bombas Hidráulicas (LEB),
                            instalado no campus da Universidade Federal de Itajubá (Unifei), foi concebido
                            inicialmente para a prestação de serviço de calibração de medidores de vazão.
                            Posteriormente, em 2002, foi projetada e implantada a bancada de ensaio de bombas
                            hidráulicas, que contou com recursos do Procel. Em 2006, entrou em operação
                            comercial e, em 2015, obteve sua acreditação no Inmetro. A equipe do LEB e sua
                            infraestrutura, com o Procel e o Inmetro, iniciou o programa de etiquetagem de
                            bombas hidráulicas centrífugas de até 25 CV no Brasil.
                            Acreditado desde o dia 17/08/2015 na norma ABNT NBR ISO/IEC 17025 para “Ensaio
                            de levantamento de curvas de desempenho (eficiência) com faixa de vazão:
                            até 325 m³/h” o LEB atende mais de 50% dos fabricantes e importadores de
                            bombas hidráulicas no Brasil.
                        </h5>
                    </div>
                </div>
            </div>
            <div class="sobre-leb">
                <div class="card-leb">
                    <img class="card-leb-img" src="{{ asset('images/logo-LEB.svg') }}">
                    <div class="card-leb-text">
                        <h3 class="leb-title">LEB</h3>
                        <h5 class="leb-text">
                            O laboratório tem contribuído com a melhoria contínua da eficiência energética
                            das bombas hidráulicas fabricadas e importadas no Brasil mediante a oferta de
                            novos serviços, como projeto de bombas empregando modelagem digital de escoamento,
                            ensaios para catálogos técnicos, ensaio de acessórios hidráulicos e ensaio de
                            bombas submersas e submersíveis.
                        </h5>
                    </div>
                </div>
            </div>
            <div class="servicos-prestados">
                <div class="servicos-ancora">
                    <div id="servicos-prestados"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                        <path fill="#394671" fill-opacity="1" d="M0,96L80,117.3C160,139,320,181,480,176C640,171,800,117,960,112C1120,107,1280,149,1360,170.7L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                    </svg>
                </div>
                <div class="servicos">
                    <h2>Serviços</h2>
                    <div id="servicosCarousel" class="servicos-container carousel slide " data-bs-ride="carousel">
                        <ol id="servicosCarouselIndicators" class="carousel-indicators">
                        </ol>
                        <div id="servicosCarouselInner" class="carousel-inner servicos-carousel-inner">

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#servicosCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#servicosCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" transform="matrix(-1,1.2246467991473532e-16,-1.2246467991473532e-16,-1,0,0)">
                    <path fill="#394671" fill-opacity="1" d="M0,96L80,117.3C160,139,320,181,480,176C640,171,800,117,960,112C1120,107,1280,149,1360,170.7L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                </svg>
            </div>
            <div class="contato" id="contato">
                <h2>Entre em Contato</h2>
                <div class="card-contato">
                    <div class="contact-form">
                        <form action="{{route('send-email')}}" method="post">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-group">
                                <input type="text" value="{{old('name')}}" id="name" name="name" placeholder="Nome" required>
                                <p class="name-error text-danger m-1"></p>
                                @if(isset($errors) && count($errors) > 0)
                                @foreach( $errors->get('name') as $error)
                                <p name="name-error" class="text-danger m-1">{{$error}}</p>
                                @endforeach
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="email" value="{{old('email')}}" id="email" name="email" placeholder="Email" required>
                                <p class="text-danger m-1 email-error"></p>
                                @if(isset($errors) && count($errors) > 0)
                                @foreach( $errors->get('email') as $error)
                                <p class="text-danger m-1">{{$error}}</p>
                                @endforeach
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="text" value="{{old('subject')}}" id="subject" name="subject" placeholder="Assunto" required>
                                <p class="text-danger m-1 subject-error"></p>
                                @if(isset($errors) && count($errors) > 0)
                                @foreach( $errors->get('subject') as $error)
                                <p class="text-danger m-1">{{$error}}</p>
                                @endforeach
                                @endif
                            </div>
                            <div class="form-group">
                                <textarea id="message" placeholder="Mensagem" name="message" rows="2" required>
                                {{old('message')}}
                                </textarea>
                                <p class="text-danger m-1 message-error"></p>
                            </div>
                            <button type="submit">Enviar</button>
                        </form>
                    </div>
                    <!-- <div class="contato-separator">
                        <img class="div-contato" src="{{ asset('images/line.svg') }}">
                    </div> -->
                    <!-- <div class="redes-sociais">
                        <div class="rede-social">
                            <img src="{{ asset('images/instagram.svg') }}">
                            <label>lorem ipsum</label>
                        </div>
                        <div class="rede-social">
                            <img src="{{ asset('images/facebook.svg') }}">
                            <label>lorem ipsum</label>
                        </div>
                        <div class="rede-social">
                            <img src="{{ asset('images/email.svg') }}">
                            <label>lorem ipsum</label>
                        </div>
                        <div class="rede-social">
                            <img src="{{ asset('images/linkedin.svg') }}">
                            <label>lorem ipsum</label>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="home-footer">
            @include('layouts.footer')
        </div>

        <div class="modal fade" id="modalProjects" tabindex="-1" aria-labelledby="modalProjectsLabel" aria-hidden="true" style='overflow-y: hidden;'>
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalTitulo">Nossos Serviços</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="max-height: 65vh; overflow-y: auto;">

                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="{{ asset('js/script.js') }}"></script>
    <!-- Script JavaScript para manipular o Modal -->
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/carousels.js') }}"></script>
</body>

</html>