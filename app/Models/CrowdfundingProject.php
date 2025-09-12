<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrowdfundingProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'title',
        'description',
        'total_amount',
        'amount_raised',
        'total_shares',
        'shares_sold',
        'price_per_share',
        'expected_roi',
        'funding_deadline',
        'status',
        'images',
        'documents',
        'risks',
        'benefits',
        'management_fee',
    ];

    protected $casts = [
        'images' => 'array',
        'documents' => 'array',
        'total_amount' => 'decimal:2',
        'amount_raised' => 'decimal:2',
        'price_per_share' => 'decimal:2',
        'expected_roi' => 'decimal:2',
        'management_fee' => 'decimal:2',
        'funding_deadline' => 'date',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function investments()
    {
        return $this->hasMany(CrowdfundingInvestment::class);
    }

    // Accesseurs
    public function getProgressPercentageAttribute()
    {
        return $this->total_amount > 0 ? ($this->amount_raised / $this->total_amount) * 100 : 0;
    }

    public function getRemainingSharesAttribute()
    {
        return $this->total_shares - $this->shares_sold;
    }

    public function getIsFullyFundedAttribute()
    {
        return $this->amount_raised >= $this->total_amount;
    }

    public function getIsExpiredAttribute()
    {
        return $this->funding_deadline < now();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFunded($query)
    {
        return $query->where('status', 'funded');
    }
}
