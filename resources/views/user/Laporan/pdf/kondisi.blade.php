@extends('user.laporan.pdf.coba')
@section('content')
<div class="judul">

    <h3>
        LAPORAN PEMERIKSAAN KONDISI KENDARAAN
    </h3>

</div>
<table class="info">

    <tr>

        <td width="18%"><strong>Tanggal</strong></td>
        <td width="32%">
            : {{ $laporan->created_at->locale('id')->translatedFormat('d F Y') }}
        </td>

        <td width="18%"><strong>Pos</strong></td>
        <td>
            : {{ $laporan->nama_posko }}
        </td>

    </tr>

    <tr>

        <td><strong>Pelapor</strong></td>
        <td>
            : {{ $laporan->user->name }}
        </td>

        <td><strong>Platon / Regu</strong></td>
        <td>
            : {{ $laporan->platon->nama ?? '-' }}/{{ $laporan->regu->nama ?? '-' }}
        </td>

    </tr>

    <tr>

        <td><strong>Kendaraan</strong></td>
        <td>
            : {{ $laporan->kendaraan->nomor_polisi }}
        </td>

        <td></td>
        <td></td>

    </tr>

</table>
<table>

    <thead>

        <tr>

            <th >No</th>

            <th>Nama Kondisi</th>

            <th>Status</th>
            <th>Keterangan</th>

        </tr>

    </thead>

    <tbody>

    @forelse($laporan->laporanKondisis as $kondisi)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td>

                {{ $kondisi->nama_kondisi }}

            </td>

          <td>
    @if($kondisi->status == 'Baik')
        <span style="
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.2rem 0.7rem;
            color: rgb(1, 50, 19);
            border-radius: 10px;
        ">
            <span style="
                width: 5px;
                height: 5px;
                background-color: rgb(34, 197, 94);
                border-radius: 9999px;
                display: inline-block;
            "></span>
            {{ $kondisi->status }}
        </span>
    @elseif($kondisi->status == 'Perlu Perhatian')
        <span style="
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.2rem 0.7rem;
            
            color: rgb(72, 46, 2);
            border-radius: 10px;
           
        ">
            <span style="
                width: 5px;
                height: 5px;
                background-color: rgb(245, 11, 11);
                border-radius: 9999px;
                display: inline-block;
               
            "></span>
            {{ $kondisi->status }}
        </span>
    @else
        <span style="
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.75rem;
           
            color: rgb(0, 0, 0);
            border-radius: 10px;
           
        ">
            <span style="
                width: 5px;
                height: 5px;
                background-color: rgb(100, 116, 139);
                border-radius: 9999px;
                display: inline-block;
            "></span>
            {{ $kondisi->status }}
        </span>
    @endif
</td>
            
       <td style="text-align:left; vertical-align:top;" >
            {{$kondisi->deskripsi }}
        </td>
  
        </tr>
        
    @empty

        <tr>

            <td colspan="5">

                Tidak ada data.

            </td>

        </tr>

    @endforelse
<tr>
    <th colspan="4">
        Foto Pemeriksaan
    </th>
</tr>

<tr>
    <td colspan="4" style="padding:10px; text-align: center;">

        @php
            $fotos = $laporan->laporanKondisis->filter(function ($kondisi) {
                return !empty($kondisi->foto);
            })->values();
        @endphp

        @if($fotos->count())

            @foreach($fotos->chunk(5) as $chunk)

                <table width="100%" style="margin-bottom:15px; border:none;">
                    <tr>

                        @php
                            $jumlah = $chunk->count();
                            $kosongKiri = floor((5 - $jumlah) / 2);
                            $kosongKanan = 5 - $jumlah - $kosongKiri;
                        @endphp

                        {{-- Kolom kosong kiri --}}
                        @for($i=0; $i<$kosongKiri; $i++)
                            <td width="20%" style="border:none;"></td>
                        @endfor

                        {{-- Foto --}}
                        @foreach($chunk as $foto)

                            <td width="20%"
                                style="border:none;
                                       text-align:center;
                                       vertical-align:top;
                                       padding:5px;">

                                <img
                                    src="{{ public_path('storage/'.$foto->foto) }}"
                                    style="
                                        width:110px;
                                        height:90px;
                                        object-fit:cover;
                                        border:1px solid #444;
                                        padding:2px;
                                    ">

                                <br>

                                <span style="font-size:10px;">
                                    {{ $foto->nama_kondisi }}
                                </span>

                            </td>

                        @endforeach

                        {{-- Kolom kosong kanan --}}
                        @for($i=0; $i<$kosongKanan; $i++)
                            <td width="20%" style="border:none;"></td>
                        @endfor

                    </tr>
                </table>

            @endforeach

        @else

            <div style="text-align:center;">
                Tidak ada foto.
            </div>

        @endif

    </td>
</tr>
    </tbody>

</table>
<br>

<br>
@endsection
