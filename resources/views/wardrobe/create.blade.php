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
                        <x-form-input label="Type" name="type" type="text" placeholder="Pants" />
                    </div>
                    <div class="flex p-5 flex-col">
                        <div class="flex flex-row">
                            <x-form-input label="Color" name="color" type="color" placeholder="Blue"
                                class="p-0 m-0 rounded-full w-20 h-20 border-none bg-transparent" id='color' />
                            <div class="text-white self-center mt-5 pink">[Click on the color to change it]</div>
                        </div>
                        <x-form-input label="Size" name="size" type="text" placeholder="M" class="pink-b" />
                        <x-form-input label="Brand" name="brand" type="text" placeholder="Levi's" class="pink-b" />
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
