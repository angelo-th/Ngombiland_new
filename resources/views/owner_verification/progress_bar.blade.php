<div class="w-full bg-gray-200 rounded-full h-2 mb-8">
    <div class="bg-blue-600 h-2 rounded-full transition-all duration-500 ease-in-out" 
         style="width: {{ ($step / 4) * 100 }}%"></div>
</div>

<div class="flex justify-between items-center mb-8">
    <div class="flex flex-col items-center {{ $step >= 1 ? 'text-blue-600' : 'text-gray-400' }}">
        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $step >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400' }}">
            @if($step > 1)
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            @else
                1
            @endif
        </div>
        <span class="text-xs mt-1 font-medium">Informations</span>
    </div>

    <div class="flex flex-col items-center {{ $step >= 2 ? 'text-blue-600' : 'text-gray-400' }}">
        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $step >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400' }}">
            @if($step > 2)
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            @else
                2
            @endif
        </div>
        <span class="text-xs mt-1 font-medium">Vérification</span>
    </div>

    <div class="flex flex-col items-center {{ $step >= 3 ? 'text-blue-600' : 'text-gray-400' }}">
        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $step >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400' }}">
            @if($step > 3)
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            @else
                3
            @endif
        </div>
        <span class="text-xs mt-1 font-medium">Géolocalisation</span>
    </div>

    <div class="flex flex-col items-center {{ $step >= 4 ? 'text-blue-600' : 'text-gray-400' }}">
        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $step >= 4 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400' }}">
            @if($step > 4)
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            @else
                4
            @endif
        </div>
        <span class="text-xs mt-1 font-medium">Confirmation</span>
    </div>
</div>