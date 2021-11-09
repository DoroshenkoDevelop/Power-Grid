<?php

use App\Http\Livewire\Table;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::put('edit/{user}',[Table::class,'actions'])->name('user.edit');

Route::put('delete/{user}',[Table::class,'actions'])->name('user.destroy');

require __DIR__.'/auth.php';
