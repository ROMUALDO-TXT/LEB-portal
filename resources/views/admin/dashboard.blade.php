<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>LEB - Dashboard</title>
    <meta name="viewport" content="initial-scale=1, width=device-width">
    <link rel="stylesheet" href="{{ asset('css/areaAdmin/cliente.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/areaAdmin/files.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/areaAdmin/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/areaAdmin/sidebar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/areaAdmin/topbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/areaAdmin/home.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/areaAdmin/footer.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/areaAdmin/admin.css') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg topbar sticky-top">
            <a class="title navbar-brand m-lg-auto" href="{{ route('home') }}">
                <h3>LEB</h3>
            </a>
            <ul class="nav navbar-nav topbar-topics">
                <li class="nav-item title">
                    <h3>Painel de administração</h3>
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
    <div class="d-block content">
        <div class="row flex-nowrap">
            <div class="sidebar col-auto col-md-3 col-xl-2">
                <div class="d-flex flex-column align-items-center align-items-sm-start text-white min-vh-100">
                    <div class="px-3 pt-2 pb-5 text-decoration-none sidebar-top"></div>
                    <ul class="px-3 pt-2 nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start sidebar-content" id="menu">
                        <li class="nav-items">
                            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link mt-3 px-0 align-middle">
                                <i class="fs-4 fa fa-briefcase"></i> <span class="ms-2 me-5 d-none d-sm-inline">Clientes</span> <i class="ms-2 me-0 fa fa-chevron-down" aria-hidden="true"></i>
                            </a>
                            <hr style="margin: .1em auto;">
                            <ul class="collapse show nav flex-column ms-4 menu-clientes" id="submenu1" data-bs-parent="#menu">
                                @for($i = 0; $i < 10; $i++) @foreach($clientes as $cl) <!---->
                                    <li class="nav-clientes">
                                        <a href="{{route('dashboard', ['cliente' => $cl->id])}}" class="nav-link px-0"> {{$cl->name}}</a>
                                    </li>
                                    @endforeach
                                    @endfor
                            </ul>
                        </li>
                        <li class="nav-items">
                            <a href="#submenu2" data-bs-toggle="collapse" class="nav-link mt-3 px-0 align-middle ">
                                <i class="fs-4 fa fa-user-tie"></i> <span class="ms-2 me-2 d-none d-sm-inline">Administradores</span><i class="ms-auto me-0 fa fa-chevron-down" aria-hidden="true"></i>
                            </a>
                            <hr style="margin: .1em auto;">
                            <ul class="collapse nav flex-column ms-4 menu-clientes" id="submenu2" data-bs-parent="#menu">
                                @for($i = 0; $i < 10; $i++) @foreach($admins as $adm) <!---->
                                    <li class="nav-clientes">
                                        <a href="{{route('dashboard', ['admin' => $adm->id])}}" class="nav-link px-0"> {{$adm->name}}</a>
                                    </li>
                                    @endforeach
                                    @endfor
                            </ul>
                        </li>
                        <li>
                            <a onclick="newUserModal()" class="nav-link mt-3 px-0 align-middle">
                                <i class="fs-4 fa fa-user-plus"></i> 
                                <span class="ms-1 d-none d-sm-inline">Novo Usuário</span> 
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="filter-home col py-3">
                @if(!empty($clienteId) && !is_null($clienteId))
                @if(!empty($cliente) && !is_null($cliente))
                <div class="area-cliente">
                    <div class="cliente-data">
                        <h5><b>Cliente: </b>{{$cliente->name}}</h5>
                        <h5><b>CNPJ: </b>{{$cliente->cnpj}}</h5>
                        <button class="btn btn-primary btn-editar-cliente">Editar <i class="fa fa-regular fa-pen"></i></button>
                    </div>
                    <div class="div-horizontal"></div>
                    <div class="files-folders">
                        <div class="folders-projects">
                            <div class="folders-projects-container d-none d-md-block">
                                <h3>Pastas</h3>
                                <div class="url-container">
                                    <h5 class="folders-url">
                                        @if($parentUrl !== "#")
                                        <a href="{{$parentUrl}}">
                                            <i class="fa fa-chevron-circle-left retorno" aria-hidden="true" alt="Retornar a pasta anterior"></i>
                                        </a>
                                        <a href="{{$parentUrl}}" style="margin-left: 2%">
                                            /{{is_null($parentFolder) ? null : $parentFolder->name}}
                                        </a>
                                        @endif
                                        /{{is_null($folder) ? null : $folder->name}}
                                    </h5>
                                    <button class="btn btn-success btn-add-folder" onclick="newFolderModal()"><i class="fa fa-regular fa-plus"></i></button>
                                </div>
                                <ul class="projects">
                                    @if(isset($childFolders) && count($childFolders) > 0)
                                    @foreach($childFolders as $c)
                                    <li class="folder" id="folder-{{$c->id}}">
                                        <i class="fa fa-folder" id="folder-icon"></i>
                                        <h5>
                                            <a href="{{route('dashboard', ['cliente'=>$cliente->id, 'folder' => $c->id]);}}">
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
                                            /{{is_null($parentFolder) ? null : $parentFolder->name}}
                                        </a>
                                        @endif
                                        /{{is_null($folder) ? null : $folder->name}}
                                    </p>
                                    <div class="dropdown pastas-list">
                                        <button class="btn btn-primary dropdown-toggle pastas-select" type="button" id="folderDropdown" data-bs-toggle="dropdown" aria-expanded="false" <?php echo (isset($childFolders) && count($childFolders) > 0) ? 'title="Sub-pastas"' : 'disabled title="Não há sub-pastas"'; ?>>
                                            Pastas
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="folderDropdown">
                                            @if(isset($childFolders) && count($childFolders) > 0)
                                            @foreach($childFolders as $c)
                                            <li><a class="dropdown-item" href="{{route('dashboard', ['cliente'=>$cliente->id, 'folder' => $c->id])}}">{{$c->name}}</a></li>
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="div-vertical"></div>
                        </div>
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
                @else
                <div class="area-cliente d-flex">
                    <h3 class="d-flex mx-auto my-auto"> {{$error}}</h3>
                </div>
                @endif
                @elseif(!empty($adminId) && !is_null($adminId))
                @if(!empty($admin) && !is_null($admin))
                <div class="area-admin">
                    <div class="admin-data">
                        <h5><b>Nome: </b>{{$admin->name}}</h5>
                        <h5><b>CNPJ: </b>{{$admin->cnpj}}</h5>
                        <button class="btn btn-primary btn-editar-cliente">Editar <i class="fa fa-regular fa-pen"></i></button>
                    </div>
                    <div class="div-horizontal"></div>
                    <div class="activities">
                        <table class="table table-striped nowrap responsive hover activitiesTable">
                            <thead>
                                <tr>
                                    <th class="all">Cliente</th>
                                    <th class="min-tablet-p">Arquivo</th>
                                    <th class="min-tablet-p">Data</th>
                                    <th class="min-tablet-p">Operação</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="area-admin d-flex">
                    <h3 class="d-flex mx-auto my-auto"> {{$error}}</h3>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>


    @include('admin/edit-file')
    @include('admin/edit-folder')
    @include('admin/edit-user')

    <div class="modal fade" id="modalDocs" tabindex="-1" aria-labelledby="modalDocsLabel" aria-hidden="true" style='overflow-y: hidden;'>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Projetos em Andamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                </div>
            </div>
        </div>
    </div>

    <!-- @include('layouts.footer') -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/sidenav.js') }}"></script>

    @if(!empty($cliente) && !is_null($cliente))
    <script>
        $(function() {
            function adjustTableProperties() {
                if ($.fn.DataTable.isDataTable('.filesTable')) {
                    $('.filesTable').DataTable().destroy();
                }

                var table = $('.filesTable').DataTable({
                    processing: true,
                    serverSide: true,
                    pageLength: window.innerWidth < 768 ? 4 : 5,
                    scrollCollapse: window.innerWidth < 768,
                    scrollY: window.innerWidth < 768 ? '34vh' : 'inherit',
                    lengthChange: false,
                    responsive: true,
                    dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [{
                        text: 'Adicionar <i class="fa fa-plus"></i>',
                        className: 'btn-add-files btn btn-success',
                        action: function() {
                            $('#edit-file-modal').modal('show')
                            fill({});
                        }
                    }],

                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
                    },
                    ajax: {
                        url: "{{ route('dashboard.files')}}",
                        method: "GET",
                        data: {
                            folder: "{{ is_null($folder) ? null : $folder->id }}" || undefined,
                            cliente: "{{ is_null($cliente) ? null : $cliente->id }}" || undefined,
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
                            name: 'nome'
                        },
                        {
                            width: '35%',
                            data: 'description',
                            name: 'comentários'
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
                            width: '10%',
                            data: 'action',
                            name: 'ações',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                table.on('init.dt', function() {
                    // Remova a classe dt-buttons dos botões
                    $('.dt-button').removeClass('dt-button');
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
    @endif

    @if(!empty($admin) && !is_null($admin))
    <script>
        $(function() {
            function adjustActivitiesProperties() {
                if ($.fn.DataTable.isDataTable('.activitiesTable')) {
                    $('.activitiesTable').DataTable().destroy();
                }

                var atividades = $('.activitiesTable').DataTable({
                    processing: true,
                    serverSide: true,
                    pageLength: window.innerWidth < 768 ? 5 : 7,
                    scrollCollapse: window.innerWidth < 768,
                    scrollY: window.innerWidth < 768 ? '34vh' : 'inherit',
                    lengthChange: true,
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
                        lengthMenu: '<h3 class="d-none d-md-block">Operações realizadas</h3>',
                    },
                    ajax: {
                        url: "{{ route('dashboard.activities')}}",
                        method: "GET",
                        data: {
                            admin: "{{ is_null($admin) ? null : $admin->id }}" || undefined,
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
                            data: 'cliente',
                            name: 'Cliente'
                        },
                        {
                            width: '35%',
                            data: 'file',
                            name: 'Arquivo'
                        },
                        {
                            width: '15%',
                            data: 'date',
                            name: 'data'

                        },
                        {
                            width: '10%',
                            data: 'action',
                            name: 'Operação'

                        },
                    ]
                });
            }

            adjustActivitiesProperties();

            // Adjust when the window is resized
            $(window).on('resize', () => {
                adjustActivitiesProperties();
                window.location.reload();
            });

        });
    </script>
    @endif
</body>

</html>