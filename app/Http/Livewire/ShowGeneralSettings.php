<?php

namespace App\Http\Livewire;

use App\Models\OrderRange;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowGeneralSettings extends Component
{

    public $form_data = [], $representative_deserves_calculation_method, $representative_percentage, $order_return_price, $exceeding_order_ranges_bounce;
    public $tax;

    public function mount()
    {
        $data = OrderRange::get(['from', 'to', 'price'])->toArray();
        $this->tax =  Setting::where('key', 'tax_precntage')->first();
        // dd($this->tax);

        // dd($data);
        foreach ($data as $key => $range) {
            $this->form_data[$key]['from'] = $range['from'];
            $this->form_data[$key]['to'] = $range['to'];
            $this->form_data[$key]['price'] = $range['price'];
        }

        $this->representative_deserves_calculation_method = Setting::where('key', 'representative_deserves_calculation_method')->first();
        $this->representative_percentage = Setting::where('key', 'representative_percentage')->first();
        $this->order_return_price = Setting::where('key', 'order_return_price')->first()->value;
        $this->exceeding_order_ranges_bounce = Setting::where('key', 'exceeding_order_ranges_bounce')->first();
    }

    public function orderReturnPriceSave()
    {
        try {
            Setting::where('key', 'order_return_price')->update(['value' => $this->order_return_price]);
            session()->flash('success', __('translation.item.created.successfully'));
        } catch (\Throwable $th) {
            session()->flash('error', __('translation.range.error'));
        }
    }
    public function exceedingOrderRangesBounce()
    {
        try {
            Setting::where('key', 'exceeding_order_ranges_bounce')->update(['value' => $this->exceeding_order_ranges_bounce]);
            session()->flash('success', __('translation.item.created.successfully'));
        } catch (\Throwable $th) {
            session()->flash('error', __('translation.range.error'));
        }
    }
    public function representativePercentageSave()
    {
        try {
            Setting::where('key', 'representative_percentage')->update(['value' => $this->representative_percentage]);
            session()->flash('success', __('translation.item.created.successfully'));
        } catch (\Throwable $th) {
            session()->flash('error', __('translation.range.error'));
        }
    }

    public function submitRanges()
    {
        // $from = null;
        $to = null;
        $is_invalid = false;
        foreach ($this->form_data as $key => $range) {
            $this->validate([
                "form_data.$key.*" => "required|numeric"
            ]);
            if ($key == 0) {
                $to = $range['to'];
            } else {
                if ($range['from'] - $to != 1) {
                    $is_invalid = true;
                }
                $to = $range['to'];
            }
        }
        if ($is_invalid) {
            session()->flash('error', __('translation.range.error'));
        }
        // dd($this->form_data);

        try {
            DB::transaction(function () {
                DB::table('order_ranges')->delete();
                OrderRange::insert($this->form_data);
                session()->flash('success', __('translation.item.created.successfully'));
            });
        } catch (\Throwable $th) {
            throw $th;
            session()->flash('error', __('translation.error.exception'));
        }
    }

    public function deleteRange($key)
    {
        array_splice($this->form_data, $key, 1);
    }
    public function addRange()
    {

        array_push($this->form_data, ['from' => null, 'to' => null, 'price' => null]);
    }
    public function updateTaxValue()
    {
        $this->validate([
            'tax' => 'required|numeric|max:100',
        ]);
        try {
            $tax = Setting::where('key', 'tax_precntage')->first();
            $tax->value =  $this->tax;
            $tax->save();
            session()->flash('success', __('translation.tax_value_update'));
            $this->emit('Success');
        } catch (\Throwable $th) {
            // dd($th);
            session()->flash('error', __('translation.update_error'));
            $this->emit('ErrorException');
        }
    }
    public function render()
    {
        return view('livewire.show-general-settings', [
            'ranges' => $this->form_data,
        ]);
    }
}