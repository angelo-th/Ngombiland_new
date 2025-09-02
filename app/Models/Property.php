<?php
// app/Models/Property.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'price', 'location', 'latitude', 'longitude', 'status'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
// app/Models/Property.php