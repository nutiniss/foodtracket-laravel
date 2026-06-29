<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dodaj posiłek do planu
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('meal-planner.store') }}" class="bg-white p-6 shadow-sm sm:rounded-lg">
                @csrf

                <div>
                    <label class="block font-medium text-sm text-gray-700">Data posiłku</label>
                    <input
                        type="date"
                        name="meal_date"
                        value="{{ old('meal_date', $date) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    >

                    @error('meal_date')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700">Typ posiłku</label>
                    <select name="meal_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Wybierz typ</option>
                        <option value="Śniadanie" @selected(old('meal_type') === 'Śniadanie')>Śniadanie</option>
                        <option value="Drugie śniadanie" @selected(old('meal_type') === 'Drugie śniadanie')>Drugie śniadanie</option>
                        <option value="Obiad" @selected(old('meal_type') === 'Obiad')>Obiad</option>
                        <option value="Kolacja" @selected(old('meal_type') === 'Kolacja')>Kolacja</option>
                        <option value="Przekąska" @selected(old('meal_type') === 'Przekąska')>Przekąska</option>
                    </select>

                    @error('meal_type')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700">Nazwa, opcjonalnie</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="np. Owsianka z owocami"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    >

                    @error('name')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-6">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded">
                        Zapisz i dodaj produkty
                    </button>

                    <a href="{{ route('meal-planner.index') }}" class="ml-2 text-gray-600">
                        Anuluj
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>