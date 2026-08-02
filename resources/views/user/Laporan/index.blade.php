@extends('user.layouts.index')
@section('user')
    <!-- Main Content - Mobile First -->
    <main class="px-4 py-4 pb-24 max-w-full space-y-5 sm:px-6 md:px-8 lg:ml-64 lg:max-w-7xl lg:mx-auto lg:space-y-7">
        <!-- Header -->
        <section class="mt-2">
            <h1 class="text-2xl font-bold text-primary md:text-3xl lg:text-h1">Data Laporan Saya</h1>
            <p class="text-sm text-on-surface-variant mt-1 md:text-base lg:text-body-regular">Kelola dan pantau laporan kendaraan serta peralatan Anda.</p>
        </section>

        <!-- Action Buttons -->
        <section>
            <div class="flex flex-col items-stretch gap-3 sm:flex-row sm:items-center sm:gap-4">
                @if(auth()->user()->platon_id && auth()->user()->regu_id)
                    <a href="{{ route('laporan.create') }}"
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary text-on-primary rounded-lg hover:bg-primary-hover hover:scale-105 hover:shadow-lg transition-all duration-300 font-medium text-sm md:text-base md:px-6 md:py-3">
                        <span class="material-symbols-outlined text-base md:text-xl">add</span>
                        Buat Laporan
                    </a>
                @else
                    <button
                        type="button"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-surface-container-lowest border-2 border-outline-variant rounded-lg text-on-surface-variant opacity-60 cursor-not-allowed text-sm md:text-base md:px-6 md:py-3"
                        onclick="alert('Anda belum ditempatkan pada Platon dan Regu oleh Admin. Silakan hubungi Admin.')">
                        <span class="material-symbols-outlined text-base md:text-xl">add</span>
                        Buat Laporan
                    </button>
                @endif
            </div>
        </section>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 rounded-md flex items-center gap-3 md:p-4">
                <span class="material-symbols-outlined text-green-500 text-lg">check_circle</span>
                <span class="text-sm md:text-base">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Card View untuk Mobile, Table untuk Desktop -->
        <section>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <!-- Mobile Card View -->
                <div class="block lg:hidden divide-y divide-outline-variant/30">
                    @forelse($laporans as $laporan)
                        <div class="p-4 space-y-3 hover:bg-surface-container-hover transition-colors">
                            <!-- Header Card -->
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-sm font-semibold text-on-surface">#{{ $loop->iteration }}</span>
                                        @if($laporan->status == 'Diproses')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-warning/10 text-warning rounded-full text-xs font-medium">
                                                <span class="w-1.5 h-1.5 bg-warning rounded-full animate-pulse"></span>
                                                Diproses
                                            </span>
                                        @elseif($laporan->status == 'Selesai')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-success/10 text-success rounded-full text-xs font-medium">
                                                <span class="w-1.5 h-1.5 bg-success rounded-full"></span>
                                                Selesai
                                            </span>
                                        @elseif($laporan->status == 'Diarsipkan')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-surface-container/50 text-on-surface-variant rounded-full text-xs font-medium">
                                                <span class="w-1.5 h-1.5 bg-on-surface-variant rounded-full"></span>
                                                Diarsipkan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-error/10 text-error rounded-full text-xs font-medium">
                                                <span class="w-1.5 h-1.5 bg-error rounded-full"></span>
                                                Ditolak
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-on-surface font-medium">{{ $laporan->kendaraan->nomor_polisi }}</p>
                                </div>
                                <span class="text-xs text-on-surface-variant/60">
                                    {{ $laporan->created_at->format('d-m-Y') }}
                                </span>
                            </div>

                            <!-- Detail Card -->
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <p class="text-xs text-on-surface-variant/60">Pos</p>
                                    <p class="text-on-surface font-medium">{{ $laporan->nama_posko }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-on-surface-variant/60">Peleton / Regu</p>
                                    <p class="text-on-surface font-medium">{{ $laporan->platon->nama ?? '-' }}/{{ $laporan->regu->nama ?? '-' }}</p>
                                </div>
                            </div>

                            <!-- Statistik Kondisi -->
                            <div class="flex gap-4">
                                <div class="flex items-center gap-1">
                                    <span class="inline-flex items-center justify-center w-6 h-6 bg-error/10 text-error rounded-full text-xs font-bold">
                                        {{ $laporan->laporanPeralatans->where('kondisi', 'Rusak Berat')->count() }}
                                    </span>
                                    <span class="text-xs text-on-surface-variant">Rusak</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="inline-flex items-center justify-center w-6 h-6 bg-warning/10 text-warning rounded-full text-xs font-bold">
                                        {{ $laporan->laporankondisis->where('status', 'Perlu Perhatian')->count() }}
                                    </span>
                                    <span class="text-xs text-on-surface-variant">Bermasalah</span>
                                </div>
                            </div>

                            <!-- Aksi -->
                            <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-outline-variant/30">
                                <a href="{{ route('laporan.show', $laporan->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary-container/20 text-primary rounded-lg text-xs font-medium hover:bg-primary-container/30 transition-colors">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                    Detail
                                </a>
                                @if($laporan->user_id == auth()->id() && $laporan->status == 'Diproses')
                                    <a href="{{ route('laporan.edit', $laporan) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-warning/20 text-warning rounded-lg text-xs font-medium hover:bg-warning/30 transition-colors">
                                        <span class="material-symbols-outlined text-sm">edit</span>
                                        Edit
                                    </a>
                                @endif
                                <div class="flex items-center gap-1 ml-auto">
                                    <a href="{{ route('laporan.export.peralatan.form', $laporan) }}"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-primary text-on-primary rounded-lg text-xs font-medium hover:bg-primary-hover transition-colors">
                                        <span class="material-symbols-outlined text-sm">picture_as_pdf</span>
                                        Peralatan
                                    </a>
                                    <a href="{{ route('laporan.export.kondisi.form', $laporan) }}"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-success text-on-success rounded-lg text-xs font-medium hover:bg-success-hover transition-colors">
                                        <span class="material-symbols-outlined text-sm">picture_as_pdf</span>
                                        Kondisi
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-on-surface-variant/60">
                            <div class="flex flex-col items-center gap-3">
                                <span class="material-symbols-outlined text-5xl opacity-40">inbox</span>
                                <p class="text-base font-medium">Belum ada laporan</p>
                                <p class="text-sm">Mulai buat laporan pertama Anda</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-surface-container text-center border-b border-outline-variant">
                            <tr>
                                <th class="px-4 py-3 text-xs font-bold text-on-surface-variant uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Pos</th>
                                <th class="px-4 py-3 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Peleton / Regu</th>
                                <th class="px-4 py-3 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Nomor Polisi</th>
                                <th class="px-4 py-3 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Peralatan Rusak</th>
                                <th class="px-4 py-3 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Kondisi Bermasalah</th>
                                <th class="px-4 py-3 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Waktu Lapor</th>
                                <th class="px-4 py-3 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Aksi</th>
                                <th class="px-4 py-3 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Ekspor PDF</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/30">
                            @forelse($laporans as $laporan)
                                <tr class="hover:bg-surface-container-hover transition-colors">
                                    <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $laporan->nama_posko }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $laporan->platon->nama ?? '-' }}/{{ $laporan->regu->nama ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm font-medium">{{ $laporan->kendaraan->nomor_polisi }}</td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-error/10 text-error rounded-full text-xs font-bold">
                                            {{ $laporan->laporanPeralatans->where('kondisi', 'Rusak Berat')->count() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-warning/10 text-warning rounded-full text-xs font-bold">
                                            {{ $laporan->laporankondisis->where('status', 'Perlu Perhatian')->count() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">{{ $laporan->created_at->format('d-m-Y') }}</td>
                                    <td class="px-4 py-3">
                                        @if($laporan->status == 'Diproses')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-warning/10 text-warning rounded-full text-xs font-medium">
                                                <span class="w-2 h-2 bg-warning rounded-full animate-pulse"></span>
                                                Diproses
                                            </span>
                                        @elseif($laporan->status == 'Selesai')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-success/10 text-success rounded-full text-xs font-medium">
                                                <span class="w-2 h-2 bg-success rounded-full"></span>
                                                Selesai
                                            </span>
                                        @elseif($laporan->status == 'Diarsipkan')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-surface-container/50 text-on-surface-variant rounded-full text-xs font-medium">
                                                <span class="w-2 h-2 bg-on-surface-variant rounded-full"></span>
                                                Diarsipkan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-error/10 text-error rounded-full text-xs font-medium">
                                                <span class="w-2 h-2 bg-error rounded-full"></span>
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <a href="{{ route('laporan.show', $laporan->id) }}"
                                               class="inline-flex items-center gap-1 px-3 py-1 bg-primary-container/20 text-primary rounded-md text-xs hover:bg-primary-container/30 transition-colors">
                                                <span class="material-symbols-outlined text-sm">visibility</span>
                                                Detail
                                            </a>
                                            @if($laporan->user_id == auth()->id() && $laporan->status == 'Diproses')
                                                <a href="{{ route('laporan.edit', $laporan) }}"
                                                   class="inline-flex items-center gap-1 px-3 py-1 bg-warning/20 text-warning rounded-md text-xs hover:bg-warning/30 transition-colors">
                                                    <span class="material-symbols-outlined text-sm">edit</span>
                                                    Edit
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <a href="{{ route('laporan.export.peralatan.form', $laporan) }}"
                                               class="inline-flex items-center gap-1 px-3 py-1 bg-primary text-on-primary rounded-md text-xs hover:bg-primary-hover transition-colors">
                                                <span class="material-symbols-outlined text-sm">picture_as_pdf</span>
                                                Peralatan
                                            </a>
                                            <a href="{{ route('laporan.export.kondisi.form', $laporan) }}"
                                               class="inline-flex items-center gap-1 px-3 py-1 bg-success text-on-success rounded-md text-xs hover:bg-success-hover transition-colors">
                                                <span class="material-symbols-outlined text-sm">picture_as_pdf</span>
                                                Kondisi
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-4 py-8 text-center text-on-surface-variant/60">
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="material-symbols-outlined text-4xl opacity-40">inbox</span>
                                            <p class="text-sm">Belum ada laporan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
@endsection