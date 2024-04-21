@extends('layout.default')

@section('content')
    <div class="flex flex-col w-full align-center px-10 ">
        <h1 class="text-3xl font-bold dark pt-8 pb-5 px-5">Add a new item to your wardrobe</h1>
        <div class="flex flex-col justify-center align-center">
            <form action="/wardrobe" method="POST" class="flex flex-col">
                @csrf
                <div class="flex flex-row">
                    <div class="flex p-5 flex-col">
                        <x-form-input label="Name" name="name" type="text" placeholder="Blue jeans" />
                        <x-form-input label="Description" name="description" type="text"
                            placeholder="The ones with a hole in them" />
                        <x-form-dropdown label="Category" name="category" type="text" placeholder="Select a category">
                            @foreach ($clothingTypes as $type)
                                <option>{{ $type }}</option>
                            @endforeach
                        </x-form-dropdown>
                        <x-form-input label="Wear count" name="Wear count " type="number" placeholder="how many times to wear before washing" />
                    </div>
                    <div class="flex p-5 flex-col">
                        </x-form-dropdown>
                        <x-form-input label="Brand" name="brand" type="text" placeholder="Levi's" class="pink-b" />
                    </div>
                </div>
                <button type="submit" class="ml-5 dark-bg w-fit pink mt-5 text-white font-bold py-2 px-3 rounded">Add
                    item</button>
            </form>
        </div>
    @endsection
