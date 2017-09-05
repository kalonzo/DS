<?php
$range = null;
$startRange = null;
$endRange = null;
$selectedItemId = null;
foreach($items as $item){
    if(isset($item['selected']) && $item['selected']){
        $selectedItemId = $item['id'];
    }
    if(isset($item['value'])){
        if($startRange === null || $item['value'] < $startRange){
            $startRange = $item['value'];
        }
        if($endRange === null || $item['value'] > $startRange){
            $endRange = $item['value'];
        }
    }
}
if($startRange !== null && $endRange !== null){
    $range = $endRange - $startRange;
}

if(empty($selectedItemId)){
    $selectedItem = current($items);
    if(!empty($selectedItem)){
        $selectedItemId = $selectedItem['id'];
    }
}
?>
<div class="timeline-links">
    <div class="timeline-line">
        @foreach($items as $item)
            <?php
            $left = 0;
            if($range !== null){
                $left = ($item['value'] - $startRange) / $range * 100;
            }
            $left .= '%';
            ?>
            <a class="timeline-checkpoint @if($item['id'] == $selectedItemId) selected @endif" data-id="{{ $item['id'] }}"
               style="left: {!! $left !!};" onclick="selectTimelineItem(this);">
                <span class="timeline-disc"></span>
                <span class="timeline-disc-label">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
    <div class="timeline-content">
        @foreach($items as $item)
            <?php
            $contentVarName = 'content_'.$item['id'];
            ?>
            @if(isset($$contentVarName))
            <div class="timeline-slide @if($item['id'] == $selectedItemId) selected @endif" data-id="{{ $item['id'] }}">
                {!! $$contentVarName !!}
            </div>
            @endif
        @endforeach
    </div>
</div>