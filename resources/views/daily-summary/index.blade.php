<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Podsumowanie dnia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="GET" action="{{ route('daily-summary.index') }}" class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <label class="block font-medium text-sm text-gray-700">Wybierz datę</label>

                <div class="mt-2 flex gap-2">
                    <input
                        type="date"
                        name="date"
                        value="{{ $date }}"
                        class="border-gray-300 rounded-md shadow-sm"
                    >

                    <button class="px-4 py-2 bg-blue-600 text-white rounded">
                        Pokaż
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Kalorie</p>
                    <p class="text-2xl font-semibold">
                        {{ number_format($totalCalories, 2) }} kcal
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Białko</p>
                    <p class="text-2xl font-semibold">
                        {{ number_format($totalProtein, 2) }} g
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Tłuszcz</p>
                    <p class="text-2xl font-semibold">
                        {{ number_format($totalFat, 2) }} g
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Węglowodany</p>
                    <p class="text-2xl font-semibold">
                        {{ number_format($totalCarbs, 2) }} g
                    </p>
                </div>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">Realizacja celu kalorycznego</h3>

                @if ($dailyGoal)
                    <p class="mb-2">
                        Cel: {{ $dailyGoal }} kcal
                    </p>

                    <div class="w-full bg-gray-200 rounded h-4">
                        <div
                            class="bg-green-600 h-4 rounded"
                            style="width: {{ $goalPercent }}%"
                        ></div>
                    </div>

                    <p class="mt-2">
                        {{ number_format($goalPercent, 2) }}% celu
                    </p>
                @else
                    <p class="text-gray-600">
                        Nie ustawiono jeszcze dziennego celu kalorii w profilu użytkownika.
                    </p>
                @endif
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Posiłki z dnia {{ $date }}</h3>
                @if ($hasPlanForDate)
                    <p class="mb-4 text-sm text-gray-600">
                        Dla tego dnia istnieje plan posiłków. W podsumowaniu widoczne są tylko posiłki oznaczone jako zjedzone.
                    </p>
                @endif

                @forelse ($meals as $meal)
                    <div class="border-b py-4">
                        <div class="flex justify-between">
                            <div>
                                <h4 class="font-semibold">
                                    {{ $meal->meal_type }} - {{ $meal->name ?? 'Bez nazwy' }}
                                </h4>

                                <div class="flex gap-2 items-center mt-1">
                                    <p class="text-sm text-gray-500">
                                        {{ $meal->meal_date }}
                                    </p>

                                    @if ($meal->is_planned)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                            Z planu
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">
                                            Spoza planu
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <a href="{{ route('meals.show', $meal) }}" class="text-blue-600">
                                Szczegóły
                            </a>
                        </div>

                        <table class="w-full mt-3">
                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="p-2">Produkt</th>
                                    <th class="p-2">Gramy</th>
                                    <th class="p-2">Kalorie</th>
                                    <th class="p-2">Białko</th>
                                    <th class="p-2">Tłuszcz</th>
                                    <th class="p-2">Węglowodany</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($meal->items as $item)
                                    <tr class="border-t">
                                        <td class="p-2">{{ $item->product->name }}</td>
                                        <td class="p-2">{{ $item->grams }} g</td>
                                        <td class="p-2">{{ number_format($item->calories, 2) }}</td>
                                        <td class="p-2">{{ number_format($item->protein, 2) }}</td>
                                        <td class="p-2">{{ number_format($item->fat, 2) }}</td>
                                        <td class="p-2">{{ number_format($item->carbs, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-2 text-gray-500">
                                            Brak produktów w posiłku.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @empty
                    <p class="text-gray-600">
                        Brak posiłków dla wybranej daty.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>