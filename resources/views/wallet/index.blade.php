@extends('layouts.app')

@section('title', 'Mon Portefeuille')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mon Portefeuille</h1>
            <p class="mt-2 text-gray-600">Gérez votre solde et vos transactions</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Solde actuel -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Solde Actuel</h2>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-green-600 mb-2">
                            {{ number_format($balance, 0, '.', ',') }} FCFA
                        </div>
                        <p class="text-gray-600">Disponible</p>
                    </div>
                    
                    <div class="mt-6 space-y-3">
                        <a href="{{ route('wallet.topup.form') }}" 
                           class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-plus mr-2"></i>
                            Recharger
                        </a>
                        <a href="{{ route('wallet.withdraw.form') }}" 
                           class="w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-minus mr-2"></i>
                            Retirer
                        </a>
                    </div>
                </div>
            </div>

            <!-- Historique des transactions -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Historique des Transactions</h2>
                    
                    @if($transactions->count() > 0)
                        <div class="space-y-4">
                            @foreach($transactions as $transaction)
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center
                                            {{ $transaction->type === 'topup' ? 'bg-green-100 text-green-600' : 
                                               ($transaction->type === 'withdraw' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600') }}">
                                            @if($transaction->type === 'topup')
                                                <i class="fas fa-plus"></i>
                                            @elseif($transaction->type === 'withdraw')
                                                <i class="fas fa-minus"></i>
                                            @else
                                                <i class="fas fa-exchange-alt"></i>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <p class="font-medium text-gray-900">
                                                {{ ucfirst($transaction->type) }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $transaction->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold 
                                            {{ $transaction->type === 'topup' ? 'text-green-600' : 
                                               ($transaction->type === 'withdraw' ? 'text-red-600' : 'text-blue-600') }}">
                                            {{ $transaction->type === 'topup' ? '+' : '-' }}{{ number_format($transaction->amount, 0, '.', ',') }} FCFA
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ ucfirst($transaction->status) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-wallet text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">Aucune transaction pour le moment</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
