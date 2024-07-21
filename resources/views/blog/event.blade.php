<x-app-layout>
    <x-slot name="header">
        Car Blog
    </x-slot>
    <div class="post"><!--投稿画面へ遷移-->
        <a href="{{ route('EventPost')}}">new post</a>
    </div>

    @foreach ($events as $event)
        <div class="post"><!--投稿内容-->
            <a href={{route('EventShow',['event'=>$event->id])}}><!--投稿詳細へ遷移-->
                <div class="user"><!--ユーザー名&アイコン-->
                    <img src="" alt="user_icon">
                    <span>{{$event->user->name}}</span>
                </div>
                <div>
                    <p class="title">{{$event->title}}</p><!--blog本文-->
                    <p class="body">{{$event->body}}</p><!--blog本文-->
                    <p><img src="{{$event->photo}}"></p>
                    <span class="address">{{$event->address}}</span>

                    <!-- Google Mapの表示エリア -->
                    <div id="map-{{ $event->id }}" style="height: 500px; width: 60%;"></div>

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
                </div>
                <span>
                    <div class="comment_count">💬{{ $event->eventComments ? $event->eventComments->count() : 0 }}</div><!--コメント数-->
                    <div class="good">❤{{ $event->eventComments ? $event->eventComments->count() : 0 }}</div><!--いいね数-->
                </span>
                
                <a href = {{route('EventComment',['event'=>$event->id])}}>comment</a><!--コメント画面へ遷移-->
                
                <form action="{{route('EventGood',['event' => $event ->id])}}" method="POST" enctype="multipart/form-data"><!--いいねボタン-->
                    @csrf
                    <input type="submit" value="いいね"><!--ボタンの生成-->
                </form>
                       
                                
                @if (isset($blog ->blogComment) && count($blog->blogComment) > 0)
                        <div class="user"><!--コメントユーザー名&アイコン-->
                            <img src="" alt="user_icon">
                            <span>{{$event->eventComments->last()->user->name}}</span><!--blogのリレーションから取得していたものを解除したためエラー発生-->
                            <p class="body">{{$event->eventComments->last()}}</p><!--blog本文-->
                        </div>
                @else
                    <div class="no_comments">コメントはまだありません</div>
                @endif
                    
            </a>
        </div>
    @endforeach

    <!-- Google Maps APIスクリプト -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap" async defer></script>
</x-app-layout>
