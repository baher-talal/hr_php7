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
		<li><a href="{{ URL::to('audiotracks?return='.$return) }}">{{ $pageTitle }}</a></li>
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

		 {!! Form::open(array('url'=>'audiotracks/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
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
									<label for="Provider Id" class=" control-label col-md-4 text-left"> Provider Id <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='provider_id' rows='5' id='provider_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Original Content Id" class=" control-label col-md-4 text-left"> Original Content Id <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='original_content_id' rows='5' id='original_content_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Country Id" class=" control-label col-md-4 text-left"> Country Id <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='country_id' rows='5' id='country_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Operators Id" class=" control-label col-md-4 text-left"> Operators Id <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='operators_id' rows='5' id='operators_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Cont Categories Id" class=" control-label col-md-4 text-left"> Cont Categories Id <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='cont_categories_id' rows='5' id='cont_categories_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div> </fieldset>
			</div>

			<div class="col-md-6">
						<fieldset><legend> Technical Specifications </legend>

								  <div class="form-group  " >
									<label for="Sound Title" class=" control-label col-md-4 text-left"> Sound Title <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('sound_title', $row['sound_title'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Sound Path" class=" control-label col-md-4 text-left"> Sound Path </label>
									<div class="col-md-6">
									  <input  type='file' name='sound_path' id='sound_path' accept='.mp3, .wav' @if($row['sound_path'] =='') class='required' @endif style='width:150px !important;'  />
					 	<div >
						{!! SiteHelpers::showUploadedFile($row['sound_path'],'/uploads/media/') !!}

						</div>

									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group hidethis " style="display:none;">
									<label for="Sound Meta Data" class=" control-label col-md-4 text-left"> Sound Meta Data </label>
									<div class="col-md-6">
									  {!! Form::text('sound_meta_data', $row['sound_meta_data'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
						 </fieldset>
			</div>




			<div style="clear:both"></div>


				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('audiotracks?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>

				  </div>

		 {!! Form::close() !!}
	</div>
</div>
</div>
</div>
   <script type="text/javascript">
	$(document).ready(function() {


		$("#provider_id").jCombo("{{ URL::to('audiotracks/comboselect?filter=providers:id:provider_name') }}",
		{  selected_value : '{{ $row["provider_id"] }}' });

		$("#original_content_id").jCombo("{{ URL::to('audiotracks/comboselect?filter=original_contents:id:original_title') }}&parent=provider_id:",
		{  parent: '#provider_id', selected_value : '{{ $row["original_content_id"] }}' });

		$("#country_id").jCombo("{{ URL::to('audiotracks/comboselect?filter=tb_countries:id:country') }}",
		{  selected_value : '{{ $row["country_id"] }}' });

		$("#operators_id").jCombo("{{ URL::to('audiotracks/comboselect?filter=tb_operators:id:name') }}&parent=country_id:",
		{  parent: '#country_id', selected_value : '{{ $row["operators_id"] }}' });

		$("#cont_categories_id").jCombo("{{ URL::to('audiotracks/comboselect?filter=specs_cont_categories:id:category_title') }}",
		{  selected_value : '{{ $row["cont_categories_id"] }}' });


		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();
			return false;
		});

	});
	</script>
@stop
