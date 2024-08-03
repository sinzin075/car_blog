<x-app-layout>
    <x-slot name="header">
        <div class="bg-car-dark-gray text-white p-4 fixed w-full z-10">
            Car Blog
        </div>
    </x-slot>

    <div class="post p-4 mt-16 text-center">
        <a href="{{ route('event.EventPost') }}" class="btn-new-post">New Post</a>
    </div>

    @foreach ($events as $event)
    <div class="post p-4 my-4 bg-car-light-gray rounded shadow space-y-4">
        <a href="{{route('event.EventShow', ['event' => $event->id])}}">
            <div class="user-container relative mb-2 p-2 rounded" style="display: inline-block;">
                <div class="user-content flex items-center relative z-10" style="padding: 10px;">
                    <img src="{{$event->user->photo}}" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
                    <span class="user-name">{{$event->user->name}}</span>
                </div>
                <div class="user-background absolute inset-0 bg-user-icon"></div>
            </div>

            <p class="title text-car-dark-gray mb-2">{{$event->title}}</p>
            <p class="body text-car-dark-gray mb-2">{{$event->body}}</p>
            <div class="image-container flex justify-center">
                <img src="{{$event->photo}}" class="common-image rounded">
            </div>

            <div id="map-{{ $event->id }}" class="map-container mt-4" data-lat="{{ $event->lat }}" data-lng="{{ $event->lng }}"></div>

            <span class="address text-car-dark-gray mb-2 block">イベント会場：{{$event->address}}</span>

            <div class="flex justify-between items-center mt-2">
                <div class="flex space-x-4">
                    <div class="count-display">💬 {{ $event->eventComments ? $event->eventComments->count() : 0 }}</div>
                    <div class="count-display">❤ {{ $event->event_likes ? $event->event_likes->count() : 0 }}</div>
                </div>
                <div class="ml-auto flex space-x-4">
                    <a href="{{route('event.EventComment', ['event' => $event->id])}}" class="btn-action">Comment</a>
                    <form action="{{route('event.EventGood', ['event' => $event->id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <button type="submit" class="btn-action">いいね</button>
                    </form>
                </div>
            </div>

            @if (isset($event->eventComments) && count($event->eventComments) > 0)
            <div class="user-container relative mt-4 p-2 rounded" style="display: inline-block;">
                <div class="user-content flex items-center relative z-10" style="padding: 10px;">
                    <img src="{{$event->eventComments->last()->user->photo}}" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
                    <span class="user-name">{{$event->eventComments->last()->user->name}}</span>
                    <p class="body text-black ml-2">{{$event->eventComments->last()->comment}}</p>
                </div>
                <div class="user-background absolute inset-0 bg-user-icon"></div>
            </div>
            @else
            <div class="no_comments text-black mt-4">
                コメントはまだありません
            </div>
            @endif
        </a>
    </div>
    @endforeach

    <style>
        .bg-car-light-gray {
            background-color: #e0e0e0;
        }

        .bg-car-dark-gray {
            background-color: #333333;
        }

        .text-car-accent-red {
            color: #D7263D;
        }

        .bg-car-accent-red {
            background-color: #D7263D;
        }

        .bg-user-icon {
            background-color: #555555;
        }

        .post {
            margin-bottom: 20px;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
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
        }

        .user-name {
            color: #ffffff;
            font-size: 1.2rem;
            font-weight: 700;
            line-height: 1.5;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .image-container img {
            width: 60%;
            height: auto;
            display: block;
            margin: 0 auto;
            object-fit: cover;
        }

        .btn-new-post {
            display: inline-block;
            padding: 10px 20px;
            background-color: #D7263D;
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
            margin: 0 5px;
            border: none;
        }

        .btn-action:hover {
            background-color: #555555;
        }

        .count-display {
            display: inline-block;
            padding: 5px 10px;
            background-color: #333333;
            color: #ffffff;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin: 5px;
            width: 60px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
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
    </style>

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

    <!-- Google Maps APIスクリプト -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}" async defer></script>
</x-app-layout>
