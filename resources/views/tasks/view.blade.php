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
            <li><a href="{{ URL::to('tasks?return='.$return) }}">{{ $pageTitle }}</a></li>
            <li class="active"> {{ Lang::get('core.detail') }} </li>
        </ul>
    </div>  


    <div class="page-content-wrapper">   
        <div class="toolbar-line">
            <a href="{{ URL::to('tasks?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
            @if($access['is_add'] ==1)
            @if($row->status==0)
            <a href="{{ URL::to('tasks/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
            @endif  		   	  
            @endif  	  
        </div>
        <div class="sbox animated fadeInRight">
            <div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
            <div class="sbox-content"> 	



                <table class="table table-striped table-bordered" >
                    <tbody>	

                        <tr>
                            <td width='30%' class='label-view text-right'>Task</td>
                            <td>{{ $row->task }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Commitment </td>
                            <td>{!! SiteHelpers::gridDisplayView($row->commitment_id,'commitment_id','1:tb_commitments:id:commitment') !!} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Assign To User</td>
                            <td>{!! SiteHelpers::gridDisplayView($row->assign_to_id,'assign_to_id','1:tb_users:id:first_name|last_name') !!} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Time</td>
                            <td>{{ $row->time }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Seen</td>
                            <td>{!! SiteHelpers::gridDisplayView($row->seen,'seen','1:tb_yes_no:id:value') !!} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Status</td>
                            <td>
                                @if($row->status==0)
                                not seen
                                @elseif($row->status==1)
                                initial
                                @elseif($row->status==2)
                                pause
                                @elseif($row->status==3)
                                working
                                @elseif($row->status==4)
                                finished
                                @endif
                            </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Working Hours</td>
                            <?php $working_hours = explode('.', $row->working_hours) ?>
                            <td><?= $working_hours[0] != 0 ? $working_hours[0] . ' Hour  ' : '' ?><?= $working_hours[1] != 0 ? ltrim($working_hours[1],'0') . ' Min.  ' : '' ?></td>

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

                 @if(count($history)>0)
                <hr/>
                <h3>Task History</h3>
                <div class="table-responsive" >
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th class="number"> No </th>                               
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Working Time</th>                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($history as $k => $value)
                            <tr>
                                <td> {{$k+1}}  </td>
                                <td> {{$value->start_time}}  </td>
                                <td> {{$value->end_time}}  </td>
                                <?php $t = get_diff_taskhistory($value->id) ?>
                                <td> <?= $t['hour'] != 0 ? $t['hour'] . ' Hour  ' : '' ?> <?= $t['min'] != 0 ? $t['min'] . ' Min.' : '' ?></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

            </div>
        </div>	

    </div>
</div>

@stop