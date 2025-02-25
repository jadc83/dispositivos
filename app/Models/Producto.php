<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;
    use SoftDeletes;

    public $fillable = ['nombre', 'precio'];

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, 'lineas', 'producto_id', 'ticket_id');
    }
}
