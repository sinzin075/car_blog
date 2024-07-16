<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\Event;
use App\Models\EventComment;
use App\Models\Car;
use App\Models\Follow;
use App\Models\Likes;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;



class BlogController extends Controller
{
    public function index(User $user,Blog $blog,BlogComment $blog_comment,){//index画面設定
        $users = $user -> get();
        $blogs = $blog -> with(['user','blogComments','likes'])->orderBy('created_at','desc') -> get();
        
        $like_count = [];
        $comment_count = [];
        $last_comments = [];
    
        foreach ($blogs as $single_blog) {
            // いいねの数をカウント
            $like_count[$single_blog->id] = $single_blog->likes->count();
            
            // コメントの数をカウント
            $comment_count[$single_blog->id] = $single_blog->blogComments->count();
            
            // 最新のコメントを取得
            $last_comments[$single_blog->id] = $single_blog->blogComments->sortByDesc('created_at')->first();
        }
        return view('blog.index') -> with([
            'users' => $users,
            'blogs' => $blogs,
            'comment_count' => $comment_count,
            'like_count' => $like_count,
            'last_comments' => $last_comments 
            ]);
    }
    
    
    public function show($id){//投稿内容の詳細ページ
        $blog = Blog::with(['user','blogComments','likes'])->findOrFail($id);
        
        $comment_count = [];//blogsテーブルのidを使用して関連するコメントの数を返す
        $comment_count[$blog->id] = $blog -> blogComments -> count();
        
        $like_count = [];//blogsテーブルのidを使用して関連するコメントの数を返す
        $like_count[$blog->id] = $blog -> likes -> count();
        
        return view('blog.show')->with([
            'blog' => $blog,
            'comment_count' => $comment_count,
            'like_count' => $like_count,
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
        $blog = Blog::with('user') -> findOrFail($id);//投稿と投稿ユーザー情報
        $commentUser = Auth::user();//ログインユーザー(コメントする人)
        
        return view('blog.comment')->with([
            'blog' => $blog,
            'commentUser'=>$commentUser
            ]);
    }
    
    public function commentUpload(Request $request): RedirectResponse
    {//postから送信されたフォームの保存
        // バリデーション
        $this->validate($request, [
            'comment' => 'required|string|max:300'
        ]);
        // データベースに保存
        $blog_comment = new BlogComment;
        $blog_comment -> user_id = Auth::id(); // ログインユーザーのIDを設定
        $blog_comment -> blog_id = $request -> blog;
        $blog_comment -> comment = $request->comment;
        $blog_comment -> save();
        
        return redirect()->route('index');
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
    
    public function status($userId){//定義完了
        $user = User::findOrFail($userId);// 特定のユーザーを取得する
        $followersCount = $user->follows()->count();// フォロワー数とフォロー数を取得する
        $followingsCount = $user->follows()->count();
        
        $blogs = Blog::where('user_id',$userId) -> get();//特定のユーザーのblogデータを取得する
        $blogIds = $blogs->pluck('id');//特定のユーザーのidのみを取得する
        $blog_comments = BlogComment::whereIn('blog_id' , $blogIds)->get();//取得したidが保存されているblog_commentのレコードを取得する
        
        $like_count = [];
        $comment_count = [];
        $last_comments = [];
    
        foreach ($blogs as $single_blog) {
            // いいねの数をカウント
            $like_count[$single_blog->id] = $single_blog->likes->count();
            
            // コメントの数をカウント
            $comment_count[$single_blog->id] = $single_blog->blogComments->count();
            
            // 最新のコメントを取得
            $last_comments[$single_blog->id] = $single_blog->blogComments->sortByDesc('created_at')->first();
        }
        
        // ユーザーのcar_idを取得する
        $carIds = [$user->car1_id, $user->car2_id, $user->car3_id];

        $cars = Car::whereIn('id', $carIds)->get();
        
        return view('blog.status') -> with([
            'user' => $user,
            'followersCount' => $followersCount,
            'followingsCount' => $followingsCount,
            'blogs' => $blogs,
            'blog_comments' => $blog_comments,
            'cars' => $cars,
            'comment_count' => $comment_count,
            'like_count' => $like_count,
            'last_comments' => $last_comments
            ]);
    }
    
    public function statusChange($userId){
        $user = User::findOrFail($userId)->get();
        
        return view('blog.statusChange')->with(['user'=>$user]);
    }




    public function good(Request $request){//いいね機能
        $user = Auth::id(); //ユーザーIDを取得
        $blog = $request->input('blog');
    
        $like = Likes::where('user_id', $user)->where('blog_id', $blog)->first();
    
        if ($like) {// いいねがすでに存在する場合、削除する
            $like->delete();
        } else {// いいねが存在しない場合、作成する
            Likes::create([
                'user_id' => $user,
                'blog_id' => $blog,
            ]);
        }
        return redirect()->back();
    }
    
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
    
        // ログインユーザーが投稿者であるかをチェック
        if (Auth::check() && Auth::user()->id == $blog->user_id) {
            $blog->delete();
            return redirect()->route('index')->with('success', '投稿を削除しました！');
        } else {
            return redirect()->route('index')->with('error', '削除権限がありません。');
        }
    }
}

