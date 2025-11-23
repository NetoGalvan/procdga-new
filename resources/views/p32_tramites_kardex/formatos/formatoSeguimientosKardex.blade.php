@extends('p32_tramites_kardex.formatos.pdf')

@section("header")
    <p class="text-right font-size-12 mb-0"><b></b></p>
@endsection

@section("titulo")
    <h4><br> SEGUIMIENTO(S) DE TRÁMITE KARDEX</h4>
@endsection

@section("contenido")

<div style="padding:10px;width:100%;margin-top:10px;">

    <p class="centrado letraTitulo">HISTORICO DE LOS SEGUIMIENTOS DEL TRÁMITE KARDEX DE {{ mb_strtoupper($tramiteKardex->tipoTramiteKardex->nombre) }} </p>

    <div>
        <table class="letraMe " width="100%">
            <tr>
                <td bgcolor="#BDBDBD" colspan="3" class="letraTitulo centrado">DATOS GENERALES</td>
            </tr>
            <tr>
                <td width="33%"><b>NOMBRE:</b> {{ mb_strtoupper($tramiteKardex->nombre) }} {{ mb_strtoupper($tramiteKardex->apellido_paterno) }} {{ mb_strtoupper($tramiteKardex->apellido_materno) }} </td>
                <td width="33%"><b>NÚMERO DE EMPLEADO:</b> {{ $tramiteKardex->numero_empleado }}</td>
                <td width="33%"><b>RFC:</b> {{ $tramiteKardex->rfc }} </td>
            </tr>
            <tr>
                <td width="33%"><b>CURP:</b> {{ $tramiteKardex->curp }} </td>
                <td width="33%"><b>ÁREA:</b> {{ isset($tramiteKardex->unidad_administrativa_nombre) ? mb_strtoupper($tramiteKardex->unidad_administrativa_nombre) : '' }}</td>
            </tr>
        </table>

        <table width="100%"  class="letraCh tablaContenido" id="tablapdf">
            <tr class="letraTitulo centrado" bgcolor="#BDBDBD">
                <td class="td" width="15%" >TRÁMITE</td>
                <td class="td" width="15%" >FECHA ELABORACIÓN</td>
                <td class="td" width="15%" >FOLIO</td>
                <td class="td" width="15%" >FECHA SEGUIMIENTO</td>
                <td class="td" width="40%">COMENTARIO</td>
            </tr>
            @foreach ($seguimientos as $seguimiento)
            <tr>
                <td class="td centrado">{{mb_strtoupper($seguimiento->tipo_tramite)}}</td>
                <td class="td centrado">{{date('d-m-Y', strtotime($seguimiento->fecha_elaboracion_tramite))}}</td>
                <td class="td centrado">{{$seguimiento->folio}}</td>
                <td class="td centrado">{{date('d-m-Y', strtotime($seguimiento->fecha_seguimiento))}}</td>
                <td class="td">{{$seguimiento->comentario_seguimiento}}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>


<style>
.centrado{
    text-align: center;
}
.izquierda{
    text-align: left;
}
.letraCh{
    font-size: 9;
}
.letraMe{
    font-size: 10;
}
.letraSecretaria{
    font-size: 11;
}
.letraTitulo{
    font-size: 12;
    color : black;

}
.saltoPagina{
    page-break-after: always;
}

.tablaContenido{
    border-collapse: collapse;
}

.mt-Tabla{
    margin-top: 200px;
}
.mb-Tabla{
    margin-bottom: 200px;
}
.td {
    border: 1px solid black;
}

</style>

@endsection


