<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'lineas', 'ticket_id', 'producto_id')->withPivot('cantidad');
    }
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;
    use SoftDeletes;
}
