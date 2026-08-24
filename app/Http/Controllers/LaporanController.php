<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Laporan;
use App\Models\Kendaraan;
use App\Notifications\LaporanSelesaiNotification;
use App\Models\Posko;
use App\Models\Kondisi;
use App\Models\Peralatan;
use App\Models\LaporanKondisi;
use App\Models\LaporanPeralatan;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\User;
use App\Models\Regu;
use App\Models\Platon;
use Carbon\Carbon;
use App\Events\LaporanSelesai;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StatusPeralatan;
use App\Models\StatusKondisi;
use App\Notifications\LaporanBaruNotification;
use App\Notifications\PeralatanRusakNotification;
use App\Notifications\KondisiKendaraanNotification;
use Illuminate\Support\Facades\Validator;




use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LaporanController extends Controller
{


    private const MAX_IMAGE_WIDTH = 1280;
    private const IMAGE_QUALITY = 75;
    private const ALLOWED_IMAGE_TYPES = ['jpg', 'jpeg', 'png'];
   private const MAX_IMAGE_SIZE = 20480;
    public function index()
    {
          $user = User::with(['platon', 'regu'])
            ->findOrFail(Auth::id());
       
        
        $laporans = Laporan::with([
            'kendaraan.jenisMobil',
            'laporanPeralatans.peralatan',
            'laporanKondisis.kondisi',
            'platon', 'regu',
            ])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
    // dd($laporans);
        return view('user.laporan.index', compact('laporans','user'));
    }
    public function create()
    {
        
        $poskos = Posko::all();
        $user = User::with(['platon', 'regu'])
            ->findOrFail(Auth::id());

        return view('user.laporan.create', compact('poskos','user'));
    }


// KB

    public function store(Request $request)
    {
       
       
       if ($request->hasFile('peralatan.1.foto')) {
    $file = $request->file('peralatan.1.foto');

    \Log::info('PERALATAN FOTO', [
        'original_name' => $file->getClientOriginalName(),
        'mime'          => $file->getMimeType(),
        'extension'     => $file->extension(),
        'size'          => $file->getSize(),
    ]);
}

if ($request->hasFile('kondisi.1.foto')) {
    $file = $request->file('kondisi.1.foto');

    \Log::info('KONDISI FOTO', [
        'original_name' => $file->getClientOriginalName(),
        'mime'          => $file->getMimeType(),
        'extension'     => $file->extension(),
        'size'          => $file->getSize(),
    ]);
}
      $validator = Validator::make($request->all(), [
    'posko_id' => 'required|exists:poskos,id',
    'jenis_mobil_id' => 'required|exists:jenis_mobils,id',
    'kendaraan_id' => 'required|exists:kendaraans,id',

    // 'deskripsi' => 'nullable|string',
    // 'keterangan' => 'nullable|string',

    'tanggal_kejadian' => 'nullable|date|before_or_equal:today','peralatan' => 'nullable|array','kondisi' => 'nullable|array',
    'peralatan.*.deskripsi' => ['nullable','string','max:1000',],
    'kondisi.*.deskripsi' => ['nullable','string','max:1000',],
    'peralatan.*.foto' => 'nullable|image|mimes:' . implode(',', self::ALLOWED_IMAGE_TYPES) . '|max:' . self::MAX_IMAGE_SIZE,
    'kondisi.*.foto' => 'nullable|image|mimes:' . implode(',', self::ALLOWED_IMAGE_TYPES) . '|max:' . self::MAX_IMAGE_SIZE,
]);

if ($validator->fails()) {
    \Log::error('VALIDASI GAGAL', [
        'errors' => $validator->errors()->toArray(),
        'request' => $request->all(),
        'files' => array_keys($request->allFiles()),
    ]);

    return back()
        ->withErrors($validator)
        ->withInput();
}


        // Validasi user
      
        $user = Auth::user();
        if (!$user->platon_id || !$user->regu_id) {
            
            return back()->with('error', 'Anda belum ditempatkan pada Platon dan Regu oleh Admin.');
        }
        \Log::info('2. USER OK');
        // Validasi peralatan
        $kendaraan = Kendaraan::with('jenisMobil.posko')->findOrFail($request->kendaraan_id);
        if ($kendaraan->jenis_mobil_id != $request->jenis_mobil_id) {
    return back()
        ->withInput()
        ->with('error', 'Jenis mobil tidak sesuai dengan kendaraan yang dipilih.');
}

if ($kendaraan->jenisMobil->posko_id != $request->posko_id) {
    return back()
        ->withInput()
        ->with('error', 'Posko tidak sesuai dengan kendaraan yang dipilih.');
}


        $validationError = $this->validatePeralatan($request->peralatan, $request->kendaraan_id);
        
        if ($validationError) {
            
            return back()->withInput()->with('error', $validationError);
        }
      
        // Mulai transaksi database
        DB::beginTransaction();

        try {
           

            // Buat laporan
            $laporan = $this->createLaporan($request, $user, $kendaraan);
    
            // Proses peralatan
           $peralatanRusak = $this->processPeralatan($request,$request->peralatan,$laporan,$request->kendaraan_id);

            // Proses kondisi
            $kondisiBermasalah = $this->processKondisi($request,$request->kondisi, $laporan, $request->kendaraan_id);
        
            // Commit transaksi
            DB::commit();

            // Kirim notifikasi
            $this->sendStoreNotifications($laporan, $peralatanRusak, $kondisiBermasalah);


          

            return redirect()
                ->route('laporan.index')
                ->with('success', 'Laporan berhasil dikirim.');

        } catch (\Throwable $e) {


            report($e);
           
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan laporan. Silakan coba lagi.');
        }
    }



    public function show(Laporan $laporan)
    {
        // hanya pemilik laporan
         $user = User::with(['platon', 'regu'])
            ->findOrFail(Auth::id());
        if ($laporan->user_id != auth()->id()) {
            abort(403);
        }
        $laporan->load(['user','kendaraan.jenisMobil',
        'laporanPeralatans.peralatan',
        'laporanKondisis.kondisi',
        ]);
     
        return view('user.laporan.show', compact('laporan','user'));
    }
public function edit(Laporan $laporan)
{

    $user = User::with(['platon', 'regu'])
            ->findOrFail(Auth::id());
    if ($laporan->user_id != Auth::id()) {
        abort(403);
    }

    if ($laporan->status != 'Diproses') {
        return back()->with(
            'error',
            'Laporan tidak dapat diedit'
        );
    }

    $laporan->load([
        'kendaraan.jenisMobil.posko',
        'laporanPeralatans.peralatan',
        'laporanKondisis.kondisi'
    ]);

    return view('user.laporan.edit',compact('laporan','user'));
}
public function update(Request $request, $id)
    {
        // Cari laporan yang akan diupdate
        $laporan = Laporan::with(['laporanPeralatans', 'laporanKondisis'])
            ->findOrFail($id);
            
             if (!$request->has('kendaraan_id')) {
        $request->merge(['kendaraan_id' => $laporan->kendaraan_id]);
    }


        // Validasi input
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'deskripsi' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tanggal_kejadian' => 'nullable|date|before_or_equal:today',
            'peralatan' => 'nullable|array',
            'kondisi' => 'nullable|array',
            'status' => 'nullable|in:Diproses,Selesai,Ditolak',
            'peralatan.*.deskripsi' => ['nullable','string','max:1000',],
            'kondisi.*.deskripsi' => ['nullable','string','max:1000',],
            'peralatan.*.foto' => 'nullable|image|mimes:' . implode(',', self::ALLOWED_IMAGE_TYPES) . '|max:' . self::MAX_IMAGE_SIZE,
            'kondisi.*.foto' => 'nullable|image|mimes:' . implode(',', self::ALLOWED_IMAGE_TYPES) . '|max:' . self::MAX_IMAGE_SIZE,
        ]);

        // Validasi user
        $user = Auth::user();
        if (!$user->platon_id || !$user->regu_id) {
            return back()->with('error', 'Anda belum ditempatkan pada Platon dan Regu oleh Admin.');
        }

        // Validasi kepemilikan laporan (opsional)
        if ($laporan->user_id !== $user->id && !in_array($user->role, ['admin', 'admin2'])) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengupdate laporan ini.');
        }

       

        // Validasi peralatan
        $kendaraan = Kendaraan::with('jenisMobil.posko')->findOrFail($request->kendaraan_id);
        $validationError = $this->validatePeralatan($request->peralatan, $request->kendaraan_id);
        
        

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Update laporan
            $this->updateLaporan($laporan, $request, $kendaraan);

            // Hapus data peralatan dan kondisi lama
            // Update peralatan
            $peralatanRusak = $this->updatePeralatan($request,$request->peralatan,$laporan,$request->kendaraan_id);

            // Update kondisi
            $kondisiBermasalah = $this->updateKondisi($request,$request->kondisi,$laporan,$request->kendaraan_id);

            // Commit transaksi
            DB::commit();

            // Kirim notifikasi update
            $this->sendUpdateNotifications($laporan, $peralatanRusak, $kondisiBermasalah);

            return redirect()
                ->route('laporan.index')
                ->with('success', 'Laporan berhasil diupdate.');

        } catch (\Throwable $e) {
            DB::rollBack();
            
            // Hapus foto baru jika ada dan transaksi gagal
          
            
            report($e);
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate laporan. Silakan coba lagi.');
        }
    }

    public function adminIndex(Request $request)
    {
    $laporanproses = Laporan::where('status','Diproses')->count();
    $laporanselesai = Laporan::where('status','Selesai')->count();
    $poskos = Posko::all();
    $platons = Platon::all();
    $total = Laporan::count();
    $regus = Regu::query();
   $query = Laporan::with([
    'user',
    'platon',
    'regu',
    'kendaraan.jenisMobil.posko',
    'laporanPeralatans.peralatan',
    'laporanKondisis.kondisi'
]);


   if ($request->filled('search')) {

    $search = trim($request->search);

    $query->where(function ($q) use ($search) {

        $q->whereHas('user', function ($user) use ($search) {
            $user->where('name', 'like', '%' . $search . '%');
        })

        ->orWhereHas('kendaraan', function ($kendaraan) use ($search) {
            $kendaraan->where('nomor_polisi', 'like', '%' . $search . '%');
        })

        ->orWhere('nama_posko', 'like', '%' . $search . '%');

    });
}
    

 if ($request->filled('status')) {
    $query->where('status', $request->status);
}

    if ($request->posko) {

    $posko = Posko::find($request->posko);

    if ($posko) {
        $query->where('nama_posko', $posko->nama_posko);
    }

}
if ($request->platon) {

    $query->where('platon_id', $request->platon);

}

if ($request->regu) {

    $query->where('regu_id', $request->regu);

}
if ($request->platon) {
    $regus->where('platon_id', $request->platon);
}

$regus = $regus->get();

    if ($request->dari && $request->sampai) {

        $query->whereBetween('created_at', [

            Carbon::parse($request->dari)->startOfDay(),

            Carbon::parse($request->sampai)->endOfDay(),

        ]);
    }

    $poskos = Posko::orderBy('nama_posko')->get();
    
    $laporans = $query->latest()->paginate(10);
    

    return view('admin.laporan.index', compact('total','laporans','poskos','platons','regus','laporanproses','laporanselesai'));
}
        

    public function adminShow(Laporan $laporan)
    {
        $laporan->load([

            'user',
            'kendaraan.jenisMobil',
            'laporanPeralatans.peralatan',
            
            'laporanKondisis.kondisi',

        ]);

        return view('admin.laporan.show', compact('laporan'));
    }


   public function updateStatus(Request $request, Laporan $laporan)
{
     if (!$laporan->user) {
        return back()->with(
            'error',
            'Status laporan tidak dapat diubah karena user yang membuat laporan sudah dinonaktifkan.'
        );
    }

    $request->validate([
        'status' => 'required|in:Diproses,Selesai,Diarsipkan',
    ]);

     $statusLama = $laporan->status;
    // Jika status dikembalikan ke Diproses, hapus tanggal selesai
    if ($request->status === 'Diproses') {
        $laporan->selesai_at = null;
    }

    // Status menjadi Selesai pertama kali
    if ($request->status === 'Selesai' && is_null($laporan->selesai_at)) {
        $laporan->selesai_at = now();
    }

    // Status menjadi Diarsipkan
    if ($request->status === 'Diarsipkan') {
        // Jika belum pernah selesai, gunakan waktu sekarang
        if (is_null($laporan->selesai_at)) {
            $laporan->selesai_at = now();
        }
        // Jika sudah ada selesai_at, biarkan tetap menggunakan tanggal lama
    }
    $laporan->status = $request->status;
    $laporan->save();

    if ($statusLama !== 'Selesai' && $request->status === 'Selesai') {

        $laporan->load('user', 'kendaraan');

        event(new LaporanSelesai($laporan));
    }

    
    return redirect()
        ->route('admin.laporan.index')
        ->with('success', 'Status laporan berhasil diperbarui');
}


  public function getKendaraanData($poskoId, $jenisId, $kendaraanId)
{
    \Log::info("GET KENDARAAN");
    $peralatans = Peralatan::where('kendaraan_id', $kendaraanId)->get();

    $kondisis = Kondisi::where('kendaraan_id', $kendaraanId)->get();

    return response()->json([
        'peralatans' => $peralatans,
        'kondisis' => $kondisis,
    ]);
}
   public function getKendaraanByJenis($poskoId, $jenisId)
{
    
    $kendaraan = Kendaraan::where('jenis_mobil_id', $jenisId)
        ->get();

    return response()->json($kendaraan);
}

    public function getJenisMobilByPosko($id)
{
    $jenisMobil = Kendaraan::where('posko_id', $id)
        ->join('jenis_mobils', 'kendaraans.jenis_mobil_id', '=', 'jenis_mobils.id')
        ->select('jenis_mobils.id', 'jenis_mobils.nama_jenis')
        ->distinct()
        ->get();

    return response()->json($jenisMobil);
}

   public function exportPdf(Request $request)
    {   
        $userId = auth()->id();
        $today = Carbon::today();
        
        $peralatanRusakHarian = LaporanPeralatan::whereHas('laporan', function ($q) use ($userId) {
            $q->where('user_id', $userId)
            ->whereDate('created_at', Carbon::today());
        })
        ->where('kondisi', 'Rusak Berat')
        ->count();

        $kondisiBermasalahHarian = LaporanKondisi::whereHas('laporan', function ($q) use ($userId) {
            $q->where('user_id', $userId)
            ->whereDate('created_at', Carbon::today());
        })
        ->where('status', 'Perlu Perhatian')
        ->count();
        
        $laporans = Laporan::with([
            'kendaraan',
            'platon',
            'regu',
        ])
        ->where('user_id', auth()->id())
        ->whereDate('created_at', $today)
        ->get();

        $pdf = Pdf::loadView('user.laporan.export', [
            'laporans' => $laporans,
            'nama_pengawas' => $request->nama_pengawas,
            'jabatan_penanggung_jawab' => $request->jabatan_penanggung_jawab,
            'nama_penanggung_jawab' => $request->nama_penanggung_jawab,
            'peralatanRusakHarian' => $peralatanRusakHarian, // Tambahkan ini
            'kondisiBermasalahHarian' => $kondisiBermasalahHarian, // Tambahkan ini
        ]);
        
        // return $pdf->download('laporan-hari-ini.pdf');
        return $pdf->stream('laporan-hari-ini.pdf');
    }
    public function pemantauIndex(Request $request)
{
    $laporanproses = Laporan::where('status','Diproses')->count();
    $laporanselesai = Laporan::where('status','Selesai')->count();
    $user = Auth::user();
    $platons = Platon::all();
    $total = Laporan::count();
    $jabatan = Auth::user()->jabatan;
    $namaPemantau = Auth::user()->name;
    $regus = Regu::query();
   $query = Laporan::with([
        'user',
        'platon',
        'regu',
        'kendaraan.jenisMobil.posko',
        'laporanPeralatans.peralatan',
        'laporanKondisis.kondisi'
    ]);


   if ($request->filled('search')) {

    $search = trim($request->search);

    $query->where(function ($q) use ($search) {

        $q->whereHas('user', function ($user) use ($search) {
            $user->where('name', 'like', '%' . $search . '%');
        })

        ->orWhereHas('kendaraan', function ($kendaraan) use ($search) {
            $kendaraan->where('nomor_polisi', 'like', '%' . $search . '%');
        })

        ->orWhere('nama_posko', 'like', '%' . $search . '%');

    });
}
    if ($request->filled('status')) {
    $query->where('status', $request->status);
}
 
      if ($request->posko) {

    $posko = Posko::find($request->posko);

    if ($posko) {
        $query->where('nama_posko', $posko->nama_posko);
    }

}

if ($request->platon) {

    $query->where('platon_id', $request->platon);

}

if ($request->regu) {

    $query->where('regu_id', $request->regu);

}
if ($request->platon) {
    $regus->where('platon_id', $request->platon);
}

$regus = $regus->get();

    if ($request->dari && $request->sampai) {

        $query->whereBetween('created_at', [
            Carbon::parse($request->dari)->startOfDay(),
            Carbon::parse($request->sampai)->endOfDay(),
        ]);
    }
    $laporans = $query->latest() ->paginate(10);
    $poskos = Posko::orderBy('nama_posko')->get();
    return view('pemantau.laporan.index',compact( 'total','laporans','poskos','platons','regus','namaPemantau','jabatan','user','laporanproses','laporanselesai'
        ));
}
public function pemantauShow(Laporan $laporan)
{   
    $user = Auth::user();
     $jabatan = Auth::user()->jabatan;
    $namaPemantau = Auth::user()->name;
    $laporan->load([
        'user',
        'kendaraan',
        'laporanPeralatans.peralatan',
        'laporanKondisis.kondisi'
    ]);

    return view(
        'pemantau.laporan.show',
        compact('laporan','jabatan','namaPemantau','user')
    );
}

   public function showExportPeralatan(Laporan $laporan)
{
     $user = User::with(['platon', 'regu'])
            ->findOrFail(Auth::id());
    if ($laporan->user_id != auth()->id()) {
        abort(403);
    }

    $laporan->load([
        'user',
        'kendaraan',
        'platon',
        'regu',
    ]);

    return view('user.laporan.export-peralatan-form', compact('laporan','user'));
}
public function showExportKondisi(Laporan $laporan)
{
     $user = User::with(['platon', 'regu'])
            ->findOrFail(Auth::id());
    if ($laporan->user_id != auth()->id()) {
        abort(403);
    }

    $laporan->load([
        'user',
        'kendaraan',
        'platon',
        'regu',
    ]);

    return view('user.laporan.export-kondisi-form', compact('laporan','user'));
}

public function exportPeralatanPdf(Request $request, Laporan $laporan)
{
    
    
    if ($laporan->user_id != auth()->id()) {
        abort(403);
    }

    $request->validate([
        'nama_pengawas' => 'required|string|max:100',
        'nama_penanggung_jawab' => 'required|string|max:100',
        'jabatan_penanggung_jawab' => 'required|string|max:100',
    ]);

    $laporan->load([
        'user',
        'kendaraan',
        'platon',
        'regu',
        'laporanPeralatans.peralatan',
    ]);

    $pdf = Pdf::loadView('user.laporan.pdf.peralatan', [

        'laporan' => $laporan,

        'nama_pengawas' => $request->nama_pengawas,

        'nama_penanggung_jawab' => $request->nama_penanggung_jawab,

        'jabatan_penanggung_jawab' => $request->jabatan_penanggung_jawab,

    ]);

    return $pdf->stream(
        'Laporan-Peralatan-'.$laporan->kendaraan->nomor_polisi.'.pdf'
    );
}

public function exportKondisiPdf(Request $request, Laporan $laporan)
{
    if ($laporan->user_id != auth()->id()) {
        abort(403);
    }

    $request->validate([
        'nama_pengawas' => 'required|string|max:100',
        'nama_penanggung_jawab' => 'required|string|max:100',
        'jabatan_penanggung_jawab' => 'required|string|max:100',
    ]);

    $laporan->load([
        'user',
        'kendaraan',
        'platon',
        'regu',
        'laporanKondisis.kondisi',
    ]);

    $pdf = Pdf::loadView('user.laporan.pdf.kondisi', [

        'laporan' => $laporan,

        'nama_pengawas' => $request->nama_pengawas,

        'nama_penanggung_jawab' => $request->nama_penanggung_jawab,

        'jabatan_penanggung_jawab' => $request->jabatan_penanggung_jawab,

    ]);

    return $pdf->stream(
        'Laporan-Kondisi-'.$laporan->kendaraan->nomor_polisi.'.pdf'
    );
}
///////////////////////////////////////////
  private function uploadAndCompressImage($file, string $directory, string $suffix = ''): ?string
    {
        if (!$file) {
            return null;
        }

        $filename = time() . $suffix . '.jpg';
        $fullPath = $directory . $filename;

        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image->scale(width: self::MAX_IMAGE_WIDTH);
            $compressed = $image->toJpeg(self::IMAGE_QUALITY);

            Storage::disk('public')->put($fullPath, (string) $compressed);
            return $fullPath;
        } catch (\Exception $e) {
            report($e);
            return null;
        }
    }

    /**
     * Hapus gambar dari storage
     */
    private function deleteImages(array $paths): void
    {
        foreach ($paths as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }

    /**
     * Validasi jumlah peralatan
     */
    private function validatePeralatan(?array $peralatan, int $kendaraanId): ?string
    {
        if (!$peralatan) {
            return null;
        }

        foreach ($peralatan as $id => $data) {
            $peralatanModel = Peralatan::where('kendaraan_id', $kendaraanId)
                ->where('id', $id)
                ->first();

            if (!$peralatanModel) {
                return 'Data peralatan tidak valid.';
            }

            $jumlahInput = (int) ($data['jumlah'] ?? 0);
            if ($jumlahInput > $peralatanModel->jumlah) {
                return "Jumlah {$peralatanModel->nama_alat} tidak boleh melebihi jumlah tersedia ({$peralatanModel->jumlah}).";
            }
        }

        return null;
    }

    /**
     * Buat laporan baru (untuk store)
     */
   private function createLaporan(Request $request, User $user, Kendaraan $kendaraan): Laporan
{
    DB::enableQueryLog();

    $laporan = Laporan::create([
        'user_id' => Auth::id(),
        'platon_id' => $user->platon_id,
        'regu_id' => $user->regu_id,
        'kendaraan_id' => $request->kendaraan_id,
        // 'deskripsi' => $request->deskripsi,
        // 'keterangan' => $request->keterangan,
        'nama_posko' => $kendaraan->jenisMobil->posko->nama_posko,
        'nomor_polisi' => $kendaraan->nomor_polisi,
        'tanggal_kejadian' => $request->tanggal_kejadian,
        'status' => 'Diproses',
    ]);

    return $laporan;
}

    /**
     * Update laporan yang sudah ada (untuk update)
     */
   private function updateLaporan(Laporan $laporan,Request $request,Kendaraan $kendaraan): void
{
    $laporan->update([
        'kendaraan_id'      => $request->kendaraan_id,
        // 'deskripsi'         => $request->deskripsi,
        // 'keterangan'        => $request->keterangan,
        'nama_posko'        => $kendaraan->jenisMobil->posko->nama_posko,
        'nomor_polisi'      => $kendaraan->nomor_polisi,
        'tanggal_kejadian'  => $request->tanggal_kejadian,
        'status'            => $request->status ?? $laporan->status,
    ]);
}

    /**
     * Proses data peralatan
     */
    private function processPeralatan(Request $request, ?array $peralatan, Laporan $laporan, int $kendaraanId): array
    {
        $peralatanRusak = [];

        if (!$peralatan) {
            return $peralatanRusak;
        }

        foreach ($peralatan as $id => $data) {
            $peralatanModel = Peralatan::where('kendaraan_id', $kendaraanId)
                ->where('id', $id)
                ->first();

            if (!$peralatanModel) {
                continue;
            }


              $fotoPath = null;

        if ($request->hasFile("peralatan.$id.foto")) {
            $fotoPath = $this->uploadAndCompressImage(
                $request->file("peralatan.$id.foto"),
                'laporan/peralatan/'
            );
        }

            $laporanPeralatan = LaporanPeralatan::create([
                'laporan_id' => $laporan->id,
                'peralatan_id' => $id,
                'nama_peralatan' => $peralatanModel->nama_alat,
                'jumlah_awal' => $peralatanModel->jumlah,
                'jumlah' => $data['jumlah'] ?? 0,
                'kondisi' => $data['kondisi'] ?? 'Baik',
                'deskripsi'     => $data['deskripsi'] ?? null,
                'foto'           => $fotoPath,
                
            ]);

            StatusPeralatan::updateOrCreate(
                [
                    'kendaraan_id' => $laporan->kendaraan_id,
                    'peralatan_id' => $id,
                ],
                [
                    'status' => $data['kondisi'] ?? 'Baik',
                     
                ]
            );

            if ($laporanPeralatan->kondisi === 'Rusak Berat') {
                $peralatanRusak[] = $peralatanModel->nama_alat;
            }
        }

        return $peralatanRusak;
    }

    /**
     * Proses data kondisi kendaraan
     */
    private function processKondisi( Request $request, ?array $kondisi, Laporan $laporan, int $kendaraanId): array
    {
        $kondisiBermasalah = [];

        if (!$kondisi) {
            return $kondisiBermasalah;
        }

        foreach ($kondisi as $id => $data) {
            $kondisiModel = Kondisi::find($id);

            if (!$kondisiModel) {
                continue;
            }

            $fotoPath = null;

        if ($request->hasFile("kondisi.$id.foto")) {
            $fotoPath = $this->uploadAndCompressImage(
                $request->file("kondisi.$id.foto"),
                'laporan/kondisi/'
            );
        }


            LaporanKondisi::create([
                'laporan_id' => $laporan->id,
                'kondisi_id' => $id,
                'nama_kondisi' => $kondisiModel->nama_kondisi,
               'status'       => $data['status'] ?? 'Baik',
                'deskripsi'     => $data['deskripsi'] ?? null,
                'foto'         => $fotoPath,
            ]);

            StatusKondisi::updateOrCreate(
                [
                    'kendaraan_id' => $laporan->kendaraan_id,
                    'kondisi_id' => $id,
                ],
                [
                    'status'       => $data['status'] ?? 'Baik',
                    
                ]
            );

             if (($data['status'] ?? '') === 'Perlu Perhatian') {
            $kondisiBermasalah[] = $kondisiModel->nama_kondisi;
        }
        }

        return $kondisiBermasalah;
    }

    private function updatePeralatan(Request $request, ?array $peralatan, Laporan $laporan, int $kendaraanId): array
{
    $peralatanRusak = [];

    if (!$peralatan) {
        return $peralatanRusak;
    }

    foreach ($peralatan as $id => $data) {

        $peralatanModel = Peralatan::where('kendaraan_id', $kendaraanId)
            ->where('id', $id)
            ->first();

        if (!$peralatanModel) {
            continue;
        }

        // Cari data laporan peralatan yang sudah ada
        $laporanPeralatan = LaporanPeralatan::where('laporan_id', $laporan->id)
            ->where('peralatan_id', $id)
            ->first();

        if (!$laporanPeralatan) {
            continue;
        }

        // Gunakan foto lama sebagai default
        $fotoPath = $laporanPeralatan->foto;

        // Jika user upload foto baru
        if ($request->hasFile("peralatan.$id.foto")) {

            // Hapus foto lama
            if (
                $laporanPeralatan->foto &&
                Storage::disk('public')->exists($laporanPeralatan->foto)
            ) {
                Storage::disk('public')->delete($laporanPeralatan->foto);
            }

            // Upload foto baru
            $fotoPath = $this->uploadAndCompressImage(
                $request->file("peralatan.$id.foto"),
                'laporan/peralatan/'
            );
        }

        // Update data
        $laporanPeralatan->update([
            'nama_peralatan' => $peralatanModel->nama_alat,
            'jumlah_awal'    => $peralatanModel->jumlah,
            'jumlah'         => $data['jumlah'] ?? 0,
            'kondisi'        => $data['kondisi'] ?? 'Baik',
            'deskripsi'     => $data['deskripsi'] ?? null,
            'foto'           => $fotoPath,
            'foto_dihapus_admin' => $fotoPath ? false : $laporanPeralatan->foto_dihapus_admin,
        ]);

        // Update status peralatan
        StatusPeralatan::updateOrCreate(
            [
                'kendaraan_id' => $laporan->kendaraan_id,
                'peralatan_id' => $id,
            ],
            [
                'status' => $data['kondisi'] ?? 'Baik',
            ]
        );

        // Simpan daftar peralatan rusak
        if (($data['kondisi'] ?? 'Baik') === 'Rusak Berat') {
            $peralatanRusak[] = $peralatanModel->nama_alat;
        }
    }

    return $peralatanRusak;
}
   private function updateKondisi(Request $request, ?array $kondisi, Laporan $laporan, int $kendaraanId): array
{
    $kondisiBermasalah = [];

    if (!$kondisi) {
        return $kondisiBermasalah;
    }

    foreach ($kondisi as $id => $data) {

        $kondisiModel = Kondisi::find($id);

        if (!$kondisiModel) {
            continue;
        }

        // Cari data laporan kondisi yang sudah ada
        $laporanKondisi = LaporanKondisi::where('laporan_id', $laporan->id)
            ->where('kondisi_id', $id)
            ->first();

        if (!$laporanKondisi) {
            continue;
        }

        // Gunakan foto lama
        $fotoPath = $laporanKondisi->foto;

        // Jika upload foto baru
        if ($request->hasFile("kondisi.$id.foto")) {

            // Hapus foto lama
            if (
                $laporanKondisi->foto &&
                Storage::disk('public')->exists($laporanKondisi->foto)
            ) {
                Storage::disk('public')->delete($laporanKondisi->foto);
            }

            // Upload foto baru
            $fotoPath = $this->uploadAndCompressImage(
                $request->file("kondisi.$id.foto"),
                'laporan/kondisi/'
            );
        }

        // Update laporan kondisi
        $laporanKondisi->update([
            'nama_kondisi' => $kondisiModel->nama_kondisi,
            'status'       => $data['status'] ?? 'Baik',
            'foto'         => $fotoPath,
            'deskripsi'     => $data['deskripsi'] ?? null,
            'foto_dihapus_admin' => $fotoPath ? false : $laporanKondisi->foto_dihapus_admin,
        ]);

        // Update status kendaraan
        StatusKondisi::updateOrCreate(
            [
                'kendaraan_id' => $laporan->kendaraan_id,
                'kondisi_id'   => $id,
            ],
            [
                'status' => $data['status'] ?? 'Baik',
            ]
        );

        // Simpan kondisi yang bermasalah
        if (($data['status'] ?? 'Baik') === 'Perlu Perhatian') {
            $kondisiBermasalah[] = $kondisiModel->nama_kondisi;
        }
    }

    return $kondisiBermasalah;
}
    /**
     * Kirim notifikasi untuk store (laporan baru)
     */
    private function sendStoreNotifications(Laporan $laporan, array $peralatanRusak, array $kondisiBermasalah): void
    {
        $recipients = $this->getAdminRecipients();

        // Notifikasi peralatan rusak
        if (!empty($peralatanRusak)) {
            foreach ($recipients as $user) {
                $user->notify(new PeralatanRusakNotification($laporan, $peralatanRusak));
            }
        }

        // Notifikasi kondisi bermasalah
        if (!empty($kondisiBermasalah)) {
            foreach ($recipients as $user) {
                $user->notify(new KondisiKendaraanNotification($laporan, $kondisiBermasalah));
            }
        }

        // Notifikasi laporan baru
        foreach ($recipients as $user) {
            $user->notify(new LaporanBaruNotification($laporan));
        }
    }

    /**
     * Kirim notifikasi untuk update
     */
    private function sendUpdateNotifications(Laporan $laporan, array $peralatanRusak, array $kondisiBermasalah): void
    {
        $recipients = $this->getAdminRecipients();

        // Notifikasi peralatan rusak
        if (!empty($peralatanRusak)) {
            foreach ($recipients as $user) {
                $user->notify(new PeralatanRusakNotification($laporan, $peralatanRusak));
            }
        }

        // Notifikasi kondisi bermasalah
        if (!empty($kondisiBermasalah)) {
            foreach ($recipients as $user) {
                $user->notify(new KondisiKendaraanNotification($laporan, $kondisiBermasalah));
            }
        }

        // Notifikasi laporan diupdate
            // foreach ($recipients as $user) {
            //     $user->notify(new LaporanBaruNotification($laporan));
            // }
    }

    /**
     * Get daftar admin dan pemantau
     */
    private function getAdminRecipients(): \Illuminate\Database\Eloquent\Collection
    {
        return User::whereIn('role', ['admin', 'admin2'])->get();
    }
}