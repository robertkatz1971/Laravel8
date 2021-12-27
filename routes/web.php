<?php

use App\Http\Controllers\CategoryController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BrandController;

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', [ContactController::class, 'index'])->name('contact');

//Categories
Route::get('/category/all', [CategoryController::class, 'index'])->name('all.category');
Route::post('/category/add', [CategoryController::class, 'store'])->name('store.category');
Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('edit.category');
Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('update.category');
Route::delete('/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy.category');
Route::delete('/category/restore/{id}', [CategoryController::class, 'restore'])->name('restore.category');
Route::get('/category/forceDelete/{id}', [CategoryController::class, 'forceDelete'])->name('forceDelete.category');

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    $users = User::all();
    return view('dashboard', ['users' => $users]);
})->name('dashboard');

//Brands
Route::get('/brand/all', [BrandController::class, 'index'])->name('all.brand');
Route::post('/brand/add', [BrandController::class, 'store'])->name('store.brand');
Route::get('/brand/edit/{id}', [BrandController::class, 'edit'])->name('edit.brand');
Route::put('/brand/update/{id}', [BrandController::class, 'update'])->name('update.brand');
Route::delete('/brand/destroy/{id}', [BrandController::class, 'destroy'])->name('destroy.brand');
Route::delete('/brand/restore/{id}', [BrandController::class, 'restore'])->name('restore.brand');
Route::get('/brand/forceDelete/{id}', [BrandController::class, 'forceDelete'])->name('forceDelete.brand');
