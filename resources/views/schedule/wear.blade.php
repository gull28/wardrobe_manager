@extends ('layout.default')

@section('content')
    <div class="flex flex-grow justify-center mt-10">
        <x-card title="Choose an outfit to wear" to="none">
            <form action="{{ route('schedule.wear', ['day' => $day]) }}" method="POST">
                @csrf
                <div class="flex flex-grow flex-col px-10">
                    @foreach ($outfits as $outfit)
                        <x-form-radio disabled="{{ !in_array($outfit['id'], $wearables) ? 'disabled' : '' }}"
                            label="{{ $outfit['name'] }}" checked="{{$outfitId === $outfit['id'] ? 'checked' : ''}}" value="{{$outfit['id']}}" name="outfit" type="radio" />
                    @endforeach
                </div>
                <button type="submit" class="pink-bg w-fit dark mt-10 text-white font-bold py-2 px-3 rounded">Wear
                    outfit</button>
            </form>
        </x-card>
    </div>
@endsection
