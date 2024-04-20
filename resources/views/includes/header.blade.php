<header class="sticky top-0 py-2">
    <nav class="min-h-10 flex w-full items-center">
        {{-- logo --}}
        <div class="px-5 flex-initial w-64">
            <a href="{{ route('home') }}" class="text-l font-bold text-gray-800">Laravel</a>
        </div>

        {{-- nav stuff --}}
        <div class="flex-grow">
            <ul class="flex justify-evenly">
                @auth
                    <li class="px-5">
                        <a href="/wardrobe" class="navlink text-black-900">Wardrobe</a>
                    </li>
                    <li class="px-5">
                        <a href="/wardrobe" class="navlink text-black-900">Outfits</a>
                    </li>
                    <li class="px-5">
                        <a href="/wardrobe" class="navlink text-black-900">Laundry cycles</a>
                    </li>
                @else
                    <li class="px-5">
                        <a href="{{ route('home') }}" class="navlink text-black-900 ">Home</a>
                    </li>
                    <li class="px-5">
                        <a href="/about" class=" navlink text-black-900">About</a>
                    </li>
                @endauth

            </ul>
        </div>

        {{-- icons --}}
        <div class="flex-initial px-5">
            @auth
                <ul class="flex justify-evenly">
                    <li class="px-5">
                        <a href="/profile" class="contrast text-gray-900 navlink">Profile</a>
                    </li>
                    <li class="px-5">
                        <form action="/logout" method="POST">
                            @csrf
                            <button class="contrast pink text-gray-900 navlink">Logout</button>
                        </form>
                    </li>
                </ul>
            @else
                <ul class="flex justify-evenly">
                    <li class="px-5">
                        <a href="/login" class="contrast text-gray-900 navlink">Login</a>
                    </li>
                    <li class="px-5">
                        <a href="/register" class="contrast text-gray-900 navlink ">Register</a>
                    </li>
                </ul>
            @endauth
        </div>
    </nav>
</header>
