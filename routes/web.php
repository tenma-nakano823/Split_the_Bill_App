<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController; 
use App\Http\Controllers\EventController; 
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(GroupController::class)->middleware(['auth'])->group(function(){
    Route::get('/','index')->name('index');
    Route::post('/groups','store')->name('store');
    Route::get('/groups/create','create')->name('create');
    Route::get('/groups/{group}','show')->name('show');
    Route::get('/groups/{group}/edit','edit')->name('edit');
    Route::put('/groups/{group}','update')->name('update');
});

Route::controller(EventController::class)->middleware(['auth'])->group(function(){
    //Route::get('/groups/{group}','index')->name('index');
    Route::post('/groups/{group}/events','store')->name('store');
    Route::get('/groups/{group}/events/create','create')->name('create');
    Route::get('/groups/{group}/events/{event}/edit','edit')->name('edit');
    Route::put('/groups/{group}/events/{event}/','update')->name('update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
