@extends('layouts.app')

@section('title', $crowdfunding->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête du projet -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $crowdfunding->title }}</h1>
                <p class="text-gray-600 mt-2">{{ $crowdfunding->property->location }}</p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    {{ $crowdfunding->status === 'active' ? 'bg-green-100 text-green-800' : 
                       ($crowdfunding->status === 'funded' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                    {{ $crowdfunding->status === 'active' ? 'Actif' : 
                       ($crowdfunding->status === 'funded' ? 'Financé' : 'Terminé') }}
                </span>
            </div>
        </div>

        <!-- Images du projet -->
        @if($crowdfunding->images && count($crowdfunding->images) > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            @foreach($crowdfunding->images as $image)
            <img src="{{ asset('storage/' . $image) }}" 
                 alt="{{ $crowdfunding->title }}" 
                 class="w-full h-48 object-cover rounded-lg">
            @endforeach
        </div>
        @endif

        <!-- Description -->
        <div class="prose max-w-none">
            <p class="text-gray-700 leading-relaxed">{{ $crowdfunding->description }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contenu principal -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Progression du financement -->
            @livewire('crowdfunding-progress', ['project' => $crowdfunding])

            <!-- Détails du projet -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Détails du Projet
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Montant Total</p>
                            <p class="text-xl font-bold text-gray-900">{{ number_format($crowdfunding->total_amount, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Prix par Part</p>
                            <p class="text-xl font-bold text-gray-900">{{ number_format($crowdfunding->price_per_share, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">ROI Attendu</p>
                            <p class="text-xl font-bold text-green-600">{{ $crowdfunding->expected_roi }}% par an</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Parts Total</p>
                            <p class="text-xl font-bold text-gray-900">{{ number_format($crowdfunding->total_shares) }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Parts Vendues</p>
                            <p class="text-xl font-bold text-gray-900">{{ number_format($crowdfunding->shares_sold) }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Date Limite</p>
                            <p class="text-xl font-bold text-gray-900">{{ $crowdfunding->funding_deadline->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Investisseurs récents -->
            @livewire('recent-investors', ['project' => $crowdfunding])
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Formulaire d'investissement -->
            @if($crowdfunding->status === 'active' && $crowdfunding->remaining_shares > 0)
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-coins mr-2 text-primary-600"></i>
                    Investir dans ce Projet
                </h3>
                
                <form action="{{ route('crowdfunding.invest', $crowdfunding) }}" method="POST" x-data="investmentForm()">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="shares" class="form-label">Nombre de parts</label>
                            <input type="number" id="shares" name="shares" x-model="shares" 
                                   :max="{{ $crowdfunding->remaining_shares }}" min="1" 
                                   class="form-input" required>
                            <p class="text-sm text-gray-500 mt-1">Maximum: {{ $crowdfunding->remaining_shares }} parts</p>
                        </div>
                        
                        <div>
                            <label class="form-label">Montant total</label>
                            <div class="form-input bg-gray-50 text-center font-semibold" x-text="formatPrice(totalAmount)"></div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-full">
                            <i class="fas fa-coins mr-2"></i>
                            Investir maintenant
                        </button>
                    </div>
                </form>
            </div>
            @elseif($crowdfunding->status === 'funded')
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="text-center">
                    <i class="fas fa-trophy text-6xl text-green-500 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Projet Financé !</h3>
                    <p class="text-gray-600">Ce projet a atteint son objectif de financement.</p>
                </div>
            </div>
            @endif

            <!-- Informations du propriétaire -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-user mr-2 text-gray-600"></i>
                    Propriétaire
                </h3>
                
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-primary-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $crowdfunding->user->name }}</p>
                        <p class="text-sm text-gray-600">Propriétaire</p>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-bolt mr-2 text-yellow-600"></i>
                    Actions Rapides
                </h3>
                
                <div class="space-y-3">
                    <a href="{{ route('secondary-market.index') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-exchange-alt text-blue-600 mr-3"></i>
                        <span class="font-medium">Marketplace Secondaire</span>
                    </a>
                    
                    <a href="{{ route('rental-distribution.user-history') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-chart-line text-green-600 mr-3"></i>
                        <span class="font-medium">Mes Revenus</span>
                    </a>
                    
                    <a href="{{ route('payments.index') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-wallet text-purple-600 mr-3"></i>
                        <span class="font-medium">Mon Portefeuille</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function investmentForm() {
    return {
        shares: 1,
        
        get totalAmount() {
            return this.shares * {{ $crowdfunding->price_per_share }};
        },
        
        formatPrice(amount) {
            return new Intl.NumberFormat('fr-FR').format(amount || 0) + ' FCFA';
        }
    }
}
</script>
@endpush
@endsection