<?php

namespace App\Http\Controllers;

use App\Models\MealItem;
use App\Models\ShoppingList;
use App\Models\ShoppingListItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingListController extends Controller
{
    public function index()
    {
        $shoppingLists = ShoppingList::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('shopping-lists.index', compact('shoppingLists'));
    }

    public function create()
    {
        return view('shopping-lists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        $shoppingList = ShoppingList::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        $items = MealItem::with('meal', 'product')
            ->whereHas('meal', function ($query) use ($validated) {
                $query->where('user_id', Auth::id())
                    ->where('is_planned', true)
                    ->whereBetween('meal_date', [
                        $validated['start_date'],
                        $validated['end_date'],
                    ]);
            })
            ->get()
            ->groupBy('product_id');

        foreach ($items as $productId => $mealItems) {
            ShoppingListItem::create([
                'shopping_list_id' => $shoppingList->id,
                'product_id' => $productId,
                'grams' => $mealItems->sum('grams'),
                'is_bought' => false,
            ]);
        }

        return redirect()
            ->route('shopping-lists.show', $shoppingList)
            ->with('success', 'Lista zakupów została wygenerowana.');
    }

    public function show(ShoppingList $shoppingList)
    {
        if ($shoppingList->user_id !== Auth::id()) {
            abort(403);
        }

        $shoppingList->load('items.product');

        return view('shopping-lists.show', compact('shoppingList'));
    }

    public function destroy(ShoppingList $shoppingList)
    {
        if ($shoppingList->user_id !== Auth::id()) {
            abort(403);
        }

        $shoppingList->delete();

        return redirect()
            ->route('shopping-lists.index')
            ->with('success', 'Lista zakupów została usunięta.');
    }
}