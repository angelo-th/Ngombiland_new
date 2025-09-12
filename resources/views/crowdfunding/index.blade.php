@extends('layouts.app')

@section('title', 'Crowdfunding - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Crowdfunding Immobilier</h1>
            <p class="text-xl text-gray-600">Investissez dans l'immobilier camerounais avec des montants accessibles</p>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center mb-8">
            <div class="flex space-x-4">
                <a href="{{ route('crowdfunding.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Créer un projet
                </a>
                <a href="{{ route('investments.index') }}" class="btn btn-outline">
                    <i class="fas fa-chart-line mr-2"></i>
                    Mes investissements
                </a>
            </div>
            
            <div class="flex space-x-2">
                <select class="form-select" onchange="filterProjects(this.value)">
                    <option value="">Tous les projets</option>
                    <option value="active">Actifs</option>
                    <option value="funded">Financés</option>
                    <option value="draft">Brouillons</option>
                </select>
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
            <div class="card hover:shadow-xl transition-shadow">
                <!-- Image -->
                <div class="relative">
                    @if($project->images && count($project->images) > 0)
                        <img src="{{ asset('storage/' . $project->images[0]) }}" 
                             alt="{{ $project->title }}" 
                             class="w-full h-48 object-cover rounded-t-lg">
                    @else
                        <div class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                            <i class="fas fa-building text-4xl text-gray-400"></i>
                        </div>
                    @endif
                    
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4">
                        @switch($project->status)
                            @case('active')
                                <span class="badge badge-success">Actif</span>
                                @break
                            @case('funded')
                                <span class="badge badge-primary">Financé</span>
                                @break
                            @case('draft')
                                <span class="badge badge-warning">Brouillon</span>
                                @break
                            @default
                                <span class="badge badge-secondary">{{ ucfirst($project->status) }}</span>
                        @endswitch
                    </div>
                </div>

                <!-- Content -->
                <div class="card-body">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $project->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($project->description, 100) }}</p>

                    <!-- Property Info -->
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>{{ $project->property->location ?? 'Localisation non définie' }}</span>
                    </div>

                    <!-- Investment Info -->
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Montant levé</span>
                            <span class="font-semibold">{{ number_format($project->amount_raised, 0, ',', ' ') }} FCFA</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Objectif</span>
                            <span class="font-semibold">{{ number_format($project->total_amount, 0, ',', ' ') }} FCFA</span>
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-primary-600 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ $project->progress_percentage }}%"></div>
                        </div>
                        
                        <div class="text-center text-sm text-gray-600">
                            {{ number_format($project->progress_percentage, 1) }}% financé
                        </div>
                    </div>

                    <!-- ROI and Shares -->
                    <div class="grid grid-cols-2 gap-4 mt-4 pt-4 border-t border-gray-200">
                        <div class="text-center">
                            <div class="text-lg font-bold text-green-600">{{ $project->expected_roi }}%</div>
                            <div class="text-xs text-gray-500">ROI attendu</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-blue-600">{{ number_format($project->price_per_share, 0, ',', ' ') }}</div>
                            <div class="text-xs text-gray-500">FCFA/part</div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 space-y-2">
                        <a href="{{ route('crowdfunding.show', $project) }}" class="btn btn-primary w-full">
                            Voir le projet
                        </a>
                        
                        @if($project->status === 'active' && $project->remaining_shares > 0)
                            <button onclick="openInvestmentModal({{ $project->id }}, {{ $project->price_per_share }}, {{ $project->remaining_shares }})" 
                                    class="btn btn-success w-full">
                                <i class="fas fa-coins mr-2"></i>
                                Investir
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-building text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun projet de crowdfunding</h3>
                <p class="text-gray-600 mb-6">Soyez le premier à créer un projet de crowdfunding !</p>
                <a href="{{ route('crowdfunding.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Créer un projet
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($projects->hasPages())
        <div class="mt-8">
            {{ $projects->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Investment Modal -->
<div id="investmentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50" x-data="investmentModal()">
    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Investir dans ce projet</h3>
            <button @click="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form @submit.prevent="submitInvestment()">
            <div class="space-y-4">
                <div>
                    <label class="form-label">Nombre de parts</label>
                    <input type="number" x-model="shares" :max="maxShares" min="1" class="form-input" required>
                    <p class="text-sm text-gray-500 mt-1">Prix par part: <span x-text="formatPrice(pricePerShare)"></span> FCFA</p>
                </div>
                
                <div>
                    <label class="form-label">Montant total</label>
                    <div class="form-input bg-gray-50" x-text="formatPrice(totalAmount)"></div>
                </div>
                
                <div class="flex space-x-3">
                    <button type="button" @click="closeModal()" class="btn btn-outline flex-1">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary flex-1">
                        <i class="fas fa-coins mr-2"></i>
                        Investir
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function filterProjects(status) {
    const url = new URL(window.location);
    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }
    window.location = url;
}

function openInvestmentModal(projectId, pricePerShare, maxShares) {
    window.investmentModalData = {
        projectId: projectId,
        pricePerShare: pricePerShare,
        maxShares: maxShares
    };
    document.getElementById('investmentModal').classList.remove('hidden');
    document.getElementById('investmentModal').classList.add('flex');
}

function investmentModal() {
    return {
        shares: 1,
        projectId: null,
        pricePerShare: 0,
        maxShares: 0,
        
        get totalAmount() {
            return this.shares * this.pricePerShare;
        },
        
        init() {
            if (window.investmentModalData) {
                this.projectId = window.investmentModalData.projectId;
                this.pricePerShare = window.investmentModalData.pricePerShare;
                this.maxShares = window.investmentModalData.maxShares;
            }
        },
        
        closeModal() {
            document.getElementById('investmentModal').classList.add('hidden');
            document.getElementById('investmentModal').classList.remove('flex');
        },
        
        submitInvestment() {
            if (this.shares < 1 || this.shares > this.maxShares) {
                alert('Nombre de parts invalide');
                return;
            }
            
            // Créer un formulaire et le soumettre
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/crowdfunding/${this.projectId}/invest`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const sharesInput = document.createElement('input');
            sharesInput.type = 'hidden';
            sharesInput.name = 'shares';
            sharesInput.value = this.shares;
            
            form.appendChild(csrfToken);
            form.appendChild(sharesInput);
            document.body.appendChild(form);
            form.submit();
        },
        
        formatPrice(price) {
            return new Intl.NumberFormat('fr-FR').format(price);
        }
    }
}
</script>
@endpush
@endsection