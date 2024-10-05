<?php

namespace App\Http\Livewire\Components;

use App\Models\Area;
use App\Models\Client;
use App\Models\Representative;
use Livewire\Component;

class NotifcationForm extends Component
{
    public $To , $ToSpicficUser , $Disabled = true;
    public function updatedTo($val){
        // dd($val);
        $this->To = $val;
    }
    public function updatedToSpicficUser($value){
        // dd($value);
        $this->Disabled = !$value;
        // dd($this->Disabled);
    }

    public function render()
    {
        if($this->To)  $Users  = $this->To == 1 ? Client::get() : Representative::get() ;
        else $Users = Client::get();
        // dd($Users);
        return view('livewire.components.notifcation-form',
        [
            'Area' => Area::get(),
            'Users' => $Users,
        ]
    );
    }
}
