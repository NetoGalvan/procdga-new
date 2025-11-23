<div class="row">
    <div class="form-group col-md-4">
        <label><span class="text-danger">*</span> Nivel salarial:</label>
        <input type="text"
            name="nombre"
            class="form-control"
            value="{{ old("nombre") ?? $nivelSalarial->nombre ?? "" }}"
            required />
    </div>
    <div class="form-group col-md-4">
        <label><span class="text-danger">*</span> Identificador nivel salarial:</label>
        <input type="text"
            name="identificador"
            class="form-control"
            value="{{ old("identificador") ?? $nivelSalarial->identificador ?? ""  }}"
            required />
    </div>
    <div class="form-group col-md-4">
        <label><span class="text-danger">*</span> Tipo estructura:</label>
        <select
            name="tipo_personal"
            class="form-control"
            required />
            <option value=""> Selecciona una opción </option>
            <option value="ESTRUCTURA" @if(old("tipo_personal") == "ESTRUCTURA" || (isset($nivelSalarial) && $nivelSalarial->tipo_personal == "ESTRUCTURA")) selected @endif> ESTRUCTURA </option>
            <option value="BASE CON DIGITO" @if(old("tipo_personal") == "BASE CON DIGITO" || (isset($nivelSalarial) && $nivelSalarial->tipo_personal == "BASE CON DIGITO")) selected @endif> BASE CON DIGITO </option>
            <option value="BASE SIN DIGITO" @if(old("tipo_personal") == "BASE SIN DIGITO" || (isset($nivelSalarial) && $nivelSalarial->tipo_personal == "BASE SIN DIGITO")) selected @endif> BASE SIN DIGITO </option>
            <option value="CONFIANZA" @if(old("tipo_personal") == "CONFIANZA" || (isset($nivelSalarial) && $nivelSalarial->tipo_personal == "CONFIANZA")) selected @endif> CONFIANZA </option>
            <option value="ESTABILIDAD LABORAL" @if(old("tipo_personal") == "ESTABILIDAD LABORAL" || (isset($nivelSalarial) && $nivelSalarial->tipo_personal == "ESTABILIDAD LABORAL")) selected @endif> ESTABILIDAD LABORAL </option>
        </select>
    </div>
    <div class="form-group col-md-4">
        <label><span class="text-danger">*</span> Sueldo cotizable </label>
        <input type="text"
            name="sueldo_cotizable"
            class="form-control"
            value="{{ old("sueldo_cotizable") ?? $nivelSalarial->sueldo_cotizable ?? ""  }}"
            required />
    </div>
    <div class="form-group col-md-4">
        <label><span class="text-danger">*</span> Sueldo sar </label>
        <input type="text"
            name="sueldo_sar"
            class="form-control"
            value="{{ old("sueldo_sar") ?? $nivelSalarial->sueldo_sar ?? ""  }}"
            required />
    </div>
    <div class="form-group col-md-4">
        <label><span class="text-danger">*</span> Sueldo total </label>
        <input type="text"
            name="sueldo_total"
            class="form-control"
            value="{{ old("sueldo_total") ?? $nivelSalarial->sueldo_total ?? ""  }}"
            required />
    </div>
</div>
