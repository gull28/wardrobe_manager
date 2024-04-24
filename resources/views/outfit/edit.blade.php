@extends('layout.default')

@section('content')
    <div class="flex flex-col w-full align-center px-10 ">
        <h1 class="text-3xl font-bold dark pt-8 pb-5 px-5">Edit {{ $outfit['name'] }}</h1>
        <div class="flex flex-col justify-center align-center">
            <form action={{ route('outfits.update', [
                'outfit' => $outfit['id'],
            ]) }}
                method="POST" class="flex flex-col">
                @csrf
                @method('PUT')
                <div class="flex flex-row">
                    <div class="flex p-5 flex-row">
                        <div class="flex-flex-grow m-4">
                            <x-form-input label="Name" name="name" :value="$outfit['name']" type="text"
                                placeholder="For school" />
                            <x-form-input label="Description" :value="$outfit['desc']" name="description" type="text"
                                placeholder="Casual day outfit" />
                            <button type="submit"
                                class="dark-bg w-fit pink mt-10 text-white font-bold py-2 px-3 rounded">Save
                                outfit</button>
                        </div>
                        <div class="flex flex-grow flex-col m-4">
                            @foreach ($clothingTypes as $type)
                                <div class="flex flex-grow">
                                    @if (isset($clothesByCategory[$type]))
                                        <x-form-dropdown class="mb-2" label="{{ $type }}"
                                            name="{{ $type }}" type="checkbox" placeholder="Select a category">
                                            @foreach ($clothesByCategory[$type] as $clothes)
                                                <option value="{{ $clothes->id }}"
                                                    {{ (int) $clothes->id == (int) ($outfit['clothes'][$type]['id'] ?? 0) ? 'selected' : '' }}>
                                                    {{ $clothes->name }}
                                                </option>
                                            @endforeach
                                        </x-form-dropdown>
                                    @else
                                        <x-form-dropdown class="mb-2" label="{{ $type }}"
                                            name="{{ $type }}" type="checkbox" placeholder="Select a category">
                                        </x-form-dropdown>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endsection
