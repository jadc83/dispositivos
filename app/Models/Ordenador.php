<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordenador extends Model
{
    /** @use HasFactory<\Database\Factories\OrdenadorFactory> */
    use HasFactory;
    protected $table = 'ordenadores';
    protected $fillable = ['nombre', 'marca', 'modelo', 'precio'];

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function dispositivos()
    {
        return $this->morphMany(Dispositivo::class, 'colocable');
    }

    public function cambiosAulas()
    {
        return $this->belongsToMany(Aula::class, 'cambios', 'ordenador_id', 'aula_id');
    }
}
