<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Szczegóły posiłku
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <p><strong>Data:</strong> {{ $meal->meal_date }}</p>
                <p><strong>Typ:</strong> {{ $meal->meal_type }}</p>
                <p><strong>Nazwa:</strong> {{ $meal->name ?? '-' }}</p>
                <p>
                    <strong>Źródło:</strong>
                    @if ($meal->is_planned)
                        Z planu
                    @else
                        Spoza planu
                    @endif
                </p>

                <p>
                    <strong>Status:</strong>
                    @if ($meal->is_eaten)
                        Zjedzony
                    @else
                        Zaplanowany, jeszcze niezjedzony
                    @endif
                </p>

                @if ($meal->is_planned)
                    <div class="mt-4">
                        @if (! $meal->is_eaten)
                            <form method="POST" action="{{ route('meal-planner.eaten', $meal) }}">
                                @csrf
                                @method('PATCH')

                                <button class="px-4 py-2 bg-green-600 text-white rounded">
                                    Oznacz jako zjedzony
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('meal-planner.uneaten', $meal) }}">
                                @csrf
                                @method('PATCH')

                                <button class="px-4 py-2 bg-yellow-600 text-white rounded">
                                    Cofnij oznaczenie jako zjedzony
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">Dodaj produkt do posiłku</h3>

                <form method="POST" action="{{ route('meal-items.store', $meal) }}">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Produkt</label>
                        <select name="product_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Wybierz produkt</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('product_id')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium text-sm text-gray-700">Ilość w gramach</label>
                        <input
                            type="number"
                            step="0.01"
                            name="grams"
                            value="{{ old('grams') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        >

                        @error('grams')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <button class="px-4 py-2 bg-blue-600 text-white rounded">
                            Dodaj produkt
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Produkty w posiłku</h3>

                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3">Produkt</th>
                            <th class="p-3">Gramy</th>
                            <th class="p-3">Kalorie</th>
                            <th class="p-3">Białko</th>
                            <th class="p-3">Tłuszcz</th>
                            <th class="p-3">Węglowodany</th>
                            <th class="p-3">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($meal->items as $item)
                            <tr class="border-t">
                                <td class="p-3">{{ $item->product->name }}</td>
                                <td class="p-3">{{ $item->grams }} g</td>
                                <td class="p-3">{{ number_format($item->calories, 2) }}</td>
                                <td class="p-3">{{ number_format($item->protein, 2) }}</td>
                                <td class="p-3">{{ number_format($item->fat, 2) }}</td>
                                <td class="p-3">{{ number_format($item->carbs, 2) }}</td>
                                <td class="p-3">
                                    <form method="POST" action="{{ route('meal-items.destroy', $item) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button class="text-red-600" onclick="return confirm('Usunąć produkt z posiłku?')">
                                            Usuń
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-3">
                                    Brak produktów w tym posiłku.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-6 p-4 bg-gray-100 rounded">
                    <p><strong>Suma kalorii:</strong> {{ number_format($meal->items->sum('calories'), 2) }} kcal</p>
                    <p><strong>Białko:</strong> {{ number_format($meal->items->sum('protein'), 2) }} g</p>
                    <p><strong>Tłuszcz:</strong> {{ number_format($meal->items->sum('fat'), 2) }} g</p>
                    <p><strong>Węglowodany:</strong> {{ number_format($meal->items->sum('carbs'), 2) }} g</p>
                </div>

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('meals.edit', $meal) }}" class="text-yellow-600">
                        Edytuj posiłek
                    </a>

                    <a href="{{ route('meals.index') }}" class="text-blue-600">
                        Wróć do listy
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>