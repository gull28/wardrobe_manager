@extends('layout.default')

@section('content')
    <div class="flex flex-row justify-center align-center mt-10">
        @if ($clothes->isEmpty())
            <x-card title="No items found">
                <p class="text-lg text-white w-96 text-wrap">Add some clothes to your wardrobe, so you can plan your outfits better.</p>
                <a href="/wardrobe/create" class=" py-2 px-4 pink-bg dark font-bold w-fit border-2 border-gray-500 mt-5 rounded">Add clothes</a>
            </x-card>
        @else
            <div class="grid grid-cols-3 gap-4">

                @foreach ($clothes as $clothe)
                    <x-card title="{{ $clothe->name }}" class="pink-bg">
                        <p class="text-lg text-white">{{ $clothe->description }}</p>
                        <p class="text-lg text-white pt-3">{{ $clothe->created_at }}</p>
                    </x-card>
                @endforeach
            </div>
        @endif
    @endsection