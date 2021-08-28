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
                    <h3><i class="fa fa-bars"></i>Link Operator with Track</h3>
                    <div class="box-tool">
                        <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                        <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="box-content">

                    {!! Form::open(["url"=>"operator_track",'class'=>'form-horizontal']) !!}
                    <h3>Track Content</h3><br><br>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Track Type</label>
                        <div class="col-sm-9 col-lg-10 label-p">
                            {{$track->album->type->type}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Track Name</label>
                        <div class="col-sm-9 col-lg-10 label-p">
                            {{$track->title}}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Album background image</label>
                            <div class="col-sm-9 col-lg-10 controls">
                                <img src="{{url($track->album->background_image)}}"  width="300px" height="300px">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Track</label>
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
                            </div>
                        </div>
                    </div>
                    <hr style="height:1px;border:none;color:#333;background-color:#333;width: 50%" />
                    <h3>Add code and operator</h3><br><br>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Track Code *</label>
                        <div class="col-sm-9 col-lg-10 controls">
                            {!! Form::number('code',null,['placeholder'=>'Track Code','class'=>'form-control input-lg','required' => 'required']) !!}
                            <span class="help-inline">Enter a new code for track</span><br><br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Select Operator for that track *</label>
                        <div class="col-sm-9 col-lg-10 controls">
                          <select class="form-control chosen" name="operator_id" required>
                            @foreach ($operators as $key => $value)
                              <option value="{{$value->id}}">{{ $value->country->country }}-{{ $value->name }}</option>
                            @endforeach
                          </select>
                            {{-- {!! Form::select('operator_id',$operators,null,['class'=>'form-control chosen', 'required'=>'required']) !!} --}}
                        </div>
                    </div>
                            {!! Form::hidden('track_id',$track->id) !!}

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
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
</div>
<script>
    $('#operator-track').addClass('active');
    $('#operator_track-index').addClass('active');
</script>
@stop
