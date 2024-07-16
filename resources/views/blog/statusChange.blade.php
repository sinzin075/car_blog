<x-app-layout>
    <x-slot name="header">
        Car Blog
    </x-slot>
    <!--変更点-->
    <form action="{{route('statusCanageUpload')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name" placeholder="ユーザー名" value={{old($user->name)}}>
        <input type="file" name="photo" value={{old($user->photo) }}><!--クラウディナリーを使用して画像を保存-->
        <input type="textarea" name="greeting" value={{old($user->greeting) }}>
        <input type="submit" value="登録">
    </form>
    
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
</x-app-layout>