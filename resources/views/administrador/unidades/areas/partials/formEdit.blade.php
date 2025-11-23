<div class="row">
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Nombre</strong></label>
        <input type="text" class="form-control normalizar-texto" name="nombre" value="{{ old("nombre") ?? $area->nombre ?? "" }}" autocomplete="off" required>
    </div>
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Identificador</strong></label>
        <input type="text" class="form-control normalizar-texto" name="identificador" id="identificador" value="{{ old("identificador") ?? $area->identificador ?? "" }}" number="true" autocomplete="off" required @if (isset($area->identificador)) disabled @endif>
        @if (isset($area->identificador))
        <small class="valor-dato"> El campo identificador no puede ser editado </small>
        @endif
    </div>
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Unidad administrativa</strong></label>
        <input type="hidden" class="form-control normalizar-texto" name="unidad_administrativa_id" id="unidad_administrativa_id" value="{{ $unidad->unidad_administrativa_id }}" autocomplete="off" required>
        <span class="valor-dato">  {{  $unidad->nombre }} </span>
    </div>
    @if (isset($area->identificador))
        <div class="form-group col-md-4">
            <label for="activo" class="titulo-dato">Estatus</label>
            <input 
                id="activo" 
                name="activo" 
                type="checkbox" 
                data-switch="true" 
                data-on-text="Activo" 
                data-off-text="Inactivo" 
                data-on-color="success" 
                data-off-color="danger"/>
        </div>
    @endif
</div>
