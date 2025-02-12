<?php

namespace App\Livewire;

use App\Models\Attedance;
use Livewire\Component;

class Map extends Component
{
    public function render()
    {
        $attendances = Attedance::with('user')->get();
        return view('livewire.map', ['attendances' => $attendances]);
    }
}
