@extends('layouts.sidebar')

@extends('layouts.header')
<!-- Aquí puedes agregar tu formulario, tabla u otro contenido -->




@section('content')

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

@if(session('warning'))
<div class="alert alert-warning">
    {{ session('warning') }}
</div>
@endif


<section class="general mt-3">

    <form action="{{ route('conductor.buscar') }}" method="GET" style="width: 100%;">
        <div class="container p-4" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); min-width: 95%;">
            <h4 class="block">Filtrar por:</h4>
            <div class="d-flex mb-2">
                <input type="text" class="form-control mr-2" name="dni" placeholder="DNI">
                <input type="text" class="form-control mr-2" name="brevete" placeholder="Brevete">

            </div>
            <div class="d-flex">
                <input type="text" class="form-control mr-2" name="nombre_apellidos" placeholder="Nombres y Apellidos">
                <input type="text" class="form-control mr-2" name="telefono" placeholder="Telefono">
                <a href="/conductores" class="btn btn-secondary mr-2">Restablecer</a>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

</section>



<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Conductores</h3>
        <div class="text-right">
            <button type="button" class="btn btn-danger" onclick="borrarSeleccionadosOtodo()" title=" Borrar Seleccionados">
                <i class="fas fa-trash-alt"></i>
            </button>

        </div>
    </div>

    <div class="card-body p-2">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAllCheckbox" onchange="selectAll()" style="cursor: pointer;"></th>
                    <th>ID</th>
                    <th>Brevete</th>
                    <th>DNI</th>
                    <th>Nombres y Apellidos</th>
                    <th>Telefono</th>

                    <th>Acciones</th>

                </tr>

            </thead>
            <tbody>
                @foreach ($choferes as $chofer)
                <tr>
                    <td><input type="checkbox" class="deleteCheckbox" value="{{ $chofer->id }}" style="cursor: pointer;"></td>
                    <td>{{ $chofer->id }}</td>
                    <td>{{ $chofer->brevete }}</td>
                    <td>{{ $chofer->dni }}</td>
                    <td>{{ $chofer->nombre_apellidos }}</td>
                    <td>{{ $chofer->telefono }}</td>



                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $chofer->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                        </button>
                        <div class="modal fade" id="editModal{{ $chofer->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $chofer->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h5 class="modal-title" id="editModalLabel{{ $chofer->id }}">Editar Conductor</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Formulario para editar la guía de remisión -->
                                        <form id="editForm{{ $chofer->id }}" action="{{ route('conductor.update', $chofer->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <!-- Campos para editar -->

                                            <div class="col-md-6 ">
                                                <label for="brevete">Brevete:</label>
                                                <input type="text" class="form-control" id="brevete" name="brevete" value="{{ $chofer->brevete }}" required>

                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6 ">
                                                    <label for="dni">DNI:</label>
                                                    <input type="number" class="form-control" id="dni" name="dni" value="{{ $chofer->dni }}" required>

                                                </div>
                                                <div class="col-md-6">
                                                    <label for="nombre_apellidos">Nombres y Apellidos: </label>
                                                    <input type="text" class="form-control" id="nombre_apellidos" name="nombre_apellidos" value="{{ $chofer->nombre_apellidos }}" required>

                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6 ">
                                                    <label for="telefono">Telefono:</label>
                                                    <input type="number" class="form-control" id="telefono" name="telefono" value="{{ $chofer->telefono }}" required>

                                                </div>



                                            </div>


                                            <!-- Agrega aquí más campos para editar -->
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('conductor.destroy', $chofer->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16zm-9.489 5.14a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" stroke-width="0" fill="currentColor" />
                                    <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>
@endsection

@section('js')
<script>
    function selectAll() {
        var checkboxes = document.querySelectorAll('.deleteCheckbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = document.getElementById('selectAllCheckbox').checked;
        });
    }

    function borrarSeleccionadosOtodo() {
        var choferesSeleccionados = document.querySelectorAll('.deleteCheckbox:checked');
        if (choferesSeleccionados.length === 0) {
            alert('Debes seleccionar al menos un chofer para borrar.');
        } else {
            if (confirm('¿Estás seguro de que quieres borrar los choferes selecionados?')) {
                var choferIds = [];
                choferesSeleccionados.forEach(function(chofer) {
                    choferIds.push(chofer.value);
                });
                // Crear un formulario dinámico para enviar la solicitud DELETE
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('chofer.borrar_seleccionados')}}';
                form.innerHTML = '<input type="hidden" name="_method" value="DELETE">' +
                    '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                    '<input type="hidden" name="chofer_ids" value="' + choferIds.join(',') + '">';
                document.body.appendChild(form);
                // Enviar el formulario una vez creado
                form.submit();
            }
        }
    }
</script>


@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/styleTables.css') }}">
@endsection