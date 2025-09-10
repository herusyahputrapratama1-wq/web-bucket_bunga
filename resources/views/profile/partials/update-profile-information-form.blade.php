<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Alamat') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Pastikan alamat pengiriman Anda benar dan lengkap.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Nomor Telepon')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                :value="old('phone', $user->phone)" />
        </div>

        <hr />

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="province" :value="__('Provinsi')" />
                <x-text-input id="province" name="province" type="text" class="mt-1 block w-full"
                    :value="old('province', $user->province)" />
            </div>
            <div>
                <x-input-label for="city" :value="__('Kota')" />
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full"
                    :value="old('city', $user->city)" />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="district" :value="__('Kecamatan')" />
                <x-text-input id="district" name="district" type="text" class="mt-1 block w-full"
                    :value="old('district', $user->district)" />
            </div>
            <div>
                <x-input-label for="postal_code" :value="__('Kode Pos')" />
                <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full"
                    :value="old('postal_code', $user->postal_code)" />
            </div>
        </div>

        <div>
            <x-input-label for="street_address" :value="__('Nama Jalan, Gedung, No. Rumah')" />
            <textarea id="street_address" name="street_address"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('street_address', $user->street_address) }}</textarea>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email (Tidak bisa diubah)')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-gray-100"
                :value="$user->email" readonly />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>