<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>

        body{
            font-family:'Times New Roman', Times, serif;
            font-size:12px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }
       

        table,th,td{
            border:1px solid black;
        }

        .kapital{
            text-transform: lowercase;
        }
        .kapital::first-letter{
            text-transform: uppercase;
        }

        th,td{
            padding:3px;
            text-align:center;
            vertical-align:middle;
            text-transform: capitalize;
        }

        .header{
            text-align:center;
        }

        .header h2{
            margin-bottom:0;
        }

        .logo{
            margin-top:-5px;
        }
        .logo-kiri{
            margin-top: 3px;
            width: 60px;
            height:64px;
            left: 25px;
            position:absolute;
            margin-bottom: 0;
        }
        .logo-kanan{
            width:70px;
            height:70px;
            position:absolute;
            right:20px;
        }

        .judul{
            text-align:center;
            margin-top:10px;
            margin-bottom:20px;
        }

        .info{
            margin-bottom:15px;
        }

        .info td{
            border:none;
            text-align:left;
            padding:2px;
        }

        .foto-besar{
            width:auto;
            height:150px;
            object-fit:contain;
        }

        .footer{
            width:100%;
            margin-top:70px;
        }

        .ttd-kiri{
            width:40%;
            float:left;
            text-align:center;
            
        }

        .ttd-kanan{
            width:40%;
            float:right;
            text-align:center;
        }

        .nama-ttd{
            margin-top:70px;
            font-weight:bold;
           
        }

        hr{
            border:1px solid black;
        }

    </style>

</head>

<body>

<div class="logo">

    <img src="{{ public_path('assets/damkar.png') }}" class="logo-kiri">

    <img src="{{ public_path('assets/logo.png') }}" class="logo-kanan">

</div>

<div class="header">

    <h2>DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN</h2>

    <h2 style="margin-top: -0%;">KOTA AMBON</h2>

</div>

<hr>

@yield('content')

<div class="footer">
    <div style="text-align: center; margin-top: -4%;">
        <p>Pelapor</p>
        <p class="nama-ttd">{{ $laporan->user->name }}</p>
         <p>Mengetahui</p>
    </div>
    <div class="ttd-kiri">
        <p>{{ $jabatan_penanggung_jawab }}</p>

        <p class="nama-ttd">{{ucwords (strtolower(trim($nama_penanggung_jawab))) }}</p>
    </div>
    <div class="ttd-kanan">
        <p>Pengawas</p>

        <p class="nama-ttd">
            {{ucwords (strtolower(trim( $nama_pengawas ))) }}
        </p>
    </div>
</div>
</body>
</html>