<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'amount',
        'roi',
        'status',
        'investment_date',
    ];

    protected $casts = [
        'investment_date' => 'datetime',
        'amount' => 'decimal:2',
        'roi' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
