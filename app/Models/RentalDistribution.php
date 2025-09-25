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
        'total_rent_amount',
        'distributed_amount',
        'distribution_date',
    ];

    protected $casts = [
        'total_rent_amount' => 'decimal:2',
        'distributed_amount' => 'decimal:2',
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

}
