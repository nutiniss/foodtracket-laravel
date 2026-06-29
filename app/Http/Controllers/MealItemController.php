<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\MealItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MealItemController extends Controller
{
    public function store(Request $request, Meal $meal)
    {
        if ($meal->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'grams' => ['required', 'numeric', 'min:0.01'],
        ]);

        $validated['meal_id'] = $meal->id;

        MealItem::create($validated);

        return redirect()
            ->route('meals.show', $meal)
            ->with('success', 'Produkt został dodany do posiłku.');
    }

    public function destroy(MealItem $mealItem)
    {
        if ($mealItem->meal->user_id !== Auth::id()) {
            abort(403);
        }

        $meal = $mealItem->meal;
        $mealItem->delete();

        return redirect()
            ->route('meals.show', $meal)
            ->with('success', 'Produkt został usunięty z posiłku.');
    }

    public function update(Request $request, MealItem $mealItem)
    {
        if ($mealItem->meal->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'grams' => ['required', 'numeric', 'min:0.01'],
        ]);

        $mealItem->update($validated);

        return redirect()
            ->route('meals.show', $mealItem->meal)
            ->with('success', 'Gramatura produktu została zaktualizowana.');
    }
}