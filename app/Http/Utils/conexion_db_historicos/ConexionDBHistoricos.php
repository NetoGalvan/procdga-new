<?php

namespace App\Http\Utils\conexion_db_historicos;

use Exception;
use Illuminate\Support\Facades\DB;

class ConexionDBHistoricos {

    protected $connectionIsSuccess;
    protected $messageError;

    public function __construct($connectionName)
    {
        try {
            DB::connection($connectionName)->getPdo();
            $this->connectionIsSuccess = true;
        } catch (Exception $e) {
            $this->connectionIsSuccess = false;
            $this->messageError = $e->getMessage();
        }
    }

    public function connectionIsSuccess()
    {
        return $this->connectionIsSuccess;
    }
   
    public function getMessageError()
    {
        return $this->messageError;
    }
}
