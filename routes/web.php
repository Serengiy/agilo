<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [PasswordController::class, 'index'])->middleware('auth')->name('home');


Route::controller(PasswordController::class)->middleware('auth')->prefix('password')->group(function (){
    Route::get('/create/{password?}', 'create')->name('create.password');
    Route::post('', 'store')->name('store.password');
    Route::get('generate', 'passwordGenerate')->name('generate.password');
    Route::delete('password/{password}', 'destroy')->name('delete.password');
});

Route::controller(ProjectController::class)->middleware('auth')->prefix('project')->group(function (){
    Route::get('index', 'index')->name('admin.projects.index');
    Route::get('create', 'create')->name('create.project.form');
    Route::get('project/{project}/add-user', 'rightsAccess')->name('project.user.access');
    Route::post('sore', 'store')->name('project.store');
    Route::post('project/{project}/toggle/{user}', 'projectToggle')->name('project.toggle');
    Route::get('show/{project}', 'show')->name('project.show');
    Route::delete('{project}', 'destroy')->name('project.destroy');
});

Route::controller(UserController::class)->middleware('auth')->prefix('user')->group(function (){
    Route::middleware('admin')->group(function (){
        Route::post('store', 'store')->name('admin.user.store');
        Route::get('create', 'create')->name('create.user.form');

        Route::get('index', 'index')->name('admin.users');
        Route::get('show/{user}', 'show')->name('user.show');
        Route::delete('{user}', 'destroy')->name('user.delete');
    });
    Route::post('/user/{user}/remove/{project}', 'removeAccess')->name('user.remove.access');

});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
