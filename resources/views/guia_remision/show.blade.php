<div class="guiaremitente">
    <table>
        <tr>
            <td style="width: 70%; text-align: center;">
                <h1>NEGOCIOS CHUCLUYSUYO E.I.R.L.</h1><br>
                <p>Servicio de corte, arrume, carguío y transporte de caña de azúcar - compra y veenta de carbón transporte en general</p>
                <p style="font-size: 10px;">Mz. Z30 -LT. 18 - A.H SAGITARIO - SANTIAGO DE SURCO - LIMA - LIMA</p>
            </td>
            @foreach($guias as $guia)
            <td style="width: 30%; text-align: center; border-left: 1px solid black;">
                <h2>R.U.C N° 20604298246</h2>
                <h4 style="background-color: #899B8A;">Guia de Remision Remitente</h4>
                <p>0001 - {{$guia->nro_guia}}</p>
            </td>
            @endforeach
        </tr>
        <tr></tr>

    </table>
    <br>
    <table>
        @foreach($guias as $guia)
        <tr>
            <td colspan="2" style="width: 400px;">
                <p>Punto de Partida: {{$guia->punto_partida}}</p>
            </td>
            <td>
                <p>Fecha de Emisión: </p> 11/11/2020
            </td>
            <td>
                <p>Fecha de Inicio de Traslado </p>11/11/11
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p>Punto de Llegada {{$guia->punto_llegada}}</p>
            </td>

        </tr>
        @endforeach
    </table>
    <br>
    <table>
        @foreach($guias as $guia)
        <tr style="width: 100%;">
            <td style="width: 50%;">
                <h2 style="text-align: center;">DATOS DEL DESTINATARIO</h2>
                <p>Razón Social: {{$guia->agricultor->razon_social}}</p>
                <p>R.U.C: {{$guia->agricultor->ruc}}</p>
                <p>DNI: {{$guia->agricultor->dni}}</p>
            </td>
            <td style="width: 50%;">
                <h2 style="text-align: center;">DATOS DEL TRANSPORTISTA</h2>
                <p>Razón Social: {{$guia->transportista->razon_social}}</p>
                <p>R.U.C: {{$guia->transportista->RUC}}</p>
                <p>Unidad Tecnica: {{$guia->transportista->unidad_tecnica}}</p>
            </td>


        </tr>

        @endforeach
    </table>
    <br>
    <table>
        @foreach($guias as $guia)
        <tr style="width: 100%;">
            <td style="width: 50%;">
                <h4>DESCRIPCION</h4>
                <p>{{$guia->producto}}</p>
            </td>
            <td>
                <h4>CANTIDAD</h4>
                <p>{{ $guia->peso_bruto }}</p>
            </td>
            @foreach($pagos as $pago)
            <td>
                <h4>PRECIO U.</h4>
                <p>{{$pago->precio_unitario}}</p>
            </td>
            @endforeach
            <td>
                <h4>UN. MEDIDA</h4>
                <p>KG</p>
            </td>


        </tr>
        @endforeach
    </table>


</div>
<br><br>
<div class="guiaremitente guiaremitente_estilos">
    <table >
        <tr>
            <td style="width: 70%; text-align: center;">
                <h1>AGRO & COMERCIO EL VALLE ESCONDIDO E.I.R.L.</h1><br>
                <p>Venta y servicio de corte de caña de azucar - transporte de carga <br> por carretera - servicios agrícolas en general - Compra y venta <br> de carbón ferretería en general - compra y venta de <br> materiales de construcción</p>
                <p style="font-size: 10px;">Mz. Z30 -LT. 18 - A.H SAGITARIO - SANTIAGO DE SURCO - LIMA - LIMA</p>
            </td>
            @foreach($guias as $guia)
            <td style="width: 30%; text-align: center; border-left: 1px solid black;">
                <h2>R.U.C N° 20609069270</h2>
                <h4 style="background-color: lightblue;">Guia de Remision Transportista</h4>
                <p>0001 - {{$guia->transportista->codigo}}</p>
            </td>
            @endforeach
        </tr>
        <tr></tr>

    </table>
    <br>
    <table>
        @foreach($guias as $guia)
        <tr style="width: 100%;">
            <td style="width: 50%;">
                <h2 style="text-align: center;">REMITENTE</h2>
                <p>Razón Social: NEGOCIOS CHUCLUYSUYO E.I.R.L.</p>
                <p>R.U.C:20604298246</p>
                
            </td>
            <td style="width: 50%;">
                <h2 style="text-align: center;">DESTINATARIO</h2>
                
                <p>Razón Social: {{$guia->agricultor->razon_social}}</p>
                <p>R.U.C: {{$guia->agricultor->ruc}}</p>
                <p>DNI: {{$guia->agricultor->dni}}</p>
            </td>


        </tr>

        @endforeach
    </table>
    <br>
    <table>
        @foreach($guias as $guia)
        <tr style="width: 100%;">
            <td style="width: 50%;">
                <h4>DESCRIPCION</h4>
                <p>Un viaje de: <b> {{$guia->producto}}</b>, desde el capo de: <b>{{$guia->transportista->campo}}</b></p>
            </td>
            <td>
                <h4>CANTIDAD</h4>
                <p>{{ $guia->peso_bruto }}</p>
            </td>
            @foreach($pagos as $pago)
            <td>
                <h4>PRECIO U.</h4>
                <p>{{$pago->precio_unitario}}</p>
            </td>
            @endforeach
            <td>
                <h4>UN. MEDIDA</h4>
                <p>KG</p>
            </td>


        </tr>
        @endforeach
    </table>
    <br>
    <table>
        @foreach($guias as $guia)
        <tr>
            <td>
                <h2 style="text-align: center;">DATOS DE IDENTIFICACION DE LA UNIDAD DE TRANSPORTE Y DEL CONDUCTOR</h2>
                <p>Placa N°: {{$guia->transportista->vehiculos->first()->placa}}</p>
                <p>Codigo Vehicular: {{$guia->transportista->vehiculos->first()->codigo}}</p>
                @foreach($choferes as $chofer)
                <p>Chofer: {{$chofer->nombre_apellidos}}</p>
                <p>DNI: {{$chofer->dni}}</p>

                @endforeach
            </td>  
        </tr>
        @endforeach
    </table>

</div>

<style>
    
    .guiaremitente h1,
    .guiaremitente h2{
        font-size: 20px;
        font-weight: bold;
        margin: 0;
        /* Ajusta el margen para evitar espacios extra dentro de la celda de la tabla */
    }

    .guiaremitente p {
        font-size: 15px;
        margin: 0;
        /* Ajusta el margen para evitar espacios extra dentro de la celda de la tabla */
    }

    p {
        border-bottom: 1px solid black;
    }

    .guiaremitente td{
        background-color: #ABA98E;
    }

    .guiaremitente_estilos td{
        background-color: #6F8DA7;
    }
    table{
        width: 100%;
    }
</style>