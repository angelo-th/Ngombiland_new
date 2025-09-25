<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'amount',
        'shares',
        'status',
        'return_rate',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'return_rate' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
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

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Accesseurs
    public function getExpectedReturnAttribute()
    {
        return $this->amount * ($this->return_rate / 100);
    }

    public function getTotalReturnAttribute()
    {
        return $this->amount + $this->expected_return;
    }
}