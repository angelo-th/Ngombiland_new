{{-- resources/views/owner_verification/success.blade.php --}}
<div id="successStep" class="verification-step hidden">
    <div class="bg-white rounded-xl shadow-lg p-8 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-6">
            <i data-lucide="check-circle" class="w-12 h-12 text-green-600"></i>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Verification Complete!</h2>
        <p class="text-gray-600 mb-8">Your documents have been successfully submitted. Our team will verify them within the next 24-48 hours.</p>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
            <h3 class="font-semibold text-blue-800 mb-3">Next Steps:</h3>
            <ul class="text-left text-blue-700 space-y-2">
                <li class="flex items-center space-x-2">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                    <span>Automatic document analysis (few minutes)</span>
                </li>
                <li class="flex items-center space-x-2">
                    <i data-lucide="user-check" class="w-4 h-4"></i>
                    <span>Manual verification by our team (24-48h)</span>
                </li>
                <li class="flex items-center space-x-2">
                    <i data-lucide="mail" class="w-4 h-4"></i>
                    <span>Notification via email and SMS</span>
                </li>
            </ul>
        </div>

        <div class="space-y-4">
            <button onclick="goToDashboard()" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition">
                Go to Dashboard
            </button>
            <button onclick="checkStatus()" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-lg font-medium transition">
                Check Status
            </button>
        </div>
    </div>
</div>
