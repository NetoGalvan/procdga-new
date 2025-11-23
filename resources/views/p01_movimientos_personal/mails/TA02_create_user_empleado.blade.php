@component('mail::message')
# Inicio de trámite de movimiento de personal 

Hola {{$usuario->nombre}} {{$usuario->apellido_paterno}} {{$usuario->apellido_materno}}, se ha iniciado un movimiento de personal con folio: {{ $movimientoPersonal->instancia->folio }}

Favor de ingresar al sistema PROCDGA con las siguientes crendenciales y subir los documentos que se le han solicitado . <br> <br>
Usuario: {{ $usuario->email }} <br>
Contraseña: {{ $password }}

@component('mail::button', ['url' => Config::get('app.url')])
Ingresar
@endcomponent

@endcomponent