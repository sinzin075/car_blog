<section>
    <!--変更点-->
    <h2 class="text-lg font-medium text-gray-900">ユーザー詳細設定</h2>
    
    <form action="{{route('statusChangeUpload')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($user->photo)
            <div>
                <img src="{{ $user->photo }}" alt="Current Photo">
            </div>
        @endif
        <input type="file" name="photo"><!--クラウディナリーを使用して画像を保存-->
        <textarea name="greeting">{{ old('user->greeting',$user->greeting) }}</textarea>
        <input type="submit" value="登録">
    </form>
    
    <div class="user_car"><!--ユーザーの愛車一覧-->
        <ul>
            @if (isset($user ->car1_id))<!--愛車登録がある場合のみ表示-->
            <li>
                <p>愛車‗1</p>
                <img src="{{$user->car1->photo}}" alt="ユーザーの愛車1">
                <span>{{$user->car1->name}}</span>
            </li>
            @else
            <p>愛車登録がまだありません</p>
            @endif
            @if (isset($user ->car2_id))
            <li>
                <p>愛車‗2</p>
                <img src="{{$user->car1->photo}}" alt="ユーザーの愛車2">
                <span>{{$user->car2->name}}</span>
            </li>
            @endif
            @if (isset($user ->car3_id))
            <li>
                <p>愛車‗3</p>
                <img src="{{$user->car1->photo}}" alt="ユーザーの愛車3">
                <span>{{$user->car3->name}}</span>
            </li>
            @endif
        </ul>
        <a href="{{route('carChoice', ['userId' => Auth::id()])}}">愛車登録</a>
    </div>
</section>