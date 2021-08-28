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
		<li><a href="{{ URL::to('companies?return='.$return) }}">{{ $pageTitle }}</a></li>
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

		 {!! Form::open(array('url'=>'companies/save?return='.$return, 'class'=>'form-vertical','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-3">
						<fieldset><legend> Basic information</legend>
				
								  <div class="form-group hidethis " style="display:none;">
									<label for="ipt" class=" control-label "> Id    </label>
									  {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
								  </div> 
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> Provider Type    </label>
									  <select name='provider_type_id' rows='5' id='provider_type_id' class='select2 '   ></select>
								  </div> 
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> Company Name  <span class="asterix"> * </span>  </label>
									  {!! Form::text('company_name', $row['company_name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
								  </div> 
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> Phone    </label>
									  {!! Form::text('company_phone', $row['company_phone'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
								  </div> 
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> Post Office    </label>
									  {!! Form::text('company_post_office', $row['company_post_office'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
								  </div> 
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> Address    </label>
									  {!! Form::text('company_address', $row['company_address'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
								  </div> 
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> Admin Email    </label>
									  {!! Form::text('company_admin_email', $row['company_admin_email'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
								  </div> 
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> Admin Name    </label>
									  {!! Form::text('company_admin_name', $row['company_admin_name'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
								  </div> 
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> Admin Mobile    </label>
									  {!! Form::text('company_admin_mobile', $row['company_admin_mobile'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
								  </div> </fieldset>
			</div>

			<div class="col-md-3">
						<fieldset><legend> Commercial Register Information</legend>
				
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> CR No  <span class="asterix"> * </span>  </label>
									  {!! Form::text('company_cr_no', $row['company_cr_no'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
								  </div> 
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> CR File  <span class="asterix"> * </span>  </label>
									  <input  type='file' name='company_cr_file' id='company_cr_file' @if($row['company_cr_file'] =='') class='required' @endif style='width:150px !important;'  />
					 	<div >
						{!! SiteHelpers::showUploadedFile($row['company_cr_file'],'uploads/docs') !!}

						</div>
					
								  </div> 
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> CR Release Date  <span class="asterix"> * </span>  </label>
									  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('company_cr_date', $row['company_cr_date'],array('class'=>'form-control date')) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
								  </div> </fieldset>
			</div>

			<div class="col-md-3">
						<fieldset><legend> Tax Card Information</legend>
				
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> TC No  <span class="asterix"> * </span>  </label>
									  {!! Form::text('company_tc_no', $row['company_tc_no'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
								  </div> 
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> TC File  <span class="asterix"> * </span>  </label>
									  <input  type='file' name='company_tc_file' id='company_tc_file' @if($row['company_tc_file'] =='') class='required' @endif style='width:150px !important;'  />
					 	<div >
						{!! SiteHelpers::showUploadedFile($row['company_tc_file'],'uploads/docs') !!}

						</div>
					
								  </div> </fieldset>
			</div>

			<div class="col-md-3">
						<fieldset><legend> Agent Information</legend>
				
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> Agent Name    </label>
									  {!! Form::text('company_agent_name', $row['company_agent_name'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
								  </div> 
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> Agent Signature File    </label>
									  <input  type='file' name='company_agent_file' id='company_agent_file' @if($row['company_agent_file'] =='') class='required' @endif style='width:150px !important;'  />
					 	<div >
						{!! SiteHelpers::showUploadedFile($row['company_agent_file'],'uploads/docs') !!}

						</div>
					
								  </div> </fieldset>
			</div>

			

		
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('companies?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		$("#provider_type_id").jCombo("{{ URL::to('companies/comboselect?filter=provider_types:id:provider_type_title') }}",
		{  selected_value : '{{ $row["provider_type_id"] }}' });
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop