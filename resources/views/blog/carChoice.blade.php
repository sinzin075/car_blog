<x-app-layout>
    <x-slot name="header">
        Car Blog
    </x-slot>

    <!-- 選択した車のデータを表示するエリア -->
    <div id="selected-cars" class="mb-4">
        <h2 class="text-2xl font-bold mb-4">Selected Cars</h2>
        <ul id="selected-cars-list" class="flex flex-wrap gap-4">
            @for ($i = 0; $i < 3; $i++)
                <li id="car-{{ $i+1 }}" class="selected-car hidden p-4 border rounded shadow">
                    <p class="car-name font-semibold mb-2"></p>
                    <img class="car-photo w-full h-32 object-cover mb-2" src="" alt="">
                    <button type="button" class="cancel-button bg-red-500 text-white px-2 py-1 rounded">Cancel</button>
                    <input type="hidden" class="car-id" value="">
                </li>
            @endfor
        </ul>
    </div>

    <!-- 車の一覧表示エリア -->
    <div>
        @foreach($cars as $countryName => $makers)
            <h2 class="text-xl font-bold mt-6 mb-2">{{ $countryName }}</h2>
            @foreach($makers->groupBy('maker.name') as $makerName => $carsByMaker)
                <h3 class="text-lg font-semibold mt-4 mb-2">{{ $makerName }}</h3>
                <div class="flex flex-wrap -mx-1 lg:-mx-4">
                    @foreach($carsByMaker as $car)
                        <div class="car-item w-1/5 px-1 py-1 lg:px-4 lg:py-4" data-car-id="{{ $car->id }}" data-car-name="{{ $car->name }}" data-car-photo="{{ $car->photo }}">
                            <div class="car-photo-container h-32 overflow-hidden">
                                <img class="w-full h-full object-cover" src="{{ $car->photo }}" alt="{{ $car->name }}">
                            </div>
                            <p class="text-center font-semibold mt-2">{{ $car->name }}</p>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endforeach
    </div>

    <!-- 選択した車のデータを送信するためのフォーム -->
    <form action="{{ route('carSave') }}" id="car-form" method="POST" class="mt-6">
        @csrf
        <input type="hidden" name="car1_id" id="form-car-1-id" value="">
        <input type="hidden" name="car2_id" id="form-car-2-id" value="">
        <input type="hidden" name="car3_id" id="form-car-3-id" value="">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save as My Cars</button>
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
                    for (let i = selectedCars.length - 1; i >= 0; i--) {
                        if (!selectedCars[i].classList.contains('hidden')) {
                            selectedCars[i].classList.add('hidden');
                            selectedCars[i].querySelector('.car-id').value = '';
                            formCarIds[i].value = '';
                            selectedCarCount--;
                            break;
                        }
                    }
                });
            });

            window.addEventListener('scroll', function() {
                document.getElementById('selected-cars').style.top = `${window.scrollY}px`;
            });

            document.getElementById('car-form').addEventListener('submit', function() {
                this.submit();
            });
        });
    </script>
</x-app-layout>
