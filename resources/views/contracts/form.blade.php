@extends('layouts.app')

@section('content')

<?php
  $providers = get_providers();
 ?>
 <style media="screen">
 .select2-container-multi .select2-choices {
    min-height: 26px;
    margin: -7px -12px;
  }
 </style>
<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
        </div>
        <ul class="breadcrumb">
            <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
            <li><a href="{{ URL::to('contracts?return='.$return) }}">{{ $pageTitle }}</a></li>
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

                {!! Form::open(array('url'=>'contracts/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#ContractDetails" data-toggle="tab">Contract Details</a></li>
                    <li><a href="#ContractOperators" data-toggle="tab">Contract Operators</a></li>
                    <li><a href="#ContractServices" data-toggle="tab">Contract Services</a></li>
                    <li><a href="#ContractTemplate" data-toggle="tab">Contract Template</a></li>
                    <li><a href="#ContractAttachments" data-toggle="tab">Contract Attachments</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane m-t active" id="ContractDetails">

                        <div class="form-group hidethis " style="display:none;">
                            <label for="Id" class=" control-label col-md-4 text-left"> Id </label>
                            <div class="col-md-6">
                                {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        @if($acquisition_id)
                       <div class="form-group hidethis " style="display:none;" >
                           <label for="acqisition_id" class=" control-label col-md-4 text-left"> Acquisition <span class="asterix"> * </span></label>
                           <div class="col-md-6">
                               {!! Form::text('acqisition_id', $acquisition_id,array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                           </div>
                           <div class="col-md-2">

                           </div>
                       </div>
                        @endif
                        <div class="form-group  " >
                            <label for="Type" class=" control-label col-md-4 text-left"> Type <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                  <?php
                                    $contract_type = array('1' => 'New', '2' => 'Draft');
                                    ?>
                                    <select name='contract_type' rows='5' required  class='select2 ' id='contract_type' >
                                        <option ></option>
                                        <?php
                                        foreach ($contract_type as $key => $val) {
                                            echo "<option  value ='$key' " . ($row['contract_type'] == $key ? " selected='selected' " : '' ) . ">$val</option>";
                                        }
                                        ?></select>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Title" class=" control-label col-md-4 text-left"> Title <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('title', $row['title'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Signed Date" class=" control-label col-md-4 text-left"> Signed Date <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <div class="input-group m-b" style="width:250px !important;">
                                    {!! Form::text('signed_date', $row['signed_date'],array('class'=>'form-control date','id'=>'signed_date','required'=>'true' ,'autocomplete' => 'off')) !!}
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Start Date" class=" control-label col-md-4 text-left"> Start Date <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <div class="input-group m-b" style="width:250px !important;">
                                    {!! Form::text('start_date', $row['start_date'],array('id'=>'startDate','class'=>'form-control date', 'required'=>'true')) !!}
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="Peroid" class=" control-label col-md-4 text-left"> Peroid <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <div class="input-group" style="width:250px !important;">
                                    <?php
                                    $peroid = explode(',', $row['peroid']);
                                    $peroid_opt = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5',);
                                    ?>
                                    <select name='peroid' rows='5' required  class='select2 ' id='peroid' >
                                        <?php
                                        foreach ($peroid_opt as $key => $val) {
                                            echo "<option  value ='$key' " . ($row['peroid'] == $key ? " selected='selected' " : '' ) . ">$val</option>";
                                        }
                                        ?></select>
                                    <span class="input-group-addon">Year</span>
                                </div>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  " >
                            <label for="End Date" class=" control-label col-md-4 text-left"> End Date <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <div class="input-group m-b" style="width:250px !important;">
                                    {!! Form::text('end_date', $row['end_date'],array('id'=>'endDate','class'=>'form-control date', 'required'=>'true')) !!}
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="First Part Name" class=" control-label col-md-4 text-left"> First Part <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::select('first_part_name', $providers->pluck('provider_name','id'),null,array('class'=>'form-control','id'=>'first_part' ,'placeholder'=>''  )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="First Part Name" class=" control-label col-md-4 text-left"> First Part Name <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('first_part_name', $row['first_part_name'],array('class'=>'form-control','id'=>'first_part_name' ,'placeholder'=>'', 'required'=>'true'  )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="First Part Email" class=" control-label col-md-4 text-left"> First Part Email </label>
                            <div class="col-md-6">
                                {!! Form::email('first_part_email', $row['first_part_email'],array('id'=>'first_part_email','class'=>'form-control', 'placeholder'=>''   )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="First Part Address" class=" control-label col-md-4 text-left"> First Part Address </label>
                            <div class="col-md-6">
                                {!! Form::text('first_part_address', $row['first_part_address'],array('class'=>'form-control','id'=>'first_part_address', 'placeholder'=>'')) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="First Part Phone" class=" control-label col-md-4 text-left"> First Part Phone </label>
                            <div class="col-md-6">
                                {!! Form::text('first_part_phone', $row['first_part_phone'],array('id'=>'first_part_phone','class'=>'form-control', 'placeholder'=>'' )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="First Part Ratio" class=" control-label col-md-4 text-left"> First Part Ratio <span class="asterix"> * </span></label>
                            <div class="col-md-6 ">
                                <div class="input-group">
                                    {!! Form::number('first_part_ratio', $row['first_part_ratio'],array('class'=>'form-control ratio', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number' ,'max'=>'100'  )) !!}
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="Second Part Name" class=" control-label col-md-4 text-left"> Second Part <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::select('second_part_name', $providers->pluck('provider_name','id'),null,array('class'=>'form-control','id'=>'second_part' ,'placeholder'=>''  )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Second Part Name" class=" control-label col-md-4 text-left"> Second Part Name <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('second_part_name', $row['second_part_name'],array('class'=>'form-control','id'=>'second_part_name', 'placeholder'=>'', 'required'=>'true'  )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="Second Part Email" class=" control-label col-md-4 text-left"> Second Part Email </label>
                            <div class="col-md-6">
                                {!! Form::email('second_part_email', $row['second_part_email'],array('id'=>'second_part_email','class'=>'form-control', 'placeholder'=>'' )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="Second Part Address" class=" control-label col-md-4 text-left"> Second Part Address </label>
                            <div class="col-md-6">
                                {!! Form::text('second_part_address', $row['second_part_address'],array('id'=>'second_part_address','class'=>'form-control', 'placeholder'=>''  )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="Second Part Phone" class=" control-label col-md-4 text-left"> Second Part Phone </label>
                            <div class="col-md-6">
                                {!! Form::text('second_part_phone', $row['second_part_phone'],array('id'=>'second_part_phone','class'=>'form-control', 'placeholder'=>''  )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="Second Part Ratio" class=" control-label col-md-4 text-left"> Second Part Ratio <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    {!! Form::number('second_part_ratio', $row['second_part_ratio'],array('class'=>'form-control ratio', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number' ,'max'=>'100'  )) !!}
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="Min Guarantee" class=" control-label col-md-4 text-left"> Min Guarantee </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    {!! Form::number('min_guarantee', $row['min_guarantee'],array('class'=>'form-control', 'placeholder'=>'' )) !!}
                                    <span class="input-group-addon">$</span>
                                </div>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="Location" class=" control-label col-md-4 text-left"> Location <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <?php
                                $location = explode(',', $row['location']);
                                $location_opt = array('1' => 'inside', '2' => 'outside',);
                                ?>
                                <select name='location' rows='5' required  class='select2 '  >
                                    <?php
                                    foreach ($location_opt as $key => $val) {
                                        echo "<option  value ='$key' " . ($row['location'] == $key ? " selected='selected' " : '' ) . ">$val</option>";
                                    }
                                    ?></select>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="Notification Period Months" class=" control-label col-md-4 text-left"> Notification Period Months <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <input type="number" name='notification_period_months'  id='notification_period_months' class='form-control '
                                       required  value="{{ $row['notification_period_months'] }}" min="1"/>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="expected_time_to_finish_with_days" class=" control-label col-md-4 text-left"> Expected Days To Finish </label>
                            <div class="col-md-6">
                                <input type="number" name='expected_time_to_finish_with_days'  id='expected_time_to_finish_with_days' class='form-control '
                                       value="{{ $row['expected_time_to_finish_with_days'] }}"/>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  " >
                            <label for="Project Owner" class=" control-label col-md-4 text-left"> Project Owner </label>
                            <div class="col-md-6">
                                <select name='brand_manager_id' rows='5' id='brand_manager_id' class='select2 '   ></select>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 text-right">&nbsp;</label>
                            <div class="col-sm-8">
                                <button type="button" href="#ContractOperators" class="formControl btn btn-success btn-sm "><i class="fa  fa-arrow-circle-right "></i>  Next </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane m-t" id="ContractOperators">

                        <a class="btn btn-success btn-xs pull-right" id="AddNewCoun"><i class="fa fa-plus-circle"></i> Add More</a>
                        <br/>
                        <div class="region_div">
                        @if($id)
                            @foreach($contract_contries as $k => $country)
                            <div class="region">
                                @if($k!=0)
                                <a class="btn btn-danger btn-xs delCoun" ><i class="fa fa-trash-o"></i> Delete</a>
                                @endif
                                <div class="form-group  " >
                                    <label for="countries" class=" control-label col-md-4 text-left"> Country <span class="asterix"> * </span></label>
                                    <div class="col-md-6">
                                        <select name="countries_{{$k}}" id='countries' rows='5' required  class='form-control countries'  >
                                            <option  value ='' ></option>
                                            @foreach ($countries as $key => $val)
                                            <option  value ='{{$val->id}}' @if($contract_contries &&  $val->id == $country) selected @endif >{{$val->country}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                </div>
                                 <div class="form-group  " >
                                    <label for="Peroid" class=" control-label col-md-4 text-left"> operator <span class="asterix"> * </span></label>
                                    <div class="col-md-6">
                                        <select name="operator_id_{{$k}}[]"  rows='5' required  class='select2 operator' multiple >
                                            @foreach ($old_contract_operators[$country] as $key => $val)
                                            <option  value ='{{$val->id}}' @if($contract_operator && in_array($val->id, $contract_operator[$k])) selected @endif > {{$val->name }}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                </div>
                                <hr/>
                            </div>
                            @endforeach
                        @elseif($acquisition_id)
                            @foreach($acquisitions_contries as $k => $country)
                            <div class="region">
                                @if($k!=0)
                                <a class="btn btn-danger btn-xs delCoun" ><i class="fa fa-trash-o"></i> Delete</a>
                                @endif
                                <div class="form-group  " >
                                    <label for="countries" class=" control-label col-md-4 text-left"> Country <span class="asterix"> * </span></label>
                                    <div class="col-md-6">
                                        <select name="countries_{{$k}}" id='countries' rows='5' required  class='form-control countries'  >
                                            <option  value ='' ></option>
                                            @foreach ($countries as $key => $val)
                                            <option  value ='{{$val->id}}' @if($acquisitions_contries &&  $val->id == $country) selected @endif >{{$val->country}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                </div>
                                 <div class="form-group  " >
                                    <label for="Peroid" class=" control-label col-md-4 text-left"> operator <span class="asterix"> * </span></label>
                                    <div class="col-md-6">
                                        <select name="operator_id_{{$k}}[]"  rows='5' required  class='select2 operator' multiple >
                                            @foreach ($old_operators[$country] as $key => $val)
                                                <option  value ='{{$val->id}}' @if($acquisitions_contries && in_array($val->id, $acquisition_operator[$k])) selected @endif > {{$val->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                </div>
                                <hr/>
                            </div>
                            @endforeach
                        @else
                            <div class="region">
                                <div class="form-group  " >
                                    <label for="countries" class=" control-label col-md-4 text-left"> Country <span class="asterix"> * </span></label>
                                    <div class="col-md-6">
                                        <select name='countries_0' id='countries' rows='5' required  class='form-control countries'  >
                                            <option  value ='' ></option>
                                            @foreach ($countries as $key => $val)
                                            <option  value ='{{$val->id}}' @if($contract_contries &&  in_array($val->id, $contract_contries)) selected @endif >{{$val->country}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                </div>
                                 <div class="form-group  " >
                                <label for="Peroid" class=" control-label col-md-4 text-left"> operator <span class="asterix"> * </span></label>
                                <div class="col-md-6">
                                    <select name='operator_id_0[]'  rows='5' required  class='select2 operator' multiple >
                                        @foreach ($operators as $key => $val)
                                        <option  value ='{{$val->id}}' @if($contract_operator && in_array($val->id, $contract_operator)) selected @endif > {{$val->name }}</option>

                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">

                                </div>
                            </div>
                            </div>
                        @endif
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 text-right">&nbsp;</label>
                            <div class="col-sm-8">
                                <button type="button" href="#ContractDetails" class="formControl btn btn-info btn-sm "><i class="fa  fa-arrow-circle-left "></i>  Previous </button>
                                <button type="button" href="#ContractServices" class="formControl btn btn-success btn-sm "><i class="fa  fa-arrow-circle-right "></i>  Next </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane m-t" id="ContractServices">
                        <br/>
                        <div class="form-group  " >
                            <label for="Peroid" class=" control-label col-md-4 text-left"> Services <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <select name='service_id[]' rows='5' required  class='select2 services' multiple >
                                    @foreach ($services as $key => $val)
                                    <option  value ='{{$val->id}}' @if($contract_service) @foreach($contract_service as $CSid) @if($CSid == $val->id) selected @endif @endforeach @endif> {{$val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 text-right">&nbsp;</label>
                            <div class="col-sm-8">
                                <button type="button" href="#ContractOperators" class="formControl btn btn-info btn-sm "><i class="fa  fa-arrow-circle-left "></i>  Previous </button>
                                <button type="button" href="#ContractTemplate" class="formControl btn btn-success btn-sm "><i class="fa  fa-arrow-circle-right "></i>  Next </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane m-t" id="ContractTemplate">
                        <br/>
                        <div class="form-group  " >
                            <label for="template" class=" control-label col-md-4 text-left"> Template <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                @if($id)
                                <input type="hidden" name='template_id' required="" value="{{$row['template_id']}}">
                                @endif
                                <select name='template_id' id="template_id" rows='5' required=""  class='select2 '  @if($id) disabled="true" @endif>
                                    <option  value =''></option>
                                    @foreach ($templates as $key => $val)
                                    <option  value ='{{$val->id}}' @if($val->id == $row['template_id'] ) selected @endif > {{$val->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">

                            </div>
                            <div class="clearfix"></div>
                            <br/>
                            <div id="template_items" class="center-block col-md-8 col-md-push-2">
                                <!-- list inserted contract items if edit -->
                                @if($id)
                                    <a class="btn btn-success btn-xs" id="AddNew"><i class="fa fa-plus-circle"></i> Add More</a>
                                    <br/>
                                    <div class="bordered" style="border:1px dashed #000000b8;padding: 10px;">
                                        <div class="items">
                                            @foreach($items as $k=>$value)
                                            <div class="item" style="margin: 5px;">
                                                <a class="btn btn-danger btn-xs del-item " ><i class="fa fa-trash-o"></i> Delete</a>
                                                <select class="form-control select2" style="margin-top:20px" name="dep_id[{{$k}}][]" multiple>
                                                     <option  value =''>-- Please Select --</option>
                                                     <?php $departments_id=explode(',',$value->department_id) ?>
                                                     @foreach($departments_id as $dept_id)
                                                     @foreach($departments as $dept)
                                                        <option  value ='{{$dept->id}}' @if($dept->id == $dept_id ) selected @endif > {{$dept->title }}</option>
                                                     @endforeach
                                                     @endforeach
                                                </select>
                                                <br/>
                                                <textarea class="form-control editor" name="item[]" required="">{!!$value->item!!}</textarea>
                                                <hr style="border-top: 1px dashed #dddddd;"/>
                                            </div>

                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- end list inserted contract items if edit -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 text-right">&nbsp;</label>
                            <div class="col-sm-8">
                                <button type="button" href="#ContractServices" class="formControl btn btn-info btn-sm "><i class="fa  fa-arrow-circle-left "></i>  Previous </button>
                                <button type="button" href="#ContractAttachments" class="formControl btn btn-success btn-sm "><i class="fa  fa-arrow-circle-right "></i>  Next </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane m-t" id="ContractAttachments">
                        <br/>
                        @foreach($attachment_types as $type)
                        <div class="form-group  " >
                            <label for="Attachments" class=" control-label col-md-4 text-left"> {{$type->title}} </label>
                            <div class="col-md-6">
                                <input  type='file'   name='attachments_{{$type->id}}[]'   style="color:#f00;"  multiple=""   />

                            </div>
                            <div class="col-md-2">

                            </div>
                            @if ($contract_attachments)                                
                            @if(count($contract_attachments)>0)
                                @foreach($contract_attachments as $val)
                                    @if($val->attachment_type_id==$type->id)
                                        <div class="clearfix"></div>
                                        <div class="col-md-8 col-md-push-4">
                                            {!! SiteHelpers::showUploadedFile($val->attachment_path,'/uploads/contracts/') !!}
                                            <a class="btn btn-danger btn-xs removeCurrentFiles" href="" id="{{$val->id}}"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr style="margin-top: 5px;margin-bottom: 5px;"/>
                                    @endif
                                @endforeach
                            @endif
                            @endif

                        </div>
                        @endforeach


                        <div class="clearfix"></div>
                        <br/>
                        <div class="form-group">
                            <label class="col-sm-4 text-right">&nbsp;</label>
                            <div class="col-sm-8">
                                <button type="button" href="#ContractTemplate" class="formControl btn btn-info btn-sm "><i class="fa  fa-arrow-circle-left "></i>  Previous </button>
                                <button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
                                <button type="button" onclick="location.href ='{{ URL::to('contracts?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
                            </div>
                        </div>
                    </div>



                    <div style="clear:both"></div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div id="item" style="display: none">
        <div class="item" style="margin: 5px;">
            <a class="btn btn-danger btn-xs del-item" ><i class="fa fa-trash-o"></i> Delete</a>
            <select class="form-control department_id select2" style="margin-top:20px" name="dep_id[]" required=""  multiple>
            </select>
            <br/>
            <textarea class="form-control editor" name="item[]" required=""></textarea>
            <hr style="border-top: 1px dashed #dddddd;"/>
        </div>
    </div>
    <div id="region" style="display: none">
        <div class="region">
            <hr/>
            <a class="btn btn-danger btn-xs delCoun" ><i class="fa fa-trash-o"></i> Delete</a>
            <div class="form-group  " >
                <label for="countries" class=" control-label col-md-4 text-left"> Country <span class="asterix"> * </span></label>
                <div class="col-md-6">
                    <select name='countries[]' id='countries' rows='5' required  class='form-control countries'  >
                        <option  value ='' ></option>
                        @foreach ($countries as $key => $val)
                        <option  value ='{{$val->id}}' >{{$val->country}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">

                </div>
            </div>
            <div class="form-group  " >
                <label for="Peroid" class=" control-label col-md-4 text-left"> operator <span class="asterix"> * </span></label>
                <div class="col-md-6">
                    <select name='operator_id[]' rows='5' required  class='select2 operator' multiple >
                        @foreach ($operators as $key => $val)
                        <option  value ='{{$val->id}}' > {{$val->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">

                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="firsr_" name="" value="">
    <input type="hidden" name="" value="">
    <script type="text/javascript">
        $(document).ready(function () {
          $("#brand_manager_id").jCombo("{{ URL::to('contracts/comboselect?filter=tb_users:id:first_name|last_name') }}",
            @if($acquisition_id)
             {  selected_value : '{{ $acquisition_brand }}' });
            @else
            {  selected_value : '{{ $row["brand_manager_id"] }}' });
            @endif
            $(document).on('change','.countries', function () {
              var id = $(this).val();
              var op = $(this).closest(".region").find("select.operator");
              $.ajax({
                method: "get",
                url: "<?= url('contracts/operator') ?>",
                data: {'id': id},
                success: function (data) {
                    op.parent().find(".select2-container").remove();
                    op.html(data);
                    op.select2();
                    if($('.item .note-editable')[0])
                      var countries;
                      $(".region_div .countries").each(function(index){
                          if(index == 0) // for the first time
                              countries = $(this).find('option:selected').text();
                          else
                              countries += $(this).find('option:selected').text();
                          if(index != $(".region_div .countries").length -1) // to put , after each country except last one
                              countries += ' , ';
                      });
                      $("#template_items").find(".item .note-editable #countries").html("<sa>"+ countries +"</sa>");
                }
              });
            });
            $(document).on('change','.operator', function (index,e) {
               var operators;
               var len = $(this).find('option:selected').length;
               $(this).find('option:selected').each(function(ind){
                  if(index == 1 && ind ==0)
                      operators = $(this).text();
                  else if(ind ==0)
                      operators += " - " + $(this).text(); //  - is the sparater to the second dropdown of country
                  else
                      operators +=  $(this).text();
                  if(ind != len-1)
                      operators += ' , ';
               });

                // append selected operators to it's related country ex:
                //   first operators group +"that work in"+ first country  -  second operators group +"that work in"+ second country
                var op_name = $(this).attr("name");
                if(op_name){
                    var coun_name = op_name.replace("operator_id","countries").replace("[]","");
                    var cc = $(".countries[name='"+coun_name+"']").find('option:selected').text();
                    operators += ' العامله فى دوله /  '+ cc;
                }
                //var operators = operators.filter(Boolean)
                var operators = operators.replace('undefined - ', '')
                $("#template_items").find(".item .note-editable #operators").html("<sa>"+ operators +"</sa>");
                console.log(operators);
              });
            $('.removeCurrentFiles').on('click', function () {
              var removeUrl = "{{url('contracts/removeattach')}}";
              var id = $(this).attr('id');
              $.get(removeUrl, {'id':id}, function (response) {
              });
              $(this).parent('div').empty();
              return false;
          });
        });
        $('.ratio').on('change', function () {
            var v = $(this).val();
            var sub = 100 - v;
            $(".ratio").not(this).val(sub);
        });
        $('#startDate , #peroid').on('change', function () {
            var peroid = parseInt($('#peroid').val());
            var start = new Date($('#startDate').val());
            var end = new Date(start.getFullYear() + peroid, start.getMonth(), start.getDate()-1);
            $("#endDate").datepicker('setDate', end);
            if($('.item .note-editable')[0])
              $("#template_items").find(".item .note-editable #peroid").html("<sa>"+ peroid +"</sa>");
        });
        $('.formControl').on('click', function () {
            var attr = $(this).attr('href');
            $(".nav li a[href='" + attr + "']").parent('li').addClass('active').siblings('li').removeClass('active');
            $(attr).addClass('active').siblings('div').removeClass('active');
            $('html, body').animate({
            scrollTop: $(".nav").offset().top
            }, 500, 'linear');
        });
        $('.date').on('changeDate', function(e){
            $(this).datepicker('hide');
        });
        $('.date').attr('autocomplete','off');
    </script>
    <script>
        var first_commercial_register_no , first_tax_card_no , second_commercial_register_no , second_first_tax_card_no;
        $("#first_part").change(function(){
          id = $(this).val();
          $.get("{{url('provider_info')}}"+'/'+id , function(response){
            console.log(response);
            $('#first_part_name').val(response.provider_name);
            $('#first_part_phone').val(response.provider_phone);
            $('#first_part_address').val(response.provider_address);
            $('#first_part_email').val(response.provider_email);
            first_commercial_register_no = response.provider_commercial_register_no;
            first_tax_card_no = response.provider_tax_card_no;
            if($('.item .note-editable')[0])
              $("#template_items").find(".item .note-editable #first_part_name").html("<sa>"+ response.provider_name +"</sa>");
              $("#template_items").find(".item .note-editable #first_part_address").html("<sa>"+ response.provider_address +"</sa>");
              $("#template_items").find(".item .note-editable #first_part_email").html("<sa>"+ response.provider_email +"</sa>");
              $("#template_items").find(".item .note-editable #first_part_phone").html("<sa>"+ response.provider_phone +"</sa>");
              $("#template_items").find(".item .note-editable #first_commercial_register_no").html("<sa>"+ response.provider_commercial_register_no +"</sa>");
              $("#template_items").find(".item .note-editable #first_tax_card_no").html("<sa>"+ response.provider_tax_card_no +"</sa>");

          });
        });

        $("#second_part").change(function(){
            id = $(this).val();
          $.get("{{url('provider_info')}}"+'/'+id , function(response){
            $('#second_part_name').val(response.provider_name);
            $('#second_part_phone').val(response.provider_phone);
            $('#second_part_address').val(response.provider_address);
            $('#second_part_email').val(response.provider_email);
            second_commercial_register_no = response.provider_commercial_register_no;
            second_tax_card_no = response.provider_tax_card_no;
            if($('.item .note-editable')[0])
              $("#template_items").find(".item .note-editable #second_part_name").html("<sa>"+ response.provider_name +"</sa>");
              $("#template_items").find(".item .note-editable #second_part_address").html("<sa>"+ response.provider_address +"</sa>");
              $("#template_items").find(".item .note-editable #second_part_email").html("<sa>"+ response.provider_email +"</sa>");
              $("#template_items").find(".item .note-editable #second_part_phone").html("<sa>"+ response.provider_phone +"</sa>");
              $("#template_items").find(".item .note-editable #second_commercial_register_no").html("<sa>"+ response.provider_commercial_register_no +"</sa>");
              $("#template_items").find(".item .note-editable #second_tax_card_no").html("<sa>"+ response.provider_tax_card_no +"</sa>");
          });
        })

        $("#signed_date").change(function(){
          var signed_date = $("#signed_date").val();
          var day_name = ["اللأحد","الأثنين","الثلاثاء","الأربعاء","الخميس","الجمعة","السبت"][new Date(signed_date).getDay()];
          if($('.note-editable #signed_date')[0])
            $("#template_items").find(".item .note-editable #signed_date").html("<sa>"+signed_date+"</sa>");
             $("#template_items").find(".item .note-editable #day_name").html("<sa>"+day_name+"</sa>");
        })
        $(".services").change(function(){
          var services;
          $(this).each(function(index){
               var len = $(this).find('option:selected').length;
              $(this).find('option:selected').each(function(ind){

                  if(ind ==0)
                      services = $(this).text();
                  else
                      services += $(this).text();

                  if(ind != len-1)
                      services += ' , ';

              })
          });
          if($('.note-editable #signed_date')[0])
            $("#template_items").find(".item .note-editable #services").html("<sa>"+services+"</sa>");
        })
        $('#template_id').on('change', function(){
            var id = $(this).val();
            var url = "<?= url('items/get/') ?>";
            url += "/"+id;
            //get form input value
                var countries , operators , services;
                var signed_date = $("#signed_date").val();
                var first_part_name = $("#first_part_name").val();
                var first_part_address = $("#first_part_address").val();
                var second_part_name = $("#second_part_name").val();
                var second_part_address = $("#second_part_address").val();
                $(".region_div .countries").each(function(index){
                    if(index == 0) // for the first time
                        countries = $(this).find('option:selected').text();
                    else
                        countries += $(this).find('option:selected').text();
                    if(index != $(".region_div .countries").length -1) // to put , after each country except last one
                        countries += ' , ';
                });




                $(".region_div .operator").each(function(index){
                     var len = $(this).find('option:selected').length;
                    $(this).find('option:selected').each(function(ind){


                        if(index == 1 && ind ==0)
                            operators = $(this).text();
                        else if(ind ==0)
                            operators += " - " + $(this).text(); //  - is the sparater to the second dropdown of country
                        else
                            operators +=  $(this).text();

                        if(ind != len-1)
                            operators += ' , ';
                    });

                    // append selected operators to it's related country ex:
                    //   first operators group +"that work in"+ first country  -  second operators group +"that work in"+ second country
                    var op_name = $(this).attr("name");
                    if(op_name){
                        var coun_name = op_name.replace("operator_id","countries").replace("[]","");
                        var cc = $(".countries[name='"+coun_name+"']").find('option:selected').text();
                        operators += ' العامله فى دوله /  '+ cc;
                    }

                });


                $(".services").each(function(index){
                     var len = $(this).find('option:selected').length;
                    $(this).find('option:selected').each(function(ind){

                        if(ind ==0)
                            services = $(this).text();
                        else
                            services += $(this).text();

                        if(ind != len-1)
                            services += ' , ';

                    })
                });




                var second_part_address = $("#second_part_address").val();
                var peroid = $("#peroid").val();
                var first_part_email = $("#first_part_email").val();
                var second_part_email = $("#second_part_email").val();
                var first_part_phone = $("#first_part_phone").val();
                var second_part_phone = $("#second_part_phone").val();
                var day_name = ["اللأحد","الأثنين","الثلاثاء","الأربعاء","الخميس","الجمعة","السبت"][new Date(signed_date).getDay()];

                $.ajax({
                method: "get",
                        url: url,
                        success: function (data) {
                        $("#template_items").html(data);
                        // drop input values to items
                         $("#template_items").find(".item .note-editable #signed_date").html("<sa>"+signed_date+"</sa>");
                         $("#template_items").find(".item .note-editable #first_part_name").html("<sa>"+ first_part_name +"</sa>");
                         $("#template_items").find(".item .note-editable #second_part_name").html("<sa>"+second_part_name +"</sa>");
                         $("#template_items").find(".item .note-editable #first_part_address").html("<sa>"+ first_part_address +"</sa>");
                         $("#template_items").find(".item .note-editable #second_part_address").html("<sa>"+ second_part_address +"</sa>");
                         $("#template_items").find(".item .note-editable #countries").html("<sa>"+ countries +"</sa>");
                         $("#template_items").find(".item .note-editable #operators").html("<sa>"+ operators +"</sa>");
                         $("#template_items").find(".item .note-editable #peroid").html("<sa>"+ peroid +"</sa>");
                         $("#template_items").find(".item .note-editable #first_part_email").html("<sa>"+ first_part_email +"</sa>");
                         $("#template_items").find(".item .note-editable #second_part_email").html("<sa>"+ second_part_email +"</sa>");
                         $("#template_items").find(".item .note-editable #first_part_phone").html("<sa>"+ first_part_phone +"</sa>");
                         $("#template_items").find(".item .note-editable #second_part_phone").html("<sa>"+ second_part_phone +"</sa>");
                         $("#template_items").find(".item .note-editable #services").html("<sa>"+services+"</sa>");
                         $("#template_items").find(".item .note-editable #day_name").html("<sa>"+day_name+"</sa>");
                         $("#template_items").find(".item .note-editable #first_commercial_register_no").html("<sa>"+ first_commercial_register_no +"</sa>");
                         $("#template_items").find(".item .note-editable #first_tax_card_no").html("<sa>"+ first_tax_card_no +"</sa>");
                         $("#template_items").find(".item .note-editable #second_commercial_register_no").html("<sa>"+ second_commercial_register_no +"</sa>");
                         $("#template_items").find(".item .note-editable #second_tax_card_no").html("<sa>"+ second_tax_card_no +"</sa>");

                    }
                });
        });
        // add more item
        $(document).on('click', '#AddNew', function(){
              $(".bordered").append($("#item").html());
         });
        // delete item
        $(document).on('click', '.del-item', function(){
                $(this).parent('.item').remove();

         });
          $(".department_id").jCombo("{{ URL::to('commitments/comboselect?filter=tb_departments:id:title') }}");

          // add more
        @if($id)
            var k = <?=count($contract_contries)-1?>;
        @else
            var k =0;
        @endif
        $(document).on('click', '#AddNewCoun', function(){
            k++;
            $("#ContractOperators .region_div").append($("#region").html());
            $("#ContractOperators .region").last().find("select.operator").attr('name',"operator_id_"+k+"[]");
            $("#ContractOperators .region").last().find("select.countries").attr('name',"countries_"+k);
        });
        // delete country
        $(document).on('click', '.delCoun', function(){
                $(this).parent('.region').remove();

         });
        // contract type

        @if($id)
            @if($row['final_approve'] == 0)
                var oldContractType = $("#contract_type").val();
                if(oldContractType == 1){
                    $("#ContractAttachments :input:not(.btn)").attr('disabled','disabled');
                    $("#ContractAttachments").append('<p class="text-danger extra">You Can upload files after contract approve');

                }
                else if(oldContractType == 2){
                    $("#ContractTemplate :input:not(.btn)").attr('disabled','disabled');
                    $("#ContractTemplate").append("<p class='text-danger extra'>You don't need to select template ...you can upload contract files" );
                }
            @else
                $("#contract_type").change(function(){
                $('.extra').remove();
                if($(this).val()== 1){
                        $("#ContractTemplate :input:not(.btn)").removeAttr('disabled');
                    }
                else if($(this).val()== 2){
                        $("#ContractTemplate :input:not(.btn)").attr('disabled','disabled');
                        $("#ContractTemplate").append("<p class='text-danger extra'>You don't need to select template ...you can upload contract files" );
                    }
                })
            @endif
        @else
            //add
            $("#contract_type").change(function(){
                $('.extra').remove();
                if($(this).val()== 1){
                    $("#ContractTemplate :input:not(.btn)").removeAttr('disabled');
                    $("#ContractAttachments :input:not(.btn)").attr('disabled','disabled');
                    $("#ContractAttachments").append('<p class="text-danger extra">You Can upload files after contract approve');

                }
                else if($(this).val()== 2){
                    $("#ContractAttachments :input:not(.btn)").removeAttr('disabled');
                    $("#ContractTemplate :input:not(.btn)").attr('disabled','disabled');
                    $("#ContractTemplate").append("<p class='text-danger extra'>You don't need to select template ...you can upload contract files" );
                }
            })
        @endif



    </script>
    @stop
