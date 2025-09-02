{{-- resources/views/owner_verification/step3.blade.php --}}
<div id="cniVersoStep" class="verification-step hidden">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 rounded-full mb-4">
                <i data-lucide="credit-card" class="w-8 h-8 text-orange-600"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">National ID - Back</h2>
            <p class="text-gray-600">Now scan the back side of your ID</p>
        </div>

        <div class="max-w-md mx-auto">
            <div class="camera-preview bg-gray-100 h-64 flex items-center justify-center relative mb-6">
                <div id="cniVersoPreview" class="hidden w-full h-full">
                    <img id="cniVersoImage" src="" alt="ID Back" class="w-full h-full object-cover rounded-lg">
                </div>
                <div id="cniVersoPlaceholder" class="text-center">
                    <div class="document-frame w-32 h-20 mx-auto mb-4 flex items-center justify-center">
                        <i data-lucide="fingerprint" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <p class="text-gray-500">Side with fingerprint</p>
                </div>
                <div class="scan-overlay"></div>
            </div>

            <div class="space-y-4">
                <input type="file" id="cniVersoInput" accept="image/*" capture="camera" class="hidden">
                <button onclick="captureCniVerso()" class="w-full bg-orange-600 hover:bg-orange-700 text-white py-3 rounded-lg font-medium transition flex items-center justify-center space-x-2">
                    <i data-lucide="camera" class="w-5 h-5"></i>
                    <span>Scan ID Back</span>
                </button>
            </div>

            <div class="flex justify-between mt-6">
                <button onclick="previousStep()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-medium transition">
                    Previous
                </button>
                <button id="nextStep3" onclick="nextStep()" disabled class="bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-medium cursor-not-allowed">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>
