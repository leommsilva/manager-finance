<table class="table datatable table-bordered table-striped">
    <thead>
        <tr>
            @foreach(end($data) as $key=>$value)
                @if(!in_array($key, ['id', 'is_verified']))
                    @if(in_array($key, ['Category', 'Month/Year']))
                        <th class="hidden-xs hidden-sm">{{$key}}</th>
                    @else
                        <th>{{$key}}</th>
                    @endif
                @endif
            @endforeach
            @if(!empty($actions))
                <th>Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key=>$entity)
            <tr>
                @foreach($entity as $key=>$attr)
                    @if(!in_array($key, ['id', 'is_verified']))
                        @if(in_array($key, ['Category', 'Month/Year']))
                            <td class="hidden-xs hidden-sm">{!!$attr!!}</td>
                        @else
                            <td>{!!$attr!!}</td>
                        @endif
                    @endif
                @endforeach
                @if(!empty($actions))
                    <td>
                        <div class="btn-group-horizontal">
                            @if (!empty($actions['delete']))
                                <a href="{{$actions['delete']}}/{{$entity['id']}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            @endif
                            @if (!empty($actions['verify']))
                                @if ($entity['is_verified'])
                                    <a href="{{$actions['verify']}}/{{$entity['id']}}" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i></a>
                                @else
                                    <a href="{{$actions['verify']}}/{{$entity['id']}}" class="btn btn-danger"><i class="fa fa-thumbs-o-down"></i></a>
                                @endif
                            @endif
                        </div>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>