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
		<li><a href="{{ URL::to('report?return='.$return) }}">{{ $pageTitle }}</a></li>
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

		 {!! Form::open(array('url'=>'report/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> Report</legend>

              <div class="form-group hidethis " style="display:none;">
              <label for="Id" class=" control-label col-md-4 text-left"> Id </label>
              <div class="col-md-6">
                {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
               </div>
               <div class="col-md-2">

               </div>
              </div>
              <div class="form-group hidethis " style="display:none;">
              <label for="Id" class=" control-label col-md-4 text-left"> RbtId </label>
              <div class="col-md-6">
                {!! Form::text('rbt_id', $row['rbt_id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
               </div>
               <div class="col-md-2">

               </div>
              </div>
              <?php
                  $months = months();
                  $years = years();
              ?>


              <div class="form-group">
                <label class="col-sm-4 col-lg-4 control-label">Years Select <span class="asterix"> * </span></label>
                <div class="col-sm-6 col-lg-6 controls">
                   <select class="form-control chosen" data-placeholder="Choose a Years" name="year" tabindex="1" >
                      <option value=""></option>
                      @foreach($years as $year)
                          <option value="{{$year}}" {{($row['year'] == $year) ? ' selected' : ''}}>{{$year}}</option>
                      @endforeach
                   </select>
                </div>
                <div class="col-md-2">

                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-4 col-lg-4 control-label">Months Select <span class="asterix"> * </span></label>
                <div class="col-sm-6 col-lg-6 controls">
                   <select class="form-control chosen" data-placeholder="Choose a Months" name="month" tabindex="1" >
                      <option value=""></option>
                      @foreach($months as $index=>$month)
                          <option value="{{$index+1}}" {{($row['month'] == $index+1) ? ' selected' : ''}}>{{$month}}</option>
                      @endforeach
                   </select>
                </div>
                <div class="col-md-2">

                </div>
              </div>
								  <div class="form-group  " >
									<label for="Classification" class=" control-label col-md-4 text-left"> Classification <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('classification', $row['classification'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
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
									<label for="Rbt Name" class=" control-label col-md-4 text-left"> Rbt Name <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('rbt_name', $row['rbt_name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Download No" class=" control-label col-md-4 text-left"> Download No </label>
									<div class="col-md-6">
									  {!! Form::text('download_no', $row['download_no'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Total Revenue" class=" control-label col-md-4 text-left"> Total Revenue <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('total_revenue', $row['total_revenue'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Revenue Share" class=" control-label col-md-4 text-left"> Revenue Share <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('revenue_share', $row['revenue_share'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Operator Title" class=" control-label col-md-4 text-left"> Operator Title <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='operator_id' rows='5' id='operator_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Provider Title" class=" control-label col-md-4 text-left"> Provider Title <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='provider_id' rows='5' id='provider_id' class='select2 ' required  ></select>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Aggregator Title" class=" control-label col-md-4 text-left"> Aggregator Title </label>
									<div class="col-md-6">
									  <select name='aggregator_id' rows='5' id='aggregator_id' class='select2 '   ></select>
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
					<button type="button" onclick="location.href='{{ URL::to('report?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>

				  </div>

		 {!! Form::close() !!}
	</div>
</div>
</div>
</div>
   <script type="text/javascript">
	$(document).ready(function() {


		$("#operator_id").jCombo("{{ URL::to('report/comboselect?filter=tb_operators:id:name') }}",
		{  selected_value : '{{ $row["operator_id"] }}' });

		$("#provider_id").jCombo("{{ URL::to('report/comboselect?filter=providers:id:provider_name') }}",
		{  selected_value : '{{ $row["provider_id"] }}' });

		$("#aggregator_id").jCombo("{{ URL::to('report/comboselect?filter=aggregators:id:aggregator_name') }}",
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
