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
		<li><a href="{{ URL::to('providers?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('providers?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('providers/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content"> 	


	
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Id</td>
						<td>{{ $row->id }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Aggregator</td>
						<td>{!! SiteHelpers::gridDisplayView($row->aggregator_id,'aggregator_id','1:aggregators:id:aggregator_name') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Name</td>
						<td>{{ $row->provider_name }} </td>

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
						<td width='30%' class='label-view text-right'>Address</td>
						<td>{{ $row->provider_address }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Bank Account</td>
						<td>{{ $row->provider_bank_account }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Joining Date</td>
						<td>{{ $row->provider_joining_date }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Admin Id</td>
						<td>{!! SiteHelpers::gridDisplayView($row->admin_id,'admin_id','1:tb_users:id:first_name|last_name') !!} </td>

					</tr>
				
		</tbody>	
	</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop