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

    <section class="general mt-3">
        <form action="{{ route('pago.buscar') }}" method="GET" style="width: 100%;">
            <div class="container p-4" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); min-width: 95%;">
                <h4 class="block">Filtrar por:</h4>
                <div class="d-flex mb-2">
                    <input type="text" class="form-control mr-2" name="agricultor_id" placeholder="Agricultor">
                    
                    <input type="text" class="form-control mr-2" name="precio_unitario" placeholder="Precio Unitario">
                    <input type="text" class="form-control mr-2" name="adelanto" placeholder="Adelanto">
                    
                    


                </div>
                <div class="d-flex">
                    <input type="text" class="form-control mr-2" name="tipo_pago" placeholder="Tipo de Pago">
                    <input type="text" class="form-control mr-2" name="num_pago" placeholder="Número de Pago">

                    <a href="/pagos" class="btn btn-secondary mr-2">Restablecer</a>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>

    </section>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Pagos</h3>
            <div class="text-right">
                <button type="button" class="btn btn-danger" onclick="borrarSeleccionadosOtodo()" title=" Borrar Seleccionados">
                    <i class="fas fa-trash-alt"></i>
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal" title="Registrar Pago">
                    <i class="fas fa-plus-circle"></i> 
                </button>
            </div>
            
            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel">Registrar Pago</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulario para registrar la tabla de pagos -->
                            <form action="{{ route('pagos.store') }}" method="POST">
                                @csrf
                                <!-- Campos del formulario -->
                                <div class="form-group">
                                    <label for="agricultor_id">ID del Agricultor</label>
                                    <select class="form-control" id="agricultor_id" name="agricultor_id" required>
                                        @foreach($agricultores as $agricultor)
                                            <option value="{{ $agricultor->id }}">{{ $agricultor->razon_social }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="precio_unitario">Precio Unitario</label>
                                    <input type="number" class="form-control" id="precio_unitario" name="precio_unitario" required>
                                </div>
                                <div class="form-group">
                                    <label for="adelanto">Adelanto</label>
                                    <input type="number" class="form-control" id="adelanto" name="adelanto" required>
                                </div>
                                <div class="form-group">
                                    <label for="tipo_pago">Tipo de Pago</label>
                                    <select class="form-control" id="tipo_pago" name="tipo_pago" required>
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="Tarjeta de Débito">Tarjeta de Débito</option>
                                        <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                                    </select>
                                </div>
                                <!-- Agrega aquí más campos si es necesario -->
                                <button type="submit" class="btn btn-primary">Registrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
                        
        </div>

        <div class="card-body p-2">
            <table class="table table-striped" id="tablaPagos">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAllCheckbox" onchange="selectAll()" style="cursor: pointer;"></th>
                        <th>ID</th>
                        <th>Agricultor</th>
                        <th>Precio Unitario</th>
                        <th>Adelanto</th>
                        <th>Tipo Pago</th>
                        <th>Número Pago</th>
                        <th>Acciones</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($pagos as $pago)
                        <tr>
                            <td><input type="checkbox" class="deleteCheckbox" value="{{ $pago->id }}" style="cursor: pointer;"></td>
                            <td>{{ $pago->id }}</td>
                            <td>{{ $pago->agricultor->nombres }}</td>
                            <td>{{ $pago->precio_unitario }}</td>
                            <td>{{ $pago->adelanto }}</td>
                            <td>{{$pago->tipo_pago}}</td>
                            <td>{{$pago->num_pago}}</td>
                            <td>
                                <button  type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $pago->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                      </svg>
                                </button>
                                <div class="modal fade" id="editModal{{ $pago->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $pago->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title" id="editModalLabel{{ $pago->id }}">Editar Pagos</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Formulario para editar la guía de remisión -->
                                                <form id="editForm{{ $pago->id }}" action="{{ route('pago.update', $pago->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="agricultor_id">Agricultor</label>
                                                        <select class="form-control" id="agricultor_id" name="agricultor_id" required>
                                                            <option value="{{ $pago->agricultor_id }}">{{ $pago->agricultor->nombres }}</option>
                                                            <!-- Aquí puedes agregar opciones adicionales si lo deseas -->
                                                        </select>
                                                    </div>
                                                    
                                                    <!-- Campos para editar -->
                                                    <div class="form-group">
                                                        <label for="precio_unitario">Precio Unitario</label>
                                                        <input type="number" class="form-control" id="precio_unitario" name="precio_unitario" value="{{ $pago->precio_unitario }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="adelanto">Adelanto</label>
                                                        <input type="number" class="form-control" id="adelanto" name="adelanto" value="{{ $pago->adelanto }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tipo_pago">Tipo de Pago</label>
                                                        <select class="form-control" id="tipo_pago" name="tipo_pago" required>
                                                            <option value="Efectivo" {{ $pago->tipo_pago == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                                                            <option value="Tarjeta de Débito" {{ $pago->tipo_pago == 'Tarjeta de Débito' ? 'selected' : '' }}>Tarjeta de Débito</option>
                                                            <option value="Transferencia Bancaria" {{ $pago->tipo_pago == 'Transferencia Bancaria' ? 'selected' : '' }}>Transferencia Bancaria</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="num_pago">Número de Pago</label>
                                                        <input type="number" class="form-control" id="num_pago" name="num_pago" value="{{ $pago->num_pago }}" required>
                                                    </div>
                                                    
                                                   
                                                    
                                                       
                                                
                                                    <!-- Agrega aquí más campos para editar -->
                                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('pago.destroy', $pago->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
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

            <script>
                // Función para seleccionar todas las casillas de verificación
                function selectAll() {
                    var checkboxes = document.querySelectorAll('.deleteCheckbox');
                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = document.getElementById('selectAllCheckbox').checked;
                    });
                }
                
                // Función para borrar elementos seleccionados o todo
                function borrarSeleccionadosOtodo() {
                    var pagosSeleccionados = document.querySelectorAll('.deleteCheckbox:checked');
                    if (pagosSeleccionados.length === 0) {
                        alert('Debes seleccionar al menos un pago  para borrar.');
                    } else {
                        if (confirm('¿Estás seguro de que quieres borrar los pagos selecionados?')) {
                            var pagoIds = [];
                           pagosSeleccionados.forEach(function(pago) {
                                pagoIds.push(pago.value);
                            });
                            // Crear un formulario dinámico para enviar la solicitud DELETE
                            var form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route('pago.borrar_seleccionados') }}';
                            form.innerHTML = '<input type="hidden" name="_method" value="DELETE">' +
                                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                                            '<input type="hidden" name="pago_ids" value="' + pagoIds.join(',') + '">';
                            document.body.appendChild(form);
                            // Enviar el formulario una vez creado
                            form.submit();
                        }
                    }
                }
            </script>

        </div>
        
    </div>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/styleTables.css') }}">
@endsection