<?php

namespace App\Http\Livewire;

use App\Models\PropertyReport;
use Livewire\Component;
use Livewire\WithFileUploads;

class AgentReport extends Component
{
    use WithFileUploads;

    public $property_name;

    public $report_desc;

    public $photos = [];

    public $lat;

    public $lng;

    public function submitReport()
    {
        $this->validate([
            'property_name' => 'required|string|max:255',
            'report_desc' => 'required|string',
            'photos.*' => 'image|max:1024',
        ]);

        $report = PropertyReport::create([
            'property_name' => $this->property_name,
            'report_desc' => $this->report_desc,
            'lat' => $this->lat,
            'lng' => $this->lng,
        ]);

        foreach ($this->photos as $photo) {
            $report->addMedia($photo->getRealPath())->toMediaCollection('photos');
        }

        $this->reset(['property_name', 'report_desc', 'photos']);
        session()->flash('success', 'Rapport soumis avec succès !');
    }

    public function setLocation($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function render()
    {
        return view('livewire.agent-report');
    }
}
