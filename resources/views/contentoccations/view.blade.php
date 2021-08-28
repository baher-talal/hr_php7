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
		<li><a href="{{ URL::to('contentoccations?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('contentoccations?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('contentoccations/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content"> 	


	
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Occation Name</td>
						<td>{{ $row->cont_occation_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Occation Description</td>
						<td>{{ $row->cont_occation_description }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Occation Date</td>
						<td>{{ $row->cont_occation_date }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Category</td>
						<td>{!! SiteHelpers::gridDisplayView($row->category_id,'category_id','1:cont_categories:id:cont_category_title') !!} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Country</td>
						<td>{!! SiteHelpers::gridDisplayView($row->country_id,'country_id','1:tb_countries:id:country') !!} </td>
						
					</tr>
				
		</tbody>	
	</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop