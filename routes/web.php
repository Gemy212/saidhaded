<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminAuth;
use App\Models\Process;


Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::get('/process', function () {
    $steps = Process::orderBy('step_number', 'asc')->get();
    return view('process', compact('steps'));
})->name('process');

Route::middleware([AdminAuth::class])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/projects/create', [AdminController::class, 'createProject'])->name('admin.projects.create');
    Route::post('/projects/store', [AdminController::class, 'storeProject'])->name('admin.projects.store');

    Route::get('/projects/{id}/edit', [AdminController::class, 'editProject'])->name('admin.projects.edit');
    Route::post('/projects/{id}/update', [AdminController::class, 'updateProject'])->name('admin.projects.update');
    Route::post('/projects/{id}/delete', [AdminController::class, 'deleteProject'])->name('admin.projects.delete');

    Route::post('/quotes/{id}/status', [AdminController::class, 'updateQuoteStatus'])->name('admin.quotes.status');

    Route::get('/process/{id}/edit', [AdminController::class, 'editProcessStep'])->name('admin.process.edit');
    Route::post('/process/{id}/update', [AdminController::class, 'updateProcessStep'])->name('admin.process.update');

});
Route::post('/quote/store', [QuoteController::class, 'store'])->name('quote.store');
Route::get('/', [ProjectController::class, 'index'])->name('home');
Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
