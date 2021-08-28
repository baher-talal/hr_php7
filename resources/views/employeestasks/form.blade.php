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
            <li><a href="{{ URL::to('employeestasks?return='.$return) }}">{{ $pageTitle }}</a></li>
            <li class="active">{{ Lang::get('core.addedit') }} </li>
        </ul>

    </div>

    <div class="page-content-wrapper">

        <ul class="parsley-error-list">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <div class="sbox animated fadeInRight">
            <div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
            <div class="sbox-content"> 	

                {!! Form::open(array('url'=>'employeestasks/save?return='.$return, 'class'=>'form-horizontal','files' => true )) !!}
                <div class="col-md-12">
                    <fieldset><legend> Tasks @if(!$row['id']) <button class="addUser btn btn-info pull-right">Add User</button>@endif</legend>

                        <div id="tasks">
                            <div class="form-group hidethis " style="display:none;">
                                <label for="Id" class=" control-label col-md-4 text-left"> Id </label>
                                <div class="col-md-6">
                                    {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
                                </div> 
                                <div class="col-md-2">

                                </div>
                            </div>                            
                            @if($commitents)
                            <div class="form-group hidethis ">
                                <label for="Commitment Id" class=" control-label col-md-4 text-left"> Commitment  <span class="asterix"> * </span></label>
                                <div class="col-md-6">
                                    <select name='commitment_id' id='countries' rows='5' required  class='select2 '  > 
                                        <option  value ='' ></option>                                   
                                        @foreach ($commitents as $key => $val) 
                                        <option  value ='{{$val->id}}' >{{$val->commitment}}</option>
                                        @endforeach
                                    </select> 
                                </div> 
                                <div class="col-md-2">

                                </div>
                            </div>
                            @elseif(!$row['id'])
                            <div class="form-group hidethis " style="display:none;">
                                <label for="Commitment Id" class=" control-label col-md-4 text-left"> Commitment  <span class="asterix"> * </span></label>
                                <div class="col-md-6">
                                    {!! Form::text('commitment_id', $commitment_id,array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
                                </div> 
                                <div class="col-md-2">

                                </div>
                            </div> 

                            @endif
                            <div id="taskDetails" >
                                <div class="taskDetails">
                                    @if(!$row['id'])
                                    <button class="addTask btn btn-success pull-right">Add Task</button>
                                    @endif
                                    <div class="form-group  " >
                                        <label for="Employee" class=" control-label col-md-4 text-left"> Employee <span class="asterix"> * </span></label>
                                        <div class="col-md-6">
                                            <select name='assign_to_id[]' rows='5' id='assign_to_id' class='form-control assign_to_id' required  order='User_0'>
                                                <option ></option>
                                                @foreach($users as $user)
                                                <option value="{{$user->id}}" <?= $user->id == $row['assign_to_id'] ? 'selected' : '' ?>>{{$user->first_name .' '.$user->last_name.' ('.$user->username.')'}}</option>
                                                @endforeach
                                            </select> 
                                        </div> 
                                        <div class="col-md-2">
                                        </div>
                                    </div>
                                    <div id="task">
                                        <div class="task">
                                            <div class="form-group  " >
                                                <label for="Task" class=" control-label col-md-4 text-left"> Task <span class="asterix"> * </span></label>
                                                <div class="col-md-6">
                                                    <textarea name='taskUser_0[]' rows='5'  class='form-control '  
                                                              required  >{{ $row['task'] }}</textarea> 
                                                </div> 
                                                <div class="col-md-2">
                                                </div>
                                            </div> 					
                                            <div class="form-group  " >
                                                <label for="Task" class=" control-label col-md-4 text-left"> Time <span class="asterix"> * </span></label>
                                                <div class="col-md-6">
                                                    <div class="input-group">

                                                        <select name='tasktimeUser_0[]' required  class='form-control time'>
                                                            @foreach ($time_opt as $key => $val) 
                                                            <option  value ='{{$val}}' <?= ($row['time'] == $val ? " selected='selected' " : '' ) ?>>{{$val}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="input-group-addon">Hour</span>
                                                    </div> 
                                                    <div class="col-md-2">
                                                    </div>
                                                </div> 					
                                            </div> 	
                                            <div class="form-group  " >
                                                <label for="Priority" class=" control-label col-md-4 text-left"> Priority </label>
                                                <div class="col-md-6">
                                                    <select name='taskPriorityUser_0[]' rows='5' id='priority' class='form-control priority'  required ></select> 
                                                </div> 
                                                <div class="col-md-2">

                                                </div>
                                            </div>
                                        </div> 					
                                    </div> 					
                                </div> 					
                            </div> 					
                    </fieldset>
                </div>




                <div style="clear:both"></div>	


                <div class="form-group">
                    <label class="col-sm-4 text-right">&nbsp;</label>
                    <div class="col-sm-8">	

                        <button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
                        <button type="button" onclick="location.href ='{{ URL::to('tasks?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
                    </div>	  

                </div> 

                {!! Form::close() !!}
            </div>
        </div>		 
    </div>	
</div>			 
<script>
    var order = 1;
    $(document).on("click", ".addTask", function (event) {
        event.preventDefault();
        $(this).closest('.taskDetails').append("<hr style='border-style: dashed;'/><a class='del btn btn-danger pull-right' href='javascript:void(0);'><i class='fa fa-trash-o'></i></a>");
        $(this).closest('.taskDetails').append($('#task').html());
        var user = $(this).closest('.taskDetails').find('.assign_to_id').attr('order');
        $(this).closest('.taskDetails').find('.task textarea').last().attr('name', "task" + user + "[]");
        $(this).closest('.taskDetails').find('.task select.time').last().attr('name', "tasktime" + user + "[]");
        $(this).closest('.taskDetails').find('.task select.priority').last().attr('name', "taskPriority" + user + "[]");
    });

    $(document).on("click", ".addUser", function (event) {
        event.preventDefault();
        $('#tasks').append("<hr style='border-color: #45b6af;'/><a class='delUser btn btn-danger pull-right' href='javascript:void(0);'><i class='fa fa-trash-o'></i></a>");
        $('#tasks').append($('#taskDetails').html());
        $('.taskDetails').last().find('.assign_to_id').attr('order', "User_" + order);
        $('.taskDetails').last().find('.task textarea').each(function () {
            $(this).attr('name', "taskUser_" + order + "[]");
        })
        $('.taskDetails').last().find('.task select.time').each(function () {
            $(this).attr('name', "tasktimeUser_" + order + "[]");
        })
        $('.taskDetails').last().find('.task select.priority').each(function () {
            $(this).attr('name', "taskPriorityUser_" + order + "[]");
        })
        
        
        order++;

    });

    $(document).on("click", ".del", function () {
        $(this).next('.task').remove();
        $(this).remove();
    });
    $(document).on("click", ".delUser", function () {
        $(this).next('.taskDetails').remove();
        $(this).remove();

    });
    $("#priority").jCombo("{{ URL::to('commitments/comboselect?filter=priorities:id:value') }}",
        {  selected_value : '{{ $row["priority"] }}' });
</script>        
@stop