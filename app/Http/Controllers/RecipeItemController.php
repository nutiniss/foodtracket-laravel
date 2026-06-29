<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\RecipeItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeItemController extends Controller
{
    public function store(Request $request, Recipe $recipe)
    {
        if ($recipe->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'grams' => ['required', 'numeric', 'min:0.01'],
        ]);

        $validated['recipe_id'] = $recipe->id;

        RecipeItem::create($validated);

        return redirect()
            ->route('recipes.show', $recipe)
            ->with('success', 'Składnik został dodany do przepisu.');
    }

    public function destroy(RecipeItem $recipeItem)
    {
        if ($recipeItem->recipe->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $recipe = $recipeItem->recipe;
        $recipeItem->delete();

        return redirect()
            ->route('recipes.show', $recipe)
            ->with('success', 'Składnik został usunięty z przepisu.');
    }
}