@extends('layout.default')

@section('content')
    <div class="flex flex-col w-full align-center px-10 ">
        <h1 class="text-3xl font-bold dark pt-8 pb-5 px-5">Add a new item to your wardrobe</h1>
        <div class="flex flex-col justify-center align-center">
            <form action="/outfits" method="POST" class="flex flex-col">
                @csrf
                <div class="flex flex-row">
                    <div class="flex p-5 flex-col">
                        <x-form-input label="Name" name="name" type="text" placeholder="For school" />
                        <x-form-input label="Description" name="description" type="text"
                            placeholder="Casual day outfit" />
                        @foreach ($clothingTypes as $type)
                            <div class="flex flex-grow">
                                @if (isset($clothesByCategory[$type]))
                                    <x-form-dropdown class="mb-2" label="{{ $type }}" name="{{ $type }}" type="checkbox"
                                        placeholder="Select a category">
                                        @foreach ($clothesByCategory[$type] as $clothes)
                                            <option value={{$clothes->id}}>{{ $clothes->name }}</option>
                                        @endforeach
                                    </x-form-dropdown>
                                @else
                                    <x-form-dropdown class="mb-2" label="{{ $type }}" name="{{ $type }}" type="checkbox"
                                        placeholder="Select a category">
                                    </x-form-dropdown>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="ml-5 dark-bg w-fit pink text-white font-bold py-2 px-3 rounded">Add
                    item</button>
            </form>
        </div>
    @endsection
