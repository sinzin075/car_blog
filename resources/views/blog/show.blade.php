<x-app-layout>
    <div class="user"><!--ユーザー名&アイコン-->
        <img src="" alt="user_icon">
        <span>{{$blog -> user -> name}}</span>
    </div>
    <p class="body">{{$blog -> body}}</p><!--blog本文-->
    <p><img src="{{$blog -> photo}}"></p>
    <span>
        <div class="comment_count">{{$comment_count[$blog->id]}}</div><!--コメント数-->
        <!--ここまで完了-->
        <div class="good">{{$blog->good}}</div><!--いいね数-->
    </span>
        @if (isset($blog_comments[$blog->id]) && count($blog_comments[$blosg->id]) > 0)
            <div class="comment_count">{{ count($blog_comments[$blogs->id]) }}</div><!--コメント数-->
            @foreach ($blog_comments[$blogs->id] as $comment)
                <!--コメント内容を表示-->
                <div class="comment">{{ $comment->content }}</div>
            @endforeach
        @else
            <div class="no_comments"></div>
        @endif

</x-app-layout>