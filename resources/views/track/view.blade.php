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
		<li><a href="{{ URL::to('track?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>


 	<div class="page-content-wrapper" >
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('track?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('track/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
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
						<td width='30%' class='label-view text-right'>Web Audition Preview</td>
						<td>{{ $row->web_audition_preview }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Aip Play Rbt</td>
						<td>{{ $row->aip_play_rbt }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Wap Audition Rbt</td>
						<td>{{ $row->wap_audition_rbt }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Rbt Name</td>
						<td>{{ $row->rbt_name }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Initial Rbt Name</td>
						<td>{{ $row->initial_rbt_name }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Singer Name</td>
						<td>{{ $row->singer_name }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Initial Singer Name</td>
						<td>{{ $row->initial_singer_name }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Singer Gender</td>
						<td>{{ $row->singer_gender }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Value Of Category</td>
						<td>{{ $row->value_of_category }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Rbt Information</td>
						<td>{{ $row->rbt_information }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Rbt Price</td>
						<td>{{ $row->rbt_price }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Validity Period Rbt</td>
						<td>{{ $row->validity_period_rbt }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Language Code</td>
						<td>{{ $row->language_code }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Relative Expiry Rbt</td>
						<td>{{ $row->relative_expiry_rbt }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Language Prompt Rbt</td>
						<td>{{ $row->language_prompt_rbt }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Allowed Cut</td>
						<td>{{ $row->allowed_cut }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Movie Name</td>
						<td>{{ $row->movie_name }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Sub Cp Id</td>
						<td>{{ $row->sub_cp_id }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Price Group Id</td>
						<td>{{ $row->price_group_id }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Company Lyrics</td>
						<td>{{ $row->company_lyrics }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Dt Lyrics</td>
						<td>{{ $row->dt_lyrics }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Company Id Tune</td>
						<td>{{ $row->company_id_tune }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Date Tune</td>
						<td>{{ $row->date_tune }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Company Id</td>
						<td>{{ $row->company_id }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Validity Date</td>
						<td>{{ $row->validity_date }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Allowed Channels</td>
						<td>{{ $row->allowed_channels }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Renew Allowed</td>
						<td>{{ $row->renew_allowed }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Max Download Times</td>
						<td>{{ $row->max_download_times }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Multiple Language Code</td>
						<td>{{ $row->multiple_language_code }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Rbt Name Ml</td>
						<td>{{ $row->rbt_name_ml }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Singer Name Ml</td>
						<td>{{ $row->singer_name_ml }} </td>

					</tr>

		</tbody>
	</table>



	</div>
</div>

	</div>
</div>

@stop
