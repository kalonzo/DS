@php
    $id = $tabledata['id'];
    $columns = $tabledata['columns'];
    $rows = $tabledata['rows'];
    $actions = $tabledata['actions'];
    $reloaded = $tabledata['reloaded'];
    $nbColumns = count($columns);
    if(!empty($actions)){
        $nbColumns++;   
    }
@endphp

@if(!isset($reloaded) || !$reloaded)
<div class="datatable-container">
@endif
    <table class="datatable table table-custom dt-responsive" id="{{ $id }}" width="100%">
        <thead>
            <tr>
            @foreach($columns as $column)
                <th class="sorting">{{ $column }}</th>
                @endforeach
                <!-- Actions extra column -->
                @if(!empty($actions))
                <th>Actions</th>
            @endif
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
            <tr class="">
            @foreach($columns as $columnKey => $columnLabel)
                <td>{{ $row[$columnKey] }}</td>
            @endforeach

            <!-- Actions -->
            @if(!empty($actions))
                <td>
                @foreach($actions as $actionId => $rowAction)
                    @if(!empty($rowAction->getHref()))
                    <?php
                        $href = $rowAction->getHref();
                        if(strpos($href, '{{') !== false){
                            $refAttribute = str_between($href, "{{", '}}');
                            if(isset($row[$refAttribute])){
                                $href = str_replace('{{'.$refAttribute.'}}', $row[$refAttribute], $href);
                            }
                        }
                    ?>
                    <a href="{{ $href }}">
                    @endif
                    <span class="glyphicon {{ $rowAction->getIcon() }}" title="{{ $rowAction->getTitle() }}" onclick="{{ $rowAction->getOnClick() }}"
                          aria-hidden="true"></span>
                    @if(!empty($rowAction->getHref()))
                    </a>
                    @endif
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