@extends('layout.default')

@section('content')
    <div class="flex flex-grow flex-col">
        <h1 class="text-2xl font-bold dark p-10">Day: {{ $day }}</h1>
        @if ($isEditable)
            <div class="flex px-10 py-3">
                <a href={{ route('schedule.wear', [
                    'day' => $day,
                ]) }}
                    class=" dark mx-5">Schedule
                    an
                    outfit</a>
                <a href={{ route('schedule.wash', [
                    'day' => $day,
                ]) }}
                    class=" dark mx-5 ">Schedule
                    a
                    wash</a>
            </div>
        @endif
        <div class="flex flex-grow flex-col px-8">
                @foreach ($wearSchedule as $wear)
                <h1 class="text-2xl font-bold dark px-8 py-2">Outfit scheduled</h1>
                    @foreach ($wear['outfit']['clothing'] as $clothing)
                        <x-card :title="$clothing['name']" :to="route('outfits.edit', ['outfit' => $wear['id']])" class="pink-bg">
                        @foreach ($clothingTypes as $type)
                            <div class="flex flex-row my-1">
                                <p class="text-lg text-white">{{ $type }}: </p>
                                <p class="text-lg text-white mx-3">{{ ($clothing['category'] === $type) ? $clothing['name'] : 'None' }}</p>
                                @if (isset($clothing['color'] ) && ($clothing['category'] === $type))
                                    <div class="w-5 h-5 rounded-full mt-1"
                                        style="background-color: {{ $clothing['color'] }}"></div>
                                @endif
                            </div>
                        @endforeach
                        </x-card>
                    @endforeach
                @endforeach
        </div>
    </div>
@endsection
