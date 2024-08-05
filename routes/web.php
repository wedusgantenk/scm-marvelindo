<?php

use App\Http\Controllers\Admin\ClusterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard')->middleware(['auth']);
Route::get('logout', [App\Http\Controllers\Admin\PetugasController::class, 'logout'])->name('logout');
Route::get('profil', [App\Http\Controllers\Admin\ProfilController::class, 'index'])->name('admin.profil')->middleware(['checkRole:admin']);

Route::get('change/password', [App\Http\Controllers\Admin\SettingsController::class, 'updatePasswordForm'])
    ->name('update.password')
    ->middleware('auth');

Route::post('change/password', [App\Http\Controllers\Admin\SettingsController::class, 'updatePassword'])
    ->middleware('auth');

Route::get('jenisbarang', [App\Http\Controllers\Admin\JenisBarangController::class, 'index'])->name('admin.jenis_barang')->middleware(['checkRole:admin']);
Route::get('jenisbarang/create', [App\Http\Controllers\Admin\JenisBarangController::class, 'create'])->name('admin.jenis_barang.create')->middleware(['checkRole:admin']);
Route::post('jenisbarang/create', [App\Http\Controllers\Admin\JenisBarangController::class, 'store'])->name('admin.jenis_barang.store')->middleware(['checkRole:admin']);
Route::get('jenisbarang/edit/{id}', [App\Http\Controllers\Admin\JenisBarangController::class, 'edit'])->name('admin.jenis_barang.edit')->middleware(['checkRole:admin']);
Route::patch('jenisbarang/edit/{id}/update', [App\Http\Controllers\Admin\JenisBarangController::class, 'update'])->name('admin.jenis_barang.update')->middleware(['checkRole:admin']);
Route::delete('jenisbarang/delete/{id}', [App\Http\Controllers\Admin\JenisBarangController::class, 'destroy'])->name('admin.jenis_barang.delete')->middleware(['checkRole:admin']);

Route::get('barang', [App\Http\Controllers\Admin\BarangController::class, 'index'])->name('admin.barang')->middleware(['checkRole:admin']);
Route::get('barang/create', [App\Http\Controllers\Admin\BarangController::class, 'create'])->name('admin.barang.create')->middleware(['checkRole:admin']);
Route::post('barang/create', [App\Http\Controllers\Admin\BarangController::class, 'store'])->name('admin.barang.store')->middleware(['checkRole:admin']);
Route::get('barang/edit/{id}', [App\Http\Controllers\Admin\BarangController::class, 'edit'])->name('admin.barang.edit')->middleware(['checkRole:admin']);
Route::patch('barang/edit/{id}/update', [App\Http\Controllers\Admin\BarangController::class, 'update'])->name('admin.barang.update')->middleware(['checkRole:admin']);
Route::delete('barang/delete/{id}', [App\Http\Controllers\Admin\BarangController::class, 'destroy'])->name('admin.barang.delete')->middleware(['checkRole:admin']);
Route::get('barang/import', [App\Http\Controllers\Admin\BarangController::class, 'import'])->name('admin.barang.import')->middleware(['checkRole:admin']);
Route::post('barang/import', [App\Http\Controllers\Admin\BarangController::class, 'import_excel'])->name('admin.barang.import_excel')->middleware(['checkRole:admin']);
Route::get('barang/export', [App\Http\Controllers\Admin\BarangController::class, 'export'])->name('admin.barang.export')->middleware(['checkRole:admin']);


Route::get('bts', [App\Http\Controllers\Admin\BtsController::class, 'index'])->name('admin.bts')->middleware(['checkRole:admin']);
Route::get('bts/create', [App\Http\Controllers\Admin\BtsController::class, 'create'])->name('admin.bts.create')->middleware(['checkRole:admin']);
Route::post('bts/create', [App\Http\Controllers\Admin\BtsController::class, 'store'])->name('admin.bts.store')->middleware(['checkRole:admin']);
Route::get('bts/edit/{id}', [App\Http\Controllers\Admin\BtsController::class, 'edit'])->name('admin.bts.edit')->middleware(['checkRole:admin']);
Route::patch('bts/edit/{id}/update', [App\Http\Controllers\Admin\BtsController::class, 'update'])->name('admin.bts.update')->middleware(['checkRole:admin']);
Route::delete('bts/delete/{id}', [App\Http\Controllers\Admin\BtsController::class, 'destroy'])->name('admin.bts.delete')->middleware(['checkRole:admin']);

Route::get('cluster', [App\Http\Controllers\Admin\ClusterController::class, 'index'])->name('admin.cluster')->middleware(['checkRole:admin']);
Route::post('cluster', [App\Http\Controllers\Admin\ClusterController::class, 'store'])->name('admin.cluster.store')->middleware(['checkRole:admin']);
Route::put('cluster/{id}', [App\Http\Controllers\Admin\ClusterController::class, 'update'])->name('admin.cluster.update')->middleware(['checkRole:admin']);
Route::delete('cluster/{id}', [App\Http\Controllers\Admin\ClusterController::class, 'destroy'])->name('admin.cluster.delete')->middleware(['checkRole:admin']);
Route::get('cluster/export', [App\Http\Controllers\Admin\ClusterController::class, 'export'])->name('admin.cluster.export')->middleware(['checkRole:admin']);
Route::post('cluster/import', [App\Http\Controllers\Admin\ClusterController::class, 'import'])->name('admin.cluster.import')->middleware(['checkRole:admin']);

Route::get('depo', [App\Http\Controllers\Admin\DepoController::class, 'index'])->name('admin.depo')->middleware(['checkRole:admin']);
Route::get('depo/create', [App\Http\Controllers\Admin\DepoController::class, 'create'])->name('admin.depo.create')->middleware(['checkRole:admin']);
Route::post('depo/create', [App\Http\Controllers\Admin\DepoController::class, 'store'])->name('admin.depo.store')->middleware(['checkRole:admin']);
Route::get('depo/edit/{id}', [App\Http\Controllers\Admin\DepoController::class, 'edit'])->name('admin.depo.edit')->middleware(['checkRole:admin']);
Route::patch('depo/edit/{id}/update', [App\Http\Controllers\Admin\DepoController::class, 'update'])->name('admin.depo.update')->middleware(['checkRole:admin']);
Route::delete('depo/{id}', [App\Http\Controllers\Admin\DepoController::class, 'destroy'])->name('admin.depo.delete')->middleware(['checkRole:admin']);

Route::get('transaksi/distribusi_depo', [App\Http\Controllers\Admin\TransaksiDepoController::class, 'index'])->name('admin.transaksi.distribusi_depo')->middleware(['checkRole:admin']);
Route::get('transaksi/distribusi_depo/create', [App\Http\Controllers\Admin\TransaksiDepoController::class, 'create'])->name('admin.transaksi.distribusi_depo.create')->middleware(['checkRole:admin']);
Route::post('transaksi/distribusi_depo/create', [App\Http\Controllers\Admin\TransaksiDepoController::class, 'store'])->name('admin.transaksi.distribusi_depo.store')->middleware(['checkRole:admin']);
Route::get('transaksi/distribusi_depo/edit/{id}', [App\Http\Controllers\Admin\TransaksiDepoController::class, 'edit'])->name('admin.transaksi.distribusi_depo.edit')->middleware(['checkRole:admin']);
Route::patch('transaksi/distribusi_depo/edit/{id}/update', [App\Http\Controllers\Admin\TransaksiDepoController::class, 'update'])->name('admin.transaksi.distribusi_depo.update')->middleware(['checkRole:admin']);
Route::delete('transaksi/distribusi_depo/{id}', [App\Http\Controllers\Admin\TransaksiDepoController::class, 'destroy'])->name('admin.transaksi.distribusi_depo.delete')->middleware(['checkRole:admin']);
Route::get('transaksi/distribusi_depo/import', [App\Http\Controllers\Admin\TransaksiDepoController::class, 'import'])->name('admin.transaksi.distribusi_depo.import')->middleware(['checkRole:admin']);
Route::post('transaksi/distribusi_depo/import', [App\Http\Controllers\Admin\TransaksiDepoController::class, 'import_excel'])->name('admin.transaksi.distribusi_depo.import_excel')->middleware(['checkRole:admin']);
Route::get('transaksi/distribusi_depo/histori/{id}', [App\Http\Controllers\Admin\TransaksiDepoController::class, 'histori'])->name('admin.transaksi.distribusi_depo.histori')->middleware(['checkRole:admin']);

Route::get('transaksi/distribusi_sales', [App\Http\Controllers\Admin\TransaksiSalesController::class, 'index'])->name('admin.transaksi.distribusi_sales')->middleware(['checkRole:admin']);
Route::get('transaksi/distribusi_sales/create', [App\Http\Controllers\Admin\TransaksiSalesController::class, 'create'])->name('admin.transaksi.distribusi_sales.create')->middleware(['checkRole:admin']);
Route::post('transaksi/distribusi_sales/create', [App\Http\Controllers\Admin\TransaksiSalesController::class, 'store'])->name('admin.transaksi.distribusi_sales.store')->middleware(['checkRole:admin']);
Route::get('transaksi/distribusi_sales/edit/{id}', [App\Http\Controllers\Admin\TransaksiSalesController::class, 'edit'])->name('admin.transaksi.distribusi_sales.edit')->middleware(['checkRole:admin']);
Route::patch('transaksi/distribusi_sales/edit/{id}/update', [App\Http\Controllers\Admin\TransaksiSalesController::class, 'update'])->name('admin.transaksi.distribusi_sales.update')->middleware(['checkRole:admin']);
Route::delete('transaksi/distribusi_sales/{id}', [App\Http\Controllers\Admin\TransaksiSalesController::class, 'destroy'])->name('admin.transaksi.distribusi_sales.delete')->middleware(['checkRole:admin']);
Route::get('transaksi/distribusi_sales/import', [App\Http\Controllers\Admin\TransaksiSalesController::class, 'import'])->name('admin.transaksi.distribusi_sales.import')->middleware(['checkRole:admin']);
Route::post('transaksi/distribusi_sales/import', [App\Http\Controllers\Admin\TransaksiSalesController::class, 'import_excel'])->name('admin.transaksi.distribusi_sales.import_excel')->middleware(['checkRole:admin']);
Route::get('transaksi/distribusi_sales/histori/{id}', [App\Http\Controllers\Admin\TransaksiSalesController::class, 'histori'])->name('admin.transaksi.distribusi_sales.histori')->middleware(['checkRole:admin']);

Route::get('transaksi/distribusi_depo/detail', [App\Http\Controllers\Admin\TransaksiDepoDetailController::class, 'index'])->name('admin.transaksi.distribusi_depo.detail')->middleware(['checkRole:admin']);
Route::get('transaksi/distribusi_depo/detail/create', [App\Http\Controllers\Admin\TransaksiDepoDetailController::class, 'create'])->name('admin.transaksi.distribusi_depo.detail.create')->middleware(['checkRole:admin']);
Route::post('transaksi/distribusi_depo/detail/create', [App\Http\Controllers\Admin\TransaksiDepoDetailController::class, 'store'])->name('admin.transaksi.distribusi_depo.detail.store')->middleware(['checkRole:admin']);
Route::get('transaksi/distribusi_depo/detail/edit/{id}', [App\Http\Controllers\Admin\TransaksiDepoDetailController::class, 'edit'])->name('admin.transaksi.distribusi_depo.detail.edit')->middleware(['checkRole:admin']);
Route::patch('transaksi/distribusi_depo/detail/edit/{id}/update', [App\Http\Controllers\Admin\TransaksiDepoDetailController::class, 'update'])->name('admin.transaksi.distribusi_depo.detail.update')->middleware(['checkRole:admin']);
Route::delete('transaksi/distribusi_depo/detail/{id}', [App\Http\Controllers\Admin\TransaksiDepoDetailController::class, 'destroy'])->name('admin.transaksi.distribusi_depo.detail.delete')->middleware(['checkRole:admin']);

Route::get('transaksi/distribusi_sales/detail', [App\Http\Controllers\Admin\TransaksiSalesDetailController::class, 'index'])->name('admin.transaksi.distribusi_sales.detail')->middleware(['checkRole:admin']);
Route::get('transaksi/distribusi_sales/detail/create', [App\Http\Controllers\Admin\TransaksiSalesDetailController::class, 'create'])->name('admin.transaksi.distribusi_sales.detail.create')->middleware(['checkRole:admin']);
Route::post('transaksi/distribusi_sales/detail/create', [App\Http\Controllers\Admin\TransaksiSalesDetailController::class, 'store'])->name('admin.transaksi.distribusi_sales.detail.store')->middleware(['checkRole:admin']);
Route::get('transaksi/distribusi_sales/detail/edit/{id}', [App\Http\Controllers\Admin\TransaksiSalesDetailController::class, 'edit'])->name('admin.transaksi.distribusi_sales.detail.edit')->middleware(['checkRole:admin']);
Route::patch('transaksi/distribusi_sales/detail/edit/{id}/update', [App\Http\Controllers\Admin\TransaksiSalesDetailController::class, 'update'])->name('admin.transaksi.distribusi_sales.detail.update')->middleware(['checkRole:admin']);
Route::delete('transaksi/distribusi_sales/detail/{id}', [App\Http\Controllers\Admin\TransaksiSalesDetailController::class, 'destroy'])->name('admin.transaksi.distribusi_sales.detail.delete')->middleware(['checkRole:admin']);

Route::get('jenisoutlet', [App\Http\Controllers\Admin\JenisOutletController::class, 'index'])->name('admin.jenis_outlet')->middleware(['checkRole:admin']);
Route::get('jenisoutlet/create', [App\Http\Controllers\Admin\JenisOutletController::class, 'create'])->name('admin.jenis_outlet.create')->middleware(['checkRole:admin']);
Route::post('jenisoutlet/create', [App\Http\Controllers\Admin\JenisOutletController::class, 'store'])->name('admin.jenis_outlet.store')->middleware(['checkRole:admin']);
Route::get('jenisoutlet/edit/{id}', [App\Http\Controllers\Admin\JenisOutletController::class, 'edit'])->name('admin.jenis_outlet.edit')->middleware(['checkRole:admin']);
Route::patch('jenisoutlet/edit/{id}/update', [App\Http\Controllers\Admin\JenisOutletController::class, 'update'])->name('admin.jenis_outlet.update')->middleware(['checkRole:admin']);
Route::delete('jenisoutlet/delete/{id}', [App\Http\Controllers\Admin\JenisOutletController::class, 'destroy'])->name('admin.jenis_outlet.delete')->middleware(['checkRole:admin']);

Route::get('outlet', [App\Http\Controllers\Admin\OutletController::class, 'index'])->name('admin.outlet')->middleware(['checkRole:admin']);
Route::get('outlet/create', [App\Http\Controllers\Admin\OutletController::class, 'create'])->name('admin.outlet.create')->middleware(['checkRole:admin']);
Route::post('outlet/create', [App\Http\Controllers\Admin\OutletController::class, 'store'])->name('admin.outlet.store')->middleware(['checkRole:admin']);
Route::get('outlet/edit/{id}', [App\Http\Controllers\Admin\OutletController::class, 'edit'])->name('admin.outlet.edit')->middleware(['checkRole:admin']);
Route::patch('outlet/edit/{id}/update', [App\Http\Controllers\Admin\OutletController::class, 'update'])->name('admin.outlet.update')->middleware(['checkRole:admin']);
Route::delete('outlet/delete/{id}', [App\Http\Controllers\Admin\OutletController::class, 'destroy'])->name('admin.outlet.delete')->middleware(['checkRole:admin']);

Route::get('petugas', [App\Http\Controllers\Admin\PetugasController::class, 'index'])->name('admin.petugas')->middleware(['checkRole:admin']);
Route::get('petugas/create', [App\Http\Controllers\Admin\PetugasController::class, 'create'])->name('admin.petugas.create')->middleware(['checkRole:admin']);
Route::post('petugas/create', [App\Http\Controllers\Admin\PetugasController::class, 'store'])->name('admin.petugas.store')->middleware(['checkRole:admin']);
Route::get('petugas/edit/{id}', [App\Http\Controllers\Admin\PetugasController::class, 'edit'])->name('admin.petugas.edit')->middleware(['checkRole:admin']);
Route::patch('petugas/edit/{id}/update', [App\Http\Controllers\Admin\PetugasController::class, 'update'])->name('admin.petugas.update')->middleware(['checkRole:admin']);
Route::delete('petugas/delete/{id}', [App\Http\Controllers\Admin\PetugasController::class, 'destroy'])->name('admin.petugas.delete')->middleware(['checkRole:admin']);

Route::get('sales', [App\Http\Controllers\Admin\SalesController::class, 'index'])->name('admin.sales')->middleware(['checkRole:admin']);
Route::get('sales/create', [App\Http\Controllers\Admin\SalesController::class, 'create'])->name('admin.sales.create')->middleware(['checkRole:admin']);
Route::post('sales/create', [App\Http\Controllers\Admin\SalesController::class, 'store'])->name('admin.sales.store')->middleware(['checkRole:admin']);
Route::get('sales/edit/{id}', [App\Http\Controllers\Admin\SalesController::class, 'edit'])->name('admin.sales.edit')->middleware(['checkRole:admin']);
Route::patch('sales/edit/{id}/update', [App\Http\Controllers\Admin\SalesController::class, 'update'])->name('admin.sales.update')->middleware(['checkRole:admin']);
Route::delete('sales/delete/{id}', [App\Http\Controllers\Admin\SalesController::class, 'destroy'])->name('admin.sales.delete')->middleware(['checkRole:admin']);

Route::get('brg_masuk', [App\Http\Controllers\Admin\BarangMasukController::class, 'index'])->name('admin.brg_masuk')->middleware(['checkRole:admin']);
Route::get('brg_masuk/create', [App\Http\Controllers\Admin\BarangMasukController::class, 'create'])->name('admin.brg_masuk.create')->middleware(['checkRole:admin']);
Route::post('brg_masuk/create', [App\Http\Controllers\Admin\BarangMasukController::class, 'store'])->name('admin.brg_masuk.store')->middleware(['checkRole:admin']);
Route::get('brg_masuk/edit/{id}', [App\Http\Controllers\Admin\BarangMasukController::class, 'edit'])->name('admin.brg_masuk.edit')->middleware(['checkRole:admin']);
Route::patch('brg_masuk/edit/{id}/update', [App\Http\Controllers\Admin\BarangMasukController::class, 'update'])->name('admin.brg_masuk.update')->middleware(['checkRole:admin']);
Route::get('brg_masuk/delete/{id}', [App\Http\Controllers\Admin\BarangMasukController::class, 'destroy'])->name('admin.brg_masuk.delete')->middleware(['checkRole:admin']);
Route::get('brg_masuk/import', [App\Http\Controllers\Admin\BarangMasukController::class, 'import'])->name('admin.brg_masuk.import')->middleware(['checkRole:admin']);
Route::post('brg_masuk/import', [App\Http\Controllers\Admin\BarangMasukController::class, 'import_excel'])->name('admin.brg_masuk.import_excel')->middleware(['checkRole:admin']);
Route::get('brg_masuk/export', [App\Http\Controllers\Admin\BarangMasukController::class, 'export'])->name('admin.brg_masuk.export')->middleware(['checkRole:admin']);


Route::get('detailbarang', [App\Http\Controllers\Admin\DetailBarangController::class, 'index'])->name('admin.detail_barang')->middleware(['checkRole:admin']);
Route::get('detailbarang/create', [App\Http\Controllers\Admin\DetailBarangController::class, 'create'])->name('admin.detail_barang.create')->middleware(['checkRole:admin']);
Route::post('detailbarang/create', [App\Http\Controllers\Admin\DetailBarangController::class, 'store'])->name('admin.detail_barang.store')->middleware(['checkRole:admin']);
Route::get('detailbarang/edit/{id}', [App\Http\Controllers\Admin\DetailBarangController::class, 'edit'])->name('admin.detail_barang.edit')->middleware(['checkRole:admin']);
Route::patch('detailbarang/edit/{id}/update', [App\Http\Controllers\Admin\DetailBarangController::class, 'update'])->name('admin.detail_barang.update')->middleware(['checkRole:admin']);
Route::delete('detailbarang/delete/{id}', [App\Http\Controllers\Admin\DetailBarangController::class, 'destroy'])->name('admin.detail_barang.delete')->middleware(['checkRole:admin']);

Route::get('histori', [App\Http\Controllers\Admin\HistoriBarangController::class, 'index'])->name('admin.histori_barang')->middleware(['checkRole:admin']);
Route::get('histori/create', [App\Http\Controllers\Admin\HistoriBarangController::class, 'create'])->name('admin.histori_barang.create')->middleware(['checkRole:admin']);
Route::post('histori/create', [App\Http\Controllers\Admin\HistoriBarangController::class, 'store'])->name('admin.histori_barang.store')->middleware(['checkRole:admin']);
Route::get('histori/edit/{id}', [App\Http\Controllers\Admin\HistoriBarangController::class, 'edit'])->name('admin.histori_barang.edit')->middleware(['checkRole:admin']);
Route::patch('histori/edit/{id}/update', [App\Http\Controllers\Admin\HistoriBarangController::class, 'update'])->name('admin.histori_barang.update')->middleware(['checkRole:admin']);
Route::delete('histori/delete/{id}', [App\Http\Controllers\Admin\HistoriBarangController::class, 'destroy'])->name('admin.histori_barang.delete')->middleware(['checkRole:admin']);

Route::get('stok_barang_depo', [App\Http\Controllers\Admin\StokdepoController::class, 'index'])->name('admin.stok_barang.depo')->middleware(['checkRole:admin']);
Route::get('stok_barang_depo/create', [App\Http\Controllers\Admin\StokdepoController::class, 'create'])->name('admin.stok_barang.depo.create')->middleware(['checkRole:admin']);
Route::post('stok_barang_depo/create', [App\Http\Controllers\Admin\StokdepoController::class, 'store'])->name('admin.stok_barang.depo.store')->middleware(['checkRole:admin']);
Route::get('stok_barang_depo/edit/{id}', [App\Http\Controllers\Admin\StokdepoController::class, 'edit'])->name('admin.stok_barang.depo.edit')->middleware(['checkRole:admin']);
Route::patch('stok_barang_depo/edit/{id}/update', [App\Http\Controllers\Admin\StokdepoController::class, 'update'])->name('admin.stok_barang.depo.update')->middleware(['checkRole:admin']);
Route::get('stok_barang_depo/delete/{id}', [App\Http\Controllers\Admin\StokdepoController::class, 'destroy'])->name('admin.stok_barang.depo.delete')->middleware(['checkRole:admin']);

Route::get('stok_barang_cluster', [App\Http\Controllers\Admin\StokclusterController::class, 'index'])->name('admin.stok_barang.cluster')->middleware(['checkRole:admin']);
Route::get('stok_barang_cluster/create', [App\Http\Controllers\Admin\StokclusterController::class, 'create'])->name('admin.stok_barang.cluster.create')->middleware(['checkRole:admin']);
Route::post('stok_barang_cluster/create', [App\Http\Controllers\Admin\StokclusterController::class, 'store'])->name('admin.stok_barang.cluster.store')->middleware(['checkRole:admin']);
Route::get('stok_barang_cluster/edit/{id}', [App\Http\Controllers\Admin\StokclusterController::class, 'edit'])->name('admin.stok_barang.cluster.edit')->middleware(['checkRole:admin']);
Route::patch('stok_barang_cluster/edit/{id}/update', [App\Http\Controllers\Admin\StokclusterController::class, 'update'])->name('admin.stok_barang.cluster.update')->middleware(['checkRole:admin']);
Route::get('stok_barang_cluster/delete/{id}', [App\Http\Controllers\Admin\StokclusterController::class, 'destroy'])->name('admin.stok_barang.cluster.delete')->middleware(['checkRole:admin']);

Route::get('hargabarang', [App\Http\Controllers\Admin\HargaBarangController::class, 'index'])->name('admin.harga_barang')->middleware(['checkRole:admin']);
Route::get('hargabarang/create', [App\Http\Controllers\Admin\HargaBarangController::class, 'create'])->name('admin.harga_barang.create')->middleware(['checkRole:admin']);
Route::post('hargabarang/create', [App\Http\Controllers\Admin\HargaBarangController::class, 'store'])->name('admin.harga_barang.store')->middleware(['checkRole:admin']);
Route::get('hargabarang/edit/{id}', [App\Http\Controllers\Admin\HargaBarangController::class, 'edit'])->name('admin.harga_barang.edit')->middleware(['checkRole:admin']);
Route::patch('hargabarang/edit/{id}/update', [App\Http\Controllers\Admin\HargaBarangController::class, 'update'])->name('admin.harga_barang.update')->middleware(['checkRole:admin']);
Route::delete('hargabarang/delete/{id}', [App\Http\Controllers\Admin\HargaBarangController::class, 'destroy'])->name('admin.harga_barang.delete')->middleware(['checkRole:admin']);
