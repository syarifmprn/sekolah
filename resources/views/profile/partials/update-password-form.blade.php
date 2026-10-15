<form method="post" action="{{ route('password.update') }}" class="space-y-6">
    @csrf
    @method('put')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2" for="update_password_current_password">{{ __('Kata Sandi Saat Ini') }} <span class="text-red-500">*</span></label>
            <input type="password" id="update_password_current_password" name="current_password" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" autocomplete="current-password" required />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-500 text-xs" />
        </div>
        
        <div class="md:col-span-2 hidden md:block"></div> <!-- Spacing for grid -->

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2" for="update_password_password">{{ __('Kata Sandi Baru') }} <span class="text-red-500">*</span></label>
            <input type="password" id="update_password_password" name="password" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" autocomplete="new-password" required />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-500 text-xs" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2" for="update_password_password_confirmation">{{ __('Konfirmasi Kata Sandi') }} <span class="text-red-500">*</span></label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" autocomplete="new-password" required />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-500 text-xs" />
        </div>
    </div>

    <div class="flex items-center justify-end pt-6 border-t border-gray-100 mt-6 gap-4">
        @if (session('status') === 'password-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-green-600 font-medium"
            >{{ __('Berhasil disimpan.') }}</p>
        @endif
        
        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-colors flex items-center gap-2">
            {{ __('Update Password') }}
        </button>
    </div>
</form>
