@extends('layouts.app')

@section('title', $crowdfunding->title . ' - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $crowdfunding->title }}</h1>
                    <p class="text-gray-600">{{ $crowdfunding->property->location }}</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('crowdfunding.index') }}" class="text-gray-600 hover:text-gray-800">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour
                    </a>
                    @if(auth()->id() === $crowdfunding->user_id)
                        <a href="{{ route('crowdfunding.edit', $crowdfunding) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-edit mr-2"></i>
                            Modifier
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contenu principal -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Images du projet -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    @if($crowdfunding->images && count($crowdfunding->images) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 p-4">
                            @foreach($crowdfunding->images as $index => $image)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $crowdfunding->title }}" 
                                         class="w-full h-48 object-cover rounded-lg">
                                    @if($index === 0)
                                        <div class="absolute top-2 left-2 bg-blue-600 text-white px-2 py-1 rounded text-sm font-medium">
                                            Photo principale
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-home text-6xl text-gray-400"></i>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Description du Projet</h2>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 leading-relaxed">{{ $crowdfunding->description }}</p>
                    </div>
                </div>

                <!-- Informations sur la propriété -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations sur la Propriété</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-medium text-gray-900 mb-2">Type de propriété</h3>
                            <p class="text-gray-600 capitalize">{{ $crowdfunding->property->type }}</p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 mb-2">Localisation</h3>
                            <p class="text-gray-600">{{ $crowdfunding->property->location }}</p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 mb-2">Prix de la propriété</h3>
                            <p class="text-gray-600">{{ number_format($crowdfunding->property->price) }} FCFA</p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 mb-2">Propriétaire</h3>
                            <p class="text-gray-600">{{ $crowdfunding->user->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Risques et avantages -->
                @if($crowdfunding->risks || $crowdfunding->benefits)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Analyse du Projet</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($crowdfunding->risks)
                        <div>
                            <h3 class="font-medium text-red-900 mb-2">Risques</h3>
                            <p class="text-gray-700">{{ $crowdfunding->risks }}</p>
                        </div>
                        @endif
                        @if($crowdfunding->benefits)
                        <div>
                            <h3 class="font-medium text-green-900 mb-2">Avantages</h3>
                            <p class="text-gray-700">{{ $crowdfunding->benefits }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Investisseurs -->
                @if($crowdfunding->investments->count() > 0)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Investisseurs ({{ $stats['total_investors'] }})</h2>
                    <div class="space-y-4">
                        @foreach($crowdfunding->investments->take(5) as $investment)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-semibold text-sm">
                                        {{ substr($investment->user->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $investment->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $investment->shares_purchased }} parts</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">{{ number_format($investment->amount_invested) }} FCFA</p>
                                <p class="text-sm text-gray-600">{{ $investment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                        @if($crowdfunding->investments->count() > 5)
                        <p class="text-center text-gray-600 text-sm">
                            Et {{ $crowdfunding->investments->count() - 5 }} autres investisseurs...
                        </p>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Statut et progression -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="text-center mb-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($crowdfunding->status === 'active') bg-green-100 text-green-800
                            @elseif($crowdfunding->status === 'funded') bg-blue-100 text-blue-800
                            @elseif($crowdfunding->status === 'expired') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            @if($crowdfunding->status === 'active') Actif
                            @elseif($crowdfunding->status === 'funded') Financé
                            @elseif($crowdfunding->status === 'expired') Expiré
                            @else {{ ucfirst($crowdfunding->status) }}
                            @endif
                        </span>
                    </div>

                    <!-- Progression -->
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Progression</span>
                            <span>{{ round($crowdfunding->progress_percentage) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" 
                                 style="width: {{ $crowdfunding->progress_percentage }}%"></div>
                        </div>
                    </div>

                    <!-- Statistiques -->
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Montant levé</span>
                            <span class="font-semibold">{{ number_format($crowdfunding->amount_raised) }} FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Montant total</span>
                            <span class="font-semibold">{{ number_format($crowdfunding->total_amount) }} FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Parts vendues</span>
                            <span class="font-semibold">{{ $crowdfunding->shares_sold }} / {{ $crowdfunding->total_shares }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Prix par part</span>
                            <span class="font-semibold">{{ number_format($crowdfunding->price_per_share) }} FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">ROI attendu</span>
                            <span class="font-semibold text-green-600">{{ $crowdfunding->expected_roi }}%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Investisseurs</span>
                            <span class="font-semibold">{{ $stats['total_investors'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Investissement moyen</span>
                            <span class="font-semibold">{{ number_format($stats['average_investment']) }} FCFA</span>
                        </div>
                    </div>

                    <!-- Temps restant -->
                    @if($crowdfunding->status === 'active')
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-blue-600 mr-2"></i>
                            <span class="text-blue-800 font-medium">
                                @if($stats['days_remaining'] > 0)
                                    {{ $stats['days_remaining'] }} jours restants
                                @else
                                    Expire bientôt
                                @endif
                            </span>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Formulaire d'investissement -->
                @if($crowdfunding->status === 'active' && $crowdfunding->remaining_shares > 0)
                <div class="bg-white rounded-lg shadow-lg p-6" id="invest">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Investir dans ce projet</h3>
                    
                    <form method="POST" action="{{ route('crowdfunding.invest', $crowdfunding) }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="shares" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombre de parts (max: {{ $crowdfunding->remaining_shares }})
                                </label>
                                <input type="number" id="shares" name="shares" min="1" max="{{ $crowdfunding->remaining_shares }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       onchange="updateInvestmentAmount()">
                                @error('shares')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Montant total:</span>
                                    <span class="font-semibold" id="total-amount">0 FCFA</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                <i class="fas fa-coins mr-2"></i>
                                Investir maintenant
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Actions du propriétaire -->
                @if(auth()->id() === $crowdfunding->user_id)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions du Propriétaire</h3>
                    <div class="space-y-3">
                        @if($crowdfunding->status === 'draft')
                            <form method="POST" action="{{ route('crowdfunding.activate', $crowdfunding) }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-play mr-2"></i>
                                    Activer le projet
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('crowdfunding.edit', $crowdfunding) }}" 
                           class="w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors text-center block">
                            <i class="fas fa-edit mr-2"></i>
                            Modifier le projet
                        </a>
                        
                        <form method="POST" action="{{ route('crowdfunding.destroy', $crowdfunding) }}" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                                <i class="fas fa-trash mr-2"></i>
                                Supprimer le projet
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function updateInvestmentAmount() {
    const shares = document.getElementById('shares').value;
    const pricePerShare = {{ $crowdfunding->price_per_share }};
    const totalAmount = shares * pricePerShare;
    
    document.getElementById('total-amount').textContent = new Intl.NumberFormat('fr-FR').format(totalAmount) + ' FCFA';
}
</script>
@endsection