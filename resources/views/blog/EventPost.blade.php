<x-app-layout>
    <div class="user"><!--ユーザー名&アイコン-->
        <img src="/{$id}" alt="user_icon">
        <span>{{$user -> name}}</span>
    </div>
    <form action="{{route('event.EventUpload')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="title" placeholder="イベントの名前を入力！"　value={{old('title')}}>
        <input type="text" name="body" placeholder="イベントの概要・注意点等の入力！" value={{old('body')}}>
        <input type="file" name="photo" ><!--クラウディナリーを使用して画像を保存-->
        <label for="address">イベント実施場所の住所を入力:</label>
        <input type="text" name="address" value={{old('address')}}>
        <input type="submit" value="投稿">
    </form>
     @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</x-app-layout>

