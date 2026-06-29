<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailySummaryController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        $meals = Meal::with('items.product')
            ->where('user_id', Auth::id())
            ->whereDate('meal_date', $date)
            ->where('is_eaten', true)
            ->orderBy('meal_type')
            ->get();

        $hasPlanForDate = Meal::where('user_id', Auth::id())
            ->whereDate('meal_date', $date)
            ->where('is_planned', true)
            ->exists();

        $items = $meals->flatMap->items;

        $totalCalories = $items->sum('calories');
        $totalProtein = $items->sum('protein');
        $totalFat = $items->sum('fat');
        $totalCarbs = $items->sum('carbs');

        $dailyGoal = Auth::user()->daily_calorie_goal;
        $goalPercent = null;

        if ($dailyGoal && $dailyGoal > 0) {
            $goalPercent = min(100, ($totalCalories / $dailyGoal) * 100);
        }

        return view('daily-summary.index', compact(
            'date',
            'meals',
            'totalCalories',
            'totalProtein',
            'totalFat',
            'totalCarbs',
            'dailyGoal',
            'goalPercent',
            'hasPlanForDate'
        ));
    }
}