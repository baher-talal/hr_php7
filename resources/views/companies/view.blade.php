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
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('companies?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('companies/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content"> 	


	
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Provider Type</td>
						<td>{!! SiteHelpers::gridDisplayView($row->provider_type_id,'provider_type_id','1:provider_types:id:provider_type_title') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Company Name</td>
						<td>{{ $row->company_name }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Phone</td>
						<td>{{ $row->company_phone }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Post Office</td>
						<td>{{ $row->company_post_office }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Address</td>
						<td>{{ $row->company_address }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Commercial Register No</td>
						<td>{{ $row->company_cr_no }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Commercial Register Release Date</td>
						<td>{{ $row->company_cr_date }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Commercial Register File</td>
						<td>{{ $row->company_cr_file }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tax card No</td>
						<td>{{ $row->company_tc_no }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tax card File</td>
						<td>{{ $row->company_tc_file }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Agent Name</td>
						<td>{{ $row->company_agent_name }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Agent File</td>
						<td>{{ $row->company_agent_file }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Admin Name</td>
						<td>{{ $row->company_admin_name }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Admin Email</td>
						<td>{{ $row->company_admin_email }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Admin Mobile</td>
						<td>{{ $row->company_admin_mobile }} </td>

					</tr>
				
		</tbody>	
	</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop