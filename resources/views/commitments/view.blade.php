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
            <li><a href="{{ URL::to('commitments?return='.$return) }}">{{ $pageTitle }}</a></li>
            <li class="active"> {{ Lang::get('core.detail') }} </li>
        </ul>
    </div>  


    <div class="page-content-wrapper">   
        <div class="toolbar-line">
            <a href="{{ URL::to('commitments?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
            @if($access['is_add'] ==1)
            <a href="{{ URL::to('commitments/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
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
                            <td width='30%' class='label-view text-right'>Contract </td>
                            <td>{!! SiteHelpers::gridDisplayView($row->contract_id,'contract_id','1:tb_contracts:id:title') !!} </td>

                        </tr>
                        <tr>
                            <td width='30%' class='label-view text-right'>Project </td>
                            <td>{!! SiteHelpers::gridDisplayView($row->project_id,'project_id','1:projects:id:name') !!} </td>

                        </tr>
                        <tr>
                            <td width='30%' class='label-view text-right'>Department </td>
                            <td>{!! SiteHelpers::gridDisplayView($row->department_id,'department_id','1:tb_departments:id:title') !!} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Commitment</td>
                            <td>{!! $row->commitment !!} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Notes</td>
                            <td>{{ $row->notes }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Seen</td>
                            <td>{!! SiteHelpers::gridDisplayView($row->seen,'seen','1:tb_yes_no:id:value') !!} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Approve</td>
                            <td>{!! SiteHelpers::gridDisplayView($row->approve,'approve','1:tb_yes_no:id:value') !!} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Disaprove Reason</td>
                            <td>{{ $row->disaprove_reason }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Working Hours</td>
                            <?php $working_hours = explode('.', $row->working_hours) ?>
                            <td><?= $working_hours[0] != 0 ? $working_hours[0] . ' Hour  ' : '' ?><?= $working_hours[1] != 0 ? ltrim($working_hours[1], '0') . ' Min.  ' : '' ?></td>


                        </tr>
                        <tr>
                            <td width='30%' class='label-view text-right'>Priority</td>
                            <td>{!! SiteHelpers::gridDisplayView($row->priority,'priority','1:priorities:id:value') !!} </td>

                        </tr>
                        <tr>
                            <td width='30%' class='label-view text-right'>Created At</td>
                            <td>{{ $row->created_at }} </td>

                        </tr>

                    </tbody>	
                </table>   

                <hr/>

                <div id="piechart" style="width: 100%; height: 500px;"></div>
                <div class="clearfix"></div>
                <div id="barchart" style="width: 100%; height: 500px;"></div>
                <div class="clearfix"></div>
            </div>
        </div>	

    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {

        var data = google.visualization.arrayToDataTable([
                ['tasks Status', 'Count'],
                ['Not Completed', {{$chart['notcompletedtasks']}}],
                ['Completed', {{$chart['completedtasks']}}],
        ]);
                var options = {
                title: 'Tasks Status',
                        slices: {0: {color: 'red'}, 1:{color: '#109618'}}

                };
                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1]);
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
                // bar chart
                var data1 = google.visualization.arrayToDataTable([
                        ["Element", "Count", { role: "style" } ],
                        ["Completed", {{$chart['completedtasks']}}, "green"],
                        ["Working", {{$chart['workingtasks']}}, "gold"],
                        ["Pending", {{$chart['pendingtasks']}}, "red"],
                        ["Initial", {{$chart['initialtasks']}}, "color: silver"],
                        ["Not Seen", {{$chart['waitingtasks']}}, "color: #e5e4e2"]
                ]);
                var view1 = new google.visualization.DataView(data1);
                view1.setColumns([0, 1,
                { calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation" },
                        2]);
                var options1 = {
                title: "Count of Tasks In Each Phase",
                        hAxis: { Type: "number", format: '0'},
                        height: 400,
                        bar: {groupWidth: "95%"},
                        legend: { position: "none" },
                };
                var chart1 = new google.visualization.BarChart(document.getElementById("barchart"));
                chart1.draw(view1, options1);
        }
</script>		
@stop