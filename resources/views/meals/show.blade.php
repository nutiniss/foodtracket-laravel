<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Szczegóły posiłku
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <p><strong>Data:</strong> {{ $meal->meal_date }}</p>
                <p><strong>Typ:</strong> {{ $meal->meal_type }}</p>
                <p><strong>Nazwa:</strong> {{ $meal->name ?? '-' }}</p>

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('meals.edit', $meal) }}" class="text-yellow-600">
                        Edytuj
                    </a>

                    <a href="{{ route('meals.index') }}" class="text-blue-600">
                        Wróć do listy
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>