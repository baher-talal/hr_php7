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
            <li><a href="{{ URL::to('acquisitions?return='.$return) }}">{{ $pageTitle }}</a></li>
            <li class="active"> {{ Lang::get('core.detail') }} </li>
        </ul>
    </div>


    <div class="page-content-wrapper">
        <div class="toolbar-line">
            <a href="{{ URL::to('acquisitions?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
            @if($access['is_add'] == 1 && $row->final_approve == 0)
            <a href="{{ URL::to('acquisitions/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
            @endif
            @if($approveStatus)
            @if($is_ceo)
            <a href="{{ URL::to('acquisitions/cancel/'.$id) }}" class="tips btn btn-xs btn-danger" title="Cancel"><i class="fa fa-close"></i>&nbsp;Cancel </a>
            @else
            <a data-toggle="modal" data-target="#ApproveModal" class="tips btn btn-xs btn-success" title="Approve"><i class="fa fa-check"></i>&nbsp;Approve  </a>
            @endif
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
                            <td width='30%' class='label-view text-right'>Provider </td>
                            <td>{!! SiteHelpers::gridDisplayView($row->provider_id,'provider_id','1:providers:id:provider_name') !!} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Wikipedia</td>
                            <td>{{ $row->wikipedia }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Business Case</td>
                            <td>{!! SiteHelpers::showUploadedFile($row->business_case,'/uploads/acquisitions/') !!}</td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Youtube</td>
                            <td>{{ $row->youtube }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Facebook</td>
                            <td>{{ $row->facebook }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Brand Manager </td>
                            <td>{!! SiteHelpers::gridDisplayView($row->brand_manager_id,'brand_manager_id','1:tb_users:id:first_name|last_name') !!} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Twitter</td>
                            <td>{{ $row->twitter }} </td>
                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Instagram</td>
                            <td>{{ $row->instagram }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Sample Links</td>
                            <td>{{ $row->sample_links }} </td>

                        </tr>
                        <tr>
                            <td width='30%' class='label-view text-right'>Content Type</td>
                            <td>{{ ($row->content_type==1)?'In':'Out' }} </td>

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
                            <td width='30%' class='label-view text-right'>Ceo Cancel</td>
                            <td>{!! SiteHelpers::gridDisplayView($row->ceo_cancel,'ceo_cancel','1:tb_yes_no:id:value') !!} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Final Approve</td>
                            <td>{!! SiteHelpers::gridDisplayView($row->final_approve,'final_approve','1:tb_yes_no:id:value') !!} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Content Classification</td>
                            <td>{{ $row->content_classification }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Created At</td>
                            <td>{{ $row->created_at }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Entry By</td>
                            <td>{!! SiteHelpers::gridDisplayView($row->entry_by,'entry_by','1:tb_users:id:first_name|last_name') !!} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Region</td>
                            <td>
                              @foreach ($countrys as $key => $country)
                                @foreach($all_operators[$key] as $k=>$operator)
                                  {{$country->country}} {{$operator->name}}  @if($key<count($countrys)-1) / @endif
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
                        {!! Form::open(array('url'=>'acquisitions/teamapprove', 'class'=>'form-horizontal','method'=>'get')) !!}
                        <input type="hidden" name="acquisition_id" value="{{$row->id}}"/>
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
                        {!! Form::open(array('url'=>'acquisitions/creatorapprove', 'class'=>'form-horizontal','method'=>'get')) !!}
                        <input type="hidden" name="acquisition_id" value="{{$row->id}}"/>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('.reply').click(function () {
            var id = $(this).attr('data-id')
            $("#ReplayModal #approve_id").val(id);
        })
    })
</script>
@stop
