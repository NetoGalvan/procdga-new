<div class="row">
    <div class="col-md-12">
        <strong class="text-uppercase">HORARIO GENERAL</strong>
    </div>
    <div class="col-md-3 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Entrada</strong></label>
        <input type="time" class="form-control" name="entrada" value="{{ isset($horario->entrada) ? substr($horario->entrada, 0, 5) : old("entrada") }}" autocomplete="off" required @if(isset($horario)) disabled @endif>
        <span class="form-text text-muted">Formato de 24 horas (HH:MM)</span>
    </div>
    <div class="col-md-3 form-group">
        <label class="titulo-dato">Salida</label>
        <input type="time" class="form-control" name="salida" value="{{ isset($horario->salida) ? substr($horario->salida, 0, 5) : old("salida") }}" autocomplete="off" @if(isset($horario)) disabled @endif>
        <span class="form-text text-muted">Formato de 24 horas (HH:MM)</span>
    </div>
    <div class="col-md-3 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Tipo empleado</strong></label>
        <select class="form-control" name="tipo_empleado" autocomplete="off" required @if(isset($horario)) disabled @endif>
            <option value="">Selecciona una opción</option>
            <option value="SINDICALIZADO" @if ((isset($horario) && $horario->tipo_empleado == "SINDICALIZADO") || old("tipo_empleado") == "SINDICALIZADO") selected @endif>SINDICALIZADO</option>
            <option value="NO_SINDICALIZADO" @if (isset($horario) && $horario->tipo_empleado == "NO_SINDICALIZADO" || old("tipo_empleado") == "NO_SINDICALIZADO") selected @endif>NO SINDICALIZADO</option>
        </select>
    </div>
    {{-- <div class="col-md-3 form-group">
        <label class="titulo-dato""><strong><span class="text-danger">*</span> Horario base</strong></label>
        <span class="switch switch-outline switch-icon switch-success">
            <label>
                <input type="checkbox" name="es_horario_base" autocomplete="off" @if (isset($horario) && $horario->es_horario_base || old("es_horario_base")) checked @endif @if(isset($horario)) disabled @endif>
                <span></span>
            </label>
        </span>
    </div> --}}
    <div class="col-md-12 form-group">
        @php
            $diasSemana = [ 
                "domingo" => "Domingo", 
                "lunes" => "Lunes", 
                "martes" => "Martes", 
                "miercoles" => "Miércoles", 
                "jueves" => "Jueves", 
                "viernes" => "Viernes", 
                "sabado" => "Sábado",
            ]    
        @endphp
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Días laborales</strong></label>
        <div class="checkbox-inline">
            @foreach ($diasSemana as $indice => $dia)
                <label class="checkbox">
                    <input type="checkbox" name="dias_laborales[]" value="{{ $indice }}" autocomplete="off" @if (isset($horario) && substr($horario->dias, $loop->index, 1) || in_array($indice, old("dias_laborales") ?? [])) checked @endif  @if(isset($horario)) disabled @endif />
                    <span></span>
                    {{ $dia }}
                </label>
            @endforeach
        </div>
    </div>
    <div class="col-md-3 form-group">
        <label class="titulo-dato""><strong><span class="text-danger">*</span> ¿DÍAS FESTIVOS SON LABORALES? </strong></label>
        <span class="switch switch-outline switch-icon switch-success">
            <label>
                <input type="checkbox" name="dias_festivos_son_laborales" autocomplete="off" @if (isset($horario) && $horario->dias_festivos_son_laborales || old("dias_festivos_son_laborales")) checked @endif @if(isset($horario)) disabled @endif>
                <span></span>
            </label>
        </span>
    </div>
</div>
<div class="separator separator-solid mb-10"></div>
<div class="row">
    <div class="col-md-12">
        <h4 class="font-weight-bold mb-6">Intervalos</h4>
    </div>
    <div class="col-md-12">
        <strong class="text-uppercase">ENTRADA</strong>
        @php
            $intervaloEntrada = isset($horario) ? $horario->intervalos()->where("tipo", "ENTRADA")->first() : null;
        @endphp
    </div>
    <div class="col-md-3 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Inicio</strong></label>
        <input type="time" class="form-control" name="intervalos[ENTRADA][inicio]" value="{{ $intervaloEntrada ? substr($intervaloEntrada->inicio, 0, 5) : old("intervalos.ENTRADA.inicio") }}" autocomplete="off" required @if(isset($horario)) disabled @endif>
        <span class="form-text text-muted">Formato de 24 horas (HH:MM)</span>
    </div>
    <div class="col-md-3 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Final</strong></label>
        <input type="time" class="form-control" name="intervalos[ENTRADA][final]" value="{{ $intervaloEntrada ? substr($intervaloEntrada->final, 0, 5) : old("intervalos.ENTRADA.final") }}" autocomplete="off" required @if(isset($horario)) disabled @endif>
        <span class="form-text text-muted">Formato de 24 horas (HH:MM)</span>
    </div>
    <div class="col-md-12">
        <strong class="text-uppercase">SALIDA</strong>
        @php
            $intervaloSalida = isset($horario) ? $horario->intervalos()->where("tipo", "SALIDA")->first() : null;
        @endphp
    </div>
    <div class="col-md-3 form-group">
        <label class="titulo-dato">Inicio</label>
        <input type="time" class="form-control" name="intervalos[SALIDA][inicio]" value="{{ $intervaloSalida ? substr($intervaloSalida->inicio, 0, 5) : old("intervalos.SALIDA.inicio") }}" autocomplete="off"  @if(isset($horario)) disabled @endif>
        <span class="form-text text-muted">Formato de 24 horas (HH:MM)</span>
    </div>
    <div class="col-md-3 form-group">
        <label class="titulo-dato">Final</label>
        <input type="time" class="form-control" name="intervalos[SALIDA][final]" value="{{ $intervaloSalida ? substr($intervaloSalida->final, 0, 5) : old("intervalos.SALIDA.final") }}" autocomplete="off"  @if(isset($horario)) disabled @endif>
        <span class="form-text text-muted">Formato de 24 horas (HH:MM)</span>
    </div>
    <div class="col-md-12">
        <label class="titulo-dato"">Habilitar retardos</label>
        <span class="switch switch-outline switch-icon switch-success">
            <label>
                <input type="checkbox" name="aplica_retardos" autocomplete="off" @if ((isset($horario) && $horario->aplica_retardos) || old("aplica_retardos")) checked @endif  @if(isset($horario)) disabled @endif>
                <span></span>
            </label>
        </span>
    </div>
    <div class="col-md-12">
        <div class="row" id="contenedor_intervalos_retardos" @if ((!is_null(old("aplica_retardos")) && old("aplica_retardos")) || (isset($horario) && $horario->aplica_retardos)) @else style="display: none;" @endif>
            <div class="col-md-12">
                <strong class="text-uppercase">RETARDO LEVE</strong>
            </div>
            <div class="col-md-3 form-group">
                <label class="titulo-dato"><strong><span class="text-danger">*</span> Inicio</strong></label>
                <input type="time" class="form-control" name="intervalos[RETARDO_LEVE][inicio]" value="{{ (isset($horario) && $horario->aplica_retardos) ? substr($horario->intervalos()->where("tipo", "RETARDO_LEVE")->first()->inicio, 0, 5) : old("intervalos.RETARDO_LEVE.inicio") }}" autocomplete="off" required @if(isset($horario)) disabled @endif>
                <span class="form-text text-muted">Formato de 24 horas (HH:MM)</span>
            </div>
            <div class="col-md-3 form-group">
                <label class="titulo-dato"><strong><span class="text-danger">*</span> Final</strong></label>
                <input type="time" class="form-control" name="intervalos[RETARDO_LEVE][final]" value="{{ (isset($horario) && $horario->aplica_retardos) ? substr($horario->intervalos()->where("tipo", "RETARDO_LEVE")->first()->final, 0, 5) : old("intervalos.RETARDO_LEVE.final") }}" autocomplete="off" required @if(isset($horario)) disabled @endif>
                <span class="form-text text-muted">Formato de 24 horas (HH:MM)</span>
            </div>
            <div class="col-md-12">
                <strong class="text-uppercase">RETARDO GRAVE</strong>
            </div>
            <div class="col-md-3 form-group">
                <label class="titulo-dato"><strong><span class="text-danger">*</span> Inicio</strong></label>
                <input type="time" class="form-control" name="intervalos[RETARDO_GRAVE][inicio]" value="{{ (isset($horario) && $horario->aplica_retardos) ? substr($horario->intervalos()->where("tipo", "RETARDO_GRAVE")->first()->inicio, 0, 5) : old("intervalos.RETARDO_GRAVE.inicio") }}" autocomplete="off" required @if(isset($horario)) disabled @endif>
                <span class="form-text text-muted">Formato de 24 horas (HH:MM)</span>
            </div>
            <div class="col-md-3 form-group">
                <label class="titulo-dato"><strong><span class="text-danger">*</span> Final</strong></label>
                <input type="time" class="form-control" name="intervalos[RETARDO_GRAVE][final]" value="{{ (isset($horario) && $horario->aplica_retardos) ? substr($horario->intervalos()->where("tipo", "RETARDO_GRAVE")->first()->final, 0, 5) : old("intervalos.RETARDO_GRAVE.final") }}" autocomplete="off" required @if(isset($horario)) disabled @endif>
                <span class="form-text text-muted">Formato de 24 horas (HH:MM)</span>
            </div>
        </div>
    </div>
</div>