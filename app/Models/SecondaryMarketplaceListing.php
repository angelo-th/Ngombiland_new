<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryMarketplaceListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'crowdfunding_investment_id',
        'seller_id',
        'shares_on_sale',
        'price_per_share',
        'status',
    ];

    public function investment()
    {
        return $this->belongsTo(CrowdfundingInvestment::class, 'crowdfunding_investment_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
