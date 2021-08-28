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
		<li><a href="{{ URL::to('providerestablishments?return='.$return) }}">{{ $pageTitle }}</a></li>
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

		 {!! Form::open(array('url'=>'providerestablishments/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-3">
						<fieldset><legend> General</legend>

								  <div class="form-group hidethis " style="display:none;">
									<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
									<div class="col-md-6">
									  {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Type" class=" control-label col-md-4 text-left"> Type <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='provider_type_id' rows='5' id='provider_type_id' class='select2 ' required  >
									      @foreach($providerType as $types)
									        <option value="{{ $types->id }}">{{ $types->provider_type_title }}</option>
									      @endforeach

									  </select>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Name" class=" control-label col-md-4 text-left"> Name <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('provider_name', $row['provider_name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Address" class=" control-label col-md-4 text-left"> Address </label>
									<div class="col-md-6">
									  {!! Form::text('provider_address', $row['provider_address'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="PO No" class=" control-label col-md-4 text-left"> PO No </label>
									<div class="col-md-6">
									  {!! Form::text('provider_po_no', $row['provider_po_no'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Status" class=" control-label col-md-4 text-left"> Status <span class="asterix"> * </span></label>
									<div class="col-md-6">

					<input type='radio' name='provider_status' value ='1' checked required @if($row['provider_status'] == '1') checked="checked" @endif > Active
					<input type='radio' name='provider_status' value ='0' required @if($row['provider_status'] == '0') checked="checked" @endif > Inactive
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Joining Date" class=" control-label col-md-4 text-left"> Joining Date <span class="asterix"> * </span></label>
									<div class="col-md-6">

				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('provider_joining_date', $row['provider_joining_date'],array('class'=>'form-control date')) !!}
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Logo" class=" control-label col-md-4 text-left"> Logo </label>
									<div class="col-md-6">
									  <input  type='file' name='provider_logo' id='provider_logo' accept='.jpg, .png' @if($row['provider_logo'] =='') class='required' @endif style='width:150px !important;'  />
					 	<div >
						{!! SiteHelpers::showUploadedFile($row['provider_logo'],'/uploads/images/') !!}

						</div>

									 </div>
									 <div class="col-md-2">

									 </div>
								  </div> </fieldset>
			</div>

			<div class="col-md-3">
						<fieldset><legend> Contact</legend>

								  <div class="form-group  " >
									<label for="Email" class=" control-label col-md-4 text-left"> Email <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('provider_email', $row['provider_email'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'email'   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Mobile" class=" control-label col-md-4 text-left"> Mobile <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('provider_mobile', $row['provider_mobile'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Phone" class=" control-label col-md-4 text-left"> Phone <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('provider_phone', $row['provider_phone'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div> </fieldset>
			</div>

			<div class="col-md-3">
						<fieldset><legend> Bank and Legal</legend>

								  <div class="form-group  " >
									<label for="Account Name" class=" control-label col-md-4 text-left"> Account Name <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('provider_bank_account_name', $row['provider_bank_account_name'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Account No" class=" control-label col-md-4 text-left"> Account No <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('provider_bank_account_no', $row['provider_bank_account_no'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number'   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="C-Register No" class=" control-label col-md-4 text-left"> C-Register No <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('provider_commercial_register_no', $row['provider_commercial_register_no'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="C-Register Date" class=" control-label col-md-4 text-left"> C-Register Date <span class="asterix"> * </span></label>
									<div class="col-md-6">

				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('provider_commercial_register_date', $row['provider_commercial_register_date'],array('class'=>'form-control date')) !!}
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="C-Register File" class=" control-label col-md-4 text-left"> C-Register File </label>
									<div class="col-md-6">
									  <input  type='file' name='provider_commercial_register_file' id='provider_commercial_register_file' accept='.pdf, .jpg, .png' @if($row['provider_commercial_register_file'] =='') class='required' @endif style='width:150px !important;'  />
					 	<div >
						{!! SiteHelpers::showUploadedFile($row['provider_commercial_register_file'],'/uploads/images/') !!}

						</div>

									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Tax Card No" class=" control-label col-md-4 text-left"> Tax Card No <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('provider_tax_card_no', $row['provider_tax_card_no'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Tax Card File" class=" control-label col-md-4 text-left"> Tax Card File </label>
									<div class="col-md-6">
									  <input  type='file' name='provider_tax_card_file' id='provider_tax_card_file' accept='.pdf, .jpg, .png' @if($row['provider_tax_card_file'] =='') class='required' @endif style='width:150px !important;'  />
					 	<div >
						{!! SiteHelpers::showUploadedFile($row['provider_tax_card_file'],'/uploads/images/') !!}

						</div>

									 </div>
									 <div class="col-md-2">

									 </div>
								  </div> </fieldset>
			</div>

			<div class="col-md-3">
						<fieldset><legend> Admin and Agent</legend>

								  <div class="form-group  " >
									<label for="Admin Name" class=" control-label col-md-4 text-left"> Admin Name <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('provider_admin_name', $row['provider_admin_name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Admin Email" class=" control-label col-md-4 text-left"> Admin Email <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('provider_admin_email', $row['provider_admin_email'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'email'   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Admin Mobile" class=" control-label col-md-4 text-left"> Admin Mobile <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('provider_admin_mobile', $row['provider_admin_mobile'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number'   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Agent Name" class=" control-label col-md-4 text-left"> Agent Name </label>
									<div class="col-md-6">
									  {!! Form::text('provider_agent_name', $row['provider_agent_name'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Agent File" class=" control-label col-md-4 text-left"> Agent File </label>
									<div class="col-md-6">
									  <input  type='file' name='provider_agent_file' id='provider_agent_file' accept='.pdf, .jpg, .png' @if($row['provider_agent_file'] =='') class='required' @endif style='width:150px !important;'  />
					 	<div >
						{!! SiteHelpers::showUploadedFile($row['provider_agent_file'],'/uploads/images/') !!}

						</div>

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
					<button type="button" onclick="location.href='{{ URL::to('providerestablishments?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>

				  </div>

		 {!! Form::close() !!}
	</div>
</div>


<div class="alert alert-info">
  <strong>Note!</strong> The commercial register is valid for 90 days only.
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
