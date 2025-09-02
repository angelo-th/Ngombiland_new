{{-- resources/views/owner_verification/step1.blade.php --}}
<div id="titleStep" class="verification-step">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                <i data-lucide="file-text" class="w-8 h-8 text-blue-600"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Land Title Scan</h2>
            <p class="text-gray-600">Take a clear photo of your property title</p>
        </div>

        <div class="max-w-md mx-auto">
            <div class="camera-preview bg-gray-100 h-64 flex items-center justify-center relative mb-6">
                <div id="titlePreview" class="hidden w-full h-full">
                    <img id="titleImage" src="" alt="Land title" class="w-full h-full object-cover rounded-lg">
                </div>
                <div id="titlePlaceholder" class="text-center">
                    <i data-lucide="camera" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                    <p class="text-gray-500">Click to capture</p>
                </div>
                <div class="scan-overlay"></div>
            </div>

            <div class="space-y-4">
                <input type="file" id="titleInput" accept="image/*" capture="camera" class="hidden">
                <button onclick="captureTitle()" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition flex items-center justify-center space-x-2">
                    <i data-lucide="camera" class="w-5 h-5"></i>
                    <span>Take Photo</span>
                </button>

                <div class="text-center">
                    <button onclick="uploadTitle()" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                        Or choose from gallery
                    </button>
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-6">
                <div class="flex items-start space-x-3">
                    <i data-lucide="lightbulb" class="w-5 h-5 text-yellow-600 mt-0.5"></i>
                    <div>
                        <h4 class="font-medium text-yellow-800 mb-2">Capture Tips:</h4>
                        <ul class="text-sm text-yellow-700 space-y-1">
                            <li>• Ensure the document is well lit</li>
                            <li>• Avoid glare and shadows</li>
                            <li>• Frame the entire document</li>
                            <li>• Hold your device straight</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button id="nextStep1" onclick="nextStep()" disabled class="bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-medium cursor-not-allowed">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>
