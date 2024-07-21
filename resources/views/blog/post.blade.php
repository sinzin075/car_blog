<x-app-layout>
    <div class="user"><!--ユーザー名&アイコン-->
        <img src="/{$id}" alt="user_icon">
        <span>{{$user -> name}}</span>
    </div>
    <form action="{{route('blog.upload')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="body" placeholder="みんなに共有しよう！" value={{old('post.body')}}>
        <input type="file" name="photo" ><!--クラウディナリーを使用して画像を保存-->
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