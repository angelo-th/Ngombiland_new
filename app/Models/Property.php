<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'price', 'location', 'latitude', 'longitude', 'status', 'type', 'images', 'is_crowdfundable', 'expected_roi',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'images' => 'array',
        'is_crowdfundable' => 'boolean',
        'expected_roi' => 'decimal:2',
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

    public function crowdfundingProjects()
    {
        return $this->hasMany(CrowdfundingProject::class);
    }

}
