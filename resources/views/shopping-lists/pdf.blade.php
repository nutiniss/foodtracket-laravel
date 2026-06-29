<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Lista zakupów</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        h1 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .muted {
            color: #6b7280;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f3f4f6;
            text-align: left;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 8px;
        }

        .bought {
            text-decoration: line-through;
            color: #6b7280;
        }

        .footer {
            margin-top: 25px;
            font-size: 10px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <h1>{{ $shoppingList->name ?? 'Lista zakupów' }}</h1>

    <p class="muted">
        Zakres:
        {{ $shoppingList->start_date->format('Y-m-d') }}
        -
        {{ $shoppingList->end_date->format('Y-m-d') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Produkt</th>
                <th>Ilość</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($shoppingList->items as $item)
                <tr>
                    <td class="{{ $item->is_bought ? 'bought' : '' }}">
                        {{ $item->product->name }}
                    </td>

                    <td>
                        {{ number_format($item->grams, 2) }} g
                    </td>

                    <td>
                        {{ $item->is_bought ? 'Kupione' : 'Do kupienia' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        Brak produktów na liście.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer">
        Wygenerowano w aplikacji Foodtracker.
    </p>
</body>
</html>