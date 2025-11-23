
@foreach ($roles as $rol)
    <div class="form-group row mb-0">
        <label class="col-3 col-form-label">{{ $rol->name }}</label>
        <div class="col-3">
            <span class="switch switch-brand">
                <label>
                    <input 
                        type="checkbox" 
                        name="roles[]"
                        value="{{$rol->name}}" 
                        id="{{$rol->name}}" 
                        autocomplete="off"
                        required
                        <?php
                            if (!$errors->has('roles')) {                                         
                                if (!is_null(old('roles')) && in_array($rol->name, old('roles'))) {
                                    echo e("checked");
                                } else if (isset($usuario->roles)) {
                                    
                                    $usuarioRoles =  $usuario->roles->pluck("name");                                                       

                                    if (in_array($rol->name, $usuarioRoles->all())) {
                                        echo e("checked");
                                    } 
                                }
                            }
                        ?>
                    />
                    <span></span>
                </label>
            </span>
        </div>
    </div>                 
@endforeach
@error('roles')
    <div class="form-group col-md-4">
        <span class="error-personalizado" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    </div>                                
@enderror
    