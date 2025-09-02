<div class="step-content hidden" id="step3">
    <div class="mb-5 text-center">
        <h2 class="text-xl font-semibold text-white mb-1">Verify Your Identity</h2>
        <p class="text-white/70 text-sm">Enter the 6-digit code sent to your phone</p>
    </div>
    <div class="flex justify-center space-x-2 mb-5">
        @for($i=0;$i<6;$i++)
            <input type="text" maxlength="1" class="otp-input rounded-lg text-center text-dark font-medium">
        @endfor
    </div>
    <p class="text-center text-white/70 text-xs mb-5">
        Didn't receive code? <button type="button" class="text-green-400 hover:text-green-300" id="resendOtp">Resend</button>
    </p>
    <div class="flex justify-between">
        <button type="button" class="bg-transparent border border-white/20 text-white w-1/3 py-2 text-xs rounded-lg" id="step3-back">Back</button>
        <button type="button" class="primary-btn w-2/3 py-2 ml-3 text-xs rounded-lg" id="step3-verify" disabled>Verify & Register</button>
    </div>
</div>
