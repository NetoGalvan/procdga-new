<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\LogLocal;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $logs = LogLocal::all();
        return view("administrador.logs.index", compact("logs"));
    }

    public function getLogs(Request $request) {
        $logs = LogLocal::orderBy("log_id", "DESC")
            ->paginate($request->pageSize);
        return $logs;        
    }
}
