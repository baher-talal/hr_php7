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
		<li><a href="{{ URL::to('deductions?return='.$return) }}">{{ $pageTitle }}</a></li>
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

		 {!! Form::open(array('url'=>'deductions/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> deductions</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
									<div class="col-md-6">
									  {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Employee" class=" control-label col-md-4 text-left"> Employee <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='user_id' rows='5' id='user_id' class='select2 ' required  ></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Deducation Period" class=" control-label col-md-4 text-left"> Deducation Period <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('deducation_period', $row['deducation_period'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
									 </div> 
									 <div class="col-md-2">
									 	<a href="#" data-toggle="tooltip" placement="left" class="tips" title="number of day(s)"><i class="icon-question2"></i></a>
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Date" class=" control-label col-md-4 text-left"> Date <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('date', $row['date'],array('class'=>'form-control date')) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Month" class=" control-label col-md-4 text-left"> Month <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='month' rows='5' id='month' class='select2 ' required  ></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Year" class=" control-label col-md-4 text-left"> Year <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='year' rows='5' id='year' class='select2 ' required  ></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Reason" class=" control-label col-md-4 text-left"> Reason <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='reason_id' rows='5' id='reason_id' class='select2 ' required  ></select> 
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
					<button type="button" onclick="location.href='{{ URL::to('deductions?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		$("#user_id").jCombo("{{ URL::to('deductions/comboselect?filter=tb_users:id:first_name|last_name') }}",
		{  selected_value : '{{ $row["user_id"] }}' });
		
		$("#month").jCombo("{{ URL::to('deductions/comboselect?filter=tb_months:id:month') }}",
		{  selected_value : '{{ $row["month"] }}' });
		
		$("#year").jCombo("{{ URL::to('deductions/comboselect?filter=tb_years:id:year') }}",
		{  selected_value : '{{ $row["year"] }}' });
		
		$("#reason_id").jCombo("{{ URL::to('deductions/comboselect?filter=tb_reasons:id:reason') }}",
		{  selected_value : '{{ $row["reason_id"] }}' });
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop