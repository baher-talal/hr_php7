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
		<li><a href="{{ URL::to('originalcontents?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('originalcontents?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('originalcontents/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content"> 	


	
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Title</td>
						<td>{{ $row->original_title }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Provider</td>
						<td>{!! SiteHelpers::gridDisplayView($row->provider_id,'provider_id','1:providers:id:provider_name') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Type</td>
						<td>{!! SiteHelpers::gridDisplayView($row->content_type_id,'content_type_id','1:cont_types:id:cont_type_title') !!} </td>
						{{-- <td>{!! $row->content_type_id !!} </td> --}}

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Occasion</td>
						<td>{!! SiteHelpers::gridDisplayView($row->occasion_id,'occasion_id','1:occasions:id:occasion_name') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>File Path</td>
						{{-- <td>{!! SiteHelpers::showUploadedFile($row->original_path,'/uploads/media/') !!} </td> --}}
						{{-- 
							3/ image
							2/ video
							1/audio
						--}}
						@if ($row->content_type_id == 3)
							<td><img src="{{url("uploads/media/$row->original_path")}}" height="200px" alt=""></td>
						@elseif($row->content_type_id == 2)
							<td><video src="{{url("uploads/media/$row->original_path")}}" width="300px" controls></video></td>
						@elseif($row->content_type_id == 1)
							<td><audio src="{{url("uploads/media/$row->original_path")}}" controls></audio></td>
						@endif
					</tr>
				
		</tbody>	
	</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop