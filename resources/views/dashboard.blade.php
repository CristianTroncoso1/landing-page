@php
    $selected = 0;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de control') }}
        </h2>
        @if (Auth::user()->role != 'user')
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Usuarios
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach ($dataset[0] as $users)
                        <a class="dropdown-item" onclick="setearIDCookies({{ $users->id }})">
                            {{ $users->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="dashboard">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-upload">
                            Agregar archivos
                        </button>
                        @include('user.upload')
                        <div class="dashboard__search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                            <input placeholder="Buscar" id="myInput">
                        </div>
                    </div>
                    <table class="table table-bordered table-striped mt-4 tablaDatos">
                        <thead>
                            <tr>
                                <th scope="col" class="tablaDatos__name">Nombre</th>
                                <th scope="col" class="tablaDatos__filename">Archivo</th>
                                <th scope="col" class="tablaDatos__date">Fecha</th>
                                <th scope="col" class="tablaDatos__options"></th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            {{-- Si es administrador --}}
                            @if (Auth::user()->role != 'user')
                                @foreach ($dataset[1] as $data)
                                    @if ($data->user_id == $_COOKIE['search'])
                                        <tr class="tablaDatos__body">
                                            <td class="tablaDatos__body__name">{{ $data->name }}</td>
                                            <td class="tablaDatos__body__filename">{{ $data->file_name }}</td>
                                            <td class="tablaDatos__body__date">{{ $data->created_at }}</td>
                                            <td class="tablaDatos__body__options">
                                                <div class="btn-group dropup tablaDatos__body__options__div">
                                                    <button type="button" class="btn btn-info dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <a class="default">Opciones</a>
                                                        <a class="mobile">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" fill="currentColor"
                                                                class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                            </svg>
                                                        </a>
                                                    </button>
                                                    <div class="dropdown-menu tablaDatos__downloadButton">
                                                        <!-- Dropdown menu links -->
                                                        <a class="dropdown-item"
                                                            href="/filedownload/{{ $data->id }}">
                                                            <i>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor"
                                                                    class="bi bi-cloud-arrow-down" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd"
                                                                        d="M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708l2 2z" />
                                                                    <path
                                                                        d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                                                                </svg>
                                                            </i>
                                                            Descargar
                                                        </a>
                                                        {{-- button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-upload-{{ $cosa = Auth::user()->id}}" --}}
                                                        {{-- <a class="dropdown-item" href="/file/{{$data->id}}/edit"> --}}
                                                        <a class="dropdown-item" type="button" data-toggle="modal"
                                                            data-target="#Rename{{ $data->id }}"
                                                            onclick="setFileID({{ $data->id }})">
                                                            <i>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor"
                                                                    class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                    <path fill-rule="evenodd"
                                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                                </svg>
                                                            </i>
                                                            Renombrar
                                                        </a>
                                                        <a class="dropdown-item" type="button" data-toggle="modal"
                                                            data-target="#Delete{{ $id = $data->id }}">
                                                            <i>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor" class="bi bi-trash"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                                    <path fill-rule="evenodd"
                                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                                </svg>
                                                            </i>
                                                            Borrar
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @include('user.rename')
                                        @include('user.delete')
                                    @endif
                                @endforeach
                            @endif
                            {{-- Si es usuario normal --}}
                            @if (Auth::user()->role == 'user')
                                @foreach ($dataset as $data)
                                    <tr class="tablaDatos__body">
                                        <td class="tablaDatos__body__name">{{ $data->name }}</td>
                                        <td class="tablaDatos__body__filename">{{ $data->file_name }}</td>
                                        <td class="tablaDatos__body__date">{{ $data->created_at }}</td>
                                        <td class="tablaDatos__body__options">
                                            <div class="btn-group dropup tablaDatos__body__options__div">
                                                <button type="button" class="btn btn-info dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <a class="default">Opciones</a>
                                                    <a class="mobile">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            fill="currentColor" class="bi bi-three-dots-vertical"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                        </svg>
                                                    </a>
                                                </button>
                                                <div class="dropdown-menu tablaDatos__downloadButton">
                                                    <!-- Dropdown menu links -->
                                                    <a class="dropdown-item" href="/filedownload/{{ $data->id }}">
                                                        <i>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" fill="currentColor"
                                                                class="bi bi-cloud-arrow-down" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd"
                                                                    d="M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708l2 2z" />
                                                                <path
                                                                    d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                                                            </svg>
                                                        </i>
                                                        Descargar
                                                    </a>
                                                    {{-- button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-upload-{{ $cosa = Auth::user()->id}}" --}}
                                                    {{-- <a class="dropdown-item" href="/file/{{$data->id}}/edit"> --}}
                                                    <a class="dropdown-item" type="button" data-toggle="modal"
                                                        data-target="#Rename{{ $id = $data->id }}"
                                                        onclick="setFileID({{ $data->id }})">
                                                        <i>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor"
                                                                class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                <path fill-rule="evenodd"
                                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                            </svg>
                                                        </i>
                                                        Renombrar
                                                    </a>
                                                    <a class="dropdown-item" type="button" data-toggle="modal"
                                                        data-target="#Delete{{ $id = $data->id }}">
                                                        <i>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-trash"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                                <path fill-rule="evenodd"
                                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                            </svg>
                                                        </i>
                                                        Borrar
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('user.rename')
                                    @include('user.delete')
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



<div class="modal fade" id="Rename" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Cambiar nombre</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/file/{{ $selected }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="uploadModal">
                        <div class="uploadModal__field">
                            <h1>Nuevo nombre</h1>
                            <input name="new-filename" type="text" placeholder="Documento 2021" required>
                        </div>
                    </div>
                    <hr>
                    <div class="uploadModal__buttons">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">
                            Cambiar nombre
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Borrar archivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/file/{{ $selected }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="uploadModal">
                        <div class="uploadModal__field">
                            <h1>Desea borrar el archivo?</h1>
                            <button type="submit" class="btn btn-danger">Borrar archivo</button>
                        </div>
                    </div>
                    <hr>
                    <div class="uploadModal__buttons">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    function setearIDCookies(id) {
        localStorage.setItem('searchID', id);
        document.cookie = "search=" + id;
        location.reload();
    }
    function setFileID(id) {
        console.log(id);
        document.cookie = 'fileid=' + id;
    }

    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
