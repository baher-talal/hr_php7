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
            <li><a href="{{ URL::to('employeestravelling?return='.$return) }}">{{ $pageTitle }}</a></li>
<!--            <li class="active">{{ Lang::get('core.addedit') }} </li>-->
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

                {!! Form::open(array('url'=>'employeestravelling/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
                <div class="col-md-12">
                    <fieldset><legend> employees travelling</legend>

                        <div class="form-group hidethis " style="display:none;">
                            <label for="Id" class=" control-label col-md-4 text-left"> Id </label>
                            <div class="col-md-6">
                                {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 


                        <div class="form-group  " >
                            <label for="Employee" class=" control-label col-md-4 text-left"> Employee : </label>
                            <div class="col-md-6 emp_vacation_margin"  >
                                {!! SiteHelpers::gridDisplayView($row->employee_id,'employee_id','1:tb_users:id:first_name|last_name') !!}
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div>
                        
                         
                         <div class="form-group" >
                            <label for="Date" class=" control-label col-md-4 text-left"> Date : </label>
                            <div class="col-md-6 emp_vacation_margin">
                                {{ $row->date }}
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 
                        
                        
                        
                         <div class="form-group" >
                            <label for="From" class=" control-label col-md-4 text-left"> From : </label>
                            <div class="col-md-6 emp_vacation_margin">
                                {{ $row->from }}
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 
                        
                         <div class="form-group" >
                            <label for="To" class=" control-label col-md-4 text-left"> To : </label>
                            <div class="col-md-6 emp_vacation_margin">
                                {{ $row->to }}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>


                        <div class="form-group" >
                            <label for="Date" class=" control-label col-md-4 text-left"> Country : </label>
                            <div class="col-md-6 emp_vacation_margin">
                               {!! SiteHelpers::gridDisplayView($row->country_id,'country_id','1:tb_countries:id:country') !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>


                         


                         <div class="form-group" >
                            <label for="Notes" class=" control-label col-md-4 text-left"> Reason : </label>
                            <div class="col-md-6 emp_vacation_margin">
                                {{ $row->reason }}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        
                        
                          <div class="form-group" >
                            <label for="Notes" class=" control-label col-md-4 text-left"> Objectives : </label>
                            <div class="col-md-6 emp_vacation_margin">
                                {{ $row->objectives }}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        
                        
                         <div class="form-group" >
                            <label for="Notes" class=" control-label col-md-4 text-left"> Want Visa : </label>
                            <div class="col-md-6 emp_vacation_margin">
                                 {!! SiteHelpers::gridDisplayView($row->want_visa,'want_visa','1:tb_yes_no:id:value') !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        
                        
                        


                        <div class="form-group  " >
                            <label for="Manager Approved" class=" control-label col-md-4 text-left"> Manager Approved <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <label class='radio radio-inline'>
                                    <input type='radio' name='manager_approved' value ='0' required @if($row['manager_approved'] == '0') checked="checked" @endif > No </label>
                                <label class='radio radio-inline'>
                                    <input type='radio' name='manager_approved' value ='1' required @if($row['manager_approved'] == '1') checked="checked" @endif > Yes </label> 
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
                        </div> </fieldset>
                </div>




                <div style="clear:both"></div>


                <div class="form-group">
                    <label class="col-sm-4 text-right">&nbsp;</label>
                    <div class="col-sm-8">	
<!--                        <button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>-->
                        <button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
                        <button type="button" onclick="window.location.href ='{{ URL::to('employeestravelling?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
                    </div>	  

                </div> 

                {!! Form::close() !!}
            </div>
        </div>		 
    </div>	
</div>			 
<script type="text/javascript">
    $(document).ready(function () {



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