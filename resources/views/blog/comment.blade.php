<x-app-layout>
    <!-- 投稿者の情報 -->
    <div class="user-container relative mb-4 p-2 rounded" style="display: inline-block;">
        <div class="user-content flex items-center relative z-10" style="padding: 10px;">
            <img src="{{$blog->user->photo}}" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
            <span class="user-name">{{$blog->user->name}}</span>
        </div>
        <div class="user-background absolute inset-0 bg-user-icon"></div>
    </div>

    <!-- blog本文 -->
    <p class="body text-black mb-4">{{$blog->body}}</p>
    <div class="image-container flex justify-center mb-4">
        <img src="{{$blog->photo}}" class="common-image rounded">
    </div>

    <!-- コメントフォーム -->
    <form action="{{route('blog.commentUpload',['blog' => $blog->id])}}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <textarea name="comment" placeholder="コメントをしよう！" class="comment-box">{{ old('comment.comment') }}</textarea>
        <input type="submit" value="コメント" class="btn-action">
    </form>

    <style>
        .bg-user-icon {
            background-color: #555555; /* アイコンの背景色を落ち着いた色に */
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
            background-color: #555555; /* アイコンの背景色 */
        }

        .user-name {
            color: #ffffff; /* 白色で視認性を向上 */
            font-size: 1.2rem; /* ユーザー名のフォントサイズを調整 */
            font-weight: 700; /* 太文字にして視認性を向上 */
            line-height: 1.5; /* 行間を調整して読みやすさを確保 */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3); /* 影を付けて文字を際立たせる */
        }

        .image-container img {
            width: 60%;
            height: auto;
            display: block;
            margin: 0 auto;
            object-fit: cover; /* 画像のアスペクト比を保ちながらサイズを調整 */
        }

        .comment-box {
            width: 100%;
            height: 100px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #cccccc;
            margin-bottom: 10px;
            resize: vertical; /* 縦方向のサイズ変更を許可 */
            font-size: 1rem;
            font-family: Arial, sans-serif;
        }

        .btn-action {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333333; /* ダークグレー */
            color: #ffffff; /* 白色 */
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
            cursor: pointer;
            margin-top: 5px;
            border: none;
        }

        .btn-action:hover {
            background-color: #555555; /* ホバー時に少し明るくする */
        }
    </style>
</x-app-layout>
