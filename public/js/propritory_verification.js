// public/js/propritory_verification.js

// Step navigation
let currentStep = 1;
const totalSteps = 4;

// Helper to show/hide steps
function showStep(step) {
    // Hide all steps
    document.querySelectorAll('.verification-step').forEach(el => el.classList.add('hidden'));
    
    if(step <= totalSteps) {
        document.querySelector(`#${stepId(step)}`).classList.remove('hidden');
        document.getElementById('currentStep').innerText = step;
        updateProgressBar(step);
    }
}

// Return the step container ID
function stepId(step) {
    switch(step) {
        case 1: return 'titleStep';
        case 2: return 'cniRectoStep';
        case 3: return 'cniVersoStep';
        case 4: return 'livenessStep';
        default: return '';
    }
}

// Update progress bar and step circle
function updateProgressBar(step) {
    const progress = step * 25;
    document.getElementById('progressBar').style.width = `${progress}%`;

    for(let i=1;i<=totalSteps;i++){
        const el = document.getElementById(`step${i}`);
        if(i<step) {
            el.classList.add('step-completed');
            el.classList.remove('step-active','step-pending');
        } else if(i === step){
            el.classList.add('step-active');
            el.classList.remove('step-completed','step-pending');
        } else {
            el.classList.add('step-pending');
            el.classList.remove('step-active','step-completed');
        }
    }
}

// Next/Previous
function nextStep() {
    if(currentStep < totalSteps) {
        currentStep++;
        showStep(currentStep);
    }
}

function previousStep() {
    if(currentStep > 1) {
        currentStep--;
        showStep(currentStep);
    }
}

// Go back
function goBack() {
    window.history.back();
}

// --- Image preview and input handling ---
function handleImageInput(inputId, previewId, nextBtnId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    input.click();
    input.onchange = () => {
        if(input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.querySelector('img').src = e.target.result;
                preview.classList.remove('hidden');
                preview.previousElementSibling.classList.add('hidden'); // hide placeholder
                document.getElementById(nextBtnId).disabled = false;
                document.getElementById(nextBtnId).classList.remove('bg-gray-300','text-gray-500','cursor-not-allowed');
                document.getElementById(nextBtnId).classList.add('bg-blue-600','text-white');
            };
            reader.readAsDataURL(input.files[0]);
        }
    };
}

// Step 1: Land Title
function captureTitle() {
    handleImageInput('titleInput','titlePreview','nextStep1');
}
function uploadTitle() {
    handleImageInput('titleInput','titlePreview','nextStep1');
}

// Step 2: ID Front
function captureCniRecto() {
    handleImageInput('cniRectoInput','cniRectoPreview','nextStep2');
}

// Step 3: ID Back
function captureCniVerso() {
    handleImageInput('cniVersoInput','cniVersoPreview','nextStep3');
}

// --- Step 4: Liveness Check ---
let videoStream;

async function startLivenessCheck() {
    const video = document.getElementById('livenessVideo');
    const placeholder = document.getElementById('livenessPlaceholder');

    placeholder.classList.add('hidden');
    video.classList.remove('hidden');

    try {
        videoStream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = videoStream;
    } catch(err) {
        alert('Unable to access camera: '+err.message);
    }

    // Enable capture after 1s for demo
    setTimeout(() => {
        document.getElementById('captureSelfie').classList.remove('hidden');
    }, 1000);
}

function captureSelfie() {
    const video = document.getElementById('livenessVideo');
    const preview = document.getElementById('livenessPreview');
    const canvas = document.createElement('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video,0,0,canvas.width,canvas.height);

    preview.querySelector('img').src = canvas.toDataURL('image/png');
    preview.classList.remove('hidden');
    video.classList.add('hidden');

    // Stop video stream
    videoStream.getTracks().forEach(track => track.stop());

    // Enable complete button
    const btn = document.getElementById('completeVerification');
    btn.disabled = false;
    btn.classList.remove('bg-gray-300','text-gray-500','cursor-not-allowed');
    btn.classList.add('bg-blue-600','text-white');
}

// --- Success buttons ---
function goToDashboard() {
    window.location.href = '/dashboard';
}

function checkStatus() {
    window.location.href = '/verification-status';
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    showStep(currentStep);
});
