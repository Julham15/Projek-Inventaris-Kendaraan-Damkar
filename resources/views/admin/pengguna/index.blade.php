@extends('admin.layouts')

@section('navbar')
<!-- Main Content -->

<main class="flex-1 flex flex-col lg:pl-[280px] w-full h-full overflow-y-auto relative">
  <header class="flex justify-between items-center w-full px-lg py-md sticky top-0 z-40 bg-white border-b border-outline-variant">
        <div class="flex items-center gap-md">
            <button class="lg:hidden text-on-surface-variant hover:text-primary transition-colors p-sm rounded-lg hover:bg-surface-container">
                <span class="material-symbols-outlined" data-icon="menu">menu</span>
            </button>
            <span class="font-h2 text-h2 font-bold text-primary">Manajemen Pengguna</span>
        </div>
        
        <!-- Bagian kanan header (opsional) -->
        <div class="flex items-center gap-sm">
            <!-- Tambahkan tombol aksi di sini -->
        </div>
    </header>
  @if(session('success'))
    <div class="mb-4 p-4 rounded-lg border border-green-300 bg-green-100 text-green-800 flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 rounded-lg border border-red-300 bg-red-100 text-red-800 flex items-center gap-2">
        <span class="material-symbols-outlined">error</span>
        <span>{{ session('error') }}</span>
    </div>
@endif
  <!-- Content Wrapper with padding to shift content right -->
  <div class="flex-1 p-lg md:p-margin">
  
  <!-- Header Actions -->
  <div class="flex justify-between items-center bg-surface-container-lowest p-md rounded-lg border border-outline-variant shadow-sm">
    <div>
      <h2 class="font-h3 text-h3 text-on-background">Kelola Akses &amp; Personel</h2>
      <p class="text-on-surface-variant font-body-regular">Tambahkan, ubah, atau nonaktifkan pengguna sistem.</p>
    </div>
    <a href="{{ route('pengguna.createPemantau') }}" class="button flex items-center gap-sm bg-primary-container text-on-primary font-h4 text-h4 px-lg py-sm rounded-lg hover:bg-secondary transition-colors duration-200 shadow-sm">
      <span class="material-symbols-outlined">person_add</span>
      Tambah Pemantau
    </a>
  </div>
  <br>
  
  <!-- Tabel Pengguna Aktif -->
  <section class="bg-surface-container-lowest rounded-lg border border-outline-variant shadow-sm overflow-hidden flex flex-col">
    <div class="p-md border-b border-outline-variant bg-surface flex justify-between items-center">
      <h3 class="font-h3 text-h3 text-on-background flex items-center gap-sm">
        <span class="material-symbols-outlined text-primary">check_circle</span>
        Pengguna Aktif
      </h3>
      <span class="bg-primary-fixed text-on-primary-fixed px-sm py-base rounded-full font-small text-small font-bold"> {{ $activeUsers }} Total</span>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-primary text-on-primary font-h4 text-h4">
            <th class="py-sm px-md font-medium">Nama</th>
            <th class="py-sm px-md font-medium hidden md:table-cell">Kontak</th>
            <th class="py-sm px-md font-medium">Jabatan</th>
            <th class="py-sm px-md font-medium">Peleton/Regu</th>
            <th class="py-sm px-md font-medium text-center">Aksi</th>
          </tr>
        </thead>
        @foreach($penggunaAktif as $user)
        <tbody class="font-body-regular text-body-regular divide-y divide-outline-variant">
          <!-- Row 1 -->
          <tr class="bg-surface-container-lowest hover:bg-surface transition-colors">
            <td class="py-sm px-md">
              <div class="flex items-center gap-sm">
                <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed font-bold">
                  @php
                    $words = explode(' ', trim($user->name));
                    $initials = strtoupper($words[0][0] ?? '');
                    if (count($words) > 1) {
                      $initials .= strtoupper(end($words)[0] ?? '');
                    }
                  @endphp
                  {{ $initials }}
                </div>
                <div>
                  <p class="font-bold text-on-background">{{ $user->name }}</p>
                  <span class="inline-flex items-center gap-1 text-on-surface-variant font-small text-small md:hidden">
                    <span class="material-symbols-outlined text-[14px]">phone</span><span> {{ $user->phone ?? '-' }}</span>
                  </span>
                </div>
              </div>
            </td>
            <td class="py-sm px-md hidden md:table-cell text-on-surface-variant">
              <div class="">{{ $user->email }}</div>
              <div class="font-small text-small flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">phone</span> {{ $user->phone ?? '-' }}</div>
            </td>
            <td class="py-sm px-md">
              <span class="bg-secondary-fixed text-on-secondary-fixed px-2 py-1 rounded font-small text-small"> 
                @if($user->role === 'admin2')
                  {{ $user->jabatan }}
                @else
                  Pegawai
                @endif
              </span>
            </td>
            <td class="py-sm px-md text-center font-medium" style="font-size: 15px;">
              @if($user->role == 'user')
                <div class="bg-surface-container border border-outline-variant rounded px-2 py-1 text-on-background font-body-regular w-full max-w-[150px]">
                  @if($user->platon && $user->regu)
                    {{ $user->platon->nama }} - {{ $user->regu->nama }}
                  @elseif($user->platon)
                    {{ $user->platon->nama }} - <span style="color:red;">-</span>
                  @else
                    <span style="color:red;">-</span>
                  @endif
                </div>
              @endif
            </td>
            <td class="py-sm px-md text-center">
              <form action="{{ route('pengguna.nonaktifkan', $user->id) }}"
                    method="POST" 
                    class="button text-error hover:bg-error-container p-2 rounded-full transition-colors group relative" 
                    title="Nonaktifkan" 
                    style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('Nonaktifkan pengguna ini?')"
                        style="background:none; border:none; cursor:pointer;">
                  <span class="material-symbols-outlined">block</span>
                  <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface px-2 py-1 rounded font-small text-small hidden group-hover:block whitespace-nowrap">
                    Nonaktifkan
                  </span>
                </button>
              </form>
              <!-- Tombol Edit yang membuka modal -->
              <button type="button" 
                      onclick="openEditModal('{{ $user->id }}')"
                      class="text-primary hover:bg-primary-fixed p-2 rounded-full transition-colors group relative ml-1" 
                      title="Edit">
                <span class="material-symbols-outlined">edit</span>
                <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface px-2 py-1 rounded font-small text-small hidden group-hover:block whitespace-nowrap">
                  Edit
                </span>
              </button>

              <!-- Modal -->
              <dialog id="editModal{{ $user->id }}" class="rounded-xl shadow-xl backdrop:bg-black/50 p-0 max-w-md w-full">
                <div class="bg-surface p-6 rounded-xl">
                  <!-- Header Modal -->
                  <div class="flex justify-between items-center mb-4">
                    <h3 class="font-h3 text-h3 text-on-surface">Edit Peleton / Regu</h3>
                    <button type="button" 
                            onclick="document.getElementById('editModal{{ $user->id }}').close()"
                            class="text-on-surface-variant hover:text-on-surface p-2 rounded-full transition-colors">
                      <span class="material-symbols-outlined">close</span>
                    </button>
                  </div>

                  <!-- Form -->
                  <form action="{{ route('pengguna.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if($user->role == 'user')
                      <!-- Pilihan Platon -->
                      <div class="mb-4">
                        <label for="platon_id_{{ $user->id }}" class="block font-label text-label text-on-surface-variant mb-1">
                          Peleton
                        </label>
                        <select name="platon_id" 
                                id="platon_id_{{ $user->id }}" 
                                onchange="filterRegu('{{ $user->id }}')"
                                class="w-full px-3 py-2 border border-outline rounded-lg bg-surface text-on-surface focus:outline-none focus:ring-2 focus:ring-primary transition-colors">
                          <option value="">Pilih Platon</option>
                          @foreach($platons as $platon)
                            <option value="{{ $platon->id }}" @selected($user->platon_id == $platon->id)>
                              {{ $platon->nama }}
                            </option>
                          @endforeach
                        </select>
                      </div>

                      <!-- Pilihan Regu -->
                      <div class="mb-4">
                        <label for="regu_id_{{ $user->id }}" class="block font-label text-label text-on-surface-variant mb-1">
                          Regu
                        </label>
                        <select name="regu_id" 
                                id="regu_id_{{ $user->id }}" 
                                class="w-full px-3 py-2 border border-outline rounded-lg bg-surface text-on-surface focus:outline-none focus:ring-2 focus:ring-primary transition-colors">
                          <option value="">Pilih Regu</option>
                          @foreach($regus as $regu)
                            <option value="{{ $regu->id }}" 
                                    data-platon="{{ $regu->platon_id }}"
                                    @selected($user->regu_id == $regu->id)>
                              {{ $regu->nama }}
                            </option>
                          @endforeach
                        </select>
                      </div>

                      <!-- Tombol Aksi -->
                      <div class="flex justify-end gap-2 mt-6">
                        <button type="button" 
                                onclick="document.getElementById('editModal{{ $user->id }}').close()"
                                class="px-4 py-2 rounded-lg border border-outline text-gray-600 hover:bg-red-500 hover:text-white transition-colors">
                          Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 rounded-lg bg-primary text-on-primary hover:bg-sky-400 hover:text-on-surface transition-colors">
                          Simpan
                        </button>
                      </div>
                    @else
                      <p class="text-on-surface-variant text-center py-4">
                        Pengguna ini tidak dapat diedit
                      </p>
                      <div class="flex justify-end mt-4">
                        <button type="button" 
                                onclick="document.getElementById('editModal{{ $user->id }}').close()"
                                class="px-4 py-2 rounded-lg border border-outline text-on-surface-variant hover:bg-surface-container transition-colors">
                          Tutup
                        </button>
                      </div>
                    @endif
                  </form>
                </div>
              </dialog>
            </td>
          </tr>
        </tbody>
        @endforeach
      </table>
    </div>
    <div class="p-sm border-t border-outline-variant bg-surface flex justify-center">
      <button class="text-primary font-h4 text-h4 hover:underline">Muat Lebih Banyak</button>
    </div>
  </section>
  <br>
  <!-- Tabel Pengguna Nonaktif -->
  <section class="bg-surface-container-lowest rounded-lg border border-outline-variant shadow-sm overflow-hidden flex flex-col opacity-90">
    <div class="p-md border-b border-outline-variant bg-surface-container-high flex justify-between items-center">
      <h3 class="font-h3 text-h3 text-on-background flex items-center gap-sm">
        <span class="material-symbols-outlined text-outline">person_off</span>
        Pengguna Nonaktif
      </h3>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-surface-dim text-on-surface-variant font-h4 text-h4 border-b border-outline-variant">
            <th class="py-sm px-md font-medium">Nama</th>
            <th class="py-sm px-md font-medium hidden md:table-cell">Kontak</th>
            <th class="py-sm px-md font-medium text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="font-body-regular text-body-regular divide-y divide-outline-variant text-on-surface-variant">
          @foreach($penggunaNonaktif as $user)
          <tr class="bg-surface-container-lowest hover:bg-surface transition-colors">
            <td class="py-sm px-md flex items-center gap-sm">
              <span class="material-symbols-outlined text-outline">account_circle</span>
              {{ $user->name }}
            </td>
            <td class="py-sm px-md hidden md:table-cell">
              <div class="">{{ $user->email }}</div>
              <div class="font-small text-small flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">phone</span>{{ $user->phone ?? '-' }}
              </div>
            </td>
            <td class="py-sm px-md text-center">
              <form action="{{ route('pengguna.restore', $user->id) }}"
                    method="POST"
                    style="display:inline;">
                @csrf
                <button type="submit"
                        onclick="return confirm('Pulihkan pengguna ini?')"
                        class="text-primary hover:bg-primary-fixed p-2 rounded-lg transition-colors font-h4 text-h4 mr-2 border border-primary">
                  Pulihkan
                </button>
              </form>
              <form action="{{ route('pengguna.forceDelete', $user->id) }}"
                    method="POST"
                    style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Hapus permanen pengguna ini?')"
                        class="text-error hover:bg-error-container p-2 rounded-lg transition-colors font-h4 text-h4 border border-error">
                  Hapus Permanen
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>
  
  </div> <!-- End of Content Wrapper -->
</main>

<script>
  // Fungsi untuk membuka modal dan mengatur filter
  function openEditModal(userId) {
    const modal = document.getElementById('editModal' + userId);
    modal.showModal();
    
    // Jalankan filter saat modal dibuka
    setTimeout(function() {
      filterRegu(userId);
    }, 100);
  }

  // Fungsi untuk filter regu berdasarkan platon yang dipilih
  function filterRegu(userId) {
    const platonSelect = document.getElementById('platon_id_' + userId);
    const reguSelect = document.getElementById('regu_id_' + userId);
    
    if (!platonSelect || !reguSelect) return;
    
    const selectedPlaton = platonSelect.value;
    const options = reguSelect.querySelectorAll('option');
    
    // Sembunyikan semua option regu
    let hasVisibleOption = false;
    
    options.forEach(option => {
      // Option pertama (Pilih Regu) selalu ditampilkan
      if (option.value === '') {
        option.style.display = 'block';
        return;
      }
      
      const platonId = option.getAttribute('data-platon');
      // Tampilkan hanya regu yang platon_id-nya sesuai
      if (selectedPlaton === '' || platonId === selectedPlaton) {
        option.style.display = 'block';
        hasVisibleOption = true;
      } else {
        option.style.display = 'none';
      }
    });
    
    // Reset pilihan regu jika yang dipilih tidak tersedia
    const currentSelected = reguSelect.value;
    if (currentSelected !== '') {
      const selectedOption = reguSelect.querySelector('option[value="' + currentSelected + '"]');
      if (selectedOption && selectedOption.style.display === 'none') {
        reguSelect.value = '';
      }
    }
  }

  // Jalankan filter saat halaman dimuat
  document.addEventListener('DOMContentLoaded', function() {
    // Untuk semua modal yang ada
    document.querySelectorAll('dialog[id^="editModal"]').forEach(modal => {
      const userId = modal.id.replace('editModal', '');
      // Set platon yang sudah dipilih sebelumnya
      setTimeout(function() {
        filterRegu(userId);
      }, 200);
    });
  });
</script>
@endsection