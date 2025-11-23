@extends('layouts.pdf')

@section('contenido')
    <p class="text-right font-size-12 m-0"><b>{{ $movimientoPersonal->folio }}</b></p>
    <p class="text-center font-size-16 m-0 mt-4"><b>LISTA DE CHEQUEO DE DOCUMENTOS</b></p>
    <div>
        <p class="font-size-14 m-0 mt-4"> Documentación que debe contener el expediente activo del proceso de contratación de personal Técnico Operativo y de Estructura</p>
        <table class="table table-sm table-striped font-size-14 mt-4">
            <tbody>
                <tr><td> <b> Datos Generales </b> </td></tr>
                <tr><td> <b> FOLIO: </b> {{ $movimientoPersonal->folio }} <b> Tipo de movimiento: </b> {{ $movimientoPersonal->tipoMovimiento->codigo }} - {{ $movimientoPersonal->tipoMovimiento->descripcion }} </td></tr>
                <tr><td> <b> Datos del candidato </b> </td></tr>
                <tr><td> <b> Nombre (*): </b> {{ $movimientoPersonal->nombre_empleado }} <b> Apellido paterno (*): </b> {{$movimientoPersonal->apellido_paterno}} <b> Apellido materno (*): </b> {{$movimientoPersonal->apellido_materno}} </td></tr>
                <tr><td> <b> Datos de la plaza </b> </td></tr>
                <tr><td> <b> Fecha alta: </b> {{ $movimientoPersonal->fecha_propuesta_inicio }} <b> Num. de plaza: </b> {{ $movimientoPersonal->numero_plaza }} <b> Nivel: </b> {{ $movimientoPersonal->nivel_salarial }} <b> Denominación de puesto: </b> {{ $movimientoPersonal->puesto }} </td></tr>
            </tr>
            </tbody>
        </table>
        <table class="table table-sm table-bordered font-size-12 mt-4">
            <tbody>
                @foreach ($listaDocumentos as $indice => $documento)
                    <tr>
                        <td> {{ $indice + 1 }} </td>
                        <td> {{ $documento->nombre }} </td>
                        <td> {{ isset($documento->se_adjunta) && $documento->se_adjunta ? "OK" : "" }} </td>
                    </tr>                
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="page-break"></div>
    <div>
        <table class="table table-sm table-bordered font-size-14 mb-10 mt-10">
            <tbody>
                <tr> <td> LEYENDA: </td> </tr>
                <tr>
                    <td>
                        Los datos personales recabados serán protegidos, incorporados y tratados en el Sistema de Datos Personales, Sistema de Administración de Recursos Humanos en la Secretaría de
                        Administración y Finanzas, el cual tiene su fundamento en la Fracción I del Artículo 101 B del Reglamento Interior de la Administración Pública de la Ciudad de México, cuya finalidad es
                        Administrar los recursos humanos y financieros destinados a los gastos para los servicios personales, conforme a las políticas, lineamientos, criterios y normas determinadas por la
                        Oficialía Mayor y la Secretaría de Administración y Finanzas, la integración de los expedientes personales de los servidores públicos, así como la administración de la nómina, prestaciones
                        y movimientos de personal y podrán ser transmitidos a la Dirección General de Administración y Desarrollo de Personal, de la Oficialía Mayor, al Instituto de Seguridad y Servicios Sociales
                        de los Trabajadores del Estado, al Fondo de la Vivienda del Instituto de Seguridad y Servicios Sociales de los Trabajadores del Estado y a las Autoridades jurisdiccionales que en el ámbito
                        de sus atribuciones y competencias lo requieran, a fin de realizar los procesos para la emisión de la nómina de pago de los trabajadores, incluyendo sus prestaciones, descuentos e
                        impuestos con base a la información ingresada al Sistema Integral Desconcentrado de Nómina, prestación del servicio médico y de las prestaciones sociales y vivienda a las que tienen
                        derecho los trabajadores y para cumplimiento de las peticiones jurisdiccionales, además de otras transmisiones previstas en la Ley de Protección de Datos Personales para el Distrito
                        Federal.
                        Los datos marcados con un asterisco (*) son obligatorios y sin ellos no se podrá acceder o complementar el trámite de contratación. Asimismo se le informa que sus datos no podrán ser
                        difundidos sin su consentimiento expreso, salvo las excepciones previstas en la ley. 
                        El responsable del Sistema de Datos Personales es Marcos Manuel Herrería Alamina, Director General de Administración en la Secretaria de Finanzas y la dirección donde podrá ejercer los
                        derechos de acceso, rectificación, cancelación y oposición, así como la revocación del consentimiento es Plaza de la Constitución No. 1, Planta Baja, Col. Centro, Alcaldía Cuauhtémoc, C.P.
                        06068, Ciudad de México. 
                    </td>            
                </tr>
            </tbody>
        </table>
        <p class="text-center font-size-12">
            ____________________________________________ <br>
            Validado y revisado por <br>
            {{ Auth::user()->nombre }} {{ Auth::user()->apellido_paterno }} {{ Auth::user()->apellido_materno }} <br>
            {{ Auth::user()->puesto }} <br>
            {{ Auth::user()->area->unidadAdministrativa->nombre_unidad }} 
        </p>
    </div>
@endsection