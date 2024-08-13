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
use App\Models\Event_Likes;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BlogController extends Controller
{
    public function index(User $user, Blog $blog, BlogComment $blog_comment)
    {
        $users = $user->get();
        $blogs = $blog->with(['user', 'blogComments', 'likes'])->orderBy('created_at', 'desc')->get();

        return view('blog.index')->with([
            'users' => $users,
            'blogs' => $blogs,
        ]);
    }

    public function event(User $user, Event $event, EventComment $event_comment)
    {
        $users = $user->get();
        $events = $event->with(['user', 'EventComment', 'Event_likes'])->orderBy('created_at', 'desc')->get();

        return view('blog.event')->with([
            'users' => $users,
            'events' => $events,
        ]);
    }

    public function EventPost()
    {
        $user = Auth::user();
        return view('blog.EventPost')->with('user', $user);
    }

    public function EventUpload(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:35',
            'body' => 'required|string|max:300',
            'address' => 'required|string',
            'photo' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        try {
            $manager = new ImageManager(new Driver());
    
            $image = $manager->read($request->file('photo'));
        
                // 画像の幅と高さを取得
            $originalWidth = $image->width();
            $originalHeight = $image->height();
    
            // 横の最大幅に合わせてアスペクト比を保ったままリサイズする高さを計算
            $maxWidth = 750;
            $newHeight = intval(($originalHeight / $originalWidth) * $maxWidth);
    
            // 画像をリサイズ
            $image->resize($maxWidth, $newHeight, function ($constraint) {
                $constraint->aspectRatio(); // アスペクト比を保つ
                $constraint->upsize();      // 元のサイズより大きくしない
            });
    
            // 一時ファイルに保存
            $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.jpg';
            $image->save($tempPath, 75);
    
            // 画像をCloudinaryにアップロード
            $uploadedFileUrl = Cloudinary::upload($tempPath)->getSecurePath();
        
    
            $user = Auth::id();
            $address = $request->input('address');//google map用住所
            $endpoint = 'https://maps.googleapis.com/maps/api/geocode/json';
            $apiKey = config('services.google_maps.api_key');
            $response = Http::get($endpoint, [
                'address' => $address,
                'key' => $apiKey,
            ]);
            $locationData = $response->json();
    
            if (isset($locationData['results'][0])) {
                $firstResult = $locationData['results'][0];
            }
    
            $geometry = $firstResult['geometry'];
            $lat = $geometry['location']['lat'];
            $lng = $geometry['location']['lng'];
    
            $Event = new Event;
            $Event->user_id = $user;
            $Event->title = $request->title;
            $Event->body = $request->body;
            $Event->photo = $uploadedFileUrl;
            $Event->address = $address;
            $Event->lat = $lat;
            $Event->lng = $lng;
            $Event->save();

                // 一時ファイルを削除
            unlink($tempPath);
    
            return redirect()->route('event.event')->with('success', 'Blog post created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '画像処理に失敗しました。');
        }

        return redirect()->route('event.event')->with('success', 'Event post created successfully!');
    }

    public function Eventshow($id)
    {
        $event = Event::with(['user', 'eventComment', 'Event_likes'])->findOrFail($id);

        return view('blog.EventShow')->with([
            'event' => $event,
        ]);
    }

    public function EventComment($id)
    {
        $event = Event::with('user')->findOrFail($id);
        $commentUser = Auth::user();

        return view('blog.EventComment')->with([
            'event' => $event,
            'commentUser' => $commentUser,
        ]);
    }

    public function EventCommentUpload(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'comment' => 'required|string|max:300'
        ]);

        $event_comment = new EventComment;
        $event_comment->user_id = Auth::id();
        $event_comment->event_id = $request->event;
        $event_comment->comment = $request->comment;
        $event_comment->save();

        return redirect()->route('event.event');
    }

    public function show($id)
    {
        $blog = Blog::with(['user', 'blogComments', 'likes'])->findOrFail($id);

        $comment_count = [];
        $comment_count[$blog->id] = $blog->blogComments->count();

        $like_count = [];
        $like_count[$blog->id] = $blog->likes->count();

        return view('blog.show')->with([
            'blog' => $blog,
            'comment_count' => $comment_count,
            'like_count' => $like_count,
        ]);
    }

    public function post()
    {
        $user = Auth::user();
        return view('blog.post')->with('user', $user);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'photo' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'body' => 'required|string|max:300',
        ]);
    
        try {
            $manager = new ImageManager(new Driver());
    
            $image = $manager->read($request->file('photo'));
        
                // 画像の幅と高さを取得
            $originalWidth = $image->width();
            $originalHeight = $image->height();
    
            // 横の最大幅に合わせてアスペクト比を保ったままリサイズする高さを計算
            $maxWidth = 750;
            $newHeight = intval(($originalHeight / $originalWidth) * $maxWidth);
    
            // 画像をリサイズ
            $image->resize($maxWidth, $newHeight, function ($constraint) {
                $constraint->aspectRatio(); // アスペクト比を保つ
                $constraint->upsize();      // 元のサイズより大きくしない
            });
    
            // 一時ファイルに保存
            $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.jpg';
            $image->save($tempPath, 75);
    
            // 画像をCloudinaryにアップロード
            $uploadedFileUrl = Cloudinary::upload($tempPath)->getSecurePath();
    
            // データベースに保存
            $blog = new Blog;
            $blog->user_id = Auth::id();
            $blog->body = $request->body;
            $blog->photo = $uploadedFileUrl;
            $blog->save();
    
            // 一時ファイルを削除
            unlink($tempPath);
    
            return redirect()->route('index')->with('success', 'Blog post created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '画像処理に失敗しました。');
        }
    }

    public function comment($id)
    {
        $blog = Blog::with('user')->findOrFail($id);
        $commentUser = Auth::user();

        return view('blog.comment')->with([
            'blog' => $blog,
            'commentUser' => $commentUser,
        ]);
    }

    public function commentUpload(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'comment' => 'required|string|max:300'
        ]);

        $blog_comment = new BlogComment;
        $blog_comment->user_id = Auth::id();
        $blog_comment->blog_id = $request->blog;
        $blog_comment->comment = $request->comment;
        $blog_comment->save();

        return redirect()->route('index');
    }

    public function status($userId)
    {
        $user = User::findOrFail($userId);
        $followersCount = $user->followers()->count();
        $followedsCount = $user->follows()->count();
        $follow = Follow::where('followed_id', Auth::id())->where('follower_id', $userId)->first();

        $blogs = Blog::where('user_id', $userId)->with(['user', 'blogComments', 'likes'])->orderBy('created_at', 'desc')->get();
        $blogIds = $blogs->pluck('id');
        $blog_comments = BlogComment::whereIn('blog_id', $blogIds)->get();

        $carIds = [$user->car1_id, $user->car2_id, $user->car3_id];
        $cars = Car::whereIn('id', $carIds)->get();

        return view('blog.status')->with([
            'user' => $user,
            'followersCount' => $followersCount,
            'followedsCount' => $followedsCount,
            'follow' => $follow,
            'blogs' => $blogs,
            'blog_comments' => $blog_comments,
            'cars' => $cars,
        ]);
    }

    public function statusChange($userId)
    {
        $user = User::findOrFail($userId);

        return view('blog.statusChange')->with(['user' => $user]);
    }

    public function statusChangeUpload(Request $request)
    {
        $this->validate($request, [
            'photo' => 'nullable|image|max:2048',
            'greeting' => 'nullable|string|max:300',
        ]);

        $user = Auth::user();

        if ($request->hasFile('photo')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('photo')->getRealPath())->getSecurePath();
            $user->photo = $uploadedFileUrl;
        }

        $user->greeting = $request->input('greeting');
        $user->save();

        return redirect()->route('index')->with('success', 'Blog post created successfully!');
    }

    public function carChoice(Car $car)
    {
        $cars = Car::with(['maker.country'])->orderBy('id', 'asc')->get()->groupBy(function ($car) {
            return $car->maker->country->name;
        });

        $user = Auth::user();

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
        \Log::info('carSave request data', $request->all());

        $request->validate([
            'car1_id' => 'nullable|exists:cars,id',
            'car2_id' => 'nullable|exists:cars,id',
            'car3_id' => 'nullable|exists:cars,id',
        ]);

        $user = Auth::user();

        $car1_id = $request->input('car1_id');
        $car2_id = $request->input('car2_id');
        $car3_id = $request->input('car3_id');

        \Log::info('car1_id', ['car1_id' => $car1_id]);
        \Log::info('car2_id', ['car2_id' => $car2_id]);
        \Log::info('car3_id', ['car3_id' => $car3_id]);

        $user->car1_id = $car1_id;
        $user->car2_id = $car2_id;
        $user->car3_id = $car3_id;

        \Log::info('User before save', ['user' => $user]);

        $user->save();

        \Log::info('User saved', ['user' => $user]);

        return redirect()->route('profile.edit')->with('success', 'Your car selections have been saved.');
    }

    public function userCarPhoto(Request $request)
    {
        Log::info('Request Data:', $request->all());

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'carPhoto' => 'required|in:car1_photo,car2_photo,car3_photo',
        ]);

        $user = Auth::user();

        $carPhoto = $request->input('carPhoto');

        $uploadedFileUrl = Cloudinary::upload($request->file('photo')->getRealPath())->getSecurePath();

        $user->{$carPhoto} = $uploadedFileUrl;

        $user->save();

        return redirect()->back();
    }
    
    public function search()
    {
        return view('blog.search');
    }
    
    public function UserSearch(Request $request)
    {
        $query = $request->input('query'); // テキストボックスに入力された値を取得
        
        $users = User::where('name', 'like', '%' . $query . '%')->get(); // 入力データであいまい検索
        
        return view('blog.UserSearch',['users'=>$users]);
    }

    public function carList(Car $car)
    {
        $cars = Car::with(['maker.country'])->orderBy('id', 'asc')->get()->groupBy(function ($car) {
            return $car->maker->country->name;
        });

        return view('blog.carList', ['cars' => $cars]);
    }

    public function carUpload(Request $request)
    {
        if ($request->country === 'その他') {
            // countryとmakerテーブルを新規作成する必要あり
        }
    }

    public function good(Request $request)
    {
        $user = Auth::id();
        $blog = $request->input('blog');

        $like = Likes::where('user_id', $user)->where('blog_id', $blog)->first();

        if ($like) {
            $like->delete();
        } else {
            Likes::create([
                'user_id' => $user,
                'blog_id' => $blog,
            ]);
        }
        return redirect()->back();
    }

    public function EventGood(Request $request)
    {
        $user = Auth::id();
        $event = $request->input('event');

        $like = Event_Likes::where('user_id', $user)->where('event_id', $event)->first();

        if ($like) {
            $like->delete();
        } else {
            Event_Likes::create([
                'user_id' => $user,
                'event_id' => $event,
            ]);
        }
        return redirect()->back();
    }

    public function follower(Request $request)
    {
        $user = Auth::id();
        $follower = $request->input('userId');


        $follow = Follow::where('followed_id', $user)->where('follower_id', $follower)->first();

        if ($follow) {
            $follow->delete();
        } else {
            Follow::create([
                'followed_id' => $follower,
                'follower_id' => $user,
            ]);
        }
        return redirect()->back();
    }
    
    public function UserFollower($userId)
    {
        $user = User::findOrFail($userId);
    
        // 自分をフォローしているユーザーを取得
        $followers = Follow::where('followed_id', $user->id)->get();
     
        // followersをビューに渡す
        return view('blog.UserFollower', [ 
            'followers' => $followers,
            'user'=>$user
        ]);
    }

    public function UserFollowed($userId)
    {
        $user = User::findOrFail($userId);

        //自分がフォローしているユーザーを取得
        $followeds = Follow::where('follower_id', $user->id)->get();
    
        // followersをビューに渡す
        return view('blog.UserFollowed', [
            'followeds' =>$followeds,
            'user'=>$user
        ]);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

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

        if (Auth::check() && Auth::user()->id == $event->user_id) {
            $event->delete();
            return redirect()->route('event.event')->with('success', '投稿を削除しました！');
        } else {
            return redirect()->route('event.event')->with('error', '削除権限がありません。');
        }
    }
}
