<div class="flex flex-col w-fit m-5 h-max card">
    <div class="dark-bg shadow-md rounded px-8 pt-6 pb-8 h-max">
        <div class="flex flex-row justify-between items-center">
            <h1 class="text-3xl info pink pb-4">{{$title}}</h1>
            <div class="w-5 h-5 pink self-center mb-4 ml-5">
                <a href="{{$to}}">
                    @svg('fas-edit')
                </a>
            </div>
        </div>
        <hr class="h-4">
        <div class="flex flex-col justify-center align-center">
            {{$slot}}
        </div>
    </div>
</div>
