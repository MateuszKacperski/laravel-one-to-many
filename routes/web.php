<?php

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Guest\HomeController as GuestHomeController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Guest\ProjectController as GuestProjectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', GuestHomeController::class )->name('guest.home');
Route::get('/projects/{slug}', [GuestProjectController::class, 'show'])->name('guest.projects.show');


Route::prefix('/admin')->name('admin.')->middleware('auth')->group(function(){
    Route::get('',AdminHomeController::class)->name('home');


    Route::get('/projects/trash', [AdminProjectController::class, 'trash'])->name('projects.trash');
    Route::patch('/projects/{project}/restore', [AdminProjectController::class, 'restore'])->name('projects.restore')->withTrashed();
    Route::delete('/projects/{project}drop', [AdminProjectController::class, 'drop'])->name('projects.drop')->withTrashed();

    Route::resource('projects', AdminProjectController::class)->withTrashed(['show', 'edit', 'update']); 
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->withTrashed();
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->withTrashed();
});

require __DIR__.'/auth.php';
