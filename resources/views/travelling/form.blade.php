

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
            <div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
            <div class="sbox-content">

                {!! Form::open(array('url'=>'travelling/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
                <div class="col-md-12">
                    <fieldset><legend> travelling</legend>

                        <div class="form-group hidethis " style="display:none;">
                            <label for="Id" class=" control-label col-md-4 text-left"> Id </label>
                            <div class="col-md-6">
                                {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Employee" class=" control-label col-md-4 text-left"> Employee <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <select name='employee_id' rows='5' id='employee_id' class='select2 ' required  >

                                </select>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Department" class=" control-label col-md-4 text-left"> Department <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <select name='department_id' rows='5' id='department_id' class='select2 ' required  >


                                </select>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Manager" class=" control-label col-md-4 text-left"> Manager </label>
                            <div class="col-md-6">
                                <select name='manager_id' rows='5' id='manager_id' class='select2 '   ></select>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Date" class=" control-label col-md-4 text-left"> Date </label>
                            <div class="col-md-6">
                                {!! Form::text('date', $row['date'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="From" class=" control-label col-md-4 text-left"> From <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <div class="input-group m-b" style="width:150px !important;">
                                    {!! Form::text('from', $row['from'],array('class'=>'form-control date')) !!}
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="To" class=" control-label col-md-4 text-left"> To <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <div class="input-group m-b" style="width:150px !important;">
                                    {!! Form::text('to', $row['to'],array('class'=>'form-control date')) !!}
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Country" class=" control-label col-md-4 text-left"> Country <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <select name='country_id' rows='5' id='country_id' class='select2 ' required  ></select>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Reason" class=" control-label col-md-4 text-left"> Reason <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <textarea name='reason' rows='5' id='reason' class='form-control '
                                          required  >{{ $row['reason'] }}</textarea>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Objectives" class=" control-label col-md-4 text-left"> Objectives <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <textarea name='objectives' rows='5' id='objectives' class='form-control '
                                          required  >{{ $row['objectives'] }}</textarea>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Want Visa" class=" control-label col-md-4 text-left"> Want Visa </label>
                            <div class="col-md-6">

                                <label class='radio radio-inline'>
                                    <input type='radio' name='want_visa' value ='0'  @if($row['want_visa'] == '0') checked="checked" @endif > No </label>
                                <label class='radio radio-inline'>
                                    <input type='radio' name='want_visa' value ='1'  @if($row['want_visa'] == '1') checked="checked" @endif > Yes </label>
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
                            <label for="Hotel Cost" class=" control-label col-md-4 text-left"> Hotel Cost <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('hotel_cost', $row['hotel_cost'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Airline Ticket Cost" class=" control-label col-md-4 text-left"> Airline Ticket Cost <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('airline_ticket_cost', $row['airline_ticket_cost'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Per Diem Cost" class=" control-label col-md-4 text-left"> Per Diem Cost <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('per_diem_cost', $row['per_diem_cost'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Visa Cost" class=" control-label col-md-4 text-left"> Visa Cost <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('visa_cost', $row['visa_cost'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Total Cost" class=" control-label col-md-4 text-left"> Total Cost </label>
                            <div class="col-md-6">
                                {!! Form::text('total_cost', $row['total_cost'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Cfo Approve" class=" control-label col-md-4 text-left"> Cfo Approve </label>
                            <div class="col-md-6">

                                <label class='radio radio-inline'>
                                    <input type='radio' name='cfo_approve' value ='0'  required  @if($row['cfo_approve'] == '0') checked="checked" @endif > No </label>
                                <label class='radio radio-inline'>
                                    <input type='radio' name='cfo_approve' value ='1'  required  @if($row['cfo_approve'] == '1') checked="checked" @endif > Yes </label>
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
                        <div class="form-group  " >
                            <label for="Ceo Approve" class=" control-label col-md-4 text-left"> Ceo Approve </label>
                            <div class="col-md-6">

                                <label class='radio radio-inline'>
                                    <input type='radio' name='ceo_approve' value ='0'  @if($row['ceo_approve'] == '0') checked="checked" @endif > No </label>
                                <label class='radio radio-inline'>
                                    <input type='radio' name='ceo_approve' value ='1'  @if($row['ceo_approve'] == '1') checked="checked" @endif > Yes </label>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Ceo Reason" class=" control-label col-md-4 text-left"> Ceo Reason </label>
                            <div class="col-md-6">
                                <textarea name='ceo_reason' rows='5' id='ceo_reason' class='form-control '
                                          >{{ $row['ceo_reason'] }}</textarea>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="Admin Notes" class=" control-label col-md-4 text-left"> Admin Notes </label>
                            <div class="col-md-6">
                                <textarea name='admin_notes' rows='5' id='admin_notes' class='form-control '
                                          >{{ $row['admin_notes'] }}</textarea>
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
                        <button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
                        <button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
                        <button type="button" onclick="location.href ='{{ URL::to('travelling?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
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

    });
</script>
@stop




