<x-app-layout>
    <x-slot name="header">
        <div class="bg-car-dark-gray text-white p-4 fixed w-full z-10 text-center">
            Car Blog
        </div>
    </x-slot>

    <div class="post p-4 mt-16 text-center">
        <!-- 投稿画面へ遷移 -->
        <a href="{{ route('blog.post')}}" class="btn-new-post">New Post</a>
    </div>

    @foreach ($blogs as $blog)
    <div class="post p-4 my-4 bg-car-light-gray rounded shadow space-y-4">
        <!-- 投稿内容 -->
        <div class="user-container relative mb-2 p-2 rounded" style="display: inline-block;">
            <div class="user-content flex items-center relative z-10" style="padding: 10px;">
                <img src="{{$blog->user->photo}}" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
                <span class="user-name">{{$blog->user->name}}</span>
            </div>
            <div class="user-background absolute inset-0 bg-user-icon"></div>
        </div>

        <p class="body text-black mb-2">{{$blog->body}}</p>
        <!-- blog本文 -->
        <div class="image-container flex justify-center">
            <img src="{{$blog->photo}}" class="common-image rounded">
        </div>

        <div class="flex justify-between items-center mt-2">
            <div class="flex space-x-4 items-center">
                <div class="count-display">💬{{ $blog->blogComments ? $blog->blogComments->count() : 0 }}</div>
                <!-- コメント数 -->
                <div class="count-display">❤{{ $blog->likes ? $blog->likes->count() : 0 }}</div>
                <!-- いいね数 -->
            </div>
            <div class="flex space-x-4 items-center">
                <a href="{{route('blog.comment', ['blog' => $blog->id])}}" class="btn-action">Comment</a>
                <!-- コメント画面へ遷移 -->

                <!-- フォームをリンクの外に移動 -->
                <form action="{{ route('blog.good', ['blog' => $blog->id]) }}" method="POST" class="inline-block">
                    <!-- いいねボタン -->
                    @csrf
                    <button type="submit" class="btn-action">いいね</button>
                </form>
            </div>
        </div>

        @if (isset($blog->blogComment) && count($blog->blogComment) > 0)
        <div class="user-container relative mt-4 p-2 rounded" style="display: inline-block;">
            <div class="user-content flex items-center relative z-10" style="padding: 10px;">
                <!-- コメントユーザー名&アイコン -->
                <img src="{{$last_comments[$blog->id]->user->photo}}" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
                <span class="user-name">{{$last_comments[$blog->id]->user->name}}</span>
                <p class="body text-black ml-2">{{$last_comments[$blog->id]->comment}}</p>
                <!-- コメント本文 -->
            </div>
            <div class="user-background absolute inset-0 bg-user-icon"></div>
        </div>
        @else
        <div class="no_comments text-black mt-4">
            コメントはまだありません
        </div>
        @endif
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

        .text-car-accent-red {
            color: #D7263D;
            /* より明確な赤 */
        }

        .bg-car-accent-red {
            background-color: #D7263D;
        }

        .bg-user-icon {
            background-color: #555555;
            /* アイコンの背景色を落ち着いた色に */
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
        }

        .image-container img {
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
            /* ホバー時に少し明るくする */
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
    </style>
</x-app-layout>
