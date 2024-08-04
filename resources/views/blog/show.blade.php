<x-app-layout>
    <!-- 削除ボタンの表示 -->
    @if (Auth::check() && Auth::user()->id == $blog->user_id)
    <form action="{{ route('blog.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('本当にこの投稿を削除してもよろしいですか？');" class="text-right mb-4">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-delete">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="inline-block w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            投稿を削除
        </button>
    </form>
    @endif

    <div class="post p-4 mt-4 bg-car-light-gray rounded shadow space-y-4">
        <div class="user-container relative mb-2 p-2 rounded" style="display: inline-block;">
            <a href="{{route('status',['userId'=>$blog->user->id])}}">
                <div class="user-content flex items-center relative z-10" style="padding: 10px;">
                    <img src="{{$blog->user->photo}}" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
                    <span class="user-name">{{$blog->user->name}}</span>
                </div>
                <div class="user-background absolute inset-0 bg-user-icon"></div>
            </a>
        </div>

        <p class="body text-black mb-2">{{$blog->body}}</p><!-- blog本文 -->
        <div class="image-container flex justify-center">
            <img src="{{$blog->photo}}" class="common-image rounded">
        </div>

        <div class="flex justify-between items-center mt-2">
            <div class="flex space-x-4 items-center">
                <div class="count-display">💬{{$comment_count[$blog->id]}}</div><!-- コメント数 -->
                <div class="count-display">❤{{$like_count[$blog->id]}}</div><!-- いいね数 -->
            </div>
            <div class="flex space-x-4 items-center">
                <a href="{{route('blog.comment', ['blog' => $blog->id])}}" class="btn-action">コメント</a><!-- コメント画面へ遷移 -->
                <form action="{{route('blog.good', ['blog' => $blog->id])}}" method="POST" enctype="multipart/form-data" class="inline-block"><!-- いいねボタン -->
                    @csrf
                    <button type="submit" class="btn-action">いいね</button>
                </form>
            </div>
        </div>

        <hr class="comment-divider"><!-- コメントと本文の境界線 -->

        @if (isset($blog->blogComments) && count($blog->blogComments) > 0)
        @foreach ($blog->blogComments as $comment)
        <div class="user-container relative mb-2 p-2 rounded" style="display: inline-block;">
            <a href="{{route('status',['userId'=>$comment->user->id])}}">
                <div class="user-content flex items-center relative z-10" style="padding: 10px;">
                    <img src="{{$comment->user->photo}}" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
                    <span class="user-name">{{$comment->user->name}}</span>
                </div>
                <div class="user-background absolute inset-0 bg-user-icon"></div>
            </a>
        </div>

        <p class="body text-black mb-2">{{$comment->comment}}</p><!-- コメント本文 -->
        @endforeach
        @else
        <div class="no_comments text-black mt-4">コメントはまだありません</div>
        @endif
    </div>

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

        .btn-delete {
            display: inline-block;
            padding: 12px 24px;
            background-color: #D7263D;
            /* 赤色で強調 */
            color: white;
            font-weight: bold;
            border-radius: 8px;
            text-align: center;
            text-transform: uppercase;
            transition: background-color 0.3s ease, transform 0.3s ease;
            cursor: pointer;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            /* 影を追加して目立たせる */
        }

        .btn-delete:hover {
            background-color: #B51E32;
            /* ホバー時に少し暗くする */
            transform: translateY(-2px);
            /* ホバー時に少し上に移動 */
        }

        .comment-divider {
            margin: 15px 0;
            border-top: 1px solid #cccccc;
            /* コメント区切りの薄い線 */
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
    </style>
</x-app-layout>
