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
use Illuminate\Support\Facades\Http;




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
    
    public function event(User $user,Event $event,EventComment $event_comment,){//index画面設定
        $users = $user->get();
        $events = $event->with(['user','EventComment','Event_likes'])->orderBy('created_at','desc')->get();
        
        return view('blog.event')->with([
            'users'=>$users,
            'events'=>$events,
            ]);
    }
    public function EventPost(User $user){//新しい投稿ページ用
        $user -> get();
        return view('blog.EventPost')->with('user',$user);
    }
    
    public function EventUpload(Request $request){
        $request -> validate([
            'title' => 'required|string|max:35',
            'body' => 'required|string|max:300',
            'address' => 'required|string',
            ]);
        
        $user = Auth::id();
        //画像を食らうディナリーに保存しURLを作成
        $uploadedFileUrl = Cloudinary::upload($request->file('photo')->getRealPath())->getSecurePath();
        
        $address = $request->input('address');
        // Google Maps APIのエンドポイントとAPIキー
        $endpoint = 'https://maps.googleapis.com/maps/api/geocode/json';
        $apiKey = config('services.google_maps.api_key'); // 自分のAPIキーに置き換える
        // google maps APIリクエストの送信
        $response = Http::get($endpoint, [
            'address' => $address,
            'key' => $apiKey,
        ]);
          // レスポンスの取得
        $locationData = $response->json();//受け取り方が配列になってしますため、カラムの増設をしてデータを文字列に変更する
        
        if (isset($locationData['results'][0])) {
            $firstResult = $locationData['results'][0];
        }
        
        $geometry = $firstResult['geometry'];
        $lat = $geometry['location']['lat'];
        $lng = $geometry['location']['lng'];

        $Event = new Event;
        $Event -> user_id = $user;
        $Event -> title = $request ->title;
        $Event -> body = $request ->body;
        $Event -> photo = $uploadedFileUrl;
        $Event -> address = $address;
        $Event -> lat = $lat;
        $Event -> lng = $lng;
        $Event -> save();

        // ここではデータをそのままビューに渡す
        return redirect()->route('event.event')->with('success', 'Event post created successfully!');
    }
    
    public function Eventshow($id){//投稿内容の詳細ページ
        $event = Event::with(['user','eventComment','Event_likes'])->findOrFail($id);
        
        return view('blog.EventShow')->with([
            'event' => $event,
            ]);
    }
    
    public function EventComment($id){//投稿に対するコメント
        $event = Event::with('user') -> findOrFail($id);//投稿と投稿ユーザー情報
        $commentUser = Auth::user();//ログインユーザー(コメントする人)
        
        return view('blog.EventComment')->with([
            'event' => $event,
            'commentUser'=>$commentUser
            ]);
    }
    
    public function EventCommentUpload(Request $request): RedirectResponse
    {//postから送信されたフォームの保存
        // バリデーション
        $this->validate($request, [
            'comment' => 'required|string|max:300'
        ]);
        // データベースに保存
        $event_comment = new EventComment;
        $event_comment -> user_id = Auth::id(); // ログインユーザーのIDを設定
        $event_comment -> event_id = $request -> event;
        $event_comment -> comment = $request->comment;
        $event_comment -> save();
        
        return redirect()->route('event.evnet');
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
        $user = User::findOrFail($userId);
        
        return view('blog.statusChange')->with(['user'=>$user]);
    }
    
    public function statusChangeUpload(Request $request)
    {
        // バリデーション
        $this->validate($request, [
            'photo' => 'nullable|image|max:2048', // 画像ファイルのバリデーション
            'greeting' => 'nullable|string|max:300',
        ]);
    
        $user = Auth::user(); // 認証ユーザーの取得
    
        // 画像のアップロード
        if ($request->hasFile('photo')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('photo')->getRealPath())->getSecurePath();
            $user->photo = $uploadedFileUrl; // URLを直接保存
        }
    
        // データベースに保存
        $user->greeting = $request->input('greeting');
        $user->save();
    
        return redirect()->route('index')->with('success', 'Blog post created successfully!');
    }

    public function carChoice(car $car)
    {
        // 'id'カラムで昇順に並べ替え
        $cars = Car::with(['maker.country'])
                   ->orderBy('id', 'asc')
                   ->get()
                   ->groupBy(function($car) {
                       return $car->maker->country->name;
                   });

        // 現在のユーザーを取得
        $user = Auth::user();

        // ユーザーが選択した車を取得、存在しない場合はnullを設定
        $selectedCars = [
            Car::find($user->car1_id),
            Car::find($user->car2_id),
            Car::find($user->car3_id)
        ];

        return view('blog.carChoice', [
            'cars' => $cars,
            'user' => $user,
            'selectedCars' => $selectedCars,
        ]);
    }

   public function carSave(Request $request)
{
    // デバッグログ
    \Log::info('carSave request data', $request->all());

    // バリデーション
    $request->validate([
        'car1_id' => 'nullable|exists:cars,id',
        'car2_id' => 'nullable|exists:cars,id',
        'car3_id' => 'nullable|exists:cars,id',
    ]);

    // 現在のユーザーを取得
    $user = Auth::user();

    // フォームから送信された車のIDを取得
    $car1_id = $request->input('car1_id');
    $car2_id = $request->input('car2_id');
    $car3_id = $request->input('car3_id');

    // デバッグログ
    \Log::info('car1_id', ['car1_id' => $car1_id]);
    \Log::info('car2_id', ['car2_id' => $car2_id]);
    \Log::info('car3_id', ['car3_id' => $car3_id]);

    // ユーザーの選択をデータベースに保存
    $user->car1_id = $car1_id;
    $user->car2_id = $car2_id;
    $user->car3_id = $car3_id;

    // 保存前のデバッグログ
    \Log::info('User before save', ['user' => $user]);

    $user->save();

    // 保存後のデバッグログ
    \Log::info('User saved', ['user' => $user]);

    // 成功メッセージと共に特定のルートにリダイレクト
    return redirect()->route('profile.edit')->with('success', 'Your car selections have been saved.');
}

    
    
    public function carList(car $car) {
            // 'id'カラムで昇順に並べ替え
        $cars = Car::with(['maker.country'])
                   ->orderBy('id', 'asc')
                   ->get()
                   ->groupBy(function($car) {
                       return $car->maker->country->name;
                   });

        return view('blog.carList', ['cars' => $cars]);
    }
    
    public function carUpload(Request $request){
        if($request ->country ==='その他'){
            //countryとmakerテーブルを新規作成する必要あり
        }
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
    
    public function EventGood(Request $request){//いいね機能
        $user = Auth::id(); //ユーザーIDを取得
        $event = $request->input('event');
    
        $like = Event_Likes::where('user_id', $user)->where('event_id', $event)->first();
    
        if ($like) {// いいねがすでに存在する場合、削除する
            $like->delete();
        } else {// いいねが存在しない場合、作成する
            Event_Likes::create([
                'user_id' => $user,
                'event_id' => $event,
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
    
    public function EventDestroy($id)
    {
        $event = Event::findOrFail($id);
    
        // ログインユーザーが投稿者であるかをチェック
        if (Auth::check() && Auth::user()->id == $event->user_id) {
            $event->delete();
            return redirect()->route('event.event')->with('success', '投稿を削除しました！');
        } else {
            return redirect()->route('event.event')->with('error', '削除権限がありません。');
        }
    }
}

