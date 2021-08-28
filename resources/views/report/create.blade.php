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
		<li><a href="{{ URL::to('rbt?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>

    </div>

 	<div class="page-content-wrapper">

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
      @if(Session::has('message'))
      {!! Session::get('message') !!}
      @endif
		</ul>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>Add report form</h3>
                    <div class="box-tool">
                        <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                        <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    <form method = 'POST' class="form-horizontal" action = '{!!url("report/excel")!!}' enctype="multipart/form-data">
                        <?php
                            $months = months();
                            $years = years();
                        ?>
                        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>

                        <div class="form-group">
                          <label class="col-sm-3 col-lg-2 control-label">Years Select </label>
                          <div class="col-sm-9 col-lg-10 controls">
                             <select class="form-control chosen" data-placeholder="Choose a Years" name="year" tabindex="1" >
                                <option value=""></option>
                                @foreach($years as $year)
                                    <option value="{{$year}}" @if(date('Y') == $year) selected @endif>{{$year}}</option>
                                @endforeach
                             </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 col-lg-2 control-label">Months Select </label>
                          <div class="col-sm-9 col-lg-10 controls">
                             <select class="form-control chosen" data-placeholder="Choose a Months" name="month" tabindex="1" >
                                <option value=""></option>
                                @foreach($months as $index=>$month)
                                    <option value="{{$index+1}}" @if(date('m') == $index+1) selected @endif>{{$month}}</option>
                                @endforeach
                             </select>
                          </div>
                        </div>

                         <div class="form-group">
                          <label class="col-sm-3 col-lg-2 control-label">Excel file</label>
                          <div class="col-sm-9 col-lg-10 controls">
                             <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="input-group">
                                   <div class="form-control uneditable-input">
                                      <i class="fa fa-file fileupload-exists"></i>
                                      <span class="fileupload-preview"></span>
                                   </div>
                                   <div class="input-group-btn">
                                       <a class="btn bun-default btn-file">
                                           <span class="fileupload-new">Select file</span>
                                           <span class="fileupload-exists">Change</span>
                                           <input type="file" name="fileToUpload" required class="file-input">
                                       </a>
                                        <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                                   </div>
                                </div>
                                <a href="{{url('report/downloadSample')}}">Download Sample</a>
                             </div>
                          </div>
                        </div>

                       <div class="form-group">
                          <label class="col-sm-3 col-lg-2 control-label">Operators Select *</label>
                          <div class="col-sm-9 col-lg-10 controls">
                             <select class="form-control chosen" data-placeholder="Choose a Operators" name="operator_id" tabindex="1" required>
                                <option value=""></option>
                               @foreach($operators as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                             </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 col-lg-2 control-label">Aggregators Select</label>
                          <div class="col-sm-9 col-lg-10 controls">
                             <select class="form-control chosen" data-placeholder="Choose a Aggregators" name="aggregator_id" tabindex="1" >
                                <option value=""></option>
                                @foreach($aggregators as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                             </select>
                          </div>
                        </div>

                         <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
	</div>
</div>
</div>
</div>
   <script type="text/javascript">
	$(document).ready(function() {

  		$("#operator_id").jCombo("{{ URL::to('rbt/comboselect?filter=tb_operators:id:name') }}",
  		{  selected_value : '{{ $row["operator_id"] }}' });

  		$("#aggregator_id").jCombo("{{ URL::to('rbt/comboselect?filter=aggregators:id:aggregator_name') }}",
  		{  selected_value : '{{ $row["aggregator_id"] }}' });

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();
			return false;
		});

	});
	</script>
@stop
