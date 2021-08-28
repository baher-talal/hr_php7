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
            <li><a href="{{ URL::to('contracts?return='.$return) }}">{{ $pageTitle }}</a></li>
            <li class="active"> {{ Lang::get('core.detail') }} </li>
        </ul>
    </div>


    <div class="page-content-wrapper">
        <div class="toolbar-line">
            <a href="{{ URL::to('contracts?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
            @if($access['is_add'] == 1 && $row->final_approve == 0)
            <a href="{{ URL::to('contracts/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
            @endif
            @if($approveStatus)
            @if($is_ceo)
            <a href="{{ URL::to('contracts/cancel/'.$id) }}" class="tips btn btn-xs btn-danger" title="Cancel"><i class="fa fa-close"></i>&nbsp;Cancel </a>
            @else
            <a data-toggle="modal" data-target="#ApproveModal" class="tips btn btn-xs btn-success" title="Approve"><i class="fa fa-check"></i>&nbsp;Approve </a>
            @endif
            @endif

        </div>
        <div class="sbox animated fadeInRight">
            <div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
            <div class="sbox-content">



                <table class="table table-striped table-bordered" >
                    <tbody>

                        <tr>
                            <td width='30%' class='label-view text-right'>Type</td>
                            <td>
                                @if($row->contract_type==1)
                                New
                                @elseif($row->contract_type==2)
                                Draft
                                @endif
                            </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Title</td>
                            <td>{{ $row->title }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Signed Date</td>
                            <td>{{ $row->signed_date }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Start Date</td>
                            <td>{{ $row->start_date }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>End Date</td>
                            <td>{{ $row->end_date }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Peroid</td>
                            <td>{{ $row->peroid }} Year</td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>First Part Name</td>
                            <td>{{ $row->first_part_name }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Second Part Name</td>
                            <td>{{ $row->second_part_name }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>First Part Ratio</td>
                            <td>{{ $row->first_part_ratio }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Second Part Ratio</td>
                            <td>{{ $row->second_part_ratio }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>First Part Email</td>
                            <td>{{ $row->first_part_email }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Second Part Email</td>
                            <td>{{ $row->second_part_email }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Min Guarantee</td>
                            <td>{{ $row->min_guarantee }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>First Part Address</td>
                            <td>{{ $row->first_part_address }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Second Part Address</td>
                            <td>{{ $row->second_part_address }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Location</td>
                            <td>
                                @if($row->location==1)
                                inside
                                @elseif($row->location==2)
                                outside
                                @endif
                            </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>First Part Phone</td>
                            <td>{{ $row->first_part_phone }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Second Part Phone</td>
                            <td>{{ $row->second_part_phone }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Expire</td>
                            <td>{!! SiteHelpers::gridDisplayView($row->expire,'expire','1:tb_yes_no:id:value') !!} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Working Hours</td>
                            <?php $working_hours = explode('.', $row->working_hours) ?>
                            <td><?= $working_hours[0] != 0 ? $working_hours[0] . ' Hour  ' : '' ?><?= $working_hours[1] != 0 ? ltrim($working_hours[1], '0') . ' Min.  ' : '' ?></td>


                        </tr>
                        <tr>
                            <td width='30%' class='label-view text-right'>Notification Period Months</td>
                            <td>{{ $row->notification_period_months }} </td>

                        </tr>
                        <tr>
                            <td width='30%' class='label-view text-right'>Expected Days To Finish</td>
                            <td>{{ $row->expected_time_to_finish_with_days }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Brand Manager</td>
                            <td>{!! SiteHelpers::gridDisplayView($row->brand_manager_id,'brand_manager_id','1:tb_users:id:first_name|last_name') !!} </td>

                        </tr>
                        <tr>
                            <td width='30%' class='label-view text-right'>Expected Time To Finish With Days</td>
                            <td>{{ $row->expected_time_to_finish_with_days }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Final Approve</td>
                            <td>{!! SiteHelpers::gridDisplayView($row->final_approve,'final_approve','1:tb_yes_no:id:value') !!} </td>

                        </tr>
                         <tr>
                            <td width='30%' class='label-view text-right'>Operation Approve</td>
                            <td>{!! SiteHelpers::gridDisplayView($row->operation_approve,'operation_approve','1:tb_yes_no:id:value') !!} </td>

                        </tr>
                        <tr>
                            <td width='30%' class='label-view text-right'>Finance Approve</td>
                            <td>{!! SiteHelpers::gridDisplayView($row->finance_approve,'finance_approve','1:tb_yes_no:id:value') !!} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Legal Approve</td>
                            <td>{!! SiteHelpers::gridDisplayView($row->legal_approve,'legal_approve','1:tb_yes_no:id:value') !!} </td>

                        </tr>
                        <tr>
                            <td width='30%' class='label-view text-right'>Acqisition </td>
                            <td>{{$row->acqisition_id}} </td>

                        </tr>
                        <tr>
                            <td width='30%' class='label-view text-right'>Servides </td>
                            <td> (@foreach($services as $k=>$service) {{$service->name}} @if($k<count($services)-1) - @endif @endforeach )</td>

                        </tr>
                        <tr>
                            <td width='30%' class='label-view text-right'>Region </td>
                            <td>
                              @foreach ($countrys as $key => $country)
                                @foreach($all_operators[$key] as $k=>$operator)
                                  {{$country->country}} {{$operator->name}} @if($key<count($countrys)-1) / @endif
                                @endforeach
                              @endforeach
                            </td>

                        </tr>
                    </tbody>
                </table>
                 <br/>
                <!------ approve history-->
                @if($approveHistory)

                <h3>Approve History </h3>
                <div class="table-responsive">

                    <table class="table table-bordered table-striped">
                        <thead class="no-border">
                            <tr>
                                <th>User</th>
                                <th>Approve Status</th>
                                <th>Approve Description</th>
                                <th>Time</th>
                                <th>Creator Action</th>
                                <th>Creator Action Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="no-border-y">
                            @foreach($approveHistory as $value)
                            <tr>
                                <td>{!! SiteHelpers::gridDisplayView($value->user_id,'user_id','1:tb_users:id:first_name|last_name') !!}</td>
                                <td>
                                    @if($value->approve == 0)
                                    no action yet
                                    @elseif($value->approve == 1)
                                    Approve
                                    @elseif($value->approve == 2)
                                    Disapprove
                                    @elseif($value->approve == 3)
                                    Semiapprove
                                    @endif
                                </td>
                                <td>{{$value->description}}</td>
                                <td>{{$value->created_at}}</td>
                                <td>
                                    @if($value->notified_action == 1)
                                    Approve
                                    @elseif($value->notified_action == 2)
                                    Disapprove
                                    @endif
                                </td>
                                <td>{{$value->notified_description}}</td>
                                <td>
                                    @if($value->approve == 3 && $value->notified_action == 0 && \Auth::user()->id == $row->entry_by)
                                    <a data-toggle="modal" data-target="#ReplayModal" data-id="{{$value->id}}"class="tips btn btn-xs btn-info reply" title="Reply"><i class="fa fa-reply"></i>&nbsp;Reply </a>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                @endif
                @if($chart['alltasks']>0)
                <hr/>
                <div id="piechart" style="width: 100%; height: 500px;"></div>
                <div class="clearfix"></div>
                <div id="barchart" style="width: 100%; height: 400px;"></div>
                <div class="clearfix"></div>
                <div id="dept_chart" style="width: 100%; height: auto;"></div>
                <div class="clearfix"></div>
                <br/>
                <br/>
                @endif
            </div>
        </div>
        @if($approveStatus)
        @if(!$is_ceo)
        <!-- Modal -->
        <div class="modal fade" id="ApproveModal" tabindex="-1" role="dialog" aria-labelledby="ApproveModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title" id="exampleModalLabel">Approve</span>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(array('url'=>'contracts/teamapprove', 'class'=>'form-horizontal','method'=>'get')) !!}
                        <input type="hidden" name="contract_id" value="{{$row->id}}"/>
                        <input type="hidden" name="approve_name" value="{{$approve_name}}"/>

                        <div class="form-group  " >
                            <label for="countries" class=" control-label col-md-4 text-left"> Status <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <select name='approve' required  class='form-control ' >
                                    <option  value ='1' >Approve</option>
                                    <option  value ='2' >DisApprove</option>
                                    <option  value ='3' >SemiApprove</option>

                                </select>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="countries" class=" control-label col-md-4 text-left"> Description <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <textarea name="description" rows="3" class="form-control" required=""></textarea>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endif
        @if(\Auth::user()->id==$row->entry_by)
        <!-- Modal -->
        <div class="modal fade" id="ReplayModal" tabindex="-1" role="dialog" aria-labelledby="ApproveModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title" id="exampleModalLabel">Approve</span>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(array('url'=>'contracts/creatorapprove', 'class'=>'form-horizontal','method'=>'get')) !!}
                        <input type="hidden" name="contract_id" value="{{$row->id}}"/>
                        <input type="hidden" name="approve_id" id="approve_id" value=""/>

                        <div class="form-group  " >
                            <label for="countries" class=" control-label col-md-4 text-left"> Status <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <select name='notified_action' required  class='form-control ' >
                                    <option  value ='1' >Approve</option>
                                    <option  value ='2' >DisApprove</option>

                                </select>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="countries" class=" control-label col-md-4 text-left"> Description <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <textarea name="notified_description" rows="3" class="form-control" required=""></textarea>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@if($chart['alltasks']>0)
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {

        var data = google.visualization.arrayToDataTable([
                ['Project Progress', 'Count', 'link'],
                ['Not Completed', {{$chart['notcompletedtasks']}}, '{{ URL::to("tasks?contract_id=$row->id")}}&status=notcompleted'],
                ['Completed', {{$chart['completedtasks']}}, '{{ URL::to("tasks?contract_id=$row->id")}}&status=completed'],
        ]);
                var options = {
                title: 'Project Progress',
                        slices: {0: {color: 'red'}, 1:{color: '#109618'}}

                };
                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1]);
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
                // active link
                var selectHandler = function(e) {
                window.location = data.getValue(chart.getSelection()[0]['row'], 2);
                }

        // Add our selection handler.
        google.visualization.events.addListener(chart, 'select', selectHandler);
                // bar chart
                var data1 = google.visualization.arrayToDataTable([
                        ["Element", "Count", { role: "style" }, 'link'],
                        ["Completed", {{$chart['completedtasks']}}, "green", '{{ URL::to("tasks?contract_id=$row->id")}}&status=4'],
                        ["Working", {{$chart['workingtasks']}}, "gold", '{{ URL::to("tasks?contract_id=$row->id")}}&status=3'],
                        ["Pending", {{$chart['pendingtasks']}}, "red", '{{ URL::to("tasks?contract_id=$row->id")}}&status=2'],
                        ["Initial", {{$chart['initialtasks']}}, "color: silver", '{{ URL::to("tasks?contract_id=$row->id")}}&status=1'],
                        ["Not Seen", {{$chart['waitingtasks']}}, "color: #e5e4e2", '{{ URL::to("tasks?contract_id=$row->id")}}&status=0']
                ]);
                var view1 = new google.visualization.DataView(data1);
                view1.setColumns([0, 1,
                { calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation" },
                        2]);
                var options1 = {
                title: "Tasks Progress In Each Phase",
                        hAxis: { Type: "number", format: '0'},
                        height: 400,
                        bar: {groupWidth: "95%"},
                        legend: { position: "none" },
                };
                var chart1 = new google.visualization.BarChart(document.getElementById("barchart"));
                chart1.draw(view1, options1);
                // active link
                var selectHandler = function(e) {
                window.location = data1.getValue(chart1.getSelection()[0]['row'], 3);
                }  // Add our selection handler.
        google.visualization.events.addListener(chart1, 'select', selectHandler);
        }
</script>
<script type="text/javascript">
    //department bar chart
    google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawStuff);
            function drawStuff() {
            var data = new google.visualization.arrayToDataTable([
                    ['Commitment', 'All Tasks ', 'Completed Tasks'],
                    @foreach($commitments as $val)
                    ['{{$val->commitment}}', {{get_commitment_progress($val-> id)['alltasks']}}, {{get_commitment_progress($val->id)['completedtasks']}}],
                    @endforeach
            ]);
                    var options = {
                    chart: {
                    title: 'Commitments Progress',
                    },
                            bars: 'horizontal', // Required for Material Bar Charts.
                            bar: { groupWidth: "1%" }

                    };
                    var chart = new google.charts.Bar(document.getElementById('dept_chart'));
                    chart.draw(data, options);
            };
</script>
@endif
<script type="text/javascript">
    $(document).ready(function () {
        $('.reply').click(function () {
            var id = $(this).attr('data-id')
            $("#ReplayModal #approve_id").val(id);
        })
    })
</script>
@stop
