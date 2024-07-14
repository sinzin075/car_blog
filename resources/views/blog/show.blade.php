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
    <a href = {{route('comment',['blog'=>$blog->id])}}>comment</a><!--コメント画面へ遷移-->
       @if (isset($blog ->blogComments) && count($blog->blogComments) > 0)
                    @foreach ($blog->blogComments as $comment)
                        <div class="user"><!--コメントユーザー名&アイコン-->
                            <img src="" alt="user_icon">
                            <span>{{$comment->user->name}}</span>
                            <p class="body">{{$comment->comment}}</p><!--blog本文-->
                        </div>
                        <div class="comment">{{ $comment->content }}</div>
                    @endforeach
                @else
                    <div class="no_comments">コメントはまだありません</div>
                @endif

</x-app-layout>