@extends('layout.default')

@section('content')
<div class="flex flex-grow justify-center align-center m-10 mt-5">
    {{-- <x-card title="Title" class="pink-bg">
        <p class="text-lg text-white">This is a simple site built with Laravel and Tailwind CSS.</p>
        <p class="text-lg text-white pt-3">You can register or login to access the site.</p>
    </x-card>
    <x-card title="Title" class="pink-bg">
        <p class="text-lg text-white">This is a simple site built with Laravel and Tailwind CSS.</p>
        <p class="text-lg text-white pt-3">You can register or login to access the site.</p>
    </x-card> --}}
    @auth
        <x-calendar schedule="{{$schedule}}" />
    @else
        {{-- <x-card title="Welcome to Wardrobe" class="pink-bg">
            <p class="text-lg text-white">This is a simple site built with Laravel and Tailwind CSS.</p>
            <p class="text-lg text-white pt-3">You can register or login to access the site.</p>
        </x-card> --}}
    @endauth
</div>
@endsection