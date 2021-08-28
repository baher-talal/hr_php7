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
            <li><a href="{{ URL::to('mytravelling?return='.$return) }}">{{ $pageTitle }}</a></li>
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

                {!! Form::open(array('url'=>'mytravelling/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ','id'=>'travelling_form')) !!}
                <div class="col-md-12">
                    <fieldset><legend> mytravelling</legend>

                        <div class="form-group hidethis " style="display:none;">
                            <label for="Id" class=" control-label col-md-4 text-left"> Id </label>
                            <div class="col-md-6">
                                {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
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
                            <label for="Want Visa" class=" control-label col-md-4 text-left"> Want Visa <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <label class='radio radio-inline'>
                                    <input type='radio' name='want_visa' value ='0' required @if($row['want_visa'] == '0') checked="checked" @endif > No </label>
                                <label class='radio radio-inline'>
                                    <input type='radio' name='want_visa' value ='1' required @if($row['want_visa'] == '1') checked="checked" @endif > Yes </label> 
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> </fieldset>
                </div>




                <div style="clear:both"></div>	


                <div class="form-group">
                    <label class="col-sm-4 text-right">&nbsp;</label>
                    <div class="col-sm-8">	
                        <button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
                        <button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
                        <button type="button" onclick="location.href ='{{ URL::to('mytravelling?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
                    </div>	  

                </div> 

                {!! Form::close() !!}
            </div>
        </div>		 
    </div>	
</div>			 
<script type="text/javascript">
    $(document).ready(function () {


        $("#country_id").jCombo("{{ URL::to('mytravelling/comboselect?filter=tb_countries:id:country') }}",
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