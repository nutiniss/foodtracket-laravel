<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private function ensureAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $pendingProducts = Product::where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        $pendingRecipes = Recipe::where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.index', compact('pendingProducts', 'pendingRecipes'));
    }

    public function approveProduct(Product $product)
    {
        $this->ensureAdmin();

        $product->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->route('admin.index')
            ->with('success', 'Produkt został zatwierdzony.');
    }

    public function rejectProduct(Product $product)
    {
        $this->ensureAdmin();

        $product->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->route('admin.index')
            ->with('success', 'Produkt został odrzucony.');
    }

    public function approveRecipe(Recipe $recipe)
    {
        $this->ensureAdmin();

        $recipe->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->route('admin.index')
            ->with('success', 'Przepis został zatwierdzony.');
    }

    public function rejectRecipe(Recipe $recipe)
    {
        $this->ensureAdmin();

        $recipe->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->route('admin.index')
            ->with('success', 'Przepis został odrzucony.');
    }

    public function users()
    {
        $this->ensureAdmin();

        $users = User::orderBy('name')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'role' => ['required', 'in:user,admin'],
        ]);

        if ($user->id === Auth::id() && $validated['role'] !== 'admin') {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Nie możesz odebrać roli administratora samemu sobie.');
        }

        $user->role = $validated['role'];
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Rola użytkownika została zmieniona.');
    }
}