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
		<li><a href="{{ URL::to('aggregators?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>


 	<div class="page-content-wrapper">
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('aggregators?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('aggregators/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif
		</div>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content">



	<table class="table table-striped table-bordered" >
		<tbody>

					<tr>
						<td width='30%' class='label-view text-right'>Aggregator Name</td>
						<td>{{ $row->aggregator_name }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Aggregator Phone</td>
						<td>{{ $row->aggregator_phone }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Aggregator Mobile</td>
						<td>{{ $row->aggregator_mobile }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Aggregator Post Office</td>
						<td>{{ $row->aggregator_post_office }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Aggregator Email</td>
						<td>{{ $row->aggregator_email }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Aggregator Address</td>
						<td>{{ $row->aggregator_address }} </td>

					</tr>

					<tr>
						<td width='30%' class='label-view text-right'>Aggregator Admin</td>
						<td>{{ $row->aggregator_admin }} </td>

					</tr>

          <tr>
            <td width='30%' class='label-view text-right'>Aggregator Image</td>
            <td> <img src="{{ url('/uploads/user/'.$row->aggregator_img) }}" alt="aggregator image" width="100px" height="100px"> </td>

          </tr>

		</tbody>
	</table>



	</div>
</div>

	</div>
</div>

@stop
