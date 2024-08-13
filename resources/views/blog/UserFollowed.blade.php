<x-app-layout>
    <div class="content-container">
        <div class="fixed-header">
            <a href="{{ route('status', ['userId' => $user->id]) }}" class="back-link">ユーザー情報に戻る</a>
            <ul class="fixed-menu">
                <li>
                    <a href="{{ route('UserFollowed', ['userId' => $user->id]) }}">フォロー</a>
                </li>
                <li>
                    <a href="{{ route('UserFollower', ['userId' => $user->id]) }}">フォロワー</a>
                </li>
            </ul>
        </div>

        <div class="followed-list">
            @foreach ($followeds as $followed)
                <a href="{{ route('status', ['userId' => $followed->followed->id]) }}">
                    <div class="follower-card">
                        <span>{{ $followed->followed->name }}</span>
                        <img src="{{ $followed->followed->photo }}" alt="{{ $followed->followed->name }}" class="follower-icon">
                        <!-- 他のfollower情報をここで表示 -->
                    </div>
                </a>
            @endforeach

            @if ($followeds->isEmpty())
                <p>フォローしている人がいません</p>
            @endif
        </div>
    </div>
</x-app-layout>

<style>
    .content-container {
        padding-top: 20px; /* 固定メニューのスペース */
        width: 60%;
        margin: 0 auto;
    }

    .fixed-header {
        position: fixed;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        background-color: #f0f0f0;
        width: 200px; /* 固定メニューの幅 */
        padding: 10px;
        border-radius: 0 10px 10px 0;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .back-link {
        display: block;
        margin-bottom: 10px;
        font-size: 1rem;
        text-decoration: none;
        color: #555555;
    }

    .fixed-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .fixed-menu li {
        margin-bottom: 10px;
    }

    .fixed-menu li a {
        text-decoration: none;
        color: #555555;
        padding: 10px;
        border-radius: 5px;
        background-color: #e0e0e0;
        display: block;
        transition: background-color 0.3s ease;
    }

    .fixed-menu li a:hover {
        background-color: #d0d0d0;
    }

    .followed-list {
        margin-top: 20px;
    }

    .follower-card {
        display: flex;
        align-items: center;
        background-color: #f0f0f0;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .follower-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 20px;
    }
</style>

<script>
    // スクロールしても固定メニューが画面左端の中央に表示され続けるようにするスクリプト
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.fixed-header');
        const offset = window.pageYOffset || document.documentElement.scrollTop;

        if (offset > 0) {
            header.style.boxShadow = '0px 0px 10px rgba(0, 0, 0, 0.2)';
        } else {
            header.style.boxShadow = '0px 0px 10px rgba(0, 0, 0, 0.1)';
        }
    });
</script>
