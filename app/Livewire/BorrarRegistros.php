<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class BorrarRegistros extends Component
{
    public $ordenadorId;

    public function mount($ordenadorId)
    {
        $this->ordenadorId = $ordenadorId;
    }

    public function borrar()
    {
        DB::table('cambios')
            ->where('ordenador_id', $this->ordenadorId)
            ->delete();
    }

    public function render()
    {
        return view('livewire.borrar-registros');
    }
}
