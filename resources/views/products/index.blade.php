<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Produkty
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex justify-between">
                <form method="GET" action="{{ route('products.index') }}" class="flex gap-2">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Szukaj produktu..."
                        class="border-gray-300 rounded-md shadow-sm"
                    >

                    <button class="px-4 py-2 bg-gray-800 text-white rounded">
                        Szukaj
                    </button>
                </form>

                <a href="{{ route('products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                    Dodaj produkt
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3">Nazwa</th>
                            <th class="p-3">kcal / 100g</th>
                            <th class="p-3">Białko</th>
                            <th class="p-3">Tłuszcz</th>
                            <th class="p-3">Węglowodany</th>
                            <th class="p-3">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr class="border-t">
                                <td class="p-3">{{ $product->name }}</td>
                                <td class="p-3">{{ $product->calories_per_100g }}</td>
                                <td class="p-3">{{ $product->protein_per_100g }}</td>
                                <td class="p-3">{{ $product->fat_per_100g }}</td>
                                <td class="p-3">{{ $product->carbs_per_100g }}</td>
                                <td class="p-3 flex gap-2">
                                    <a href="{{ route('products.show', $product) }}" class="text-blue-600">
                                        Szczegóły
                                    </a>

                                    @if ($product->user_id === auth()->id() || auth()->user()->role === 'admin')
                                        <a href="{{ route('products.edit', $product) }}" class="text-yellow-600">
                                            Edytuj
                                        </a>

                                        <form method="POST" action="{{ route('products.destroy', $product) }}">
                                            @csrf
                                            @method('DELETE')

                                            <button class="text-red-600" onclick="return confirm('Usunąć produkt?')">
                                                Usuń
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-3">
                                    Brak produktów.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>