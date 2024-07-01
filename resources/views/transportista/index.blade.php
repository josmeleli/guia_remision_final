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

        <form action="{{ route('transportista.buscar') }}" method="GET" style="width: 100%;">
            <div class="container p-4" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); min-width: 95%;">
                <h4 class="block">Filtrar por:</h4>
                <div class="d-flex mb-2">
                    <input type="text" class="form-control mr-2" name="unidad_tecnica" placeholder="Unidad Tecnica">
                    <input type="text" class="form-control mr-2" name="campo" placeholder="Campo">
                    <input type="text" class="form-control mr-2" name="RUC" placeholder="RUC">


                </div>
                <div class="d-flex">
                    <input type="text" class="form-control mr-2" name="razon_social" placeholder="Razon Social">
                    <input type="text" class="form-control mr-2" name="codigo" placeholder="Codigo">
                    <input type="text" class="form-control mr-2" name="zona" placeholder="Zona">
                    
                    <a href="/transportistas" class="btn btn-secondary mr-2">Restablecer</a>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>

    </section>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Transportistas</h3>
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
                        <th>Unidad Tecnica</th>
                        <th>Campo</th>
                        <th>RUC</th>
                        <th>Razon Social</th>
                        <th>Codigo</th>
                        <th>Zona</th>
                        <th>Acciones</th>
                        
                    </tr>

                </thead>
                <tbody>
                    @foreach ($transportistas as $transportista)
                        <tr>
                            <td><input type="checkbox" class="deleteCheckbox" value="{{ $transportista->id }}" style="cursor: pointer;"></td>
                            <td>{{ $transportista->id }}</td>
                            <td>{{ $transportista->unidad_tecnica }}</td>
                            <td>{{ $transportista->campo }}</td>
                            <td>{{ $transportista->RUC }}</td>
                            <td>{{ $transportista->razon_social }}</td>
                            <td>{{ $transportista->codigo }}</td>
                            <td>{{ $transportista->zona }}</td>
                            
                            
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $transportista->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                      </svg>
                                </button>
                                <div class="modal fade" id="editModal{{ $transportista->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $transportista->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title" id="editModalLabel{{ $transportista->id }}">Editar Conductor</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Formulario para editar la guía de remisión -->
                                                <form id="editForm{{ $transportista->id }}" action="{{ route('transportista.update', $transportista->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Campos para editar -->
                                                    <div class="form-group row">
                                                        <div class="col-md-6 ">
                                                            <label for="unidad_tecnica">Unidad Tecnica:</label>
                                                            <input type="text" class="form-control" id="unidad_tecnica" name="unidad_tecnica" value="{{ $transportista->unidad_tecnica }}" required>
    
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="campo">Campo: </label>
                                                            <input type="text" class="form-control" id="campo" name="campo" value="{{ $transportista->campo    }}" required>
    
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-6 ">
                                                            <label for="RUC">RUC:</label>
                                                            <input type="text" class="form-control" id="RUC" name="RUC" value="{{ $transportista->RUC }}" required>
    
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="razon_social">Razon Social: </label>
                                                            <input type="text" class="form-control" id="razon_social" name="razon_social" value="{{ $transportista->razon_social }}" required>
                                                            
    
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-6 ">
                                                            <label for="codigo">CODIGO:</label>
                                                            <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $transportista->codigo }}" required>
    
                                                        </div>
                                                        <div class="col-md-6 ">
                                                            <label for="zona">Zona:</label>
                                                            <input type="text" class="form-control" id="zona" name="zona" value="{{ $transportista->zona }}" required>
    
                                                        </div>
                                                       
                                                    </div>
                                                   
                                               
                                                    <!-- Agrega aquí más campos para editar -->
                                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('transportista.destroy', $transportista->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
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
                    var transportistasSeleccionados = document.querySelectorAll('.deleteCheckbox:checked');
                    if (transportistasSeleccionados.length === 0) {
                        alert('Debes seleccionar al menos un transportista  para borrar.');
                    } else {
                        if (confirm('¿Estás seguro de que quieres borrar los transportistas selecionados?')) {
                            var transportistaIds = [];
                           transportistasSeleccionados.forEach(function(transportista) {
                                transportistaIds.push(transportista.value);
                            });
                            // Crear un formulario dinámico para enviar la solicitud DELETE
                            var form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route('transportista.borrar_seleccionados') }}';
                            form.innerHTML = '<input type="hidden" name="_method" value="DELETE">' +
                                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                                            '<input type="hidden" name="transportista_ids" value="' + transportistaIds.join(',') + '">';
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
