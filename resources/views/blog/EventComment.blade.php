<x-app-layout>
    <div class="user"><!--ユーザー名&アイコン-->
        <img src="" alt="user_icon">
        <span>{{$commentUser -> name}}</span>
    </div>
    
    <div class="user"><!--投稿者ユーザー名&アイコン-->
        <img src="" alt="user_icon">
        <span>{{$event -> user -> name}}</span>
    </div>
    
    <p class="body">{{$event -> body}}</p><!--blog本文-->
    <p><img src="{{$event -> photo}}"></p>
    
     <form action="{{route('EventCommentUpload',['event' => $event ->id])}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="comment" placeholder="コメントをしよう！" value={{old('comment.comment')}}>
        <input type="submit" value="コメント">
    </form>
</x-app-layout>