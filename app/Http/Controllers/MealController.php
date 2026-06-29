<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class MealController extends Controller
{
    public function index()
    {
        $meals = Meal::where('user_id', Auth::id())
            ->orderByDesc('meal_date')
            ->paginate(10);

        return view('meals.index', compact('meals'));
    }

    public function create()
    {
        return view('meals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'meal_date' => ['required', 'date'],
            'meal_type' => ['required', 'string', 'max:50'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_planned'] = false;
        $validated['is_eaten'] = true;
        $validated['eaten_at'] = now();

        $meal = Meal::create($validated);

        return redirect()
            ->route('meals.show', $meal)
            ->with('success', 'Posiłek został dodany. Możesz teraz dodać produkty.');
    }

    public function show(Meal $meal)
    {
        if ($meal->user_id !== Auth::id()) {
            abort(403);
        }

        $meal->load('items.product');

        $products = Product::query()
            ->where('status', 'approved')
            ->orWhere('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('meals.show', compact('meal', 'products'));
    }

    public function edit(Meal $meal)
    {
        if ($meal->user_id !== Auth::id()) {
            abort(403);
        }

        return view('meals.edit', compact('meal'));
    }

    public function update(Request $request, Meal $meal)
    {
        if ($meal->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'meal_date' => ['required', 'date'],
            'meal_type' => ['required', 'string', 'max:50'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        $meal->update($validated);

        return redirect()
            ->route('meals.index')
            ->with('success', 'Posiłek został zaktualizowany.');
    }

    public function destroy(Meal $meal)
    {
        if ($meal->user_id !== Auth::id()) {
            abort(403);
        }

        $meal->delete();

        return redirect()
            ->route('meals.index')
            ->with('success', 'Posiłek został usunięty.');
    }
}