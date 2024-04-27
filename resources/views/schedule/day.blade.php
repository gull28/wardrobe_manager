@extends('layout.default')

@section('content')
    <div class="flex flex-grow flex-col">
        <h1 class="text-2xl font-bold dark p-10">Day: {{ $day }}</h1>
        <div class="flex p-10">
            <a href={{ route('schedule.wear', [
                'day' => $day,
            ]) }} class=" dark mx-5">Schedule
                an
                outfit</a>
            <a href={{ route('schedule.wash', [
                'day' => $day,
            ]) }} class=" dark mx-5 ">Schedule
                an
                wash</a>
        </div>

        <div class="flex flex-grow flex-col p-10">
            @foreach ($wearSchedule as $wear)
                <div>{{ $wear['date'] }}</div>
                @foreach ($wear['outfit']['clothing'] as $clothing)
                    <div class="flex">
                        {{ $clothing['category'] }}
                        {{ $clothing['name'] }}
                        {{ $clothing['type'] }}
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
@endsection
