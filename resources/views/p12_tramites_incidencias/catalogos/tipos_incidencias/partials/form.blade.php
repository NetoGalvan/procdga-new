<div class="row">    
    <div class="col-md-4 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Tipo justificación</strong></label>
        <select class="form-control" name="tipo_justificacion_id" autocomplete="off" required @if ($tipoModulo == "edit") disabled @endif>
            <option value="">Selecciona una opción</option>
            @foreach($tiposJustificaciones as $tipoJustificacion)
                @if (isset($tipoIncidencia) && $tipoIncidencia->tipo_justificacion_id == $tipoJustificacion->tipo_justificacion_id) 
                    <option value="{{ $tipoJustificacion->tipo_justificacion_id }}" selected>{{ $tipoJustificacion->nombre }}</option>
                @else
                    <option value="{{ $tipoJustificacion->tipo_justificacion_id }}">{{ $tipoJustificacion->nombre }}</option>
                @endif 
            @endforeach
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Descripción</strong></label>
        <textarea class="form-control normalizar-texto" name="descripcion" autocomplete="off" required @if ($tipoModulo == "edit") disabled @endif>{{ $tipoIncidencia->descripcion ?? "" }}</textarea>
    </div>
    <div class="col-md-4 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Ley</strong></label>
        <textarea class="form-control normalizar-texto" name="ley" autocomplete="off" required @if ($tipoModulo == "edit") disabled @endif>{{ $tipoIncidencia->ley ?? "" }}</textarea>
    </div>
    <div class="col-md-4 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Artículo </strong></label>
        <input type="text" class="form-control normalizar-texto" name="articulo" autocomplete="off" value="{{ $tipoIncidencia->articulo ?? "" }}" required @if ($tipoModulo == "edit") disabled @endif></input>
    </div>
    <div class="col-md-4 form-group">
        <label class="titulo-dato"> Subartículo </label>
        <input type="text" class="form-control normalizar-texto" name="subarticulo" autocomplete="off" value="{{ $tipoIncidencia->subarticulo ?? "" }}" @if ($tipoModulo == "edit") disabled @endif></input>
    </div>
    <div class="col-md-4 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Intervalo</strong></label>
        <select class="form-control" name="intervalo_evaluacion" autocomplete="off" required @if ($tipoModulo == "edit") disabled @endif>
            <option value="">Selecciona una opción</option>
            @foreach($intervalos as $intervalo)
                @if (isset($tipoIncidencia) && $tipoIncidencia->intervalo_evaluacion == $intervalo) 
                    <option value="{{ $intervalo }}" selected>{{ str_replace("_", " ", $intervalo) }}</option>
                @else
                    <option value="{{ $intervalo }}">{{ str_replace("_", " ", $intervalo) }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Tipo de empleado</strong></label>
        <select class="form-control" name="tipo_empleado" autocomplete="off" required @if ($tipoModulo == "edit") disabled @endif>
            <option value="">Selecciona una opción</option>
            @foreach($tiposEmpleados as $tipoEmpleado)
                @if (isset($tipoIncidencia) && $tipoIncidencia->tipo_empleado == $tipoEmpleado) 
                    <option value="{{ $tipoEmpleado }}" selected>{{ str_replace("_", " ", $tipoEmpleado) }}</option>
                @else
                    <option value="{{ $tipoEmpleado }}">{{ str_replace("_", " ", $tipoEmpleado) }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Sexo</strong></label>
        <select class="form-control" name="sexo" autocomplete="off" required @if ($tipoModulo == "edit") disabled @endif>
            <option value="">Selecciona una opción</option>
            @foreach($sexos as $sexo)
                @if (isset($tipoIncidencia) && $tipoIncidencia->sexo == $sexo) 
                    <option value="{{ $sexo }}" selected>{{ str_replace("_", " ", $sexo) }}</option>
                @else
                    <option value="{{ $sexo }}">{{ str_replace("_", " ", $sexo) }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Tipo de dias</strong></label>
        <select class="form-control" name="tipo_dias" autocomplete="off" required @if ($tipoModulo == "edit") disabled @endif>
            <option value="">Selecciona una opción</option>
            @foreach($tiposDias as $tipoDias)
                @if (isset($tipoIncidencia) && $tipoIncidencia->tipo_dias == $tipoDias) 
                    <option value="{{ $tipoDias }}" selected>{{ str_replace("_", " ", $tipoDias) }}</option>
                @else
                    <option value="{{ $tipoDias }}">{{ str_replace("_", " ", $tipoDias) }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Observaciones</strong></label>
        <textarea class="form-control normalizar-texto" name="observaciones" autocomplete="off" required>{{ $tipoIncidencia->observaciones ?? "" }}</textarea>
    </div>
</div>
<div class="row">
    <div class="col-md-4 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Autoincidencia</strong></label>
        <span class="switch">
            <label>
                <input type="checkbox" name="aplica_autoincidencia" autocomplete="off" @if (isset($tipoIncidencia) && $tipoIncidencia->aplica_autoincidencia) checked @endif/>
                <span></span>
            </label>
        </span>
    </div>
    @if ($tipoModulo == "edit")
    <div class="col-md-4 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Activo </strong></label>
        <span class="switch">
            <label>
                <input type="checkbox" name="activo" autocomplete="off" @if (isset($tipoIncidencia) && $tipoIncidencia->activo) checked @endif/>
                <span></span>
            </label>
        </span>
    </div>
    @endif
</div>