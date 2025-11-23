@extends('layouts.main')

@section('title', 'MOVIMIENTOS DE PERSONAL - DESCRIPCIÓN')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false, 
                'titulo' => 'Procesos',
                'ruta' => Route('procesos')
            ],
            2 => [
                'activo' => true, 
                'titulo' => 'Movimientos de personal - Descripción'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "procesos",
        ]
    ])
@endsection

@section('contenido')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Movimientos de personal</h3>
            </div>
        </div>
        <div class="card-body">
            <p class="text-justify">
                De conformidad con el articulo 101-B; fracciones XI y XIV del Reglamento Interior de la Administración
                Pública de la Ciudad de México; numeral 1 "Administración de Personal" de la circular 1 del 2007 
                "Normatividad en Materia de Administración de Recursos"; Coniciones Generales de Trabajo del Gobierno
                de la Ciudad de México y la Guía para la Operación Desconcentrada de Movimientos de PErsonal, Incidencias,
                Ajustes y Validación de Prenómina, se expiden los siguientes lineamientos para el procedimiento de 
                Movimientos de Personal.
            </p>
            <p class="text-justify">
                El objetivo de este procedimiento es administrar, operar y asegurar el adecuado registro y control
                de los movimientos de personal establecidos en la Secretaría de Finanzas, de acuerdo con la normatividad
                vigente, así como las que para tal efecto emita la Dirección General de Administración.
            </p>
            <p class="text-justify">
                Esta herramienta esta diseñada para llevar solamente el seguimiento de los siguientes tipos de 
                movimientos de personal:
            </p>

            <h5> Altas </h5>
            <ul class="list-style-none">
                <li>101 - Alta de nuevo ingreso</li>
                <li>102 - Alta por reingreso</li>
                <li>113 - Incorporación con licencia</li>
                <li>114 - Recontratación Interinato</li>
                <li>601 - Promoción ascendente</li>
                <li>602 - Promoción descendente</li>
                <li>603 - Movimiento horizontal</li>
                <li>604 - Cambio ascendente contrato interino</li>
                <li>605 - Cambio descendente contrato interino</li>
                <li>606 - Cambio horizontal contrato interino</li>
            </ul>
            <h5> Bajas </h5>
            <ul class="list-style-none">
                <li>201 - Baja por renuncia</li>
                <li>202 - Baja por defunción</li>
                <li>203 - Baja jubilación</li>
                <li>204 - Baja por abandono de empleo</li>
                <li>205 - Baja resolución admin. O laudo sin inhab</li>
                <li>206 - Baja incompatibilidad de empleos</li>
                <li>207 - Baja termino de nombramiento provisional</li>
                <li>208 - Baja termino de interinato o beca</li>
                <li>209 - Baja termino de contrato de honorarios</li>
                <li>210 - Baja rescisión de contrato de honorarios</li>
                <li>211 - Cancelación altas insubsist nombramiento</li>
                <li>212 - Baja incapacidad fisica y/o mental permanente</li>
                <li>213 - Baja acumulación de faltas o notas malas</li>
                <li>214 - Baja convenir al buen servicio</li>
                <li>215 - Baja sentencia JUD o Admin con inhabilitación</li>
                <li>216 - Baja sentencia JUD o Admin sin inhabilitación</li>
                <li>217 - Baja supresión de puesto de confianza</li>
                <li>218 - Baja termino anticipado de beca</li>
                <li>219 - Baja por retiro voluntario</li>
                <li>220 - Baja determinación de consejo</li>
                <li>221 - Baja por suspensión</li>
                <li>222 - Baja resolución admin o laudo c/ inhabilitación</li>
                <li>301 - Licencia con sueldo prejubilatoria</li>
                <li>303 - Licencia sin sueldo limitada</li>
                <li>305 - Licencia sin sueldo ilimitada</li>
                <li>313 - Prorroga de licencia sin sueldo limitada</li>
                <li>801 - Suspensión de pago por baja preventiva</li>
                <li>804 - Suspensión de pago por enfermedad contagiosa</li>
                <li>821 - Suspensión de pago por sanción administrativa</li>
                <li>831 - Suspensión de pago por proceso judicial</li>
            </ul>
            <h5> Reanudaciones </h5>
            <ul class="list-style-none">
                <li>402 - Reanudación labores termino licencia medio sueldo</li>
                <li>403 - Reanudación labores termino licencia sin sueldo</li>
                <li>404 - Reanudación termino anticipado licencia y suspensión</li>
                <li>411 - Reanudación pago insubsis de baja preven</li>
                <li>421 - Reanudación pago termino de suspención</li>
                <li>422 - Reanudación pago insubsistencia de suspención</li>
                <li>431 - Reanudación pago resolución judicial</li>
                <li>433 - Reubicación individual</li>
                <li>502 - Reinstalación por laudo o sentencia judicial</li>
            </ul>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <form id="id_form_iniciar_proceso" action="{{ route('movimiento.personal.inicializar.proceso') }}" method="POST">
                    @csrf
                    <button id="id_btn_iniciar_proceso" type="button" class="btn btn-success"> <i class="fas fa-arrow-alt-circle-right"></i> Iniciar proceso</button>
                </form>
            </div>
        </div>
    </div> 
@endsection

@push('scripts')
    <script src="{{ asset('js/p01_movimientos_personal/tareas/descripcion.js') }}"></script>
@endpush