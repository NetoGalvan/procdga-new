<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">Detalle del proceso</h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row" style="margin-top: -15px;">
            <div class="col-md-6">
                <label class="titulo-dato">Unidad administrativa</label>
                <span class="valor-dato">  {{ $servicioSocial->area->identificador }} - {{ $servicioSocial->area->nombre }} </span>
            </div>
            <div class="col-md-6">
                <label class="titulo-dato">Folio</label>
                <span class="valor-dato">  {{ $servicioSocial->instancia->folio }} </span>
            </div>
        </div>
        @if(array_key_exists("datos_candidato", $secciones))
        <hr>
        <div class="row mt-5">
            <div class="col-md-4">
                <label class="titulo-dato"> Nombre </label>
                <span class="valor-dato">  {{ $servicioSocial->prestador->primer_apellido }} {{ $servicioSocial->prestador->segundo_apellido }} {{ $servicioSocial->prestador->nombre_prestador }} </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato">Correo electrónico</label>
                <span class="valor-dato">  {{ $servicioSocial->prestador->email }} </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato">Teléfono celular</label>
                <span class="valor-dato">  {{ $servicioSocial->prestador->telefono }} </span>
            </div>
            @if(in_array("horas", $secciones['datos_candidato']))
                <div class="col-md-4">
                        <label class="titulo-dato">Total de horas</label>
                        <span class="valor-dato">  {{ $servicioSocial->prestador->total_horas }}  hrs.</span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato">Horario tentativo</label>
                    <span class="valor-dato">  {{ $servicioSocial->prestador->horario_tentativo }} </span>
                </div>
            @endif
            @if(in_array("observaciones", $secciones['datos_candidato']))
                <div class="col-md-4">
                    <label class="titulo-dato"> Observaciones </label>
                    <span class="valor-dato">  {{ $servicioSocial->prestador->observaciones }} </span>
                </div>
            @endif
        </div>
        @endif
        @if(in_array("datos_programa", $secciones))
        <hr>
        <div class="row mt-5">
            <div class="col-md-4">
                <label class="titulo-dato"> Nombre del programa </label>
                <span class="valor-dato">  {{ $servicioSocial->prestador->programa->nombre_programa ?? 'N/A' }} </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato"> Clave del programa </label>
                <span class="valor-dato">  {{ $servicioSocial->prestador->programa->clave_programa ?? 'N/A' }} </span>
            </div>
        </div>
        @endif
        @if(array_key_exists("datos_escolares", $secciones))
            @if(in_array("general", $secciones['datos_escolares']))
            <hr>
            <h6 class="mt-5"><strong>DATOS ESCOLARES</strong></h6>
            <div class="row mt-5">
                <div class="col-md-4">
                    <label class="titulo-dato"> Institución </label>
                    <span class="valor-dato">  {{ $servicioSocial->prestador->escuela->institucion->nombre_institucion }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Escuela </label>
                    <span class="valor-dato">  {{ $servicioSocial->prestador->escuela->nombre_escuela }} </span>
                </div>
                <div class="col-md-2">
                    <label class="titulo-dato"> Carrera </label>
                    <span class="valor-dato">  {{ $servicioSocial->prestador->carrera }} </span>
                </div>
                <div class="col-md-2">
                    <label class="titulo-dato"> Matrícula </label>
                    <span class="valor-dato">  {{ $servicioSocial->prestador->matricula }} </span>
                </div>
            </div>
            @endif
            @if(in_array("responsable", $secciones['datos_escolares']))
            <hr>
            <h6 class="mt-5"><strong>RESPONSABLE DE LA ESCUELA</strong></h6>
            <div class="row">
                <div class="col-md-3">
                    <label class="titulo-dato"> Nombre </label>
                    <span class="valor-dato">  {{ $servicioSocial->prestador->nombre_funcionario }} </span>
                </div>
                <div class="col-md-3">
                    <label class="titulo-dato"> Puesto </label>
                    <span class="valor-dato">  {{ $servicioSocial->prestador->puesto_funcionario }} </span>
                </div>
                <div class="col-md-3">
                    <label class="titulo-dato"> Télefono </label>
                    <span class="valor-dato">  {{ $servicioSocial->prestador->telefono_funcionario }} </span>
                </div>
            </div>
            @endif
        @endif
        @if(array_key_exists("prestacion_servicio", $secciones))
            @if(in_array("lugar", $secciones['prestacion_servicio']))
            <hr>
            <h6 class="mt-5"><strong>PRESTACIÓN DE SERVICIO</strong></h6>
            <div class="row mt-5">
                <div class="col-md-4">
                    <label class="titulo-dato"> Área de adscripción </label>
                    <span class="valor-dato">  {{ $servicioSocial->areaAdscripcion->nombre_area_adscripcion ?? ''}} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Dirección ejecutiva (Dirección área) </label>
                    <span class="valor-dato">  {{ $servicioSocial->direccion_ejecutiva ?? 'N/A' }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Coordinación </label>
                    <span class="valor-dato">  {{ $servicioSocial->coordinacion ?? 'N/A' }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Subdirección </label>
                    <span class="valor-dato">  {{ $servicioSocial->subdireccion_ua }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Unidad Departamental </label>
                    <span class="valor-dato">  {{ $servicioSocial->unidad_departamental_ua }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Domicilio de adscripción </label>
                    <span class="valor-dato">  {{ $servicioSocial->areaAdscripcion->direccion_area_adscripcion ?? ''}} </span>
                </div>
            </div>
            @endif
            @if(in_array("horario", $secciones['prestacion_servicio']))
            <hr>
            <h6 class="mt-5"><strong>DETALLES DE PRESTACIÓN</strong></h6>
            <div class="row">
                <div class="col-md-4">
                    <label class="titulo-dato"> Fecha Inicio </label>
                    <span class="valor-dato">  {{ $servicioSocial->fecha_inicio }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Fecha Fin </label>
                    <span class="valor-dato">  {{ $servicioSocial->fecha_fin }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Horario </label>
                    <span class="valor-dato">  {{ $servicioSocial->horario }} </span>
                </div>
                <div class="col-md-12">
                    <label class="titulo-dato"> Actividades a realizar </label>
                    <span class="valor-dato"> {{ $servicioSocial->actividades }} </span>
                </div>
            </div>
            @endif
            @if(in_array("jefe", $secciones['prestacion_servicio']))
            <hr>
            <h6 class="mt-5"><strong>JEFE INMEDIATO</strong></h6>
            <div class="row">
                <div class="col-md-3">
                    <label class="titulo-dato"> Nombre </label>
                    <span class="valor-dato">  {{ $servicioSocial->jefe }} </span>
                </div>
                <div class="col-md-3">
                    <label class="titulo-dato"> Puesto </label>
                    <span class="valor-dato">  {{ $servicioSocial->puesto_jefe }} </span>
                </div>
                <div class="col-md-3">
                    <label class="titulo-dato"> Télefono </label>
                    <span class="valor-dato">  {{ $servicioSocial->telefono_jefe }} </span>
                </div>
                <div class="col-md-3">
                    <label class="titulo-dato"> Ext. </label>
                    <span class="valor-dato">  {{ $servicioSocial->telefono_ext_jefe }} </span>
                </div>
            </div>
            @endif
        @endif
    </div>
</div>