@extends('layouts.sidebar')

@extends('layouts.header')

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

<div class="row">

    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="col-md-12 mb-4">
                    <h5 class="card-title">Total de Guias Emitidas </h5>
                </div>

                <div class="row">
                    <div class="col-md-6 text-center">
                        <i class="fas fa-list-alt fa-2x text-white"></i>
                    </div>

                    <div class="col-md-6 text-center">
                        <span class="badge badge-primary" style="font-size: 20px; border-radius: 10px;">{{ $totalGuias }}</span>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- Guias por Estado -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Guias por Estado</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group mt-3">
                            @foreach($guiasPorEstado as $estado => $cantidad)
                            @if($estado === 'Guía Facturada' || $estado === 'Guía por Facturar')
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $estado }}
                                <span class="badge badge-{{ $estado === 'Guía Facturada' ? 'success' : 'info' }} badge-pill">{{ $cantidad }}</span>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group mt-3">
                            @foreach($guiasPorEstado as $estado => $cantidad)
                            @if($estado === 'Factura Cancelada' || $estado === 'Factura por Cancelar')
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $estado }}
                                <span class="badge badge-{{ $estado === 'Factura Cancelada' ? 'danger' : 'warning' }} badge-pill">{{ $cantidad }}</span>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <div class="col-md-3 mb-4">
        <div class="card bg-warning">
            <div class="card-body">
                <div class="col-md-12 mb-4">
                    <h5 class="card-title">Guias Emitidas (Hoy)</h5>
                </div>
                <div class="row">
                    <div class="col-md-6 text-center">
                        <i class="fas fa-calendar-day fa-2x "></i>

                    </div>
                    <div class="col-md-6 text-center">
                        <p class="badge badge-primary" style="font-size: 20px; border-radius: 10px;">{{ $guiasHoy }}</p>

                    </div>
                </div>


            </div>
        </div>
    </div>



</div>

<hr style="border-top: 1px solid #ccc;">

<div class="container">


    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="filtro"><i class="fas fa-filter"></i> Filtrar por:</label>
                <select class="form-control" id="filtro">
                    <option value="texto">Texto</option>
                    <option value="fecha">Fecha</option>
                    <option value="estado">Estado</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group" id="contenedorFecha" style="display: none;">
                <label for="fecha"><i class="far fa-calendar-alt"></i> Fecha:</label>
                <input type="date" class="form-control" id="fecha">
            </div>
            <div class="form-group" id="contenedorTexto">
                <label for="texto"><i class="fas fa-search"></i> Texto:</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="texto" placeholder="Ingrese el valor de filtrado">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="form-group" id="contenedorEstado" style="display: none;">
                <label for="estado"><i class="fas fa-check-circle"></i> Estado:</label>
                <select class="form-control" id="estado">
                    <option value="">Seleccionar Estado</option>
                    <option value="guia_facturada">Guia Facturada</option>
                    <option value="guia_por_facturar">Guia por Facturar</option>
                    <option value="factura_cancelada">Factura Cancelada</option>
                    <option value="factura_por_cancelar">Factura por Cancelar</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 d-flex align-items-end mb-3">
            <button type="button" class="btn btn-secondary" onclick="limpiarCampos()">
                <i class="fas fa-times-circle mr-1"></i> Limpiar Campos
            </button>
        </div>
    </div>
    <script src="js/filtros.js"></script>


    <div class="row">
        <div class="col-md-6">
            <h3>Guias de Remision</h3>
        </div>

        <div class="col-md-6 text-right">
            <button type="button" class="btn btn-danger" onclick="borrarSeleccionadosOtodo()" title=" Borrar Seleccionados">
                <i class="fas fa-trash-alt"></i>
            </button>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRegistrarGuia" title="Registrar Guía de Remisión">
                <i class="fas fa-plus-circle"></i> <!-- Solo el icono -->
            </button>

            <a href="/reporte-guias" class="btn btn-success">
                <i class="fas fa-file-excel"></i>
            </a>

            <div class="modal fade" id="modalRegistrarGuia" tabindex="-1" aria-labelledby="modalRegistrarGuiaLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalRegistrarGuiaLabel">Registrar Guía de Remisión</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Aquí coloca tu formulario para registrar la guía de remisión -->
                            <form action="{{ route('guia_remision.store') }}" method="POST">
                                @csrf

                                <div class="container mt-5">
                                    <!-- Información del Remitente (Agricultor) -->
                                    <div class="card mb-4">
                                        <div class="card-header d-flex align-items-center">
                                            <h5><i class="fas fa-user"></i> Información del Remitente (Agricultor)</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="date" class="form-control" id="fecha_emision" name="fecha_emision" placeholder="Fecha de Emisión">
                                                </div>
                                                <script src="js/days.js"></script>

                                                <div class="mr-4"></div>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                    </div>


                                                    <input type="text" class="form-control pr-2" id="rucInput" name="ruc_agricultor" placeholder="RUC">

                                                </div>
                                            </div>

                                            <div class="d-flex mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                    </div>
                                                    <input type="text" id="razonSocialInput" class="form-control" name="razon_social_remitente" placeholder="Razón Social del Remitente">
                                                </div>

                                                <div class="mr-4"></div>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="direccionInput" name="direccion_remitente" placeholder="Dirección del Remitente">
                                                </div>

                                            </div>

                                        </div>
                                    </div>


                                    <!-- Información del Transportista -->
                                    <div class="card mb-4">
                                        <div class="card-header d-flex align-items-center">
                                            <h5><i class="fas fa-truck"></i> Información del Transportista</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="date" class="form-control" id="fecha_emision_transportista" name="fecha_emision_transportista" placeholder="Fecha de Emisión (Transportista)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control pr-2" id="rucInput" name="ruc_transportista" placeholder="RUC del Transportista">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="razonSocialInput" name="razon_social_transportista" placeholder="Razón Social del Transportista">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="direccionInput" name="direccion_transportista" placeholder="Dirección del Transportista">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <!-- Información de la Guía de Remisión -->
                                    <div class="card mb-4">
                                        <div class="card-header d-flex align-items-center">
                                            <h5 class="mb-0"><i class="fas fa-clipboard-list mr-2"></i> Información de la Guía de Remisión</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-list-ol"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="nro_guia" name="nro_guia" placeholder="Número de Guía" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-ticket-alt"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="nro_ticket" name="nro_ticket" placeholder="Número de Ticket" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="date" class="form-control" id="fecha_partida" name="fecha_partida" placeholder="Fecha de Partida" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="punto_partida" name="punto_partida" placeholder="Punto de Partida" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="punto_llegada" name="punto_llegada" placeholder="Punto de Llegada" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-box"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="producto" name="producto" placeholder="Producto Transportado" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-weight-hanging"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="peso_bruto" name="peso_bruto" placeholder="Peso Bruto" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                                            </div>
                                                            <select class="form-control" id="estado" name="estado" required>
                                                                <option value="">Seleccionar Estado</option>
                                                                <option value="guia_facturada">Guía Facturada</option>
                                                                <option value="guia_por_facturar">Guía por Facturar</option>
                                                                <option value="factura_cancelada">Factura Cancelada</option>
                                                                <option value="factura_por_cancelar">Factura por Cancelar</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>


                                <div class="text-center mb-0">
                                    <button type="submit" class="btn btn-primary"> GUARDAR <i class="fas fa-save"></i></button>
                                    <button type="reset" class="btn btn-secondary " id="limpiar-btn">
                                        <i class="fas fa-broom"></i> Limpiar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <!-- Puedes agregar un botón de enviar dentro del modal si lo deseas -->
                            <!-- <button type="submit" form="formularioRegistrarGuia" class="btn btn-primary">Guardar</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div id="tables-wrapper" class="tables-wrapper">


        @foreach($guias->chunk(4) as $chunk)
        <table class="table table-striped" id="tablaGuias">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAllCheckbox" onchange="selectAll()" style="cursor: pointer;"></th>
                    <th>ID</th>
                    <th>Fecha Emision</th>
                    <th>N° Guia</th>
                    <th>N° de Ticket</th>
                    <th>Fecha de Partida</th>
                    <th>Punto Partida</th>
                    <th>Punto Llegada</th>
                    <th>Producto</th>
                    <th>Peso Bruto</th>
                    <th>Estado</th>
                    <th>Acciones</th> <!-- Nueva columna para las acciones CRUD -->
                </tr>
            </thead>
            <tbody>
                @foreach($chunk as $guia)
                <tr>
                    <td><input type="checkbox" class="deleteCheckbox" value="{{ $guia->id }}" style="cursor: pointer;"></td>
                    <td>{{ $guia->id }}</td>
                    <td>{{ $guia->fecha_emision }}</td>
                    <td>{{ $guia->nro_guia }}</td>
                    <td>{{ $guia->nro_ticket }}</td>
                    <td>{{ $guia->fecha_partida }}</td>
                    <td>{{ $guia->punto_partida }}</td>
                    <td>{{ $guia->punto_llegada }}</td>
                    <td>{{ $guia->producto }}</td>
                    <td>{{ $guia->peso_bruto }}</td>
                    <td>{{ ucwords(str_replace('_', ' ', $guia->estado)) }}</td>

                    <td style="display: flex;  justify-content: center; gap: 5px;">

                    <button type="button"class="btn btn-primary btn-sm" style="width: 38px; height: 30px; padding: 5px 10px;" data-toggle="modal" data-target="#editModal{{ $guia->id }}" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>

                        <!-- Modal para editar la guía de remisión -->
                        <div class="modal fade" id="editModal{{ $guia->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $guia->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h5 class="modal-title" id="editModalLabel{{ $guia->id }}">Editar Guía de Remisión</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Formulario para editar la guía de remisión -->
                                        <form id="editForm{{ $guia->id }}" action="{{ route('guias.update', $guia->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <!-- Campos para editar -->
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label for="fecha_emision">Fecha de Emisión</label>
                                                    <input type="date" class="form-control" id="fecha_emision" name="fecha_emision" value="{{ $guia->fecha_emision }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="nro_guia">N° de Guía de Remisión</label>
                                                    <input type="text" class="form-control" id="nro_guia" name="nro_guia" value="{{ $guia->nro_guia }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label for="nro_ticket">N° de Ticket</label>
                                                    <input type="text" class="form-control" id="nro_ticket" name="nro_ticket" value="{{ $guia->nro_ticket }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="fecha_partida">Fecha de Partida</label>
                                                    <input type="date" class="form-control" id="fecha_partida" name="fecha_partida" value="{{ $guia->fecha_partida }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label for="punto_partida">Punto de Partida</label>
                                                    <input type="text" class="form-control" id="punto_partida" name="punto_partida" value="{{ $guia->punto_partida }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="punto_llegada">Punto de Llegada</label>
                                                    <input type="text" class="form-control" id="punto_llegada" name="punto_llegada" value="{{ $guia->punto_llegada }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label for="producto">Producto</label>
                                                    <input type="text" class="form-control" id="producto" name="producto" value="{{ $guia->producto }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="peso_bruto">Peso Bruto</label>
                                                    <input type="text" class="form-control" id="peso_bruto" name="peso_bruto" value="{{ $guia->peso_bruto }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label for="estado">Estado</label>
                                                    <select class="form-control" id="estado" name="estado" required>
                                                        <option value="">Seleccionar Estado</option>
                                                        <option value="guia_facturada" {{ $guia->estado == 'guia_facturada' ? 'selected' : '' }}>Guía Facturada</option>
                                                        <option value="guia_por_facturar" {{ $guia->estado == 'guia_por_facturar' ? 'selected' : '' }}>Guía por Facturar</option>
                                                        <option value="factura_cancelada" {{ $guia->estado == 'factura_cancelada' ? 'selected' : '' }}>Factura Cancelada</option>
                                                        <option value="factura_por_cancelar" {{ $guia->estado == 'factura_por_cancelar' ? 'selected' : '' }}>Factura por Cancelar</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="ruc_agricultor">RUC del Agricultor</label>
                                                    <select class="form-control" id="ruc_agricultor" name="ruc_agricultor" required>
                                                        <option value="">Seleccionar RUC del Agricultor</option>
                                                        @foreach($agricultores as $agricultor)
                                                        <option value="{{ $agricultor->ruc }}" {{ $guia->agricultor->ruc == $agricultor->ruc ? 'selected' : '' }}>{{ $agricultor->ruc }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label for="ruc_transportista">RUC del Transportista</label>
                                                    <select class="form-control" id="ruc_transportista" name="ruc_transportista" required>
                                                        <option value="">Seleccionar RUC del Transportista</option>
                                                        @foreach($transportistas as $transportista)
                                                        <option value="{{ $transportista->RUC }}" {{ $guia->transportista->RUC == $transportista->RUC ? 'selected' : '' }}>{{ $transportista->RUC }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="text-center mb-0">
                                                <button type="submit" class="btn btn-primary"> Guardar Cambios <i class="fas fa-save"></i></button>

                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
    <a href="{{ route('guia-remision.mostrar', $guia->id) }}" target="_blank" class="btn btn-danger">
        <i class="fas fa-file-pdf"></i>
    </a>
</div>

                        
                        <form action="{{ route('guias.destroy', $guia->id) }}" method="POST" style="display: flex; align-items: center; justify-content: center;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Borrar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
        @endforeach
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
                var guiasSeleccionadas = document.querySelectorAll('.deleteCheckbox:checked');
                if (guiasSeleccionadas.length === 0) {
                    alert('Debes seleccionar al menos una guía de remisión para borrar.');
                } else {
                    if (confirm('¿Estás seguro de que quieres borrar las guías de remisión seleccionadas?')) {
                        var guiaIds = [];
                        guiasSeleccionadas.forEach(function(guia) {
                            guiaIds.push(guia.value);
                        });
                        // Crear un formulario dinámico para enviar la solicitud DELETE
                        var form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('guia_remision.borrar_seleccionados')}}';
                        form.innerHTML = '<input type="hidden" name="_method" value="DELETE">' +
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                            '<input type="hidden" name="guia_ids" value="' + guiaIds.join(',') + '">';
                        document.body.appendChild(form);
                        // Enviar el formulario una vez creado
                        form.submit();
                    }
                }
            }


            /*document.addEventListener("DOMContentLoaded", function() {
                document.getElementById('filtro').addEventListener('change', function() {
                    // Ocultar todos los contenedores
                    document.getElementById('contenedorTexto').style.display = 'none';
                    document.getElementById('contenedorFecha').style.display = 'none';
                    document.getElementById('contenedorEstado').style.display = 'none';

                    // Mostrar el contenedor correspondiente al valor seleccionado
                    switch (this.value) {
                        case 'texto':
                            document.getElementById('contenedorTexto').style.display = 'block';
                            break;
                        case 'fecha':
                            document.getElementById('contenedorFecha').style.display = 'block';
                            break;
                        case 'estado':
                            document.getElementById('contenedorEstado').style.display = 'block';
                            break;
                    }
                });
            });*/
        </script>







    </div>

    <div class="navigation">
        <button id="prev-btn" onclick="prevTable()">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-big-right-filled" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12.089 3.634a2 2 0 0 0 -1.089 1.78l-.001 2.586h-6.999a2 2 0 0 0 -2 2v4l.005 .15a2 2 0 0 0 1.995 1.85l6.999 -.001l.001 2.587a2 2 0 0 0 3.414 1.414l6.586 -6.586a2 2 0 0 0 0 -2.828l-6.586 -6.586a2 2 0 0 0 -2.18 -.434l-.145 .068z" stroke-width="0" fill="currentColor" />
            </svg>
        </button>
        <div id="table-numbers" class="table-numbers"></div>
        <button id="next-btn" onclick="prevTable()">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-big-right-filled" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12.089 3.634a2 2 0 0 0 -1.089 1.78l-.001 2.586h-6.999a2 2 0 0 0 -2 2v4l.005 .15a2 2 0 0 0 1.995 1.85l6.999 -.001l.001 2.587a2 2 0 0 0 3.414 1.414l6.586 -6.586a2 2 0 0 0 0 -2.828l-6.586 -6.586a2 2 0 0 0 -2.18 -.434l-.145 .068z" stroke-width="0" fill="currentColor" />
            </svg>
        </button>
    </div>





</div>





<link rel="stylesheet" href="css/mult.css">


<script src="js/prevNex.js"></script>
<script src="{{ asset('js/api.js') }}"></script>






@endSection


@section('css')
<link rel="stylesheet" href="{{ asset('css/styleTables.css') }}">
@endSection