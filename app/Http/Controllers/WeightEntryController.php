<?php

namespace App\Http\Controllers;

use App\Models\WeightEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeightEntryController extends Controller
{
    public function index()
    {
        $weightEntries = WeightEntry::where('user_id', Auth::id())
            ->orderByDesc('entry_date')
            ->paginate(10);

        return view('weight-entries.index', compact('weightEntries'));
    }

    public function create()
    {
        return view('weight-entries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'entry_date' => ['required', 'date'],
            'weight' => ['required', 'numeric', 'min:1', 'max:500'],
        ]);

        $validated['user_id'] = Auth::id();

        WeightEntry::create($validated);

        return redirect()
            ->route('weight-entries.index')
            ->with('success', 'Pomiar masy został dodany.');
    }

    public function edit(WeightEntry $weightEntry)
    {
        if ($weightEntry->user_id !== Auth::id()) {
            abort(403);
        }

        return view('weight-entries.edit', compact('weightEntry'));
    }

    public function update(Request $request, WeightEntry $weightEntry)
    {
        if ($weightEntry->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'entry_date' => ['required', 'date'],
            'weight' => ['required', 'numeric', 'min:1', 'max:500'],
        ]);

        $weightEntry->update($validated);

        return redirect()
            ->route('weight-entries.index')
            ->with('success', 'Pomiar masy został zaktualizowany.');
    }

    public function destroy(WeightEntry $weightEntry)
    {
        if ($weightEntry->user_id !== Auth::id()) {
            abort(403);
        }

        $weightEntry->delete();

        return redirect()
            ->route('weight-entries.index')
            ->with('success', 'Pomiar masy został usunięty.');
    }
}