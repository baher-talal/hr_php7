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
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('providerestablishments?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('providerestablishments/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content"> 	


	
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Type</td>
						<td>{!! SiteHelpers::gridDisplayView($row->provider_type_id,'provider_type_id','1:provider_types:id:provider_type_title') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Name</td>
						<td>{{ $row->provider_name }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Address</td>
						<td>{{ $row->provider_address }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Po No</td>
						<td>{{ $row->provider_po_no }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Email</td>
						<td>{{ $row->provider_email }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Mobile</td>
						<td>{{ $row->provider_mobile }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Phone</td>
						<td>{{ $row->provider_phone }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Bank Account Name</td>
						<td>{{ $row->provider_bank_account_name }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Bank Account No</td>
						<td>{{ $row->provider_bank_account_no }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Admin Name</td>
						<td>{{ $row->provider_admin_name }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Admin Email</td>
						<td>{{ $row->provider_admin_email }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Admin Mobile</td>
						<td>{{ $row->provider_admin_mobile }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Status</td>
						<td>{{ $row->provider_status }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Joining Date</td>
						<td>{{ $row->provider_joining_date }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Commercial Register No</td>
						<td>{{ $row->provider_commercial_register_no }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Commercial Register Date</td>
						<td>{{ $row->provider_commercial_register_date }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Commercial Register File</td>
						{{-- <td>{!! SiteHelpers::showUploadedFile($row->provider_commercial_register_file,'/uploads/images/') !!} </td> --}}
						<td><img height="100px" src="{{url("uploads/images/$row->provider_commercial_register_file")}}" alt=""></td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tax Card No</td>
						<td>{{ $row->provider_tax_card_no }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TC File</td>
						{{-- <td>{!! SiteHelpers::showUploadedFile($row->provider_tax_card_file,'/uploads/images/') !!} </td> --}}
						<td><img height="100px" src="{{url("uploads/images/$row->provider_tax_card_file")}}" alt=""></td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Agent Name</td>
						<td>{{ $row->provider_agent_name }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Agent File</td>
						{{-- <td>{!! SiteHelpers::showUploadedFile($row->provider_agent_file,'/uploads/images/') !!} </td> --}}
						<td><img height="100px" src="{{url("uploads/images/$row->provider_agent_file")}}" alt=""></td>

					</tr>
				
		</tbody>	
	</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop