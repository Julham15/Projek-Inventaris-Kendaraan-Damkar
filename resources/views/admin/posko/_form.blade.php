<div>
    <x-input-label for="nama_posko" value="Nama Posko" />

    <x-text-input
        id="nama_posko"
        name="nama_posko"
        type="text"
        class="mt-1 block w-full"
        :value="old('nama_posko', $posko->nama_posko ?? '')"
        required
    />

    <x-input-error :messages="$errors->get('nama_posko')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="alamat" value="Alamat" />

    <textarea
        name="alamat"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
        rows="3"
    >{{ old('alamat', $posko->alamat ?? '') }}</textarea>

    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
</div>