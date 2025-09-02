<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <script src="{{ asset('js/profile.js') }}"></script>
</head>
<body class="bg-gray-50" x-data="profileApp()">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center py-4">
            <a href="javascript:history.back()" class="mr-4 text-gray-500 hover:text-emerald-600 flex items-center">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/logo.png') }}" alt="NGOMBILAND" class="h-10">
                <h1 class="text-xl font-bold text-gray-800">My Profile</h1>
            </div>
            <div class="flex items-center space-x-4">
                <button class="p-2 text-gray-600 hover:text-primary relative">
                    <i class="fas fa-bell text-xl"></i>
                </button>
                <img :src="user.avatar" alt="Profile" class="w-8 h-8 rounded-full border-2 border-white shadow">
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Left Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex flex-col items-center">
                        <div class="avatar-upload mb-4 relative">
                            <img :src="user.avatar" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                            <input type="file" @change="updateAvatar" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                            <button class="absolute bottom-0 right-0 bg-emerald-500 text-white p-2 rounded-full hover:bg-emerald-600">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <h2 class="text-xl font-bold text-center" x-text="user.name"></h2>
                        <p class="text-gray-500 text-sm" x-text="user.role"></p>
                        
                        <div class="w-full mt-6 space-y-1">
                            <button @click="activeTab = 'profile'" :class="{'bg-gray-100 text-emerald-600': activeTab === 'profile'}" class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-user mr-2"></i>Personal Information
                            </button>
                            <button @click="activeTab = 'security'" :class="{'bg-gray-100 text-emerald-600': activeTab === 'security'}" class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-shield-alt mr-2"></i>Security
                            </button>
                            <button @click="activeTab = 'notifications'" :class="{'bg-gray-100 text-emerald-600': activeTab === 'notifications'}" class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-bell mr-2"></i>Notifications
                            </button>
                            <button @click="activeTab = 'documents'" :class="{'bg-gray-100 text-emerald-600': activeTab === 'documents'}" class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-file-alt mr-2"></i>Verified Documents
                            </button>
                            <button @click="activeTab = 'preferences'" :class="{'bg-gray-100 text-emerald-600': activeTab === 'preferences'}" class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-cog mr-2"></i>Preferences
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Personal Info -->
                <div x-show="activeTab === 'profile'" x-transition class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-6">Personal Information</h2>
                    
                    <form @submit.prevent="saveProfile">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" x-model="user.name" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" x-model="user.email" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="tel" x-model="user.phone" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Birth Date</label>
                                <input type="date" x-model="user.birthDate" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <input type="text" x-model="user.address" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                <select x-model="user.city" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                    <option value="yaounde">Yaoundé</option>
                                    <option value="douala">Douala</option>
                                    <option value="bafoussam">Bafoussam</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                <input type="text" x-model="user.country" class="w-full border border-gray-300 rounded-lg px-4 py-2" value="Cameroon" readonly>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Security, Notifications, Documents, Preferences sections follow the same pattern translated -->
                <!-- Remember to update all French text to English inside headings, labels, and buttons -->
            </div>
        </div>
    </main>

    <!-- Password Modal -->
    <div x-show="showPasswordModal" x-transition class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl max-w-md w-full" @click.stop>
            <div class="border-b p-4 flex justify-between items-center">
                <h3 class="text-xl font-bold">Change Password</h3>
                <button @click="showPasswordModal = false" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-6">
                <form @submit.prevent="changePassword">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <input type="password" x-model="passwordForm.currentPassword" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input type="password" x-model="passwordForm.newPassword" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters, with uppercase, lowercase, and number</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                            <input type="password" x-model="passwordForm.confirmPassword" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        </div>
                        
                        <div class="pt-4 flex justify-end space-x-3">
                            <button type="button" @click="showPasswordModal = false" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
