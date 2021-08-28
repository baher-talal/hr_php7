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
		<li><a href="{{ URL::to('vacations?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('vacations?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('vacations/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content"> 	


	
	<table class="table table-striped table-bordered" >
		<tbody>	
	
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
						<td width='30%' class='label-view text-right'>Type</td>
						<td>{!! SiteHelpers::gridDisplayView($row->type_id,'type_id','1:tb_vacation_types:id:name') !!} </td>
						
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
						<td width='30%' class='label-view text-right'>Peroid</td>
						<td>
                                                     @if($row->peroid)
                                                    {{ $row->peroid }} &nbsp;    Day(s)
                                                    @endif
                                                
                                                </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Manager Approved</td>
						<td>
                                                    @if($row->manager_approved  == 1)
                                                    Yes     
                                                    @elseif($row->manager_approved  == 0 && is_int($row->manager_approved))
                                                    No
                                                    @endif
                                                </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Manager Reason</td>
						<td>{{ $row->manager_reason }} </td>
						
					</tr>
				
		</tbody>	
	</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop