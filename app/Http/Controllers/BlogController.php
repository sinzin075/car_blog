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
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;



class BlogController extends Controller
{
    public function index(User $user,Blog $blog,BlogComment $blog_comment){//index画面設定
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
    
    public function show($id){//投稿内容の詳細ページ
        $blog = Blog::with('blogComments')->findOrFail($id);
        $comment_count = [];//blogsテーブルのidを使用して関連するコメントの数を返す
        $comment_count[$blog->id] = $blog -> blogComments -> count();
        
        return view('blog.show')->with([
            'blog' => $blog,
            'comment_count' => $comment_count
            ]);
    }
    
    //保存の際の画像サイズ要検討
    public function post(User $user){//新しい投稿ページ用
        $user -> get();
        return view('blog.post')->with('user',$user);
    }

    public function upload(Request $request){//postから送信されたフォームの保存
        // バリデーション
        $this->validate($request, [
            'body' => 'required|string|max:300',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        // 画像のアップロード
        $uploadedFileUrl = Cloudinary::upload($request->file('photo')->getRealPath())->getSecurePath();
        // データベースに保存
        $blog = new Blog;
        $blog->user_id = Auth::id(); // ログインユーザーのIDを設定
        $blog->body = $request->body;
        $blog->photo = $uploadedFileUrl;
        $blog->save();
        
        return redirect()->route('index')->with('success', 'Blog post created successfully!');
    }
    public function comment($id){//投稿に対するコメント
        $blog = Blog::with('user') -> findOrFail($id);
        $commentUser = Auth::user();
        
        
        return view('blog.comment')->with([
            'blog' => $blog,
            'commentUser'=>$commentUser
            ]);
    }
    
    public function commentUpload(Request $request){//postから送信されたフォームの保存
        // バリデーション
        $this->validate($request, [
            'body' => 'required|string|max:300'
        ]);
        // データベースに保存
        $blog_comment = new BlogComment;
        $blog_comment -> user_id = Auth::id(); // ログインユーザーのIDを設定
        $blog_comment -> blog_id = $request -> blog_id();
        $blog_comment -> comment = $request->comment;
        $blog_comment -> save();
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
