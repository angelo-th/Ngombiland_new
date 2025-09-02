
        // Toggle user menu
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('userMenu');
            const button = event.target.closest('button');
            if (!button || !button.onclick) {
                menu.classList.add('hidden');
            }
        });

        // Handle file upload preview
        document.getElementById('file-upload').addEventListener('change', function(e) {
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = '';
            
            if (this.files.length > 0) {
                previewContainer.classList.remove('hidden');
                
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const preview = document.createElement('div');
                            preview.className = 'relative';
                            preview.innerHTML = `
                                <img src="${e.target.result}" class="h-32 w-full object-cover rounded-lg">
                                <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs" onclick="removeImage(this)">
                                    ×
                                </button>
                            `;
                            previewContainer.appendChild(preview);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            } else {
                previewContainer.classList.add('hidden');
            }
        });

        function removeImage(button) {
            button.parentElement.remove();
            const previewContainer = document.getElementById('preview-container');
            if (previewContainer.children.length === 0) {
                previewContainer.classList.add('hidden');
            }
        }

        // Next step function
        function nextStep() {
            // Validate form
            const form = document.getElementById('crowdfundingForm');
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (isValid) {
                // In a real app, you would save the data and proceed to the next step
                alert('Form validated! Proceeding to financial details...');
                // window.location.href = 'crowdfunding_financials.html';
            } else {
                alert('Please fill in all required fields.');
            }
        }
    