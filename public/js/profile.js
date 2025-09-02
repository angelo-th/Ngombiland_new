
        function profileApp() {
            return {
                activeTab: 'profile',
                showPasswordModal: false,
                showTwoFactorSetup: false,
                passwordForm: {
                    currentPassword: '',
                    newPassword: '',
                    confirmPassword: ''
                },
                user: {
                    name: "Angelo Mbiock",
                    email: "Angel_th@example.com",
                    phone: "+237 6 53 00 85 86",
                    birthDate: "2004-05-13",
                    address: "123 Rue de Etoudi",
                    city: "yaounde",
                    country: "Cameroun",
                    avatar: "https://via.placeholder.com/150",
                    role: "Propriétaire & Investisseur",
                    twoFactorEnabled: false,
                    documents: {
                        cni: {
                            status: "verified",
                            rejectionReason: ""
                        },
                        proofOfAddress: {
                            status: "none"
                        }
                    },
                    language: "fr",
                    currency: "FCFA",
                    theme: "light"
                },
                notifications: {
                    email: {
                        transactions: true,
                        rentalPayments: true,
                        projectUpdates: false
                    },
                    push: {
                        transactions: true,
                        messages: true
                    },
                    sms: {
                        important: true,
                        otp: true
                    }
                },
                
                // Methods
                updateAvatar(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.user.avatar = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },
                
                saveProfile() {
                    alert("Profil mis à jour avec succès!");
                    // In a real app, this would call an API
                },
                
                changePassword() {
                    if (this.passwordForm.newPassword !== this.passwordForm.confirmPassword) {
                        alert("Les mots de passe ne correspondent pas!");
                        return;
                    }
                    alert("Mot de passe changé avec succès!");
                    this.showPasswordModal = false;
                    this.passwordForm = {
                        currentPassword: '',
                        newPassword: '',
                        confirmPassword: ''
                    };
                },
                
                toggleTwoFactor() {
                    if (!this.user.twoFactorEnabled) {
                        this.showTwoFactorSetup = true;
                    } else {
                        if (confirm("Désactiver l'authentification à deux facteurs?")) {
                            this.user.twoFactorEnabled = false;
                            this.showTwoFactorSetup = false;
                        }
                    }
                },
                
                saveNotificationSettings() {
                    alert("Préférences de notification enregistrées!");
                    // In a real app, this would call an API
                },
                
                savePreferences() {
                    alert("Préférences enregistrées!");
                    // In a real app, this would call an API
                }
            }
        }
    