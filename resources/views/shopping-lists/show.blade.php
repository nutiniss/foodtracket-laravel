<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista zakupów
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
                <h3 class="text-lg font-semibold">
                    {{ $shoppingList->name ?? 'Lista zakupów' }}
                </h3>

                <p class="text-gray-600">
                    Zakres:
                    {{ $shoppingList->start_date->format('Y-m-d') }}
                    -
                    {{ $shoppingList->end_date->format('Y-m-d') }}
                </p>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3">Kupione</th>
                            <th class="p-3">Produkt</th>
                            <th class="p-3">Ilość</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($shoppingList->items as $item)
                            <tr class="border-t">
                                <td class="p-3">
                                    <form method="POST" action="{{ route('shopping-list-items.toggle', $item) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button class="text-sm {{ $item->is_bought ? 'text-green-600' : 'text-gray-600' }}">
                                            {{ $item->is_bought ? '✓' : '○' }}
                                        </button>
                                    </form>
                                </td>

                                <td class="p-3 {{ $item->is_bought ? 'line-through text-gray-500' : '' }}">
                                    {{ $item->product->name }}
                                </td>

                                <td class="p-3">
                                    {{ number_format($item->grams, 2) }} g
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-3">
                                    Brak produktów na liście. Sprawdź, czy w wybranym zakresie istnieją zaplanowane posiłki z produktami.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-6">
                    <a href="{{ route('shopping-lists.index') }}" class="text-blue-600">
                        Wróć do list
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>