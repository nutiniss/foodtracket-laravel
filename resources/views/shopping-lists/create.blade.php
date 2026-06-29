<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Generuj listę zakupów
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('shopping-lists.store') }}" class="bg-white p-6 shadow-sm sm:rounded-lg">
                @csrf

                <div>
                    <label class="block font-medium text-sm text-gray-700">Nazwa listy, opcjonalnie</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="np. Zakupy na tydzień"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    >

                    @error('name')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700">Data od</label>
                    <input
                        type="date"
                        name="start_date"
                        value="{{ old('start_date', now()->toDateString()) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    >

                    @error('start_date')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700">Data do</label>
                    <input
                        type="date"
                        name="end_date"
                        value="{{ old('end_date', now()->addDays(6)->toDateString()) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    >

                    @error('end_date')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-6">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded">
                        Wygeneruj
                    </button>

                    <a href="{{ route('shopping-lists.index') }}" class="ml-2 text-gray-600">
                        Anuluj
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>