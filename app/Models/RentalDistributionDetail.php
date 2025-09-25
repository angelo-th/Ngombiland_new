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
        'percentage_owned',
        'rental_amount',
        'status',
        'distributed_at',
    ];

    protected $casts = [
        'shares_owned' => 'integer',
        'percentage_owned' => 'decimal:4',
        'rental_amount' => 'decimal:2',
        'distributed_at' => 'datetime',
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
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
