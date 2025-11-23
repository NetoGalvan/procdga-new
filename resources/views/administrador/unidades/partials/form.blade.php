<div class="row">
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Nombre</strong></label>
        <input type="text" class="form-control normalizar-texto" name="nombre" id="nombre" value="{{ old("nombre") ?? $unidad->nombre ?? "" }}" autocomplete="off" required>
    </div>
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Identificador</strong></label>
        <input type="text" class="form-control normalizar-texto" name="identificador" id="identificador" value="{{ old("identificador") ?? $unidad->identificador ?? "" }}" number="true" autocomplete="off" required  @if (isset($unidad->identificador)) disabled @endif>
        @if (isset($unidad->identificador))
        <small class="valor-dato"> El campo identificador no puede ser editado </small>
        @endif
    </div>
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Dependencia </strong></label>
        <input type="hidden" class="form-control normalizar-texto" name="dependencia_id" id="dependencia_id" value="{{ $dependencia->dependencia_id }}" autocomplete="off" required>
        <span class="valor-dato">  {{  $dependencia->nombre }} </span>
    </div>
</div>
