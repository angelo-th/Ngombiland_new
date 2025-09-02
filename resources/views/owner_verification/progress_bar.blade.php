{{-- resources/views/owner_verification/progress_bar.blade.php --}}
<div class="mb-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <div id="step1" class="step-active w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm">1</div>
                <div class="flex-1 h-2 bg-gray-200 rounded-full">
                    <div id="progressBar" class="h-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full progress-bar" style="width: 25%"></div>
                </div>
                <div id="step2" class="step-pending w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm">2</div>
                <div class="flex-1 h-2 bg-gray-200 rounded-full"></div>
                <div id="step3" class="step-pending w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm">3</div>
                <div class="flex-1 h-2 bg-gray-200 rounded-full"></div>
                <div id="step4" class="step-pending w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm">4</div>
            </div>
        </div>
        <div class="flex justify-between text-sm text-gray-600">
            <span>Land Title</span>
            <span>ID Front</span>
            <span>ID Back</span>
            <span>Liveness Check</span>
        </div>
    </div>
</div>
