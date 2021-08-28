@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
        </div>
        <ul class="breadcrumb">
            <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
            <li><a href="{{ URL::to('template?return='.$return) }}">{{ $pageTitle }}</a></li>
            <li class="active"> {{ Lang::get('core.detail') }} </li>
        </ul>
    </div>  


    <div class="page-content-wrapper">   
        <div class="toolbar-line">
            <a href="{{ URL::to('template?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
            @if($access['is_add'] ==1)
            <a href="{{ URL::to('template/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
            @endif  		   	  
        </div>
        <div class="sbox animated fadeInRight">
            <div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
            <div class="sbox-content" id="sbox-content"> 	
                <div class="bordered" style="border:2px dashed #000000b8;padding: 15px;">
                    <a class="btn btn-success btn-xs" id="AddNew"><i class="fa fa-plus-circle"></i> Add More</a>
                    <h2 class="text-center">{{ $row->title }}</h2>                    
                    <div class="items">
                        @foreach($items as $value)                             
                        <div class="item" style="padding: 10px;margin: 5px;">
                            <a class="btn btn-primary btn-xs edit" data-id="{{$value->id}}" data-item="{{$value->item}}"><i class="fa fa-pencil"></i> Edit</a>
                            <a class="btn btn-danger btn-xs del" data-id="{{$value->id}}"><i class="fa fa-trash-o"></i> Delete</a>
                            <p style="margin: 15px 0">{!!$value->item!!}</p>
                            <hr style="border-top: 1px dashed;"/>
                        </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>	
    </div>
</div>
<!-- Modal -->
<div id="Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Item</h4>
            </div>
            <div class="modal-body">
                 <form class="form-horizontal" id="addItem" method="post"> 
                    {!!Form::token()!!}
                    {!! Form::hidden('template_id',$row->id) !!} 
                    {!! Form::hidden('id','',['id'=>'id']) !!} 

                    <div class="form-group  " >                               
                        <div class="col-md-12">
                            <textarea name='item' rows='5' id='item' class='form-control editor1'   ></textarea> 
                        </div> 
                    </div> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>                       
                    </div>
                </form>    
            </div>
        </div>
    </div>
</div>


<style>

</style>
<script>
    // add new item
    $(document).on('click', '#AddNew', function () {
        $('#Modal form').trigger("reset");
        $('#Modal form').attr('id', 'addItem');
        $('#Modal .modal-title').text('Add New Item');
        $('#Modal .note-editable').html('');
        $('#Modal #id').val(''); 
        $('#Modal').modal('show');
    });
    // submit
    $(document).on('submit', '#addItem', function (event) {
        event.preventDefault();
        $('#Modal').modal('hide');
        var data = $(this).serialize();
        $.ajax({           
            type: 'POST',  
            url: "<?= url('items') ?>",
            data: data,
            success: function (data) {
                $(".items").html(data);

            }
        });
    });
     // edit item
     
    $(document).on('click', '.edit', function () {
        $('#Modal form').trigger("reset");
//        //edit modal info 
        $('#Modal .note-editable').html($(this).attr('data-item'));       
        $('#Modal #id').val($(this).attr('data-id'));        
        $('#Modal form').attr('id', 'edit_form');
        $('#Modal .modal-title').text('Edit Item');
        $('#Modal').modal('show');
    });
        // submit
        $(document).on('submit', '#edit_form', function (event) {
            event.preventDefault();
            $('#Modal').modal('hide');
            var data = $(this).serialize();       
            $.ajax({
                type: 'POST',  
                url: "<?= url('items') ?>",
                data: data,
                success: function (data) {
                    $(".items").html(data);

                }
            });
        });
    // delete item
    $(document).on('click', '.del', function () {      
        var confirmed = confirm('Are you sure you want to delete?');
        if (confirmed) {
            var btn = $(this);
            var id = $(this).attr('data-id');           
            $.ajax({
                method: "get",
                url: "<?= url('items/delete') ?>",
                data: {id: id},
                success: function (data) {                   
                    if (data == 'success') {
                         btn.parent().remove();
                     }
                    else {
                        $.notify("Sorry,something goes wrong please try again", "danger");
                    }
                }
            });
        }
    });
</script>   
@stop