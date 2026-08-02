@extends('Pemantau.layouts.index')
@section('admin2')

<!-- ===== WELCOME ===== -->
<div class="mb-xl p-lg bg-primary-container/10 border border-primary-container/30 rounded-xl">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-h1 text-h1 text-primary mb-xs">Detail Laporan Peralatan & Kondisi</h1>
            <p class="font-body-regular text-body-regular text-on-surface-variant max-w-3xl">Informasi lengkap mengenai peralatan rusak dan kondisi kendaraan yang dilaporkan.</p>
        </div>
        <a href="{{ route('pemantau.laporan.index') }}" 
           class="inline-flex items-center gap-xs px-lg py-sm bg-surface-container-low text-on-surface-variant rounded-lg hover:bg-surface-container-high transition-colors font-body-regular">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali
        </a>
    </div>
</div>

<!-- ===== DETAIL LAPORAN ===== -->
<div class="flex justify-center my-4">
    <h2 class="text-h2 text-center w-[200px] border border-primary from-secondary to-secondary/60 font-bold py-3 px-4 rounded-xl ">
        {{ $laporan->kendaraan->nomor_polisi }}
    </h2>
</div>

<div class="bg-white rounded-lg border border-outline-variant overflow-hidden">
    <div class="p-md bg-surface-container border-b border-outline-variant">
        <h3 class="font-h3 text-h3 text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">description</span>
            Detail Laporan
        </h3>
    </div>
    <div class="p-lg text-center">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="space-y-1">
            <label class="font-small text-small text-on-surface-variant">Pelapor</label>
            <p class="font-body-regular text-body-regular text-on-surface font-semibold truncate">{{ $laporan->user?->name ?? 'Dinonaktifkan' }}</p>
        </div>
        <div class="space-y-1">
            <label class="font-small text-small text-on-surface-variant">Waktu Laporan</label>
            <p class="font-body-regular text-body-regular text-on-surface font-semibold">{{ $laporan->created_at->format('d-m-Y / H:i') }}</p>
        </div>
        <div class="space-y-1">
            <label class="font-small text-small text-on-surface-variant">Status</label>
            <div class="text-body-regular font-semibold">
                @if($laporan->status == 'Diproses')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary border border-primary/20">
                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-primary"></span>
                        Diproses
                    </span>
                @elseif($laporan->status == 'Selesai')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-green-500"></span>
                        Selesai
                    </span>
                @elseif($laporan->status == 'Diarsipkan')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-surface-container/50 text-on-surface-variant border border-outline-variant">
                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-on-surface-variant"></span>
                        Diarsipkan
                    </span>
                @endif
            </div>
        </div>
        <div class="space-y-1">
            <label class="font-small text-small text-on-surface-variant">Pos</label>
            <p class="font-body-regular text-body-regular text-on-surface font-semibold truncate">{{ $laporan->nama_posko }}</p>
        </div>
        <div class="space-y-1">
            <label class="font-small text-small text-on-surface-variant">Peleton - Regu</label>
            <p class="font-body-regular text-body-regular text-on-surface font-semibold truncate">  {{ $laporan->platon->nama }} - {{ $laporan->regu->nama }}</p>
        </div>
    </div>
</div>
</div>

<!-- ===== DATA PERALATAN ===== -->
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

    @if($laporan->laporanPeralatans->count())
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-primary text-on-primary">
                    <th class="py-sm px-md font-h4 text-h4 w-16 text-center">No</th>
                    <th class="py-sm px-md font-h4 w-[200px] text-center text-h4">Nama Alat</th>
                     <th class="py-sm px-md font-h4 text-h4 w-25 text-center">Jumlah <br> Real</th>
                    <th class="py-sm px-md font-h4 text-h4 w-25 text-center">Jumlah <br> Dilaporkan</th>
                    <th class="py-sm px-md font-h4 text-h4 w-40 text-center">Kondisi</th>
                    <th class="py-sm px-md font-h4 text-h4 w-48 text-center">Foto</th>
                    <th class="py-sm px-md font-h4 text-h4 min-w-[200px]">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-variant font-body-regular text-body-regular text-center text-on-surface">
                @foreach($laporan->laporanPeralatans as $item)
                <tr class="hover:bg-surface transition-colors">
                    <td class="py-sm px-md text-center">{{ $loop->iteration }}</td>
                    <td class="py-sm px-md font-medium">{{ $item->nama_peralatan }}</td>
                    <td class="py-sm px-md text-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/10 text-primary font-bold">
                             {{ $item->jumlah_awal }}

                        </span>
                    </td>
                     <td class="py-sm px-md text-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/10 text-primary font-bold">
                            {{ $item->jumlah }}
                        </span>
                    </td>
                    <td class="py-sm px-md text-center">
                        @if($item->kondisi == 'Baik')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-green-500"></span>
                                {{ $item->kondisi }}
                            </span>
                        @elseif($item->kondisi == 'Rusak Ringan')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-yellow-500"></span>
                                {{ $item->kondisi }}
                            </span>
                        @elseif($item->kondisi == 'Rusak Berat')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-red-500"></span>
                                {{ $item->kondisi }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-gray-500"></span>
                                {{ $item->kondisi }}
                            </span>
                        @endif
                    </td>
                    <td class="py-sm px-md text-center">
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
                  
                    <td class="py-sm px-md text-left">
                        {{$item->deskripsi ?? '-'}}
                    </td>
                  
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-xl text-center text-on-surface-variant">
        <div class="flex flex-col items-center py-8">
            <span class="material-symbols-outlined text-4xl text-outline mb-2">inventory_2</span>
            <p>Tidak ada data peralatan</p>
        </div>
    </div>
    @endif
</div>

<!-- ===== DATA KONDISI ===== -->
<div class="mt-lg bg-white rounded-lg border border-outline-variant shadow-sm overflow-hidden">
    <div class="p-md bg-surface-container border-b border-outline-variant flex justify-between items-center">
        <h3 class="font-h3 text-h3 text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">health_metrics</span>
            Data Kondisi Kendaraan
        </h3>
        <span class="text-small text-on-surface-variant bg-surface-bright px-3 py-1 rounded-full border border-outline-variant">
            Total: {{ $laporan->laporanKondisis->count() }} item
        </span>
    </div>

    @if($laporan->laporanKondisis->count())
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-primary text-on-primary">
                    <th class="py-sm px-md font-h4 text-h4 w-16 text-center">No</th>
                    <th class="py-sm px-md font-h4 text-h4  text-center">Nama Kondisi</th>
                    <th class="py-sm px-md font-h4 text-h4  text-center">Status</th>
                    <th class="py-sm px-md font-h4 text-h4  text-center">Foto</th>
                    <th class="py-sm px-md font-h4 text-h4 min-w-[200px]">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-variant text-center font-body-regular text-body-regular text-on-surface">
                @foreach($laporan->laporanKondisis as $item)
                <tr class="hover:bg-surface transition-colors">
                    <td class="py-sm px-md text-center">{{ $loop->iteration }}</td>
                    <td class="py-sm px-md font-medium">{{ $item->nama_kondisi }}</td>
                    <td class="py-sm px-md text-center">
                        @if($item->status == 'Baik')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-green-500"></span>
                                {{ $item->status }}
                            </span>
                        @elseif($item->status == 'Perlu Perhatian')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-yellow-500"></span>
                                {{ $item->status }}
                            </span>
                        @elseif($item->status == 'Rusak')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-red-500"></span>
                                {{ $item->status }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-gray-500"></span>
                                {{ $item->status }}
                            </span>
                        @endif
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
                     
                    <td class="py-sm text-left px-md">
                        {{ $item->deskripsi ?? '-' }}
                    </td>
                 
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-xl text-center text-on-surface-variant">
        <div class="flex flex-col items-center py-8">
            <span class="material-symbols-outlined text-4xl text-outline mb-2">checklist</span>
            <p>Tidak ada data kondisi</p>
        </div>
    </div>
    @endif
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
                 class="max-w-full max-h-[75vh] object-contain mx-auto">
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
            @if ($item->foto)
                
            <img src="{{ asset('storage/'.$item->foto) }}"
                 class="max-w-full max-h-[75vh] object-contain mx-auto">
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
            opacity: 1;
            transform: scale(1);
        }
    }

    #fotoPeralatan,
    #fotoKondisi {
        animation: fadeIn 0.2s ease-out;
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

    // Tutup modal jika klik di luar area modal (already handled by onclick on backdrop)
    // Tutup modal dengan klik tombol close (already handled by onclick on close button)
</script>
@endsection