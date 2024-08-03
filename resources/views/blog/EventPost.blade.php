<x-app-layout>
    <div class="post p-4 mt-16 text-center">
        <!-- ユーザー名&アイコン -->
        <div class="user-container relative mb-4 p-4 rounded bg-user-icon flex items-center justify-center">
            <img src="{{$user->photo}}" alt="user_icon" class="w-9 h-9 rounded-full mr-2">
            <span class="user-name">{{$user->name}}</span>
        </div>

        <!-- イベント投稿フォーム -->
        <form action="{{route('event.EventUpload')}}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="text" name="title" placeholder="イベントの名前" value="{{old('title')}}" class="input-text">
            <input type="text" name="body" placeholder="イベントの概要・注意点・開催日時等" value="{{old('body')}}" class="input-text">
            
            <!-- カスタムファイル選択ボタン -->
            <div class="file-upload-wrapper">
                <label for="file-upload" class="file-upload-label">
                    イベント写真を選択
                </label>
                <input id="file-upload" type="file" name="photo" class="file-upload-input" accept="image/*">
            </div>

            <!-- 画像プレビュー -->
            <div id="image-preview" class="mt-4"></div>

            <input type="text" name="address" placeholder="イベント実施場所の住所" value="{{old('address')}}" class="input-text">
            
            <input type="submit" value="投稿" class="btn-action">
        </form>

        <!-- エラー表示 -->
        @if ($errors->any())
        <div class="error-container mt-4 p-4 bg-red-200 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    <style>
        .bg-car-dark-gray {
            background-color: #333333;
            /* より濃いグレー */
        }

        .bg-user-icon {
            background-color: #555555;
            /* アイコンの背景色を落ち着いた色に */
        }

        .user-name {
            color: #ffffff;
            /* 白色で視認性を向上 */
            font-size: 1.2rem;
            /* ユーザー名のフォントサイズを調整 */
            font-weight: 700;
            /* 太文字にして視認性を向上 */
            line-height: 1.5;
            /* 行間を調整して読みやすさを確保 */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            /* 影を付けて文字を際立たせる */
        }

        .post {
            margin-bottom: 20px;
            /* 投稿間のスペースを追加 */
            width: 60%;
            /* 投稿コンテナの幅を60%に設定 */
            margin-left: auto;
            /* 中央寄せのための左マージン */
            margin-right: auto;
            /* 中央寄せのための右マージン */
        }

        .user-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-text {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            transition: border-color 0.3s ease;
        }

        .input-text:focus {
            outline: none;
            border-color: #D7263D;
            /* アクセントカラーの赤 */
        }

        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-upload-label {
            display: inline-block;
            background-color: #333333;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .file-upload-label:hover {
            background-color: #555555;
            /* ホバー時に少し明るくする */
        }

        .file-upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .btn-action {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333333;
            /* ダークグレー */
            color: #ffffff;
            /* 白色 */
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
            cursor: pointer;
            margin-top: 10px;
            border: none;
        }

        .btn-action:hover {
            background-color: #555555;
            /* ホバー時に少し明るくする */
        }

        .error-container {
            width: 60%;
            margin: 20px auto;
            text-align: left;
        }

        #image-preview img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>

    <script>
        document.getElementById('file-upload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewContainer = document.getElementById('image-preview');
                    previewContainer.innerHTML = '<img src="' + e.target.result + '" alt="Image Preview">';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
