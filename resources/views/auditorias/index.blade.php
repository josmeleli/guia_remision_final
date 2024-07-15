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

    <form action="{{ route('auditorias.buscar') }}" method="GET" style="width: 100%;">
        <div class="container p-4" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); min-width: 95%;">
            <h4 class="block">Filtrar por:</h4>
            <div class="d-flex mb-2">
                <input type="text" class="form-control mr-2" name="usuario" placeholder="Usuario">
                <input type="text" class="form-control mr-2" name="rol" placeholder="Rol">
                <input type="text" class="form-control mr-2" name="evento" placeholder="Evento">
                <input type="text" class="form-control mr-2" name="tabla" placeholder="Tabla">
                



            </div>
            <div class="d-flex">
                <input type="text" class="form-control mr-2" name="contenido_antiguo" placeholder="Contenido antiguo">
                <input type="text" class="form-control mr-2" name="contenido_nuevo" placeholder="Contenido nuevo">
                <input type="date" class="form-control mr-2" name="fecha" placeholder="Fecha">

                <a href="/auditorias" class="btn btn-secondary mr-2">Restablecer</a>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

</section>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista Auditorias</h3>
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
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Evento</th>
                    <th>Tabla</th>
                    <th>Contenido antiguo</th>
                    <th>Contenido nuevo</th>
                    <th>Fecha</th>
                    <th>Acciones</th>

                </tr>

            </thead>


            <tbody>

                






                @foreach ($auditorias as $auditoria)
                <tr>
                    <td><input type="checkbox" class="deleteCheckbox" value="{{ $auditoria->id }}" style="cursor: pointer;"></td>
                    <td>{{ $auditoria->id }}</td>
                    <td>{{ $usuariosMapeo[$auditoria->user_id] ?? 'Usuario desconocido' }}</td>
                    <td>{{ $rolesMapeo[$auditoria->user_id] ?? 'Sin roles' }}</td>
                    <td>{{ $auditoria->event }}</td>
                    <td>{{ class_basename($auditoria->auditable_type) }}</td>
                    <td>
                        <ul>
                            @php
                            $oldValues = json_decode($auditoria->old_values, true);
                            @endphp
                            @foreach($oldValues as $key => $value)
                            <li>{{ $key }}: {{ $value }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul>
                            @php
                            $newValues = json_decode($auditoria->new_values, true);
                            @endphp
                            @foreach($newValues as $key => $value)
                            <li>{{ $key }}: {{ $value }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $auditoria->created_at }}</td>




                    <td>
                        <form action="{{ route('auditorias.destroy', $auditoria->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z" stroke-width="0" fill="currentColor" />
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
        var auditoriasSeleccionados = document.querySelectorAll('.deleteCheckbox:checked');
        if (auditoriasSeleccionados.length === 0) {
            alert('Debes seleccionar al menos una auditoria para borrar.');
        } else {
            if (confirm('¿Estás seguro de que quieres borrar las auditorias selecionados?')) {
                var auditoriaIds = [];
                auditoriasSeleccionados.forEach(function(auditoria) {
                    auditoriaIds.push(auditoria.value);
                });
                // Crear un formulario dinámico para enviar la solicitud DELETE
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{route('auditorias.borrar_seleccionados')}}';
                form.innerHTML = '<input type="hidden" name="_method" value="DELETE">' +
                    '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                    '<input type="hidden" name="auditoria_ids" value="' + auditoriaIds.join(',') + '">';
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