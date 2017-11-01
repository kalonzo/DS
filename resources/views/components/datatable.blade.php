@php
    $id = $tabledata['id'];
    $filters = isset($tabledata['filters']) ? $tabledata['filters'] : null;
    $columns = $tabledata['columns'];
    $rows = $tabledata['rows'];
    $actions = isset($tabledata['actions']) ? $tabledata['actions'] : null;
    $reloaded = $tabledata['reloaded'];
    $nbColumns = count($columns);
    if(!empty($actions)){
        $nbColumns++;   
    }
@endphp

@if(!isset($reloaded) || !$reloaded)
<div class="datatable-container">
@endif
    @if(isset($filters) && !empty($filters))
    <form class="datatable-filters form-inline">
        <?php
        foreach($filters as $filter){
            if($filter instanceof \App\Feeders\DatatableFilter){
                ?><div class="form-group"><?php
                if(!empty($filter->getLabel())){
                    echo Form::label('filter['.$filter->getName().']', $filter->getLabel());
                }
                switch ($filter->getInputType()){
                    case \App\Feeders\DatatableFilter::INPUT_TEXT:
                        echo Form::text('filter['.$filter->getName().']', $filter->getValue(), ['class' => 'form-control', 'placeholder' => $filter->getPlaceholder()]);
                        break;
                    case \App\Feeders\DatatableFilter::INPUT_SELECT:
                        echo Form::select('filter['.$filter->getName().']', $filter->getOptions(), $filter->getValue(), 
                                        ['class' => 'form-control select2', 'placeholder' => $filter->getPlaceholder()]);
                        break;
                }
                ?></div><?php
            }
        }
        ?>
    </form>
    @endif
    <table class="datatable table table-custom dt-responsive" id="{{ $id }}" width="100%">
        <thead>
            <tr>
            @foreach($columns as $column)
                <th class="sorting">{{ $column }}</th>
                @endforeach
                <!-- Actions extra column -->
                @if(!empty($actions))
                <th class="dt-column-action">Actions</th>
            @endif
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
            <tr class="">
            @foreach($columns as $columnKey => $columnLabel)
                <td>{!! $row[$columnKey] !!}</td>
            @endforeach

            <!-- Actions -->
            @if(!empty($actions))
                <td class="dt-column-action">
                @foreach($actions as $actionId => $rowAction)
                    <?php
                    $hide = $rowAction->getHiddenCond();
                    if(empty($hide) || !$row[$hide]){
                        $classes = $rowAction->getIcon();
                        $href = $rowAction->getHref();
                        if(!empty($rowAction->getHref())){
                            if(strpos($href, '{{') !== false){
                                $refAttribute = str_between($href, "{{", '}}');
                                if(isset($row[$refAttribute])){
                                    $href = str_replace('{{'.$refAttribute.'}}', $row[$refAttribute], $href);
                                }
                            }
                        }
                        $onClick = $rowAction->getOnClick();
                        if(!empty($rowAction->getOnClick())){
                            $classes .= ' clickable';
                            if(strpos($onClick, '{{') !== false){
                                $refAttribute = str_between($onClick, "{{", '}}');
                                if(isset($row[$refAttribute])){
                                    $onClick = str_replace('{{'.$refAttribute.'}}', $row[$refAttribute], $onClick);
                                }
                            }
                        }
                        ?>
                        @if(!empty($href))
                        <a href="{{ $href }}">
                        @endif
                        <span class="glyphicon {{ $classes }}" title="{{ $rowAction->getTitle() }}" onclick="{{ $onClick }}"
                              aria-hidden="true"></span>
                        @if(!empty($href))
                        </a>
                        @endif
                        <?php
                    }
                    ?>
                @endforeach
                </td>
            @endif
            </tr>
            @empty
            <tr class="text-center">
                <td colspan="{{ $nbColumns }}">
                    Aucune donnée à afficher
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="row no-margin datatable-container-footer">
        {{ $rows->links() }}
    </div>
@if(!isset($reloaded) || !$reloaded)
</div>
@endif