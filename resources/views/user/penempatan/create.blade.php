<x-app-layout>

    <div class="max-w-2xl mx-auto p-6">

        <h2 class="text-xl font-bold mb-4">
            Penempatan Hari Ini
        </h2>

        <form method="POST"
              action="{{ route('penempatan.store') }}">
            @csrf

            <div class="mb-4">
                <label>Platon</label>

                <select name="platon_id"
                        class="w-full border rounded p-2">

                    <option value="">
                        Pilih Platon
                    </option>

                    @foreach($platons as $platon)
                        <option value="{{ $platon->id }}">
                            {{ $platon->nama }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-4">
                <label>Regu</label>

                <select name="regu_id"
                        class="w-full border rounded p-2">

                    <option value="">
                        Pilih Regu
                    </option>

                    @foreach($regus as $regu)
                        <option value="{{ $regu->id }}">
                            {{ $regu->nama }}
                        </option>
                    @endforeach

                </select>
            </div>

            <button
                class="bg-blue-500 text-black px-4 py-2 rounded">

                Mulai Bertugas

            </button>

        </form>

    </div>

</x-app-layout>