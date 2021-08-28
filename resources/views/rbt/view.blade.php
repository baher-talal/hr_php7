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
		<li><a href="{{ URL::to('rbt?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>


 	<div class="page-content-wrapper">
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('rbt?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('rbt/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif
		</div>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content">



	<table class="table table-striped table-bordered" >
		<tbody>

					<tr>
						<td width='30%' class='label-view text-right'>Track Title </td>
						<td>{{ $row->track_title_en }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Artist</td>
						<td>{{ $row->artist_name_en }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Code</td>
						<td>{{ $row->code }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Owner</td>
						<td>{{ $row->owner }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Track File</td>
						<td>
              <audio id="trackId" width="100%"  controls>
                  <source src="{{ url($row->track_file) }}" >
              </audio>
              {{-- {!! SiteHelpers::showUploadedFile($row->track_file,'uploads/track_file') !!}  --}}
            </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Type</td>
						<td>{{ $row->type }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Provider</td>
						<td>{!! SiteHelpers::gridDisplayView($row->provider_id,'provider_id','1:providers:id:provider_name') !!} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Operator Title</td>
						<td>{!! SiteHelpers::gridDisplayView($row->operator_id,'operator_id','1:tb_operators:id:name') !!} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Occasion Title</td>
						<td>{!! SiteHelpers::gridDisplayView($row->occasion_id,'occasion_id','1:occasions:id:occasion_name') !!} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Aggregator</td>
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
