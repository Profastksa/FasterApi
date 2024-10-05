<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Area;
use App\Models\SubArea;
use Livewire\WithPagination;

class ShowSubArea extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $name, $area_id, $sub_area_id, $area;
    public $updateMode = false;


    public function mount($areaid)
    {
        $this->area = Area::find($areaid);
        $this->area_id = $areaid;
    }

    private function resetInputFields()
    {
        $this->name = '';
    }

    public function store()
    {
        $validatedData = $this->validate([
            'name' => 'required|string',
        ]);

        $validatedData['area_id'] = $this->area_id;

        SubArea::create($validatedData);

        session()->flash('success', __('translation.item.created.successfully'));

        $this->resetPage();

        $this->resetInputFields();

        $this->emit('areaStore'); // Close model to using to jquery
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $sub_area = SubArea::where('id', $id)->first();
        $this->sub_area_id = $id;
        $this->name = $sub_area->name;
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function update()
    {
        $validatedDate = $this->validate([
            'name' => 'required|string',
        ]);

        if ($this->sub_area_id) {

            $sub_area = SubArea::find($this->sub_area_id);
            $sub_area->update([
                'name' => $this->name,
            ]);
            $this->updateMode = false;
            session()->flash('success', __('translation.item.updated.successfully'));
            $this->emit('areaUpdate'); // Close model to using to jquery
            $this->resetInputFields();
        }
    }

    public function delete($id)
    {
        if ($id) {
            SubArea::where('id', $id)->delete();
            session()->flash('success', __('translation.item.deleted.successfully'));
        }
    }


    public function render()
    {
        $sub_areas = SubArea::where('area_id',  $this->area_id)->orderBy('id', 'DESC')->paginate(10);

        return view('livewire.sub_areas.show-sub-area', [
            'data' => $sub_areas,
            'area' => $this->area,
        ]);
    }
}
