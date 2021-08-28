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
		<li><a href="{{ URL::to('campaigntracks?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('campaigntracks?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('campaigntracks/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
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
						<td width='30%' class='label-view text-right'>Title</td>
						<td>{{ $row->title }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Track File</td>
						<td>{{ $row->track_file }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Album Id</td>
						<td>{{ $row->album_id }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Subscription Txt</td>
						<td>{{ $row->subscription_txt }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created At</td>
						<td>{{ $row->created_at }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Updated At</td>
						<td>{{ $row->updated_at }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Background Image</td>
						<td>{{ $row->background_image }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Track Poster</td>
						<td>{{ $row->track_poster }} </td>

					</tr>
				
		</tbody>	
	</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop