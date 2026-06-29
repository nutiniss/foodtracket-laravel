<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel administratora
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">Produkty oczekujące na akceptację</h3>

                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3">Nazwa</th>
                            <th class="p-3">Kalorie</th>
                            <th class="p-3">Białko</th>
                            <th class="p-3">Tłuszcz</th>
                            <th class="p-3">Węglowodany</th>
                            <th class="p-3">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendingProducts as $product)
                            <tr class="border-t">
                                <td class="p-3">{{ $product->name }}</td>
                                <td class="p-3">{{ $product->calories_per_100g }}</td>
                                <td class="p-3">{{ $product->protein_per_100g }}</td>
                                <td class="p-3">{{ $product->fat_per_100g }}</td>
                                <td class="p-3">{{ $product->carbs_per_100g }}</td>
                                <td class="p-3 flex gap-2">
                                    <form method="POST" action="{{ route('admin.products.approve', $product) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-green-600">
                                            Zatwierdź
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.products.reject', $product) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-red-600">
                                            Odrzuć
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-3">
                                    Brak produktów oczekujących.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Przepisy oczekujące na akceptację</h3>

                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3">Tytuł</th>
                            <th class="p-3">Opis</th>
                            <th class="p-3">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendingRecipes as $recipe)
                            <tr class="border-t">
                                <td class="p-3">{{ $recipe->title }}</td>
                                <td class="p-3">{{ $recipe->description }}</td>
                                <td class="p-3 flex gap-2">
                                    <form method="POST" action="{{ route('admin.recipes.approve', $recipe) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-green-600">
                                            Zatwierdź
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.recipes.reject', $recipe) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-red-600">
                                            Odrzuć
                                        </button>
                                    </form>

                                    <a href="{{ route('recipes.show', $recipe) }}" class="text-blue-600">
                                        Szczegóły
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-3">
                                    Brak przepisów oczekujących.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>