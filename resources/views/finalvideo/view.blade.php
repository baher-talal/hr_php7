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
		<li><a href="{{ URL::to('finalvideo?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('finalvideo?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('finalvideo/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content"> 	


	
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Title</td>
						<td>{{ $row->video_title }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Provider</td>
						<td>{!! SiteHelpers::gridDisplayView($row->provider_id,'provider_id','1:providers:id:provider_name') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Country</td>
						<td>{!! SiteHelpers::gridDisplayView($row->country_id,'country_id','1:tb_countries:id:country') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Operators</td>
						<td>{!! SiteHelpers::gridDisplayView($row->operators_id,'operators_id','1:tb_operators:id:name') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Path</td>
						{{-- <td>{!! SiteHelpers::showUploadedFile($row->video_path,'/uploads/media/') !!} </td> --}}
						<td><video src="{{url("/uploads/media/$row->video_path")}}" controls width="300px"></video></td>

					</tr>
				
		</tbody>	
	</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop