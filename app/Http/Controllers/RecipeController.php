<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::where(function ($query) {
                $query->where('status', 'approved')
                    ->orWhere('user_id', Auth::id());
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'instructions' => ['nullable', 'string'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = Auth::user()->role === 'admin' ? 'approved' : 'pending';

        Recipe::create($validated);

        return redirect()
            ->route('recipes.index')
            ->with('success', 'Przepis został dodany.');
    }

    public function show(Recipe $recipe)
    {
        if ($recipe->status !== 'approved' && $recipe->user_id !== Auth::id()) {
            abort(403);
        }

        $recipe->load('items.product');

        $products = Product::query()
            ->where('status', 'approved')
            ->orWhere('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('recipes.show', compact('recipe', 'products'));
    }

    public function edit(Recipe $recipe)
    {
        if ($recipe->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        if ($recipe->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'instructions' => ['nullable', 'string'],
        ]);

        $recipe->update($validated);

        return redirect()
            ->route('recipes.index')
            ->with('success', 'Przepis został zaktualizowany.');
    }

    public function destroy(Recipe $recipe)
    {
        if ($recipe->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $recipe->delete();

        return redirect()
            ->route('recipes.index')
            ->with('success', 'Przepis został usunięty.');
    }
}