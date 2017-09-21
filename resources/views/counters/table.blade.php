<table class="table table-responsive" id="counters-table">
    <thead>
        <th>Qty</th>
        <th>Request From</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($counters as $counter)
        <tr>
            <td>{!! $counter->qty !!}</td>
            <td>{!! $counter->ip_address !!}</td>
            <td>{!! $counter->created_at !!}</td>
            <td>{!! $counter->updated_at !!}</td>
            <td>
                {!! Form::open(['route' => ['counters.destroy', $counter->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('counters.show', [$counter->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('counters.edit', [$counter->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>