<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCambiosRequest;
use App\Http\Requests\StoreOrdenadorRequest;
use App\Http\Requests\UpdateOrdenadorRequest;
use App\Models\Aula;
use App\Models\Ordenador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $consulta = Ordenador::query();
        $columnas = ['marca', 'modelo'];

        $ordenar = $request->input('ordenar', session('ordenar', 'marca'));
        $sentido = $request->input('sentido', session('sentido', 'asc'));

        if (!in_array($ordenar, $columnas)) {
            $ordenar = 'marca'; // Establecer el valor por defecto si no es válido
        }

        session(['ordenar' => $ordenar, 'sentido' => $sentido]);

        $busqueda = $request->input('busqueda', session('busqueda', ''));
        session(['busqueda' => $busqueda ?: session()->forget('busqueda')]);

        // Filtrar la búsqueda
        if ($busqueda) {
            $consulta->where('marca', 'ilike', "%{$busqueda}%")
                     ->orWhere('modelo', 'ilike', "%{$busqueda}%");
        }

        // Obtener los ordenadores paginados
        $ordenadores = $consulta->orderBy($ordenar, $sentido)->paginate(9);

        return view('ordenadores.index', compact('ordenadores', 'busqueda'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aulas = Aula::all();
        return view('ordenadores.create', ['aulas' => $aulas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrdenadorRequest $request)
    {
        $ordenador = new Ordenador();
        $ordenador->fill($request->validated());
        $ordenador->save();
        session()->flash('exito', 'Los cambios se guardaron correctamente.');
        return redirect()->route('ordenadores.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ordenador $ordenador)
    {

        $cambios = DB::table('cambios')->where('ordenador_id', $ordenador->id)->get();
        $aulas = Aula::all();

        return view('ordenadores.show', ['ordenador' => $ordenador, 'aulas' => $aulas, 'cambios' => $cambios]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ordenador $ordenador)
    {
        $aulas = Aula::all();
        return view('ordenadores.edit', ['aulas' => $aulas, 'ordenador' => $ordenador]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrdenadorRequest $request, Ordenador $ordenador)
    {
        $ordenador->update($request->validated());

        return redirect()->route('ordenadores.show', $ordenador);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ordenador $ordenador)
    {
        $ordenador->delete();
        return redirect()->route('ordenadores.index');
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
