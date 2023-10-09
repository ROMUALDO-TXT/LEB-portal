<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
})->name('home');

Route::get('/home', function () {
    return view('welcome');
});


Route::get('/redirect',  [\App\Http\Controllers\HomeController::class, 'redirect'])->name('redirect');

Route::post('/contact/send', [\App\Http\Controllers\ContactController::class, 'sendMessage'])->name('send-email');

Auth::routes();
Auth::routes(['register' => false]); // Desativa a rota padrão de registro


Route::group(['middleware' => 'isCliente'], function () {
    Route::get('/workspace', [\App\Http\Controllers\UserController::class, 'workspace'])->name('workspace');
    Route::get('/workspace/files', [\App\Http\Controllers\FileController::class, 'getFolderFiles'])->name('workspace.files');
    Route::get('/workspace/download', [\App\Http\Controllers\FileController::class, 'downloadFile'])->name('workspace.download');
});

Route::group(['middleware' => 'isAdmin'], function () {
    Route::get('/dashboard', [\App\Http\Controllers\UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/activities', [\App\Http\Controllers\UserController::class, 'getAdminActivities'])->name('dashboard.activities');

    Route::post('/users/save',  [\App\Http\Controllers\UserController::class, 'save'])->name('users.save');
    Route::delete('/users/remove/{id}',  [\App\Http\Controllers\UserController::class, 'remove'])->name('users.remove');
    //Files

    Route::post('/files/save',  [\App\Http\Controllers\FileController::class, 'save'])->name('files.save');
    Route::delete('/files/remove/{id}',  [\App\Http\Controllers\FileController::class, 'remove'])->name('files.remove');
    Route::get('/dashboard/files', [\App\Http\Controllers\FileController::class, 'getClienteFolderFiles'])->name('dashboard.files');
    Route::get('/dashboard/preview', [\App\Http\Controllers\FileController::class, 'filePreview'])->name('dashboard.preview');

    //Folder
    Route::post('/folders/save',  [\App\Http\Controllers\FolderController::class, 'save'])->name('folders.save');
    Route::delete('/folders/remove/{id} ',  [\App\Http\Controllers\FolderController::class, 'remove'])->name('folders.remove');
    Route::get('/dashboard/download', [\App\Http\Controllers\FileController::class, 'downloadFile'])->name('download');
});
