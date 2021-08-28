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
		<li><a href="{{ URL::to('audiometadata?return='.$return) }}">{{ $pageTitle }}</a></li>
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

		 {!! Form::open(array('url'=>'audiometadata/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> Audio Meta Data</legend>
				
								  <div class="form-group hidethis " style="display:none;">
									<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
									<div class="col-md-6">
									  {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Country" class=" control-label col-md-4 text-left"> Country <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='country_id' rows='5' id='country_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Operator" class=" control-label col-md-4 text-left"> Operator <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='operators_id' rows='5' id='operators_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Category" class=" control-label col-md-4 text-left"> Category <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='cont_categories_id' rows='5' id='cont_categories_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="File Size" class=" control-label col-md-4 text-left"> File Size <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='cont_media_file_sizes' rows='5' id='cont_media_file_sizes' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Sample Path" class=" control-label col-md-4 text-left"> Sample Path </label>
									<div class="col-md-6">
									  <input  type='file' name='track_sample_path' id='track_sample_path' @if($row['track_sample_path'] =='') class='required' @endif style='width:150px !important;'  />
					 	<div >
						{!! SiteHelpers::showUploadedFile($row['track_sample_path'],'/uploads/media/') !!}

						</div>
					
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Duration" class=" control-label col-md-4 text-left"> Duration <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('track_duration', $row['track_duration'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 <p style='margin-top:10px; color:#999'> If two digits, please separate them with a comma without space, sample (50,59). </p>
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
					<button type="button" onclick="location.href='{{ URL::to('audiometadata?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		$("#country_id").jCombo("{{ URL::to('audiometadata/comboselect?filter=tb_countries:id:country') }}",
		{  selected_value : '{{ $row["country_id"] }}' });
		
		$("#operators_id").jCombo("{{ URL::to('audiometadata/comboselect?filter=tb_operators:id:name') }}&parent=country_id:",
		{  parent: '#country_id', selected_value : '{{ $row["operators_id"] }}' });
		
		$("#cont_categories_id").jCombo("{{ URL::to('audiometadata/comboselect?filter=specs_cont_categories:id:category_title') }}",
		{  selected_value : '{{ $row["cont_categories_id"] }}' });
		
		$("#cont_media_file_sizes").jCombo("{{ URL::to('audiometadata/comboselect?filter=specs_cont_media_file_sizes:id:file_size_title') }}",
		{  selected_value : '{{ $row["cont_media_file_sizes"] }}' });
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop