<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">
            <i class="fas fa-users mr-2 text-green-600"></i>
            Investisseurs Récents
        </h3>
        <span class="text-sm text-gray-500">{{ $recentInvestments->count() }} investisseurs</span>
    </div>

    @if($recentInvestments->count() > 0)
        <div class="space-y-3">
            @foreach($recentInvestments as $investment)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-primary-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $investment->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $investment->shares_purchased }} parts</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-semibold text-gray-900">{{ number_format($investment->amount_invested, 0, ',', ' ') }} FCFA</p>
                    <p class="text-xs text-gray-500">{{ $investment->confirmed_at->diffForHumans() }}</p>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <i class="fas fa-user-plus text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-600">Aucun investisseur pour le moment</p>
            <p class="text-sm text-gray-500">Soyez le premier à investir !</p>
        </div>
    @endif
</div>
