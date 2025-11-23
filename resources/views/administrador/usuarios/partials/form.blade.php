<div class="form-row">
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Nombre(s)</strong></label>
        <input id="nombre" type="text" class="form-control normalizar-texto" name="nombre" value="{{ old("nombre") ?? $usuario->nombre ?? "" }}" autocomplete="off" required>
    </div>
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Primer apellido</strong></label>
        <input id="apellido_paterno" type="text" class="form-control normalizar-texto" name="apellido_paterno" value="{{ old("apellido_paterno") ?? $usuario->apellido_paterno ?? "" }}" autocomplete="off" required>
    </div>
    <div class="form-group col-md-4">
        <label class="titulo-dato">Segundo apellido</label>
        <input id="apellido_materno" type="text" class="form-control normalizar-texto" name="apellido_materno" value="{{ old("apellido_materno") ?? $usuario->apellido_materno ?? "" }}" autocomplete="off">
    </div>
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> CURP</strong></label>
        <input id="curp" type="text" class="form-control normalizar-texto" name="curp" {{-- CURP="true" --}} value="{{ old("curp") ?? $usuario->curp ?? "" }}" autocomplete="off" required>
    </div>
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> RFC</strong></label>
        <input id="rfc" type="text" class="form-control normalizar-texto" name="rfc" {{-- RFC="true" --}} value="{{ old("rfc") ?? $usuario->rfc ?? "" }}" autocomplete="off" required>
    </div>
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Número de empleado</strong></label>
        <input id="numero_empleado" type="text" number="true" class="form-control normalizar-texto" name="numero_empleado" value="{{ old("numero_empleado") ?? $usuario->numero_empleado ?? "" }}" autocomplete="off" required>
    </div>
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Correo electrónico</strong></label>
        <input id="email" type="email" class="form-control" name="email" value="{{ old("email") ?? $usuario->email ?? "" }}" autocomplete="off" required>
    </div>
    <div class="form-group col-md-4">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Puesto</strong></label>
        <input id="puesto" type="text" class="form-control normalizar-texto" name="puesto" value="{{ old("puesto") ?? $usuario->puesto ?? "" }}" autocomplete="off" required>
    </div>
</div>    
 

