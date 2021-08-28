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
		<li><a href="{{ URL::to('attendance?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('attendance?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('attendance/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
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
						<td width='30%' class='label-view text-right'>Employee Finger Id</td>
						<td>{{ $row->employee_finger_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Employee Name</td>
						<td>{{ $row->employee_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Date</td>
						<td>{{ $row->date }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Work Day</td>
						<td>{{ $row->work_day }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Day Type</td>
						<td>{{ $row->day_type }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Sign In</td>
						<td>{{ $row->sign_in }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Sign Out</td>
						<td>{{ $row->sign_out }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Work Hours</td>
						<td>{{ $row->work_hours }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Overtime</td>
						<td>{{ $row->overtime }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Short Minutes</td>
						<td>{{ $row->short_minutes }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Leave Type</td>
						<td>{{ $row->leave_type }} </td>
						
					</tr>
				
		</tbody>	
	</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop