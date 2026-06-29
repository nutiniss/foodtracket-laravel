<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Posiłki
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('meals.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                    Dodaj posiłek
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3">Data</th>
                            <th class="p-3">Typ</th>
                            <th class="p-3">Nazwa</th>
                            <th class="p-3">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($meals as $meal)
                            <tr class="border-t">
                                <td class="p-3">{{ $meal->meal_date }}</td>
                                <td class="p-3">{{ $meal->meal_type }}</td>
                                <td class="p-3">{{ $meal->name ?? '-' }}</td>
                                <td class="p-3 flex gap-2">
                                    <a href="{{ route('meals.show', $meal) }}" class="text-blue-600">
                                        Szczegóły
                                    </a>

                                    <a href="{{ route('meals.edit', $meal) }}" class="text-yellow-600">
                                        Edytuj
                                    </a>

                                    <form method="POST" action="{{ route('meals.destroy', $meal) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button class="text-red-600" onclick="return confirm('Usunąć posiłek?')">
                                            Usuń
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-3">
                                    Brak posiłków.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $meals->links() }}
            </div>
        </div>
    </div>
</x-app-layout>