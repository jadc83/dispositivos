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

function generarNumeroAleatorio() {
    return rand(0, 9999999);
}
