{{-- resources/views/owner_verification/step2.blade.php --}}
<div id="cniRectoStep" class="verification-step hidden">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <i data-lucide="credit-card" class="w-8 h-8 text-green-600"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">National ID - Front</h2>
            <p class="text-gray-600">Scan the front side of your national ID card</p>
        </div>

        <div class="max-w-md mx-auto">
            <div class="camera-preview bg-gray-100 h-64 flex items-center justify-center relative mb-6">
                <div id="cniRectoPreview" class="hidden w-full h-full">
                    <img id="cniRectoImage" src="" alt="ID Front" class="w-full h-full object-cover rounded-lg">
                </div>
                <div id="cniRectoPlaceholder" class="text-center">
                    <div class="document-frame w-32 h-20 mx-auto mb-4 flex items-center justify-center">
                        <i data-lucide="id-card" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <p class="text-gray-500">Horizontal orientation recommended</p>
                </div>
                <div class="scan-overlay"></div>
            </div>

            <div class="space-y-4">
                <input type="file" id="cniRectoInput" accept="image/*" capture="camera" class="hidden">
                <button onclick="captureCniRecto()" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium transition flex items-center justify-center space-x-2">
                    <i data-lucide="camera" class="w-5 h-5"></i>
                    <span>Scan ID Front</span>
                </button>
            </div>

            <div class="flex justify-between mt-6">
                <button onclick="previousStep()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-medium transition">
                    Previous
                </button>
                <button id="nextStep2" onclick="nextStep()" disabled class="bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-medium cursor-not-allowed">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>
