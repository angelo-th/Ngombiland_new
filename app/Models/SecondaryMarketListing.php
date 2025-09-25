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
        'price_per_share' => 'decimal:2',
        'total_price' => 'decimal:2',
        'expires_at' => 'datetime',
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

    public function offers()
    {
        return $this->hasMany(SecondaryMarketOffer::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSold($query)
    {
        return $query->where('status', 'sold');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    // Accesseurs
    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at < now();
    }

    public function getRemainingSharesAttribute()
    {
        return $this->shares_for_sale - $this->offers()->where('status', 'accepted')->sum('shares_requested');
    }
}