@extends('layout.default')

@section('content')
    <div class="flex flex-row justify-center align-center m-10">
        @if ($clothes->isEmpty())
            {{-- <x-card title="No items found">
                <p class="text-lg text-white w-96 text-wrap">Add some clothes to your wardrobe, so you can plan your outfits better.</p>
                <a href="/wardrobe/create" class=" py-2 px-4 pink-bg dark font-bold w-fit border-2 border-gray-500 mt-5 rounded">Add clothes</a>
            </x-card> --}}
            <div class="flex flex-col">
                <a href="/wardrobe/create"
                    class="py-2 px-4 dark-bg pink font-bold w-fit border-2 border-gray-500 mt-5 rounded">Add clothes</a>
            </div>

        @else
            <div class="grid grid-cols-3 gap-4">
                @foreach ($clothes as $c)
                    <x-card title="{{ $c->name }}" :to="route('wardrobe.edit', ['wardrobe' => $c->id])" class="pink-bg">
                        <div class="flex flex-row">
                            <p class="text-lg text-white mr-5">Color: </p>
                            <div class="w-5 h-5 rounded-full mt-1" style="background-color: {{ $c->color }}"></div>
                        </div>
                        <p class="text-lg text-white">{{ $c->description }}</p>
                        <p class="text-lg text-white">Category: {{ $c->category }}</p>
                        <p class="text-lg text-white">Size: {{ $c->size }}</p>
                        <p class="text-lg text-white">Brand: {{ $c->brand }}</p>
                        <p class="text-lg text-white">Wear count: {{ $c->wear_count }}</p>
                        <p class="text-lg text-white">Uses left: {{ $c->uses_left }}</p>

                        <div class="flex flex-row justify-between">
                            <button id="delete_clothing" data-id="{{ $c->id }}"
                                class="pink-bg w-fit dark mt-5 text-white font-bold py-2 px-3 rounded mx-2">Delete</button>
                            <button id="wash_clothing" data-id="{{ $c->id }}"
                                class="pink-bg w-fit dark mt-5 text-white font-bold py-2 px-3 rounded mx-2">Wash</button>
                        </div>
                    </x-card>
                @endforeach
                <script>
                    document.querySelectorAll('#delete_clothing').forEach(item => {
                        item.addEventListener('click', event => {
                            fetch(`/wardrobe/${item.getAttribute('data-id')}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            }).then(response => {
                                if (response.ok) {
                                    location.reload();
                                }
                            });
                        });
                    });

                    document.querySelectorAll('#wash_clothing').forEach(item => {
                        item.addEventListener('click', event => {
                            fetch(`/wardrobe/${item.getAttribute('data-id')}/wash`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            }).then(response => {
                                if (response.ok) {
                                    location.reload();
                                }
                            });
                        });
                    });
                </script>
            </div>
        @endif
    @endsection
