<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryMarketListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'crowdfunding_investment_id',
        'shares_for_sale',
        'price_per_share',
        'total_price',
        'status',
        'description',
        'expires_at',
        'sold_at',
    ];

    protected $casts = [
        'shares_for_sale' => 'integer',
        'price_per_share' => 'decimal:2',
        'total_price' => 'decimal:2',
        'expires_at' => 'datetime',
        'sold_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function crowdfundingInvestment()
    {
        return $this->belongsTo(CrowdfundingInvestment::class);
    }

    public function crowdfundingProject()
    {
        return $this->hasOneThrough(
            CrowdfundingProject::class,
            CrowdfundingInvestment::class,
            'id',
            'id',
            'crowdfunding_investment_id',
            'crowdfunding_project_id'
        );
    }

    public function offers()
    {
        return $this->hasMany(SecondaryMarketOffer::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('expires_at', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    public function scopeSold($query)
    {
        return $query->where('status', 'sold');
    }

    // Accesseurs
    public function getIsExpiredAttribute()
    {
        return $this->expires_at < now();
    }

    public function getDaysRemainingAttribute()
    {
        return max(0, now()->diffInDays($this->expires_at, false));
    }

    public function getOriginalPricePerShareAttribute()
    {
        return $this->crowdfundingInvestment->price_per_share;
    }

    public function getPriceDifferenceAttribute()
    {
        return $this->price_per_share - $this->original_price_per_share;
    }

    public function getPriceDifferencePercentageAttribute()
    {
        if ($this->original_price_per_share == 0) return 0;
        return (($this->price_per_share - $this->original_price_per_share) / $this->original_price_per_share) * 100;
    }
}
