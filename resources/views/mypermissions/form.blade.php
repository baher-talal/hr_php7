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
            <li><a href="{{ URL::to('mypermissions?return='.$return) }}">{{ $pageTitle }}</a></li>
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

                {!! Form::open(array('url'=>'mypermissions/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
                <div class="col-md-12">
                    <fieldset><legend> my permissions</legend>

                        <div class="form-group hidethis " style="display:none;">
                            <label for="Id" class=" control-label col-md-4 text-left"> Id </label>
                            <div class="col-md-6">
                                {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>


                        <div class="form-group  " >
                            <label for="Date" class=" control-label col-md-4 text-left"> Date <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <div class="input-group m-b" style="width:150px !important;">
                                    {!! Form::text('date', $row['date'],array('class'=>'form-control date','required'=>'required')) !!}
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="Type" class=" control-label col-md-4 text-left"> Type <span class="asterix"> * </span></label>
                            <div class="col-md-6" style="width:180px !important;">
                                <select id='type_id' name="type" rows="5" class='select2 ' required  >
                                    <option ></option>
                                    <option value="1">Morning</option>
                                    <option value="2">Evening</option>
                                </select>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <br/>

                        <div class="form-group  " >
                            <label for="From" class=" control-label col-md-4 text-left"> From <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <div class="input-group m-b" style="width:150px !important;">
                                    {!! Form::text('from', $row['from'],array('class'=>'form-control ','autocomplete'=>'off','required'=>'required','id'=>'from')) !!}
                                    <span class="input-group-addon  datetimepicker_button"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>





                        <div class="form-group  " >
                            <label for="To" class=" control-label col-md-4 text-left"> To <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <div class="input-group m-b" style="width:150px !important;">
                                    {!! Form::text('to', $row['to'],array('class'=>'form-control','required'=>'required','autocomplete'=>'off','id'=>'to')) !!}
                                    <span class="input-group-addon  datetimepicker_button"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>


                        <div class="form-group  " >
                            <label for="Employee Reason" class=" control-label col-md-4 text-left"> Employee Reason <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <textarea name='employee_reason' rows='5' id='employee_reason' class='form-control '
                                          required  >{{ $row['employee_reason'] }}</textarea>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div> </fieldset>
                </div>




                <div style="clear:both"></div>


                <div class="form-group">
                    <label class="col-sm-4 text-right">&nbsp;</label>
                    <div class="col-sm-8">
                    <!--<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>-->
                        <button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
                        <button type="button" onclick="location.href ='{{ URL::to('mypermissions?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
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
        $('.date').attr('autocomplete','off');
        // check type
        $('#type_id').on('change', function () {
            if($(this).val()==1){
                $('#from').val('09:00am').attr('readonly','readonly');
                $('#to').val('').removeAttr('readonly');;
                $('#to').timepicker({
                        'minTime': '10:00am',
                        'maxTime': '01:00pm',
                        'step': 60,
                    });
            }
            else if($(this).val()==2){
                $('#from').timepicker({
                        'minTime': '01:00pm',
                        'maxTime': '06:00pm',
                        'step': 60,
                    });
                $('#from').val('').removeAttr('readonly');
                $('#to').val('07:00pm').attr('readonly','readonly');

            }
        });

    });
</script>
<style>
    .ui-timepicker-wrapper {
        max-height: 100px;
    }

@stop