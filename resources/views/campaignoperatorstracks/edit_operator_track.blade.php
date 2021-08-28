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
		<li><a href="{{ URL::to('campaigntracks?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>

    </div>

 	<div class="page-content-wrapper">

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content">
    <div class="row">

        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>Edit Operator Track Form</h3>
                    <div class="box-tool">
                        <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                        <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    {!! Form::open(["url"=>"operator_track/$operator_track->id",'class'=>'form-horizontal','method'=>'patch']) !!}

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Track Code *</label>
                        <div class="col-sm-9 col-lg-10 controls">
                            {!! Form::number('code',$operator_track->code,['placeholder'=>'Track Code','class'=>'form-control input-lg','required' => 'required']) !!}
                            <span class="help-inline">Enter a new code for track</span><br><br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Select Operator for that track *</label>
                        <div class="col-sm-9 col-lg-10 controls">
                          <select class="form-control chosen" name="operator_id" required>
                            @foreach ($operators as $key => $value)
                              <option value="{{$value->id}}" @if($value->id == $operator_track->operator_id) selected @endif>{{ $value->country->country }}-{{ $value->name }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                 </div>
            </div>
        </div>

    </div>
	</div>
</div>
</div>
</div>
<script>
    var room = 1;
    var deleted_items = [] ;
    var added_items = [] ;
    function new_field() {

        room++;
        var objTo = document.getElementById('new_field') ;
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group removeclass"+room);
        divtest.innerHTML =
                '<div class="col-sm-5 nopadding"> ' +
                '<div class="form-group"> ' +
                '<label class="col-sm-5 col-lg-4 control-label">Track Code *</label> ' +
                '<div class="col-sm-3 col-lg-5 controls"> {!! Form::number("new_code[]",null,["placeholder"=>"Track Code","class"=>"form-control input-lg","required" => "required"]) !!}<span class="help-inline">Enter a new code for track</span><br><br> </div> </div> </div> '+
                '<div class="col-sm-6 nopadding"> ' +
                '<div class="form-group"> <div class="input-group"> <label class="col-sm-5 col-lg-4 control-label">Select Operator for that track *</label> ' +
                '<div class="col-sm-3 col-lg-5 controls"><select class="form-control chosen" name="new_operator_id[]" required>'+
                    @foreach ($operators as $key => $value)
                    '  <option value="{{$value->id}}">{{ $value->country->country }}-{{ $value->name }}</option>'+
                    @endforeach
                  '</select></div>' +
                '<div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_new_field('+ room +');"> ' +
                '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button> </div> </div> </div> </div> <div class="clear"></div> </div>';
        objTo.append(divtest);
    }
    function remove_new_field(rid) {
        $('.removeclass'+rid).remove();
    }

    function remove_item(id) {
        document.getElementById('remove_item'+id).value = id ;
        deleted_items = deleted_items.concat(id) ;
        $('.mainchoices'+id).remove();
        document.getElementById('items_removed').value = deleted_items ;
    }
</script>
<script>
    $('#album').addClass('active');
    $('#album-index').addClass('active');
</script>
@stop
