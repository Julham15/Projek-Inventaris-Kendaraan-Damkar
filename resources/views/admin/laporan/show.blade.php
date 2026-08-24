@extends('admin.layouts')
@section('navbar')
<!-- Main Content Area -->
<main class="flex-1 flex flex-col lg:pl-[280px] w-full h-full overflow-hidden relative">
    <!-- TopNavBar -->
    <header class="flex justify-between items-center w-full px-lg py-md bg-white border-b border-outline-variant flex-shrink-0">
        <div class="flex items-center gap-md">
            <button class="lg:hidden text-on-surface-variant hover:text-primary transition-colors p-sm rounded-lg hover:bg-surface-container">
                <span class="material-symbols-outlined" data-icon="menu">menu</span>
            </button>
            <span class="font-h2 text-h2 font-bold text-primary">Detail Laporan</span>
        </div>
        <div class="flex items-center gap-sm">
            <!-- Tambahkan tombol aksi di sini -->
        </div>
    </header>

    <!-- Page Content - Scrollable Area -->
    <div class="flex-1 overflow-y-auto p-lg md:p-margin">
        <!-- Alert Success -->
        @if(session('success'))
        <div class="mb-lg p-md bg-green-50 border border-green-200 rounded-lg flex items-center gap-3">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            <p class="text-green-700 font-body-regular text-body-regular">{{ session('success') }}</p>
        </div>
        @endif

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-lg">
       
            <div class="lg:col-span-2">
                <!-- Card Informasi Laporan -->
                <div class="bg-white rounded-lg border border-outline-variant overflow-hidden mb-lg">
    <div class="p-md bg-surface-container border-b border-outline-variant">
        <h3 class="font-h3 text-h3 text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">description</span>
            Informasi Laporan
        </h3>
    </div>
    <div class="p-lg">
        <!-- Grid 2 kolom tetap -->
        <div class="grid grid-cols-2 gap-x-md gap-y-4">
            <!-- Baris 1 -->
            <div>
                <label class="font-small text-small text-on-surface-variant block mb-1">Pelapor</label>
                <p class="font-body-regular text-body-regular text-on-surface font-semibold">
                   {{ $laporan->user?->name ?? 'Dinonaktifkan'}}
                </p>
            </div>
            <div>
                <label class="font-small text-small text-on-surface-variant block mb-1">Waktu Laporan</label>
                <p class="font-body-regular text-body-regular text-on-surface font-semibold">
                    {{ $laporan->created_at->format('d-m-Y / H:i') }}
                </p>
            </div>

            <!-- Baris 2 -->
            <div>
                <label class="font-small text-small text-on-surface-variant block mb-1">Pos</label>
                <p class="font-body-regular text-body-regular text-on-surface font-semibold">
                   {{$laporan->nama_posko}}
                   
                </p>
            </div>
           
            <div>
                <label class="font-small text-small text-on-surface-variant block mb-1">Nomor Polisi</label>
                <p class="font-body-regular text-body-regular text-on-surface font-semibold">
                    {{ $laporan->kendaraan->nomor_polisi ?? '-' }}
                </p>
            </div>

            <!-- Baris 3 -->
             <div>
                <label class="font-small text-small text-on-surface-variant block mb-1">Jenis Mobil</label>
                <p class="font-body-regular text-body-regular text-on-surface font-semibold">
                    {{ $laporan->kendaraan->jenisMobil->nama_jenis ?? '-' }}
                </p>
            </div>
            <div>
                <label class="font-small text-small text-on-surface-variant block mb-1">Peleton - Regu</label>
                <p class="font-body-regular text-body-regular text-on-surface font-semibold">
                    {{ $laporan->platon->nama }} - {{ $laporan->regu->nama }}
                </p>
            </div>
        </div>
    </div>
</div>
            </div>

            <!-- Kolom Kanan: Update Status -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border border-outline-variant overflow-hidden sticky top-4">
                    <div class="p-md bg-surface-container border-b border-outline-variant">
                        <h3 class="font-h3 text-h3 text-on-surface flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">edit_note</span>
                            Update Status
                        </h3>
                    </div>
                    <div class="p-lg">
                       @if($laporan->user)
    <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div class="space-y-1">
                <label class="font-h4 text-h4 text-on-surface" for="status">
                    Status
                </label>

                <select name="status"
                        id="status"
                        class="w-full px-md py-sm border border-outline-variant rounded-lg font-body-regular focus:ring-2 focus:ring-primary focus:border-transparent transition-all appearance-none bg-white">

                    <option value="Diproses" {{ $laporan->status == 'Diproses' ? 'selected' : '' }}>
                        Diproses
                    </option>

                    <option value="Selesai" {{ $laporan->status == 'Selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>

                    <option value="Diarsipkan" {{ $laporan->status == 'Diarsipkan' ? 'selected' : '' }}>
                        Diarsipkan
                    </option>
                </select>
            </div>

            {{-- Preview status --}}
            {{-- bagian preview kamu tetap di sini --}}

            <button type="submit"
                    class="w-full py-3 rounded-lg bg-primary text-on-primary font-h4 text-h4 hover:opacity-80 transition-colors shadow-sm active:scale-[0.98] flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">save</span>
                Simpan Perubahan
            </button>
        </div>
    </form>
@else
    {{-- User sudah dinonaktifkan --}}
    <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined text-red-600">
                person_off
            </span>

            <div>
                <p class="font-semibold text-red-700">
                    Status laporan dikunci
                </p>

                <p class="text-sm text-red-600 mt-1">
                    User yang membuat laporan ini sudah dinonaktifkan.
                    Status laporan tidak dapat diubah.
                </p>
            </div>
        </div>
    </div>
@endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data Peralatan -->
        <div class="mt-lg bg-white rounded-lg border border-outline-variant shadow-sm overflow-hidden">
            <div class="p-md bg-surface-container border-b border-outline-variant flex justify-between items-center">
                <h3 class="font-h3 text-h3 text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">construction</span>
                    Data Peralatan
                </h3>
                <span class="text-small text-on-surface-variant bg-surface-bright px-3 py-1 rounded-full border border-outline-variant">
                    Total: {{ $laporan->laporanPeralatans->count() }} item
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-primary text-on-primary">
                            <th class="py-sm px-md font-h4 text-h4 w-16 text-center">No</th>
                            <th class="py-sm px-md font-h4 text-h4">Nama Alat</th>
                            <th class="py-sm px-md font-h4 text-h4 w-24 text-center">Jumlah</th>
                            <th class="py-sm px-md font-h4 text-h4 w-40 text-center">Kondisi</th>
                            <th class="py-sm px-md font-h4 text-h4 w-48 text-center">Foto</th>
                            <th class="py-sm px-md font-h4 text-h4 min-w-[200px]">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-variant font-body-regular text-body-regular text-on-surface">
                        @forelse($laporan->laporanPeralatans as $item)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="py-sm px-md text-center">{{ $loop->iteration }}</td>
                            <td class="py-sm px-md font-medium">{{ $item->nama_peralatan }}</td>
                            <td class="py-sm px-md text-center">{{ $item->jumlah }}</td>
                            <td class="py-sm px-md text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($item->kondisi == 'Baik') bg-green-100 text-green-800 border border-green-200
                                    @elseif($item->kondisi == 'Rusak Ringan') bg-yellow-100 text-yellow-800 border border-yellow-200
                                    @elseif($item->kondisi == 'Rusak Berat') bg-red-100 text-red-800 border border-red-200
                                    @else bg-gray-100 text-gray-800 border border-gray-200
                                    @endif">
                                    {{ $item->kondisi }}
                                </span>
                            </td>
                           
                            <td class="py-sm px-md text-center" >

                        @if($item->foto)

                            {{-- Foto tersedia --}}
                            <button onclick="openModal('{{ 'peralatan-'.$item->id }}')"
                                class="inline-flex items-center gap-1 mx-auto px-3 py-2
                                    border border-primary rounded-lg
                                    text-primary hover:bg-primary-container
                                    hover:text-on-primary transition-all duration-200">
                                <span class="material-symbols-outlined text-[20px]">photo</span>
                                <span class="font-small text-small">Lihat</span>
                            </button>

                        @elseif($item->foto_dihapus_admin)

                            {{-- Foto dihapus admin --}}
                            <button onclick="openModal('{{ 'peralatan-'.$item->id }}')"
                                class="inline-flex items-center gap-1 mx-auto px-3 py-2
                                    border border-red-500 rounded-lg
                                    text-red-500 hover:bg-red-500
                                    hover:text-white transition-all duration-200">
                                <span class="material-symbols-outlined text-[20px]">photo</span>
                                <span class="font-small text-small">Lihat</span>
                            </button>

                        @else

                            {{-- User tidak mengupload foto --}}
                            <button onclick="openModal('{{ 'peralatan-'.$item->id }}')"
                                class="inline-flex items-center gap-1 mx-auto px-3 py-2
                                    border border-gray-400 rounded-lg
                                    text-gray-500 hover:bg-gray-200
                                    transition-all duration-200">
                                <span class="material-symbols-outlined text-[20px]">photo</span>
                                <span class="font-small text-small">Lihat</span>
                            </button>

                        @endif

                    </td>
                            <td class="py-sm px-md">
                                {{$item->deskripsi ?? '-'}}
                            </td>
                           
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-sm px-md text-center text-on-surface-variant">
                                <div class="flex flex-col items-center py-8">
                                    <span class="material-symbols-outlined text-4xl text-outline mb-2">inventory_2</span>
                                    <p>Tidak ada data peralatan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Data Kondisi -->
        <div class="mt-lg bg-white rounded-lg border border-outline-variant shadow-sm overflow-hidden">
            <div class="p-md bg-surface-container border-b border-outline-variant flex justify-between items-center">
                <h3 class="font-h3 text-h3 text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">health_metrics</span>
                    Data Kondisi
                </h3>
                <span class="text-small text-on-surface-variant bg-surface-bright px-3 py-1 rounded-full border border-outline-variant">
                    Total: {{ $laporan->laporanKondisis->count() }} item
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-primary text-on-primary">
                            <th class="py-sm px-md font-h4 text-h4 w-16 text-center">No</th>
                            <th class="py-sm px-md font-h4 text-h4">Nama Kondisi</th>
                            <th class="py-sm px-md font-h4 text-h4 w-40 text-center">Status</th>
                            <th class="py-sm px-md font-h4 text-h4 w-48 text-center">Foto</th>
                            <th class="py-sm px-md font-h4 text-h4 min-w-[200px]">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-variant font-body-regular text-body-regular text-on-surface">
                        @forelse($laporan->laporanKondisis as $item)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="py-sm px-md text-center">{{ $loop->iteration }}</td>
                            <td class="py-sm px-md font-medium">{{ $item->nama_kondisi }}</td>
                            <td class="py-sm px-md text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($item->status == 'Baik') bg-green-100 text-green-800 border border-green-200
                                    @elseif($item->status == 'Cukup') bg-yellow-100 text-yellow-800 border border-yellow-200
                                    @elseif($item->status == 'Perlu Perhatian') bg-orange-100 text-orange-800 border border-orange-200
                                    @elseif($item->status == 'Rusak') bg-red-100 text-red-800 border border-red-200
                                    @else bg-gray-100 text-gray-800 border border-gray-200
                                    @endif">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block
                                        @if($item->status == 'Baik') bg-green-500
                                        @elseif($item->status == 'Cukup') bg-yellow-500
                                        @elseif($item->status == 'Perlu Perhatian') bg-orange-500
                                        @elseif($item->status == 'Rusak') bg-red-500
                                        @else bg-gray-500
                                        @endif">
                                    </span>
                                    {{ $item->status }}
                                </span>
                            </td>
                          
                            <td class="py-sm px-md text-center">

                        @if($item->foto)
                            {{-- Foto tersedia --}}
                            <button onclick="openModal('{{ 'kondisi-'.$item->id }}')"
                                class="inline-flex items-center gap-1 mx-auto px-3 py-2
                                    border border-primary rounded-lg
                                    text-primary hover:bg-primary-container
                                    hover:text-on-primary transition-all duration-200">
                                <span class="material-symbols-outlined text-[20px]">photo</span>
                                <span class="font-small text-small">Lihat</span>
                            </button>

                        @elseif($item->foto_dihapus_admin)

                            {{-- Foto dihapus admin --}}
                            <button onclick="openModal('{{ 'kondisi-'.$item->id }}')"
                                class="inline-flex items-center gap-1 mx-auto px-3 py-2
                                    border border-red-500 rounded-lg
                                    text-red-500 hover:bg-red-500
                                    hover:text-white transition-all duration-200">
                                <span class="material-symbols-outlined text-[20px]">photo</span>
                                <span class="font-small text-small">Lihat</span>
                            </button>

                        @else

                            {{-- User tidak mengupload foto --}}
                            <button onclick="openModal('{{ 'kondisi-'.$item->id }}')"
                                class="inline-flex items-center gap-1 mx-auto px-3 py-2
                                    border border-gray-400 rounded-lg
                                    text-gray-500 hover:bg-gray-200
                                    transition-all duration-200">
                                <span class="material-symbols-outlined text-[20px]">photo</span>
                                <span class="font-small text-small">Lihat</span>
                            </button>

                        @endif
                    </td>
                            
                            <td class="py-sm px-md" >
                                {{ $item->deskripsi ?? '-' }}
                            </td>
                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-sm px-md text-center text-on-surface-variant">
                                <div class="flex flex-col items-center py-8">
                                    <span class="material-symbols-outlined text-4xl text-outline mb-2">checklist</span>
                                    <p>Tidak ada data kondisi</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Foto Peralatan -->
    @foreach($laporan->laporanPeralatans as $item)

<div id="peralatan-{{ $item->id }}"
     class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/70 backdrop-blur-sm"
     onclick="closeModal('peralatan-{{ $item->id }}')">
    <div class="max-w-3xl max-h-[90vh] bg-white rounded-xl overflow-hidden shadow-2xl"
         onclick="event.stopPropagation()">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="font-h3">
                {{ $item->nama_peralatan }}
            </h3>
            <button onclick="closeModal('peralatan-{{ $item->id }}')">
                ✕
            </button>
        </div>
        <div class="p-4">

    @if($item->foto)

        <img src="{{ asset('storage/'.$item->foto) }}"
             class="max-w-full max-h-[75vh] object-contain mx-auto rounded-lg">
             <div class="border-t p-4 flex justify-between items-center">
                <div class="flex gap-2">

                    @if($item->foto)

                    <a href="{{ route('admin.laporan-peralatan.download',$item) }}"
                    class="inline-flex items-center gap-2
                            px-4 py-2
                            rounded-lg
                            bg-blue-600
                            text-white
                            hover:bg-blue-700">

                        <span class="material-symbols-outlined text-[20px]">
                            download
                        </span>
                       Download
                  </a>

                    <form action="{{ route('admin.laporan-peralatan.destroy-foto',$item) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus foto ini?')">

                        @csrf
                        @method('DELETE')

                        <button
                            class="inline-flex items-center gap-2
                                px-4 py-2
                                rounded-lg
                                bg-red-600
                                text-white
                                hover:bg-red-700">

                            <span class="material-symbols-outlined text-[20px]">
                                delete
                            </span>

                            Hapus

                        </button>

                    </form>

                    @endif

                    </div>
                </div>
            </div>
            @elseif($item->foto_dihapus_admin)

    <div class="flex flex-col items-center justify-center h-[400px] text-center">
        <span class="material-symbols-outlined text-7xl text-red-400">
            hide_image
        </span>

        <h3 class="mt-4 text-xl font-semibold text-red-600">
            Foto telah dihapus oleh Admin
        </h3>

        <p class="mt-2 text-gray-500">
            File gambar sudah tidak tersedia.
        </p>
    </div>

            @else

                <div class="flex flex-col items-center justify-center h-[400px] text-center">
                    <span class="material-symbols-outlined text-7xl text-gray-400">
                        image_not_supported
                    </span>

                    <h3 class="mt-4 text-xl font-semibold text-gray-700">
                        Foto tidak diunggah
                    </h3>

                    <p class="mt-2 text-gray-500">
                        {{ $laporan->user?->name ?? 'Dinonaktifkan'}} tidak mengunggah foto untuk item ini.
                    </p>
                </div>

            @endif

</div>
    </div>
</div>
@endforeach

    <!-- Modal Foto Kondisi -->
    @foreach($laporan->laporanKondisis as $item)

<div id="kondisi-{{ $item->id }}"
     class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/70 backdrop-blur-sm"
     onclick="closeModal('kondisi-{{ $item->id }}')">

    <div class="max-w-3xl max-h-[90vh] bg-white rounded-xl overflow-hidden shadow-2xl"
         onclick="event.stopPropagation()">

        <div class="flex justify-between items-center p-4 border-b">

            <h3 class="font-h3">

                {{ $item->nama_kondisi }}

            </h3>

            <button onclick="closeModal('kondisi-{{ $item->id }}')">

                ✕

            </button>

        </div>
       
        <div class="p-4">
  @if($item->foto)
            <img src="{{ asset('storage/'.$item->foto) }}"
                 class="max-w-full max-h-[75vh] object-contain mx-auto">
                <div class="border-t p-4 flex justify-between items-center">
                    <div class="flex gap-2">
                    @if($item->foto)
                    <a href="{{ route('admin.laporan-kondisi.download',$item) }}"
                    class="inline-flex items-center gap-2
                            px-4 py-2
                            rounded-lg
                            bg-blue-600
                            text-white
                            hover:bg-blue-700">
                        <span class="material-symbols-outlined text-[20px]">
                            download
                        </span>
                        Download
                    </a>
                    <form action="{{ route('admin.laporan-kondisi.destroy-foto',$item) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                        @csrf
                        @method('DELETE')
                        <button
                            class="inline-flex items-center gap-2
                                px-4 py-2
                                rounded-lg
                                bg-red-600
                                text-white
                                hover:bg-red-700">
                            <span class="material-symbols-outlined text-[20px]">
                                delete
                            </span>
                            Hapus
                        </button>
                    </form>

                    @endif

                    </div>

                    </div>

                 </div>
 @elseif($item->foto_dihapus_admin)

    <div class="flex flex-col items-center justify-center h-[400px] text-center">
        <span class="material-symbols-outlined text-7xl text-red-400">
            hide_image
        </span>

        <h3 class="mt-4 text-xl font-semibold text-red-600">
            Foto telah dihapus oleh Admin
        </h3>

        <p class="mt-2 text-gray-500">
            File gambar sudah tidak tersedia.
        </p>
    </div>

@else

    <div class="flex flex-col items-center justify-center h-[400px] text-center">
        <span class="material-symbols-outlined text-7xl text-gray-400">
            image_not_supported
        </span>

        <h3 class="mt-4 text-xl font-semibold text-gray-700">
            Foto tidak diunggah
        </h3>

        <p class="mt-2 text-gray-500">
           {{ $laporan->user?->name ?? 'Dinonaktifkan'}} tidak mengunggah foto untuk item ini.
        </p>
    </div>

@endif

        </div>

    </div>

</div>

@endforeach

    <style>
        /* Styling untuk modal */
        .modal-open {
            overflow: hidden;
        }

        /* Animasi fade in untuk modal */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1
                transform: scale(1);
            }
        }

        #fotoPeralatan,
        #fotoKondisi {
            animation: fadeIn 0.2s ease-out;
        }

        /* Styling untuk select */
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            padding-right: 2.5rem;
        }

        select:focus {
            outline: none;
        }

       
        

        /* Badge status colors */
        .bg-yellow-100 { background-color: #FEF3C7; }
        .text-yellow-800 { color: #92400E; }
        .border-yellow-200 { border-color: #FDE68A; }
        .bg-yellow-500 { background-color: #EAB308; }

        .bg-green-100 { background-color: #D1FAE5; }
        .text-green-800 { color: #065F46; }
        .border-green-200 { border-color: #A7F3D0; }
        .bg-green-500 { background-color: #22C55E; }

        .bg-gray-100 { background-color: #F3F4F6; }
        .text-gray-800 { color: #1F2937; }
        .border-gray-200 { border-color: #E5E7EB; }
        .bg-gray-500 { background-color: #6B7280; }

        .bg-red-100 { background-color: #FEE2E2; }
        .text-red-800 { color: #991B1B; }
        .border-red-200 { border-color: #FECACA; }
        .bg-red-500 { background-color: #EF4444; }

        .bg-orange-100 { background-color: #FFEDD5; }
        .text-orange-800 { color: #9A3412; }
        .border-orange-200 { border-color: #FED7AA; }
        .bg-orange-500 { background-color: #F97316; }

        /* Min width untuk keterangan */
        .min-w-\[200px\] {
            min-width: 200px;
        }
    </style>

    <script>
        // Fungsi untuk membuka modal
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('modal-open');
            }
        }

        // Fungsi untuk menutup modal
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('modal-open');
            }
        }

        // Tutup modal dengan tombol ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('#fotoPeralatan, #fotoKondisi').forEach(modal => {
                    if (!modal.classList.contains('hidden')) {
                        closeModal(modal.id);
                    }
                });
            }
        });

        // Preview status change
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status');
            const statusPreview = document.getElementById('statusPreview');
            const statusText = document.getElementById('statusText');

            if (statusSelect && statusPreview && statusText) {
                statusSelect.addEventListener('change', function() {
                    const value = this.value;
                    const statusClasses = {
                        'Diproses': 'bg-yellow-100 text-yellow-800 border-yellow-200',
                        'Selesai': 'bg-green-100 text-green-800 border-green-200',
                        'Diarsipkan': 'bg-gray-100 text-gray-800 border-gray-200'
                    };
                    
                    const dotClasses = {
                        'Diproses': 'bg-yellow-500',
                        'Selesai': 'bg-green-500',
                        'Diarsipkan': 'bg-gray-500'
                    };
                    
                    statusPreview.className = `inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusClasses[value] || 'bg-gray-100 text-gray-800 border-gray-200'}`;
                    const dot = statusPreview.querySelector('.w-1\\.5');
                    if (dot) {
                        dot.className = `w-1.5 h-1.5 rounded-full mr-1.5 inline-block ${dotClasses[value] || 'bg-gray-500'}`;
                    }
                    statusText.textContent = value;
                });
            }

            // Auto-hide success message after 5 seconds
            setTimeout(function() {
                const successAlert = document.querySelector('.bg-green-50');
                if (successAlert) {
                    successAlert.style.transition = 'opacity 0.5s';
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.style.display = 'none', 500);
                }
            }, 5000);
        });
    </script>
</main>
@endsection