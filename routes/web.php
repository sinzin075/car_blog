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
    Route::get('/', [BlogController::class,'index'])->name('index');//初期画面
   
    Route::get('/blogs/create',[BlogController::class,'post'])->name('post');//新しい投稿画面view側から遷移
    Route::post('/blogs',[BlogController::class,'upload'])->name('upload');
    Route::post('/blogs/good', [BlogController::class, 'good'])->name('good');
   
    Route::get('/events',[BlogController::class, 'event'])->name('event');
    Route::get('/events/create',[BlogController::class,'EventPost'])->name('EventPost');
    Route::post('/events/create/upload',[BlogController::class,'EventUpload'])->name('EventUpload');
    Route::post('/events/good', [BlogController::class, 'EventGood'])->name('EventGood');
    
    
    Route::get('/status/{userId}',[BlogController::class,'status'])->name('status');
    Route::get('/status/change/{userId}',[BlogController::class,'statusChange'])->name('statusChange');
    Route::post('/status/change/upload/',[BlogController::class,'statusChangeUpload'])->name('statusChangeUpload');
    
    Route::delete('/blogs/delete/{blog}', [BlogController::class, 'destroy'])->name('destroy');
    Route::get('/blogs/comment/{blog}',[BlogController::class,'comment'])->name('comment');//投稿に対するコメント画面
    Route::post('/blogs/comment/{blog}',[BlogController::class,'commentUpload'])->name('commentUpload');//コメント保存
    Route::get('/blogs/{blog}',[BlogController::class,'show'])->name('show');//投稿詳細画面
    
    Route::delete('/events/delete/{event}', [BlogController::class, 'EventDestroy'])->name('EventDestroy');
    Route::get('/events/comment/{event}',[BlogController::class,'EventComment'])->name('EventComment');//投稿に対するコメント画面
    Route::post('/events/comment/{event}',[BlogController::class,'EventCommentUpload'])->name('EventCommentUpload');//コメント保存
    Route::get('/events/{event}',[BlogController::class,'EventShow'])->name('EventShow');//投稿詳細画面
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
