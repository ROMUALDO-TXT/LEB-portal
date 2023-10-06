<!DOCTYPE html>
<html>

@if(Auth::check())
@php
return redirect()->route('home');
@endphp
@endif

<head>
    <meta charset="utf-8">
    <title>LEB - Laboratório de Etiquetagem de Bombas</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-LEB.svg') }}">
    <meta name="viewport" content="initial-scale=1, width=device-width">
    <link rel="stylesheet" href="{{ asset('css/welcome/topbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/welcome/footer.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</head>

<body>

    <main class="content">
        <header>
            <nav class="navbar navbar-expand-lg topbar">
                <a class="title navbar-brand m-lg-auto" href="{{ route('home') }}">
                    <h3>LEB</h3>
                </a>
                <ul class="nav navbar-nav d-none d-lg-flex topbar-topics">
                    <li class="nav-item title">
                        <h3></h3>
                    </li>
                </ul>
                @guest
                <a class="topbar-login nav-link navbar-text" href="{{ route('redirect') }}">{{ __('Login') }}</a></li>
                @else
                <div class="dropdown">

                    <a id="navbarDropdown" class="nav-link topbar-login navbar-text dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu title">
                        @if(Auth::user()->role === 'Cliente')
                        <a class="dropdown-item" href="{{ route('workspace') }}">

                            {{ __('Documentos') }}
                            <i class="fa fa-document" aria-hidden="true"></i>
                        </a>
                        @elseif(Auth::user()->role === 'Admin')
                        <a class="dropdown-item" href="{{ route('workspace') }}">

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
            </nav>
        </header>

        <div class="home" id="home">
            <div class="filter-home">
                <div class="login-area">
                    <div class="card">
                        <!-- <div class="card-header"><h4>{{ __('Login') }}</h4></div> -->
                        <div class="card-body">
                            <form class="login-form" method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="cnpj" class="col-form-label">{{ __('CNPJ') }}</label>

                                    <input id="cnpj" type="text" onchange="mask()" class="cnpj form-control @error('cnpj') is-invalid @enderror" name="cnpj" value="{{ old('cnpj') }}" required autocomplete="cnpj" autofocus>
                                    @error('cnpj')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-form-label">{{ __('Senha') }}</label>
                                    <div class="password @error('password') is-invalid @enderror">
                                        <input id="password" type="password" class="passwordInput" minLenght="8" maxLength="100" name="password" name="edit-user-password-confirm" required autocomplete="current-password">
                                        <label>
                                            <button type="button" class="passwordToggle" id="password-button" onclick="toggle(this)">
                                                <i class="far fa-eye" id="password-toggle"></i>
                                            </button>
                                        </label>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Lembre de mim') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </main>
    <script>
        function mask() {
            input = document.getElementById('cnpj');
            var x = input.value;
            x = x.replace(/\D/g, "") //Remove tudo o que não é dígito
            x = x.slice(0, 14)
            x = x.replace(/^(\d{2})(\d)/, "$1.$2") //Coloca ponto entre o segundo e o terceiro dígitos
            x = x.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3") //Coloca ponto entre o quinto e o sexto dígitos
            x = x.replace(/\.(\d{3})(\d)/, ".$1/$2") //Coloca uma barra entre o oitavo e o nono dígitos
            x = x.replace(/(\d{4})(\d)/, "$1-$2");
            input.value = x;
        }

        let state = false;

        function toggle(show) {

            let element;
            let icon;
            if (show.id === 'password-button') {
                element = document.getElementById("password");
                icon = document.getElementById("password-toggle");
            }

            if (state) {
                icon.classList.replace("fa-eye-slash", "fa-eye");
                element.setAttribute("type", "password");
                state = false;
            } else {
                icon.classList.replace("fa-eye", "fa-eye-slash");
                element.setAttribute("type", "text")
                state = true;
            }
        }
    </script>
</body>

</html>