@extends('layout.default')

@section('content')
    <div class="flex flex-row justify-center align-center w-full">
        @if (!$outfits)
            {{-- <x-card title="No items found">
                <p class="text-lg text-white w-96 text-wrap">Add some clothes to your wardrobe, so you can plan your outfits better.</p>
                <a href="/outfits/create" class="py-2 px-4 pink-bg dark font-bold w-fit border-2 border-gray-500 mt-5 rounded">Add clothes</a>
            </x-card> --}}
        @else
            <div class="flex flex-col">
                <div class="flex mb-5">
                    <a href="/outfits/create"
                        class="py-2 px-4 dark-bg pink font-bold w-fit border-2 border-gray-500 mt-5 rounded">Add outfits</a>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    @foreach ($outfits as $outfit)
                        <x-card :title="$outfit['name']" :to="route('outfits.edit', ['outfit' => $outfit['id']])" class="pink-bg">
                            @foreach ($clothingTypes as $type)
                                <div class="flex flex-row my-1">
                                    <p class="text-lg text-white">{{ $type }}: </p>
                                    <p class="text-lg text-white mx-3">{{ $outfit['clothes'][$type]['name'] ?? 'None' }}</p>
                                    @if (isset($outfit['clothes'][$type]['color']) && $outfit['clothes'][$type]['color'])
                                        <div class="w-5 h-5 rounded-full mt-1"
                                            style="background-color: {{ $outfit['clothes'][$type]['color'] }}"></div>
                                    @endif
                                </div>
                            @endforeach
                        </x-card>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

@endsection
