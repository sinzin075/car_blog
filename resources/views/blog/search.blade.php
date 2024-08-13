<x-app-layout>
    <div class="search-container">
        <form action="{{ route('UserSearch') }}" method="GET" enctype="multipart/form-data" class="search-form">
            @csrf
            <input type="text" name="query" placeholder="ユーザー名を入力" class="search-input">
            <input type="submit" value="検索" class="search-button">
        </form>
    </div>
</x-app-layout>

<style>
    .search-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; /* 画面の高さいっぱいに配置 */
    }

    .search-form {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #f0f0f0; /* 背景色をライトグレーに設定 */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* 軽いシャドウを追加 */
    }

    .search-input {
        width: 300px;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 1rem;
    }

    .search-button {
        width: 100px;
        padding: 10px;
        border-radius: 5px;
        border: none;
        background-color: #555555;
        color: white;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .search-button:hover {
        background-color: #666666;
    }
</style>
