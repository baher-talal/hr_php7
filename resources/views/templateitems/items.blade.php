               

    @foreach($items as $value)                             
    <div class="item" style="padding: 10px;margin: 5px;">
        <a class="btn btn-primary btn-xs edit" data-id="{{$value->id}}" data-item="{{$value->item}}"><i class="fa fa-pencil"></i> Edit</a>
        <a class="btn btn-danger btn-xs del" data-id="{{$value->id}}"><i class="fa fa-trash-o"></i> Delete</a>
        <p style="margin: 15px 0">{!! $value->item !!}</p>
        <hr style="border-top: 1px dashed;"/>
    </div>
    
    @endforeach

