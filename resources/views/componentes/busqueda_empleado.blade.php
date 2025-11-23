@if (isset($noRequerido))
<label class="titulo-dato">Ingresar RFC o número de empleado:</label>
@else
<label class="titulo-dato"><strong><span class="text-danger">*</span> Ingresar RFC o número de empleado:</strong></label>
@endif
<select id="datos_empleado" 
    name="datos_empleado" 
    class="form-control select2 normalizar-texto" 
    ruta-get-empleados="{{ route("alfabetico.get.empleados") }}" 
    autocomplete="off" 
    @if (!isset($noRequerido)) required @endif> 
    @if (isset($existeEmpleado) && $existeEmpleado)
        <option value="false" selected> 
            {{ $empleado }}
        </option>
    @endif
</select>
<spam class="form-text text-muted">Nombre empleado || RFC || Número de empleado</span>
