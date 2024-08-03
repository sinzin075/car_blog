<x-app-layout>
    <x-slot name="header">
        <div class="bg-car-dark-gray text-white p-4 fixed w-full z-10">
            Car Blog
        </div>
    </x-slot>
    
    <div class="post mx-auto mb-4 p-4 bg-car-dark-gray text-white rounded" style="width: 60%;">
        <div class="user-content flex flex-col items-center">
            <span class="font-bold text-4xl mb-2">{{$user->name}}</span>
            <img src="{{$user->photo}}" alt="user_icon" class="common-image">
            <p class="mb-4">{{$user->greeting}}</p><!--ユーザーの一言-->
        </div>
        <div class="flex justify-around mb-4">
            <span>フォロー：{{$followersCount}}</span>
            <span>フォロワー：{{$followingsCount}}</span>
        </div>
        <div class="user_car mb-4"><!--ユーザーの愛車一覧-->
            <ul class="flex space-x-4">
                @if (isset($user->car1_id))<!--愛車登録がある場合のみ表示-->
                    <li class="mb-2 text-center">
                        <p>愛車1</p>
                        <img src="{{$user->car1->photo}}" alt="ユーザーの愛車1" class="w-32 h-auto rounded">
                        <span>{{$user->car1->name}}</span>
                    </li>
                @else
                    <p>愛車登録がまだありません</p>
                @endif
                @if (isset($user->car2_id))
                <li class="mb-2 text-center">
                    <p>愛車2</p>
                    <img src="{{$user->car2->photo}}" alt="ユーザーの愛車2" class="w-32 h-auto rounded">
                    <span>{{$user->car2->name}}</span>
                </li>
                @endif
                @if (isset($user->car3_id))
                <li class="mb-2 text-center">
                    <p>愛車3</p>
                    <img src="{{$user->car3->photo}}" alt="ユーザーの愛車3" class="w-32 h-auto rounded">
                    <span>{{$user->car3->name}}</span>
                </li>
                @endif
            </ul>
        </div>
    </div>
    
    @foreach ($blogs as $blog)
        <div class="post p-4 my-4 bg-car-light-gray rounded shadow space-y-4" style="width: 60%; margin-left: auto; margin-right: auto;"><!--投稿内容-->
            <a href="{{route('blog.show', ['blog' => $blog->id])}}"><!--投稿詳細へ遷移-->
                <div class="user-container relative mb-2 p-2 rounded" style="display: inline-block;">
                    <div class="user-content flex items-center relative z-10" style="padding: 10px;">
                        <img src="{{$blog->user->photo}}" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
                        <span class="text-white font-bold text-xl" style="font-size: 20px;">{{$blog->user->name}}</span>
                    </div>
                    <div class="user-background absolute inset-0 bg-car-accent-red"></div>
                </div>
                <p class="body text-car-dark-gray mb-2">{{$blog->body}}</p><!--blog本文-->
                <div class="image-container flex justify-center">
                    <img src="{{$blog->photo}}" class="common-image rounded">
                </div>
              
                <div class="flex justify-between items-center mt-2">
                    <div class="flex space-x-4">
                        <div class="comment_count text-car-dark-gray font-bold text-3xl">💬{{$comment_count[$blog->id]}}</div><!--コメント数-->
                        <div class="good text-car-dark-gray font-bold text-3xl">❤{{$like_count[$blog->id]}}</div><!--いいね数-->
                    </div>
                </div>
                
                <a href="{{route('blog.comment', ['blog' => $blog->id])}}" class="text-black mt-2 inline-block bg-black text-white px-4 py-2 rounded hover:bg-gray-800 font-bold text-lg">comment</a><!--コメント画面へ遷移-->
                
                <form action="{{route('blog.good', ['blog' => $blog->id])}}" method="POST" enctype="multipart/form-data" class="mt-2"><!--いいねボタン-->
                    @csrf
                    <input type="submit" value="いいね" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 font-bold text-lg">
                </form>
                       
                @if (isset($blog->blogComments) && count($blog->blogComments) > 0)
                    <div class="user-container relative mt-4 p-2 rounded" style="display: inline-block;">
                        <div class="user-content flex items-center relative z-10" style="padding: 10px;"><!--コメントユーザー名&アイコン-->
                            <img src="{{$last_comments[$blog->id]->user->photo}}" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
                            <span class="text-white font-bold text-xl" style="font-size: 20px;">{{$last_comments[$blog->id]->user->name}}</span>
                            <p class="body text-car-dark-gray ml-2">{{$last_comments[$blog->id]->comment}}</p><!--コメント本文-->
                        </div>
                        <div class="user-background absolute inset-0 bg-car-accent-red"></div>
                    </div>
                    <div class="comment">{{$last_comments[$blog->id]->content}}</div>
                @else
                    <div class="no_comments text-car-dark-gray mt-4">コメントはまだありません</div>
                @endif
            </a>
        </div>
    @endforeach

    <style>
        .bg-car-light-gray {
            background-color: #767676; /* グレーよりに変更 */
        }
        .bg-car-dark-gray {
            background-color: #454545; /* より濃いグレー */
        }
        .text-car-accent-red {
            color: #D7263D; /* より明確な赤 */
        }
        .bg-car-accent-red {
            background-color: #D7263D;
        }
        .post {
            margin-bottom: 20px; /* 投稿間のスペースを追加 */
            width: 60%; /* 投稿コンテナの幅を60%に設定 */
            margin-left: auto; /* 中央寄せのための左マージン */
            margin-right: auto; /* 中央寄せのための右マージン */
        }
        .user-container {
            position: relative;
            display: inline-block;
            border-radius: 8px;
            overflow: hidden;
        }
        .user-content {
            padding: 10px;
            display: flex;
            align-items: center;
        }
        .user-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #D7263D;
        }
        .common-image {
            width: 60%;
            height: auto;
            display: block;
            margin: 0 auto;
            object-fit: cover;
        }
        .text-4xl {
            font-size: 40px;
            font-weight: bold;
        }
        .user_car ul {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }
        .user_car li {
            margin-right: 20px;
        }
    </style>
</x-app-layout>
