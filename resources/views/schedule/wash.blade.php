@extends ('layout.default')

@section('content')
    <div class="flex flex-grow justify-center mt-10">
        <x-card title="Choose clothes to wash" to="none">
            <form action="{{ route('schedule.wash', ['day' => $day]) }}" method="POST">
                @csrf
                <div class="flex flex-grow flex-col px-10">
                    @foreach ($clothes as $c)
                        <x-form-radio label="{{ $c['name'] }}" value="{{ $c['id'] }}" name="clothes[]" type="checkbox" />
                    @endforeach
                </div>
                <button type="submit" class="pink-bg w-fit dark mt-10 text-white font-bold py-2 px-3 rounded">Wash
                    clothing</button>
            </form>
        </x-card>
    </div>
@endsection
