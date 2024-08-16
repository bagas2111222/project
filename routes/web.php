<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardrController;
use App\Http\Controllers\TahapanController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\StrukturController;


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Route::middleware(['auth', 'admin'])->group(function () {
//     // Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
//     // Tambahkan route lainnya yang hanya bisa diakses oleh admin
//     Route::get('/admin/projects', [ProjectController::class, 'index']);
//     Route::get('/admin/detail/{id_tahapan}', [DetailController::class, 'index']);
// });
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    // Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // Tambahkan route lainnya yang hanya bisa diakses oleh admin
    Route::get('/admin/detail/{id_tahapan}', [DetailController::class, 'index']);
    Route::get('/admin/projects', [ProjectController::class, 'index']);

});
Route::get('/admin', [DashboardrController::class, 'index']);

Route::get('/admin/projects', [ProjectController::class, 'index']);
Route::post('addProject', [ProjectController::class, 'addProject'])->name('addProject');
// Route::post('editProject', [ProjectController::class, 'editProject'])->name('editProject');
Route::post('admin/editProject', [ProjectController::class, 'editProject'])->name('admin.editProject');
Route::get('admin/project/destroy', [ProjectController::class, 'destroy'])->name('project.destroy');
Route::get('projects/{project}/destroy', [ProjectController::class, 'destroy'])->name('projects.destroy');




Route::get('/admin/perusahaan', [PerusahaanController::class, 'index']);
Route::post('addPerusahaan', [PerusahaanController::class, 'add'])->name('addPerusahaan');
Route::post('editPerusahaan', [PerusahaanController::class, 'edit'])->name('editPerusahaan');
Route::delete('perusahaan/{perusahaan}/destroy', [PerusahaanController::class, 'destroy'])->name('perusahaan.destroy');



Route::get('/admin/vendor', [VendorController::class, 'index']);
Route::post('addVendor', [VendorController::class, 'add'])->name('addVendor');
Route::post('editVendor', [VendorController::class, 'edit'])->name('editVendor');
Route::delete('Vendor/{vendor}/destroy', [VendorController::class, 'destroy'])->name('vendor.destroy');



Route::get('/admin/pegawai', [UserController::class, 'index']);
Route::post('addUser', [UserController::class, 'add'])->name('addUser');
Route::post('editUser', [UserController::class, 'edit'])->name('editUser');
Route::delete('User/{user}/destroy', [UserController::class, 'destroy'])->name('user.destroy');


Route::get('/admin/tahapan/{id_project}', [TahapanController::class, 'index']);
Route::post('addTahapan', [TahapanController::class, 'add'])->name('addTahapan');
Route::post('editTahapan', [TahapanController::class, 'edit'])->name('editTahapan');
Route::get('Tahapan/{tahapan}/destroy', [TahapanController::class, 'destroy'])->name('tahapan.destroy');
Route::post('uploadFile', [TahapanController::class, 'uploadFile'])->name('uploadFile');


Route::get('/admin/detail/{id_tahapan}', [DetailController::class, 'index']);
Route::post('addDetail', [DetailController::class, 'add'])->name('addDetail');
Route::post('editDetail', [DetailController::class, 'edit'])->name('editDetail');
Route::get('Detail/{detail}/destroy', [DetailController::class, 'destroy'])->name('detail.destroy');
Route::get('/admin/output/{id}', [DetailController::class, 'show']);



Route::get('/admin/struktur/{id_project}', [StrukturController::class, 'index']);
Route::post('addStruktur', [StrukturController::class, 'add'])->name('addStruktur');
Route::post('editStruktur', [StrukturController::class, 'edit'])->name('editStruktur');
Route::get('Struktur/{struktur}/destroy', [StrukturController::class, 'destroy'])->name('struktur.destroy');

Route::get('/admin/Profile', [UserController::class, 'adminProfile']);


//pegawai
Route::get('/', [DashboardrController::class, 'DataPegawai']);
Route::get('/dashboard', [DashboardrController::class, 'DataPegawai']);
Route::get('/pegawai/projects', [ProjectController::class, 'indexPegawai']);

Route::get('/pegawai/tahapan/{id_project}', [TahapanController::class, 'indexPegawai']);
Route::get('/pegawai/detail/{id_tahapan}', [DetailController::class, 'indexPegawai']);
Route::get('/pegawai/pegawai', [ProjectController::class, 'DataPegawai']);


Route::get('/pegawai/profile', [UserController::class, 'profile']);
Route::post('editProfile', [UserController::class, 'editProfile'])->name('editProfile');
