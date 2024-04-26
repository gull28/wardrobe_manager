@extends('layout.default')

@section('content')
    <div class="flex flex-grow p-10">
        <a href={{ route('schedule.wear', [
            'day' => $day,
        ]) }} class=" dark">Schedule an outfit</a>
        <a href={{ route('schedule.wash', [
            'day' => $day,
        ]) }} class=" dark ">Schedule an wash</a>
    </div>
@endsection
