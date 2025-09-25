<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryMarketOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'secondary_market_listing_id',
        'shares_requested',
        'offer_price_per_share',
        'total_offer_amount',
        'status',
        'message',
        'accepted_at',
        'rejected_at',
    ];

    protected $casts = [
        'shares_requested' => 'integer',
        'offer_price_per_share' => 'decimal:2',
        'total_offer_amount' => 'decimal:2',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function secondaryMarketListing()
    {
        return $this->belongsTo(SecondaryMarketListing::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Accesseurs
    public function getIsPendingAttribute()
    {
        return $this->status === 'pending';
    }

    public function getIsAcceptedAttribute()
    {
        return $this->status === 'accepted';
    }

    public function getIsRejectedAttribute()
    {
        return $this->status === 'rejected';
    }
}
