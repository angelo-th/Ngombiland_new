<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;

class PropertySearch extends Component
{
    public $search = '';
    public $type = '';
    public $status = '';
    public $minPrice = '';
    public $maxPrice = '';
    public $city = '';
    public $sort = 'latest';
    
    public $showFilters = false;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'status' => ['except' => ''],
        'minPrice' => ['except' => ''],
        'maxPrice' => ['except' => ''],
        'city' => ['except' => ''],
        'sort' => ['except' => 'latest'],
    ];

    public function updated($property)
    {
        // Déclencher la recherche automatiquement quand les filtres changent
        if (in_array($property, ['search', 'type', 'status', 'minPrice', 'maxPrice', 'city', 'sort'])) {
            $this->dispatch('search-updated');
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->type = '';
        $this->status = '';
        $this->minPrice = '';
        $this->maxPrice = '';
        $this->city = '';
        $this->sort = 'latest';
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function render()
    {
        $query = Property::with('owner');

        // Appliquer les filtres
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%")
                  ->orWhere('location', 'like', "%{$this->search}%");
            });
        }

        if ($this->type) {
            $query->where('type', $this->type);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->minPrice) {
            $query->where('price', '>=', $this->minPrice);
        }

        if ($this->maxPrice) {
            $query->where('price', '<=', $this->maxPrice);
        }

        if ($this->city) {
            $query->where('location', 'like', "%{$this->city}%");
        }

        // Appliquer le tri
        switch ($this->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $properties = $query->paginate(12);

        return view('livewire.property-search', [
            'properties' => $properties,
            'propertyTypes' => ['villa', 'apartment', 'house', 'land', 'commercial'],
            'propertyStatuses' => ['pending', 'approved', 'rejected'],
            'cities' => ['Douala', 'Yaoundé', 'Bafoussam', 'Garoua', 'Maroua', 'Nkongsamba', 'Bertoua', 'Kumba'],
        ]);
    }
}