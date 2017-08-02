@php
    $columns = $tabledata['columns'];
    $rows = $tabledata['rows'];
@endphp
<table class="table table-custom dt-responsive" id="responsive-usage" width="100%">
    <thead>
        <tr>
            @foreach($columns as $column)
            <th class="sorting">{{ $column }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
    @foreach($rows as $row)
    <tr class="">
        @foreach($columns as $columnKey => $columnLabel)
            <td>{{ $row[$columnKey] }}</td>
        @endforeach
    </tr>
    @endforeach
</table>
{{ $rows->links() }}