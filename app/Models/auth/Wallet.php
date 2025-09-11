<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'balance',
        'frozen_amount',
        'currency',
        'last_transaction_at',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'frozen_amount' => 'decimal:2',
        'last_transaction_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }
}
