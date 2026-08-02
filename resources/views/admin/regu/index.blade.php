<form method="POST" action="{{ route('regu.store') }}">
    @csrf

    <select name="platon_id">
        <option value="">Pilih Platon</option>

        @foreach($platons as $platon)
            <option value="{{ $platon->id }}">
                {{ $platon->nama }}
            </option>
        @endforeach
    </select>

    <input
        type="text"
        name="nama"
        placeholder="Nama Regu">

    <button type="submit">
        Simpan
    </button>
</form>
<table>
    <thead>
        <tr>
            <th>Platon</th>
            <th>Regu</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($regus as $regu)
        <tr>

            <td>
                {{ $regu->platon->nama }}
            </td>

            <td>
                {{ $regu->nama }}
            </td>

            <td>

                <form method="POST"
                      action="{{ route('regu.destroy', $regu) }}">

                    @csrf
                    @method('DELETE')

                    <button>
                        Hapus
                    </button>

                </form>

            </td>

        </tr>
        @endforeach
    </tbody>
</table>