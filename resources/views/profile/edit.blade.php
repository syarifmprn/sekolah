<x-app-layout>
    <x-slot name="header">
        Profil Pengguna
    </x-slot>

    <div class="p-6 h-full overflow-y-auto max-w-4xl mx-auto">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-800">Informasi Profil</h3>
                <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil dan alamat email akun Anda.</p>
            </div>
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-800">Ubah Kata Sandi</h3>
                <p class="text-sm text-gray-500 mt-1">Pastikan akun Anda menggunakan kata sandi yang kuat dan aman.</p>
            </div>
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-800 text-red-600">Hapus Akun</h3>
                <p class="text-sm text-gray-500 mt-1">Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.</p>
            </div>
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
        
    </div>
</x-app-layout>
