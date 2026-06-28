<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dodaj produkt
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('products.store') }}" class="bg-white p-6 shadow-sm sm:rounded-lg">
                @csrf

                @include('products.partials.form')

                <div class="mt-6">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded">
                        Zapisz
                    </button>

                    <a href="{{ route('products.index') }}" class="ml-2 text-gray-600">
                        Anuluj
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>