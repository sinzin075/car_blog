<x-app-layout>
    <x-slot name="header">
        Car Blog
    </x-slot>

    <div>
        @foreach($cars as $countryName => $makers)
            <h2>{{ $countryName }}</h2>
            @foreach($makers->groupBy('maker.name') as $makerName => $carsByMaker)
                <h3>{{ $makerName }}</h3>
                @foreach($carsByMaker as $car)
                    <div>
                        <p>{{ $car->name }}</p>
                        <img src="{{ $car->photo }}" alt="{{ $car->name }}">
                    </div>
                @endforeach
            @endforeach
        @endforeach
    </div>
</x-app-layout>