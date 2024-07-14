<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
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

Route::get('/', [BlogController::class,'index'])->name('index')->middleware('auth');//初期画面
Route::get('/post/create',[BlogController::class,'post'])->name('post');//新しい投稿画面view側から遷移
Route::post('/post/create',[BlogController::class,'upload'])->name('upload');
Route::post('/post/good', [BlogController::class, 'good'])->name('good')->middleware('auth');

Route::get('/post/comment/{blog}',[BlogController::class,'comment'])->name('comment');//投稿に対するコメント画面
Route::post('/post/comment/{blog}',[BlogController::class,'commentUpload'])->name('commentUpload');//コメント保存

Route::get('/post/{blog}',[BlogController::class,'show'])->name('show');//投稿詳細画面


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
