<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileEncryptionController;

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
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [FileEncryptionController::class, 'dashboard'])->name('dashboard');
    Route::get('/encrypt', [FileEncryptionController::class, 'encrypt'])->name('encrypt');
    Route::get('/decrypt', [FileEncryptionController::class, 'decrypt'])->name('decrypt');
    Route::post('/file', [FileEncryptionController::class, 'store'])->name('file.store');
    Route::post('/files/download/{id}', [FileEncryptionController::class, 'download'])->name('files.download');
    Route::delete('/file/{id}', [FileEncryptionController::class, 'delete'])->name('file.delete');


});

require __DIR__.'/auth.php';


