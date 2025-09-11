@extends('layouts.app')

@section('title', 'Vérification Propriétaire - Étape 2')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                Vérification de Propriétaire
            </h1>
            <p class="text-lg text-gray-600">
                Vérifiez votre identité et vos documents pour publier des annonces
            </p>
        </div>

        <!-- Progress Bar -->
        @include('owner_verification.progress_bar', ['step' => 2])

        <!-- Main Content -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="max-w-2xl mx-auto">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2">
                        Vérification Liveness
                    </h2>
                    <p class="text-gray-600">
                        Prenez une photo de vous-même pour vérifier votre identité
                    </p>
                </div>

                <form action="{{ route('owner.verification.step2.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Camera Section -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Photo de vérification
                        </h3>
                        
                        <div class="text-center">
                            <!-- Camera Preview -->
                            <div id="camera-preview" class="relative mx-auto w-64 h-64 bg-gray-200 rounded-lg overflow-hidden mb-4">
                                <video id="video" class="w-full h-full object-cover" autoplay muted></video>
                                <canvas id="canvas" class="hidden"></canvas>
                                <div id="capture-overlay" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                                    <div class="text-white text-center">
                                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-sm">Photo capturée !</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Camera Controls -->
                            <div class="space-y-4">
                                <button type="button" 
                                        id="start-camera" 
                                        class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Activer la caméra
                                </button>

                                <button type="button" 
                                        id="capture-photo" 
                                        class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors hidden">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Prendre la photo
                                </button>

                                <button type="button" 
                                        id="retake-photo" 
                                        class="w-full px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors hidden">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Reprendre la photo
                                </button>
                            </div>

                            <!-- Hidden input for captured photo -->
                            <input type="hidden" id="selfie_data" name="selfie_data">
                        </div>

                        <!-- Instructions -->
                        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-blue-800 mb-2">
                                Instructions pour une photo réussie :
                            </h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Assurez-vous d'avoir un bon éclairage</li>
                                <li>• Regardez directement la caméra</li>
                                <li>• Retirez vos lunettes de soleil si vous en portez</li>
                                <li>• Gardez une expression neutre</li>
                                <li>• Votre visage doit être entièrement visible</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Document Upload -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Documents de propriété
                        </h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="title_deed" class="block text-sm font-medium text-gray-700 mb-2">
                                    Titre foncier *
                                </label>
                                <div class="relative">
                                    <input type="file" 
                                           id="title_deed" 
                                           name="title_deed" 
                                           accept="image/*,.pdf"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title_deed') border-red-500 @enderror"
                                           required>
                                </div>
                                @error('title_deed')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">
                                    Format: JPG, PNG, PDF (max 10MB)
                                </p>
                            </div>

                            <div>
                                <label for="property_photos" class="block text-sm font-medium text-gray-700 mb-2">
                                    Photos de la propriété *
                                </label>
                                <div class="relative">
                                    <input type="file" 
                                           id="property_photos" 
                                           name="property_photos[]" 
                                           accept="image/*"
                                           multiple
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('property_photos') border-red-500 @enderror"
                                           required>
                                </div>
                                @error('property_photos')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">
                                    Minimum 3 photos, Format: JPG, PNG (max 5MB chacune)
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between pt-6">
                        <a href="{{ route('owner.verification.step1') }}" 
                           class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Précédent
                        </a>
                        
                        <button type="submit" 
                                id="submit-btn"
                                class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            Continuer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.725-1.36 3.49 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">
                        Vérification en temps réel
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>
                            Notre système d'IA vérifiera automatiquement votre identité 
                            et la validité de vos documents en temps réel.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let stream = null;
    let captured = false;

    const startCameraBtn = document.getElementById('start-camera');
    const capturePhotoBtn = document.getElementById('capture-photo');
    const retakePhotoBtn = document.getElementById('retake-photo');
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const submitBtn = document.getElementById('submit-btn');
    const selfieData = document.getElementById('selfie_data');

    startCameraBtn.addEventListener('click', async () => {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    width: 640, 
                    height: 480,
                    facingMode: 'user'
                } 
            });
            
            video.srcObject = stream;
            startCameraBtn.classList.add('hidden');
            capturePhotoBtn.classList.remove('hidden');
        } catch (err) {
            alert('Erreur lors de l\'accès à la caméra: ' + err.message);
        }
    });

    capturePhotoBtn.addEventListener('click', () => {
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        context.drawImage(video, 0, 0);
        
        const imageData = canvas.toDataURL('image/jpeg', 0.8);
        selfieData.value = imageData;
        
        // Show capture overlay
        document.getElementById('capture-overlay').classList.remove('hidden');
        
        // Stop camera
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        
        capturePhotoBtn.classList.add('hidden');
        retakePhotoBtn.classList.remove('hidden');
        submitBtn.disabled = false;
        captured = true;
    });

    retakePhotoBtn.addEventListener('click', () => {
        document.getElementById('capture-overlay').classList.add('hidden');
        retakePhotoBtn.classList.add('hidden');
        startCameraBtn.classList.remove('hidden');
        submitBtn.disabled = true;
        captured = false;
        selfieData.value = '';
    });

    // File upload validation
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            
            files.forEach(file => {
                // Validate file size
                const maxSize = input.id === 'title_deed' ? 10 * 1024 * 1024 : 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert(`Le fichier ${file.name} ne doit pas dépasser ${maxSize / (1024 * 1024)}MB`);
                    this.value = '';
                    return;
                }
                
                // Validate file type
                if (input.id === 'title_deed') {
                    if (!file.type.startsWith('image/') && file.type !== 'application/pdf') {
                        alert('Veuillez sélectionner un fichier image ou PDF');
                        this.value = '';
                        return;
                    }
                } else {
                    if (!file.type.startsWith('image/')) {
                        alert('Veuillez sélectionner un fichier image');
                        this.value = '';
                        return;
                    }
                }
            });
        });
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!captured) {
            e.preventDefault();
            alert('Veuillez prendre une photo de vérification');
            return;
        }
    });
</script>
@endpush
@endsection