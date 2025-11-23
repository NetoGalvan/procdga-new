@extends('layouts.auth')

@section('title', 'Actualizar contraseña')

@section('content')
    <div class="alert alert-custom alert-outline-primary fade show mb-8" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">Por seguridad cambia tu contraseña antes de comenzar a utilizar el sistema PROCDGA.</div>
    </div>
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
    <form id="id_form_change_pass" action="{{ route('change.password.first.login') }}" method="POST">
        @csrf
        <div class="form-group">
            <input 
                id="password" 
                type="password" 
                class="form-control form-control-lg" 
                name="password" 
                placeholder="Nueva contraseña"
                autocomplete="off"
                required> 
        </div>
        <div class="form-group">
            <input 
                id="password_confirmation" 
                type="password" 
                class="form-control form-control-lg" 
                name="password_confirmation"
                placeholder="Confirmar nueva contraseña" 
                autocomplete="new-password"
                required>
        </div>
        <div class="text-center">
            <button class="btn btn-primary btn-lg btn-block mt-8 py-4"><i class="fas fa-save"></i> Actualizar contraseña</button>
        </div>        
    </form>
@endsection

@push('scripts')
    <script>
        var formChangePass = $("#id_form_change_pass");
        formChangePass.validate({
            rules: {
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    minlength: 8,
                    equalTo: "#password"
                },
            },
            messages: {
                password_confirmation: {
                    equalTo: "Las contraseñas no coinciden"
                }
            }
        }); 

    </script>    
@endpush
