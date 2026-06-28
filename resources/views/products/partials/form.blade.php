<div>
    <label class="block font-medium text-sm text-gray-700">Nazwa</label>
    <input
        type="text"
        name="name"
        value="{{ old('name', $product->name ?? '') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
    >
    @error('name')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <label class="block font-medium text-sm text-gray-700">Kalorie / 100g</label>
    <input
        type="number"
        step="0.01"
        name="calories_per_100g"
        value="{{ old('calories_per_100g', $product->calories_per_100g ?? '') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
    >
    @error('calories_per_100g')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <label class="block font-medium text-sm text-gray-700">Białko / 100g</label>
    <input
        type="number"
        step="0.01"
        name="protein_per_100g"
        value="{{ old('protein_per_100g', $product->protein_per_100g ?? '') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
    >
    @error('protein_per_100g')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <label class="block font-medium text-sm text-gray-700">Tłuszcz / 100g</label>
    <input
        type="number"
        step="0.01"
        name="fat_per_100g"
        value="{{ old('fat_per_100g', $product->fat_per_100g ?? '') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
    >
    @error('fat_per_100g')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <label class="block font-medium text-sm text-gray-700">Węglowodany / 100g</label>
    <input
        type="number"
        step="0.01"
        name="carbs_per_100g"
        value="{{ old('carbs_per_100g', $product->carbs_per_100g ?? '') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
    >
    @error('carbs_per_100g')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>