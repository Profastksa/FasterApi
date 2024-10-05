<?php

namespace App\Http\Livewire\Components;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use App\Models\Area;
use App\Models\Representative;
use App\Models\RepresentativeArea;
use App\Models\SubArea;

class RepresentativeAreas extends Component
{
    public $representativeId;
    public $selectedAreas;

    private function resetInputFields()
    {
        $this->selectedAreas = '';
    }

    protected $rules = [
        'selectedAreas' => 'required|array'
    ];

    public function mount()
    {
        $this->selectedAreas = Representative::find($this->representativeId)->subareas->pluck('id', 'id')->toArray();
    }
    public function addAreas()
    {
        // $this->validate([
        //     'area_id' => 'required',
        // ]);
        // dd($this->selectedAreas);
        $representative_exists = RepresentativeArea::where('representative_id', $this->representativeId)->count();
        if ($representative_exists > 0) {
            RepresentativeArea::where('representative_id', $this->representativeId)->delete();
        }
        // dd($this->representativeId);
        foreach ($this->selectedAreas as $selectedAreaId) {
            if ($selectedAreaId != false)
                RepresentativeArea::create(['representative_id' => $this->representativeId, 'subarea_id' => $selectedAreaId]);
        }
        $this->resetInputFields();
        $this->selectedAreas = Representative::find($this->representativeId)->subareas->pluck('id', 'id')->toArray();
        $this->emit('representative_areas_saved');

        // dd($this->selectedAreas);
        // $this->render();
    }
    // public function updatedArea($value)
    // {
    //     // dd($value);
    //     if ($value) {
    //         RepresentativeArea::create(['representative_id' => $this->representativeId, 'area_id' => $value]);
    //         $this->resetInputFields();
    //     } else {
    //         RepresentativeArea::where(['representative_id' => $this->representativeId, 'area_id' => $value])->delete();
    //         $this->resetInputFields();
    //     }
    // }
    public function render()
    {   $AllArea =  Area::with('subAreas')->orderBy('id', 'desc')->get();
        // dd($AllArea);
        return view('livewire.components.representative-areas', [
            'AllAreas' => $AllArea,
        ]);
    }
}
