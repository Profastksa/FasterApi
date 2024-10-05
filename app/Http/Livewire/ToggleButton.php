<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Representative;
use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class ToggleButton extends Component
{
    public Model $model;
    public string $field;
    public bool $is_active;

    public function mount()
    {
        $this->is_active = (bool) $this->model->getAttribute($this->field);
    }
    public function render()
    {
        return view('livewire.components.toggle-button');
    }
    public function updating($field, $value)
    {
        $this->model->setAttribute($this->field, $value)->save();

        // remove token from representative
        if ($this->model instanceof Representative || $this->model instanceof Client) {
            $this->model->tokens()->delete();
        };
    }
}
