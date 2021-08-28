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
		<li><a href="{{ URL::to('mediaspecsvideo?return='.$return) }}">{{ $pageTitle }}</a></li>
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

		 {!! Form::open(array('url'=>'mediaspecsvideo/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-6">
						<fieldset><legend> General Specifications </legend>
				
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
									<label for="Content Category" class=" control-label col-md-4 text-left"> Content Category <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='cont_category_id' rows='5' id='cont_category_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Content Type" class=" control-label col-md-4 text-left"> Content Type <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='cont_type_id' rows='5' id='cont_type_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> </fieldset>
			</div>

			<div class="col-md-6">
						<fieldset><legend> Technical Specifications </legend>
				
								  <div class="form-group  " >
									<label for="Media Extension" class=" control-label col-md-4 text-left"> Media Extension <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='cont_media_format_id' rows='5' id='cont_media_format_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Video Dimensions" class=" control-label col-md-4 text-left"> Video Dimensions <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='cont_video_image_size_id' rows='5' id='cont_video_image_size_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Video Frame Rate" class=" control-label col-md-4 text-left"> Video Frame Rate <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='cont_video_frame_rate_id' rows='5' id='cont_video_frame_rate_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Video Format" class=" control-label col-md-4 text-left"> Video Format <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='cont_video_format_id' rows='5' id='cont_video_format_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Video Pixel Aspect Ratio" class=" control-label col-md-4 text-left"> Video Pixel Aspect Ratio <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='cont_video_pixel_aspect_ratio_id' rows='5' id='cont_video_pixel_aspect_ratio_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Audio Sample Rate" class=" control-label col-md-4 text-left"> Audio Sample Rate <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='cont_audio_sample_rate_id' rows='5' id='cont_audio_sample_rate_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Audio Bit Rate" class=" control-label col-md-4 text-left"> Audio Bit Rate <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='cont_audio_bit_rate_id' rows='5' id='cont_audio_bit_rate_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Audio Channel" class=" control-label col-md-4 text-left"> Audio Channel <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='cont_audio_channel_id' rows='5' id='cont_audio_channel_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Media File Size" class=" control-label col-md-4 text-left"> Media File Size <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='cont_media_file_size_id' rows='5' id='cont_media_file_size_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Video Duration" class=" control-label col-md-4 text-left"> Video Duration </label>
									<div class="col-md-6">
									  {!! Form::text('video_duration', $row['video_duration'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
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
					<button type="button" onclick="location.href='{{ URL::to('mediaspecsvideo?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		$("#country_id").jCombo("{{ URL::to('mediaspecsvideo/comboselect?filter=tb_countries:id:country') }}",
		{  selected_value : '{{ $row["country_id"] }}' });
		
		$("#operators_id").jCombo("{{ URL::to('mediaspecsvideo/comboselect?filter=tb_operators:id:name') }}&parent=country_id:",
		{  parent: '#country_id', selected_value : '{{ $row["operators_id"] }}' });
		
		$("#cont_category_id").jCombo("{{ URL::to('mediaspecsvideo/comboselect?filter=specs_cont_categories:id:category_title') }}",
		{  selected_value : '{{ $row["cont_category_id"] }}' });
		
		$("#cont_type_id").jCombo("{{ URL::to('mediaspecsvideo/comboselect?filter=cont_types:id:cont_type_title') }}",
		{  selected_value : '{{ $row["cont_type_id"] }}' });
		
		$("#cont_media_format_id").jCombo("{{ URL::to('mediaspecsvideo/comboselect?filter=specs_cont_media_formats:id:media_format_title') }}&parent=cont_type_id:",
		{  parent: '#cont_type_id', selected_value : '{{ $row["cont_media_format_id"] }}' });
		
		$("#cont_video_image_size_id").jCombo("{{ URL::to('mediaspecsvideo/comboselect?filter=specs_cont_video_image_sizes:id:video_image_size') }}",
		{  selected_value : '{{ $row["cont_video_image_size_id"] }}' });
		
		$("#cont_video_frame_rate_id").jCombo("{{ URL::to('mediaspecsvideo/comboselect?filter=specs_cont_video_frame_rates:id:video_frame_rate_title') }}",
		{  selected_value : '{{ $row["cont_video_frame_rate_id"] }}' });
		
		$("#cont_video_format_id").jCombo("{{ URL::to('mediaspecsvideo/comboselect?filter=specs_cont_video_formats:id:video_format_title') }}",
		{  selected_value : '{{ $row["cont_video_format_id"] }}' });
		
		$("#cont_video_pixel_aspect_ratio_id").jCombo("{{ URL::to('mediaspecsvideo/comboselect?filter=specs_cont_video_pixel_aspect_ratios:id:video_pixel_aspect_ratio_title') }}",
		{  selected_value : '{{ $row["cont_video_pixel_aspect_ratio_id"] }}' });
		
		$("#cont_audio_sample_rate_id").jCombo("{{ URL::to('mediaspecsvideo/comboselect?filter=specs_cont_audio_sample_rate:id:sample_rate_title') }}",
		{  selected_value : '{{ $row["cont_audio_sample_rate_id"] }}' });
		
		$("#cont_audio_bit_rate_id").jCombo("{{ URL::to('mediaspecsvideo/comboselect?filter=specs_cont_audio_bit_rate:id:bit_rate_title') }}",
		{  selected_value : '{{ $row["cont_audio_bit_rate_id"] }}' });
		
		$("#cont_audio_channel_id").jCombo("{{ URL::to('mediaspecsvideo/comboselect?filter=specs_cont_audio_channels:id:channel_title') }}",
		{  selected_value : '{{ $row["cont_audio_channel_id"] }}' });
		
		$("#cont_media_file_size_id").jCombo("{{ URL::to('mediaspecsvideo/comboselect?filter=specs_cont_media_file_sizes:id:file_size_title') }}",
		{  selected_value : '{{ $row["cont_media_file_size_id"] }}' });
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop