<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::query()
            ->where(function ($query) {
                $query->where('status', 'approved')
                    ->orWhere('user_id', auth()->id());
            })
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->paginate(10);

        return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'calories_per_100g' => ['required', 'numeric', 'min:0'],
            'protein_per_100g' => ['required', 'numeric', 'min:0'],
            'fat_per_100g' => ['required', 'numeric', 'min:0'],
            'carbs_per_100g' => ['required', 'numeric', 'min:0'],
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'approved';

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produkt został dodany.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        if ($product->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'calories_per_100g' => ['required', 'numeric', 'min:0'],
            'protein_per_100g' => ['required', 'numeric', 'min:0'],
            'fat_per_100g' => ['required', 'numeric', 'min:0'],
            'carbs_per_100g' => ['required', 'numeric', 'min:0'],
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produkt został zaktualizowany.');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produkt został usunięty.');
    }
}