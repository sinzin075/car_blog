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
Route::middleware('auth')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index'); // 初期画面
    Route::get('/carList',[BlogController::class,'carList'])->name('carList');
    
    // Blog Routes
    Route::prefix('blogs')->name('blog.')->group(function () {
        Route::get('/create', [BlogController::class, 'post'])->name('post');
        Route::post('/', [BlogController::class, 'upload'])->name('upload');
        Route::post('/good', [BlogController::class, 'good'])->name('good');
        Route::delete('/delete/{blog}', [BlogController::class, 'destroy'])->name('destroy');
        Route::get('/comment/{blog}', [BlogController::class, 'comment'])->name('comment');
        Route::post('/comment/{blog}', [BlogController::class, 'commentUpload'])->name('commentUpload');
        Route::get('/{blog}', [BlogController::class, 'show'])->name('show');
    });

    // Event Routes
    Route::prefix('events')->name('event.')->group(function () {
        Route::get('/', [BlogController::class, 'event'])->name('event');
        Route::get('/create', [BlogController::class, 'EventPost'])->name('EventPost');
        Route::post('/create/upload', [BlogController::class, 'EventUpload'])->name('EventUpload');
        Route::post('/good', [BlogController::class, 'EventGood'])->name('EventGood');
        Route::delete('/delete/{event}', [BlogController::class, 'EventDestroy'])->name('EventDestroy');
        Route::get('/comment/{event}', [BlogController::class, 'EventComment'])->name('EventComment'); // 投稿に対するコメント画面
        Route::post('/comment/{event}', [BlogController::class, 'EventCommentUpload'])->name('EventCommentUpload'); // コメント保存
        Route::get('/{event}', [BlogController::class, 'EventShow'])->name('EventShow'); // 投稿詳細画面
    });

    Route::get('/status/{userId}', [BlogController::class, 'status'])->name('status');
    Route::get('/status/change/{userId}', [BlogController::class, 'statusChange'])->name('statusChange');
    Route::post('/status/change/upload/', [BlogController::class, 'statusChangeUpload'])->name('statusChangeUpload');
    Route::post('/status/change/mycar/save',[BlogController::class,'carSave'])->name('carSave');
    Route::post('/status/change/mycar/photo/save',[BlogController::class,'userCarPhoto'])->name('userCarPhoto');
    Route::get('/status/change/mycar/{userId}',[BlogController::class, 'carChoice'])->name('carChoice');
    
    
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
