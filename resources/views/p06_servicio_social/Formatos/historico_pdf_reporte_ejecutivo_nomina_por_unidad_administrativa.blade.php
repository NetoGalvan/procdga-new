@extends('layouts.pdf')

@section("titulo")
    {{-- <h4> REGISTRO DE SERVICIO SOCIAL </h4> --}}
@endsection

@section("contenido")

<div class="fuente">
    <div class="centrado">
        <h3 class="">REPORTE EJECUTIVO DE CONTRAPRESTACION DE PRESTADORES DE SERVICIO SOCIAL Y/O PRACTICAS PROFESIONALES AÑO {{ $anio }}</h3>
    </div>
    <div>
        <table class="table table-bordered table-general" style="width:100%">
            <thead>
                <tr bgcolor="#E6E6E6">
                    <th class="td">FOLIO</th>
                    <th class="td">DESCRIPCIÓN</th>
                    <th class="td centrado">FECHA DE CREACIÓN</th>
                    <th class="td centrado">FECHA DE CIERRE</th>
                    <th colspan="2" class="td centrado">PRESTADORES POR UNIDAD ADMINISTRATIVA</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nominaHistoricoData as $nom)
                    @if (isset($nom->unidades))
                        <tr>
                            <td width="15%" class="td">{{ $nom->folio }}</td>
                            <td width="20%" class="td centrado">{{ $nom->descripcion }}</td>
                            <td width="10%" class="td centrado">{{ $nom->fecha_creacion }}</td>
                            @if ( $nom->fecha_de_cierre != null )
                                <td width="10%" class="td centrado">{{ $nom->fecha_de_cierre }}</td>    
                            @else
                                <td width="10%" class="td centrado"> --- </td>
                            @endif

                            <td width="40%" class="td izquierda">
                                @if (isset($nom->unidades))
                                    
                                    @foreach ($nom->unidades as $unidad)
                                    {{ $unidad->unidad_administrativa }}  <br>
                                    @endforeach
                                @endif
                            </td>

                            <td width="5%" class="td centrado">
                                @if (isset($nom->unidades))
                                    @foreach ($nom->unidades as $unidad)

                                        @if ($unidad->count >= 1)
                                            {{ $unidad->count }} <br>
                                        @else
                                            ---
                                        @endif

                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class=" derecha">TOTAL DE PRESTADORES POR CONTRAPRESTACIÓN </td>
                            @if (count( $nom->total_prestadores ) >= 1)
                                <td width="10%" class="td centrado"> <b> {{ $nom->total_prestadores[0]->totalprestadores }} </b> </td>    
                            @else
                                <td width="10%" class="td centrado"> --- </td>
                            @endif
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

<style>
.justificado{
    text-align: justify;
}

.centrado{
    text-align: center;
}

.derecha{
    text-align: right
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
}

.letraLeyenda{
    font-size: 8;
}

.letraTabla{
    font-size: 8;
}

.saltoPagina{
    page-break-after: always;
}

header {
    position: fixed;
    left: 0px;
    top: -30px;
    right: 0px;
    height: 100px;
    text-align: center;
}

body{
    /*Alto, Derecha, Bajo, Izquierda*/
    margin: 5mm 8mm 15mm 8mm;
}

footer {
    position: fixed;
    left: 100px;
    bottom: -15px;
    right: 0px;
    height: 45px;
    text-align: center;
    /*border-bottom: 2px solid #ddd;*/
}

.imagen {
    right: 30px;
}

.tablaContenido{
    border-collapse: collapse;
}

.td {
    border: 1px solid black;
}

.colapsado {
    border-collapse: collapse;
}

.color {
    color: #C8C6C5;
}

/* body{
    Alto, Derecha, Bajo, Izquierda
    margin: 5mm 8mm 15mm 8mm;
} */

.fuente {
  font: Arial, 10;
}

table {
	border-collapse: collapse;
}

@page {
		margin-left: 0.2cm;
		margin-right: 1.5cm;
}

</style>
