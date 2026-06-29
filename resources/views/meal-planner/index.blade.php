<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Planer posiłków
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" action="{{ route('meal-planner.index') }}" class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <label class="block font-medium text-sm text-gray-700">Początek tygodnia</label>

                <div class="mt-2 flex gap-2">
                    <input
                        type="date"
                        name="start_date"
                        value="{{ $startDate->toDateString() }}"
                        class="border-gray-300 rounded-md shadow-sm"
                    >

                    <button class="px-4 py-2 bg-blue-600 text-white rounded">
                        Pokaż
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach ($days as $day)
                    @php
                        $dateKey = $day->toDateString();
                        $mealsForDay = $plannedMeals->get($dateKey, collect());
                    @endphp

                    <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">
                                    {{ $day->format('Y-m-d') }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    {{ $day->translatedFormat('l') }}
                                </p>
                            </div>

                            <a
                                href="{{ route('meal-planner.create', ['date' => $dateKey]) }}"
                                class="px-3 py-2 bg-blue-600 text-white rounded text-sm"
                            >
                                Dodaj
                            </a>
                        </div>

                        @forelse ($mealsForDay as $meal)
                            <div class="border-t py-3">
                                <div class="flex justify-between gap-2">
                                    <div>
                                        <p class="font-semibold">
                                            {{ $meal->meal_type }} - {{ $meal->name ?? 'Bez nazwy' }}
                                        </p>

                                        <p class="text-sm text-gray-600">
                                            {{ number_format($meal->items->sum('calories'), 2) }} kcal
                                        </p>

                                        @if ($meal->is_eaten)
                                            <span class="inline-block mt-1 px-2 py-1 bg-green-100 text-green-800 rounded text-xs">
                                                Zjedzony
                                            </span>
                                        @else
                                            <span class="inline-block mt-1 px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">
                                                Zaplanowany
                                            </span>
                                        @endif
                                    </div>

                                    <div class="text-right">
                                        <a href="{{ route('meals.show', $meal) }}" class="text-blue-600 text-sm">
                                            Szczegóły
                                        </a>
                                    </div>
                                </div>

                                <div class="mt-3 flex gap-2">
                                    @if (! $meal->is_eaten)
                                        <form method="POST" action="{{ route('meal-planner.eaten', $meal) }}">
                                            @csrf
                                            @method('PATCH')

                                            <button class="text-green-600 text-sm">
                                                Oznacz jako zjedzony
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('meal-planner.uneaten', $meal) }}">
                                            @csrf
                                            @method('PATCH')

                                            <button class="text-yellow-600 text-sm">
                                                Cofnij
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-600 text-sm">
                                Brak zaplanowanych posiłków.
                            </p>
                        @endforelse
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>