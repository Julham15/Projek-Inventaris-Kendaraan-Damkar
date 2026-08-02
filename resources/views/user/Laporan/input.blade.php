<h1>Export PDF Laporan Hari Ini</h1>

<form method="POST" action="{{ route('laporan.export.pdf') }}">

    @csrf

    <div>
        <label>Nama Pengawas</label>
        <br>

        <input type="text"
               name="nama_pengawas"
               required>
    </div>

    <br>

    <div>
        <label>Jabatan Penanggung Jawab</label>
        <br>

        <input type="text"
               name="jabatan_penanggung_jawab"
               required>
    </div>

    <br>

    <div>
        <label>Nama Penanggung Jawab</label>
        <br>

        <input type="text"
               name="nama_penanggung_jawab"
               required>
    </div>

    <br>

    <button type="submit">
        Export PDF
    </button>

</form>