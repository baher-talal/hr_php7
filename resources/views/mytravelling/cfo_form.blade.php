@extends('layouts.app')

@section('content')

<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3> {{ $pageTitle }}
                <small>{{ $pageNote }}</small>
            </h3>
        </div>
        <ul class="breadcrumb">
            <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
            <li><a href="{{ URL::to('travelling?return='.$return) }}">{{ $pageTitle }}</a></li>
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
            <div class="sbox-title"><h4><i class="fa fa-table"></i></h4></div>
            <div class="sbox-content">

                {!! Form::open(array('url'=>'mytravelling/cfo?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
                <div class="col-md-12">
                    <fieldset>
                        <legend> travelling</legend>

                        <div class="form-group hidethis " style="display:none;">
                            <label for="Id" class=" control-label col-md-4 text-left"> Id </label>
                            <div class="col-md-6">
                                {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>


  <div class="form-group" >
                            <label for="Date" class=" control-label col-md-4 text-left"> Employee : </label>
                            <div class="col-md-6 emp_vacation_margin">
                                {!! SiteHelpers::gridDisplayView($row->employee_id,'employee_id','1:tb_users:id:first_name|last_name') !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        


                        <div class="form-group" >
                            <label for="Date" class=" control-label col-md-4 text-left"> Date : </label>
                            <div class="col-md-6 emp_vacation_margin">
                                {{ $row['date'] }}
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
                            <label for="Date" class=" control-label col-md-4 text-left"> Reason : </label>
                            <div class="col-md-6 emp_vacation_margin">
                                {{ $row->reason }}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group" >
                            <label for="Date" class=" control-label col-md-4 text-left"> Objectives : </label>
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





                        <div class="form-group" >
                            <label for="Manager Approved" class=" control-label col-md-4 text-left"> Manager  Approved : </label>
                            <div class="col-md-6 emp_vacation_margin">
                                {!! SiteHelpers::gridDisplayView($row->manager_approved,'manager_approved','1:tb_yes_no:id:value') !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <!--// to handle the case when hotel_cost is int so update it = 0 we want to convert it to null--> 
                        <span class="section">

                            <div class="form-group  ">
                                <label for="Hotel Cost" class=" control-label col-md-4 text-left"> Hotel Cost </label>
                                <div class="col-md-6 emp_vacation_margin">
                                    {{ $row->hotel_cost }}
                                </div>
                                <div class="col-md-2">    

                                </div>
                            </div>
                            <div class="form-group  ">
                                <label for="Airline Ticket Cost" class=" control-label col-md-4 text-left"> Airline
                                    Ticket Cost </label>
                                <div class="col-md-6 emp_vacation_margin">
                                    {{ $row->airline_ticket_cost }}
                                </div>
                                <div class="col-md-2">

                                </div>
                            </div>
                            <div class="form-group  ">
                                <label for="Per Diem Cost" class=" control-label col-md-4 text-left"> Per Diem Cost  </label>
                                <div class="col-md-6 emp_vacation_margin">
                                    {{ $row->per_diem_cost }}
                                </div>
                                <div class="col-md-2">   

                                </div>
                            </div>
                            <div class="form-group  ">
                                <label for="Visa Cost" class=" control-label col-md-4 text-left"> Visa Cost </label>

                                <div class="col-md-6 emp_vacation_margin">
                                    {{ $row->visa_cost }}
                                </div>
                                <div class="col-md-2">     

                                </div>
                            </div>
                        </span>

                        <div class="form-group  ">
                            <label for="Total Cost" class=" control-label col-md-4 text-left"> Total Cost </label>
                            <div class="col-md-6  emp_vacation_margin">
                                {{ $row->total_cost }}
                                 @if(isset($currency)) 
                               {{$currency}}
                               @endif
                            </div>
                            <div class="col-md-2">  

                            </div>
                        </div>
                        
                        

                         <div class="form-group  " >
                            <label for="Cfo Approve" class=" control-label col-md-4 text-left"> Cfo Approve  <span class="asterix"> * </span>  </label>
                            <div class="col-md-6">

                                <label class='radio radio-inline'>
                                    <input type='radio' name='cfo_approve' value ='0'  @if($row['cfo_approve'] == '0') checked="checked" @endif > No </label>
                                <label class='radio radio-inline'>
                                    <input type='radio' name='cfo_approve' value ='1'  @if($row['cfo_approve'] == '1') checked="checked" @endif > Yes </label> 
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 	
                        



                        <div class="form-group  " >
                            <label for="Cfo Reason" class=" control-label col-md-4 text-left"> Cfo Reason </label>
                            <div class="col-md-6">
                                <textarea name='cfo_reason' rows='5' id='cfo_reason' class='form-control '  
                                          >{{ $row['cfo_reason'] }}</textarea> 
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
                        <button type="submit" name="apply" class="btn btn-info btn-sm"><i
                                class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
                        <button type="submit" name="submit" class="btn btn-primary btn-sm"><i
                                class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
                        <button type="button" onclick="location.href ='{{ URL::to('travelling?return='.$return) }}' "
                                class="btn btn-success btn-sm "><i
                                class="fa  fa-arrow-circle-left "></i> {{ Lang::get('core.sb_cancel') }}
                        </button>
                    </div>

                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {


        $("#employee_id").jCombo("{{ URL::to('travelling/comboselect?filter=tb_users:id:first_name|last_name') }}",
                {selected_value: '{{ $row["employee_id"] }}'});

        $("#department_id").jCombo("{{ URL::to('travelling/comboselect?filter=tb_departments:id:title') }}",
                {selected_value: '{{ $row["department_id"] }}'});

        $("#manager_id").jCombo("{{ URL::to('travelling/comboselect?filter=tb_users:id:first_name|last_name') }}",
                {selected_value: '{{ $row["manager_id"] }}'});

        $("#country_id").jCombo("{{ URL::to('travelling/comboselect?filter=tb_countries:id:country') }}",
                {selected_value: '{{ $row["country_id"] }}'});


        $('.removeCurrentFiles').on('click', function () {
            var removeUrl = $(this).attr('href');
            $.get(removeUrl, function (response) {
            });
            $(this).parent('div').empty();
            return false;
        });



        // to calculate total 
        $("#hotel_cost,#airline_ticket_cost,#per_diem_cost,#visa_cost").blur(function () {
            var totalPoints = 0;
            $(".section").find('input').each(function () {
                if (parseInt($(this).val())) {
                    totalPoints += parseInt($(this).val());
                }

            });
            // console.log(totalPoints)
            $("#total_cost").val(totalPoints);
        });




    });
</script>
@stop