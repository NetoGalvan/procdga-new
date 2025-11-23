@component('mail::message')

Buen día, se solicita atender la siguiente solicitud: <b>{{$solicitaServicio->servicioGeneral->nombre_servicio_general}}</b>, con folio: <b>{{$solicitaServicio->folio}}</b>.


Gracias.<br>
{{ config('app.name') }}
@endcomponent
