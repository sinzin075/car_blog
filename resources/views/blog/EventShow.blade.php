<x-app-layout>
    <x-slot name="header">
        <div class="bg-car-dark-gray text-white p-4 fixed w-full z-10">
            Car Blog
        </div>
    </x-slot>

    <!-- 削除ボタンの表示 -->
    @if (Auth::check() && Auth::user()->id == $event->user_id)
    <form action="{{ route('event.EventDestroy', $event->id) }}" method="POST" onsubmit="return confirm('本当にこの投稿を削除してもよろしいですか？');" class="text-right mb-4">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-delete">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="inline-block w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            イベントを削除
        </button>
    </form>
    @endif

    <div class="post p-4 mt-4 bg-car-light-gray rounded shadow space-y-4">
        <!-- 投稿者の情報 -->
        <div class="user-container relative mb-2 p-2 rounded">
            <a href="{{route('status',['userId'=>$event->user->id])}}">        
                <div class="user-content flex items-center relative z-10" style="padding: 10px;">
                    <img src="{{$event->user->photo}}" alt="user_icon" class="user-icon">
                    <span class="user-name">{{$event->user->name}}</span>
                </div>
                <div class="user-background absolute inset-0 bg-user-icon"></div>
            </a>
        </div>

        <div>
            <p class="title text-car-dark-gray mb-2">{{$event->title}}</p>
            <!-- blog本文 -->
            <p class="body text-car-dark-gray mb-2">{{$event->body}}</p>
            <!-- blog本文 -->
            <div class="image-container flex justify-center">
                <img src="{{$event->photo}}" class="common-image rounded">
            </div>

            <span class="address text-car-dark-gray mb-2 block">イベント会場：{{$event->address}}</span>

            <!-- Google Mapの表示エリア -->
            <div id="map-{{ $event->id }}" class="map-container mt-4" data-lat="{{ $event->lat }}" data-lng="{{ $event->lng }}"></div>
        </div>

        <div class="flex justify-between items-center mt-2">
            <div class="flex space-x-4 items-center">
                <div class="count-display comment_count">💬 {{ $event->eventComment ? $event->eventComment->count() : 0 }}</div>
                <!-- コメント数 -->
                <div class="count-display good">❤ {{ $event->event_likes ? $event->event_likes->count() : 0 }}</div>
                <!-- いいね数 -->
            </div>
            <div class="flex space-x-4 items-center">
                <a href="{{route('event.EventComment', ['event' => $event->id])}}" class="btn-action">コメント</a>
                <!-- コメント画面へ遷移 -->
                <form action="{{route('event.EventGood', ['event' => $event->id])}}" method="POST" enctype="multipart/form-data" class="inline-block">
                    <!-- いいねボタン -->
                    @csrf
                    <button type="submit" class="btn-action">いいね</button>
                </form>
            </div>
        </div>

        <hr class="comment-divider">
        <!-- コメントと本文の境界線 -->

        <!-- コメント表示 -->
        @if (isset($event->eventComment) && count($event->eventComment) > 0)
            @foreach ($event->eventComment as $comment)
            <div class="comment-container mt-4 p-2 rounded">
                <a href="{{route('status',['userId'=>$comment->user->id])}}">    
                    <div class="user-container relative mb-2 p-2 rounded" style="display: inline-block;">
                        <div class="user-content flex items-center relative z-10" style="padding: 10px;">
                            <img src="{{$comment->user->photo}}" alt="user_icon" class="user-icon">
                            <span class="user-name">{{$comment->user->name}}</span>
                        </div>
                        <div class="user-background absolute inset-0 bg-user-icon"></div>
                    </div>
                    <p class="body text-black ml-2">{{$comment->comment}}</p>
                </a>
            </div>
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
            position: relative;
            z-index: 10;
            background-color: #555555; /* アイコンと名前に背景をつける */
            border-radius: 8px; /* 背景をラウンドにする */
        }

        .user-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #555555;
            z-index: 0;
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
            position: relative;
        }

        .user-icon {
            width: 2.5rem;
            /* アイコンのサイズを調整 */
            height: 2.5rem;
            border-radius: 50%;
            /* 丸いアイコン */
            margin-right: 0.5rem;
            /* アイコンとテキストの間隔 */
            position: relative;
            z-index: 20;
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
            background-color: #333333;
            /* ダークグレー */
            color: #ffffff;
            /* 白色 */
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 1.1rem;
            /* 数字を強調 */
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

        .map-container {
            height: 500px;
            width: 60%;
            margin: 20px auto;
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .flex {
            display: flex;
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .justify-end {
            justify-content: flex-end;
        }

        .items-center {
            align-items: center;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .space-x-4 > :not(template) ~ :not(template) {
            --tw-space-x-reverse: 0;
            margin-right: calc(1rem * var(--tw-space-x-reverse));
            margin-left: calc(1rem * calc(1 - var(--tw-space-x-reverse)));
        }

        .ml-auto {
            margin-left: auto;
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

        .comment-container {
            /* コメントの背景色を削除 */
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
        }
    </style>

    <!-- Google Maps APIスクリプト -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}" async defer></script>

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

            // Google Mapsの初期化
            var maps = document.querySelectorAll('.map-container');
            maps.forEach(function(mapContainer) {
                var lat = parseFloat(mapContainer.getAttribute('data-lat'));
                var lng = parseFloat(mapContainer.getAttribute('data-lng'));
                var location = {lat: lat, lng: lng};

                var map = new google.maps.Map(mapContainer, {
                    zoom: 17,
                    center: location
                });

                new google.maps.Marker({
                    position: location,
                    map: map
                });
            });
        });
    </script>
</x-app-layout>
