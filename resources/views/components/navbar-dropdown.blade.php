@if(!isset($reloaded) || !$reloaded)
<li id="{{$containerId }}" class="dropdown">
@endif
    <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <img alt="{{ $buttonImageAlt }}" src="{{ $buttonImageSrc }}"/>
        <span class="badge">{{ count($eventsList) }}</span>
    </a>
    <div class="dropdown-menu">
        @component('components.events-list', [
                                            'title' => $dropdownTitle,
                                            'items' => $eventsList
                                            ])

        @endcomponent
    </div>
@if(!isset($reloaded) || !$reloaded)
</li>
@endif