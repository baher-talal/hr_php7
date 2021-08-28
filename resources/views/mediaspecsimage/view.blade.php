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
		<li><a href="{{ URL::to('mediaspecsimage?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('mediaspecsimage?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('mediaspecsimage/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
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
						<td width='30%' class='label-view text-right'>Content Category</td>
						<td>{!! SiteHelpers::gridDisplayView($row->cont_category_id,'cont_category_id','1:cont_categories:id:cont_category_title') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Content Type</td>
						<td>{!! SiteHelpers::gridDisplayView($row->cont_type_id,'cont_type_id','1:cont_types:id:cont_type_title') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Media Extension</td>
						<td>{!! SiteHelpers::gridDisplayView($row->cont_media_format_id,'cont_media_format_id','1:specs_cont_media_formats:id:media_format_title') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Image Dimensions</td>
						<td>{!! SiteHelpers::gridDisplayView($row->cont_photo_image_size_id,'cont_photo_image_size_id','1:specs_cont_photo_image_sizes:id:photo_image_size_title') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Image Color Mode</td>
						<td>{!! SiteHelpers::gridDisplayView($row->cont_photo_image_color_mode_id,'cont_photo_image_color_mode_id','1:specs_cont_photo_image_color_modes:id:photo_color_mode_title') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Image Resolution</td>
						<td>{!! SiteHelpers::gridDisplayView($row->cont_photo_image_resolution_id,'cont_photo_image_resolution_id','1:specs_cont_photo_image_resolutions:id:photo_image_resolution_title') !!} </td>

					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Media File Size</td>
						<td>{!! SiteHelpers::gridDisplayView($row->cont_media_file_size_id,'cont_media_file_size_id','1:specs_cont_media_file_sizes:id:file_size_title') !!} </td>

					</tr>
				
		</tbody>	
	</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop