@extends('layouts.app')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <h1>Lista de Botões para Acessar Rotas</h1>

                    <h2>Usuários:</h2>
                    <a href="{{ route('user-list') }}" class="btn btn-primary">Listar Usuários</a>
                    <a href="{{ route('user-add') }}" class="btn btn-primary">Adicionar Usuário</a>
                    <form action="{{ route('user-register') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Registrar Usuário</button>
                    </form>
                    <a href="{{ route('user-remove', ['id' => 1]) }}" class="btn btn-danger">Remover Usuário</a>

                    <h2>Arquivos:</h2>
                    <a href="{{ route('list-files') }}" class="btn btn-primary">Listar Arquivos</a>
                    <a href="{{ route('add-file') }}" class="btn btn-primary">Adicionar Arquivo</a>
                    <a href="{{ route('remove-file', ['id' => 1]) }}" class="btn btn-danger">Remover Arquivo</a>

                    <h2>Pastas:</h2>
                    <a href="{{ route('list-folder') }}" class="btn btn-primary">Listar Pastas</a>
                    <a href="{{ route('add-folder') }}" class="btn btn-primary">Adicionar Pasta</a>
                    <a href="{{ route('remove-folder', ['id' => 1]) }}" class="btn btn-danger">Remover Pasta</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection