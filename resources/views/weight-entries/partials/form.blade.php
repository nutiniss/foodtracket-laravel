<div>
    <label class="block font-medium text-sm text-gray-700">Data pomiaru</label>
    <input
        type="date"
        name="entry_date"
        value="{{ old('entry_date', $weightEntry->entry_date ?? date('Y-m-d')) }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
    >
    @error('entry_date')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <label class="block font-medium text-sm text-gray-700">Masa ciała (kg)</label>
    <input
        type="number"
        step="0.01"
        name="weight"
        value="{{ old('weight', $weightEntry->weight ?? '') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
    >
    @error('weight')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>