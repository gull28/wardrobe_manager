@extends('layout.default')

@section('content')
    <div class="flex flex-col w-full align-center px-10 ">
        <h1 class="text-3xl font-bold dark pt-8 pb-5 px-5">Edit {{$item->name}}</h1>
        <div class="flex flex-col justify-center align-center">
            <form action={{route("wardrobe.update", $item->id)}} method="POST" class="flex flex-col">
                @csrf
                @method('PUT')
                <div class="flex flex-row">
                    <div class="flex p-5 flex-col">
                        <x-form-input label="Name" :value="$item->name" name="name" type="text" placeholder="Blue jeans" />
                        <x-form-input label="Description" :value="$item->description" name="description" type="text"
                            placeholder="The ones with a hole in them" />
                        <x-form-dropdown label="Category" name="category" type="text" placeholder="Select a category">
                            @foreach ($clothingTypes as $type)
                                <option selected={{
                                    $item->category == $type ? 'selected' : ''
                                }}>{{ $type }}</option>
                            @endforeach
                        </x-form-dropdown>
                        <x-form-input label="Wear count" name="Wear count" :value="$item->wear_count"  type="number" placeholder="how many times to wear before washing" />
                    </div>
                    <div class="flex p-5 flex-col">
                        <div class="flex flex-row">
                            <x-form-input label="Color" name="color" :value="$item->color" type="color" placeholder="Blue"
                                class="p-0 m-0 rounded-full w-16 h-16 border-none bg-transparent" id='color' />
                        </div>
                        <x-form-dropdown label="Size" name="size" type="text" placeholder="M" class="pink-b">
                            @foreach ($sizes as $size)
                                <option selected={{
                                    $item->size == $size ? 'selected' : ''
                                }}>{{ $size }}</option>
                            @endforeach
                        </x-form-dropdown>
                        <x-form-input label="Brand" :value="$item->brand"  name="brand" type="text" placeholder="Levi's" class="pink-b" />
                    </div>
                </div>
                <button type="submit" class="ml-5 dark-bg w-fit pink mt-5 text-white font-bold py-2 px-3 rounded">Add
                    item</button>
            </form>
        </div>
        <script>
            $("#color").change(function(event) {
                console.log($(this).val());
                $("#color_front").css('background-color', $(this).val());
            });

            $("#color_front").click(function(event) {
                $("#color").click();
            });
        </script>
    @endsection
