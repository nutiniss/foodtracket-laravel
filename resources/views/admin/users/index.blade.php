<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Zarządzanie użytkownikami
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('admin.index') }}" class="text-blue-600">
                    Wróć do panelu administratora
                </a>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3">Nazwa</th>
                            <th class="p-3">E-mail</th>
                            <th class="p-3">Aktualna rola</th>
                            <th class="p-3">Zmień rolę</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)
                            <tr class="border-t">
                                <td class="p-3">
                                    {{ $user->name }}

                                    @if ($user->id === auth()->id())
                                        <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                            Ty
                                        </span>
                                    @endif
                                </td>

                                <td class="p-3">
                                    {{ $user->email }}
                                </td>

                                <td class="p-3">
                                    @if ($user->role === 'admin')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">
                                            Administrator
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">
                                            Użytkownik
                                        </span>
                                    @endif
                                </td>

                                <td class="p-3">
                                    <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="flex gap-2 items-center">
                                        @csrf
                                        @method('PATCH')

                                        <select
                                            name="role"
                                            class="border-gray-300 rounded-md shadow-sm text-sm"
                                            @disabled($user->id === auth()->id())
                                        >
                                            <option value="user" @selected($user->role === 'user')>
                                                Użytkownik
                                            </option>

                                            <option value="admin" @selected($user->role === 'admin')>
                                                Administrator
                                            </option>
                                        </select>

                                        <button
                                            class="px-3 py-2 bg-blue-600 text-white rounded text-sm"
                                            @disabled($user->id === auth()->id())
                                        >
                                            Zapisz
                                        </button>
                                    </form>

                                    @if ($user->id === auth()->id())
                                        <p class="text-xs text-gray-500 mt-1">
                                            Nie możesz zmienić własnej roli.
                                        </p>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-3">
                                    Brak użytkowników.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>