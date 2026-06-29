<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rejestr masy ciała
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
                <a href="{{ route('weight-entries.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                    Dodaj pomiar
                </a>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">Trend masy ciała</h3>

                @if ($chartEntries->count() >= 2)
                    <canvas id="weightChart" height="120"></canvas>
                @else
                    <p class="text-gray-600">
                        Dodaj przynajmniej dwa pomiary masy, aby zobaczyć wykres.
                    </p>
                @endif
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3">Data</th>
                            <th class="p-3">Masa</th>
                            <th class="p-3">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($weightEntries as $entry)
                            <tr class="border-t">
                                <td class="p-3">{{ $entry->entry_date }}</td>
                                <td class="p-3">{{ $entry->weight }} kg</td>
                                <td class="p-3 flex gap-2">
                                    <a href="{{ route('weight-entries.edit', $entry) }}" class="text-yellow-600">
                                        Edytuj
                                    </a>

                                    <form method="POST" action="{{ route('weight-entries.destroy', $entry) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button class="text-red-600" onclick="return confirm('Usunąć pomiar?')">
                                            Usuń
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-3">
                                    Brak pomiarów.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $weightEntries->links() }}
                </div>
            </div>
        </div>
    </div>
    @if ($chartEntries->count() >= 2)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const weightData = @json($chartEntries->map(fn ($entry) => [
                'x' => $entry->entry_date,
                'y' => (float) $entry->weight,
            ])->values());

            const targetWeight = @json($targetWeight);

            const datasets = [
                {
                    label: 'Masa ciała',
                    data: weightData,
                    backgroundColor: '#2563eb',
                    borderColor: '#2563eb',
                    showLine: true,
                    tension: 0.2
                }
            ];

            if (targetWeight) {
                datasets.push({
                    label: 'Cel masy',
                    data: weightData.map(point => ({
                        x: point.x,
                        y: Number(targetWeight)
                    })),
                    borderColor: '#16a34a',
                    backgroundColor: '#16a34a',
                    showLine: true,
                    pointRadius: 0,
                    borderDash: [6, 6]
                });
            }

            new Chart(document.getElementById('weightChart'), {
                type: 'scatter',
                data: {
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y + ' kg';
                                }
                            }
                        },
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        x: {
                            type: 'category',
                            title: {
                                display: true,
                                text: 'Data'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Masa ciała (kg)'
                            }
                        }
                    }
                }
            });
        </script>
    @endif
</x-app-layout>