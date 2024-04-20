@extends('layout.default')

@section('content')
    <div class="flex pt-10">
        <div class="flex shrink m-10">
            <form action="/login" method="POST" class="flex flex-col">
                <h1 class="text-3xl info dark pb-4">Login</h1>
                @csrf
                <x-form-input label="Email" name="email" type="email" placeholder="janedoe@example.org" />
                <x-form-input label="Password" name="password" type="password" />
                <button class="dark-bg w-fit pink mt-5 text-white font-bold py-2 px-4 rounded">Login</button>
            </form>
        </div>
        <div class="flex-none pt-10">
            <h1 class=" text-3xl info pink pb-10">Not registered? Register!</h1>
            <a href="/register" class=" py-2 px-4 pink-bg dark font-bold border-2 border-gray-500 rounded">Register</a>
        </div>
    </div>
@endsection
