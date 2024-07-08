<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\Event;
use App\Models\EventComment;
use App\Models\Car;
use App\Models\Follow;



class BlogController extends Controller
{
    public function index(User $user,Blog $blog,BlogComment $blog_comment){//定義ほぼ完了
        $users = $user -> get();
        $blogs = $blog -> with(['user','blogComments'])->orderBy('created_at','desc') -> get();
        $comment_count = [];//blogsテーブルのidを使用して関連するコメントの数を返す
        foreach($blogs as $single_blog){
            $comment_count[$single_blog->id] = $single_blog  -> blogComments -> count();
        }
        
        return view('blog.index') -> with([
            'users' => $users,
            'blogs' => $blogs,
            'comment_count' => $comment_count,
            ]);
    }
    public function post(){
        $data = User::all();
        return view('post',compact('data'));
    }
    
    public function event(User $user,Event $event,EventComment $event_comment){//定義未完了
        $users = $user -> get();
        $events = $event -> get();
        $event_comments = $eventc_comment -> get();
        
        return view('blog.event') -> with([
            'users' => $users,
            'events' => $events,
            'event_comments' => $event_comments,
            ]);
    }

    public function status($userId , User $user , Blog $blog , BlogComment $blog_comment , Car $car){//定義完了
        $user = User::findOrFail($userId);// 特定のユーザーを取得する
        $followersCount = $user->followers()->count();// フォロワー数とフォロー数を取得する
        $followingsCount = $user->followings()->count();
        
        $blogs = Blog::where('user_id',$user -> id) -> get();//特定のユーザーのblogデータを取得する
        $blogIds = $blogs->pluck('id');//特定のユーザーのidのみを取得する
        $blog_comments = BlogComment::whereIn('blog_id' , $blogIds)->get();//取得したidが保存されているblog_commentのレコードを取得する
        
        $cars = Car::where('user_id',$user -> id) -> get();//特定のユーザーのcarデータを取得する
        
        return view('blog.status') -> with([
            'user' => $user,
            'followersCount' => $followersCount,
            'followingsCount' => $followingsCount,
            'blogs' => $blogs,
            'blog_comments' => $blog_comments,
            'cars' => $cars,
            ]);
    }
}
