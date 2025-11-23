<div class="row">
    <div class="col-md-3 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Nombre:</strong></label>
        <input type="text" class="form-control normalizar-texto" name="nombre" value="{{ $biometrico->nombre ?? old("nombre") ?? "" }}" autocomplete="off" required>
    </div>
    <div class="col-md-3 form-group">
        <label class="titulo-dato">Acceso:</label>
        <input type="text" class="form-control normalizar-texto" name="acceso" value="{{ $biometrico->acceso ?? old("acceso") ?? "" }}" autocomplete="off">
    </div>
    <div class="col-md-3 form-group">
        <label class="titulo-dato">IP:</label>
        <input type="text" class="form-control normalizar-texto" name="ip" value="{{ $biometrico->ip ?? old("ip") ?? "" }}" autocomplete="off">
    </div>
    <div class="col-md-3 form-group">
        <label class="titulo-dato">Ubicación:</label>
        <input type="text" class="form-control normalizar-texto" name="ubicacion" value="{{ $biometrico->ubicacion ?? old("ubicacion") ?? "" }}" autocomplete="off">
    </div>
    <div class="col-md-3 form-group">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Tipo</strong></label>
        <select class="form-control normalizar-texto" name="tipo" autocomplete="off" required>
            <option value="">Selecciona una opción</option>
            <option value="DACTILAR" @if ((isset($biometrico) && $biometrico->tipo == "DACTILAR") || old("tipo") == "DACTILAR") selected @endif>DACTILAR</option>
            <option value="FACIAL" @if (isset($biometrico) && $biometrico->tipo == "FACIAL" || old("tipo") == "FACIAL") selected @endif>FACIAL</option>
        </select>
    </div>
</div>