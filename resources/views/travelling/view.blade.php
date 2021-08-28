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
		<li><a href="{{ URL::to('travelling?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('travelling?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('travelling/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content"> 	


	
	<table class="table table-striped table-bordered" >
		<tbody>	
	
<!--					<tr>
						<td width='30%' class='label-view text-right'>Id</td>
						<td>{{ $row->id }} </td>
						
					</tr>
				-->
					<tr>
						<td width='30%' class='label-view text-right'>Employee</td>
						<td>{!! SiteHelpers::gridDisplayView($row->employee_id,'employee_id','1:tb_users:id:first_name|last_name') !!} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Department</td>
						<td>{!! SiteHelpers::gridDisplayView($row->department_id,'department_id','1:tb_departments:id:title') !!} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Manager</td>
						<td>{!! SiteHelpers::gridDisplayView($row->manager_id,'manager_id','1:tb_users:id:first_name|last_name') !!} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Date</td>
						<td>{{ $row->date }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>From</td>
						<td>{{ $row->from }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>To</td>
						<td>{{ $row->to }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Country</td>
						<td>{!! SiteHelpers::gridDisplayView($row->country_id,'country_id','1:tb_countries:id:country') !!} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Reason</td>
						<td>{{ $row->reason }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Objectives</td>
						<td>{{ $row->objectives }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Want Visa</td>
						<td>{{ $row->want_visa }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Manager Approved</td>
						<td>{!! SiteHelpers::gridDisplayView($row->manager_approved,'manager_approved','1:tb_yes_no:id:value') !!} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Hotel Cost</td>
						<td>{{ $row->hotel_cost }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Airline Ticket Cost</td>
						<td>{{ $row->airline_ticket_cost }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Per Diem Cost</td>
						<td>{{ $row->per_diem_cost }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Visa Cost</td>
						<td>{{ $row->visa_cost }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Cost</td>
						<td>{{ $row->total_cost }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Cfo Approve</td>
						<td>{!! SiteHelpers::gridDisplayView($row->cfo_approve,'cfo_approve','1:tb_yes_no:id:value') !!} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Cfo Reason</td>
						<td>{{ $row->cfo_reason }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Ceo Approve</td>
						<td>{!! SiteHelpers::gridDisplayView($row->ceo_approve,'ceo_approve','1:tb_yes_no:id:value') !!} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Ceo Reason</td>
						<td>{{ $row->ceo_reason }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Admin Notes</td>
						<td>{{ $row->admin_notes }} </td>
						
					</tr>
				
		</tbody>	
	</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop