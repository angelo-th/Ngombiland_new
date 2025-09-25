<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalDistributionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_distribution_id',
        'user_id',
        'investment_id',
        'shares_owned',
        'amount_received',
    ];

    protected $casts = [
        'shares_owned' => 'integer',
        'amount_received' => 'decimal:2',
    ];

    // Relations
    public function rentalDistribution()
    {
        return $this->belongsTo(RentalDistribution::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function investment()
    {
        return $this->belongsTo(\App\Models\CrowdfundingInvestment::class);
    }

}
