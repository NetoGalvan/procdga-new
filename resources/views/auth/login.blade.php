@extends('layouts.auth')

@section('title', 'Iniciar sesión')

@section('subtitle', 'Introduzca su correo electrónico y su contraseña')

@section('content')  
    @if ($errors->any())
    <div class="alert alert-custom alert-light-danger fade show mb-8" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">
            @foreach ($errors->all() as $error)
                • {!! $error !!} <br>
            @endforeach
        </div>
    </div>
    @endif
    <form id="form_login" action="{{ route('login') }}" method="POST" class="form">
        @csrf
        <div class="row">
            <div class="col-12 form-group">
                <input type="text"
                    class="form-control form-control-lg"
                    name="login" value="{{ old('login') }}"
                    autocomplete="off"
                    placeholder="RFC o correo electrónico"
                    required>
            </div>
            <div class="col-12 form-group">
                <input type="password"
                    class="form-control form-control-lg"
                    name="password"
                    autocomplete="off"
                    placeholder="Contraseña"
                    required>
            </div>
            <div class="col-12 form-group">
                <a href="{{ route('password.request') }}" class="text-muted text-hover-primary">¿Ha olvidado su contraseña?</a>
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-primary btn-lg btn-block mt-8 py-4"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</button>
            {{-- <a class="btn btn-outline-primary btn-lg btn-block mt-8 py-4" href="{{ route("credencializacion.login") }}"><i class="fas fa-address-card"></i> Continuar con credencialización </a> --}}
        </div>
    </form>
@endsection

@push('scripts')
	<script>
        const formLogin = $("#form_login");
        formLogin.validate({
            onfocusout: false,
            errorClass: "is-invalid",
        });
    </script>
@endpush

