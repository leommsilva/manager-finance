<table id="example2" class="table datatable table-bordered table-striped">
    <thead>
        <tr>
            @foreach(end($data) as $key=>$value)
                <th>{{$key}}</th>
            @endforeach
            @if(!empty($actions))
                <th width="15%">Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key=>$entity)
            <tr>
                @foreach($entity as $key=>$attr)
                    <td>{!!$attr!!}</td>
                @endforeach
                @if(!empty($actions))
                    <td>
                        <div class="btn-group-horizontal">
                            @if (!empty($actions['delete']))
                                <a href="{{$actions['delete']}}/{{$entity['id']}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            @endif
                        </div>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>