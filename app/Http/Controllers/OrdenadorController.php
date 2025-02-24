<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCambiosRequest;
use App\Http\Requests\StoreOrdenadorRequest;
use App\Http\Requests\UpdateOrdenadorRequest;
use App\Models\Aula;
use App\Models\Ordenador;
use Illuminate\Support\Facades\DB;

class OrdenadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ordenadores = Ordenador::all();

        return view('ordenadores.index', ['ordenadores' => $ordenadores]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ordenadores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrdenadorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ordenador $ordenador)
    {
        if (!$ordenador) {
            abort(404);
        }

        $cambios = DB::table('cambios')
            ->where('ordenador_id', $ordenador->id)
            ->get();

        $aulas = Aula::all();

        return view('ordenadores.show', ['ordenador' => $ordenador, 'aulas' => $aulas, 'cambios' => $cambios]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ordenador $ordenador)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrdenadorRequest $request, Ordenador $ordenador)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ordenador $ordenador)
    {
        //
    }

    public function cambiar(StoreCambiosRequest $request, Ordenador $ordenador)
    {

        $origen_id = $ordenador->aula->id;

        if($request->destino_id == $origen_id){
            abort(403, 'Sin cambios');
        } else {

        DB::table('cambios')->insert([
            'ordenador_id' => $ordenador->id,
            'origen_id' => $origen_id,
            'destino_id' => $request->destino_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
        $ordenador->aula_id = $request->destino_id;
        $ordenador->save();

        return redirect()->route('ordenadores.show', $ordenador);
    }


}
