<x-app-layout>
    <x-slot name="header">
        Car Blog
    </x-slot>
    <div class="menu">
        <ul>
            <li><a href="">Blog</a></li><!--blog画面へ遷移-->
            <li><a href="">Event</a></li><!--event画面へ遷移-->
            <li><a href="">Users</a></li><!--userstatus画面へ遷移-->
        </ul>
    </div>
    <div class="post"><!--投稿画面へ遷移-->
        <a href="{{ route('post') }}">new post</a>
    </div>

    @foreach ($blogs as $blog)
        <div class="post"><!--投稿内容-->
            <a href=""><!--投稿詳細へ遷移-->
                <div class="user"><!--ユーザー名&アイコン-->
                    <img src="" alt="user_icon">
                    <span>{{$blog -> user -> name}}</span>
                </div>
                <p class="body">{{$blog -> body}}</p><!--blog本文-->
                <span>
                    <div class="comment_count">{{$comment_count[$blog -> id]}}</div><!--コメント数-->
                    <!--ここまで完了-->
                    <div class="good">{{$blog->good}}</div><!--いいね数-->
                </span>
                @foreach($blog_comments as $comment)
                    <p>{{ $blogs->comment }}</p>
                @endforeach
                    
            </a>
        </div>
    @endforeach
</x-app-layout>