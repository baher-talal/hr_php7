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
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('report?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('report/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content"> 	


	
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Rbt Id</td>
						<td>{!! SiteHelpers::gridDisplayView($row->rbt_id,'rbt_id','1:rbts:id:id') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Rbt title</td>
						<td>{{ $row->rbt_name }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Year</td>
						<td>{{ $row->year }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Month</td>
						<td>{{ $row->month }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Classification</td>
						<td>{{ $row->classification }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Code</td>
						<td>{{ $row->code }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Download Number</td>
						<td>{{ $row->download_no }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Revenue</td>
						<td>{{ $row->total_revenue }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Revenue Share</td>
						<td>{{ $row->revenue_share }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Operator Title</td>
						<td>{!! SiteHelpers::gridDisplayView($row->operator_id,'operator_id','1:tb_operators:id:name') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Provider Title</td>
						<td>{!! SiteHelpers::gridDisplayView($row->provider_id,'provider_id','1:providers:id:provider_name') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Aggregator Title</td>
						<td>{!! SiteHelpers::gridDisplayView($row->aggregator_id,'aggregator_id','1:aggregators:id:aggregator_name') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created</td>
						<td>{{ $row->created_at }} </td>

					</tr>
				
		</tbody>	
	</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop