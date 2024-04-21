<div class="flex flex-col w-96 m-5 h-max card">
    <div class="dark-bg shadow-md rounded px-8 pt-6 pb-8 h-max">
        <h1 class="text-3xl info pink pb-4">{{$title}}</h1>
        <hr class="h-4">
        <div class="flex flex-col justify-center align-center">
            {{$slot}}
        </div>
    </div>
</div>