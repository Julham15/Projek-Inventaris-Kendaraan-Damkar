@extends('admin.layouts')

@section('navbar')
<!-- Main Content Area -->
<main class="flex-1 flex flex-col lg:pl-[280px] w-full h-full overflow-hidden relative">
  <header class="flex justify-between items-center w-full px-lg py-md sticky top-0 z-40 bg-white border-b border-outline-variant">
    <div class="flex items-center gap-md">
      <button class="lg:hidden text-on-surface-variant hover:text-primary transition-colors p-sm rounded-lg hover:bg-surface-container">
        <span class="material-symbols-outlined" data-icon="menu">menu</span>
      </button>
      <span class="font-h2 text-h2 font-bold text-primary">Manajemen Peleton</span>
    </div>
    <div class="flex-1 max-w-md mx-lg hidden md:block">
      <div class="relative">
      </div>
    </div>
    <div class="flex items-center gap-sm">
      <button class="text-on-surface-variant hover:text-primary transition-colors p-sm rounded-full hover:bg-surface-container active:opacity-80">
      </button>
    </div>
  </header>
  
  <!-- Content Wrapper -->
  <div class="flex-1 overflow-x-hidden p-lg md:p-margin">
  
    <!-- Alert Messages -->
    @if(session('success'))
      <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded flex items-center justify-between" role="alert">
        <div class="flex items-center">
          <span class="material-symbols-outlined mr-2">check_circle</span>
          <p>{{ session('success') }}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
    @endif

    @if(session('error'))
      <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded flex items-center justify-between" role="alert">
        <div class="flex items-center">
          <span class="material-symbols-outlined mr-2">error</span>
          <p>{{ session('error') }}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
    @endif

    @if(session('warning'))
      <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded flex items-center justify-between" role="alert">
        <div class="flex items-center">
          <span class="material-symbols-outlined mr-2">warning</span>
          <p>{{ session('warning') }}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-yellow-700 hover:text-yellow-900">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
    @endif

    @if($errors->any())
      <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-lg mb-xl">
      <div class="">
        <p class="text-body-regular text-on-surface-variant">Kelola Data Peleton Dan Pembagian Regu Operasional Pemadam Kebakaran.</p>
      </div>
      <div class="flex flex-wrap gap-md">
        <!-- Tombol Tambah Platon -->
        <button onclick="openModal('platonModal')" class="bg-surface-container-lowest border border-primary text-primary px-lg py-sm rounded-lg font-h4 text-h4 hover:bg-primary-container transition-all active:scale-95 flex items-center gap-xs shadow-sm">
          <span class="material-symbols-outlined">add_circle</span>
          Tambah Peleton
        </button>
        <!-- Tombol Tambah Regu -->
        <button onclick="openModal('reguModal')" class="bg-primary text-on-primary px-lg py-sm rounded-lg font-h4 text-h4 hover:bg-secondary transition-all active:scale-95 flex items-center gap-xs shadow-md">
          <span class="material-symbols-outlined">group_add</span>
          Tambah Regu
        </button>
      </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-xl">
      <div class="bento-card p-lg rounded-xl shadow-sm">
        <div class="flex justify-between items-start">
          <div>
            <p class="text-on-surface-variant font-h4">Total Peleton</p>
            <h2 class="text-h1 font-h1 text-primary">{{ count($platons) }}</h2>
          </div>
          <div class="bg-primary-container p-xs rounded-lg text-on-primary-container">
            <span class="material-symbols-outlined">shield</span>
          </div>
        </div>
        <div class="mt-md flex items-center gap-xs text-small text-green-600">
          <span class="material-symbols-outlined text-[16px]">trending_up</span>
          <span class="">Siap Operasional</span>
        </div>
      </div>
      <div class="bento-card p-lg rounded-xl shadow-sm">
        <div class="flex justify-between items-start">
          <div>
            <p class="text-on-surface-variant font-h4">Total Regu</p>
            <h2 class="text-h1 font-h1 text-primary">{{ count($regus) }}</h2>
          </div>
          <div class="bg-secondary-container p-xs rounded-lg text-on-secondary-container">
            <span class="material-symbols-outlined">groups</span>
          </div>
        </div>
        <div class="mt-md flex items-center gap-xs text-small text-on-surface-variant">
          <span class="">Terbagi di {{ count($platons) }} Peleton</span>
        </div>
      </div>
      <div class="bento-card p-lg rounded-xl shadow-sm border-l-4 border-l-tertiary">
        <div class="flex justify-between items-start">
          <div>
            <p class="text-on-surface-variant font-h4">Status Petugas</p>
            <h2 class="text-h1 font-h1 text-tertiary">{{ $totalPetugas ?? 0 }}</h2>
          </div>
          <div class="bg-tertiary-fixed p-xs rounded-lg text-on-tertiary-fixed">
            <span class="material-symbols-outlined">person</span>
          </div>
        </div>
        <div class="mt-md flex items-center gap-xs text-small text-on-surface-variant">
          <span class="w-2 h-2 rounded-full bg-green-500"></span>
          <span class="">Aktif Bertugas</span>
        </div>
      </div>
    </div>

    <!-- Main Table Container -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm overflow-hidden">
      <div class="p-lg border-b border-outline-variant bg-surface-container-low flex justify-between items-center">
        <h3 class="font-h3 text-h3 text-on-surface">Daftar Platon &amp; Regu</h3>
      </div>
      <div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-primary text-on-primary">
                <th class="px-lg py-md font-h4 text-h4 w-16">No.</th>
                <th class="px-lg py-md font-h4 text-h4">Nama Peleton</th>
                <th class="px-lg py-md font-h4 text-h4">Daftar Regu</th>
                <th class="px-lg py-md font-h4 text-h4 text-center w-32">Aksi Regu</th>
                <th class="px-lg py-md font-h4 text-h4 text-center w-40">Aksi Peleton</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-outline-variant">
            @php $no = 1; @endphp
            
            @forelse($platons as $platon)
                @php 
                    $regusPlaton = $platon->regus; // Ambil regu dari relasi
                    $jumlahRegu = $regusPlaton->count();
                @endphp
                
                @if($jumlahRegu > 0)
                    {{-- Tampilkan baris pertama dengan data platon dan regu pertama --}}
                    @foreach($regusPlaton as $index => $regu)
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="px-lg py-md text-body-regular">{{ $no++ }}</td>
                            <td class="px-lg py-md font-h4">
                                @if($index === 0)
                                    {{ $platon->nama }}
                                @endif
                            </td>
                            <td class="px-lg py-md text-body-regular">
                                Regu {{ $regu->nama }}
                            </td>
                            <td class="px-lg py-md text-center">
                                <form method="POST" action="{{ route('regu.destroy', $regu->id) }}" class="inline-block" onsubmit="return confirmDeleteRegu('{{ $platon->nama }}', {{ $regu->nama }})">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-xs text-error hover:bg-error-container rounded-lg transition-all active:scale-90 group relative" title="Hapus Regu">
                                        <span class="material-symbols-outlined">delete</span>
                                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                            Hapus Regu
                                        </span>
                                    </button>
                                </form>
                            </td>
                            <td class="px-lg py-md text-center">
                                @if($index === 0)
                                    <form method="POST" action="{{ route('platon.destroy', $platon->id) }}" 
                                          class="inline-block" 
                                          onsubmit="return confirmDeletePlaton('{{ $platon->nama }}', {{ $jumlahRegu }})">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-xs text-red-600 hover:bg-red-50 rounded-lg transition-all active:scale-90 group relative" title="Hapus Platon">
                                            <span class="material-symbols-outlined">delete_forever</span>
                                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                                Hapus Peleton
                                            </span>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    {{-- Tampilkan platon yang tidak memiliki regu --}}
                    <tr class="hover:bg-surface-container-low transition-colors">
                        <td class="px-lg py-md text-body-regular">{{ $no++ }}</td>
                        <td class="px-lg py-md font-h4">{{ $platon->nama }}</td>
                        <td class="px-lg py-md text-body-regular text-gray-400 italic">
                            Belum ada regu
                        </td>
                        <td class="px-lg py-md text-center text-gray-400">
                            -
                        </td>
                        <td class="px-lg py-md text-center">
                            <form method="POST" action="{{ route('platon.destroy', $platon->id) }}" 
                                  class="inline-block" 
                                  onsubmit="return confirmDeletePlaton('{{ $platon->nama }}', 0)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-xs text-red-600 hover:bg-red-50 rounded-lg transition-all active:scale-90 group relative" title="Hapus Platon">
                                    <span class="material-symbols-outlined">delete_forever</span>
                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        Hapus Peleton
                                    </span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endif
                
            @empty
                <tr>
                    <td colspan="5" class="px-lg py-md text-center text-on-surface-variant">
                        Belum ada data peleton. Silakan tambahkan peleton baru.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
      <div class="p-lg flex flex-col sm:flex-row justify-between items-center gap-md bg-surface-container-low">
        <p class="text-caption text-on-surface-variant">Menampilkan 1 - {{ count($regus) }} dari {{ count($regus) }} entri</p>
        <div class="flex items-center gap-xs">
          <button class="w-8 h-8 flex items-center justify-center rounded border border-outline-variant bg-surface-container-lowest text-on-surface hover:bg-primary-container disabled:opacity-50" disabled>
            <span class="material-symbols-outlined text-[18px]">chevron_left</span>
          </button>
          <button class="w-8 h-8 flex items-center justify-center rounded bg-primary text-on-primary">1</button>
          <button class="w-8 h-8 flex items-center justify-center rounded border border-outline-variant bg-surface-container-lowest text-on-surface hover:bg-primary-container">
            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Modal Tambah Platon -->
<div id="platonModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
  <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4">
    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-primary">Tambah Peleton</h2>
        <button onclick="closeModal('platonModal')" class="text-gray-500 hover:text-gray-700">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
      <form method="POST" action="{{ route('platon.store') }}" id="formPlaton">
        @csrf
        <div class="mb-4">
          <label for="nama_platon" class="block text-sm font-medium text-gray-700 mb-2">Nama Peleton</label>
          <input type="text" id="nama_platon" name="nama" placeholder="Contoh : Peleton A" 
                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" 
                 required>
          <p id="platonError" class="text-red-500 text-sm mt-1 hidden"></p>
          @error('nama')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
        <div class="flex gap-3 justify-end">
          <button type="button" onclick="closeModal('platonModal')" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            Batal
          </button>
          <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Tambah Regu -->
<div id="reguModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
  <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4">
    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-primary">Tambah Regu</h2>
        <button onclick="closeModal('reguModal')" class="text-gray-500 hover:text-gray-700">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
      <form method="POST" action="{{ route('regu.store') }}" id="formRegu">
        @csrf
        <div class="mb-4">
          <label for="platon_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Peleton</label>
          <select id="platon_id" name="platon_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
            <option value="">Pilih Platon</option>
            @foreach($platons as $platon)
              <option value="{{ $platon->id }}">{{ $platon->nama }}</option>
            @endforeach
          </select>
          @error('platon_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
        <div class="mb-4">
          <label for="nama_regu" class="block text-sm font-medium text-gray-700 mb-2">Nomor Regu</label>
          <input type="number" id="nama_regu" name="nama" placeholder="Contoh: 1, 2, 3" 
                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" 
                 min="1" max="999" required>
          <p class="text-sm text-gray-500 mt-1">Masukkan nomor regu (angka)</p>
          <p id="reguError" class="text-red-500 text-sm mt-1 hidden"></p>
          @error('nama')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
        <div class="flex gap-3 justify-end">
          <button type="button" onclick="closeModal('reguModal')" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            Batal
          </button>
          <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Hapus Platon -->
<div id="deletePlatonModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
  <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all scale-95 opacity-0" id="deleteModalContent">
    <div class="p-6">
      <div class="flex items-start gap-4 mb-4">
        <div class="bg-red-100 p-3 rounded-full">
          <span class="material-symbols-outlined text-red-600 text-3xl">warning</span>
        </div>
        <div class="flex-1">
          <h2 class="text-xl font-bold text-gray-900 mb-2">Peringatan!</h2>
          <div id="deleteMessage" class="text-gray-700 mb-4">
            <!-- Pesan akan diisi oleh JavaScript -->
          </div>
          <div id="reguList" class="bg-gray-50 p-3 rounded-lg mb-4 hidden">
            <p class="text-sm font-semibold text-gray-700 mb-2">Daftar Regu yang perlu dihapus:</p>
            <ul id="reguListItems" class="list-disc list-inside text-sm text-gray-600">
              <!-- Daftar regu akan diisi oleh JavaScript -->
            </ul>
          </div>
          {{-- <p class="text-sm text-red-600 font-semibold">⚠️ Tindakan ini tidak dapat dibatalkan!</p> --}}
        </div>
      </div>
      <div class="flex gap-3 justify-end">
        <button onclick="closeDeleteModal()" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
          Batal
        </button>
        <button id="confirmDeleteBtn" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2">
          <span class="material-symbols-outlined text-sm">delete_forever</span>
          Hapus 
        </button>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript untuk Modal dan Validasi -->
<script>
  // Fungsi Modal
  function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    document.getElementById(modalId).classList.add('flex');
    document.body.style.overflow = 'hidden';
  }

  function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.getElementById(modalId).classList.remove('flex');
    document.body.style.overflow = 'auto';
    resetErrors();
  }

  function resetErrors() {
    const platonError = document.getElementById('platonError');
    const reguError = document.getElementById('reguError');
    if (platonError) platonError.classList.add('hidden');
    if (reguError) reguError.classList.add('hidden');
  }

  // Tutup modal jika klik di luar modal
  document.addEventListener('click', function(event) {
    if (event.target.classList.contains('fixed')) {
      event.target.classList.add('hidden');
      event.target.classList.remove('flex');
      document.body.style.overflow = 'auto';
      resetErrors();
    }
  });

  // Konfirmasi Hapus Platon dengan Modal Khusus
  let deletePlatonForm = null;

  function confirmDeletePlaton(namaPlaton, jumlahRegu) {
    // Cari data regu untuk platon ini
    const reguItems = @json($regus->groupBy('platon_id')->map(function($items) {
      return $items->pluck('nama')->toArray();
    }));
    
    const platonId = @json($platons->pluck('id', 'nama')->toArray())[namaPlaton];
    const reguList = reguItems[platonId] || [];
    
    // Tampilkan modal konfirmasi
    const modal = document.getElementById('deletePlatonModal');
    const content = document.getElementById('deleteModalContent');
    const message = document.getElementById('deleteMessage');
    const reguListDiv = document.getElementById('reguList');
    const reguListItems = document.getElementById('reguListItems');
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    
    // Set pesan
    if (jumlahRegu > 0) {
      message.innerHTML = `
        <p class="mb-2">Jika anda mau menghapus "<strong>${namaPlaton}</strong>" perlu hapus dulu <strong>${jumlahRegu}</strong> regu yang ada di dalamnya:</p>
      `;
      
      // Tampilkan daftar regu
      reguListDiv.classList.remove('hidden');
      reguListItems.innerHTML = '';
      reguList.forEach((regu, index) => {
        const li = document.createElement('li');
        li.textContent = `Regu ${regu}`;
        li.className = 'py-1 border-b border-gray-200 last:border-0';
        reguListItems.appendChild(li);
      });
    } else {
      message.innerHTML = `
        <p class="mb-2">Anda akan menghapus Peleton "<strong>${namaPlaton}</strong>".</p>
        <p class="text-gray-500">Platon ini tidak memiliki regu.</p>
      `;
      reguListDiv.classList.add('hidden');
    }
    
    // Set action form
    const platon = @json($platons->keyBy('id')->toArray());
    const platonIdValue = platon ? Object.keys(platon).find(key => platon[key].nama === namaPlaton) : null;
    
    if (platonIdValue) {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = `{{ url('platon') }}/${platonIdValue}`;
      
      const csrfInput = document.createElement('input');
      csrfInput.type = 'hidden';
      csrfInput.name = '_token';
      csrfInput.value = '{{ csrf_token() }}';
      form.appendChild(csrfInput);
      
      const methodInput = document.createElement('input');
      methodInput.type = 'hidden';
      methodInput.name = '_method';
      methodInput.value = 'DELETE';
      form.appendChild(methodInput);
      
      deletePlatonForm = form;
    }
    
    // Tampilkan modal dengan animasi
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
    
    setTimeout(() => {
      content.classList.remove('scale-95', 'opacity-0');
      content.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    // Set button confirm
    confirmBtn.onclick = function() {
      if (deletePlatonForm) {
        document.body.appendChild(deletePlatonForm);
        deletePlatonForm.submit();
      }
    };
    
    return false; // Prevent form submission
  }

  function closeDeleteModal() {
    const modal = document.getElementById('deletePlatonModal');
    const content = document.getElementById('deleteModalContent');
    
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      document.body.style.overflow = 'auto';
      deletePlatonForm = null;
    }, 300);
  }

  // Konfirmasi Hapus Regu
  function confirmDeleteRegu(namaPlaton, nomorRegu) {
    return confirm(`Apakah Anda yakin ingin menghapus Regu ${nomorRegu} dari Platon "${namaPlaton}"?`);
  }

  // Validasi Client-side untuk Platon
  document.getElementById('formPlaton').addEventListener('submit', function(e) {
    const namaPlaton = document.getElementById('nama_platon').value.trim();
    const errorElement = document.getElementById('platonError');
    
    const existingPlatons = @json($platons->pluck('nama')->toArray());
    
    if (existingPlatons.includes(namaPlaton)) {
      e.preventDefault();
      errorElement.textContent = 'Nama Platon "' + namaPlaton + '" sudah ada. Silakan gunakan nama yang berbeda.';
      errorElement.classList.remove('hidden');
      errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return false;
    }
    
    errorElement.classList.add('hidden');
    return true;
  });

  // Validasi Client-side untuk Regu
  document.getElementById('formRegu').addEventListener('submit', function(e) {
    const platonId = document.getElementById('platon_id').value;
    const namaRegu = document.getElementById('nama_regu').value.trim();
    const errorElement = document.getElementById('reguError');
    
    if (!platonId) {
      e.preventDefault();
      errorElement.textContent = 'Silakan pilih Peleton terlebih dahulu.';
      errorElement.classList.remove('hidden');
      return false;
    }
    
    if (!/^\d+$/.test(namaRegu)) {
      e.preventDefault();
      errorElement.textContent = 'Nomor regu harus berupa angka.';
      errorElement.classList.remove('hidden');
      return false;
    }
    
    const reguNumber = parseInt(namaRegu);
    if (reguNumber < 1) {
      e.preventDefault();
      errorElement.textContent = 'Nomor regu minimal 1.';
      errorElement.classList.remove('hidden');
      return false;
    }
    
    const existingRegus = @json($regus->map(function($regu) {
      return [
        'platon_id' => $regu->platon_id,
        'nama' => (int)$regu->nama
      ];
    })->toArray());
    
    const isDuplicate = existingRegus.some(regu => 
      regu.platon_id == platonId && regu.nama === reguNumber
    );
    
    if (isDuplicate) {
      e.preventDefault();
      const platonName = document.getElementById('platon_id').selectedOptions[0].text;
      errorElement.textContent = 'Regu nomor ' + reguNumber + ' sudah ada di Peleton "' + platonName + '". Silakan gunakan nomor yang berbeda.';
      errorElement.classList.remove('hidden');
      errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return false;
    }
    
    errorElement.classList.add('hidden');
    return true;
  });

  // Reset error saat input berubah
  document.getElementById('nama_platon').addEventListener('input', function() {
    document.getElementById('platonError').classList.add('hidden');
  });

  document.getElementById('nama_regu').addEventListener('input', function() {
    document.getElementById('reguError').classList.add('hidden');
  });

  document.getElementById('platon_id').addEventListener('change', function() {
    document.getElementById('reguError').classList.add('hidden');
  });
</script>

@endsection