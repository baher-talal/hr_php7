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


    <div class="page-content-wrapper m-t">	 	

        <div class="sbox animated fadeInRight">
            <div class="sbox-title"> <h5> <i class="fa fa-table"></i> </h5>
                <div class="sbox-tools" >
                    @if(Session::get('gid') ==1)
                    <a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="btn btn-xs btn-white tips" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa fa-cog"></i></a>
                    @endif 
                </div>
            </div>
            <div class="sbox-content"> 	
                <div class="toolbar-line ">                   
                    @if($access['is_remove'] ==1)
                    <a href="javascript://ajax"  onclick="SximoDelete();" class="tips btn btn-sm btn-white" title="{{ Lang::get('core.btn_remove') }}">
                        <i class="fa fa-minus-circle "></i>&nbsp;{{ Lang::get('core.btn_remove') }}</a>
                    @endif 		
                    @if($access['is_excel'] ==1)
                    <a href="{{ URL::to('tasks/download') }}" class="tips btn btn-sm btn-white" title="{{ Lang::get('core.btn_download') }}">
                        <i class="fa fa-download"></i>&nbsp;{{ Lang::get('core.btn_download') }} </a>
                    @endif			

                </div> 		



                {!! Form::open(array('url'=>'tasks/delete/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) !!}
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
                                <th width="70" >{{ Lang::get('core.btn_action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr id="sximo-quick-search" >
                                <td class="number"> # </td>
                                <td> </td>
                                @foreach ($tableGrid as $t)
                                @if($t['view'] =='1')
                                <td>						
                                    {!! SiteHelpers::transForm($t['field'] , $tableForm) !!}								
                                </td>
                                @endif
                                @endforeach
                                <td >
                                    <input type="hidden"  value="Search">
                                    <button type="button"  class=" do-quick-search btn btn-xs btn-info"> GO</button></td>
                            </tr>	        

                            @foreach ($rowData as $row)
                            <tr class="{{check_task_status($row->id)}}">
                                <td width="30"> {{ ++$i }} </td>
                                <td width="50"><input type="checkbox" class="ids" name="id[]" value="{{ $row->id }}" />  </td>									
                                @foreach ($tableGrid as $field)
                                @php
                                $conn = (isset($field['conn']) ? $field['conn'] : array() );
                                $x = $field['field'];
                                @endphp

                                @if($field['view'] =='1')
                                <td>					 
                                    @if($field['attribute']['image']['active'] =='1')
                                    {!! SiteHelpers::showUploadedFile($row->$x,$field['attribute']['image']['path']) !!}
                                    @else	
                                    {{--*/ $conn = (isset($field['conn']) ? $field['conn'] : array() ) /*--}}
                                    @if($x=='status')
                                        @if($row->status==0)
                                            <label class="label label-default"> Not Seen </label>
                                        @elseif($row->status==1)
                                            <label class="label label-default"> Initial </label>
                                        @elseif($row->status==2)
                                            <label class="label label-danger">  Pause </label>
                                        @elseif($row->status==3)
                                            <label class="label label-info"> Working </label>
                                        @elseif($row->status==4)
                                            <label class="label label-success"> Finished</label>
                                        @endif
                                    @elseif($x=='seen')
                                        @if($row->seen==1) 
                                            <label class="label label-success">Seen</label>
                                        @elseif($row->seen==0)  
                                            <label class="label label-danger"> Not Seen </label>
                                         @endif
                                    @elseif($x=='working_hours')
                                            <?php $working_hours = explode('.', $row->working_hours) ?>
                                            <?= $working_hours[0] != 0 ? $working_hours[0] . ' Hour  ' : '' ?><?= $working_hours[1] != 0 ? ltrim($working_hours[1], '0') . ' Min.  ' : '' ?>
     
                                    @else
                                    {!! SiteHelpers::gridDisplay($row->$x,$x,$conn) !!}	
                                    @endif						 
                                    @endif						 
                                </td>
                                @endif					 
                                @endforeach
                                <td>
                                    @if($access['is_detail'] ==1)                                       
                                        <a href="{{ URL::to('tasks/show/'.$row->id.'?return='.$return)}}" class="tips btn btn-xs btn-white" title="{{ Lang::get('core.btn_view') }}"><i class="fa  fa-search "></i></a>
                                    @endif
                                    @if($access['is_edit'] ==1) 
                                        @if($row->status==0)
                                            <a  href="{{ URL::to('tasks/update/'.$row->id.'?return='.$return) }}" class="tips btn btn-xs btn-white" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit "></i></a>
                                         @endif
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
    $(document).ready(function () {

        $('.do-quick-search').click(function () {
            $('#SximoTable').attr('action', '{{ URL::to("tasks/multisearch")}}');
            $('#SximoTable').submit();
        });

    });
</script>		
@stop