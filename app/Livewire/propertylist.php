<?php

namespace App\Http\Livewire;

use App\Models\Property;
use Livewire\Component;

class PropertyList extends Component
{
    public $properties;

    public function mount()
    {
        $this->properties = Property::with('owner')->latest()->get();
    }

    public function render()
    {
        return view('livewire.property-list');
    }
}
