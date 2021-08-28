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
            <li><a href="{{ URL::to('employeesvacations?return='.$return) }}">{{ $pageTitle }}</a></li>
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

                {!! Form::open(array('url'=>'employeesvacations/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
                <div class="col-md-12">
                    <fieldset><legend> Employees Vacations</legend>

                        <div class="form-group hidethis " style="display:none;">
                            <label for="Id" class=" control-label col-md-4 text-left"> Id </label>
                            <div class="col-md-6">
                                {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 	

                        <div class="form-group  " >
                            <label for="Employee" class=" control-label col-md-4 text-left"> Employee </label>
                            <div class="col-md-6 emp_vacation_margin"  >
                                {!! SiteHelpers::gridDisplayView($row->employee_id,'employee_id','1:tb_users:id:first_name|last_name') !!}
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div>




                        <div class="form-group  " >
                            <label for="Type" class=" control-label col-md-4 text-left"> Type </label>
                            <div class="col-md-6 emp_vacation_margin">
                                {!! SiteHelpers::gridDisplayView($row->type_id,'type_id','1:tb_vacation_types:id:name') !!} 
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 	
                        
                        <div class="form-group" >
                            <label for="Date" class=" control-label col-md-4 text-left"> Date </label>
                            <div class="col-md-6 emp_vacation_margin">
                                {{ $row->date }}
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 					
                        <div class="form-group  " >
                            <label for="From" class=" control-label col-md-4 text-left"> From</label>
                            <div class="col-md-6 emp_vacation_margin">
                                {{ $row->from }}
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 					
                        <div class="form-group  " >
                            <label for="To" class=" control-label col-md-4 text-left"> To </label>
                            <div class="col-md-6 emp_vacation_margin">
                                {{ $row->to }}
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 

                        <div class="form-group  " >
                            <label for="Peroid" class=" control-label col-md-4 text-left"> Peroid </label>
                            <div class="col-md-6 emp_vacation_margin">
                                {{ $row->peroid }} &nbsp;   Day(s)
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 
                        
                           <div class="form-group  " >
                            <label for="Manager Approved" class=" control-label col-md-4 text-left"> Manager Approved </label>
                            <div class="col-md-6">

                                <label class='radio radio-inline'>
                                    <input type='radio' name='manager_approved' value ='0'  @if($row['manager_approved'] == '0') checked="checked" @endif > No </label>
                                <label class='radio radio-inline'>
                                    <input type='radio' name='manager_approved' value ='1'  @if($row['manager_approved'] == '1') checked="checked" @endif > Yes </label> 
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 					
                        <div class="form-group  " >
                            <label for="Manager Reason" class=" control-label col-md-4 text-left"> Manager Reason </label>
                            <div class="col-md-6">
                                <textarea name='manager_reason' rows='5' id='manager_reason' class='form-control '  
                                          >{{ $row['manager_reason'] }}</textarea> 
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 
                        
                    
                    </fieldset>
                </div>




                <div style="clear:both"></div>	


                <div class="form-group">
                    <label class="col-sm-4 text-right">&nbsp;</label>
                    <div class="col-sm-8">	
                        <!--<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>-->
                        <button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
                        <button type="button" onclick="window.location.href ='{{ URL::to('employeesvacations?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
                    </div>	  

                </div> 

                {!! Form::close() !!}
            </div>
        </div>		 
    </div>	
</div>			 
<script type="text/javascript">
    $(document).ready(function () {


        $("#employee_id").jCombo("{{ URL::to('employeesvacations/comboselect?filter=tb_users:id:first_name|last_name') }}",
                {selected_value: '{{ $row["employee_id"] }}'});

        $("#department_id").jCombo("{{ URL::to('employeesvacations/comboselect?filter=tb_departments:id:title') }}",
                {selected_value: '{{ $row["department_id"] }}'});

        $("#manager_id").jCombo("{{ URL::to('employeesvacations/comboselect?filter=tb_users:id:first_name|last_name') }}",
                {selected_value: '{{ $row["manager_id"] }}'});

        $("#type_id").jCombo("{{ URL::to('employeesvacations/comboselect?filter=tb_vacation_types:id:name') }}",
                {selected_value: '{{ $row["type_id"] }}'});


        $('.removeCurrentFiles').on('click', function () {
            var removeUrl = $(this).attr('href');
            $.get(removeUrl, function (response) {
            });
            $(this).parent('div').empty();
            return false;
        });

    });
</script>		 
@stop