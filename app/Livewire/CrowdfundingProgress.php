<?php

namespace App\Livewire;

use App\Models\CrowdfundingProject;
use Livewire\Component;

class CrowdfundingProgress extends Component
{
    public $project;
    public $progressPercentage;
    public $amountRaised;
    public $totalAmount;
    public $sharesSold;
    public $totalShares;
    public $daysRemaining;
    public $investorsCount;

    public function mount(CrowdfundingProject $project)
    {
        $this->project = $project;
        $this->updateProgress();
    }

    public function updateProgress()
    {
        $this->amountRaised = $this->project->amount_raised;
        $this->totalAmount = $this->project->total_amount;
        $this->sharesSold = $this->project->shares_sold;
        $this->totalShares = $this->project->total_shares;
        $this->progressPercentage = $this->project->progress_percentage;
        $this->daysRemaining = max(0, now()->diffInDays($this->project->funding_deadline, false));
        $this->investorsCount = $this->project->investments()->confirmed()->count();
    }

    public function render()
    {
        return view('livewire.crowdfunding-progress');
    }
}
