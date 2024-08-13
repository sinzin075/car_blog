<x-app-layout>
    <x-slot name="header">
        <div class="bg-car-dark-gray text-white p-4 fixed w-full z-10 text-center">
            Car Blog
        </div>
    </x-slot>

    <!-- 選択した車のデータを表示するエリア -->
    <div id="selected-cars" class="post mb-4 p-4 bg-car-dark-gray text-white rounded" style="width: 24%; left: 0.5%; top: 80px; position: fixed;">
        <h2 class="text-2xl font-bold mb-4">Selected Cars</h2>
        <ul id="selected-cars-list" class="flex flex-wrap gap-4 justify-between">
            @for ($i = 0; $i < 3; $i++)
                <li id="car-{{ $i+1 }}" class="selected-car hidden p-4 border rounded shadow car-card">
                    <p class="car-name font-semibold mb-2 text-center"></p>
                    <img class="car-photo car-image mt-2" src="" alt="">
                    <button type="button" class="cancel-button unfollow-button mt-4" data-index="{{ $i }}">Cancel</button>
                    <input type="hidden" class="car-id" value="">
                </li>
            @endfor
        </ul>
    </div>

    <!-- 車の一覧表示エリア -->
    <div class="post mx-auto mb-4 p-4 bg-car-dark-gray text-white rounded" style="width: 60%; margin-left: 25%;">
        @foreach($cars as $countryName => $makers)
            <h2 class="text-xl font-bold mt-6 mb-2">{{ $countryName }}</h2>
            @foreach($makers->groupBy('maker.name') as $makerName => $carsByMaker)
                <h3 class="text-lg font-semibold mt-4 mb-2">{{ $makerName }}</h3>
                <div class="flex flex-wrap -mx-1 lg:-mx-4 car-container">
                    @foreach($carsByMaker as $car)
                        <div class="car-item px-1 py-1 lg:px-4 lg:py-4 car-card" data-car-id="{{ $car->id }}" data-car-name="{{ $car->name }}" data-car-photo="{{ $car->photo }}">
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

    <!-- 選択した車のデータを送信するためのフォーム -->
    <form action="{{ route('carSave') }}" id="car-form" method="POST" class="mt-6 mb-4 p-4 bg-car-dark-gray text-white rounded" style="width: 18%; left: 0.5%; top: 400px; position: fixed;">
        @csrf
        <input type="hidden" name="car1_id" id="form-car-1-id" value="">
        <input type="hidden" name="car2_id" id="form-car-2-id" value="">
        <input type="hidden" name="car3_id" id="form-car-3-id" value="">
        <button type="submit" class="follow-button">Save as My Cars</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const carItems = document.querySelectorAll('.car-item');
            const selectedCars = document.querySelectorAll('.selected-car');
            const formCarIds = [
                document.getElementById('form-car-1-id'),
                document.getElementById('form-car-2-id'),
                document.getElementById('form-car-3-id')
            ];
            let selectedCarCount = 0;

            // 既存のデータを設定
            const existingCars = @json($selectedCars);
            existingCars.forEach((car, index) => {
                if (car && index < selectedCars.length) {
                    selectedCars[index].querySelector('.car-name').textContent = car.name;
                    selectedCars[index].querySelector('.car-photo').src = car.photo;
                    selectedCars[index].querySelector('.car-id').value = car.id;
                    selectedCars[index].classList.remove('hidden');
                    formCarIds[index].value = car.id;
                    selectedCarCount++;
                }
            });

            carItems.forEach(item => {
                item.addEventListener('click', function () {
                    if (selectedCarCount < 3) {
                        const carId = this.getAttribute('data-car-id');
                        const carName = this.getAttribute('data-car-name');
                        const carPhoto = this.getAttribute('data-car-photo');

                        for (let i = 0; i < selectedCars.length; i++) {
                            if (selectedCars[i].classList.contains('hidden')) {
                                if (i > 0 && selectedCars[i - 1].classList.contains('hidden')) {
                                    alert('Please select the previous car first.');
                                    return;
                                }
                                selectedCars[i].querySelector('.car-name').textContent = carName;
                                selectedCars[i].querySelector('.car-photo').src = carPhoto;
                                selectedCars[i].querySelector('.car-id').value = carId;
                                selectedCars[i].classList.remove('hidden');

                                formCarIds[i].value = carId;

                                selectedCarCount++;
                                break;
                            }
                        }
                    } else {
                        alert('You can only select up to 3 cars.');
                    }
                });
            });

            document.querySelectorAll('.cancel-button').forEach((button, index) => {
                button.addEventListener('click', function () {
                    const carIndex = parseInt(this.getAttribute('data-index'), 10);

                    if (!selectedCars[carIndex].classList.contains('hidden')) {
                        // Shift remaining cars
                        for (let i = carIndex; i < selectedCars.length - 1; i++) {
                            if (!selectedCars[i + 1].classList.contains('hidden')) {
                                selectedCars[i].querySelector('.car-name').textContent = selectedCars[i + 1].querySelector('.car-name').textContent;
                                selectedCars[i].querySelector('.car-photo').src = selectedCars[i + 1].querySelector('.car-photo').src;
                                selectedCars[i].querySelector('.car-id').value = selectedCars[i + 1].querySelector('.car-id').value;
                                formCarIds[i].value = formCarIds[i + 1].value;
                            } else {
                                selectedCars[i].classList.add('hidden');
                                selectedCars[i].querySelector('.car-name').textContent = '';
                                selectedCars[i].querySelector('.car-photo').src = '';
                                selectedCars[i].querySelector('.car-id').value = '';
                                formCarIds[i].value = '';
                                break;
                            }
                        }

                        // Clear the last car
                        const lastIndex = selectedCars.length - 1;
                        selectedCars[lastIndex].classList.add('hidden');
                        selectedCars[lastIndex].querySelector('.car-name').textContent = '';
                        selectedCars[lastIndex].querySelector('.car-photo').src = '';
                        selectedCars[lastIndex].querySelector('.car-id').value = '';
                        formCarIds[lastIndex].value = '';

                        selectedCarCount--;
                    }
                });
            });
        });
    </script>

    <style>
        .bg-car-light-gray {
            background-color: #e0e0e0;
        }

        .bg-car-dark-gray {
            background-color: #333333;
        }

        .user-container {
            position: relative;
            display: inline-block;
            border-radius: 8px;
            overflow: hidden;
            background-color: #555555;
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
        }

        .user-name {
            color: #ffffff;
            font-size: 1.2rem;
            font-weight: 700;
            line-height: 1.5;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            z-index: 20;
            margin-left: 0.5rem;
        }

        .post {
            margin-bottom: 20px;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
        }

        .user-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .user-profile-image {
            width: 35%;
            height: auto;
            display: block;
            object-fit: cover;
            clip-path: inset(15% 0 15% 0);
        }

        .common-image {
            width: 60%;
            height: auto;
            display: block;
            margin: 0 auto;
            object-fit: cover;
        }

        .btn-new-post {
            display: inline-block;
            padding: 10px 20px;
            background-color: #D7263D;
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
        }

        .btn-action {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333333;
            color: #ffffff;
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
        }

        .count-display {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333333;
            color: #ffffff;
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
            margin: 5px 1%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        .car-image {
            width: 100%;
            height: 150px;
            border-radius: 10px;
            object-fit: cover;
        }

        .car-card p,
        .car-card span {
            color: #333333;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }

        .no_comments {
            color: #999999;
            font-style: italic;
            text-align: center;
            margin-top: 10px;
        }

        .comment-divider {
            margin: 15px 0;
            border-top: 1px solid #cccccc;
        }

        .follow-button {
            display: inline-block;
            padding: 8px 16px;
            background-color: #1DA1F2;
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
        }

        .unfollow-button {
            display: inline-block;
            padding: 4px 8px; /* 小さめのパディング */
            font-size: 0.8rem; /* ボタンの文字サイズを小さく */
            background-color: #ff4444;
            color: #ffffff;
            font-weight: bold;
            border-radius: 3px; /* 角を少し丸める */
            text-align: center;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
            cursor: pointer;
            border: none;
            margin: 5px 0;
        }

        .unfollow-button:hover {
            background-color: #cc3333;
        }

        /* 車の表示エリア全体のサイズを小さくする */
        .selected-car {
            padding: 8px; /* 内側のパディングを小さく */
            font-size: 0.9rem; /* 全体のフォントサイズを少し小さく */
            width: 80px; /* カードの幅を小さく */
            height: 120px; /* カードの高さを小さく */
        }

        .selected-car .car-image {
            width: 60px; /* 画像の幅を小さく */
            height: 50px; /* 画像の高さを小さく */
        }

        .selected-car .car-name {
            font-size: 0.8rem; /* 車名のフォントサイズを小さく */
            margin-top: 5px; /* 車名と画像の間隔を狭く */
        }
    </style>
</x-app-layout>
