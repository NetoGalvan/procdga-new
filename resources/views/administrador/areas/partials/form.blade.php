@if ($errors->any())
    <div class="alert alert-custom alert-light-danger fade show mb-8" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">
            @foreach ($errors->all() as $error)
                • {{ $error }} <br>
            @endforeach
        </div>
    </div>
@endif
<div class="row">
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Nombre</strong></label>
        <input type="text" class="form-control normalizar-texto" name="nombre" value="{{ old("nombre") ?? $area->nombre ?? "" }}" autocomplete="off" required>
    </div>
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> CN</strong></label>
        <input type="text" class="form-control normalizar-texto" name="cn" value="{{ old("cn") ?? $area->identificador ?? "" }}" number="true" autocomplete="off" required>
    </div>
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Unidad administrativa</strong></label>
        <select id="unidad_administrativa_id" name="unidad_administrativa_id" class="custom-select select2" autocomplete="off" required>
            <option value>Selecciona una opción</option>
            @foreach ($unidadesAdministrativas as $unidadAdministrativa)
                <option value="{{$unidadAdministrativa->unidad_administrativa_id}}" 
                    {{ (old("unidad_administrativa_id") == $unidadAdministrativa->unidad_administrativa_id) || (isset($area->unidadAdministrativa->unidad_administrativa_id) && ($area->unidadAdministrativa->unidad_administrativa_id == $unidadAdministrativa->unidad_administrativa_id)) ? "selected" : "" }}>{{ $unidadAdministrativa->nombre }}</option>
            @endforeach
        </select>
    </div>
</div>    
 

