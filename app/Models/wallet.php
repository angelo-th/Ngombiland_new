<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'currency',
        'status',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Deduct commission from wallet
     */
    public function deductCommission($amount)
    {
        $commission = $amount * 0.01; // 1% commission
        $this->balance -= $commission;
        $this->save();

        // Create transaction record
        Transaction::create([
            'user_id' => $this->user_id,
            'type' => 'commission',
            'amount' => $commission,
            'status' => 'completed',
            'reference' => \Illuminate\Support\Str::uuid(),
        ]);

        return $commission;
    }
}
