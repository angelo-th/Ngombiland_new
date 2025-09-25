<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PropertyWizard extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 4;

    // Étape 1: Informations de base
    public $title;
    public $description;
    public $type;
    public $price;
    public $location;
    public $latitude;
    public $longitude;

    // Étape 2: Images
    public $images = [];
    public $temporaryImages = [];

    // Étape 3: Crowdfunding
    public $is_crowdfundable = false;
    public $expected_roi;
    public $total_amount;
    public $total_shares;
    public $price_per_share;
    public $funding_deadline;

    // Étape 4: Documents
    public $documents = [];
    public $temporaryDocuments = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|min:50',
        'type' => 'required|in:villa,apartment,house,land,commercial',
        'price' => 'required|numeric|min:100000',
        'location' => 'required|string|max:255',
        'latitude' => 'required|numeric|between:-90,90',
        'longitude' => 'required|numeric|between:-180,180',
        'is_crowdfundable' => 'boolean',
        'expected_roi' => 'required_if:is_crowdfundable,true|numeric|min:5|max:50',
        'total_amount' => 'required_if:is_crowdfundable,true|numeric|min:1000000',
        'total_shares' => 'required_if:is_crowdfundable,true|integer|min:10|max:10000',
        'funding_deadline' => 'required_if:is_crowdfundable,true|date|after:today',
    ];

    public function mount()
    {
        $this->type = 'house';
        $this->is_crowdfundable = false;
        $this->expected_roi = 12;
        $this->funding_deadline = now()->addDays(30)->format('Y-m-d');
    }

    public function nextStep()
    {
        $this->validateCurrentStep();
        $this->currentStep++;
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function validateCurrentStep()
    {
        switch ($this->currentStep) {
            case 1:
                $this->validate([
                    'title' => 'required|string|max:255',
                    'description' => 'required|string|min:50',
                    'type' => 'required|in:villa,apartment,house,land,commercial',
                    'price' => 'required|numeric|min:100000',
                    'location' => 'required|string|max:255',
                    'latitude' => 'required|numeric|between:-90,90',
                    'longitude' => 'required|numeric|between:-180,180',
                ]);
                break;
            case 2:
                $this->validate([
                    'images' => 'required|array|min:1|max:10',
                    'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
                ]);
                break;
            case 3:
                if ($this->is_crowdfundable) {
                    $this->validate([
                        'expected_roi' => 'required|numeric|min:5|max:50',
                        'total_amount' => 'required|numeric|min:1000000',
                        'total_shares' => 'required|integer|min:10|max:10000',
                        'funding_deadline' => 'required|date|after:today',
                    ]);
                }
                break;
        }
    }

    public function updatedIsCrowdfundable()
    {
        if ($this->is_crowdfundable) {
            $this->total_amount = $this->price;
            $this->total_shares = 100;
            $this->price_per_share = $this->total_amount / $this->total_shares;
        }
    }

    public function updatedTotalAmount()
    {
        if ($this->total_shares > 0) {
            $this->price_per_share = (float)$this->total_amount / (int)$this->total_shares;
        }
    }

    public function updatedTotalShares()
    {
        if ($this->total_amount > 0) {
            $this->price_per_share = (float)$this->total_amount / (int)$this->total_shares;
        }
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function removeDocument($index)
    {
        unset($this->documents[$index]);
        $this->documents = array_values($this->documents);
    }

    public function save()
    {
        $this->validate();

        // Sauvegarder les images
        $savedImages = [];
        foreach ($this->images as $image) {
            $path = $image->store('properties', 'public');
            $savedImages[] = $path;
        }

        // Sauvegarder les documents
        $savedDocuments = [];
        foreach ($this->documents as $document) {
            $path = $document->store('documents', 'public');
            $savedDocuments[] = $path;
        }

        // Créer la propriété
        $property = Property::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'price' => $this->price,
            'location' => $this->location,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'status' => 'pending',
            'images' => $savedImages,
            'is_crowdfundable' => $this->is_crowdfundable,
            'expected_roi' => $this->is_crowdfundable ? $this->expected_roi : null,
        ]);

        // Créer le projet de crowdfunding si nécessaire
        if ($this->is_crowdfundable) {
            $property->crowdfundingProjects()->create([
                'user_id' => auth()->id(),
                'title' => $this->title . ' - Projet de Crowdfunding',
                'description' => $this->description,
                'total_amount' => $this->total_amount,
                'amount_raised' => 0,
                'total_shares' => $this->total_shares,
                'shares_sold' => 0,
                'price_per_share' => $this->price_per_share,
                'expected_roi' => $this->expected_roi,
                'funding_deadline' => $this->funding_deadline,
                'status' => 'draft',
                'images' => $savedImages,
                'documents' => $savedDocuments,
            ]);
        }

        session()->flash('success', 'Propriété créée avec succès !');
        return $this->redirect('/properties');
    }

    public function render()
    {
        return view('livewire.property-wizard');
    }
}
