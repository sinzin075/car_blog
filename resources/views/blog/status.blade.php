<x-app-layout>
    <x-slot name="header">
        <div class="bg-car-dark-gray text-white p-4 fixed w-full z-10 text-center">
            Car Blog
        </div>
    </x-slot>

    <div class="post mx-auto mb-4 p-4 bg-car-dark-gray text-white rounded" style="width: 60%;">
        <div class="user-content flex flex-col items-center">
            <span class="font-bold text-5xl mb-2">{{ $user->name }}</span>
            <img src="{{ $user->photo }}" alt="user_icon" class="user-profile-image">
            <p class="mb-4 text-center text-lg">{{ $user->greeting }}</p>
        </div>
        <div class="flex justify-around mb-4 text-xl">
            <span class="text-center">フォロー：{{ $followersCount }}</span>
            <span class="text-center">フォロワー：{{ $followingsCount }}</span>
        </div>
      <div>
        @if(Auth::check() && Auth::user()->id != $user->id)
            @if($follow == null)
                <form action="{{ route('follower',['userId'=>$user->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="userId" value="{{ $user->id }}">
                    <button type="submit" class="follow-button">フォローする</button>
                </form>
            @else
                <form action="{{ route('follower',['userId'=>$user->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="userId" value="{{ $user->id }}">
                    <button type="submit" class="unfollow-button">フォロー解除</button>
                </form>
            @endif
        @endif
    </div>


        <div class="user_car mb-4">
            <ul class="flex justify-between mt-4">
                @if (isset($user->car1_id))
                <li class="car-card">
                    <p class="font-bold text-center">愛車1</p>
                    @if (isset($user->car1_photo))
                    <img src="{{ $user->car1_photo }}" alt="ユーザーの愛車1" class="car-image mt-2">
                    @else
                    <img src="{{ $user->car1->photo }}" alt="ユーザーの愛車イメージ1" class="car-image mt-2">
                    <span class="block mt-2 text-center">ユーザーの愛車１イメージ</span>
                    @endif
                    <span class="block mt-2 font-bold text-center">{{ $user->car1->name }}</span>
                </li>
                @else
                <p>愛車登録がまだありません</p>
                @endif

                @if (isset($user->car2_id))
                <li class="car-card">
                    <p class="font-bold text-center">愛車2</p>
                    @if (isset($user->car2_photo))
                    <img src="{{ $user->car2_photo }}" alt="ユーザーの愛車2" class="car-image mt-2">
                    @else
                    <img src="{{ $user->car2->photo }}" alt="ユーザーの愛車イメージ2" class="car-image mt-2">
                    <span class="block mt-2 text-center">ユーザーの愛車２イメージ</span>
                    @endif
                    <span class="block mt-2 font-bold text-center">{{ $user->car2->name }}</span>
                </li>
                @endif

                @if (isset($user->car3_id))
                <li class="car-card">
                    <p class="font-bold text-center">愛車3</p>
                    @if (isset($user->car3_photo))
                    <img src="{{ $user->car3_photo }}" alt="ユーザーの愛車3" class="car-image mt-2">
                    @else
                    <img src="{{ $user->car3->photo }}" alt="ユーザーの愛車イメージ3" class="car-image mt-2">
                    <span class="block mt-2 text-center">ユーザーの愛車３イメージ</span>
                    @endif
                    <span class="block mt-2 font-bold text-center">{{ $user->car3->name }}</span>
                </li>
                @endif
            </ul>
        </div>
    </div>

    <!-- 適用範囲 -->
    @foreach ($blogs as $blog)
    <div class="post p-4 my-4 bg-car-light-gray rounded shadow space-y-4" style="width: 60%; margin-left: auto; margin-right: auto;">
        <a href="{{ route('blog.show', ['blog' => $blog->id]) }}">
            <div class="user-container relative mb-2 p-2 rounded flex items-center">
                <div class="user-content flex items-center relative z-10" style="padding: 10px;">
                    <img src="{{$blog->user->photo}}" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
                    <span class="user-name">{{$blog->user->name}}</span>
                </div>
                <div class="user-background absolute inset-0 bg-user-icon"></div>
            </div>
            <p class="body text-black mb-2">{{ $blog->body }}</p>
            <div class="image-container flex justify-center">
                <img src="{{ $blog->photo }}" class="common-image rounded">
            </div>

            <div class="flex justify-between items-center mt-2">
                <div class="flex space-x-4 items-center">
                    <div class="count-display comment_count">💬 {{ $comment_count[$blog->id] }}</div>
                    <div class="count-display good">❤ {{ $like_count[$blog->id] }}</div>
                </div>
                <div class="flex space-x-4 items-center">
                    <a href="{{ route('blog.comment', ['blog' => $blog->id]) }}" class="btn-action">コメント</a>
                    <form action="{{ route('blog.good', ['blog' => $blog->id]) }}" method="POST" enctype="multipart/form-data" class="inline-block">
                        @csrf
                        <button type="submit" class="btn-action">いいね</button>
                    </form>
                </div>
            </div>

            <hr class="comment-divider">
            <!-- コメントと本文の境界線 -->

            @if (isset($blog->blogComments) && count($blog->blogComments) > 0)
            <div class="user-container relative mt-4 p-2 rounded flex items-center">
                <div class="user-content flex items-center relative z-10" style="padding: 10px;">
                    <img src="{{$last_comments[$blog->id]->user->photo}}" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
                    <span class="user-name">{{$last_comments[$blog->id]->user->name}}</span>
                </div>
                <div class="user-background absolute inset-0 bg-user-icon"></div>
            </div>
            <p class="body text-black ml-2">{{ $last_comments[$blog->id]->comment }}</p>
            @else
            <div class="no_comments text-black mt-4">コメントはまだありません</div>
            @endif
        </a>
    </div>
    @endforeach
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ページロード時にスクロール位置を復元
            const scrollPosition = localStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, parseInt(scrollPosition, 10));
                localStorage.removeItem('scrollPosition');
            }

            // ページ離脱時にスクロール位置を保存
            window.addEventListener('beforeunload', function() {
                localStorage.setItem('scrollPosition', window.scrollY);
            });
        });
    </script>

    <style>
        .bg-car-light-gray {
            background-color: #e0e0e0;
            /* 薄いグレーに変更 */
        }

        .bg-car-dark-gray {
            background-color: #333333;
            /* より濃いグレー */
        }

        .user-container {
            position: relative;
            display: inline-block;
            border-radius: 8px;
            overflow: hidden;
            background-color: #555555;
            /* アイコンの背景色を落ち着いた色に */
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
            background-color: #555555;
            /* アイコンの背景色 */
        }

        .user-name {
            color: #ffffff;
            /* 白色で視認性を向上 */
            font-size: 1.2rem;
            /* ユーザー名のフォントサイズを調整 */
            font-weight: 700;
            /* 太文字にして視認性を向上 */
            line-height: 1.5;
            /* 行間を調整して読みやすさを確保 */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            /* 影を付けて文字を際立たせる */
            z-index: 20;
            margin-left: 0.5rem;
        }

        .post {
            margin-bottom: 20px;
            /* 投稿間のスペースを追加 */
            width: 60%;
            /* 投稿コンテナの幅を60%に設定 */
            margin-left: auto;
            /* 中央寄せのための左マージン */
            margin-right: auto;
            /* 中央寄せのための右マージン */
        }

        .user-icon {
            width: 3rem;
            /* アイコンのサイズを調整 */
            height: 3rem;
            border-radius: 50%;
            /* 丸いアイコン */
            margin-right: 0.5rem;
            /* アイコンとテキストの間隔 */
        }

        .user-profile-image {
            width: 35%;
            height: auto;
            display: block;
            object-fit: cover;
            /* 縦長画像をカットする */
            clip-path: inset(15% 0 15% 0);
            /* 上下15%をカット */
        }

        .common-image {
            width: 60%;
            height: auto;
            display: block;
            margin: 0 auto;
            object-fit: cover;
            /* 画像のアスペクト比を保ちながらサイズを調整 */
        }

        .btn-new-post {
            display: inline-block;
            padding: 10px 20px;
            background-color: #D7263D;
            /* アクセントカラーの赤 */
            color: white;
            text-transform: uppercase;
            font-weight: bold;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .btn-new-post:hover {
            background-color: #B51E32;
            /* ホバー時に少し暗くする */
        }

        .btn-action {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333333;
            /* ダークグレー */
            color: #ffffff;
            /* 白色 */
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
            cursor: pointer;
            margin: 5px;
            border: none;
        }

        .btn-action:hover {
            background-color: #555555;
            /* ホバー時の色変更 */
        }

        .count-display {
             display: inline-block;
            padding: 10px 20px;
            background-color: #333333;
            /* ダークグレー */
            color: #ffffff;
            /* 白色 */
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin: 5px;
            transition: background-color 0.3s ease;
        }

        .car-card {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 30%;
            margin: 0 1%;
            /* 車カードのデザイン */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            /* フレックスボックスで下に寄せる */
        }

        .car-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
            /* 車画像のデザイン */
        }

        .car-card p,
        .car-card span {
            color: #333333;
            /* テキストの色を濃いグレーに */
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
            /* 上下の余白を追加 */
        }

        .no_comments {
            color: #999999;
            /* 薄いグレーで未コメントを表示 */
            font-style: italic;
            /* イタリックで強調 */
            text-align: center;
            /* 中央揃え */
            margin-top: 10px;
        }

        .comment-divider {
            margin: 15px 0;
            border-top: 1px solid #cccccc;
            /* コメント区切りの薄い線 */
        }
        
        /* フォローボタンのスタイル */
        .follow-button {
            display: inline-block;
            padding: 8px 16px;
            background-color: #1DA1F2;
            /* Twitterブルーに近い色 */
            color: #ffffff;
            font-weight: bold;
            border-radius: 5px;
            text-align: center;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
            cursor: pointer;
            border: none;
            margin: 5px 0;
        }
        
        .follow-button:hover {
            background-color: #0d8de0;
            /* ホバー時に少し暗くする */
        }
        
        .unfollow-button {
            display: inline-block;
            padding: 8px 16px;
            background-color: #ff4444;
            /* 赤色で目立たせる */
            color: #ffffff;
            font-weight: bold;
            border-radius: 5px;
            text-align: center;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
            cursor: pointer;
            border: none;
            margin: 5px 0;
        }
        
        .unfollow-button:hover {
            background-color: #cc3333;
            /* ホバー時に少し暗くする */
        }

        
    </style>
</x-app-layout>
