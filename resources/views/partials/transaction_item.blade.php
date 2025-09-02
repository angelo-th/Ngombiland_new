<div class="p-6 hover:bg-gray-50 transition border-l-4 {{ $transaction['type'] == 'recharge' ? 'border-green-500' : 'border-red-500' }}">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="{{ $transaction['type'] == 'recharge' ? 'bg-green-100' : 'bg-red-100' }} p-2 rounded-full">
                <i data-lucide="{{ $transaction['type'] == 'recharge' ? 'arrow-down-right' : 'arrow-up-right' }}" class="w-5 h-5 {{ $transaction['type'] == 'recharge' ? 'text-green-600' : 'text-red-600' }}"></i>
            </div>
            <div>
                <p class="font-medium text-gray-800">{{ $transaction['description'] }}</p>
                <p class="text-sm text-gray-500">{{ $transaction['time'] }}</p>
            </div>
        </div>
        <div class="text-right">
            <p class="font-bold {{ $transaction['type'] == 'recharge' ? 'text-green-600' : 'text-red-600' }}">{{ $transaction['amount'] }}</p>
            <p class="text-sm text-gray-500">{{ $transaction['status'] }}</p>
        </div>
    </div>
</div>
