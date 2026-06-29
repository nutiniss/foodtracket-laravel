<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Listy zakupów
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('shopping-lists.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                    Wygeneruj listę zakupów
                </a>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3">Nazwa</th>
                            <th class="p-3">Zakres</th>
                            <th class="p-3">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($shoppingLists as $list)
                            <tr class="border-t">
                                <td class="p-3">{{ $list->name ?? 'Lista zakupów' }}</td>
                                <td class="p-3">{{ $list->start_date->format('Y-m-d') }} - {{ $list->end_date->format('Y-m-d') }}</td>
                                <td class="p-3 flex gap-2">
                                    <a href="{{ route('shopping-lists.show', $list) }}" class="text-blue-600">
                                        Szczegóły
                                    </a>

                                    <form method="POST" action="{{ route('shopping-lists.destroy', $list) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button class="text-red-600" onclick="return confirm('Usunąć listę zakupów?')">
                                            Usuń
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-3">
                                    Brak list zakupów.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $shoppingLists->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>