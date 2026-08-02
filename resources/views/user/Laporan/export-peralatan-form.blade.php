@extends('user.layouts.index')
@section('user')
    <!-- Main Content -->
    <main class="lg:ml-64 p-lg max-w-7xl mx-auto space-y-xl">
        <!-- Header -->
        <section class="mt-md">
            <h1 class="font-h1 text-h1 text-primary mb-xs">Export PDF Peralatan</h1>
            <p class="text-on-surface-variant font-body-regular text-body-regular">Ekspor laporan peralatan ke dalam format PDF.</p>
        </section>

        <!-- Success/Error Message -->
        @if(session('error'))
            <div class="bg-error/10 border-l-4 border-error text-error p-md rounded-md flex items-center gap-md">
                <span class="material-symbols-outlined text-error">error</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Card Informasi Laporan -->
        <section>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden">
                <div class="p-lg">
                    <h3 class="font-semibold text-body-large text-on-surface mb-md">
                        Informasi Laporan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-6">
                        <div class="flex items-center gap-2">
                            <span class="text-on-surface-variant font-medium min-w-[120px]">Pos</span>
                            <span class="text-on-surface">: {{ $laporan->nama_posko }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-on-surface-variant font-medium min-w-[120px]">Peleton - Regu</span>
                            <span class="text-on-surface">: {{ $laporan->platon->nama }} - {{ $laporan->regu->nama }}</span>
                        </div>

                       

                        <div class="flex items-center gap-2">
                            <span class="text-on-surface-variant font-medium min-w-[120px]">Waktu Lapor</span>
                            <span class="text-on-surface">: {{ $laporan->created_at->format('d-m-Y') }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-on-surface-variant font-medium min-w-[120px]">Kendaraan</span>
                            <span class="text-on-surface">: {{ $laporan->kendaraan->nomor_polisi }}</span>
                        </div>
                    </div>

                    <hr class="my-lg border-outline-variant/30">

                    <form method="POST"
                          action="{{ route('laporan.export.peralatan', $laporan) }}"
                          class="space-y-md">

                        @csrf

                        <div class="space-y-2">
                            <label for="nama_pengawas" class="block text-small font-medium text-on-surface-variant">
                                Nama Pengawas
                            </label>
                            <input
                                type="text"
                                id="nama_pengawas"
                                name="nama_pengawas"
                                value="{{ old('nama_pengawas') }}"
                                class="w-full px-md py-2 bg-surface-container border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-on-surface placeholder:text-on-surface-variant/50 transition-all"
                                placeholder="Masukkan nama pengawas"
                                required>
                            @error('nama_pengawas')
                                <p class="text-small text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="nama_penanggung_jawab" class="block text-small font-medium text-on-surface-variant">
                                Nama Penanggung Jawab
                            </label>
                            <input
                                type="text"
                                id="nama_penanggung_jawab"
                                name="nama_penanggung_jawab"
                                value="{{ old('nama_penanggung_jawab') }}"
                                class="w-full px-md py-2 bg-surface-container border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-on-surface placeholder:text-on-surface-variant/50 transition-all"
                                placeholder="Masukkan nama penanggung jawab"
                                required>
                            @error('nama_penanggung_jawab')
                                <p class="text-small text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="jabatan_penanggung_jawab" class="block text-small font-medium text-on-surface-variant">
                                Jabatan Penanggung Jawab
                            </label>
                            <input
                                type="text"
                                id="jabatan_penanggung_jawab"
                                name="jabatan_penanggung_jawab"
                                value="{{ old('jabatan_penanggung_jawab') }}"
                                class="w-full px-md py-2 bg-surface-container border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-on-surface placeholder:text-on-surface-variant/50 transition-all"
                                placeholder="Masukkan jabatan penanggung jawab"
                                required>
                            @error('jabatan_penanggung_jawab')
                                <p class="text-small text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap items-center gap-md pt-md">
                            <a href="{{ route('laporan.index') }}"
                               class="inline-flex items-center gap-1 px-md py-2 bg-surface-container border border-outline-variant rounded-lg text-on-surface-variant hover:bg-surface-container-hover transition-colors">
                                <span class="material-symbols-outlined text-base">close</span>
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center gap-1 px-md py-2 bg-error text-on-error rounded-lg hover:bg-error-hover transition-colors">
                                <span class="material-symbols-outlined text-base">picture_as_pdf</span>
                                Export PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection