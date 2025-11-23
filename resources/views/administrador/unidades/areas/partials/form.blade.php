<div class="row">
    <div class="col-md-4 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Tipo</strong></label>
        <select name="tipo_area" id="tipo_area" class="form-control" autocomplete="off" required>
            <option value=""> Selecciona una opción </option>
            <option value="AREA_PRINCIPAL"> ÁREA PRINCIPAL </option>
            <option value="SUBAREA"> SUBÁREA </option>
        </select>
    </div>
    <div class="col-md-4 form-group contenedor-datos-area-subarea d-none">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Área </strong></label>
        <select name="area_id" id="area_id" class="form-control" autocomplete="off" required>
            <option value=""> Selecciona una opción </option>
            @foreach ($areasPrincipales as $area)
                <option value="{{ $area->area_id }}"> {{ $area->nombre_completo }} </option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4 contenedor-datos-area d-none">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Identificador</strong>
            <i class="fa fa-question-circle icon-nm" data-toggle="tooltip" data-placement="top" title="Para crear un Área se acepta del 1 al 9 y para crear Subárea se acepta del 01 al 99"></i>
        </label>
        <input type="text" class="form-control normalizar-texto" name="identificador" id="identificador" value="{{ old("identificador") }}" number="true" autocomplete="off" required>
        <small class="valor-dato" id="mensaje_identificador"></small>
    </div>
    <div class="form-group col-md-4 contenedor-datos-area d-none">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Nombre</strong></label>
        <input type="text" class="form-control normalizar-texto" name="nombre" id="nombre" value="{{ old("nombre") }}" autocomplete="off" required>
    </div>
</div>
