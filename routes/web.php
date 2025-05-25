<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlatfromController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ToggleUserPlatformController;
use App\Http\Controllers\UploadTemporatyAttachmentsController;
use App\Services\PlatformService;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::get('dashboard', HomeController::class)->name('dashboard');

    Route::resource('posts', PostController::class)->except('show')->names('posts');
    Route::get('platforms', [PlatfromController::class, 'index'])->name('platform.index');
    Route::post('toggle/platform', ToggleUserPlatformController::class)->name('platform.toggle');
});

// Uploading Attachments
Route::post('/attachments/upload', [UploadTemporatyAttachmentsController::class, 'uploadAttachments'])->name('upload');
Route::post('/attachments/revert', [UploadTemporatyAttachmentsController::class, 'revertAttachments'])->name('revert');



Route::get('/test', function () {
    return Inertia::render('test');
})->name('home');
Route::get('/test2', function () {
    return Inertia::render('test2');
})->name('home');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';