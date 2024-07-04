<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController; 
use App\Http\Controllers\EventController; 
use App\Http\Controllers\MemberEventPayController; 
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
    return view('toppage');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(GroupController::class)->middleware(['auth'])->group(function(){
    Route::get('/home','index')->name('user.index');
    Route::post('/groups','store')->name('group.store');
    Route::get('/groups/create','create')->name('group.create');
    Route::get('/groups/{group}','show')->name('group.show');
    Route::get('/groups/{group}/edit','edit')->name('group.edit');
    Route::put('/groups/{group}','update')->name('group.update');
    Route::delete('/groups/{group}','delete')->name('group.delete');
});

Route::controller(EventController::class)->middleware(['auth'])->group(function(){
    Route::post('/events','store')->name('event.store');
    Route::get('/groups/{group}/events/create','create')->name('event.create');
    Route::get('/events/{event}/edit','edit')->name('event.edit');
    Route::put('/events/{event}','update')->name('event.update');
    Route::delete('/events/{event}','delete')->name('group.delete');
});

//Route::controller(MemberEventPayController::class)->middleware(['auth'])->group(function(){
Route::controller(MemberEventPayController::class)->group(function(){
    Route::post('/member_event_pays','store')->name('member_event_pays.store');
    Route::get('/member_event_pays/create/events/{event}','create')->name('member_event_pays.create');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
