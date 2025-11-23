@extends('layouts.auth')

@section('title', 'Restablecer contraseña')

@section('subtitle', 'Introduzca su correo electrónico')

@section('content')
    @if (session('status'))
    <div class="alert alert-custom alert-light-success fade show mb-8" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">
            {{ session('status') }}
        </div>
    </div>
    @endif
    <form id="form_restablecer_contraseña" method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="row">
            <div class="col-12 form-group">
                <input 
                    type="email" 
                    class="form-control form-control-lg @error('email') is-invalid @enderror" 
                    name="email" 
                    value="{{ old('email') }}"  
                    placeholder="Correo electrónico"
                    autocomplete="off" 
                    required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-primary btn-lg btn-block mt-8 py-4"><i class="fas fa-sign-in-alt"></i> Enviar enlace de restablecimiento</button>
        </div>
    </form>
@endsection

@push('scripts')	
	<script>
        const formRestablecer = $("#form_restablecer_contraseña");
        formRestablecer.validate({
            onfocusout: false,
            errorClass: "is-invalid",
        });
    </script>
@endpush