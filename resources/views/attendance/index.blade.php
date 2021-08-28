@extends('layouts.app')

@section('content')
{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
        </div>

        <ul class="breadcrumb">
            <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ul>

    </div>

    <?php
    /*
  $d =   "07-Dec-16" ;
 echo  date("Y-m-d",strtotime( trim($d)));
    */
    ?>


    <div class="page-content-wrapper m-t">

        <div class="sbox animated fadeInRight">
            <div class="sbox-title">
                <h5> <i class="fa fa-table"></i> </h5>
                <div class="sbox-tools">
                    @if(Session::get('gid') ==1)
                    <a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="btn btn-xs btn-white tips"
                        title=" {{ Lang::get('core.btn_config') }}"><i class="fa fa-cog"></i></a>
                    @endif
                </div>
            </div>
            @if(Session::has('message'))
            {!! Session::get('message') !!}
            @endif
            <div class="sbox-content">
                <div class="toolbar-line ">
                    @if($access['is_add'] ==1)

                    <!--	   		<a href="{{ URL::to('attendance/update') }}" class="tips btn btn-sm btn-white"  title="{{ Lang::get('core.btn_create') }}">
			<i class="fa fa-plus-circle "></i>&nbsp;{{ Lang::get('core.btn_create') }}</a>-->

                    <a href="{{ URL::to('attendance/upload') }}" class="tips btn btn-sm btn-white"
                        title="{{ Lang::get('core.btn_upload_excel') }}">
                        <i class="fa fa-plus-circle "></i>&nbsp;{{ Lang::get('core.btn_upload_excel') }}</a>

                    @endif


                    @if($access['is_remove'] ==1)
                    <a href="javascript://ajax" onclick="SximoDelete();" class="tips btn btn-sm btn-white"
                        title="{{ Lang::get('core.btn_remove') }}">
                        <i class="fa fa-minus-circle "></i>&nbsp;{{ Lang::get('core.btn_remove') }}</a>
                    @endif
                    @if($access['is_excel'] ==1)
                    <a href="{{ URL::to('attendance/download') }}" class="tips btn btn-sm btn-white"
                        title="{{ Lang::get('core.btn_download') }}">
                        <i class="fa fa-download"></i>&nbsp;{{ Lang::get('core.btn_download') }} </a>
                    @endif
                    <a href="{{ URL::to('refresh_punch') }}" class="tips btn btn-sm btn-white" title="Get Punch">
                        <i class="fa fa-folder"></i>&nbsp;Get Punch</a>
                </div>



                {!! Form::open(array('url'=>'attendance/delete/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) !!}
                <div class="table-responsive" style="min-height:300px;">
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th class="number"> No </th>
                                <th> <input type="checkbox" class="checkall" /></th>

                                @foreach ($tableGrid as $t)
                                @if($t['view'] =='1')
                                <th>{{ $t['label'] }}</th>
                                @endif
                                @endforeach
                                <th width="70">{{ Lang::get('core.btn_action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr id="sximo-quick-search">
                                <td class="number"> # </td>
                                <td> </td>
                                @foreach ($tableGrid as $t)
                                @if($t['view'] =='1')
                                <td>
                                    {!! SiteHelpers::transForm($t['field'] , $tableForm) !!}
                                </td>
                                @endif
                                @endforeach
                                <td>
                                    <input type="hidden" value="Search">
                                    <button type="button" class=" do-quick-search btn btn-xs btn-info"> GO</button>
                                </td>
                            </tr>

                            @foreach ($rowData as $row)
                            <tr>
                                <td width="30"> {{ ++$i }} </td>
                                <td width="50"><input type="checkbox" class="ids" name="id[]" value="{{ $row->id }}" />
                                </td>
                                @foreach ($tableGrid as $field)
                                @php
                                $conn = (isset($field['conn']) ? $field['conn'] : array() );
                                $x = $field['field'];
                                @endphp
                                @if($field['view'] =='1')
                                <td>
                                    @if($field['attribute']['image']['active'] =='1')
                                    {!!
                                    SiteHelpers::showUploadedFile($row->$field['field'],$field['attribute']['image']['path'])
                                    !!}
                                    @else
                                    {{--*/ $conn = (isset($field['conn']) ? $field['conn'] : array() ) /*--}}
                                    {!! SiteHelpers::gridDisplay($row->$x,$field['field'],$conn) !!}


                                    @if($field['field']=='overtime')
                                    <?php $overtime= App\Http\Controllers\AttendanceController::over($row->employee_finger_id,$row->date)?>
                                    @if($overtime!='none')
                                    <a style="color: #b72420;"
                                        href="{{ URL::to('overtimes/show/'.$overtime['id'].'?return='.$return)}}"
                                        class="tips btn btn-xs btn-white">OverTime / Actual:
                                        {{ $overtime['no_hours'] }}</a>
                                    @endif
                                    @endif


                                    @if($field['field']=='leave_type')
                                    <?php $vacation= App\Http\Controllers\AttendanceController::vacation($row->employee_finger_id,$row->date) ?>
                                    @if($vacation[0]!='none' && $vacation[1])
                                    <a style="color: #b72420;"
                                        href="{{ URL::to('vacations/show/'.$vacation[0][0]->id.'?return='.$return)}}"
                                        class="tips btn btn-xs btn-white">Vacation </a>
                                    @elseif($vacation[0]!='none' && !$vacation[1])
                                    <a style="color: #b72420;"
                                        href="{{ URL::to('permissions/show/'.$vacation[0][0]->id.'?return='.$return)}}"
                                        class="tips btn btn-xs btn-white">Permission </a>

                                    @endif
                                    @endif



                                    @endif


                                </td>
                                @endif
                                @endforeach
                                <td>
                                    @if($access['is_detail'] ==1)
                                    <a href="{{ URL::to('attendance/show/'.$row->id.'?return='.$return)}}"
                                        class="tips btn btn-xs btn-white" title="{{ Lang::get('core.btn_view') }}"><i
                                            class="fa  fa-search "></i></a>
                                    @endif
                                    @if($access['is_edit'] ==1)
                                    <a href="{{ URL::to('attendance/update/'.$row->id.'?return='.$return) }}"
                                        class="tips btn btn-xs btn-white" title="{{ Lang::get('core.btn_edit') }}"><i
                                            class="fa fa-edit "></i></a>
                                    @endif


                                </td>
                            </tr>

                            @endforeach

                        </tbody>

                    </table>
                    <input type="hidden" name="md" value="" />
                </div>
                {!! Form::close() !!}
                @include('footer')
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {

    $('.do-quick-search').click(function() {
        $('#SximoTable').attr('action', '{{ URL::to("attendance/multisearch")}}');
        $('#SximoTable').submit();
    });

});
</script>
@stop
