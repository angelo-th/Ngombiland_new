<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'crowdfunding_project_id',
        'total_rental_income',
        'management_fee_percentage',
        'management_fee_amount',
        'net_rental_income',
        'distribution_date',
        'status',
    ];

    protected $casts = [
        'total_rental_income' => 'decimal:2',
        'management_fee_percentage' => 'decimal:2',
        'management_fee_amount' => 'decimal:2',
        'net_rental_income' => 'decimal:2',
        'distribution_date' => 'date',
    ];

    // Relations
    public function crowdfundingProject()
    {
        return $this->belongsTo(CrowdfundingProject::class);
    }

    public function distributionDetails()
    {
        return $this->hasMany(RentalDistributionDetail::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Accesseurs
    public function getTotalDistributedAttribute()
    {
        return $this->distributionDetails()->sum('amount_distributed');
    }

    public function getRemainingAmountAttribute()
    {
        return $this->net_rental_income - $this->total_distributed;
    }
}