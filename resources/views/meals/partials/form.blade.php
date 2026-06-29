<div>
    <label class="block font-medium text-sm text-gray-700">Data posiłku</label>
    <input
        type="date"
        name="meal_date"
        value="{{ old('meal_date', $meal->meal_date ?? date('Y-m-d')) }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
    >
    @error('meal_date')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <label class="block font-medium text-sm text-gray-700">Typ posiłku</label>
    <select
        name="meal_type"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
    >
        @php
            $selectedType = old('meal_type', $meal->meal_type ?? '');
        @endphp

        <option value="">Wybierz typ</option>
        <option value="Śniadanie" @selected($selectedType === 'Śniadanie')>Śniadanie</option>
        <option value="Drugie śniadanie" @selected($selectedType === 'Drugie śniadanie')>Drugie śniadanie</option>
        <option value="Obiad" @selected($selectedType === 'Obiad')>Obiad</option>
        <option value="Kolacja" @selected($selectedType === 'Kolacja')>Kolacja</option>
        <option value="Przekąska" @selected($selectedType === 'Przekąska')>Przekąska</option>
    </select>

    @error('meal_type')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <label class="block font-medium text-sm text-gray-700">Nazwa, opcjonalnie</label>
    <input
        type="text"
        name="name"
        value="{{ old('name', $meal->name ?? '') }}"
        placeholder="np. Owsianka z bananem"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
    >
    @error('name')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>