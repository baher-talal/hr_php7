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
                    <h3><i class="fa fa-bars"></i>Add Track Form</h3>
                    <div class="box-tool">
                        <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                        <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    {!! Form::open(["url"=>"campaignalbums/add/track",'class'=>'form-horizontal','files'=>'true']) !!}
                    {!! Form::hidden('album_id',$id) !!}
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Track Type</label>
                        <div class="col-sm-9 col-lg-10 text-danger">
                            {!! $album->type->type !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Album background image</label>
                            <div class="col-sm-9 col-lg-10 controls">
                                <img src="{{url('uploads/campaign/albums/'.$album->background_image)}}"  width="300px" height="300px">
                            </div>
                        </div>
                        <label class="col-sm-3 col-lg-2 control-label">Track *</label>
                        <div class="col-sm-9 col-lg-10 controls">
                            {!! Form::text('title',null,['placeholder'=>'Track Name','class'=>'form-control input-lg','required' => 'required']) !!}
                            <span class="help-block">Enter a new track name</span><br><br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Track file *</label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-default btn-file"><span class="fileupload-new">Select Track *</span>
                                        <span class="fileupload-exists">Change</span>
                                        {!! Form::file('track_file',['required'=>'required']) !!}</span>
                                    <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                                </div>
                            </div>
                            <span class="label label-important">NOTE!</span>
                            <span class="text-danger">Only extension supported for audio .wav or .mp3 ,and for videos mp4, upload max file size 10M</span>
                        </div>
                    </div>

                    <div class="form-group">
                          <label class="col-sm-3 col-lg-2 control-label">Subscription Text </label>
                           <div class="col-sm-9 col-lg-10 controls">
                            {!! Form::text('subscription_txt',null,['placeholder'=>'Subscription Text','class'=>'form-control input-lg']) !!}
                            <span class="help-block">Enter a new subscription txt</span><br><br>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Track Background image</label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">

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
                            <span class="text-danger">Only extension supported jpg, png, and jpeg</span>
                        </div>
                    </div>

                    @if($album->type->type == 'Video')
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Track Poster image</label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">

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
                            <span class="text-danger">Only extension supported jpg, png, and jpeg</span>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                            <div class="col-sm-5 nopadding">
                                <div class="form-group">
                                    <label class="col-sm-5 col-lg-4 control-label">Track Code *</label>
                                    <div class="col-sm-3 col-lg-5 controls">
                                        {!! Form::number('code[]',null,['placeholder'=>'Track Code','class'=>'form-control input-lg','required' => 'required']) !!}
                                        <span class="help-inline">Enter a new code for track</span><br><br>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 nopadding">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label class="col-sm-5 col-lg-4 control-label">Select Operator for that track *</label>
                                        <div class="col-sm-3 col-lg-5 controls">
                                            {{-- {!! Form::select('operator_id[]',$operators,null,['class'=>'form-control chosen', 'required'=>'required']) !!} --}}
                                            <select class="form-control chosen" name="operator_id[]" required>
                                              @foreach ($operators as $key => $value)
                                                <option value="{{$value->id}}">{{ $value->name }}</option>
                                              @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group-btn">
                                            <button class="btn btn-success" type="button"  onclick="new_field();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>

                        </div>
                    <div id="new_field">
                    </div>


                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                        </div>
                    </div>

                    </div>


                </div>

                {!! Form::close() !!}
            </div>
        </div>
	</div>
</div>
</div>
</div>
   <script type="text/javascript">
	$(document).ready(function() {



		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();
			return false;
		});

	});
	</script>
  <script>
      var room = 1;
      function new_field() {

          room++;
          var objTo = document.getElementById('new_field') ;
          var divtest = document.createElement("div");
          divtest.setAttribute("class", "form-group removeclass"+room);
          divtest.innerHTML =
                  '<div class="col-sm-5 nopadding"> ' +
                  '<div class="form-group"> ' +
                  '<label class="col-sm-5 col-lg-4 control-label">Track Code *</label> ' +
                  '<div class="col-sm-3 col-lg-5 controls"> {!! Form::number("code[]",null,["placeholder"=>"Track Code","class"=>"form-control input-lg","required" => "required"]) !!}<span class="help-inline">Enter a new code for track</span><br><br> </div> </div> </div> '+
                  '<div class="col-sm-6 nopadding"> ' +
                  '<div class="form-group"> <div class="input-group"> <label class="col-sm-5 col-lg-4 control-label">Select Operator for that track *</label> ' +
                  '<div class="col-sm-3 col-lg-5 controls"><select class="form-control chosen" name="operator_id[]" required>'+
                      @foreach ($operators as $key => $value)
                      '  <option value="{{$value->id}}">{{ $value->name }}</option>'+
                      @endforeach
                    '</select></div>' +
                  '<div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_new_field('+ room +');"> ' +
                  '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button> </div> </div> </div> </div> <div class="clear"></div> </div>';
          objTo.append(divtest);
      }
      function remove_new_field(rid) {
          $('.removeclass'+rid).remove();
      }

  </script>
@stop
