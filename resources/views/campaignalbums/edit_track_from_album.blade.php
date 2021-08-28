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
                    <h3><i class="fa fa-bars"></i>Edit Track Form</h3>
                    <div class="box-tool">
                        <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                        <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    {!! Form::open(["url"=>"campaigntrack/$track->id",'class'=>'form-horizontal','files'=>'true',"method"=>"patch"]) !!}
                    {!! Form::hidden('album_type',$track->album->type->id) !!}
                    {!! Form::hidden('album_id',$track->album->id) !!}


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Track name *</label>
                        <div class="col-sm-9 col-lg-10 controls">
                            {!! Form::text('title',$track->title,['placeholder'=>'track Name','class'=>'form-control input-lg','required' => 'required']) !!}
                            <span class="help-inline">Enter a new track name</span><br><br>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">{{$track->album->type->type}}</label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                @if($track->album->type->type=="Audio")
                                    <audio controls>
                                        <source src="{{url($track->track_file)}}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                @elseif($track->album->type->type=="Video")
                                    <video width="320" height="240" controls>
                                        <source src="{{url($track->track_file)}}" type="video/mp4">
                                        Your browser does not support the video element.
                                    </video>
                                @endif

                                <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-default btn-file"><span class="fileupload-new">Select Track</span>
                                        <span class="fileupload-exists">Change</span>
                                        {!! Form::file('track_file') !!}</span>
                                    <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                                </div>
                            </div>
                            <span class="label label-important">NOTE!</span>
                            <span>Only extension supported for audio .wav or .mp3 ,and for videos mp4, upload max file size 10M</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Album *</label>
                        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                            {!! Form::select('album_id',$albums,$track->album->id,['class'=>'form-control chosen', 'required'=>'required']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Subscription Text </label>
                        <div class="col-sm-9 col-lg-10 controls">
                            {!! Form::text('subscription_txt',$track->subscription_txt,['placeholder'=>'Subscription Text','class'=>'form-control input-lg']) !!}
                            <span class="help-inline">Edit a new subscription txt</span><br><br>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Track Background image</label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                    <img src="{{url($track->background_image)}}" style="width: 200px; height: 150px;" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-default btn-file"><span class="fileupload-new">Select image</span>
                                        <span class="fileupload-exists">Change</span>
                                        {!! Form::file('background_image') !!}</span>
                                    <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                                </div>
                            </div>
                            <span class="label label-important">NOTE!</span>
                            <span>Only extension supported jpg, png, and jpeg</span>
                        </div>
                    </div>

                    @if($track->album->type->type=="Video")
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Track Poster image</label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                    <img src="{{url($track->track_poster)}}" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-default btn-file"><span class="fileupload-new">Select image</span>
                                        <span class="fileupload-exists">Change</span>
                                        {!! Form::file('track_poster') !!}</span>
                                    <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                                </div>
                            </div>
                            <span class="label label-important">NOTE!</span>
                            <span>Only extension supported jpg, png, and jpeg</span>
                        </div>
                    </div>
                    @endif


                    <div class="btn-toolbar pull-right">
                        <div class="btn-group">
                            <a class="btn btn-circle btn-success show-tooltip" title="" onclick="new_field();" data-original-title="Add new record"><i class="fa fa-plus"></i></a>
                        </div>
                    </div><br>
                    {!! Form::hidden('items_removed[]','',["id"=>"items_removed"]) !!}
                    {!! Form::hidden('items_added[]','',["id"=>"items_added"]) !!}
                    {{--<input type="hidden" name="removed_items[]" value="" id="remove_item">--}}
                    @for($i=0;$i<count($op_tr);$i++)
                    <div class="form-group mainchoices{{$op_tr[$i]->operator_track_id}}">
                        <div class="col-sm-5 nopadding">
                            <div class="form-group">
                                <label class="col-sm-5 col-lg-4 control-label">Track Code *</label>
                                <div class="col-sm-3 col-lg-5 controls">
                                    {!! Form::number('code[]',$op_tr[$i]->code,['placeholder'=>'Track Code','class'=>'form-control input-lg','required' => 'required']) !!}
                                    <span class="help-inline">Enter a new code for track</span><br><br>
                                </div>
                            </div>
                        </div>
                        {!! Form::hidden('removed_items[]','',["id"=>"remove_item".$op_tr[$i]->operator_track_id]) !!}
                        {!! Form::hidden('operator_track_id[]',$op_tr[$i]->operator_track_id) !!}
                        <div class="col-sm-6 nopadding">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="col-sm-5 col-lg-4 control-label">Select Operator for that track *</label>
                                    <div class="col-sm-3 col-lg-5 controls">
                                      <select class="form-control chosen" name="operator_id[]" required>
                                        @foreach ($operators as $key => $value)
                                          <option value="{{$value->id}}" @if($value->id == $op_tr[$i]->operator_id) selected @endif>{{ $value->country->country }}-{{ $value->name }}</option>
                                        @endforeach
                                      </select>
                                        {{-- {!! Form::select('operator_id[]',$operators,$op_tr[$i]->operator_id,['class'=>'form-control chosen', 'required'=>'required']) !!} --}}
                                    </div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-danger" type="button" onclick="remove_item('{{$op_tr[$i]->operator_track_id}}');"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    @endfor
                    <div id="new_field">
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
