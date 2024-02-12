<div class="slideshow">
    {{--    @dd($slides)--}}
    @isset($slides)
        @foreach($slides as $slide)
            @if($slide->link)
                <a href="{{ $slide->link }}">
                    @endif
                    <div class="slide">
                        <img src="{{ $slide->media->getUrl() }}" alt="">
                    </div>
                    @if($slide->link)
                </a>
            @endif
        @endforeach
    @endisset

    <a class="prev" onclick="move(-1)"><span>&#10095</span></a>
    <a class="next" onclick="move(1)"><span>&#10094</span></a>

    <div class="items">
        @isset($slides)
            @foreach($slides as $slide)
                <div class="item">
                    <div class="item-inner"></div>
                </div>
            @endforeach
        @endisset
    </div>
</div>