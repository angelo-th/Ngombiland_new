<?php

namespace App\Http\Livewire;

use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WalletTopup extends Component
{
    public $amount;

    public function topup()
    {
        $this->validate(['amount' => 'required|numeric|min:100']);

        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()]);
        $wallet->balance += $this->amount;
        $wallet->save();

        session()->flash('success', 'Portefeuille rechargé !');
        $this->amount = '';
    }

    public function render()
    {
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()]);

        return view('livewire.wallet-topup', compact('wallet'));
    }
}
