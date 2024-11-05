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



<div class="container" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);padding:20px;margin-bottom:20px">

    <div class="card-header">
        <div class="row">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-text" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                <path d="M9 12h6" />
                <path d="M9 16h6" />
            </svg>
            <h4>Registro de Guía de Remisión</h4>


        </div>


    </div>
    <div class="row">



        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">RUC Registrados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table>
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Razón Social</th>
                                        <th>RUC Agricultor</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($agricultores->reverse() as $agricultor) <!-- Invertir el orden -->
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $agricultor->razon_social }}</td>
                                        <td class="ruc">{{ $agricultor->ruc }}</td>
                                        <td>
                                            <button class="btn btn-info boton-copiar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                    <path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                                </svg>
                                            </button>
                                            <a href="/agricultores" class="btn btn-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-arrow-up-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M17 3.34a10 10 0 1 1 -14.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 14.995 -8.336zm-4.98 3.66l-.163 .01l-.086 .016l-.142 .045l-.113 .054l-.07 .043l-.095 .071l-.058 .054l-4 4l-.083 .094a1 1 0 0 0 1.497 1.32l2.293 -2.293v5.586l.007 .117a1 1 0 0 0 1.993 -.117v-5.585l2.293 2.292l.094 .083a1 1 0 0 0 1.32 -1.497l-4 -4l-.082 -.073l-.089 -.064l-.113 -.062l-.081 -.034l-.113 -.034l-.112 -.02l-.098 -.006z" stroke-width="0" fill="currentColor" />
                                                </svg>
                                            </a>
                                            <button class="btn btn-info" onclick="consultarRUCDesdeTD()">
                                                Seleccionar
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            <div id="copiadoMensaje">¡RUC copiado!</div>

                        </div>

                        <script src="js/copy.js"></script>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModalTransportista" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">RUC Registrados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">

                            <table>
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Razón Social</th>
                                        <th>RUC Transportistas</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transportistas->reverse() as $transportista) <!-- Invertir el orden -->
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td >{{ $transportista->razon_social }}</td>
                                        <td class="ruc2">{{ $transportista->RUC }}</td>
                                        <td>
                                            <button class="btn btn-info boton-copiar2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                    <path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                                </svg>
                                            </button>
                                            <a href="/transportistas" class="btn btn-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-arrow-up-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M17 3.34a10 10 0 1 1 -14.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 14.995 -8.336zm-4.98 3.66l-.163 .01l-.086 .016l-.142 .045l-.113 .054l-.07 .043l-.095 .071l-.058 .054l-4 4l-.083 .094a1 1 0 0 0 1.497 1.32l2.293 -2.293v5.586l.007 .117a1 1 0 0 0 1.993 -.117v-5.585l2.293 2.292l.094 .083a1 1 0 0 0 1.32 -1.497l-4 -4l-.082 -.073l-.089 -.064l-.113 -.062l-.081 -.034l-.113 -.034l-.112 -.02l-.098 -.006z" stroke-width="0" fill="currentColor" />
                                                </svg>
                                            </a>
                                            <button class="btn btn-info" onclick="consultarRUCTransportistaDesdeTD()">
                                                Seleccionar
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <div id="copiadoMensaje2">¡RUC copiado!</div>

                        </div>

                        <script src="js/copy.js"></script>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cerrarModalTransportista" data-dismiss="modal">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="mb-3"></div>

    <form action="{{ route('guia_remision.store') }}" method="POST" id="guia">
        @csrf

        <div class="container">
            <!-- Información del Remitente (Agricultor) -->


            <div class="card mb-4">
                <div class="card-header" style="display: flex;">
                    <h5><i class="fas fa-user"></i> Información del Remitente (Agricultor)</h5>
                    <button type="button" class="btn btn-primary ml-auto" data-toggle="modal" data-target="#exampleModal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-square-rounded-plus-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 2l.324 .001l.318 .004l.616 .017l.299 .013l.579 .034l.553 .046c4.785 .464 6.732 2.411 7.196 7.196l.046 .553l.034 .579c.005 .098 .01 .198 .013 .299l.017 .616l.005 .642l-.005 .642l-.017 .616l-.013 .299l-.034 .579l-.046 .553c-.464 4.785 -2.411 6.732 -7.196 7.196l-.553 .046l-.579 .034c-.098 .005 -.198 .01 -.299 .013l-.616 .017l-.642 .005l-.642 -.005l-.616 -.017l-.299 -.013l-.579 -.034l-.553 -.046c-4.785 -.464 -6.732 -2.411 -7.196 -7.196l-.046 -.553l-.034 -.579a28.058 28.058 0 0 1 -.013 -.299l-.017 -.616c-.003 -.21 -.005 -.424 -.005 -.642l.001 -.324l.004 -.318l.017 -.616l.013 -.299l.034 -.579l.046 -.553c.464 -4.785 2.411 -6.732 7.196 -7.196l.553 -.046l.579 -.034c.098 -.005 .198 -.01 .299 -.013l.616 -.017c.21 -.003 .424 -.005 .642 -.005zm0 6a1 1 0 0 0 -1 1v2h-2l-.117 .007a1 1 0 0 0 .117 1.993h2v2l.007 .117a1 1 0 0 0 1.993 -.117v-2h2l.117 -.007a1 1 0 0 0 -.117 -1.993h-2v-2l-.007 -.117a1 1 0 0 0 -.993 -.883z" fill="currentColor" stroke-width="0" />
                        </svg>
                    </button>
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
                            <input type="text" class="form-control pr-2" id="rucInput" name="ruc_agricultor" placeholder="RUC" maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            <div class="input-group-append">
                                <button type="button" id="consultarBtn" onclick="consultarRUC()" style="background-color:#001F4B; color:white; border: solid 2px  #001F4B;border-radius:0 6px 6px 0 "><i class="fas fa-search"></i> Consultar</button>
                            </div>
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





            <div class="card mb-4">
                <div class="card-header" style="display: flex;">
                    <h5><i class="fas fa-truck"></i> Información del Transportista</h5>
                    <button type="button" class="btn btn-primary ml-auto" data-toggle="modal" data-target="#exampleModalTransportista">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-square-rounded-plus-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 2l.324 .001l.318 .004l.616 .017l.299 .013l.579 .034l.553 .046c4.785 .464 6.732 2.411 7.196 7.196l.046 .553l.034 .579c.005 .098 .01 .198 .013 .299l.017 .616l.005 .642l-.005 .642l-.017 .616l-.013 .299l-.034 .579l-.046 .553c-.464 4.785 -2.411 6.732 -7.196 7.196l-.553 .046l-.579 .034c-.098 .005 -.198 .01 -.299 .013l-.616 .017l-.642 .005l-.642 -.005l-.616 -.017l-.299 -.013l-.579 -.034l-.553 -.046c-4.785 -.464 -6.732 -2.411 -7.196 -7.196l-.046 -.553l-.034 -.579a28.058 28.058 0 0 1 -.013 -.299l-.017 -.616c-.003 -.21 -.005 -.424 -.005 -.642l.001 -.324l.004 -.318l.017 -.616l.013 -.299l.034 -.579l.046 -.553c.464 -4.785 2.411 -6.732 7.196 -7.196l.553 -.046l.579 -.034c.098 -.005 .198 -.01 .299 -.013l.616 -.017c.21 -.003 .424 -.005 .642 -.005zm0 6a1 1 0 0 0 -1 1v2h-2l-.117 .007a1 1 0 0 0 .117 1.993h2v2l.007 .117a1 1 0 0 0 1.993 -.117v-2h2l.117 -.007a1 1 0 0 0 -.117 -1.993h-2v-2l-.007 -.117a1 1 0 0 0 -.993 -.883z" fill="currentColor" stroke-width="0" />
                        </svg>
                    </button>
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
                                    <input type="text" class="form-control pr-2" id="rucInputTransportista" name="ruc_transportista" placeholder="RUC del Transportista" maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    <div class="input-group-append">
                                        <button type="button" id="consultarBtn" onclick="consultarRUCTransportista()" style="background-color:#001F4B; color:white; border: solid 2px  #001F4B;border-radius:0 6px 6px 0 "><i class="fas fa-search"></i> Consultar</button>
                                    </div>

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
                                    <input type="text" class="form-control" id="razonSocialInputTransportista" name="razon_social_transportista" placeholder="Razón Social del Transportista">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="zonaInputTransportista" name="zona_transportista" placeholder="zona del Transportista">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Información del Transportista -->




            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-clipboard-list"></i> Información de la Guía de Remisión</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-list-ol"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="nro_guia" name="nro_guia" placeholder="Número de Guía" required minlength="8" maxlength="8">
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
            <div class="d-flex justify-content-center mb-0">
                <button type="submit" class="btn btn-primary mr-2" style="width: auto; position: relative;"> GUARDAR <i class="fas fa-save"></i></button>
                <button type="reset" class="btn btn-secondary" style="width: auto; position: relative;" id="limpiar-btn">
                    <i class="fas fa-broom"></i> Limpiar
                </button>
            </div>



            <!-- Información de la Guía de Remisión -->




        </div>



    </form>


</div>





<div class="container" style="padding: 20px">
    <div class="formulario-container active" id="formularios1">
        <!--- subsecciones de campo-->
        <div class="d-flex">

            <div class="col-md-6">
                <div class="card card-info flex-fill" style="box-shadow: 1px 3px 20px 0px rgb(9, 3, 44)">
                    <div class="card-header text-uppercase rounded-bottom border-info" style="background-color:#0003A3;color:white; display: flex; align-items: center;">
                        <h3 class="card-title" data-toggle="collapse" data-target="#transportista-form">
                            <i class="fas fa-lg fa-building"></i> Transportista
                        </h3>
                        <div style="margin-left: auto;">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body collapse" id="conductor-form">

                        <form action="/transportista" method="POST">
                            @csrf <!-- Agrega el token CSRF -->

                            <div class="form-group row">
                                <div class="col">
                                    <input type="number" class="form-control mt-2" id="rucDos" name="RUC" placeholder=" " required>



                                    <label for="rucDos" class="form-control-label">RUC:</label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control mt-2" id="razonSocialDos" name="razon_social" placeholder=" " required>
                                    <label for="razonSocial" class="form-control-label">Razon Social:</label>
                                </div>


                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <input type="text" class="form-control mt-2" id="campo" name="campo" placeholder=" " maxlength="30" required>
                                    <label for="campo" class="form-control-label">Campo:</label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control mt-2" id="codigo" name="codigo" placeholder=" " maxlength="30" required>
                                    <label for="codigo" class="form-control-label">Codigo:</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <input type="text" class="form-control mt-2" id="zona" name="zona" placeholder=" " maxlength="50" required>
                                    <label for="zona" class="form-control-label">Zona:</label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control mt-2" id="unidadTecnica" name="unidad_tecnica" placeholder=" " maxlength="20" required>
                                    <label for="unidadTecnica" class="form-control-label">Unidad Tecnica:</label>
                                </div>

                            </div>

                            <input type="hidden" name="agricultor_id" value="{{ $agricultorId }}">
                            <input type="hidden" name="transportista_id" value="{{ $transportistaId }}">


                            <div class="form-group row">
                                <div class="col-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary mt-2  mr-3">
                                        <i class="fas fa-save"></i> Guardar
                                    </button>
                                    <button type="reset" class="btn btn-secondary mt-2" id="limpiar-btn">
                                        <i class="fas fa-broom"></i> Limpiar
                                    </button>

                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div style="border-left: 2px solid rgb(21, 18, 197); height: 45px;"></div>


            <div class="col-md-6">
                <div class="card card-info flex-fill" style="box-shadow: 1px 3px 20px 0px rgb(9, 3, 44)">
                    <div class="card-header text-uppercase rounded-bottom border-info" style="background-color:#0003A3;color:white; display: flex; align-items: center;">
                        <h3 class="card-title" data-toggle="collapse" data-target="#transportista-form">
                            <i class="fas fa-lg fa-car"></i> Vehiculo
                        </h3>
                        <div style="margin-left: auto;">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body collapse" id="conductor-form">
                        <form action="{{ route('vehiculo.store') }}" method="POST">
                            @csrf <!-- Agrega el token CSRF -->

                            <div class="form-group row">
                                <div class="col">
                                    <input type="text" name="placa" class="form-control mt-2" id="placa" placeholder=" " required maxlength="7" minlength="7">
                                    <label for="placa" class="form-control-label">Placa Principal:</label>
                                </div>
                                <div class="col">
                                    <input type="text" name="placa1" class="form-control mt-2" id="placa1" placeholder=" " maxlength="7" minlength="7">
                                    <label for="placa1" class="form-control-label">Placa Carreta:</label>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <input type="text" name="codigo" class="form-control mt-2" id="codigo" placeholder=" " required>
                                    <label for="codigo" class="form-control-label">Código:</label>
                                </div>
                                <div class="col">
                                    <input type="number" name="num_ejes" class="form-control mt-2" id="num_ejes" placeholder=" " required>
                                    <label for="num_ejes" class="form-control-label">Número de Ejes:</label>
                                </div>

                            </div>


                            <div class="form-group row">
                                <div class="col">
                                    <label for="id_transportista">Transportista:</label>
                                    <select name="id_transportista" id="id_transportista" class="form-control mt-2" required style="font-size:14px; overflow:auto">
                                        <option value="">Selecionar ID</option>
                                        @foreach($transportistas->reverse() as $transportista)

                                        <option value="{{ $transportista->id }}">{{ $transportista->id }}-{{ $transportista->razon_social }}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col">
                                    <input type="text" name="dueño" class="form-control mt-2" id="dueño" placeholder=" " required>
                                    <label for="dueño" class="form-control-label">Dueño:</label>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary mt-3">
                                        <i class="fas fa-save"></i> Guardar
                                    </button>
                                    <button type="reset" class="btn btn-secondary mt-3" id="limpiar-btn">
                                        <i class="fas fa-broom"></i> Limpiar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <div class="formulario-container" id="formularios2">
        <div class="d-flex">
            <div class="col-md-6">
                <div class="card  flex-fill" style="box-shadow: 1px 3px 20px 0px rgb(9, 3, 44)">
                    <div class="card-header text-uppercase rounded-bottom border-info" style="background-color:#0003A3;color:white; display: flex; align-items: center;">
                        <h3 class="card-title" data-toggle="collapse" data-target="#conductor-form">
                            <i class="fas fa-lg fa-id-card"></i> Conductor
                        </h3>
                        <div style="margin-left: auto;">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body collapse conductor-form" id="conductor-form">
                        <form action="{{ route('conductor.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control mt-2" id="brevete" name="brevete" placeholder=" " minlength="8" maxlength="8" required>
                                <label for="brevete" class="form-control-label">Brevete:</label>
                            </div>

                            <div class="form-group">
                                <input type="number" class="form-control mt-2" id="dni" name="dni" placeholder=" " required>
                                <label for="dni" class="form-control-label">DNI:</label>
                            </div>


                            <div class="form-group">
                                <input type="text" class="form-control mt-2" id="nombre_apellidos" name="nombre_apellidos" placeholder=" " maxlength="60" required>
                                <label for="nombre_apellidos" class="form-control-label">Nombre y Apellidos:</label>
                            </div>

                            <div class="form-group">
                                <input type="number" class="form-control mt-2" id="telefono" name="telefono" placeholder=" " required>
                                <label for="telefono" class="form-control-label">Teléfono:</label>
                            </div>



                            <div class="form-group row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary mt-3">
                                        <i class="fas fa-save"></i> Guardar
                                    </button>
                                    <button type="reset" class="btn btn-secondary mt-3" id="limpiar-btn">
                                        <i class="fas fa-broom"></i> Limpiar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div style="border-left: 2px solid rgb(21, 18, 197); height: 45px;"></div>

            <div class="col-md-6">
                <div class="card card-info flex-fill" style="box-shadow: 1px 3px 20px 0px rgb(9, 3, 44)">
                    <div class="card-header text-uppercase rounded-bottom border-info" style="background-color:#0003A3;color:white; display: flex; align-items: center;">
                        <h3 class="card-title" data-toggle="collapse" data-target="#carga-form">
                            <i class="fas fa-lg fa-truck"></i> Carga
                        </h3>
                        <div style="margin-left: auto;">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body collapse" id="carga-form">
                        <form action="{{ route('carga.store') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col">
                                    <select class="form-control mt-2" id="chofer_id" name="chofer_id" required>
                                        <option value="" selected disabled hidden>ID Conductor</option>
                                        <!-- Aquí se cargarán las opciones de los conductores -->
                                        @foreach($conductores->reverse() as $conductor)
                                        <option value="{{ $conductor->id }}">{{ $conductor->id }} - {{ $conductor->nombre_apellidos }}</option>
                                        @endforeach

                                    </select>
                                    <label for="chofer_id" class="form-control-label">ID Conductor:</label>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control mt-2" id="total_carga_bruta" name="total_carga_bruta" placeholder=" " required>
                                    <label for="total_carga_bruta" class="form-control-label">Carga Bruta:</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <input type="number" class="form-control mt-2" id="total_carga_neta" name="total_carga_neta" placeholder=" " required>
                                    <label for="total_carga_neta" class="form-control-label">Carga Neta:</label>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control mt-2" id="total_material_extrano" name="total_material_extrano" placeholder=" " required>
                                    <label for="total_material_extrano" class="form-control-label">Material Extraño:</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <input type="number" class="form-control mt-2" id="tara" name="tara" placeholder=" " required>
                                    <label for="tara" class="form-control-label">Tara:</label>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control mt-2" id="nro_ticket" name="nro_ticket" placeholder=" " required>
                                    <label for="nro_ticket" class="form-control-label">Nro_ticket:</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <input type="number" class="form-control mt-2" id="km_origen" name="km_origen" placeholder=" " required>
                                    <label for="km_origen" class="form-control-label">Km Origen:</label>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control mt-2" id="km_de_destino" name="km_de_destino" placeholder=" " required>
                                    <label for="km_de_destino" class="form-control-label">Km de Destino:</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <label for="fecha_carga" class="col col-form-label" style="color:blue">Fecha Carga:</label>
                                    <input type="date" class="form-control mt-2" id="fecha_carga" name="fecha_carga" required>
                                </div>
                                <div class="col">
                                    <label for="fecha_de_descarga" class="col col-form-label" style="color:blue">Fecha de Descarga:</label>
                                    <input type="date" class="form-control mt-2" id="fecha_de_descarga" name="fecha_de_descarga" required>
                                </div>
                            </div>

                            <div class="text-center mb-3">
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fas fa-save"></i> Guardar
                                </button>
                                <button type="reset" class="btn btn-secondary mt-3" id="limpiar-btn">
                                    <i class="fas fa-broom"></i> Limpiar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="formulario-container" id="formularios3">
        <div class="d-flex">
            <div class="col-md-6">
                <div class="card card-info flex-fill" style="box-shadow: 1px 3px 20px 0px rgb(9, 3, 44)">
                    <div class="card-header text-uppercase rounded-bottom border-info" style="background-color:#0003A3;color:white; display: flex; align-items: center;">
                        <h3 class="card-title" data-toggle="collapse" data-target="#agricultor-form">
                            <i class="fas fa-lg fa-tractor"></i> Agricultor
                        </h3>
                        <div style="margin-left: auto;">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body collapse" id="agricultor-form">
                        <form action="{{ route('agricultor.store') }}" method="POST" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control mt-2" id="ruc" name="ruc" placeholder=" " required onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="11" maxlength="11">
                                <label for="ruc" class="form-control-label">RUC:</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control mt-2" id="razon_social" name="razon_social" placeholder=" " maxlength="255" required>
                                <label for="razon_social" class="form-control-label">Razón Social:</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control mt-2" id="direccion" name="direccion" placeholder=" " maxlength="255" required>
                                <label for="direccion" class="form-control-label">Dirección:</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control mt-2" id="apellidos" name="apellidos" placeholder=" " maxlength="50" required>
                                <label for="apellidos" class="form-control-label">Apellidos:</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control mt-2" id="nombres" name="nombres" placeholder=" " maxlength="50" required>
                                <label for="nombres" class="form-control-label">Nombres:</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control mt-2" id="dni" name="dni" placeholder=" " minlength="8" maxlength="8" required onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                <label for="dni" class="form-control-label">DNI:</label>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary mt-3 mr-3">
                                        <i class="fas fa-save"></i> Guardar
                                    </button>
                                    <button type="reset" class="btn btn-secondary mt-3" id="limpiar-btn">
                                        <i class="fas fa-broom"></i> Limpiar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <div style="border-left: 2px solid rgb(21, 18, 197); height: 45px;"></div>

            <div class="col-md-6">
                <div class="card card-info flex-fill" style="box-shadow: 1px 3px 20px 0px rgb(9, 3, 44)">
                    <div class="card-header text-uppercase rounded-bottom border-info" style="background-color:#0003A3;color:white; display: flex; align-items: center;">
                        <h3 class="card-title" data-toggle="collapse" data-target="#campo-form">
                            <i class="fas fa-lg fa-leaf"></i> Campo
                        </h3>
                        <div style="margin-left: auto;">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body collapse" id="campo-form">
                        <form action="{{ route('campo.store') }}" method="POST" class="form-horizontal">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control mt-2" id="acopiadora" name="acopiadora" placeholder=" " maxlength="35" required>
                                    <label for="acopiadora" class="form-control-label">Acopiadora</label>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control mt-2" id="ubigeo" name="ubigeo" placeholder=" " maxlength="35" required>
                                    <label for="ubigeo" class="form-control-label">Ubigeo:</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control mt-2" id="zona" name="zona" placeholder=" " maxlength="30" required>
                                    <label for="zona" class="form-control-label">Zona:</label>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control mt-2" id="ingenio" name="ingenio" placeholder=" " maxlength="30" required>
                                    <label for="ingenio" class="form-control-label">Ingenio:</label>
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-md-6 mb-3">
                                    <input list="campos" class="form-control mt-2" id="campo" name="carga_id" placeholder=" " required>
                                    <label for="campo" class="form-control-label">Carga ID</label>
                                    <datalist id="campos">
                                        <!-- Aquí puedes iterar sobre los campos disponibles y generar las opciones -->
                                        @foreach($cargas->reverse() as $carga)
                                        <option value="{{ $carga->id }}">{{ $carga->id }}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input list="agricultores" class="form-control mt-2" id="agricultor" name="agricultor_id" placeholder=" " required>
                                    <label for="agricultor" class="form-control-label">Agricultor: </label>
                                    <datalist id="agricultores">
                                        <!-- Aquí puedes iterar sobre los agricultores disponibles y generar las opciones -->
                                        @foreach($agricultores->reverse() as $agricultor)
                                        <option value="{{ $agricultor->id }}">{{ $agricultor->nombres }}</option>
                                        @endforeach
                                    </datalist>
                                </div>

                            </div>



                            <div class="form-group row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary mt-3">
                                        <i class="fas fa-save"></i> Guardar
                                    </button>
                                    <button type="reset" class="btn btn-secondary mt-3" id="limpiar-btn">
                                        <i class="fas fa-broom"></i> Limpiar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="formulario-container" id="formularios4">

        <div class="col">
            <div class="card card-info flex-fill" style="box-shadow: 1px 3px 20px 0px rgb(9, 3, 44)">
                <div class="card-header text-uppercase rounded-bottom border-info" style="background-color:#0003A3;color:white; display: flex; align-items: center;">
                    <h3 class="card-title" data-toggle="collapse" data-target="#pagos-form">
                        <i class="fas fa-lg fa-coins"></i> Pagos
                    </h3>
                    <div style="margin-left: auto;">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body collapse" id="agricultor-form">
                    <form action="{{ route('pagos.store') }}" method="POST" class="form-horizontal">
                        @csrf

                        <div class="form-group row">
                            <div class="col">
                                <input type="number" name="adelanto" class="form-control mt-2 @error('adelanto') is-invalid @enderror" id="adelanto" placeholder=" ">
                                <label for="adelanto" class="form-control-label">Adelanto:</label>
                                @error('adelanto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col">
                                <input type="number" class="form-control mt-2 @error('precio_unitario') is-invalid @enderror" id="precio_unitario" name="precio_unitario" placeholder=" ">
                                <label for="precio_unitario" class="form-control-label">Precio Unitario:</label>
                                @error('precio_unitario')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <select name="agricultor_id" class="form-control mt-2 @error('agricultor_id') is-invalid @enderror" id="agricultor_id">
                                    <option value="">Seleccionar Agricultor</option>
                                    @foreach ($agricultores as $agricultor)
                                    <option value="{{ $agricultor->id }}">{{ $agricultor->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="agricultor_id" class="form-control-label">Agricultor:</label>
                                @error('agricultor_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                            <div class="col">
                                <select name="tipo_pago" class="form-control mt-2 @error('tipo_pago') is-invalid @enderror" id="tipo_pago">
                                    <option value="">Seleccionar Tipo de Pago</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Tarjeta de Débito">Tarjeta de Débito</option>
                                    <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                                </select>
                                <label for="tipo_pago" class="form-control-label">Tipo de Pago:</label>
                                @error('tipo_pago')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col">
                                <input type="num_pago" class="form-control mt-2 @error('num_pago') is-invalid @enderror" id="num_pago" name="num_pago" placeholder=" ">
                                <label for="num_pago" class="form-control-label">Numero de Pago:</label>
                                @error('num_pago')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                        </div>

                        <!-- Agrega los campos adicionales según tu esquema de base de datos -->

                        <div class="form-group row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fas fa-save"></i> Guardar
                                </button>
                                <button type="reset" class="btn btn-secondary mt-3" id="limpiar-btn">
                                    <i class="fas fa-broom"></i> Limpiar
                                </button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>

    </div>

</div>


<div id="chatbot-container">
    <div id="chatbot-icon" class="rounded-circle bg-light shadow">
        <img src="images/chatbot.png" alt="Bot" class="img-fluid">
    </div>
    <div id="chatbot-message" class="bg-white rounded p-3 mt-2 shadow">
        <p id="chatbot-text" class="m-0">{{ $message }}</p>
    </div>
</div>




@endsection

@section('css')
<link rel="stylesheet" href="css/form.css">
<link rel="stylesheet" href="css/botStyle.css">
<link rel="stylesheet" href="css/tableModal.css">

<style>

</style>


@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/alert.js')}}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var chatbotContainer = document.getElementById('chatbot-container');
        var chatbotMessage = document.getElementById('chatbot-message');


        var userName = "{{ Auth::user()->name }}";
        var message = '👋 ¡Hola, ' + userName + '!';
        const mensaje = '¡Recuerda!\n 📌Debes registrar los datos en la sección 🌾 Campo y 💰 Pago por si no los has registrado antes de emitir una guía de remisión 📝📦';
        chatbotMessage.textContent = message;


        setTimeout(function() {
            chatbotMessage.textContent = mensaje;
        }, 5000);

        chatbotContainer.addEventListener('click', function(event) {
            if (event.button !== 2) {
                chatbotMessage.style.display = chatbotMessage.style.display === 'none' ? 'block' : 'none';
            }
        });

        chatbotContainer.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });


        var chatbotWidth = chatbotContainer.offsetWidth;
        var chatbotHeight = chatbotContainer.offsetHeight;


        function keepMessageInScreen() {
            var windowWidth = window.innerWidth;
            var windowHeight = window.innerHeight;


            var chatbotPosX = parseInt(chatbotContainer.style.left, 10) || 0;
            var chatbotPosY = parseInt(chatbotContainer.style.top, 10) || 0;


            if (chatbotPosX < 0) {
                chatbotContainer.style.left = '0px';
            } else if (chatbotPosX + chatbotWidth > windowWidth) {
                chatbotContainer.style.left = (windowWidth - chatbotWidth) + 'px';
            }

            if (chatbotPosY < 0) {
                chatbotContainer.style.top = '0px';
            } else if (chatbotPosY + chatbotHeight > windowHeight) {
                chatbotContainer.style.top = (windowHeight - chatbotHeight) + 'px';
            }
        }


        window.addEventListener('resize', keepMessageInScreen);
        window.addEventListener('load', keepMessageInScreen);
        window.addEventListener('scroll', keepMessageInScreen);
    });




    document.addEventListener('DOMContentLoaded', function() {
        // Recuperar el RUC de localStorage y establecerlo como el valor del campo si existe
        const ruc = localStorage.getItem('rucAgricultor');
        if (ruc) {
            document.getElementById('rucInput').value = ruc;
            // Solo iniciar el temporizador si hay un valor en el campo
            if (ruc.trim() !== '') {
                setTimeout(function() {
                    localStorage.removeItem('rucAgricultor');
                }, 15000); // 15000 milisegundos = 15 segundos
            }
        }

        // Guardar el RUC en localStorage cuando el usuario cambie el valor
        document.getElementById('rucInput').addEventListener('input', function() {
            const inputValue = this.value;
            localStorage.setItem('rucAgricultor', inputValue);
            // Reiniciar el temporizador cada vez que el usuario cambie el valor
            // Primero, limpiar cualquier temporizador existente
            clearTimeout(window.rucTimeout);
            // Solo establecer un nuevo temporizador si hay un valor en el campo
            if (inputValue.trim() !== '') {
                window.rucTimeout = setTimeout(function() {
                    localStorage.removeItem('rucAgricultor');
                }, 15000);
            }
        });
    });


    document.addEventListener("DOMContentLoaded", function() {
        const slides = document.querySelectorAll(".slide");
        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove("active"));
            slides[index].classList.add("active");
        }

        document.querySelector(".prev").addEventListener("click", function() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        });

        document.querySelector(".next").addEventListener("click", function() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        });





    });

    function limitInputLength(id, maxLength) {
        const element = document.getElementById(id);
        element.addEventListener('input', function(event) {
            if (this.value.length > maxLength) {
                this.value = this.value.slice(0, maxLength);
            }
        });
    }

    limitInputLength('rucDos', 11);
    limitInputLength('ruc', 11);
    limitInputLength('dni', 8);
    limitInputLength('telefono', 9);


    function consultarRUC() {
        var ruc = document.getElementById('rucInput').value;

        $.ajax({
            url: "{{ route('ruc.agricultor') }}",
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'ruc_agricultor': ruc
            },
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    document.getElementById('razonSocialInput').value = response.razon_social;
                    document.getElementById('direccionInput').value = response.direccion;
                }
            },
            error: function(xhr) {
                alert('Error al consultar el RUC.');
            }
        });
    }

    function consultarRUCTransportista() {
        var ruc = document.getElementById('rucInputTransportista').value;

        $.ajax({
            url: "{{ route('ruc.transportista') }}",
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'ruc_transportista': ruc
            },
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    document.getElementById('razonSocialInputTransportista').value = response.razon_social;
                    document.getElementById('zonaInputTransportista').value = response.zona;
                    
                }
            },
            error: function(xhr) {
                alert('Error al consultar el RUC.');
            }
        });
    }

    function consultarRUCDesdeTD() {
    var ruc = document.querySelector('.ruc').innerText.trim();

    $.ajax({
        url: "{{ route('ruc.agricultor') }}",
        method: 'POST',
        data: {
            '_token': '{{ csrf_token() }}',
            'ruc_agricultor': ruc
        },
        success: function(response) {
            console.log(response);
            if (response.error) {
                alert(response.error);
            } else {
                document.getElementById('razonSocialInput').value = response.razon_social;
                document.getElementById('direccionInput').value = response.direccion;
                document.getElementById('rucInput').value = response.ruc;
                document.querySelector('[data-dismiss="modal"]').click();
            }
        },
        error: function(xhr) {
            alert('Error al consultar el RUC.');
        }
    });
}

function consultarRUCTransportistaDesdeTD() {
    var ruc = document.querySelector('.ruc2').innerText.trim();

    $.ajax({
        url: "{{ route('ruc.transportista') }}",
        method: 'POST',
        data: {
            '_token': '{{ csrf_token() }}',
            'ruc_transportista': ruc
        },
        success: function(response) {
            console.log(response);
            if (response.error) {
                alert(response.error);
            } else {
                document.getElementById('razonSocialInputTransportista').value = response.razon_social;
                document.getElementById('zonaInputTransportista').value = response.zona;
                document.getElementById('rucInputTransportista').value = response.RUC;
                document.getElementById('cerrarModalTransportista').click();
            }
        },
        error: function(xhr) {
            alert('Error al consultar el RUC.');
        }
    });
}

    //numero de guia
    document.getElementById('guia').onsubmit = function(e) {
        var nroGuia = document.getElementById('nro_guia').value;
        if (!nroGuia.startsWith('00')) {
            alert('El número de guía debe comenzar con "00".');
            e.preventDefault(); // Evita que el formulario se envíe
        }
    };
</script>





@stop