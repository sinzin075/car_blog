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
                <p class="body">{{$event->body}}</p><!--blog本文-->
                <p><img src="{{$event->photo}}"></p>
              
                <span>
                    <div class="comment_count">💬{{ $event->eventComments ? $event->eventComments->count() : 0 }}</div><!--コメント数-->
                    <div class="good">❤{{ $event->eventComments ? $event->eventComments->count() : 0 }}</div><!--いいね数-->
                </span>
                
                <a href = {{route('',['blog'=>$blog->id])}}>comment</a><!--コメント画面へ遷移-->
                
                <form action="{{route('good',['blog' => $blog ->id])}}" method="POST" enctype="multipart/form-data"><!--いいねボタン-->
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
</x-app-layout>