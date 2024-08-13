<x-app-layout>
    <div class="user-list-background">
        <div class="user-list-container">
            @foreach($users as $user)
                <a href="{{ route('status', [$user->id]) }}" class="user-link">
                    <div class="user-card">
                        <img src="{{ $user->photo }}" alt="{{ $user->name }}のアイコン" class="user-icon">
                        <span class="user-name">{{ $user->name }}</span>
                    </div>
                </a>
            @endforeach    
        </div>
    </div>
</x-app-layout>

<style>
    .user-list-background {
        background-color: #f0f0f0; /* 背景色をライトグレーに設定 */
        width: 60%;
        height: 100vh; /* 画面の高さいっぱいに表示 */
        margin: 0 auto; /* 中央寄せ */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* 軽いシャドウを追加 */
    }

    .user-list-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        margin-top: 20px;
    }

    .user-link {
        width: 100%; /* リンクは背景色の幅いっぱいに */
        text-decoration: none;
    }

    .user-card {
        display: flex;
        align-items: center;
        background-color: #555555;
        padding: 10px;
        border-radius: 10px;
        transition: background-color 0.3s ease;
    }

    .user-card:hover {
        background-color: #666666;
    }

    .user-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 20px;
    }

    .user-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: white;
    }
</style>
