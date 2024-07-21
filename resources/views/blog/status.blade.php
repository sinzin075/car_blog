<x-app-layout>
    <x-slot name="header">
        Car Blog
    </x-slot>
    <a href="{{ route('statusChange',Auth::user()->id) }}">ユーザーステータス変更</a>
    <div class="user"><!--ユーザー名&アイコン-->
        <img src="{{$user->photo}}" alt="user_icon">
        <span>{{$user->name}}</span>
        <p>{{$user->greeting}}</p><!--ユーザーの一言-->
    </div>
    <div>
        <span>フォロー：{{$followersCount}}</span>
        <span>フォロワー：{{$followingsCount}}</span>
    </div>
    
    <div class="user_car"><!--ユーザーの愛車一覧-->
        <ul>
            @if (isset($user ->car1_id))<!--愛車登録がある場合のみ表示-->
                <li>
                    <p>愛車‗1</p>
                    <img src="" alt="ユーザーの愛車1">
                    <span>{{$car[$user->car1_id]->name}}</span>
                </li>
            @else
                <p>愛車登録がまだありません</p>
            @endif
            @if (isset($user ->car2_id))
            <li>
                <p>愛車‗2</p>
                <img src="" alt="ユーザーの愛車2">
                <span>{{$car[$user->car2_id]->name}}</span>
            </li>
            @endif
            @if (isset($user ->car3_id))
            <li>
                <p>愛車‗3</p>
                <img src="" alt="ユーザーの愛車3">
                <span>{{$car[$user->car3_id]->name}}</span>
            </li>
            @endif
        </ul>
    </div>
        
    
    @foreach ($blogs as $blog)
        <div class="post"><!--投稿内容-->
            <a href={{route('blog.show',['blog'=>$blog->id])}}><!--投稿詳細へ遷移-->
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
                
                <a href = {{route('blog.comment',['blog'=>$blog->id])}}>comment</a><!--コメント画面へ遷移-->
                
                <form action="{{route('blog.good',['blog' => $blog ->id])}}" method="POST" enctype="multipart/form-data"><!--いいねボタン-->
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