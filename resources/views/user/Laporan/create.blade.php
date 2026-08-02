@extends('user.layouts.index')
@section('user')
    <!-- Main Content - Mobile First -->
    <main class="px-4 py-4 pb-24 max-w-full space-y-5 sm:px-6 md:px-8 lg:ml-64 lg:max-w-7xl lg:mx-auto lg:space-y-7">
        <!-- Header -->
        <section class="mt-2">
            <h1 class="text-2xl font-bold text-primary md:text-3xl lg:text-h1">Buat Laporan</h1>
            <p class="text-sm text-on-surface-variant mt-1 md:text-base lg:text-body-regular">Isi formulir berikut untuk membuat laporan kendaraan dan peralatan.</p>
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
            <form action="{{ route('laporan.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 space-y-5 md:p-6 lg:p-8 lg:space-y-7">
                @csrf

                <!-- Posko -->
                <div class="space-y-1.5">
                    <label for="posko_id" class="block text-sm font-medium text-on-surface-variant md:text-base">
                        <span class="material-symbols-outlined text-sm align-middle mr-1">location_on</span>
                        Pos
                    </label>
                    <select id="posko_id" 
                            name="posko_id"
                            class="w-full px-3 py-2.5 bg-surface-container border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-sm md:text-base md:px-4">
                        <option value="">-- Pilih Pos --</option>
                        @foreach($poskos as $posko)
                            <option value="{{ $posko->id }}">{{ $posko->nama_posko }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Jenis Mobil -->
                <div class="space-y-1.5">
                    <label for="jenis_mobil_id" class="block text-sm font-medium text-on-surface-variant md:text-base">
                        <span class="material-symbols-outlined text-sm align-middle mr-1">directions_car</span>
                        Jenis Mobil
                    </label>
                    <select id="jenis_mobil_id" 
                            name="jenis_mobil_id"
                            class="w-full px-3 py-2.5 bg-surface-container border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-sm md:text-base md:px-4">
                        <option value="">-- Pilih Jenis Mobil --</option>
                    </select>
                </div>

                <!-- Kendaraan -->
                <div class="space-y-1.5">
                    <label for="kendaraan_id" class="block text-sm font-medium text-on-surface-variant md:text-base">
                        <span class="material-symbols-outlined text-sm align-middle mr-1">local_police</span>
                        Kendaraan
                    </label>
                    <select id="kendaraan_id" 
                            name="kendaraan_id"
                            class="w-full px-3 py-2.5 bg-surface-container border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-sm md:text-base md:px-4">
                        <option value="">-- Pilih Kendaraan --</option>
                    </select>
                </div>

                <!-- Peralatan -->
                <div class="space-y-3">
                    <h3 class="text-lg font-semibold text-on-surface text-center md:text-xl lg:text-h3">
                        <span class="material-symbols-outlined text-primary align-middle mr-2">build</span>
                        Peralatan
                    </h3>
                    <div id="peralatan-box" class="space-y-3"></div>
                </div>

                <!-- Kondisi -->
                <div class="space-y-3">
                    <h3 class="text-lg font-semibold text-on-surface text-center md:text-xl lg:text-h3">
                        <span class="material-symbols-outlined text-primary align-middle mr-2">assessment</span>
                        Kondisi
                    </h3>
                    <div id="kondisi-box" class="space-y-3"></div>
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
                        <span class="material-symbols-outlined text-base md:text-xl">send</span>
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </section>
    </main>

    <!-- Modal Preview - Mobile Optimized -->
    <div id="previewModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/70 backdrop-blur-sm p-4">
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
            <div class="flex flex-col-reverse gap-2 mt-4 sm:flex-row sm:justify-end sm:gap-3">
                <button type="button" onclick="closeModal()" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm md:text-base">
                    Tutup
                </button>
                <button type="button" onclick="closeModal()" 
                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-sm md:text-base inline-flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    OK
                </button>
            </div>
        </div>
    </div>

    <script>
        // ==========================================
        // VARIABEL GLOBAL
        // ==========================================
        let isSubmitting = false;
        let photoStorage = {}; // Menyimpan foto per input

        // ==========================================
        // FUNGSI MODAL
        // ==========================================
        function openModal(imageData, title, inputId) {
            const modal = document.getElementById('previewModal');
            const modalImage = document.getElementById('modalImage');
            const modalTitle = document.getElementById('modalTitle');
            const loadingIndicator = document.getElementById('loadingIndicator');

            // Set judul
            modalTitle.textContent = title || 'Preview Foto';

            // Tampilkan loading
            modalImage.classList.add('hidden');
            loadingIndicator.classList.remove('hidden');

            // Tampilkan modal
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';

            // Set gambar setelah loading
            setTimeout(() => {
                modalImage.src = imageData;
                modalImage.classList.remove('hidden');
                loadingIndicator.classList.add('hidden');
            }, 500);
        }

        function closeModal() {
            const modal = document.getElementById('previewModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
            
            // Reset gambar untuk menghindari memory leak
            const modalImage = document.getElementById('modalImage');
            setTimeout(() => {
                modalImage.src = '';
            }, 300);
        }

        // Tutup modal dengan ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Klik di luar modal juga menutup
        document.getElementById('previewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // ==========================================
        // FUNGSI CAPTURE & STORE FOTO
        // ==========================================
        function handlePhotoCapture(inputElement, targetId, title) {
            const file = inputElement.files[0];
            if (!file) return;

            // Validasi tipe file
            if (!file.type.startsWith('image/')) {
                alert('Mohon pilih file gambar yang valid.');
                inputElement.value = '';
                return;
            }

            // Validasi ukuran (maks 10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('Ukuran gambar terlalu besar. Maksimal 10MB.');
                inputElement.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const imageData = e.target.result;
                
                // Simpan ke storage
                photoStorage[targetId] = {
                    data: imageData,
                    file: file,
                    name: file.name
                };

                // Tampilkan indikator
                const indicator = document.getElementById(`status-indicator-${targetId}`);
                if (indicator) {
                    indicator.classList.remove('hidden');
                }

                // Tampilkan preview otomatis
                openModal(imageData, title || 'Preview Foto', targetId);
            };

            reader.onerror = function() {
                alert('Gagal membaca file. Silakan coba lagi.');
                inputElement.value = '';
            };

            reader.readAsDataURL(file);
        }

        // ==========================================
        // EVENT LISTENER FORM SUBMIT
        // ==========================================
        document.querySelector("form").addEventListener("submit", function(e) {
            isSubmitting = true;
            console.log('Form submitted dengan ' + Object.keys(photoStorage).length + ' foto');
        });

        // ==========================================
        // EVENT POSKO CHANGE
        // ==========================================
        document.getElementById('posko_id').addEventListener('change', function() {
            let posko = this.value;

            document.getElementById('jenis_mobil_id').innerHTML = `
                <option value="">-- Pilih Jenis Mobil --</option>
            `;

            document.getElementById('kendaraan_id').innerHTML = `
                <option value="">-- Pilih Kendaraan --</option>
            `;

            document.getElementById('peralatan-box').innerHTML = '';
            document.getElementById('kondisi-box').innerHTML = '';

            if (!posko) return;

            fetch('/laporan/posko/' + posko)
                .then(res => res.json())
                .then(data => {
                    let html = `<option value="">-- Pilih Jenis Mobil --</option>`;
                    data.forEach(item => {
                        html += `<option value="${item.id}">${item.nama_jenis}</option>`;
                    });
                    document.getElementById('jenis_mobil_id').innerHTML = html;
                })
                .catch(err => console.error('Error:', err));
        });

        // ==========================================
        // EVENT JENIS MOBIL CHANGE
        // ==========================================
        document.getElementById('jenis_mobil_id').addEventListener('change', function() {
            let id = this.value;
            let posko = document.getElementById('posko_id').value;

            document.getElementById('peralatan-box').innerHTML = '';
            document.getElementById('kondisi-box').innerHTML = '';

            if (!id) {
                document.getElementById('kendaraan_id').innerHTML = `
                    <option value="">-- Pilih Kendaraan --</option>
                `;
                return;
            }

            fetch('/laporan/posko/' + posko + '/jenis-mobil/' + id)
                .then(res => res.json())
                .then(data => {
                    let html = `<option value="">-- Pilih Kendaraan --</option>`;
                    data.forEach(item => {
                        html += `<option value="${item.id}">${item.nomor_polisi}</option>`;
                    });
                    document.getElementById('kendaraan_id').innerHTML = html;
                })
                .catch(err => console.error('Error:', err));
        });

        // ==========================================
        // EVENT KENDARAAN CHANGE
        // ==========================================
        document.getElementById('kendaraan_id').addEventListener('change', function() {
            if (isSubmitting) return;

            let kendaraan = this.value;
            let jenis = document.getElementById('jenis_mobil_id').value;
            let posko = document.getElementById('posko_id').value;

            if (!kendaraan || !jenis || !posko) return;

            fetch(`${window.location.origin}/laporan/posko/${posko}/jenis-mobil/${jenis}/kendaraan/${kendaraan}`)
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(data => {
                    // Reset photoStorage untuk item baru
                    Object.keys(photoStorage).forEach(key => {
                        if (key.startsWith('peralatan-') || key.startsWith('kondisi-')) {
                            delete photoStorage[key];
                        }
                    });

                    renderPeralatan(data.peralatans);
                    renderKondisi(data.kondisis);
                })
                .catch(err => console.error('Error:', err));
        });

        // ==========================================
        // RENDER PERALATAN - Mobile Optimized
        // ==========================================
        function renderPeralatan(peralatans) {
            let peralatanHtml = '';
            peralatans.forEach((item) => {
                peralatanHtml += `
                    <div class="bg-surface-container border border-outline-variant rounded-lg p-3 space-y-3 md:p-4 lg:p-5">
                        <b class="text-sm text-on-surface md:text-base">${item.nama_alat}</b>
                        <div class="space-y-3">
                            <!-- Jumlah & Kondisi -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs text-on-surface-variant md:text-sm">
                                        Jumlah
                                        <span class="text-primary font-medium text-xs">
                                            (MAX: ${item.jumlah})
                                        </span>
                                    </label>
                                    <input type="number"
                                        min="0"
                                        max="${item.jumlah}"
                                        data-max="${item.jumlah}"
                                        value="0"
                                        name="peralatan[${item.id}][jumlah]"
                                        class="jumlah-peralatan w-full px-3 py-2 bg-surface-container-lowest border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-sm md:text-base">
                                    <small class="text-error text-xs hidden pesan-error">
                                        Jumlah melebihi batas.
                                    </small>
                                </div>
                                <div>
                                    <label class="block text-xs text-on-surface-variant md:text-sm">Kondisi</label>
                                    <select name="peralatan[${item.id}][kondisi]"
                                            class="w-full px-3 py-2 bg-surface-container-lowest border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-sm md:text-base">
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak Ringan">Rusak Ringan</option>
                                        <option value="Rusak Berat">Rusak Berat</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Foto -->
                            <div>
                                <label class="block text-xs text-on-surface-variant mb-1.5 md:text-sm">Foto Peralatan</label>
                                <button type="button"
                                        class="btn-camera w-full py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-sm md:text-base inline-flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-base">photo_camera</span>
                                    Ambil Foto
                                </button>
                                <div id="status-indicator-peralatan-${item.id}" class="mt-2 hidden">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-success text-xs flex items-center gap-1 md:text-sm">
                                            <span class="material-symbols-outlined text-sm">check_circle</span>
                                            Foto sudah diambil
                                        </span>
                                        <button type="button" 
                                                class="btn-view-photo text-primary text-xs hover:underline flex items-center gap-1 md:text-sm">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                            Lihat Foto
                                        </button>
                                    </div>
                                </div>
                                <input type="file"
                                    hidden
                                    class="camera-input"
                                    id="peralatan-${item.id}"
                                    name="peralatan[${item.id}][foto]"
                                    accept="image/*"
                                    capture="environment">
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label class="block text-xs text-on-surface-variant mb-1.5 md:text-sm">Deskripsi</label>
                                <textarea
                                    name="peralatan[${item.id}][deskripsi]"
                                    rows="3"
                                    placeholder="Masukkan deskripsi peralatan..."
                                    class="w-full px-3 py-2 bg-surface-container-lowest border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-none text-sm md:text-base"></textarea>
                            </div>
                        </div>
                    </div>
                `;
            });
            document.getElementById('peralatan-box').innerHTML = peralatanHtml;

            // Setup event listeners
            setupPeralatanEvents();
        }

        // ==========================================
        // RENDER KONDISI - Mobile Optimized
        // ==========================================
        function renderKondisi(kondisis) {
            let kondisiHtml = '';
            kondisis.forEach((item) => {
                kondisiHtml += `
                    <div class="bg-surface-container border border-outline-variant rounded-lg p-3 space-y-3 md:p-4 lg:p-5">
                        <b class="text-sm text-on-surface md:text-base">${item.nama_kondisi}</b>
                        <div class="space-y-3">
                            <!-- Status -->
                            <div>
                                <label class="block text-xs text-on-surface-variant mb-1.5 md:text-sm">Status</label>
                                <select name="kondisi[${item.id}][status]"
                                        class="w-full px-3 py-2 bg-surface-container-lowest border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-sm md:text-base">
                                    <option value="Baik">Baik</option>
                                    <option value="Perlu Perhatian">Perlu Perhatian</option>
                                </select>
                            </div>

                            <!-- Foto -->
                            <div>
                                <label class="block text-xs text-on-surface-variant mb-1.5 md:text-sm">Foto Kondisi</label>
                                <button type="button"
                                        class="btn-camera-kondisi w-full py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-sm md:text-base inline-flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-base">photo_camera</span>
                                    Ambil Foto
                                </button>
                                <div id="status-indicator-kondisi-${item.id}" class="mt-2 hidden">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-success text-xs flex items-center gap-1 md:text-sm">
                                            <span class="material-symbols-outlined text-sm">check_circle</span>
                                            Foto sudah diambil
                                        </span>
                                        <button type="button" 
                                                class="btn-view-photo-kondisi text-primary text-xs hover:underline flex items-center gap-1 md:text-sm">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                            Lihat Foto
                                        </button>
                                    </div>
                                </div>
                                <input type="file"
                                    hidden
                                    class="camera-input-kondisi"
                                    id="kondisi-${item.id}"
                                    name="kondisi[${item.id}][foto]"
                                    accept="image/*"
                                    capture="environment">
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label class="block text-xs text-on-surface-variant mb-1.5 md:text-sm">Deskripsi</label>
                                <textarea
                                    name="kondisi[${item.id}][deskripsi]"
                                    rows="3"
                                    placeholder="Masukkan deskripsi kondisi kendaraan..."
                                    class="w-full px-3 py-2 bg-surface-container-lowest border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-none text-sm md:text-base"></textarea>
                            </div>
                        </div>
                    </div>
                `;
            });
            document.getElementById('kondisi-box').innerHTML = kondisiHtml;

            // Setup event listeners
            setupKondisiEvents();
        }

        // ==========================================
        // SETUP EVENT PERALATAN
        // ==========================================
        function setupPeralatanEvents() {
            // Tombol kamera
            document.querySelectorAll("#peralatan-box .btn-camera").forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    const parent = this.closest('.bg-surface-container');
                    const input = parent.querySelector('.camera-input');
                    if (input) {
                        input.click();
                    }
                });
            });

            // Input file
            document.querySelectorAll("#peralatan-box .camera-input").forEach(input => {
                input.addEventListener("change", function(e) {
                    const target = this.id;
                    const parent = this.closest('.bg-surface-container');
                    const titleBtn = parent.querySelector('.btn-camera');
                    const title = titleBtn?.dataset?.title || 'Preview Foto';
                    handlePhotoCapture(this, target, title);
                });
            });

            // Tombol lihat foto
            document.querySelectorAll("#peralatan-box .btn-view-photo").forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    const parent = this.closest('.bg-surface-container');
                    const input = parent.querySelector('.camera-input');
                    const inputId = input?.id;
                    const title = 'Preview Foto';
                    if (inputId && photoStorage[inputId]) {
                        openModal(photoStorage[inputId].data, title, inputId);
                    } else {
                        alert('Belum ada foto yang diambil.');
                    }
                });
            });

            // Validasi jumlah
            document.querySelectorAll('.jumlah-peralatan').forEach(input => {
                input.addEventListener('input', function() {
                    const max = parseInt(this.dataset.max);
                    const error = this.parentElement.querySelector('.pesan-error');
                    if (parseInt(this.value) > max) {
                        this.value = max;
                        error.classList.remove('hidden');
                        error.innerText = `Jumlah maksimal ${max}`;
                    } else if (parseInt(this.value) < 0) {
                        this.value = 0;
                    } else {
                        error.classList.add('hidden');
                    }
                });
            });
        }

        // ==========================================
        // SETUP EVENT KONDISI
        // ==========================================
        function setupKondisiEvents() {
            // Tombol kamera
            document.querySelectorAll("#kondisi-box .btn-camera-kondisi").forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    const parent = this.closest('.bg-surface-container');
                    const input = parent.querySelector('.camera-input-kondisi');
                    if (input) {
                        input.click();
                    }
                });
            });

            // Input file
            document.querySelectorAll("#kondisi-box .camera-input-kondisi").forEach(input => {
                input.addEventListener("change", function(e) {
                    const target = this.id;
                    const parent = this.closest('.bg-surface-container');
                    const titleBtn = parent.querySelector('.btn-camera-kondisi');
                    const title = titleBtn?.dataset?.title || 'Preview Foto';
                    handlePhotoCapture(this, target, title);
                });
            });

            // Tombol lihat foto
            document.querySelectorAll("#kondisi-box .btn-view-photo-kondisi").forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    const parent = this.closest('.bg-surface-container');
                    const input = parent.querySelector('.camera-input-kondisi');
                    const inputId = input?.id;
                    const title = 'Preview Foto';
                    if (inputId && photoStorage[inputId]) {
                        openModal(photoStorage[inputId].data, title, inputId);
                    } else {
                        alert('Belum ada foto yang diambil.');
                    }
                });
            });
        }

        // ==========================================
        // INITIAL LOAD
        // ==========================================
        console.log('Laporan page loaded with photo preview modal');
    </script>
@endsection