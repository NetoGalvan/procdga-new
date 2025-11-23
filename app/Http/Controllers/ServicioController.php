<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

class ServicioController extends Controller
{

    /*
     * Método que obtiene la información de un empleado
     */
    public function getDatosEmpleado(Request $request) {

        $rfc = $request->input('rfc');
        $numeroEmpleado = $request->input('numero_empleado');
        $camposRequeridos = $request->campos_requeridos;
        $relacionCampos = [
            'numero_empleado' => 'NUMEMPLEADO',
            'plaza_id' => 'NUM_PLAZA',
            'sector' => 'SECT_PRES',
            'nombre_sector' => 'N_SECT_PRES',
            'nombre_empleado' => 'nombres',
            'primer_apellido' => 'paterno',
            'segundo_apellido' => 'materno',
            'nombre_completo' => 'NombreUsuario',
            'rfc' => 'RFC',
            'curp' => 'CURP',
            'unidad_administrativa' => 'UNIDAD_ADM',
            'nombre_unidad_administrativa' => 'N_UNIDAD_ADM',
            'tipo_nomina' => 'TIPOCONTRATO',
            'universo' => 'UNIVERSO',
            'nivel_salarial' => 'NIVEL_SALARIAL',
            'nombre_puesto' => 'COD_PUESTO_CVE_ACT',
            'descripcion_puesto' => 'N_PUESTO_ACT_ASOC_PROG',
            'seccion_sindical' => 'SINDICATO',
            'fecha_alta_empleado' => 'FECHAINICIOREALLABORAL',
            'zona_pagadora' => 'ZONA_PAGADORA',
            'departamento' => 'DEPARTAMENTO',
            'antiguedad' => 'ANTIGUEDAD',
            'sindicalizado' => 'SINDICALIZADO',
            'tipo_jornada' => 'TIPOJORNADA',
            'tipo_regimen' => 'TIPOREGIMEN',
            'riesgo_puesto' => 'RIESGOPUESTO',
            'periodicidad_pago' => 'PERIODICIDADPAGO',
            'serie' => 'SERIE',
            'comision_sindical' => 'COMISION_SIND',
            'tipo_contratacion_subprog' => 'TIPO_CONTRATACION_SUBPROG',
            'estatus' => 'status',
            'created_at' => 'CreateMng',
            'num_empleado' => 'NumEmpleado'
        ];
        $respuesta = array();

        $request = [
            "security" => [
                "token" => env('TOKEN_WS_DATA_EMPLOYEE_SAF')
            ],
            "data" => [
                "NUMEMPLEADO" => strval($numeroEmpleado),
                "RFC" => $rfc
                ]
            ];

        $url_ws = env('URL_WS_DATA_EMPLOYEE_SAF');
        $response = Curl::to($url_ws)
                        ->withData( $request  )
                        ->asJson()
                        ->post();

		$llavesJson = array_keys((array)$response->data);
        if ( is_null($response) ) {
            return response()->json( ['error' => 'No se puede obtener los datos del empleado por el momento. Intente más tarde.'] );
        }
        if ( $response->data == "Datos Erroneos" ) {
            return response()->json( ['error' => 'No existen datos del empleado.'] );
        }

        foreach ($camposRequeridos as $campoRequerido) {

            if(array_search($relacionCampos[$campoRequerido],$llavesJson) != false){
//                 dump("entras");
                $respuesta[$campoRequerido] = $response->data->{ $relacionCampos[$campoRequerido] };
            }
        }

        return response()->json( $respuesta );
    }


    /**
     * Método usado para consumir el servicio de llenar la información de plazas
     */
    public function getDatosPlaza(Request $request) {
        $plaza_id = $request->input('plaza_id');

        $plaza =DB::select('SELECT plaz.plaza_id,plaz.numero_plaza,plaz.nivel_salarial_id,plaz.situacion_plaza_id,
                                   plaz.denominacion_puesto, nivel_salarial, situacion_plaza,
                                   universos.nombre_universo, plaz.codigo_puesto
                FROM plazas plaz
                left join niveles_salariales nivsal on plaz.nivel_salarial_id = nivsal.nivel_salarial_id
                left join situacion_plazas siplaz on plaz.situacion_plaza_id = siplaz.situacion_plaza_id
                left join universos universos on universos.universo_id = plaz.universo_id
                WHERE plaza_id = ?',[$plaza_id]);

        if ( !is_null($plaza) ) {
            return response()->json( $plaza );
        }

        $camposRequeridos = $request->campos_requeridos;
        $relacionCampos = [
            'numero_empleado' => 'NUMEMPLEADO',
            'plaza_id' => 'NUM_PLAZA',
            'sector' => 'SECT_PRES',
            'universo' => 'UNIVERSO',
            'nivel_salarial' => 'NIVEL_SALARIAL',
            'nombre_puesto' => 'COD_PUESTO_CVE_ACT',
            'descripcion_puesto' => 'PUESTO'
        ];
        $respuesta = array();

        $request = [
            "security" => [
                "token" => env('TOKEN_WS_DATA_EMPLOYEE_SAF')
            ],
            "data" => [
                "NUM_PLAZA" => strval($plaza_id)
                ]
            ];

        $url_ws = env('URL_WS_DATA_EMPLOYEE_SAF');
        $response = Curl::to($url_ws)
                        ->withData( $request  )
                        ->asJson()
                        ->post();

        if ( is_null( $response ) ) {
            return response()->json( ['error' => 'No se puede obtener los datos del empleado por el momento. Intente más tarde.'] );
        }
        if ( $response->data == "Datos Erroneos" ) {
            return response()->json( ['error' => 'No existen datos del empleado.'] );
        }

        foreach ($camposRequeridos as $campoRequerido) {
            $respuesta[$campoRequerido] = $response->data->{ $relacionCampos[$campoRequerido] };
        }

        return response()->json( $respuesta );
    }


    /**
     * Método que obtiene todas las plazas de una unidad administrativa
     */
    public function getPlazasUnidadAdm(Request $request) {
        $unidadAdministrativa = $request->input('identificador_unidad');

        $plazas = DB::select('SELECT plaz.plaza_id, plaz.numero_plaza, plaz.nivel_salarial_id, plaz.situacion_plaza_id,
                                   plaz.denominacion_puesto, nivel_salarial, situacion_plaza,
                                   universos.nombre_universo, plaz.codigo_puesto
                              FROM plazas plaz
                              left join niveles_salariales nivsal on plaz.nivel_salarial_id = nivsal.nivel_salarial_id
                              left join situacion_plazas siplaz on plaz.situacion_plaza_id = siplaz.situacion_plaza_id
                              left join universos universos on universos.universo_id = plaz.universo_id
                              WHERE unidad_administrativa_id = ?', [$unidadAdministrativa]);

        if ( !is_null($plazas) ) {
            return response()->json($plazas);
        }

        $camposRequeridos = $request->campos_requeridos;
        $relacionCampos = [
            'numero_empleado' => 'NUMEMPLEADO',
            'plaza_id' => 'NUM_PLAZA',
            'sector' => 'SECT_PRES',
            'universo' => 'UNIVERSO',
            'nivel_salarial' => 'NIVEL_SALARIAL',
            'nombre_puesto' => 'COD_PUESTO_CVE_ACT',
            'descripcion_puesto' => 'PUESTO'
        ];
        $respuesta = array();

        $request = [
            "security" => [
                "token" => env('TOKEN_WS_DATA_EMPLOYEE_SAF')
            ],
            "data" => [
                "UNIDAD_ADM" => strval($unidadAdministrativa)
            ]
        ];

        $url_ws = env('URL_WS_DATA_EMPLOYEE_SAF');
        $response = Curl::to($url_ws)
                        ->withData( $request  )
                        ->asJson()
                        ->post();

        if ( is_null( $response ) ) {
            return response()->json( ['error' => 'No se puede obtener las plazas por el momento. Intente más tarde.'] );
        }
        if ( $response->data == "Datos Erroneos" ) {
            return response()->json( ['error' => 'No existen plazas de la unidad administrativa.'] );
        }

        foreach ($camposRequeridos as $campoRequerido) {
            $respuesta[$campoRequerido] = $response->data->{ $relacionCampos[$campoRequerido] };
        }

        return response()->json( $respuesta );
    }


    /**
     * Función para hacer login al servicio de Capital Humano.
     * Este devuelve un SessionId
     */
    public function iniciarSesionCapitalHumano($email, $password){

        $url = '10.1.181.116:9000/i4ch/login';

        $request = [
            "security" => [
                "token" => "A4ZFTQy8RZ-cDMx_2*!8.M5o5sIvxWp"
            ],
            "data" => [
                'mail' => $email,
                'password' => $password
            ]
        ];

        $response = Curl::to($url)
                        ->withData( $request  )
                        ->asJson()
                        ->post();


        if ( is_null( $response ) ) {
            return response()->json( ['error' => 'No se puede acceder por el momento. Intente más tarde.'] );
        }
        if ( $response->data == null ) {
            return response()->json( ['error' => 'Usuario y/o contraseña son incorrectos.'] );
        }

        return response()->json( $response );
    }


    /**
     * Funcion para obtener los datos CFDI
     */
    public function obtenerCFDI($sesionId, $curp, $anio, $rfc) {

        $url = '10.1.181.116:9005/recibo/obtieneCFDIs';

        $request = [
            "security" => [
                "token" => "A4ZFTQy8RZ-cDMx_2*!8.M5o5sIvxWp",
                "sessionId" => $sesionId
            ],
            "data" => [
                "CURP" => $curp,
                "anio" => $anio,
                "RFC" => $rfc
            ]
        ];

        $response = Curl::to($url)
                        ->withData( $request  )
                        ->asJson()
                        ->post();

        if ( is_null( $response ) ) {
            return response()->json( ['error' => 'No se puede acceder por el momento. Intente más tarde.'] );
        }
        return response()->json( $response );

    }


    /**
     * Función para consultar los datos de los recibos
     */
    public function consultarRecibo($uuid, $anio) {
        $url = '10.1.181.4:9007/timbre/consultarecibo';

        $request = [
            "security" => [
                "token" => "grmldg8eo5brr885ainqt72icq"
            ],
            "data" => [
                "Anio" => $anio,
                "UUID" => $uuid
            ]
        ];

        $response = Curl::to($url)
                        ->withData( $request  )
                        ->asJson()
                        ->post();

        if ( is_null( $response ) ) {
            return response()->json( ['error' => 'No se puede acceder por el momento. Intente más tarde.'] );
        }
        if ( $response->data == null ) {
            return response()->json( ['error' => 'Los datos enviados son incorrectos.'] );
        }

       $xmlZamu = '<?xml version="1.0" encoding="UTF-8"?>'.
'    <cfdi:Comprobante xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:ventavehiculos="http://www.sat.gob.mx/ventavehiculos" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:catCFDI="http://www.sat.gob.mx/sitio_internet/cfd/catalogos" xmlns:tdCFDI="http://www.sat.gob.mx/sitio_internet/cfd/tipoDatos/tdCFDI" xmlns:vehiculousado="http://www.sat.gob.mx/vehiculousado" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http://www.sat.gob.mx/ventavehiculos http://www.sat.gob.mx/sitio_internet/cfd/ventavehiculos/ventavehiculos11.xsd http://www.sat.gob.mx/vehiculousado http://www.sat.gob.mx/sitio_internet/cfd/vehiculousado/vehiculousado.xsd" Version="3.3" Serie="KMA" Folio="7634" Fecha="2019-07-31T17:27:03" Sello="atR0aiSMpoQB2XW9GPMQDHJPnqEgW0LmAF6K2J4yUhAlPWCGVq0Sv22IIlUPFyIL183f2air31sukccZnGoMz9haPcouSGzCMoUwlGBUvnssZThk++WJWePdQq+NjrjzVTRh61b99f1YIgqYr565HoFZdjllBFUz1CllPx+3cfMPhQcNTISwV2t9kc9arqYkNEi8uOoyWNpLb48CvA/lW2fss7FnyvSPSmTqfgDCFyXx66PZHS4ZbivNjo5TWD4kBsUqZHT25+ttAJu/lodTtrnMENhrMiiyu2mNYkGvnWbcpe9lNRem4q6YtD+3XPejzkb9VAVnOO+4dNPJzyFttA==" FormaPago="99" NoCertificado="00001000000413030227" Certificado="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" CondicionesDePago="." SubTotal="580086.21" Moneda="MXN" TipoCambio="1" Total="672900.00" TipoDeComprobante="I" MetodoPago="PPD" LugarExpedicion="15730">'.
'      <cfdi:CfdiRelacionados TipoRelacion="04">'.
'        <cfdi:CfdiRelacionado UUID="4b932e86-2a21-476e-a2f3-fb9989151db9" />'.
'      </cfdi:CfdiRelacionados>'.
'      <cfdi:Emisor Rfc="KMO141215B19" Nombre="KURE MOTORS SA DE CV" RegimenFiscal="601" />'.
'      <cfdi:Receptor Rfc="SAKA7209206Y8" Nombre="ABRAHAM MOISES SAFDIE KANAN" UsoCFDI="G03" />'.
'      <cfdi:Conceptos>'.
'        <cfdi:Concepto ClaveProdServ="25101500" Cantidad="1.00" ClaveUnidad="H87" Unidad="PIEZA" Descripcion="Kia - SEDONA PE 3.3L EX PACK A/T - 7P - PANTHERA METAL - 2019 - SEDONA PE 3.3L EX PACK A/T - 7P - KNDMC5C28K6556950 SERIE KNDMC5C28K6556950" ValorUnitario="580086.21000" Importe="580086.21">'.
'          <cfdi:Impuestos>'.
'            <cfdi:Traslados>'.
'              <cfdi:Traslado Base="580086.21" Impuesto="002" TipoFactor="Tasa" TasaOCuota="0.160000" Importe="92813.79" />'.
'            </cfdi:Traslados>'.
'          </cfdi:Impuestos>'.
'          <cfdi:ComplementoConcepto>'.
'            <ventavehiculos:VentaVehiculos version="1.1" ClaveVehicular="0751503" Niv="KNDMC5C28K6556950">'.
'              <ventavehiculos:InformacionAduanera numero="[195116699000326]" fecha="2019-04-16" aduana="LAZARO CARDENAS MICH." />'.
'            </ventavehiculos:VentaVehiculos>'.
'          </cfdi:ComplementoConcepto>'.
'        </cfdi:Concepto>'.
'      </cfdi:Conceptos>'.
'      <cfdi:Impuestos TotalImpuestosTrasladados="92813.79">'.
'        <cfdi:Traslados>'.
'          <cfdi:Traslado Impuesto="002" TipoFactor="Tasa" TasaOCuota="0.160000" Importe="92813.79" />'.
'        </cfdi:Traslados>'.
'      </cfdi:Impuestos>'.
'      <cfdi:Complemento>'.
'        <vehiculousado:VehiculoUsado Version="1.0" montoAdquisicion="381900.00" montoEnajenacion="175000.00" claveVehicular="0520815" marca="TOYOTA" tipo="RAV 4 XLE  A/T" modelo="2013" numeroMotor="2AR-M386728" numeroSerie="2T3WF4EV4DW022556" NIV="2T3WF4EV4DW022556" valor="175000.00">'.
'          <vehiculousado:InformacionAduanera numero="13243770303998" fecha="2013-05-08" aduana="NUEVO LAREDO" />'.
'        </vehiculousado:VehiculoUsado>'.
'      <tfd:TimbreFiscalDigital xmlns:tfd="http://www.sat.gob.mx/TimbreFiscalDigital" xsi:schemaLocation="http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd" FechaTimbrado="2019-07-31T17:27:14" RfcProvCertif="EDI101020E99" UUID="2c71642e-1538-45a8-959c-01cf36363e75" NoCertificadoSAT="00001000000405428713" SelloCFD="atR0aiSMpoQB2XW9GPMQDHJPnqEgW0LmAF6K2J4yUhAlPWCGVq0Sv22IIlUPFyIL183f2air31sukccZnGoMz9haPcouSGzCMoUwlGBUvnssZThk++WJWePdQq+NjrjzVTRh61b99f1YIgqYr565HoFZdjllBFUz1CllPx+3cfMPhQcNTISwV2t9kc9arqYkNEi8uOoyWNpLb48CvA/lW2fss7FnyvSPSmTqfgDCFyXx66PZHS4ZbivNjo5TWD4kBsUqZHT25+ttAJu/lodTtrnMENhrMiiyu2mNYkGvnWbcpe9lNRem4q6YtD+3XPejzkb9VAVnOO+4dNPJzyFttA==" SelloSAT="ho3GRGDR9vjd5IFU/F5umaV3rUiGAijvcjIX0a8Twkd4Ri5mf6gTEjRRiMq22o5rXbZdkHsytj6ZF/y7w60I/2bnkBEdaw/LeIbs7T8DGIA5o/ujjYIiVW3yPKnQM3F2VMfrV0LYNFU5xvdDKD2lFIT5Un/8Oq0wNA2nC+lXZGgg7w0n+sQFu3wUkZ1EDLm/BcFqIByYb5FY/UlnloPzX+Z6JtpWt6DtzPNoS+SzTZ40BoqTzpACUe2OvsXqDIEc07M/CoC9ygRBs+lxhybOs+eiJBkZRFVFYxqzKfsbll3PyKFAlVcOWQsGjw3EQaQTtuIGAC8iuQUZQqFzMhxGKA==" Version="1.1" /></cfdi:Complemento></cfdi:Comprobante>';

        $xmlZamu = $this->removeColonsFromRSS($xmlZamu);

        return response()->json( simplexml_load_string($xmlZamu) );




        // $xml = $this->removeColonsFromRSS($response->data);
        // return response()->json( simplexml_load_string($xml) );


        // $xml1= simplexml_load_string($xml);
        // $xmlrespuetas = $xml1->cfdi_Emisor->attributes();
        // //dd($x);
        // foreach ($xmlrespuetas as $value) {
        //     # code...
        //     dump((string)$value);
        // }
        // dd($xml1->attributes()['Certificado']);
    }


    /**
     * Función para obtener toda la información del servidor a travez de los servicios.
     * iniciarSesionCapitalHumano()
     * obtenerCFDI()
     * El CFDI (Comprobante Fiscal Digital por Internet) en México es un documento XML que cumple con la especificación proporcionada por el SAT (Servicio de Administración Tributaria)
     * consultarRecibo()
     */
    public function consultarRecibosAnio() {
        $correo = 'procdga@procdga.mx'; // $email;
        $contrasena =  'cadb136430a939253924bc5ad0d3af2b'; // $password;

        $dataLogin = $this->iniciarSesionCapitalHumano($correo, $contrasena);

        $sessionId = $dataLogin->getData()->data->sessionId;

        $curp = 'RAJJ850122HMCMLS08';
        $rfc = 'RAJJ850122DD5';
        $anio = '2019';

        $arregloDeRecibos = $this->obtenerCFDI($sessionId, $curp, $anio, $rfc);

        $anio = $arregloDeRecibos->getData()->data->Comprobantes->anio;
        $comprobantes = $arregloDeRecibos->getData()->data->Comprobantes->CFDI;

        foreach ($comprobantes as $key => $comprobante) {
            $xmlRecibo = $this->consultarRecibo($comprobante->UUID, $anio);
            // dd($xmlRecibo->getData());
             $xmlConceptosZamu = json_decode( json_encode( $xmlRecibo->getData() ), true )['cfdi_Conceptos'];

            $xmlZambuRespuesta =  $this->recursiveArray($xmlConceptosZamu);
            dd($xmlConceptosZamu, $this->arrayZambu);
            }

    }


    /**
     * Funcion para quitar los : y colocarle _
     */
    function removeColonsFromRSS($xml) {
        $xml = preg_replace('~(</?|\s)([a-z0-9_]+):~is', '$1$2_', $xml);
        return $xml;
    }


    /**Función Zamu */
    var $arrayZambu = array();
    private function recursiveArray($array){

        foreach ($array as $key => $value) {
            if ( $key == '@attributes' ) {
                $this->arrayZambu = array_merge($value, $this->arrayZambu);

            } else {
                $this->recursiveArray( $value );
            }
        }
    }


}
