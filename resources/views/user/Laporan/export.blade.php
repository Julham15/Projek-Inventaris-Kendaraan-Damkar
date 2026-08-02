<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>Laporan Harian Kendaraan</title>

    <style>

        body{
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
        }

        table{
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td{
            border: 1px solid black;
        }

        th, td{
            padding: 3px;
            text-align: center;
            vertical-align: middle;
        }

        .header{
            text-align: center;
        }

        .header h2{
            margin-bottom: 0;
        }

        .header h3{
            margin-top: 5px;
        }
        .logo{
            margin-top: -5px;
        }
        .logo-kiri{
            width: 70px;
            position: absolute;
            height: 70px;
            left: 20px;
        }

        .logo-kanan{
            width: 70px;
            position: absolute;
            height: 70px;
            right: 20px;
        }

        .judul{
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .tanggal{
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .foto{
            width: 40px;
            height: 25px;
            object-fit: cover;
        }

        .footer{
            width: 100%;
            margin-top: 70px;
        }

        .ttd-kiri{
            margin-top:-3.5%;
            width: 40%;
            float: left;
            text-align: center;
        }

        .ttd-kanan{
            width: 40%;
            float: right;
            text-align: center;
        }

        .nama-ttd{
            margin-top: 70px;
            font-weight: bold;
            text-transform: capitalize;
        }

        hr{
            border: 1px solid black;
        }

        tbody{
            text-align: center;
        }

    </style>
</head>

<body>

    {{-- LOGO --}}
   <div class="logo">
    <img src="{{ public_path('assets/logo1.png') }}"
         class="logo-kiri">

    <img src="{{ public_path('assets/DAMKAR.png') }}"
         class="logo-kanan">
   </div>
    {{-- HEADER --}}
    <div class="header">

        <h2>
            DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN
        </h2>

        <h2 style="margin-top: -0%;">
            KOTA AMBON
        </h2>

    </div>

    <hr>

    {{-- JUDUL --}}
    <div class="judul">

        <h3>
            LAPORAN HARIAN KENDARAAN
        </h3>

    </div>

    {{-- TANGGAL --}}
    <div class="tanggal">

        <strong>
            Tanggal :
        </strong>

        Ambon,
       {{ \Carbon\Carbon::now('Asia/Jayapura')->locale('id')->translatedFormat('d F Y') }}
        <span style="float: right; font-weight: bold;" >{{ $laporans->first()->platon->nama ?? '-' }} / Regu {{ $laporans->first()->regu->nama ?? '-' }}</span>
    </div>

    {{-- TABEL --}}
    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>Kendaraan</th>
                <th>Peralatan<br>Rusak</th>
                <th>Kondisi<br>Bermasalah</th>
                <th>Keterangan</th>
                <th>Foto</th>
            </tr>

        </thead>

        <tbody>

            @forelse($laporans as $laporan)

            <tr>

                <td>
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $laporan->kendaraan->nomor_polisi }}
                </td>

                <td>
                    {{ $peralatanRusakHarian }}
                </td>
                <td>
                    {{ $kondisiBermasalahHarian }}
                </td>

                <td style="text-align: left;">
                    {{ $laporan->deskripsi }}
                </td>

                <td>

                    @if($laporan->foto)

                        <img src="{{ public_path('storage/' . $laporan->foto) }}"
                             class="foto">

                    @else

                        Tidak Ada Foto

                    @endif

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="6">
                    Tidak ada laporan hari ini
                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

    {{-- FOOTER TTD --}}
    <div class="footer">

        {{-- PENGAWAS --}}
        <div class="ttd-kiri">
            <p>
               Penanggung Jawab
            </p>
            <p>
                {{ $jabatan_penanggung_jawab }}
            </p>

            <p class="nama-ttd">
                {{ $nama_penanggung_jawab }}
            </p>
            

        </div>

        {{-- PENANGGUNG JAWAB --}}
        <div class="ttd-kanan">
            <p>
                Pengawas
            </p>

            <p class="nama-ttd">
                {{ $nama_pengawas }}
            </p>
        </div>

    </div>

</body>
</html>