<div class="container mx-auto flex justify-center">
    <section class="bg-white p-6 rounded-lg shadow-md w-full md:w-3/5">
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
                    <div class="w-2/5 h-auto overflow-hidden">
                        <img src="{{ $user->photo }}" alt="Current Photo" class="car-image">
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
                    <li class="bg-gray-100 p-4 rounded-lg shadow-md w-1/3">
                        <p class="font-bold">愛車1</p>
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
                    <li class="bg-gray-100 p-4 rounded-lg shadow-md w-1/3">
                        <p class="font-bold">愛車2</p>
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
                    <li class="bg-gray-100 p-4 rounded-lg shadow-md w-1/3">
                        <p class="font-bold">愛車3</p>
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

            <div class="mt-4">
                <a href="{{ route('carChoice', ['userId' => Auth::id()]) }}" class="text-blue-500 hover:underline">愛車登録</a>
            </div>
        </div>
    </section>
</div>
