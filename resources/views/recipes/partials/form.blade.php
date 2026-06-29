<div>
    <label class="block font-medium text-sm text-gray-700">Tytuł przepisu</label>
    <input
        type="text"
        name="title"
        value="{{ old('title', $recipe->title ?? '') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
    >
    @error('title')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <label class="block font-medium text-sm text-gray-700">Opis</label>
    <textarea
        name="description"
        rows="3"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
    >{{ old('description', $recipe->description ?? '') }}</textarea>
    @error('description')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <label class="block font-medium text-sm text-gray-700">Instrukcja przygotowania</label>
    <textarea
        name="instructions"
        rows="6"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
    >{{ old('instructions', $recipe->instructions ?? '') }}</textarea>
    @error('instructions')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>