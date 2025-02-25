<?php

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

function fecha($fecha)
{

    $fecha = Carbon::parse($fecha)->setTimezone('Europe/Madrid');

    return $fecha->format('d-m-Y H:i');
}


function mes($fecha)
{
    $fecha = Carbon::parse($fecha)->setTimezone('Europe/Madrid');

    return $fecha->isoFormat('MMMM');
}

function anyo($fecha)
{

    $fecha = Carbon::parse($fecha)->setTimezone('Europe/Madrid');

    return $fecha->isoFormat('YYYY');
}

function esFuturo($fecha)
{
    return Carbon::parse($fecha)->isFuture();
}

function esPasado($fecha)
{
    return Carbon::parse($fecha)->isPast();
}

function diferenciaFechas($fecha1, $fecha2)
{
    return Carbon::parse($fecha1)->diffInDays(Carbon::parse($fecha2));
}

function comprobarUserLogeado($user)
{
    if (Auth::check()) {
        return ($user->name == Auth::user()->name);
    }
}

function numeroRandom() {
    return rand(0, 9999999);
}


// $producto = DB::table('productos')->where('id', 1)->first();

//DB::table('productos')->insert([
//    'nombre' => 'Producto 1',
//    'precio' => 100,
//    'stock' => 10
//]);

//DB::table('productos')->where('id', 1)->update(['precio' => 150]);

//DB::table('productos')->where('id', 1)->delete();

//$productos = DB::table('productos')
//    ->where('precio', '>', 50)
//    ->where('stock', '>', 0)
//    ->get();

//$productos = DB::table('productos')
//    ->join('categorias', 'productos.categoria_id', '=', 'categorias.id')
//    ->select('productos.nombre', 'productos.precio', 'categorias.nombre as categoria')
//    ->get();
