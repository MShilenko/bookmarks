<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookmarksController;

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

Route::get('/', [BookmarksController::class, 'index'])->name('bookmarks.index');
Route::resource('/bookmarks', BookmarksController::class)->except('index');