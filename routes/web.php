<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/materials', \App\Http\Livewire\Materials::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/products', \App\Http\Livewire\Products::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/addnewproduct', \App\Http\Livewire\AddNewProduct::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/addnewmaterial', \App\Http\Livewire\AddNewMaterial::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/settings', \App\Http\Livewire\Settings::class);
