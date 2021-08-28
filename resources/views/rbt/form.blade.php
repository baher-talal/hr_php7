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
		</ul>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content">

		 {!! Form::open(array('url'=>'rbt/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> Rbt</legend>

								  <div class="form-group hidethis " style="display:none;">
									<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
									<div class="col-md-6">
									  {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Track Title" class=" control-label col-md-4 text-left"> Track Title <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('track_title_en', $row['track_title_en'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group hidethis " style="display:none;">
									<label for="Track Title Ar" class=" control-label col-md-4 text-left"> Track Title Ar </label>
									<div class="col-md-6">
									  {!! Form::text('track_title_ar', $row['track_title_ar'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group hidethis " style="display:none;" >
									<label for="Artist Name" class=" control-label col-md-4 text-left"> Artist Name <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('artist_name_en', $row['artist_name_en'],array('class'=>'form-control', 'placeholder'=>'' )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group hidethis " style="display:none;">
									<label for="Artist Name Ar" class=" control-label col-md-4 text-left"> Artist Name Ar </label>
									<div class="col-md-6">
									  {!! Form::text('artist_name_ar', $row['artist_name_ar'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group hidethis " style="display:none;">
									<label for="Album Name" class=" control-label col-md-4 text-left"> Album Name </label>
									<div class="col-md-6">
									  {!! Form::text('album_name', $row['album_name'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Code" class=" control-label col-md-4 text-left"> Code <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('code', $row['code'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Social Media Code" class=" control-label col-md-4 text-left"> Social Media Code </label>
									<div class="col-md-6">
									  {!! Form::text('social_media_code', $row['social_media_code'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  hidethis " style="display:none;" >
									<label for="Owner" class=" control-label col-md-4 text-left"> Owner </label>
									<div class="col-md-6">
									  {!! Form::text('owner', $row['owner'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Track File" class=" control-label col-md-4 text-left"> Track File </label>
									<div class="col-md-6">
									  <input  type='file' name='track_file' id='track_file' @if($row['track_file'] =='') class='required' @endif style='width:150px !important;'  />
					 	<div >
						{!! SiteHelpers::showUploadedFile($row['track_file'],'') !!}

						</div>

									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  hidethis " style="display:none;" >
									<label for="Type" class=" control-label col-md-4 text-left"> Type <span class="asterix"> * </span></label>
									<div class="col-md-6">

					<?php $type = explode(',',$row['type']);
					$type_opt = array( '0' => 'Old Excel' ,  '1' => 'NewExcel' , ); ?>
					<select name='type' rows='5' required  class='select2 '  >
						<?php
						foreach($type_opt as $key=>$val)
						{
							echo "<option  value ='$key' ".($row['type'] == $key ? " selected='selected' " : '' ).">$val</option>";
						}
						?></select>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Provider" class=" control-label col-md-4 text-left"> Provider </label>
									<div class="col-md-6">
									  <select name='provider_id' rows='5' id='provider_id' class='select2 '   ></select>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
                  <div class="form-group  " >
                      <label for="countries" class=" control-label col-md-4 text-left"> Operator <span class="asterix"> * </span></label>
                      <div class="col-md-6">
                          <select name="operator_id" id='countries' rows='5' required  class='select2'  >
                              <option  value ='' >--Please Select--</option>
                              @foreach ($operators as $key => $val)
                              <option  value ='{{$val->id}}' @if($row["operator_id"] == $val->id) selected @endif >{{ $val->country->country }}-{{$val->name}}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="col-md-2">

                      </div>
                  </div>

								  <div class="form-group  " >
									<label for="Occasion " class=" control-label col-md-4 text-left"> Occasion </label>
									<div class="col-md-6">
									  <select name='occasion_id' rows='5' id='occasion_id' class='select2 '   ></select>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Aggregator" class=" control-label col-md-4 text-left"> Aggregator </label>
									<div class="col-md-6">
									  <select name='aggregator_id' rows='5' id='aggregator_id' class='select2 '   ></select>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group hidethis " style="display:none;">
									<label for="Created At" class=" control-label col-md-4 text-left"> Created At </label>
									<div class="col-md-6">
									  {!! Form::text('created_at', $row['created_at'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group hidethis " style="display:none;">
									<label for="Updated At" class=" control-label col-md-4 text-left"> Updated At </label>
									<div class="col-md-6">
									  {!! Form::text('updated_at', $row['updated_at'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
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
					<button type="button" onclick="location.href='{{ URL::to('rbt?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>

				  </div>

		 {!! Form::close() !!}
	</div>
</div>
</div>
</div>
   <script type="text/javascript">
	$(document).ready(function() {


		$("#provider_id").jCombo("{{ URL::to('rbt/comboselect?filter=providers:id:provider_name') }}",
		{  selected_value : '{{ $row["provider_id"] }}' });

		$("#operator_id").jCombo("{{ URL::to('rbt/comboselect?filter=tb_operators:id:name') }}",
		{  selected_value : '{{ $row["operator_id"] }}' });

		$("#occasion_id").jCombo("{{ URL::to('rbt/comboselect?filter=occasions:id:occasion_name') }}",
		{  selected_value : '{{ $row["occasion_id"] }}' });

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
