<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-900">
            <i class="fas fa-chart-line mr-2 text-primary-600"></i>
            Progression du Financement
        </h3>
        <div class="text-right">
            <p class="text-2xl font-bold text-primary-600">{{ number_format($progressPercentage, 1) }}%</p>
            <p class="text-sm text-gray-600">Complété</p>
        </div>
    </div>

    <!-- Barre de progression -->
    <div class="mb-6">
        <div class="flex justify-between text-sm text-gray-600 mb-2">
            <span>0%</span>
            <span class="font-semibold">{{ number_format($progressPercentage, 1) }}%</span>
            <span>100%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 h-3 rounded-full transition-all duration-500 ease-out"
                 style="width: {{ min($progressPercentage, 100) }}%"></div>
        </div>
    </div>

    <!-- Statistiques détaillées -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="text-center">
            <p class="text-2xl font-bold text-gray-900">{{ number_format($amountRaised, 0, ',', ' ') }}</p>
            <p class="text-sm text-gray-600">FCFA Levés</p>
        </div>
        <div class="text-center">
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalAmount, 0, ',', ' ') }}</p>
            <p class="text-sm text-gray-600">FCFA Objectif</p>
        </div>
        <div class="text-center">
            <p class="text-2xl font-bold text-gray-900">{{ $sharesSold }}/{{ $totalShares }}</p>
            <p class="text-sm text-gray-600">Parts Vendues</p>
        </div>
        <div class="text-center">
            <p class="text-2xl font-bold text-gray-900">{{ $investorsCount }}</p>
            <p class="text-sm text-gray-600">Investisseurs</p>
        </div>
    </div>

    <!-- Temps restant -->
    <div class="bg-gray-50 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-clock text-yellow-500 mr-2"></i>
                <span class="font-medium text-gray-900">Temps restant</span>
            </div>
            <div class="text-right">
                @if($daysRemaining > 0)
                    <p class="text-lg font-bold text-gray-900">{{ $daysRemaining }} jours</p>
                    <p class="text-sm text-gray-600">jusqu'au {{ $project->funding_deadline->format('d/m/Y') }}</p>
                @else
                    <p class="text-lg font-bold text-red-600">Expiré</p>
                    <p class="text-sm text-gray-600">le {{ $project->funding_deadline->format('d/m/Y') }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Statut du projet -->
    <div class="mt-4">
        @if($project->status === 'active')
            @if($progressPercentage >= 100)
                <div class="bg-green-100 border border-green-200 rounded-lg p-3">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                        <span class="font-medium text-green-800">Projet entièrement financé !</span>
                    </div>
                </div>
            @elseif($daysRemaining <= 7)
                <div class="bg-yellow-100 border border-yellow-200 rounded-lg p-3">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                        <span class="font-medium text-yellow-800">Dernière semaine !</span>
                    </div>
                </div>
            @else
                <div class="bg-blue-100 border border-blue-200 rounded-lg p-3">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        <span class="font-medium text-blue-800">Financement en cours</span>
                    </div>
                </div>
            @endif
        @elseif($project->status === 'funded')
            <div class="bg-green-100 border border-green-200 rounded-lg p-3">
                <div class="flex items-center">
                    <i class="fas fa-trophy text-green-600 mr-2"></i>
                    <span class="font-medium text-green-800">Projet financé avec succès !</span>
                </div>
            </div>
        @elseif($project->status === 'cancelled')
            <div class="bg-red-100 border border-red-200 rounded-lg p-3">
                <div class="flex items-center">
                    <i class="fas fa-times-circle text-red-600 mr-2"></i>
                    <span class="font-medium text-red-800">Projet annulé</span>
                </div>
            </div>
        @endif
    </div>
</div>
