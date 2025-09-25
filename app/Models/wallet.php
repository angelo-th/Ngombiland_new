<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'currency',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Méthodes
    public function credit($amount, $description = null)
    {
        $this->balance += $amount;
        $this->save();

        if ($description) {
            $this->transactions()->create([
                'user_id' => $this->user_id,
                'type' => 'deposit',
                'amount' => $amount,
                'description' => $description,
                'status' => 'completed',
            ]);
        }

        return $this;
    }

    public function debit($amount, $description = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception('Solde insuffisant');
        }

        $this->balance -= $amount;
        $this->save();

        if ($description) {
            $this->transactions()->create([
                'user_id' => $this->user_id,
                'type' => 'withdrawal',
                'amount' => $amount,
                'description' => $description,
                'status' => 'completed',
            ]);
        }

        return $this;
    }

    public function canAfford($amount)
    {
        return $this->balance >= $amount;
    }
}