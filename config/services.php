<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'eventos_biometricos' => [
        'url' => env('BIOMETRICOS_URL'),
        'token' => env('BIOMETRICOS_TOKEN'),
        'endpoints' => [
            "get_eventos" => env('BIOMETRICOS_EVENTOS'),
            "get_eventos_empleado" => env('BIOMETRICOS_EVENTOS_EMPLEADO'),
            'get_imagen_evento' => env('BIOMETRICOS_IMAGEN_EVENTO'),
        ]
    ],
    
    'consulta_empleado' => [
        'url' => env('CONSULTA_EMPLEADO_URL'),
        'token' => env('CONSULTA_EMPLEADO_TOKEN'),
    ],
    
    'consulta_premio_puntualidad_asistencia' => [
        'url' => env('CONSULTA_PREMIO_PUNTUALIDAD_ASISTENCIA_URL'),
        'token' => env('CONSULTA_PREMIO_PUNTUALIDAD_ASISTENCIA_TOKEN'),
    ],
    
    'credencializacion' => [
        'url_authorize' => env('CREDENCIALIZACION_SERVER') . "/" . env('CREDENCIALIZACION_SERVER_URL_AUTHORIZE'),
        'url_token' => env('CREDENCIALIZACION_SERVER') . "/" . env('CREDENCIALIZACION_SERVER_URL_TOKEN'),
        'url_user' => env('CREDENCIALIZACION_SERVER') . "/" . env('CREDENCIALIZACION_SERVER_URL_USER'),
        'client_id' => env('CREDENCIALIZACION_CLIENT_ID'),
        'client_secret' => env('CREDENCIALIZACION_CLIENT_SECRET'),
    ],
];
