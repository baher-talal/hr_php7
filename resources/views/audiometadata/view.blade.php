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
		<li><a href="{{ URL::to('audiometadata?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('audiometadata?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('audiometadata/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content"> 	


	
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Country</td>
						<td>{!! SiteHelpers::gridDisplayView($row->country_id,'country_id','1:tb_countries:id:country') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Operator</td>
						<td>{!! SiteHelpers::gridDisplayView($row->operators_id,'operators_id','1:tb_operators:id:name') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Category</td>
						<td>{!! SiteHelpers::gridDisplayView($row->cont_categories_id,'cont_categories_id','1:specs_cont_categories:id:category_title') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>File Sizes</td>
						<td>{!! SiteHelpers::gridDisplayView($row->cont_media_file_sizes,'cont_media_file_sizes','1:specs_cont_media_file_sizes:id:file_size_title') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Sample Path</td>
						{{-- <td>{!! SiteHelpers::showUploadedFile($row->track_sample_path,'/uploads/media/') !!} </td> --}}
						<td><audio controls>
							<source src="{{url("uploads/media/$row->track_sample_path")}}" type="audio/ogg">
							<source src="{{url("uploads/media/$row->track_sample_path")}}" type="audio/mpeg">
						</audio></td>
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Meta Data</td>
						<td>{{ $row->track_meta_data }} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Duration</td>
						<td>{{ $row->track_duration }} </td>

					</tr>
				
		</tbody>	
	</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop