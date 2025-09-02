{{-- resources/views/owner_verification/step4.blade.php --}}
<div id="livenessStep" class="verification-step hidden">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full mb-4">
                <i data-lucide="user-check" class="w-8 h-8 text-purple-600"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Liveness Verification</h2>
            <p class="text-gray-600">Follow the instructions to confirm your identity</p>
        </div>

        <div class="max-w-md mx-auto">
            <div class="camera-preview bg-gray-900 h-80 flex items-center justify-center relative mb-6 rounded-xl overflow-hidden">
                <video id="livenessVideo" class="w-full h-full object-cover hidden" autoplay playsinline></video>
                <div id="livenessPreview" class="hidden w-full h-full">
                    <img id="livenessImage" src="" alt="Selfie verification" class="w-full h-full object-cover">
                </div>
                <div id="livenessPlaceholder" class="text-center text-white">
                    <div class="pulse-ring w-24 h-24 border-4 border-white rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i data-lucide="user" class="w-12 h-12"></i>
                    </div>
                    <p>Position your face within the circle</p>
                </div>
            </div>

            <div class="space-y-4">
                <button id="startLiveness" onclick="startLivenessCheck()" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg font-medium transition flex items-center justify-center space-x-2">
                    <i data-lucide="video" class="w-5 h-5"></i>
                    <span>Start Verification</span>
                </button>

                <button id="captureSelfie" onclick="captureSelfie()" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium transition flex items-center justify-center space-x-2 hidden">
                    <i data-lucide="camera" class="w-5 h-5"></i>
                    <span>Capture</span>
                </button>
            </div>

            <div class="flex justify-between mt-6">
                <button onclick="previousStep()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-medium transition">
                    Previous
                </button>
                <button id="completeVerification" onclick="completeVerification()" disabled class="bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-medium cursor-not-allowed">
                    Complete
                </button>
            </div>
        </div>
    </div>
</div>
