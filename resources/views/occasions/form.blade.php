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
		<li><a href="{{ URL::to('occasions?return='.$return) }}">{{ $pageTitle }}</a></li>
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

		 {!! Form::open(array('url'=>'occasions/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> Occasions</legend>

								  <div class="form-group hidethis " style="display:none;">
									<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
									<div class="col-md-6">
									  {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Name" class=" control-label col-md-4 text-left"> Name <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('occasion_name', $row['occasion_name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Description" class=" control-label col-md-4 text-left"> Description </label>
									<div class="col-md-6">
									  <textarea name='occasion_description' rows='5' id='occasion_description' class='form-control '
				           >{{ $row['occasion_description'] }}</textarea>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Date" class=" control-label col-md-4 text-left"> Date <span class="asterix"> * </span></label>
									<div class="col-md-6">

				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('occasion_date', $row['occasion_date'],array('class'=>'form-control date')) !!}
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Category" class=" control-label col-md-4 text-left"> Category <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='category_id' rows='5' id='category_id' class='select2 ' required  ></select>
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
								  </div> </fieldset>
			</div>




			<div style="clear:both"></div>


				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('occasions?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>

				  </div>

		 {!! Form::close() !!}
	</div>
</div>
</div>
</div>
   <script type="text/javascript">
	$(document).ready(function() {


		$("#category_id").jCombo("{{ URL::to('occasions/comboselect?filter=cont_categories:id:cont_category_title') }}",
		{  selected_value : '{{ $row["category_id"] }}' });

		$("#country_id").jCombo("{{ URL::to('occasions/comboselect?filter=tb_countries:id:country') }}",
		{  selected_value : '{{ $row["country_id"] }}' });


		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();
			return false;
		});

	});
	</script>
@stop