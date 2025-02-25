<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddRequest;
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
        // Definir las columnas válidas para ordenar
        $columnasValidas = ['nombre', 'precio'];
        $consulta = Producto::query();

        // Obtener el valor de 'ordenar' de la solicitud o de la sesión, con validación
        $ordenar = $request->input('ordenar', session('ordenar', 'nombre'));
        $sentido = $request->input('sentido', session('sentido', 'asc'));

        // Si el campo 'ordenar' no es válido, asignar el valor por defecto 'nombre'
        if (!in_array($ordenar, $columnasValidas)) {
            $ordenar = 'nombre';
        }

        // Guardar el criterio de ordenación en la sesión
        session(['ordenar' => $ordenar, 'sentido' => $sentido]);

        // Obtener el valor de búsqueda de la solicitud o de la sesión
        $busqueda = $request->input('busqueda', session('busqueda', ''));
        session(['busqueda' => $busqueda ?: session()->forget('busqueda')]);

        // Aplicar el filtro de búsqueda si hay alguno
        if ($busqueda) {
            $consulta->where('nombre', 'ilike', "%{$busqueda}%")
                     ->orWhere('precio', 'ilike', "%{$busqueda}%");
        }

        // Ejecutar la consulta con el orden y la paginación
        $productos = $consulta->orderBy($ordenar, $sentido)->paginate(9);

        // Retornar la vista con los productos y la búsqueda
        return view('productos.index', ['productos' => $productos, 'busqueda' => $busqueda]);
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
