<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrowdfundingInvestment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'crowdfunding_project_id',
        'shares_purchased',
        'amount_invested',
        'price_per_share',
        'status',
        'confirmed_at',
    ];

    protected $casts = [
        'amount_invested' => 'decimal:2',
        'price_per_share' => 'decimal:2',
        'confirmed_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function crowdfundingProject()
    {
        return $this->belongsTo(CrowdfundingProject::class);
    }

    // Scopes
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
