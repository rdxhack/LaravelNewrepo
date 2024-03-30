<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/addpost', [App\Http\Controllers\HomeController::class, 'addpost'])->name('add.post');
Route::post('/storepost', [App\Http\Controllers\HomeController::class, 'storepost'])->name('store.post');
Route::post('/deletepost', [App\Http\Controllers\HomeController::class, 'deletepost'])->name('delete.post');
Route::post('/filterpost', [App\Http\Controllers\HomeController::class, 'filterpost'])->name('filter.post');
Route::get('/editpost/{id}', [App\Http\Controllers\HomeController::class, 'editpost'])->name('edit.post');
Route::post('/deleteimage', [App\Http\Controllers\HomeController::class, 'deleteimage'])->name('delete.image');
Route::post('/updatepost', [App\Http\Controllers\HomeController::class, 'updatepost'])->name('update.post');
