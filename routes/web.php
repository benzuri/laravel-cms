<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Livewire\SettingsTable;
use App\Livewire\CategoriesTable;
use App\Livewire\PostsTable;

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

Route::get('/', [PostController::class, 'index'])->name('welcome');
Route::get('/post/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/search', [PostController::class, 'searchByTitle'])->name('posts.search');
Route::get('/category/{slug}', [PostController::class, 'showByCategory'])->name('posts.category');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('/dashboard')
->group(function () {
    Route::get('/', [DashboardController:: class, 'index'])->name('dashboard');
    Route::get('/settings', SettingsTable::class)->name('dashboard.settings');
    Route::get('/categories', CategoriesTable::class)->name('dashboard.categories');
    Route::get('/posts', PostsTable::class)->name('dashboard.posts');
});
