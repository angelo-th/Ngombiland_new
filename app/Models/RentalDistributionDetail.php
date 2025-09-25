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
        'shares_owned',
        'percentage_ownership',
        'amount_distributed',
        'status',
    ];

    protected $casts = [
        'shares_owned' => 'integer',
        'percentage_ownership' => 'decimal:4',
        'amount_distributed' => 'decimal:2',
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

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}