<div class="flex flex-col">
    <label for="{{ $name }}" class="text-m font-semibold text-black-900 py-1">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="form p-2 rounded mt-1 w-96 text-m" autocomplete="off" placeholder="{{ $placeholder }}"/>
    @error($name)
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>