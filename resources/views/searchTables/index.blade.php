@extends('layouts.app')

@section('content')

<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3> {{ ucfirst($pageTitle) }} </h3>
        </div>

        <ul class="breadcrumb">
            <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
            <li class="active">{{ ucfirst($pageTitle) }}</li>
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

                </div>
            </div>
            <div class="sbox-content">
                {!! Form::open(array('url'=>'searchTables/search','method'=>'get', 'class'=>'form-horizontal',
                'parsley-validate'=>'','novalidate'=>' ','id'=>'search')) !!}
                <div class="col-md-12">
                    <div class="form-group col-md-4 ">
                        <label class=" control-label col-md-4 text-left"> Table </label>
                        <div class="col-md-6">
                            <div class="input-group m-b" style="width:190px !important;">
                                <select class="form-control" name="TableName" required="">
                                    <option value="tb_vacations" @if($requestInput['TableName']=='tb_vacations' )
                                        selected @endif>Vacations</option>
                                    <option value="tb_permissions" @if($requestInput['TableName']=='tb_permissions' )
                                        selected @endif>Permissions</option>
                                    <option value="tb_overtimes" @if($requestInput['TableName']=='tb_overtimes' )
                                        selected @endif>Overtimes</option>
                                    <option value="tb_attendance" @if($requestInput['TableName']=='tb_attendance' )
                                        selected @endif>Attendance</option>
                                    <option value="tb_meetings" @if($requestInput['TableName']=='tb_meetings' ) selected
                                        @endif>Meetings</option>
                                    <option value="tb_travellings" @if($requestInput['TableName']=='tb_travellings' )
                                        selected @endif>Traveling</option>
                                    <option value="tb_deductions" @if($requestInput['TableName']=='tb_deductions' )
                                        selected @endif>Deductions</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label class=" control-label col-md-4 text-left"> From </label>
                        <div class="col-md-6">
                            <div class="input-group m-b" style="width:150px !important;">
                                {!! Form::text('start', $requestInput['start'],array('class'=>'form-control date',
                                'style'=>'width:150px !important;','required'=>'true')) !!}
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group  col-md-4">
                        <label class=" control-label col-md-4 text-left"> To </label>
                        <div class="col-md-6">
                            <div class="input-group m-b" style="width:150px !important;">
                                {!! Form::text('end',$requestInput['end'],array('class'=>'form-control date',
                                'style'=>'width:150px !important;','required'=>'true')) !!}
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear:both"></div>

                <div class="form-group">
                    <label class="col-sm-5 text-right">&nbsp;</label>
                    <div class="col-sm-6">
                        <button type="submit" name="submit" class="btn btn-primary btn-sm"><i
                                class="fa  fa-search "></i> Search</button>
                    </div>

                </div>

                {!! Form::close() !!}
                <hr />
                <div class="toolbar-line ">
                    @if($access['is_excel'] ==1 && count($Data)>0 )
                    <a href="{{ URL::to('searchTables/download?TableName='.$requestInput['TableName'].'&start='.$requestInput['start'].'&end='.$requestInput['end']) }}"
                        class="tips btn btn-sm btn-white" title="{{ Lang::get('core.btn_download') }}">
                        <i class="fa fa-download"></i>&nbsp;{{ Lang::get('core.btn_download') }} </a>
                    @endif

                </div>
                <div class="table-responsive">
                    @if(count($Data)>0)
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th class="number" width="60"> No </th>
                                @foreach ($tableGrid as $t)
                                @if($t['view'] =='1')
                                <th>{{ $t['label'] }}</th>
                                @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = ($Data->currentpage() - 1) * $Data->perpage() + 1 ?>
                            @foreach ($Data as $k=>$row)
                            <tr>
                                <td> {{ $c++ }} </td>
                                @foreach ($tableGrid as $t)
                                @php
                                $x = $t['field'];
                                $conn = (isset($t['conn']) ? $t['conn'] : array() );
                                @endphp

                                @if($t['view'] =='1')

                                <td>
                                    @if($t['field'] == "manager_approved" && $row->$x == 1 )
                                    Yes
                                    @elseif( $t['field'] == "manager_approved" && $row->$x == 0 && is_int($row->$x) )
                                    No
                                    @else
                                    {{--*/ $conn = (isset($t['conn']) ? $t['conn'] : array() ) /*--}}
                                    {!! SiteHelpers::gridDisplay($row->$x,$t['field'],$conn) !!}
                                    @endif
                                </td>
                                @endif
                                @endforeach
                                <td>
                                    @if($access['is_detail'] ==1)
                                    <a href="{{ URL::to($pageTitle.'/show/'.$row->id)}}"
                                        class="tips btn btn-xs btn-white" title="{{ Lang::get('core.btn_view') }}"><i
                                            class="fa  fa-search "></i></a>
                                    @endif
                                    @if($access['is_edit'] ==1)
                                    <a href="{{ URL::to($pageTitle.'/update/'.$row->id) }}"
                                        class="tips btn btn-xs btn-white" title="{{ Lang::get('core.btn_edit') }}"><i
                                            class="fa fa-edit "></i></a>
                                    @endif
                                    @if($pageTitle=="vacations"||$pageTitle=="overtimes"||$pageTitle=="permissions"||$pageTitle=="meetings")
                                    <a href="{{ URL::to($pageTitle.'/makepdfvacation?id='.$row->id) }}"
                                        class="tips btn btn-xs btn-white"
                                        title="{{ Lang::get('core.btn_preview_as_pdf') }}"><i
                                            class="fa fa-arrows-alt "></i></a>
                                    @endif


                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <div id="pagenation" class="pull-right" style="margin-bottom: 30px;">
                        <span style="font-weight: bold;display: block; margin:0 10px -15px 0;color:#428bca"> Total :
                            {{$Data->total()}} </span>
                        {!! $Data->render() !!}
                    </div>
                    @else
                    <h3 class="text-center" style="margin:25px 0;">No Data Found</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.date').datepicker({
        format: "dd/mm/yyyy",
    });
</script>
@stop