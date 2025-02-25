<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Producto;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $consulta = Producto::query();

        if ($busqueda = $request->input('busqueda')) {
            $consulta->where('nombre', 'ilike', "%{$busqueda}%");
        }

        if ($precioMin = $request->input('precio_min')) {
            $consulta->where('precio', '>=', $precioMin);
        }

        if ($precioMax = $request->input('precio_max')) {
            $consulta->where('precio', '<=', $precioMax);
        }

        $orden = $request->input('orden', 'nombre_asc');
        $criterios = [
            'nombre_asc' => ['nombre', 'asc'],
            'nombre_desc' => ['nombre', 'desc'],
            'precio_asc' => ['precio', 'asc'],
            'precio_desc' => ['precio', 'desc'],
        ];

        $consulta->orderBy(...($criterios[$orden] ?? $criterios['nombre_asc']));

        $productos = $consulta->paginate(5);

        return view('productos.index', compact('productos'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request)
    {
        $producto = new Producto();
        $producto->fill($request->validated());

        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName(); // Nombre único
            $archivo->move(public_path(), $nombreArchivo); // Guarda directamente en "public/"
            $producto->imagen = $nombreArchivo; // Guarda solo el nombre del archivo
        }

        $producto->save();

        session()->flash('exito', 'Los cambios se guardaron correctamente.');
        return redirect()->route('productos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        return view('productos.show', ['producto' => $producto]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        return view('productos.edit', ['producto' => $producto]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoRequest $request, Producto $producto)
    {

        $producto->update($request->validated());
        session()->flash('exito', 'Los cambios se guardaron correctamente.');

        return redirect()->route('productos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index');
    }

        /**
     * Añade un producto al carrito
     */

     public function add($id)
    {

        $producto = Producto::find($id);
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad']++;
        } else {
            $carrito[$id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1
            ];
        }

        session()->put('carrito', $carrito);
        session()->flash('exito', 'Producto añadido al carrito.');

        return redirect()->route('productos.index');

    }

         /**
     * Resta un producto
     */

     public function resta($id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            if ($carrito[$id]['cantidad'] > 1) {
                $carrito[$id]['cantidad']--;
            } else {
                unset($carrito[$id]);
            }
            session()->put('carrito', $carrito);
        }

        session()->flash('exito', 'Producto eliminado del carrito.');

        return redirect()->route('productos.index');
    }

         /**
     * Crea una factura, enlaza los productos del carrito, los asigna a la factura y vacia el carrito
     */

    public function pagar()
    {
        $ticket = new Ticket();
        $ticket->tarjeta = '3589239';
        $ticket->save();

        foreach (session('carrito') as $objeto)
        {
            $ticket->productos()->attach($objeto['id'], ['cantidad' => $objeto['cantidad']]);
        }
        $ticket->save();
        $this->vaciar();

        return view('productos.factura', ['ticket' => $ticket]);

    }
         /**
     * Vacia el carrito
     */

    public function vaciar()
    {
        session()->forget('carrito');
        return redirect()->route('carrito');
    }
}
