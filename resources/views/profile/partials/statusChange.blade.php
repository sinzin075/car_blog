<div class="container mx-auto flex justify-center">
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                ユーザー詳細設定
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                プロフィール写真をアップロードし、愛車の情報を更新できます。
            </p>
        </header>

        <form action="{{ route('statusChangeUpload') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
            @csrf
            @if($user->photo)
                <div class="mb-4 flex justify-center">
                    <div class="user-profile-image-container w-2/5 h-auto overflow-hidden">
                        <img src="{{ $user->photo }}" alt="Current Photo" >
                    </div>
                </div>
            @endif
            <div>
                <x-input-label for="photo" :value="__('プロフィール写真')" />
                <x-text-input id="photo" name="photo" type="file" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="greeting" :value="__('一言メッセージ')" />
                <textarea id="greeting" name="greeting" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:ring-blue-300">{{ old('user->greeting', $user->greeting) }}</textarea>
                <x-input-error :messages="$errors->get('greeting')" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('登録') }}</x-primary-button>
            </div>
        </form>

        <div class="user_car mt-6">
            <header>
                <h3 class="text-lg font-medium text-gray-900">
                    {{ __('ユーザーの愛車一覧') }}
                </h3>
            </header>

            <ul class="flex justify-between mt-4">
                @if (isset($user->car1_id))<!--愛車登録がある場合のみ表示-->
                    <li class="car-card">
                        <p class="font-bold text-center">愛車1</p>
                        @if(isset($user->car1_photo))
                            <img src="{{ $user->car1_photo }}" alt="ユーザーの愛車1" class="car-image mt-2">
                        @else
                            <img src="{{ $user->car1->photo }}" alt="ユーザーの愛車イメージ1" class="car-image mt-2">
                            <span class="block mt-2 text-center">ユーザーの愛車１イメージ</span>
                        @endif
                        <span class="block mt-2 font-bold text-center">{{ $user->car1->name }}</span>
                        <form action="{{ route('userCarPhoto') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <x-text-input id="car1_photo" name="photo" type="file" class="block w-full text-sm text-gray-600" />
                            <input type="hidden" name="carPhoto" value="car1_photo"><!-- 対応するカラム名を指定 -->
                            <div class="flex items-center gap-4 mt-2">
                                <x-primary-button>{{ __('登録') }}</x-primary-button>
                            </div>
                        </form>
                    </li>
                @else
                    <p>愛車登録がまだありません</p>
                @endif

                @if (isset($user->car2_id))
                    <li class="car-card">
                        <p class="font-bold text-center">愛車2</p>
                        @if(isset($user->car2_photo))
                            <img src="{{ $user->car2_photo }}" alt="ユーザーの愛車2" class="car-image mt-2">
                        @else
                            <img src="{{ $user->car2->photo }}" alt="ユーザーの愛車イメージ2" class="car-image mt-2">
                            <span class="block mt-2 text-center">ユーザーの愛車２イメージ</span>
                        @endif
                        <span class="block mt-2 font-bold text-center">{{ $user->car2->name }}</span>
                        <form action="{{ route('userCarPhoto') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <x-text-input id="car2_photo" name="photo" type="file" class="block w-full text-sm text-gray-600" />
                            <input type="hidden" name="carPhoto" value="car2_photo"><!-- 対応するカラム名を指定 -->
                            <div class="flex items-center gap-4 mt-2">
                                <x-primary-button>{{ __('登録') }}</x-primary-button>
                            </div>
                        </form>
                    </li>
                @endif

                @if (isset($user->car3_id))
                    <li class="car-card">
                        <p class="font-bold text-center">愛車3</p>
                        @if(isset($user->car3_photo))
                            <img src="{{ $user->car3_photo }}" alt="ユーザーの愛車3" class="car-image mt-2">
                        @else
                            <img src="{{ $user->car3->photo }}" alt="ユーザーの愛車イメージ3" class="car-image mt-2">
                            <span class="block mt-2 text-center">ユーザーの愛車３イメージ</span>
                        @endif
                        <span class="block mt-2 font-bold text-center">{{ $user->car3->name }}</span>
                        <form action="{{ route('userCarPhoto') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <x-text-input id="car3_photo" name="photo" type="file" class="block w-full text-sm text-gray-600" />
                            <input type="hidden" name="carPhoto" value="car3_photo"><!-- 対応するカラム名を指定 -->
                            <div class="flex items-center gap-4 mt-2">
                                <x-primary-button>{{ __('登録') }}</x-primary-button>
                            </div>
                        </form>
                    </li>
                @endif
            </ul>

            <div class="flex items-center gap-4 mt-4">
                <a href="{{ route('carChoice', ['userId' => Auth::id()]) }}" class="btn-action">{{ __('愛車登録') }}</a>
            </div>
        </div>
    </section>
</div>

<style>
    .bg-car-light-gray {
        background-color: #e0e0e0;
        /* 薄いグレーに変更 */
    }

    .bg-car-dark-gray {
        background-color: #333333;
        /* より濃いグレー */
    }

    .user-container {
        position: relative;
        display: inline-block;
        border-radius: 8px;
        overflow: hidden;
        background-color: #555555;
        /* アイコンの背景色を落ち着いた色に */
    }

    .user-content {
        padding: 10px;
        display: flex;
        align-items: center;
    }

    .user-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #555555;
        /* アイコンの背景色 */
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
        z-index: 20;
        margin-left: 0.5rem;
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

    .user-icon {
        width: 3rem;
        /* アイコンのサイズを調整 */
        height: 3rem;
        border-radius: 50%;
        /* 丸いアイコン */
        margin-right: 0.5rem;
        /* アイコンとテキストの間隔 */
    }

    .user-profile-image {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
        border-radius: 50%;
        /* ユーザープロフィール画像のデザイン */
    }

    .common-image {
        width: 60%;
        height: auto;
        display: block;
        margin: 0 auto;
        object-fit: cover;
        /* 画像のアスペクト比を保ちながらサイズを調整 */
    }

    .btn-new-post {
        display: inline-block;
        padding: 10px 20px;
        background-color: #D7263D;
        /* アクセントカラーの赤 */
        color: white;
        text-transform: uppercase;
        font-weight: bold;
        border-radius: 5px;
        text-align: center;
        transition: background-color 0.3s ease;
        text-decoration: none;
    }

    .btn-new-post:hover {
        background-color: #B51E32;
        /* ホバー時に少し暗くする */
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
        margin: 5px;
        border: none;
    }

    .btn-action:hover {
        background-color: #555555;
        /* ホバー時の色変更 */
    }

    .count-display {
        display: inline-block;
        padding: 10px 20px;
        background-color: #333333;
        /* ダークグレー */
        color: #ffffff;
        /* 白色 */
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
        margin: 5px;
        transition: background-color 0.3s ease;
    }

    .car-card {
        background-color: #f5f5f5;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: 30%;
        margin: 0 1%;
        /* 車カードのデザイン */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        /* フレックスボックスで下に寄せる */
    }

    .car-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
        /* 車画像のデザイン */
    }

    .car-card p,
    .car-card span {
        color: #333333;
        /* テキストの色を濃いグレーに */
        font-weight: bold;
        text-align: center;
        margin-top: 10px;
        /* 上下の余白を追加 */
    }

    .no_comments {
        color: #999999;
        /* 薄いグレーで未コメントを表示 */
        font-style: italic;
        /* イタリックで強調 */
        text-align: center;
        /* 中央揃え */
        margin-top: 10px;
    }

    .comment-divider {
        margin: 15px 0;
        border-top: 1px solid #cccccc;
        /* コメント区切りの薄い線 */
    }

    /* フォローボタンのスタイル */
    .follow-button {
        display: inline-block;
        padding: 8px 16px;
        background-color: #1DA1F2;
        /* Twitterブルーに近い色 */
        color: #ffffff;
        font-weight: bold;
        border-radius: 5px;
        text-align: center;
        text-transform: uppercase;
        transition: background-color 0.3s ease;
        cursor: pointer;
        border: none;
        margin: 5px 0;
    }

    .follow-button:hover {
        background-color: #0d8de0;
        /* ホバー時に少し暗くする */
    }

    .unfollow-button {
        display: inline-block;
        padding: 8px 16px;
        background-color: #ff4444;
        /* 赤色で目立たせる */
        color: #ffffff;
        font-weight: bold;
        border-radius: 5px;
        text-align: center;
        text-transform: uppercase;
        transition: background-color 0.3s ease;
        cursor: pointer;
        border: none;
        margin: 5px 0;
    }

    .unfollow-button:hover {
        background-color: #cc3333;
        /* ホバー時に少し暗くする */
    }
</style>
