<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'crowdfunding_project_id',
        'total_rental_amount',
        'investor_share_amount',
        'platform_share_amount',
        'distribution_date',
        'status',
        'reference',
    ];

    protected $casts = [
        'total_rental_amount' => 'decimal:2',
        'investor_share_amount' => 'decimal:2',
        'platform_share_amount' => 'decimal:2',
        'distribution_date' => 'date',
    ];

    // Relations
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function crowdfundingProject()
    {
        return $this->belongsTo(CrowdfundingProject::class);
    }

    public function distributions()
    {
        return $this->hasMany(RentalDistributionDetail::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
