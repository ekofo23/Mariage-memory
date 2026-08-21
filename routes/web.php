<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Auth\LoginController;



// Routes Publiques
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/album', [HomeController::class, 'album'])->name('album');
Route::get('/assistance', [HomeController::class, 'contact'])->name('contact');

// Route Dashboard (Espace Admin)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes d'authentification Breeze
require __DIR__.'/auth.php';


Route::get('/album', [AlbumController::class, 'index'])->name('album');



Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/album', [AlbumController::class, 'index'])->name('album');
Route::get('/album/download/{photo}', [AlbumController::class, 'download'])->name('album.download');
Route::get('/album', [AlbumController::class, 'index'])->name('album');
Route::get('/album/download-all', [AlbumController::class, 'downloadZip'])->name('album.downloadZip');
Route::get('/album/download/{photo}', [AlbumController::class, 'download'])->name('album.download');


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('photos', PhotoController::class);
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');