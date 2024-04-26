<div class="flex flex-row">
    <label for="{{ $name }}" class="flex flex-grow w-32 text-m font-semibold text-black-900 py-1">{{ $label }}</label>
    <input type="{{ $type }}" value="{{$value}}" name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'form p-2 rounded mt-1 w-10 text-m']) }} autocomplete="off"
        placeholder="{{ $placeholder }}">
    {{ $slot }}
    </input>
    @error($name)
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>
