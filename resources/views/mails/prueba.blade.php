@component('mail::message')
# Bienvenido al sistema de procdga 

Esto es una prueba de envio de correo electrónico. <br>



@component('mail::button', ['url' => Config::get('app.url')])
Ingresar
@endcomponent

@endcomponent