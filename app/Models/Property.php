<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'price', 'location', 'latitude', 'longitude', 'status', 'type', 'images'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'images' => 'array',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    // Accessor pour s'assurer que owner n'est jamais null
    public function getOwnerAttribute()
    {
        return $this->owner() ?? new User(['name' => 'Propriétaire inconnu', 'email' => 'N/A']);
    }
}