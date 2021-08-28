@extends('template')

@section('page_title')
    Operators - Tracks
@stop

@section('content')
    @include('errors')
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

                    {!! Form::open(["url"=>"operator_track/$operator_track->id",'class'=>'form-horizontal','method'=>'patch']) !!}
                    <h3>Edit code and operator</h3><br><br>
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
                            {!! Form::select('operator_id',$operators,$operator_track->operator->id,['class'=>'form-control chosen', 'required'=>'required']) !!}
                        </div>
                    </div>

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


@stop
@section('script')
    <script>
        $('#operator-track').addClass('active');
        $('#operator_track-index').addClass('active');
    </script>
@stop