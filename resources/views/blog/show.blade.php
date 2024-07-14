<x-app-layout>
    
    <!-- 削除ボタンの表示 -->
    @if (Auth::check() && Auth::user()->id == $blog->user_id)
        <form action="{{ route('destroy', $blog->id) }}" method="POST" onsubmit="return confirm('本当にこの投稿を削除してもよろしいですか？');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">削除</button>
        </form>
    @endif
    
    
    <div class="user"><!--ユーザー名&アイコン-->
        <img src="" alt="user_icon">
        <span>{{$blog -> user -> name}}</span>
    </div>
    <p class="body">{{$blog -> body}}</p><!--blog本文-->
    <p><img src="{{$blog -> photo}}"></p>
    
    
    <span>
        <div class="comment_count">💬{{$comment_count[$blog->id]}}</div><!--コメント数-->
        <!--ここまで完了-->
        <div class="good">❤{{$like_count[$blog->id]}}</div><!--いいね数-->
    </span>
    
    
    <a href = {{route('comment',['blog'=>$blog->id])}}>comment</a><!--コメント画面へ遷移-->
    
    <form action="{{route('good',['blog' => $blog ->id])}}" method="POST" enctype="multipart/form-data"><!--いいねボタン-->
        @csrf
        <input type="submit" value="いいね"><!--ボタンの生成-->
    </form>
    
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