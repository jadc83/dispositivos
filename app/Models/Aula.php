<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    /** @use HasFactory<\Database\Factories\AulaFactory> */
    use HasFactory;

    public function ordenadores()
    {
        return $this->hasMany(Ordenador::class, 'ordenador_id');
    }

    public function dispositivos()
    {
        return $this->morphMany(Dispositivo::class, 'colocable');
    }

    public function cambiosOrdenadores()
    {
        return $this->belongsToMany(Ordenador::class, 'cambios', 'aula_id', 'ordenador_id');
    }
}
