@extends('layouts.pdf')

@section("titulo")
    {{-- <h4> REGISTRO DE SERVICIO SOCIAL </h4> --}}
@endsection

@section("contenido")

    <table class="letraCh" width="100%">
        <tr>
            <td bgcolor="#E6E6E6" colspan="2" class="centrado letraMe">CEDULA DE EVALUACIÓN DEL DESEMPEÑO</td>
        </tr>
        <tr>
            <td ><b> NOMBRE </b></td>
            <td ><b> DENOMINACIÓN DEL PUESTO </b></td>
        </tr>
        <tr>
            <td>{{ $datosEmpleado->apellido_paterno }} {{ $datosEmpleado->apellido_materno }} {{ $datosEmpleado->nombre }} </td>
            <td>{{ $datosEmpleado->puesto }}</td>
        </tr>
        <tr>
            <td ><b>ÁREA DE ADSCRIPCIÓN</b></td>
            <td ><b>PUESTO REAL</b></td>
        </tr>
        <tr>
            <td>____________________________________</td>
            <td>____________________________________</td>
        </tr>
    </table>
    
    <table width="100%" class="cuerpoImagen">
        <tr>
            <td class="centrado">
                <img src="{!! public_path().'/images/logos/tabla_desempeno.PNG' !!}" height="620px" width="700px">
            </td>
        </tr>
    </table>

    <table width="100%" class="cuerpoImagen">
        <tr>
            <td class="centrado">
                <img src="{!! public_path().'/images/logos/tabla_puntualidad_asistencia_2.PNG' !!}" height="300px" width="700px">
            </td>
        </tr>
    </table>

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
        top: 0px;
        right: 0px;
        height: 100px;
        text-align: center;
    }
    
    body{
        /*Alto, Derecha, Bajo, Izquierda*/
        margin: 5mm 8mm 15mm 8mm;
    }

    .cuerpoImagen{
        /*Alto, Derecha, Bajo, Izquierda*/
        margin: 5mm 5mm 5mm -1mm;
        /* top: 50%; */
    }
    
    footer {
        position: fixed;
        left: 50px;
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
