<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MealPlannerController extends Controller
{
    public function index(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date', now()->toDateString()))->startOfDay();

        $days = collect(range(0, 6))->map(function ($offset) use ($startDate) {
            return $startDate->copy()->addDays($offset);
        });

        $plannedMeals = Meal::with('items.product')
            ->where('user_id', Auth::id())
            ->where('is_planned', true)
            ->whereBetween('meal_date', [
                $days->first()->toDateString(),
                $days->last()->toDateString(),
            ])
            ->orderBy('meal_date')
            ->orderBy('meal_type')
            ->get()
            ->groupBy(function ($meal) {
                return $meal->meal_date->toDateString();
            });

        return view('meal-planner.index', compact('days', 'plannedMeals', 'startDate'));
    }

    public function create(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        return view('meal-planner.create', compact('date'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'meal_date' => ['required', 'date'],
            'meal_type' => ['required', 'string', 'max:50'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_planned'] = true;
        $validated['is_eaten'] = false;
        $validated['eaten_at'] = null;

        $meal = Meal::create($validated);

        return redirect()
            ->route('meals.show', $meal)
            ->with('success', 'Posiłek został dodany do planu. Możesz teraz dodać produkty.');
    }

    public function markAsEaten(Meal $meal)
    {
        if ($meal->user_id !== Auth::id()) {
            abort(403);
        }

        $meal->update([
            'is_eaten' => true,
            'eaten_at' => now(),
        ]);

        return back()->with('success', 'Posiłek został oznaczony jako zjedzony.');
    }

    public function markAsUneaten(Meal $meal)
    {
        if ($meal->user_id !== Auth::id()) {
            abort(403);
        }

        $meal->update([
            'is_eaten' => false,
            'eaten_at' => null,
        ]);

        return back()->with('success', 'Cofnięto oznaczenie posiłku jako zjedzonego.');
    }
}