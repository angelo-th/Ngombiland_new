@extends('layouts.app')

@section('title', $crowdfunding->title . ' - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $crowdfunding->title }}</h1>
                    <p class="mt-2 text-gray-600">{{ $crowdfunding->property->location ?? 'Localisation non définie' }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('crowdfunding.index') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour
                    </a>
                    @can('update', $crowdfunding)
                        <a href="{{ route('crowdfunding.edit', $crowdfunding) }}" class="btn btn-primary">
                            <i class="fas fa-edit mr-2"></i>
                            Modifier
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contenu principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Images -->
                @if($crowdfunding->images && count($crowdfunding->images) > 0)
                <div class="card">
                    <div class="card-body p-0">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($crowdfunding->images as $index => $image)
                            <div class="{{ $index === 0 ? 'md:col-span-2' : '' }}">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     alt="{{ $crowdfunding->title }}" 
                                     class="w-full h-48 {{ $index === 0 ? 'h-64' : '' }} object-cover rounded-lg">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Description -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Description du projet</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-gray-700 leading-relaxed">{{ $crowdfunding->description }}</p>
                    </div>
                </div>

                <!-- Avantages et risques -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($crowdfunding->benefits)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold text-green-700">
                                <i class="fas fa-check-circle mr-2"></i>
                                Avantages
                            </h3>
                        </div>
                        <div class="card-body">
                            <p class="text-gray-700">{{ $crowdfunding->benefits }}</p>
                        </div>
                    </div>
                    @endif

                    @if($crowdfunding->risks)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold text-red-700">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Risques
                            </h3>
                        </div>
                        <div class="card-body">
                            <p class="text-gray-700">{{ $crowdfunding->risks }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Informations sur la propriété -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Informations sur la propriété</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-600">Type:</span>
                                <span class="font-semibold">{{ ucfirst($crowdfunding->property->type ?? 'Non défini') }}</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Localisation:</span>
                                <span class="font-semibold">{{ $crowdfunding->property->location ?? 'Non définie' }}</span>
                            </div>
                            @if($crowdfunding->property->area)
                            <div>
                                <span class="text-sm text-gray-600">Superficie:</span>
                                <span class="font-semibold">{{ $crowdfunding->property->area }} m²</span>
                            </div>
                            @endif
                            @if($crowdfunding->property->bedrooms)
                            <div>
                                <span class="text-sm text-gray-600">Chambres:</span>
                                <span class="font-semibold">{{ $crowdfunding->property->bedrooms }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Investisseurs récents -->
                @if($crowdfunding->investments->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Investisseurs récents</h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-3">
                            @foreach($crowdfunding->investments->take(5) as $investment)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-primary-600 font-semibold text-sm">
                                            {{ substr($investment->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $investment->user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $investment->shares_purchased }} parts</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">{{ number_format($investment->amount_invested, 0, ',', ' ') }} FCFA</p>
                                    <p class="text-sm text-gray-600">{{ $investment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Statut et progression -->
                <div class="card">
                    <div class="card-header">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">Progression</h3>
                            <span class="badge badge-{{ $crowdfunding->status === 'active' ? 'success' : ($crowdfunding->status === 'funded' ? 'primary' : 'warning') }}">
                                {{ ucfirst($crowdfunding->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Barre de progression -->
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>Montant levé</span>
                                <span>{{ number_format($crowdfunding->progress_percentage, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-primary-600 h-3 rounded-full transition-all duration-300" 
                                     style="width: {{ $crowdfunding->progress_percentage }}%"></div>
                            </div>
                        </div>

                        <!-- Montants -->
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Montant levé:</span>
                                <span class="font-semibold">{{ number_format($crowdfunding->amount_raised, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Objectif:</span>
                                <span class="font-semibold">{{ number_format($crowdfunding->total_amount, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Parts vendues:</span>
                                <span class="font-semibold">{{ $crowdfunding->shares_sold }} / {{ $crowdfunding->total_shares }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations d'investissement -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Informations d'investissement</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $crowdfunding->expected_roi }}%</div>
                            <div class="text-sm text-gray-600">ROI attendu par an</div>
                        </div>

                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ number_format($crowdfunding->price_per_share, 0, ',', ' ') }}</div>
                            <div class="text-sm text-gray-600">FCFA par part</div>
                        </div>

                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900">{{ $crowdfunding->remaining_shares }}</div>
                            <div class="text-sm text-gray-600">Parts disponibles</div>
                        </div>

                        <div class="text-center">
                            <div class="text-lg font-bold text-orange-600">{{ $stats['days_remaining'] }}</div>
                            <div class="text-sm text-gray-600">Jours restants</div>
                        </div>
                    </div>
                </div>

                <!-- Formulaire d'investissement -->
                @if($crowdfunding->status === 'active' && $crowdfunding->remaining_shares > 0)
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Investir dans ce projet</h3>
                    </div>
                    <div class="card-body">
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
                </div>
                @elseif($crowdfunding->status === 'funded')
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle text-4xl text-green-500 mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Projet entièrement financé</h3>
                        <p class="text-gray-600">Ce projet a atteint son objectif de financement.</p>
                    </div>
                </div>
                @elseif($crowdfunding->remaining_shares === 0)
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-times-circle text-4xl text-red-500 mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Plus de parts disponibles</h3>
                        <p class="text-gray-600">Toutes les parts ont été vendues.</p>
                    </div>
                </div>
                @endif

                <!-- Statistiques -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Statistiques</h3>
                    </div>
                    <div class="card-body space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Investisseurs:</span>
                            <span class="font-semibold">{{ $stats['total_investors'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Investissement moyen:</span>
                            <span class="font-semibold">{{ number_format($stats['average_investment'], 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Créé le:</span>
                            <span class="font-semibold">{{ $crowdfunding->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Échéance:</span>
                            <span class="font-semibold">{{ $crowdfunding->funding_deadline->format('d/m/Y') }}</span>
                        </div>
                    </div>
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
        pricePerShare: {{ $crowdfunding->price_per_share }},
        
        get totalAmount() {
            return this.shares * this.pricePerShare;
        },
        
        formatPrice(price) {
            return new Intl.NumberFormat('fr-FR').format(Math.round(price)) + ' FCFA';
        }
    }
}
</script>
@endpush
@endsection
