<x-app-layout>
    <x-slot name="header">
        <div class="bg-car-dark-gray text-white p-4 fixed w-full z-10 text-center">
            Car Blog
        </div>
    </x-slot>

    <div class="post mx-auto mb-4 p-4 bg-car-dark-gray text-white rounded" style="width: 60%;">
        @foreach($cars as $countryName => $makers)
            <h2 class="text-xl font-bold mt-6 mb-2">{{ $countryName }}</h2>
            @foreach($makers->groupBy('maker.name') as $makerName => $carsByMaker)
                <h3 class="text-lg font-semibold mt-4 mb-2">{{ $makerName }}</h3>
                <div class="flex flex-wrap -mx-1 lg:-mx-4 car-container">
                    @foreach($carsByMaker as $car)
                        <div class="car-item px-1 py-1 lg:px-4 lg:py-4 car-card">
                            <p class="text-center font-bold mt-2">{{ $car->name }}</p>
                            <div class="car-photo-container">
                                <img class="car-image" src="{{ $car->photo }}" alt="{{ $car->name }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endforeach
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
            width: 35%;
            height: auto;
            display: block;
            object-fit: cover;
            /* 縦長画像をカットする */
            clip-path: inset(15% 0 15% 0);
            /* 上下15%をカット */
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

        .car-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .car-card {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 18%;
            margin:5px 1%;
            /* 車カードのデザイン */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            /* フレックスボックスで下に寄せる */
            align-items: center;
        }

        .car-image {
            width: 100%;
            height: 150px;
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
</x-app-layout>
