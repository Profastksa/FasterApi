<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Area;
use App\Models\AreaPriceHistory;
use App\Models\AreaServices;
use App\Models\Service;
use Livewire\WithPagination;

class ShowArea extends Component
{
    use WithPagination;
    protected $listeners = ['deleted' => 'deleted'];

    protected $paginationTheme = 'bootstrap';
    public $name, $fees, $area_id,$AreaServices=[];
    public $area_prices = [];
    public $updateMode = false;
    public $AssginArea;


    protected $rules = [
        'area.name' => 'required|string',
        'area.fees' => 'required|numeric',
    ];

    public function deleted($status)
    {
        if ($status) {
            session()->flash('success', __('translation.item.deleted.successfully'));
            $this->render();
        } else {
            session()->flash('success', __('translation.delete.exception'));
        }
    }


    private function resetInputFields()
    {
        $this->name = '';
        $this->fees = 0;
    }

    public function store()
    {
        $validatedData = $this->validate([
            'name' => 'required|string',
          //  'fees' => 'required|numeric',
        ]);

        Area::create($validatedData);

        session()->flash('success', __('translation.item.created.successfully'));

        $this->resetPage();

        $this->resetInputFields();

        $this->emit('areaStore'); // Close model to using to jquery
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $area = Area::where('id', $id)->first();
        $this->area_id = $id;

       $this->AreaServices= AreaServices::where('area_id', $id)->get()->keyBy('service_id')->toArray();
    //    dd($this->AreaServices);

    // $this->AssginArea = Area::with('ServiceModel')->where('id', $this->area_id)->first();
    // dd($this->AssginArea);
        $this->name = $area->name;
        $this->fees =
            (int) filter_var($area->fees, FILTER_SANITIZE_NUMBER_INT);

    }

    public function showPriceHistory($id)
    {
        $this->area_prices = AreaPriceHistory::where('area_id', $id)->orderBy('id', 'DESC')->get();
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
          //  'fees' => 'required|numeric',
        ]);

        if ($this->area_id) {
            $area = Area::find($this->area_id);
/*
            //CASTED AREA FEES
            $casted_fees = (int) filter_var($area->fees, FILTER_SANITIZE_NUMBER_INT);


            if ($casted_fees !=  $validatedDate['fees']) {
                try {
                    //insert area price histories table
                    $area_price_history_data = [
                        'area_id' => $this->area_id,
                        'price' => $casted_fees,
                        'from' => $area->updated_at,
                        'to' => date('Y-m-d H:i:s'),
                    ];
                    AreaPriceHistory::create($area_price_history_data);
                    //end insert area price histories table

                    //update areas table
                    $area->update([
                        'name' => $this->name,
                       // 'fees' => $this->fees,
                    ]);
                    //end update areas table
                } catch (\Throwable $th) {
                    session()->flash('error', __('translation.error.exception'));
                    // session()->flash('error', $th);
                }
            } else */{
                //update areas table
                $area->update([
                    'name' => $this->name,
                    //'fees' => $this->fees,
                ]);
                //end update areas table
            }



            $this->updateMode = false;
            session()->flash('success', __('translation.item.updated.successfully'));
            $this->emit('areaUpdate'); // Close model to using to jquery
            $this->resetInputFields();
        }
    }

    // public function delete($id)
    // {
    //     if ($id) {
    //         try {
    //             $deleted = Area::where('id', $id)->delete();
    //             session()->flash('success', __('translation.item.deleted.successfully'));
    //         } catch (\Throwable $th) {
    //             session()->flash('error', __('translation.delete.exception'));
    //         }
    //     }
    // }

    public function render()
    {
        return view('livewire.areas.show-area', [
            'data' => Area::orderBy('id', 'DESC')->paginate(1000),
            'services' => Service::get(),
        ]);
    }
}
