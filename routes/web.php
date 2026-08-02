<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JenisMobilController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PeralatanController;
use App\Http\Controllers\KondisiController;
use App\Http\Controllers\PencarianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PemantauNotifikasiController;
use App\Http\Controllers\DashboardPemantauController;
use App\Http\Controllers\PoskoController;
use App\Http\Controllers\UserNotifikasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlatonController;
use App\Http\Controllers\ReguController;
use App\Models\JenisMobil;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\PeralatanKondisiController;
// use App\Http\Controllers\UserController;



    Route::get('/', function () {
    return view('auth.login');
});
Route::get('/siapa-saya', function () {
    return response()->json([
        'auth_check' => Auth::check(),
        'user' => Auth::user(),
        'session_id' => session()->getId(),
    ]);
});
Route::get('/paksa-logout', function () {
    Auth::guard('web')->logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return 'Logout berhasil';
});
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

//.................. Admin ..................//
Route::middleware(['auth', 'role:admin'])->group(function () {
//posko
Route::resource('posko', PoskoController::class);
//...... Jenis Mobil
Route::resource('posko.jenis-mobil', JenisMobilController::class);
//...... Kendaraan 
Route::get(
    'posko/{posko}/jenis-mobil/{jenis_mobil}/kendaraan/{kendaraan}/mutasi',
    [KendaraanController::class, 'mutasi']
)->name('posko.jenis-mobil.kendaraan.mutasi');

Route::put(
    'posko/{posko}/jenis-mobil/{jenis_mobil}/kendaraan/{kendaraan}/mutasi',
    [KendaraanController::class, 'prosesMutasi']
)->name('posko.jenis-mobil.kendaraan.prosesMutasi');

//.........Kendaraan
Route::resource('posko.jenis-mobil.kendaraan',KendaraanController::class );

//...... Peralatan
Route::resource('posko.jenis-mobil.kendaraan.peralatan', PeralatanController::class);
//....... Kondisi
Route::resource('posko.jenis-mobil.kendaraan.kondisi',KondisiController::class);
//........ Pencarian
Route::get('/pencarian', [PencarianController::class, 'index'])->name('pencarian.index');
Route::get('/pencarian/{kendaraan}',[PencarianController::class, 'show'])->name('pencarian.show');
Route::get('/api/jenis-mobil', function() {
    $poskoId = request('posko_id');
    return JenisMobil::where('posko_id', $poskoId)->get();
});

Route::get('/api/kendaraan', function() {
    $jenisMobilId = request('jenis_mobil_id');
    return Kendaraan::where('jenis_mobil_id', $jenisMobilId)->get();
});
//........ Laporan
Route::get('/admin/laporan', [LaporanController::class, 'adminIndex'])
    ->name('admin.laporan.index');
Route::get('/admin/laporan/{laporan}', [LaporanController::class, 'adminShow'])
    ->name('admin.laporan.show');
Route::put('/admin/laporan/{laporan}', [LaporanController::class, 'updateStatus'])
    ->name('admin.laporan.update');
//......... Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
Route::get('/dashboard/peralatan-rusak',[DashboardController::class, 'peralatanRusak'])
                ->name('admin.dashboard.peralatan-rusak');
Route::get('/dashboard/kondisi-bermasalah',[DashboardController::class, 'kondisiBermasalah'])
                ->name('admin.dashboard.kondisi-bermasalah');
//......... Notifikasi
Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'read'])->name('notifikasi.read');
Route::delete('/notifikasi/{id}', [NotifikasiController::class, 'destroy'])->name('notifikasi.destroy');
Route::delete('/notifikasi-dibaca/hapus', [NotifikasiController::class, 'deleteRead'])->name('notifikasi.deleteRead');
//.......... Pengelolaan Users
Route::get('/pengguna', [UserManagementController::class, 'index'])->name('pengguna.index');
Route::get('/pengguna/{user}/edit', [UserManagementController::class, 'edit'])
    ->name('pengguna.edit');
Route::put('/pengguna/{user}',[UserManagementController::class, 'update'])->name('pengguna.update');
Route::get('/pengguna/create-pemantau', [UserManagementController::class, 'createPemantau'])->name('pengguna.createPemantau');
Route::post('/pengguna/store-pemantau', [UserManagementController::class, 'storePemantau'])->name('pengguna.storePemantau');
Route::delete('/pengguna/{user}/nonaktifkan', [UserManagementController::class, 'nonaktifkan'])
    ->name('pengguna.nonaktifkan');
Route::post('/pengguna/{id}/restore', [UserManagementController::class, 'restore'])
    ->name('pengguna.restore');
Route::delete('/pengguna/{id}/force-delete',[UserManagementController::class, 'forceDelete'])->name('pengguna.forceDelete');
//...........Platon & Regu
Route::resource('platon', PlatonController::class);
Route::resource('regu', ReguController::class);
    
//.........Foto Peralatan-kondisi (Download & Haspus)
Route::get(
    '/admin/laporan/peralatan/{laporanPeralatan}/download',
    [PeralatanKondisiController::class, 'peralatanDownload']
)->name('admin.laporan-peralatan.download');

Route::delete(
    '/admin/laporan/peralatan/{laporanPeralatan}/foto',
    [PeralatanKondisiController::class, 'peralatanDestroy']
)->name('admin.laporan-peralatan.destroy-foto');

Route::get(
    '/admin/laporan/kondisi/{laporanKondisi}/download',
    [PeralatanKondisiController::class, 'kondisiDownload']
)->name('admin.laporan-kondisi.download');

Route::delete(
    '/admin/laporan/kondisi/{laporanKondisi}/foto',
    [PeralatanKondisiController::class, 'kondisiDestroy']
)->name('admin.laporan-kondisi.destroy-foto');
});


//...................Login Admin 2...............//
Route::middleware(['auth', 'role:admin2'])->group(function () {
Route::get('/pemantau', function () {return "Halaman Pemantau";});
Route::get('/pemantau/laporan', [LaporanController::class, 'pemantauIndex'])->name('pemantau.laporan.index');
Route::get('/pemantau/laporan/{laporan}', [LaporanController::class, 'pemantauShow'])->name('pemantau.laporan.show');
////dashboard
Route::get('/dashboard-pemantau', [DashboardPemantauController::class, 'index'])
                ->name('dashboard-pemantau');
Route::get('/dashboard-pemantau/alat-rusak',[DashboardController::class, 'alatrusak'])
                ->name('pemantau.dashboard.alat-rusak');
Route::get('/dashboard-pemantau/kondisi-masalah',[DashboardController::class, 'kondisimasalah'])
                ->name('pemantau.dashboard.kondisi-masalah');
    //notifikasi
Route::get('/pemantaunotifikasi', [PemantauNotifikasiController::class, 'index'])->name('pemantaunotifikasi.index');
Route::post('/pemantaunotifikasi/{id}/read', [PemantauNotifikasiController::class, 'read'])->name('pemantaunotifikasi.read');
Route::get('/pemantau/profile', [ProfileController::class, 'Pemantauedit'])
        ->name('pemantau.profil');
});


//...................Login User...............//
Route::middleware(['auth', 'role:user'])->group(function () {

Route::view('/laporan/export', 'user.Laporan.input')->name('laporan.input');
Route::resource('laporan', LaporanController::class)->only(['index','create','store','show']);
Route::get('/laporan/{laporan}/edit', [LaporanController::class, 'edit'])
    ->name('laporan.edit');
Route::put('/laporan/{laporan}', [LaporanController::class, 'update'])
    ->name('laporan.update');
Route::get('/laporan/posko/{posko}/jenis-mobil/{jenis}/kendaraan/{kendaraan}', [LaporanController::class, 'getKendaraanData']);
// posko/{posko}/jenis-mobil/{jenis}/kendaraan/{kendaraan}
Route::get('/laporan/posko/{id}', [LaporanController::class, 'getJenisMobilByPosko']);
Route::get('/laporan/posko/{posko}/jenis-mobil/{jenis}',[LaporanController::class, 'getKendaraanByJenis']);
Route::get('/dashboard-user', [DashboardUserController::class, 'index'])
    ->name('dashboard-user');
// Route::post('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');

// FORM EXPORT PERALATAN
Route::get('/laporan/{laporan}/export-peralatan', [LaporanController::class, 'showExportPeralatan'])
    ->name('laporan.export.peralatan.form');

Route::post('/laporan/{laporan}/export-peralatan', [LaporanController::class, 'exportPeralatanPdf'])
    ->name('laporan.export.peralatan');

// EXPORT KONDISI
Route::get('/laporan/{laporan}/export-kondisi', [LaporanController::class, 'showExportKondisi'])
    ->name('laporan.export.kondisi.form');

Route::post('/laporan/{laporan}/export-kondisi', [LaporanController::class, 'exportKondisiPdf'])
    ->name('laporan.export.kondisi');


    ///Notifikasi user

     Route::get(
        '/user/notifikasi',
        [UserNotifikasiController::class,'index']
    )->name('user.notifikasi.index');

    Route::post(
        '/user/notifikasi/{id}/read',
        [UserNotifikasiController::class,'read']
    )->name('user.notifikasi.read');

    Route::delete(
        '/user/notifikasi/{id}',
        [UserNotifikasiController::class,'destroy']
    )->name('user.notifikasi.destroy');

    Route::delete(
        '/user/notifikasi/delete-read',
        [UserNotifikasiController::class,'deleteRead']
    )->name('user.notifikasi.deleteRead');
});
//.............................//
Route::middleware('auth')->group(function () {
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
