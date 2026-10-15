<div class="space-y-6">
    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-600 max-w-xl">
            {{ __('Saat akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.') }}
        </p>

        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-200 transition-colors flex items-center gap-2 whitespace-nowrap"
        >
            <i class="fa-solid fa-trash-can"></i> {{ __('Hapus Akun') }}
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-gray-900 mb-2">
                {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
            </h2>

            <p class="text-sm text-gray-600 mb-6">
                {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
            </p>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="password">{{ __('Kata Sandi') }} <span class="text-red-500">*</span></label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm transition-colors"
                    placeholder="{{ __('Kata Sandi') }}"
                    required
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 transition-colors">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-200 transition-colors">
                    {{ __('Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</div>
