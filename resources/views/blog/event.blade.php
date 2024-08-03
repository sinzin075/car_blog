<x-app-layout>
    <x-slot name="header">
        <div class="bg-car-dark-gray text-white p-4 fixed w-full z-10">
            Car Blog
        </div>
    </x-slot>
    
    <div class="post p-4 mt-16 text-center"><!--投稿画面へ遷移-->
        <a href="{{ route('event.EventPost')}}" class="btn-new-post">new post</a>
    </div>

    @foreach ($events as $event)
        <div class="post p-4 my-4 bg-car-light-gray rounded shadow space-y-4"><!--投稿内容-->
            <a href="{{route('event.EventShow', ['event' => $event->id])}}">
                <div class="user-container relative mb-2 p-2 rounded" style="display: inline-block;">
                    <div class="user-content flex items-center relative z-10 diagonal-line" style="padding: 10px;">
                        <img src="{{$event->user->photo}}" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
                        <span class="text-white font-bold text-xl" style="font-size: 20px;">{{$event->user->name}}</span>
                    </div>
                    <div class="user-background absolute inset-0 bg-car-accent-red"></div>
                </div>
                <p class="title text-car-dark-gray mb-2">{{$event->title}}</p><!--イベントタイトル-->
                <p class="body text-car-dark-gray mb-2">{{$event->body}}</p><!--イベント本文-->
                <div class="image-container flex justify-center">
                    <img src="{{$event->photo}}" class="common-image rounded">
                </div>
                <!-- Google Mapの表示エリア -->
                <p id="map-{{ $event->id }}" class="map-container"></p>
                <script>
                    function initMap() {
                        @foreach ($events as $event)
                            var lat{{ $event->id }} = {{ $event->lat }};
                            var lng{{ $event->id }} = {{ $event->lng }};
                            
                            var location{{ $event->id }} = {lat: lat{{ $event->id }}, lng: lng{{ $event->id }}};
                            var map{{ $event->id }} = new google.maps.Map(document.getElementById('map-{{ $event->id }}'), {
                                zoom: 17,
                                center: location{{ $event->id }}
                            });
                
                            var marker{{ $event->id }} = new google.maps.Marker({
                                position: location{{ $event->id }},
                                map: map{{ $event->id }}
                            });
                        @endforeach
                    }
                </script>
                
                <span class="address text-car-dark-gray mb-2">イベント会場：{{$event->address}}</span>
              
                <div class="flex justify-between items-center mt-2">
                    <div class="flex space-x-4">
                        <div class="comment_count text-car-dark-gray font-bold text-3xl">💬{{ $event->eventComments ? $event->eventComments->count() : 0 }}</div><!--コメント数-->
                        <div class="good text-car-dark-gray font-bold text-3xl">❤{{ $event->eventComments ? $event->eventComments->count() : 0 }}</div><!--いいね数-->
                    </div>
                </div>
                
                <a href="{{route('event.EventComment', ['event' => $event->id])}}" class="text-black mt-2 inline-block bg-black text-white px-4 py-2 rounded hover:bg-gray-800 font-bold text-lg">comment</a><!--コメント画面へ遷移-->
                
                <form action="{{route('event.EventGood', ['event' => $event->id])}}" method="POST" enctype="multipart/form-data" class="mt-2"><!--いいねボタン-->
                    @csrf
                    <input type="submit" value="いいね" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 font-bold text-lg">
                </form>
                       
                @if (isset($blog->blogComment) && count($blog->blogComment) > 0)
                    <div class="user-container relative mt-4 p-2 rounded" style="display: inline-block;">
                        <div class="user-content flex items-center relative z-10 diagonal-line" style="padding: 10px;"><!--コメントユーザー名&アイコン-->
                            <img src="" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
                            <span class="text-white font-bold text-xl" style="font-size: 20px;">{{$event->eventComments->last()->user->name}}</span>
                            <p class="body text-car-dark-gray ml-2">{{$event->eventComments->last()}}</p><!--コメント本文-->
                        </div>
                        <div class="user-background absolute inset-0 bg-car-accent-red"></div>
                    </div>
                @else
                    <div class="no_comments text-car-dark-gray mt-4">コメントはまだありません</div>
                @endif
            </a>
        </div>
    @endforeach

    <!-- Google Maps APIスクリプト -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap" async defer></script>

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
        .image-container img {
            width: 60%;
            height: auto;
            display: block;
            margin: 0 auto;
            object-fit: cover; /* 画像のアスペクト比を保ちながらサイズを調整 */
        }
        .btn-new-post {
            display: inline-block;
            padding: 10px 20px;
            background-color: #D7263D; /* アクセントカラーの赤 */
            color: white;
            text-transform: uppercase;
            font-weight: bold;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .btn-new-post:hover {
            background-color: #B51E32; /* ホバー時に少し暗くする */
        }
        .map-container {
            height: 500px;
            width: 60%;
            margin: 0 auto;
        }
    </style>
</x-app-layout>
