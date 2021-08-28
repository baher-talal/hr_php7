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
		<li><a href="{{ URL::to('aggregators?return='.$return) }}">{{ $pageTitle }}</a></li>
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

		 {!! Form::open(array('url'=>'aggregators/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> Aggregators</legend>

								  <div class="form-group hidethis " style="display:none;">
									<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
									<div class="col-md-6">
									  {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Aggregator Name" class=" control-label col-md-4 text-left"> Aggregator Name <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('aggregator_name', $row['aggregator_name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Aggregator Phone" class=" control-label col-md-4 text-left"> Aggregator Phone <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('aggregator_phone', $row['aggregator_phone'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number'   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Aggregator Mobile" class=" control-label col-md-4 text-left"> Aggregator Mobile <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('aggregator_mobile', $row['aggregator_mobile'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number'   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Aggregator Post Office" class=" control-label col-md-4 text-left"> Aggregator Post Office <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('aggregator_post_office', $row['aggregator_post_office'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Aggregator Email" class=" control-label col-md-4 text-left"> Aggregator Email <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('aggregator_email', $row['aggregator_email'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'email'   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
                  <div class="form-group  " >
                  <label for="Phone" class=" control-label col-md-4 text-left"> Password <span class="asterix"> * </span></label>
                  <div class="col-md-6">
                    <input type="password" name="aggregator_password" value="" class="form-control" autocomplete="off"> 
                   </div>
                   <div class="col-md-2">

                   </div>
                  </div>
								  <div class="form-group  " >
									<label for="Aggregator Address" class=" control-label col-md-4 text-left"> Aggregator Address <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('aggregator_address', $row['aggregator_address'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Aggregator Admin" class=" control-label col-md-4 text-left"> Aggregator Admin </label>
									<div class="col-md-6">
									  {!! Form::text('aggregator_admin', $row['aggregator_admin'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group hidethis " style="display:none;">
									<label for="Aggregator Join Date" class=" control-label col-md-4 text-left"> Aggregator Join Date </label>
									<div class="col-md-6">
									  {!! Form::text('aggregator_join_date', $row['aggregator_join_date'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group hidethis " style="display:none;">
									<label for="Created" class=" control-label col-md-4 text-left"> Created </label>
									<div class="col-md-6">
									  {!! Form::text('created_at', $row['created_at'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div> </fieldset>
			</div>




			<div style="clear:both"></div>


				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('aggregators?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>

				  </div>

		 {!! Form::close() !!}
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
@stop
