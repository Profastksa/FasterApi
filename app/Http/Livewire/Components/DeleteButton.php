<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;


class DeleteButton extends Component
{
    public Model $model;
    protected $listeners = ['delete' => 'delete'];

    public function delete($model_id)
    {
        try {
            // dd($this->model->where('id', 213));
            $deleted = $this->model->find($model_id);#->delete();
            $deletedBol = $deleted->delete();
        //   dd($deletedBol);
            // dd($deletedBol);
            $this->emit('deleted', true);
            // session()->flash('success', __('translation.item.deleted.successfully'));
        } catch (\Throwable $th) {
            $this->emit('deleted', false);
            // session()->flash('error', __('translation.delete.exception'));
        }
    }

    public function render()
    {
        return view('livewire.components.delete-button');
    }
}
