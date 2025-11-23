<?php

namespace App\Http\Controllers\p02_tramites_issste\catalogos;

use App\Http\Controllers\Controller;
use App\Models\p24_directorio\NivelSalarial;
use Illuminate\Http\Request;

class NivelSalarialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nivelesSalariales = NivelSalarial::activo()->orderBy('nivel_salarial_id', 'desc')->paginate(20);
        return view("p02_tramites_issste.catalogos.nivel_salarial.index", compact("nivelesSalariales"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("p02_tramites_issste.catalogos.nivel_salarial.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nivelSalarial = NivelSalarial::create($request->all());

        return redirect()
            ->route("niveles-salariales.edit", $nivelSalarial)
            ->with("success", "Se creo correctamente el nivel salarial");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(NivelSalarial $nivelSalarial)
    {
        return view("p02_tramites_issste.catalogos.nivel_salarial.edit", compact("nivelSalarial"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NivelSalarial $nivelSalarial)
    {
        $nivelSalarial = $nivelSalarial->update($request->all());

        return redirect()
            ->back()
            ->with("success", "Se actualizó correctamente el nivel salarial");
    }
}
