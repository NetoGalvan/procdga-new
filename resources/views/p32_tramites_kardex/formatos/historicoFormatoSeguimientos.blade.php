@extends('p32_tramites_kardex.formatos.pdf')

@section("header")
    <p class="text-right font-size-12 mb-0"><b></b></p>
@endsection

@section("titulo")
    <h4><br> SEGUIMIENTO(S) DE {{ mb_strtoupper($tra) }}</h4>
@endsection

@section("contenido")

<div style="padding:10px;width:100%;margin-top:10px;">

    <p class="centrado letraTitulo">HISTORICO DE LOS SEGUIMIENTOS DE {{ mb_strtoupper($tra) }} </p>

    <div>
        <table class="letraMe " width="100%">
            <tr>
                <td bgcolor="#BDBDBD" colspan="3" class="letraTitulo centrado">DATOS GENERALES</td>
            </tr>
            <tr>
                <td width="33%"><b>NOMBRE:</b> {{ mb_strtoupper($tramite->nombre) }} {{ mb_strtoupper($tramite->apellido_paterno) }} {{ mb_strtoupper($tramite->apellido_materno) }} </td>
                <td width="33%"><b>NÚMERO DE EMPLEADO:</b> {{ $tramite->numero_empleado }}</td>
                <td width="33%"><b>RFC:</b> {{ $tramite->rfc }} </td>
            </tr>
            <tr>
                <td width="33%"><b>CURP:</b> {{ $tramite->curp }} </td>
                <td width="33%"><b>ÁREA:</b> {{ isset($tramite->area->nombre) ? mb_strtoupper($tramite->area->nombre) : '' }}</td>
            </tr>
        </table>

        <table width="100%"  class="letraCh tablaContenido" id="tablapdf">
            <tr class="letraTitulo centrado" bgcolor="#BDBDBD">
                <td class="td" width="15%" >FECHA SEGUIMIENTO</td>
                <td class="td" width="40%">COMENTARIO</td>
            </tr>
            @foreach ($seguimientos as $seguimiento)
            <tr>
                <td class="td centrado">{{date('d-m-Y', strtotime($seguimiento->fecha))}}</td>
                <td class="td">{{$seguimiento->comentario}}</td>
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


