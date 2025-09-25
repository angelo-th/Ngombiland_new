<?php

namespace App\Livewire;

use App\Models\CrowdfundingProject;
use Livewire\Component;

class RecentInvestors extends Component
{
    public $project;
    public $recentInvestments;

    public function mount(CrowdfundingProject $project)
    {
        $this->project = $project;
        $this->loadRecentInvestments();
    }

    public function loadRecentInvestments()
    {
        $this->recentInvestments = $this->project->investments()
            ->confirmed()
            ->with('user')
            ->orderBy('confirmed_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.recent-investors');
    }
}
