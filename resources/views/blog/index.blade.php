<x-app-layout>
    <x-slot name="header">
        Car Blog
    </x-slot>
    <div class="post"><!--投稿画面へ遷移-->
        <a href="{{ route('post')}}">new post</a>
    </div>

    @foreach ($blogs as $blog)
        <div class="post"><!--投稿内容-->
            <a href={{route('show',['blog' => $blog->id])}}><!--投稿詳細へ遷移-->
                <div class="user"><!--ユーザー名&アイコン-->
                    <img src="" alt="user_icon">
                    <span>{{$blog -> user -> name}}</span>
                </div>
                <p class="body">{{$blog -> body}}</p><!--blog本文-->
                <p><img src="{{$blog -> photo}}"></p>
                <span>
                    <div class="comment_count">{{$comment_count[$blog -> id]}}</div><!--コメント数-->
                    <!--ここまで完了-->
                    <div class="good">{{$blog->good}}</div><!--いいね数-->
                </span>
                <a href = {{route('comment',['blog' => $blog->id])}}>comment</a><!--コメント画面へ遷移-->
                    @if (isset($blog_comments[$blog->id]) && count($blog_comments[$blog->id]) > 0)
                        <div class="comment_count">{{ count($blog_comments[$blog->id]) }}</div><!--コメント数-->
                        @foreach ($blog_comments[$blog->id] as $comment)
                            <!--コメント内容を表示-->
                            <div class="comment">{{ $comment->content }}</div>
                        @endforeach
                    @else
                        <div class="no_comments"></div>
                    @endif
                    
            </a>
        </div>
    @endforeach
</x-app-layout>