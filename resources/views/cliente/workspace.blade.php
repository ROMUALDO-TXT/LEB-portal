<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>LEB - Documentos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-LEB.svg') }}">
    <meta name="viewport" content="initial-scale=1, width=device-width">
    <link rel="stylesheet" href="{{ asset('css/areaCliente/cliente.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/areaCliente/files.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/areaCliente/topbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/areaCliente/home.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/areaCliente/footer.css') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
</head>

<body style="width:100vw">
    <header>
        <nav class="navbar navbar-expand-lg topbar">
            <a class="title navbar-brand m-lg-auto" href="{{ route('home') }}">
                <h3>LEB</h3>
            </a>
            <ul class="nav navbar-nav topbar-topics">
                <li class="nav-item title">
                    <h3>Lista de Documentos</h3>
                </li>
            </ul>
            <div class="dropdown">
                <a id="navbarDropdown" class="nav-link topbar-login navbar-text dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ strtok(Auth::user()->name, " ") }}
                </a>

                <div class="dropdown-menu header-menu title" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('home') }}">
                        {{ __('Home') }}
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </a>
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
        </nav>
    </header>

    <div class="home" id="home">
    </div>

    <div class="content">
        <div class="filter-home">
            <div class="area-cliente">
                <div class="folders-projects">
                    <div class="folders-projects-container d-none d-md-block">
                        <h3>Pastas</h3>
                        <h5 class="folders-url">
                            @if($parentUrl !== "#")
                            <a href="{{$parentUrl}}">
                                <i class="fa fa-chevron-circle-left retorno" aria-hidden="true" alt="Retornar a pasta anterior"></i>
                            </a>
                            <a href="{{$parentUrl}}" style="margin-left: 2%">
                                /{{$parentFolder->name}}
                            </a>
                            @endif
                            <span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                                /{{$folder->name}}
                            </span>
                        </h5>
                        <ul class="projects">
                            @if(isset($childFolders) && count($childFolders) > 0)
                            @foreach($childFolders as $c)
                            <li class="folder" id="folder-{{$c->id}}">
                                <i class="fa fa-folder" id="folder-icon"></i>
                                <h5>
                                    <a href="{{route('workspace', ['folder' => $c->id]);}}">
                                        {{$c->name}}
                                    </a>
                                </h5>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="folders-projects-container d-md-none">
                        <h3>Documentos</h3>
                        <div class="d-flex">
                            <p class="folders-url">
                                @if($parentUrl !== "#")
                                <a href="{{$parentUrl}}">
                                    <i class="fa fa-chevron-circle-left retorno" aria-hidden="true" alt="Retornar a pasta anterior"></i>
                                </a>
                                <a href="{{$parentUrl}}" style="margin-left: 2%">
                                    /{{$parentFolder->name}}
                                </a>
                                @endif
                                /{{$folder->name}}
                            </p>
                            <div class="dropdown pastas-list">
                                <button class="btn btn-primary dropdown-toggle pastas-select" type="button" id="folderDropdown" data-bs-toggle="dropdown" aria-expanded="false" <?php echo (isset($childFolders) && count($childFolders) > 0) ? 'title="Sub-pastas"' : 'disabled title="Não há sub-pastas"'; ?>>
                                    Pastas
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="folderDropdown">
                                    @if(isset($childFolders) && count($childFolders) > 0)
                                    @foreach($childFolders as $c)
                                    <li><a class="dropdown-item" href="{{route('workspace', ['folder' => $c->id])}}">{{$c->name}}</a></li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="div1"></div>
                <div class="files-projects">
                    <h3 class="d-none d-md-block">Documentos</h3>
                    <table class="table table-striped nowrap responsive hover filesTable">
                        <thead>
                            <tr>
                                <th class="all">Nome</th>
                                <th class="min-tablet-p">Comentários</th>
                                <th class="min-tablet-p">Data</th>
                                <th class="min-tablet-p">Tipo</th>
                                <th class="all">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')

    @include('admin/preview-document')

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script>
        $(function() {
            function adjustTableProperties() {
                if ($.fn.DataTable.isDataTable('.filesTable')) {
                    $('.filesTable').DataTable().destroy();
                }

                var table = $('.filesTable').DataTable({
                    processing: true,
                    serverSide: false,
                    pageLength: window.innerWidth < 768 ? 4 : 5,
                    scrollCollapse: window.innerWidth < 768,
                    scrollY: window.innerWidth < 768 ? '34vh' : 'inherit',
                    scrollX: false,
                    lengthChange: false,
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
                    },
                    ajax: {
                        url: "{{ route('workspace.files', ['folder'=> $folder->id]) }}",
                        method: "GET",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),

                        }
                    },
                    createdRow: function(row, data, dataIndex) {
                        if (data[2] == `someVal`) {
                            $(row).addClass('darkGrey');
                        } else {
                            $(row).addClass('lightGrey');
                        }
                    },
                    columns: [{
                            width: window.innerWidth < 768 ? '70%' : '30%',
                            data: 'name',
                            name: 'nome',
                            className: 'col-overflow'
                        },
                        {
                            width: '31%',
                            data: 'description',
                            name: 'comentários',
                            className: 'col-break'
                        },
                        {
                            width: '15%',
                            data: 'date',
                            name: 'data'

                        },
                        {
                            width: '10%',
                            data: 'extension',
                            name: 'tipo'

                        },
                        {
                            width: '14%',
                            data: 'action',
                            name: 'ações',
                            className: 'col-actions',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            }

            adjustTableProperties();

            // Adjust when the window is resized
            $(window).on('resize', () => {
                adjustTableProperties()
                window.location.reload();
            });

        });
    </script>
    @if(Session::has('message'))
    <script>
        alert('{{ Session::get("message") }}');
    </script>
    @endif
</body>

</html>