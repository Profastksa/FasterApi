<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceNote;



class NotesModal extends Component
{
    public Model $model;
    public $note;
    protected $listeners = ['deleted' => 'render'];

    private function resetInputFields()
    {
        $this->note = '';
    }
    public function addNote()
    {
        $this->validate([
            'note' => 'required',
        ]);
        ServiceNote::create(['body' => $this->note, 'service_id' => $this->model->id]);
        $this->resetInputFields();
    }
    public function render()
    {
        return view('livewire.components.notes-modal', [
            'notes' => ServiceNote::where('service_id', $this->model->id)->orderBy('id', 'DESC')->get(),
        ]);
    }
}
