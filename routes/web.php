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

Route::get('/redirect',  [\App\Http\Controllers\HomeController::class, 'redirect'])->name('redirect');

Route::post('/contact/send', [\App\Http\Controllers\ContactController::class, 'sendMessage'])->name('send-email');

Auth::routes();
Auth::routes(['register' => false]); // Desativa a rota padrão de registro

Route::group(['middleware' => 'isCliente'], function () {
    Route::get('/users/workspace', [\App\Http\Controllers\UserController::class, 'workspace'])->name('workspace');
    Route::get('/users/workspace/files', [\App\Http\Controllers\UserController::class, 'getFolderFiles'])->name('workspace.files');
});

Route::group(['middleware' => 'isAdmin'], function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/users/dashboard/files', [\App\Http\Controllers\UserController::class, 'getClienteFolderFiles'])->name('dashboard.files');
    Route::get('/users/dashboard/activities', [\App\Http\Controllers\UserController::class, 'getAdminActivities'])->name('dashboard.activities');

    Route::get('/users/list', [\App\Http\Controllers\UserController::class, 'list'])->name('user-list');
    Route::get('/users/new',  [\App\Http\Controllers\UserController::class, 'new'])->name('user-add');
    Route::post('users/register', [\App\Http\Controllers\UserController::class, 'register'])->name('user-register');
    Route::get('/users/remove/{id}',  [\App\Http\Controllers\UserController::class, 'remove'])->name('user-remove');
    //Files

    Route::get('/files/list', [\App\Http\Controllers\FileController::class, 'list'])->name('list-files');
    Route::get('/files/save',  [\App\Http\Controllers\FileController::class, 'new'])->name('files.save');
    Route::get('/files/remove/{id}',  [\App\Http\Controllers\FileController::class, 'delete'])->name('remove-file');

    //Folder
    Route::get('/folders/list', [\App\Http\Controllers\FolderController::class, 'list'])->name('list-folder');
    Route::get('/folders/new',  [\App\Http\Controllers\FolderController::class, 'new'])->name('add-folder');
    Route::get('/folders/remove/{id}',  [\App\Http\Controllers\FolderController::class, 'delete'])->name('remove-folder');
});
