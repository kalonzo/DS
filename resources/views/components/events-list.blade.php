<div class="events-list">
    <h2>{{ $title }}</h2>
    <ul>
    @foreach($items as $item)
        <li>
            <a href="{{ $item['ets_url'] }}">
                <div class="events-item-avatar" style="background-color: {{ $item['bg_color'] }};">
                    <span class='events-item-avatar-text'>{!! $item['distance'] !!}</span>
                </div>
                <div class="events-item-text">
                    <span class='events-ets-name'>{{ $item['ets_name'] }}</span>
                    <br/>
                    <span class='events-item-name'>{{ $item['item_name'] }}</span>
                </div>
            </a>
        </li>
    @endforeach
    </ul>
</div>