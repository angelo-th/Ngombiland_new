<?php

namespace App\Livewire;

use App\Models\CrowdfundingProject;
use App\Models\Property;
use Livewire\Component;

class CreateCrowdfundingProject extends Component
{
    public Property $property;
    public $title;
    public $description;
    public $total_amount;
    public $total_shares;
    public $price_per_share;
    public $funding_deadline;
    public $expected_roi;
    public $management_fee;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'total_amount' => 'required|numeric|min:0',
        'total_shares' => 'required|integer|min:1',
        'price_per_share' => 'required|numeric|min:0',
        'funding_deadline' => 'required|date',
        'expected_roi' => 'required|numeric|min:0|max:100',
        'management_fee' => 'required|numeric|min:0|max:100',
    ];

    public function mount(Property $property)
    {
        $this->property = $property;
    }

    public function save()
    {
        $this->validate();

        $crowdfundingProject = CrowdfundingProject::create([
            'user_id' => auth()->id(),
            'property_id' => $this->property->id,
            'title' => $this->title,
            'description' => $this->description,
            'total_amount' => $this->total_amount,
            'amount_raised' => 0,
            'total_shares' => $this->total_shares,
            'shares_sold' => 0,
            'price_per_share' => $this->price_per_share,
            'expected_roi' => $this->expected_roi,
            'funding_deadline' => $this->funding_deadline,
            'status' => 'active',
            'management_fee' => $this->management_fee,
        ]);

        session()->flash('message', 'Crowdfunding project created successfully.');

        return redirect()->to('/properties/' . $this->property->id);
    }

    public function render()
    {
        return view('livewire.create-crowdfunding-project');
    }
}
