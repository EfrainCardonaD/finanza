@php $editing = isset($category) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="name" label="Name">
            @php $selected = old('name', ($editing ? $category->name : '')) @endphp
            <option value="Tarjeta de credito" {{ $selected == 'Tarjeta de credito' ? 'selected' : '' }} >Tarjeta de credito</option>
            <option value="Gastos Personales" {{ $selected == 'Gastos Personales' ? 'selected' : '' }} >Gastos personales</option>
            <option value="" {{ $selected == '' ? 'selected' : '' }} ></option>
        </x-inputs.select>
    </x-inputs.group>
</div>
