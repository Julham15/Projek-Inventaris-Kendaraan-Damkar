@extends('user.layouts.index')
@section('user')
<title>Edit Laporan</title>
    <!-- Main Content - Mobile First -->
    <main class="px-4 py-4 pb-24 max-w-full space-y-5 sm:px-6 md:px-8 lg:ml-64 lg:max-w-7xl lg:mx-auto lg:space-y-7">
        <!-- Header -->
        <section class="mt-2">
            <h1 class="text-2xl font-bold text-primary md:text-3xl lg:text-h1">Edit Laporan</h1>
            <p class="text-sm text-on-surface-variant mt-1 md:text-base lg:text-body-regular">Edit laporan kendaraan dan peralatan yang telah dibuat.</p>
        </section>

        <!-- Error Validation -->
        @if ($errors->any())
            <div class="bg-error/10 border-l-4 border-error text-error p-3 rounded-md flex items-start gap-3 md:p-4">
                <span class="material-symbols-outlined text-error mt-0.5 text-lg">error</span>
                <div class="flex-1">
                    <p class="font-medium text-sm mb-1 md:text-base">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-xs space-y-0.5 md:text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Form -->
        <section>
            <form action="{{ route('laporan.update', $laporan) }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 space-y-5 md:p-6 lg:p-8 lg:space-y-7">
                @csrf
                @method('PUT')

                <!-- Peralatan -->
                <div class="space-y-3">
                    <h3 class="text-lg font-semibold text-on-surface md:text-xl lg:text-h3">
                        <span class="material-symbols-outlined text-primary align-middle mr-2">build</span>
                        Peralatan
                    </h3>
                    
                    <!-- List Peralatan - Mobile Optimized -->
                    <div class="space-y-3">
                        @foreach($laporan->laporanPeralatans as $item)
                            <div class="bg-surface-container border border-outline-variant rounded-lg p-3 space-y-3 md:p-4 lg:p-5">
                                <b class="text-sm text-on-surface md:text-base">{{ $item->peralatan->nama_alat }}</b>
                                
                                <div class="space-y-3">
                                    <!-- Jumlah & Kondisi -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs text-on-surface-variant md:text-sm">
                                                Jumlah
                                                <span class="text-primary font-medium text-xs">
                                                    (MAX: {{ $item->jumlah_awal }})
                                                </span>
                                            </label>
                                            <input type="number"
                                                min="0"
                                                max="{{ $item->jumlah_awal }}"
                                                data-max="{{ $item->jumlah_awal }}"
                                                data-nama="{{ $item->peralatan->nama_alat }}"
                                                name="peralatan[{{ $item->peralatan_id }}][jumlah]"
                                                value="{{ $item->jumlah }}"
                                                class="jumlah-peralatan w-full px-3 py-2 bg-surface-container-lowest border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-sm md:text-base">
                                            <small class="text-error text-xs hidden pesan-error">
                                                Jumlah melebihi batas.
                                            </small>
                                        </div>
                                        <div>
                                            <label class="block text-xs text-on-surface-variant md:text-sm">Kondisi</label>
                                            <select name="peralatan[{{ $item->peralatan_id }}][kondisi]"
                                                    class="w-full px-3 py-2 bg-surface-container-lowest border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-sm md:text-base">
                                                <option value="Baik" {{ $item->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                <option value="Rusak Ringan" {{ $item->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                                <option value="Rusak Berat" {{ $item->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Foto -->
                                    <div>
                                        <label class="block text-xs text-on-surface-variant mb-1.5 md:text-sm">Foto Peralatan</label>
                                        
                                        <div class="flex flex-wrap items-center gap-2">
                                            @if($item->foto)
                                                <!-- Foto tersedia -->
                                                <button type="button"
                                                        onclick="openModal('peralatan-{{ $item->id }}', 'Foto Peralatan - {{ $item->peralatan->nama_alat }}', '{{ asset('storage/'.$item->foto) }}')"
                                                        class="px-3 py-2 bg-primary-container text-primary rounded-lg hover:bg-primary hover:text-white transition-colors text-xs md:text-sm inline-flex items-center gap-1 flex-1 sm:flex-none justify-center">
                                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                                    Lihat Foto
                                                </button>
                                            @elseif($item->foto_dihapus_admin)
                                                <!-- Foto dihapus admin -->
                                                <span class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-red-100 text-red-600 border border-red-300 text-xs md:text-sm flex-1 sm:flex-none justify-center">
                                                    <span class="material-symbols-outlined text-sm">hide_image</span>
                                                    Foto dihapus Admin
                                                </span>
                                            @else
                                                <!-- User tidak mengupload foto -->
                                                <span class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-gray-100 text-gray-600 border border-gray-300 text-xs md:text-sm flex-1 sm:flex-none justify-center">
                                                    <span class="material-symbols-outlined text-sm">image_not_supported</span>
                                                    Tidak ada foto
                                                </span>
                                            @endif
                                            
                                            <button type="button"
                                                    class="btn-camera-edit px-3 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-xs md:text-sm inline-flex items-center gap-1 flex-1 sm:flex-none justify-center"
                                                    data-target="peralatan-{{ $item->id }}"
                                                    data-title="Foto Peralatan - {{ $item->peralatan->nama_alat }}">
                                                <span class="material-symbols-outlined text-sm">photo_camera</span>
                                                Ambil Foto
                                            </button>
                                        </div>
                                        
                                        <!-- Indikator foto telah diambil -->
                                        <div id="status-indicator-peralatan-{{ $item->id }}" class="mt-2 hidden">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="text-success text-xs flex items-center gap-1 md:text-sm">
                                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                                    Foto baru sudah diambil
                                                </span>
                                                <button type="button" 
                                                        class="btn-view-photo-edit text-primary text-xs hover:underline flex items-center gap-1 md:text-sm"
                                                        data-input="peralatan-{{ $item->id }}"
                                                        data-title="Foto Peralatan - {{ $item->peralatan->nama_alat }}">
                                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                                    Lihat Foto Baru
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <input type="file"
                                               hidden
                                               class="camera-input-edit"
                                               id="peralatan-{{ $item->id }}"
                                               name="peralatan[{{ $item->peralatan_id }}][foto]"
                                               accept="image/*"
                                               capture="environment">
                                    </div>

                                    <!-- Deskripsi -->
                                    <div>
                                        <label for="deskripsi-{{ $item->peralatan_id }}" class="block text-xs text-on-surface-variant mb-1.5 md:text-sm">
                                            Deskripsi
                                        </label>
                                        <textarea
                                            id="deskripsi-{{ $item->peralatan_id }}"
                                            name="peralatan[{{ $item->peralatan_id }}][deskripsi]"
                                            rows="3"
                                            class="w-full px-3 py-2 bg-surface-container-lowest border-2 border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-none text-sm md:text-base">{{ old("peralatan.$item->peralatan_id.deskripsi", $item->deskripsi) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Kondisi Kendaraan -->
                <div class="space-y-3">
                    <h3 class="text-lg font-semibold text-on-surface md:text-xl lg:text-h3">
                        <span class="material-symbols-outlined text-primary align-middle mr-2">assessment</span>
                        Kondisi Kendaraan
                    </h3>
                    
                    <!-- List Kondisi - Mobile Optimized -->
                    <div class="space-y-3">
                        @foreach($laporan->laporanKondisis as $item)
                            <div class="bg-surface-container border border-outline-variant rounded-lg p-3 space-y-3 md:p-4 lg:p-5">
                                <b class="text-sm text-on-surface md:text-base">{{ $item->kondisi->nama_kondisi }}</b>
                                
                                <div class="space-y-3">
                                    <!-- Status -->
                                    <div>
                                        <label class="block text-xs text-on-surface-variant mb-1.5 md:text-sm">Status</label>
                                        <select name="kondisi[{{ $item->kondisi_id }}][status]"
                                                class="w-full px-3 py-2 bg-surface-container-lowest border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-sm md:text-base">
                                            <option value="Baik" {{ $item->status == 'Baik' ? 'selected' : '' }}>Baik</option>
                                            <option value="Perlu Perhatian" {{ $item->status == 'Perlu Perhatian' ? 'selected' : '' }}>Perlu Perhatian</option>
                                        </select>
                                    </div>

                                    <!-- Foto -->
                                    <div>
                                        <label class="block text-xs text-on-surface-variant mb-1.5 md:text-sm">Foto Kondisi</label>
                                        
                                        <div class="flex flex-wrap items-center gap-2">
                                            @if($item->foto)
                                                <!-- Foto tersedia -->
                                                <button type="button"
                                                        onclick="openModal('kondisi-{{ $item->id }}', 'Foto Kondisi - {{ $item->kondisi->nama_kondisi }}', '{{ asset('storage/'.$item->foto) }}')"
                                                        class="px-3 py-2 bg-primary-container text-primary rounded-lg hover:bg-primary hover:text-white transition-colors text-xs md:text-sm inline-flex items-center gap-1 flex-1 sm:flex-none justify-center">
                                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                                    Lihat Foto
                                                </button>
                                            @elseif($item->foto_dihapus_admin)
                                                <!-- Foto dihapus admin -->
                                                <span class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-red-100 text-red-600 border border-red-300 text-xs md:text-sm flex-1 sm:flex-none justify-center">
                                                    <span class="material-symbols-outlined text-sm">hide_image</span>
                                                    Foto dihapus Admin
                                                </span>
                                            @else
                                                <!-- User tidak mengupload foto -->
                                                <span class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-gray-100 text-gray-600 border border-gray-300 text-xs md:text-sm flex-1 sm:flex-none justify-center">
                                                    <span class="material-symbols-outlined text-sm">image_not_supported</span>
                                                    Tidak ada foto
                                                </span>
                                            @endif
                                            
                                            <button type="button"
                                                    class="btn-camera-edit-kondisi px-3 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-xs md:text-sm inline-flex items-center gap-1 flex-1 sm:flex-none justify-center"
                                                    data-target="kondisi-{{ $item->id }}"
                                                    data-title="Foto Kondisi - {{ $item->kondisi->nama_kondisi }}">
                                                <span class="material-symbols-outlined text-sm">photo_camera</span>
                                                Ambil Foto
                                            </button>
                                        </div>
                                        
                                        <!-- Indikator foto telah diambil -->
                                        <div id="status-indicator-kondisi-{{ $item->id }}" class="mt-2 hidden">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="text-success text-xs flex items-center gap-1 md:text-sm">
                                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                                    Foto baru sudah diambil
                                                </span>
                                                <button type="button" 
                                                        class="btn-view-photo-edit-kondisi text-primary text-xs hover:underline flex items-center gap-1 md:text-sm"
                                                        data-input="kondisi-{{ $item->id }}"
                                                        data-title="Foto Kondisi - {{ $item->kondisi->nama_kondisi }}">
                                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                                    Lihat Foto Baru
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <input type="file"
                                               hidden
                                               class="camera-input-edit-kondisi"
                                               id="kondisi-{{ $item->id }}"
                                               name="kondisi[{{ $item->kondisi_id }}][foto]"
                                               accept="image/*"
                                               capture="environment">
                                    </div>

                                    <!-- Deskripsi -->
                                    <div>
                                        <label for="deskripsi-{{ $item->kondisi_id }}" class="block text-xs text-on-surface-variant mb-1.5 md:text-sm">
                                            Deskripsi
                                        </label>
                                        <textarea
                                            id="deskripsi-{{ $item->kondisi_id }}"
                                            name="kondisi[{{ $item->kondisi_id }}][deskripsi]"
                                            rows="3"
                                            class="w-full px-3 py-2 bg-surface-container-lowest border-2 border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-none text-sm md:text-base">{{ old("kondisi.$item->kondisi_id.deskripsi", $item->deskripsi) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tombol Aksi - Mobile Optimized -->
                <div class="flex flex-col-reverse gap-3 pt-4 border-t-2 border-outline-variant/30 sm:flex-row sm:justify-end sm:gap-4">
                    <a href="{{ route('laporan.index') }}"
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-surface-container border-2 border-outline-variant text-on-surface-variant rounded-lg hover:bg-surface-container-hover transition-colors font-medium text-sm md:text-base md:px-6 md:py-3">
                        <span class="material-symbols-outlined text-base md:text-xl">close</span>
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary text-on-primary rounded-lg hover:bg-primary-hover hover:scale-105 hover:shadow-lg transition-all duration-300 font-medium text-sm md:text-base md:px-6 md:py-3">
                        <span class="material-symbols-outlined text-base md:text-xl">save</span>
                        Update Laporan
                    </button>
                </div>
            </form>
        </section>
    </main>

    <!-- Modal Preview - Mobile Optimized -->
    <div id="previewModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/70 backdrop-blur-sm p-4" onclick="closeModal()">
        <div class="relative bg-white rounded-2xl max-w-2xl w-full p-4 md:p-6" onclick="event.stopPropagation()">
            <!-- Header Modal -->
            <div class="flex justify-between items-center mb-3 md:mb-4">
                <h3 class="text-base font-semibold text-gray-800 md:text-lg" id="modalTitle">Preview Foto</h3>
                <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-gray-700 transition-colors p-1">
                    <span class="material-symbols-outlined text-xl md:text-2xl">close</span>
                </button>
            </div>
            <!-- Gambar Preview -->
            <div class="relative bg-gray-50 rounded-lg overflow-hidden">
                <img id="modalImage" src="" alt="Preview" class="w-full max-h-[60vh] object-contain md:max-h-[70vh]">
                <div id="loadingIndicator" class="absolute inset-0 flex items-center justify-center bg-white/80 rounded-lg hidden">
                    <div class="text-center">
                        <span class="material-symbols-outlined text-3xl text-primary animate-spin md:text-4xl">refresh</span>
                        <p class="text-xs text-gray-600 mt-2 md:text-sm">Memuat gambar...</p>
                    </div>
                </div>
            </div>
            <!-- Tombol Aksi -->
            <div class="flex justify-end mt-4">
                <button type="button" onclick="closeModal()" 
                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-sm md:text-base inline-flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    OK
                </button>
            </div>
        </div>
    </div>

    <script>
        let photoStorage = {}; // Menyimpan data foto per input untuk edit

        // Fungsi untuk membuka modal
        function openModal(id, title, imageUrl) {
            const modal = document.getElementById('previewModal');
            const modalImage = document.getElementById('modalImage');
            const modalTitle = document.getElementById('modalTitle');
            const loading = document.getElementById('loadingIndicator');
            
            // Set data
            modalTitle.textContent = title || 'Preview Foto';
            
            // Tampilkan loading
            loading.classList.remove('hidden');
            modalImage.classList.add('hidden');
            
            // Tampilkan modal
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            
            // Load gambar
            const img = new Image();
            img.onload = function() {
                modalImage.src = imageUrl;
                modalImage.classList.remove('hidden');
                loading.classList.add('hidden');
            };
            img.onerror = function() {
                loading.classList.add('hidden');
                modalImage.src = imageUrl;
                modalImage.classList.remove('hidden');
            };
            img.src = imageUrl;
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            const modal = document.getElementById('previewModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal dengan ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Event listener untuk tombol kamera peralatan (edit)
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-camera-edit')) {
                const button = e.target.closest('.btn-camera-edit');
                const target = button.dataset.target;
                const title = button.dataset.title || 'Preview Foto';
                const input = document.getElementById(target);
                
                if (input) {
                    // Buka kamera
                    input.click();
                    
                    // Handle perubahan file
                    const handleChange = function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            // Validasi tipe file
                            if (!file.type.startsWith('image/')) {
                                alert('Mohon pilih file gambar yang valid.');
                                input.value = '';
                                return;
                            }

                            // Validasi ukuran (maks 10MB)
                            if (file.size > 10 * 1024 * 1024) {
                                alert('Ukuran gambar terlalu besar. Maksimal 10MB.');
                                input.value = '';
                                return;
                            }

                            const reader = new FileReader();
                            reader.onload = function(e) {
                                // Simpan di storage
                                photoStorage[target] = {
                                    data: e.target.result,
                                    title: title,
                                    file: file
                                };
                                
                                // Tampilkan modal dengan preview
                                openModal(target, title, e.target.result);
                                
                                // Tampilkan indikator dan tombol lihat
                                const indicator = document.getElementById(`status-indicator-${target}`);
                                if (indicator) {
                                    indicator.classList.remove('hidden');
                                }
                            };
                            reader.readAsDataURL(file);
                        }
                        input.removeEventListener('change', handleChange);
                    };
                    
                    input.addEventListener('change', handleChange);
                }
            }
        });

        // Event listener untuk tombol lihat foto peralatan (edit)
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-view-photo-edit')) {
                const button = e.target.closest('.btn-view-photo-edit');
                const inputId = button.dataset.input;
                const title = button.dataset.title;
                if (photoStorage[inputId]) {
                    openModal(inputId, title, photoStorage[inputId].data);
                } else {
                    alert('Belum ada foto baru yang diambil.');
                }
            }
        });

        // Event listener untuk tombol kamera kondisi (edit)
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-camera-edit-kondisi')) {
                const button = e.target.closest('.btn-camera-edit-kondisi');
                const target = button.dataset.target;
                const title = button.dataset.title || 'Preview Foto';
                const input = document.getElementById(target);
                
                if (input) {
                    // Buka kamera
                    input.click();
                    
                    // Handle perubahan file
                    const handleChange = function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            // Validasi tipe file
                            if (!file.type.startsWith('image/')) {
                                alert('Mohon pilih file gambar yang valid.');
                                input.value = '';
                                return;
                            }

                            // Validasi ukuran (maks 10MB)
                            if (file.size > 10 * 1024 * 1024) {
                                alert('Ukuran gambar terlalu besar. Maksimal 10MB.');
                                input.value = '';
                                return;
                            }

                            const reader = new FileReader();
                            reader.onload = function(e) {
                                // Simpan di storage
                                photoStorage[target] = {
                                    data: e.target.result,
                                    title: title,
                                    file: file
                                };
                                
                                // Tampilkan modal dengan preview
                                openModal(target, title, e.target.result);
                                
                                // Tampilkan indikator dan tombol lihat
                                const indicator = document.getElementById(`status-indicator-${target}`);
                                if (indicator) {
                                    indicator.classList.remove('hidden');
                                }
                            };
                            reader.readAsDataURL(file);
                        }
                        input.removeEventListener('change', handleChange);
                    };
                    
                    input.addEventListener('change', handleChange);
                }
            }
        });

        // Event listener untuk tombol lihat foto kondisi (edit)
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-view-photo-edit-kondisi')) {
                const button = e.target.closest('.btn-view-photo-edit-kondisi');
                const inputId = button.dataset.input;
                const title = button.dataset.title;
                if (photoStorage[inputId]) {
                    openModal(inputId, title, photoStorage[inputId].data);
                } else {
                    alert('Belum ada foto baru yang diambil.');
                }
            }
        });

        // Validasi jumlah peralatan
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.jumlah-peralatan').forEach(function (input) {
                input.addEventListener('input', function () {
                    let max = parseInt(this.dataset.max);
                    let nilai = parseInt(this.value);
                    let error = this.parentElement.querySelector('.pesan-error');

                    if (isNaN(nilai)) return;

                    if (nilai > max) {
                        this.value = max;
                        error.classList.remove('hidden');
                        error.innerText = `Jumlah maksimal ${max}`;
                    } else {
                        error.classList.add('hidden');
                    }

                    if (nilai < 0) {
                        this.value = 0;
                    }
                });
            });
        });
    </script>
@endsection