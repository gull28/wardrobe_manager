@extends('layout.default')

@section('content')
    <div class="flex flex-row justify-center align-center m-10">
        @if ($clothes->isEmpty())
            {{-- <x-card title="No items found">
                <p class="text-lg text-white w-96 text-wrap">Add some clothes to your wardrobe, so you can plan your outfits better.</p>
                <a href="/wardrobe/create" class=" py-2 px-4 pink-bg dark font-bold w-fit border-2 border-gray-500 mt-5 rounded">Add clothes</a>
            </x-card> --}}
        @else
            <div class="grid grid-cols-3 gap-4">
                @foreach ($clothes as $c)
                <x-card title="{{ $c->name }}" :to="route('wardrobe.edit', ['wardrobe' => $c->id])" class="pink-bg">
                    <p class="text-lg text-white">{{ $c->description }}</p>
                        <p class="text-lg text-white">Category: {{ $c->category }}</p>
                        <p class="text-lg text-white">Size: {{ $c->size }}</p>
                        <p class="text-lg text-white">Brand: {{ $c->brand }}</p>
                        <p class="text-lg text-white">Wear count: {{ $c->wear_count }}</p>
                    </x-card>
                @endforeach
            </div>
        @endif
    @endsection
