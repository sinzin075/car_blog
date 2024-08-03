<x-app-layout>
    <div class="post p-4 mt-16 bg-car-light-gray rounded shadow space-y-4" style="width: 60%; margin: 0 auto;">
        <!-- コメントしたユーザー名&アイコン -->
        <div class="user flex items-center mb-4">
            <img src="{{$commentUser->photo}}" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
            <span class="user-name">{{$commentUser->name}}</span>
        </div>
        
        <!-- 投稿者ユーザー名&アイコン -->
        <div class="user flex items-center mb-4">
            <img src="{{$event->user->photo}}" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
            <span class="user-name">{{$event->user->name}}</span>
        </div>
        
        <!-- イベントの内容 -->
        <p class="body text-black mb-4">{{$event->body}}</p>
        <div class="image-container flex justify-center mb-4">
            <img src="{{$event->photo}}" class="common-image rounded">
        </div>

        <!-- コメントフォーム -->
        <form action="{{route('event.EventCommentUpload',['event' => $event->id])}}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="text" name="comment" placeholder="コメントをしよう！" value="{{ old('comment.comment') }}" class="comment-input">
            <input type="submit" value="コメント" class="btn-action">
        </form>
    </div>

    <style>
        .bg-car-light-gray {
            background-color: #e0e0e0;
            /* 薄いグレーに変更 */
        }

        .post {
            margin-bottom: 20px;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
        }

        .user {
            position: relative;
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: #777777;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .user-name {
            color: #ffffff;
            font-size: 1.2rem;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .body {
            color: #333333;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .image-container img {
            width: 60%;
            height: auto;
            display: block;
            margin: 0 auto;
            object-fit: cover;
        }

        .comment-input {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .btn-action {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333333;
            color: #ffffff;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .btn-action:hover {
            background-color: #555555;
        }
    </style>
</x-app-layout>
