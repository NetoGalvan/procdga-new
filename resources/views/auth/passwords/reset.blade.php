@extends('layouts.auth')

@section('title', 'Restablecer contraseña')

@section('subtitle', 'Introduzca una nueva contraseña')

@section('content')
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
    <form id="form_restablecer_contraseña" method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="row">
            <div class="col-12 form-group">
                <input type="password"
                    class="form-control form-control-lg"
                    id="password"
                    name="password" 
                    autocomplete="off"
                    placeholder="Contraseña"
                    required>
            </div>
            <div class="col-12 form-group">
                <input type="password"
                    class="form-control form-control-lg"
                    id="password_confirmation"
                    name="password_confirmation" 
                    autocomplete="off"
                    placeholder="Confirmar contraseña"
                    required>
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-primary btn-lg btn-block mt-8 py-4"><i class="fas fa-sign-in-alt"></i> Restablecer contraseña</button>
        </div>         
    </form>
@endsection

@push('scripts')	
	<script>
        const formRestablecer = $("#form_restablecer_contraseña");
        formRestablecer.validate({
            onfocusout: false,
            errorClass: "is-invalid",
            rules: {
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    minlength: 8,
                    equalTo: "#password"
                }
            }, 
            messages: {
                password_confirmation: {
                    equalTo: "Las contraseñas no coinciden"
                }
            }
        });
    </script>
@endpush
