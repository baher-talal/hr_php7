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
                    @if($access['is_add'] ==1)
                    <a href="{{ URL::to('employeestasks/update') }}" class="tips btn btn-sm btn-white"  title="{{ Lang::get('core.btn_create') }}">
                        <i class="fa fa-plus-circle "></i>&nbsp;{{ Lang::get('core.btn_create') }}</a>
                    @endif  
                    @if($access['is_remove'] ==1)
                    <a href="javascript://ajax"  onclick="SximoDelete();" class="tips btn btn-sm btn-white" title="{{ Lang::get('core.btn_remove') }}">
                        <i class="fa fa-minus-circle "></i>&nbsp;{{ Lang::get('core.btn_remove') }}</a>
                    @endif 		
                    @if($access['is_excel'] ==1)
                    <a href="{{ URL::to('employeestasks/download') }}" class="tips btn btn-sm btn-white" title="{{ Lang::get('core.btn_download') }}">
                        <i class="fa fa-download"></i>&nbsp;{{ Lang::get('core.btn_download') }} </a>
                    @endif			

                </div> 		



                {!! Form::open(array('url'=>'employeestasks/delete/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) !!}
                <div class="table-responsive" style="min-height:300px;">
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th class="number"> No </th>
                                <th> <input type="checkbox" class="checkall" /></th>

                               
                                    <th>User</th>
                                    <th>Tasks Count</th>
                                  
                                <th width="70" >{{ Lang::get('core.btn_action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                              <tr id="sximo-quick-search" >
                                <td class="number"> # </td>
                                <td> </td>
                                @foreach ($tableGrid as $t)
                                @if($t['field'] =='assign_to_id')
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
                                @if($field['field']=='assign_to_id')                                     
                                    
                                @if($field['view'] =='1')
                                @php
                                $conn = (isset($field['conn']) ? $field['conn'] : array() );
                                $x = $field['field'];
                                @endphp

                              <td>					 
                                    @if($field['attribute']['image']['active'] =='1')
                                    {!! SiteHelpers::showUploadedFile($row->$x,$field['attribute']['image']['path']) !!}
                                    @else	
                                    {{--*/ $conn = (isset($field['conn']) ? $field['conn'] : array() ) /*--}}
                              
                                    {!! SiteHelpers::gridDisplay($row->$x,$field['field'],$conn) !!}	
                                    @endif						 
                                   					 
                                </td>
                                <td>{{countTasks($row->assign_to_id,$row->commitment_id)}}</td>
                                @endif					 
                                @endif					 
                                @endforeach
                                <td>
                                    <a href="{{ URL::to('employeestasks/index?commitment_id='.$row->commitment_id.'&user_id='.$row->assign_to_id) }}" class="tips btn btn-xs btn-white"  title="Tasks"> <i class="fa fa-list-ol "></i></a>


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
            $('#SximoTable').attr('action', '{{ URL::to("employeestasks/multisearch")}}');
            $('#SximoTable').submit();
        });

    });
</script>		
@stop