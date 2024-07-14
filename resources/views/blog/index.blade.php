<x-app-layout>
    <x-slot name="header">
        Car Blog
    </x-slot>
    <div class="post"><!--投稿画面へ遷移-->
        <a href="{{ route('post')}}">new post</a>
    </div>

    @foreach ($blogs as $blog)
        <div class="post"><!--投稿内容-->
            <a href={{route('show',['blog'=>$blog->id])}}><!--投稿詳細へ遷移-->
                <div class="user"><!--ユーザー名&アイコン-->
                    <img src="" alt="user_icon">
                    <span>{{$blog->user->name}}</span>
                </div>
                <p class="body">{{$blog->body}}</p><!--blog本文-->
                <p><img src="{{$blog->photo}}"></p>
                <span>
                    <div class="comment_count">{{$comment_count[$blog->id]}}</div><!--コメント数-->
                    <div class="good">{{$blog->good}}</div><!--いいね数-->
                </span>
                
                
                <a href = {{route('comment',['blog'=>$blog->id])}}>comment</a><!--コメント画面へ遷移-->
                @if (isset($blog ->blogComments) && count($blog->blogComments) > 0)
                    <div class="comment_count">{{ count($blog->blogComments) }}</div><!--コメント数-->
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
                    
            </a>
        </div>
    @endforeach
</x-app-layout>