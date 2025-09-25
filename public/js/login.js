// Login Page JavaScript
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const emailInput = document.querySelector('input[name="email"]');
    const passwordInput = document.querySelector('input[name="password"]');
    const submitButton = document.querySelector('button[type="submit"]');
    const rememberCheckbox = document.querySelector('input[name="remember"]');

    // Auto-focus on email input
    if (emailInput) {
        emailInput.focus();
    }

    // Form validation
    function validateForm() {
        let isValid = true;

        // Clear previous errors
        clearErrors();

        // Validate email
        if (!emailInput.value || !isValidEmail(emailInput.value)) {
            showError(emailInput, "Veuillez entrer une adresse email valide");
            isValid = false;
        }

        // Validate password
        if (!passwordInput.value || passwordInput.value.length < 6) {
            showError(
                passwordInput,
                "Le mot de passe doit contenir au moins 6 caractères"
            );
            isValid = false;
        }

        return isValid;
    }

    // Email validation
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Show error
    function showError(input, message) {
        input.classList.add("border-red-500");

        // Remove existing error message
        const existingError = input.parentNode.querySelector(".error-message");
        if (existingError) {
            existingError.remove();
        }

        // Add new error message
        const errorDiv = document.createElement("div");
        errorDiv.className = "error-message mt-1 text-xs text-red-400";
        errorDiv.textContent = message;
        input.parentNode.appendChild(errorDiv);
    }

    // Clear errors
    function clearErrors() {
        const errorMessages = document.querySelectorAll(".error-message");
        errorMessages.forEach((error) => error.remove());

        const errorInputs = document.querySelectorAll(".border-red-500");
        errorInputs.forEach((input) =>
            input.classList.remove("border-red-500")
        );
    }

    // Real-time validation
    if (emailInput) {
        emailInput.addEventListener("blur", function () {
            if (this.value && !isValidEmail(this.value)) {
                showError(this, "Veuillez entrer une adresse email valide");
            } else {
                this.classList.remove("border-red-500");
                const errorMessage =
                    this.parentNode.querySelector(".error-message");
                if (errorMessage) {
                    errorMessage.remove();
                }
            }
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener("blur", function () {
            if (this.value && this.value.length < 6) {
                showError(
                    this,
                    "Le mot de passe doit contenir au moins 6 caractères"
                );
            } else {
                this.classList.remove("border-red-500");
                const errorMessage =
                    this.parentNode.querySelector(".error-message");
                if (errorMessage) {
                    errorMessage.remove();
                }
            }
        });
    }

    // Form submission
    if (form) {
        form.addEventListener("submit", function (e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }

            // Show loading state
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Connexion...
                `;
            }
        });
    }

    // Mobile Money buttons
    const mtnButton = document.querySelector(
        'button[class*="mobile-money-btn"]:first-of-type'
    );
    const orangeButton = document.querySelector(
        'button[class*="mobile-money-btn"]:last-of-type'
    );

    if (mtnButton) {
        mtnButton.addEventListener("click", function () {
            showMobileMoneyModal("MTN Mobile Money");
        });
    }

    if (orangeButton) {
        orangeButton.addEventListener("click", function () {
            showMobileMoneyModal("Orange Money");
        });
    }

    // Mobile Money modal
    function showMobileMoneyModal(provider) {
        const modal = document.createElement("div");
        modal.className =
            "fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50";
        modal.innerHTML = `
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Connexion avec ${provider}</h3>
                <p class="text-gray-600 mb-4">Cette fonctionnalité sera bientôt disponible.</p>
                <button onclick="this.closest('.fixed').remove()" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                    Fermer
                </button>
            </div>
        `;
        document.body.appendChild(modal);
    }

    // Keyboard shortcuts
    document.addEventListener("keydown", function (e) {
        // Enter key on form
        if (
            e.key === "Enter" &&
            (e.target === emailInput || e.target === passwordInput)
        ) {
            if (e.target === emailInput) {
                passwordInput.focus();
            } else if (e.target === passwordInput) {
                form.submit();
            }
        }
    });

    // Remember me functionality
    if (rememberCheckbox) {
        // Load saved credentials
        const savedEmail = localStorage.getItem("rememberedEmail");
        if (savedEmail && emailInput) {
            emailInput.value = savedEmail;
            rememberCheckbox.checked = true;
        }

        // Save credentials when form is submitted
        if (form) {
            form.addEventListener("submit", function () {
                if (rememberCheckbox.checked && emailInput.value) {
                    localStorage.setItem("rememberedEmail", emailInput.value);
                } else {
                    localStorage.removeItem("rememberedEmail");
                }
            });
        }
    }
});

// Toggle password visibility
function togglePassword() {
    const passwordInput = document.querySelector('input[name="password"]');
    const toggleButton = document.querySelector(
        'button[onclick="togglePassword()"]'
    );

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleButton.innerHTML = `
            <svg class="w-4 h-4 text-white/70" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"/>
                <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/>
            </svg>
        `;
    } else {
        passwordInput.type = "password";
        toggleButton.innerHTML = `
            <svg class="w-4 h-4 text-white/70" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        `;
    }
}
