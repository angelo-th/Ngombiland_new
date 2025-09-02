document.addEventListener('DOMContentLoaded', () => {
    const step1Next = document.getElementById('step1-next');
    const step2Back = document.getElementById('step2-back');
    const step2Next = document.getElementById('step2-next');
    const step3Back = document.getElementById('step3-back');
    const step3Verify = document.getElementById('step3-verify');

    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');
    const step4 = document.getElementById('step4');

    // Step1 → Step2
    step1Next.addEventListener('click', () => {
        step1.classList.add('hidden');
        step2.classList.remove('hidden');
    });

    // Step2 Back
    step2Back.addEventListener('click', () => {
        step2.classList.add('hidden');
        step1.classList.remove('hidden');
    });

    // Sélection du rôle active le bouton Continue
    document.querySelectorAll('.profile-card').forEach(card => {
        card.addEventListener('click', () => {
            document.querySelectorAll('.profile-card').forEach(c => c.classList.remove('border-green-400', 'border-2'));
            card.classList.add('border-green-400', 'border-2');
            step2Next.disabled = false;
        });
    });

    // Step2 → Step3
    step2Next.addEventListener('click', () => {
        step2.classList.add('hidden');
        step3.classList.remove('hidden');
    });

    // Step3 Back
    step3Back.addEventListener('click', () => {
        step3.classList.add('hidden');
        step2.classList.remove('hidden');
    });

    // Step3 → Step4 (simulate OTP success)
    step3Verify.addEventListener('click', () => {
        step3.classList.add('hidden');
        step4.classList.remove('hidden');
    });

    // Active le bouton Verify quand OTP rempli (optionnel)
    const otpInputs = document.querySelectorAll('.otp-input');
    otpInputs.forEach(input => {
        input.addEventListener('input', () => {
            let filled = Array.from(otpInputs).every(i => i.value.trim() !== '');
            step3Verify.disabled = !filled;
        });
    });
});
