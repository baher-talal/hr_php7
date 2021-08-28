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

                {!! Form::open(array('url'=>'mytravelling/admin?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
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

                        
                          <div class="form-group" >
                              <label for="Booking Sites" class=" control-label col-md-4 text-left"> <b> Booking Sites : </b></label>
                            <div class="col-md-6 emp_vacation_margin">
                                <a href="https://www.booking.com/index.ar.html" target="blank" > Booking.com</a>
                                <br>
                                <a href="http://www.egyptair.com/ar" target="blank" > Egyptair</a>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        
                        
                        <!--// to handle the case when hotel_cost is int so update it = 0 we want to convert it to null--> 
                        <span class="section">

                            <div class="form-group  ">
                                <label for="Hotel Cost" class=" control-label col-md-4 text-left"> Hotel Cost <span
                                        class="asterix"> * </span></label>
                                <div class="col-md-6">
                                    {!! Form::text('hotel_cost',($row['hotel_cost'] == 0 )? "" : $row['hotel_cost'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' ,'id'=>'hotel_cost'  )) !!}
                                </div>
                                <div class="col-md-2">    

                                </div>
                            </div>
                            <div class="form-group  ">
                                <label for="Airline Ticket Cost" class=" control-label col-md-4 text-left"> Airline
                                    Ticket Cost <span class="asterix"> * </span></label>
                                <div class="col-md-6">
                                    {!! Form::text('airline_ticket_cost',  ($row['airline_ticket_cost'] == 0 )? "" : $row['airline_ticket_cost']  ,array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' ,'id'=>'airline_ticket_cost'  )) !!}
                                </div>
                                <div class="col-md-2">

                                </div>
                            </div>
                            <div class="form-group  ">
                                <label for="Per Diem Cost" class=" control-label col-md-4 text-left"> Per Diem Cost
                                    <span class="asterix"> * </span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        {!! Form::text('per_diem_cost',  ($cost == "" )? "" : $cost ,array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' ,'id'=>'per_diem_cost' ,  ($cost=="")? '':'readonly' )) !!}
                                        <span class="input-group-addon"> {{$currency}} </span>
                                    </div>

                                </div>

                                <div class="col-md-2"> 
                                    @if(isset($peroid))
                                      {{$per_diem_cost}}  {{$currency}} *  {{  $peroid   }}   day(s)


                                    @endif
                                </div>
                            </div>


                            <div class="form-group  ">
                                <label for="Visa Cost" class=" control-label col-md-4 text-left"> Visa Cost 
                                    @if($row['want_visa'] == 1)
                                    <span  class="asterix"> * </span>
                                    @endif

                                </label>



                                <div class="col-md-6">
                                    {!! Form::text('visa_cost', ($visa_cost == 0 )? 0 : $row['visa_cost'] ,array('class'=>'form-control', 'placeholder'=>'', ($row['want_visa'] == 0 )? "" : 'required'=>'true','id'=>'visa_cost' ,  ($visa_cost == 0 )? 'readonly' : '' )) !!}
                                </div>
                                <div class="col-md-2">     

                                </div>
                            </div>
                        </span>

                        <div class="form-group  ">
                            <label for="Total Cost" class=" control-label col-md-4 text-left"> Total Cost </label>
                            <div class="col-md-6">
                                {!! Form::text('total_cost', ($row['total_cost'] == 0 )? "" : $row['total_cost'] ,array('class'=>'form-control', 'placeholder'=>'', 'readonly' ,'id'=>'total_cost'  )) !!}
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