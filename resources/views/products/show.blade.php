<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Szczegóły produktu
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-xl font-semibold mb-4">
                    {{ $product->name }}
                </h3>

                <p>Kalorie / 100g: {{ $product->calories_per_100g }}</p>
                <p>Białko / 100g: {{ $product->protein_per_100g }}</p>
                <p>Tłuszcz / 100g: {{ $product->fat_per_100g }}</p>
                <p>Węglowodany / 100g: {{ $product->carbs_per_100g }}</p>
                <p>Status: {{ $product->status }}</p>

                <div class="mt-6">
                    <a href="{{ route('products.index') }}" class="text-blue-600">
                        Wróć do listy
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>