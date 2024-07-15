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
                    <div class="comment_count">💬{{$comment_count[$blog->id]}}</div><!--コメント数-->
                    <div class="good">❤{{$like_count[$blog->id]}}</div><!--いいね数-->
                </span>
                
                <a href = {{route('comment',['blog'=>$blog->id])}}>comment</a><!--コメント画面へ遷移-->
                
                <form action="{{route('good',['blog' => $blog ->id])}}" method="POST" enctype="multipart/form-data"><!--いいねボタン-->
                    @csrf
                    <input type="submit" value="いいね"><!--ボタンの生成-->
                </form>
                       
                                
                @if (isset($blog ->blogComments) && count($blog->blogComments) > 0)
                        <div class="user"><!--コメントユーザー名&アイコン-->
                            <img src="" alt="user_icon">
                            <span>{{$last_comments[$blog->id]->user->name}}</span><!--blogのリレーションから取得していたものを解除したためエラー発生-->
                            <p class="body">{{$last_comments[$blog->id]->comment}}</p><!--blog本文-->
                        </div>
                        <div class="comment">{{$last_comments[$blog->id]->content}}</div>
                @else
                    <div class="no_comments">コメントはまだありません</div>
                @endif
                    
            </a>
        </div>
    @endforeach
</x-app-layout>