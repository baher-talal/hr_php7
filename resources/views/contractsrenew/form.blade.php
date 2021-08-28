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
            <li><a href="{{ URL::to('contractsrenew?return='.$return) }}">{{ $pageTitle }}</a></li>
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

                {!! Form::open(array('url'=>'contractsrenew/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
                <div class="col-md-12">
                    <fieldset><legend> Contracts_renew</legend>

                        <div class="form-group hidethis " style="display:none;">
                            <label for="Id" class=" control-label col-md-4 text-left"> Id </label>
                            <div class="col-md-6">
                                {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 					
                        <div class="form-group hidethis " style="display:none;">
                            <label for="Contract Id" class=" control-label col-md-4 text-left"> Contract Id <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('contract_id', $contract_id,array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 					
                        <div class="form-group  " >
                            <label for="Start Date" class=" control-label col-md-4 text-left"> Start Date <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <div class="input-group m-b" style="width:150px !important;">
                                    {!! Form::text('start_date', $row['start_date'],array('class'=>'form-control date')) !!}
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div> 
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 					
                        <div class="form-group  " >
                            <label for="End Date" class=" control-label col-md-4 text-left"> End Date <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <div class="input-group m-b" style="width:150px !important;">
                                    {!! Form::text('end_date', $row['end_date'],array('class'=>'form-control date')) !!}
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div> 
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> </fieldset>
                </div>




                <div style="clear:both"></div>	


                <div class="form-group">
                    <label class="col-sm-4 text-right">&nbsp;</label>
                    <div class="col-sm-8">	
                       
                        <button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
                        <button type="button" onclick="location.href ='{{ URL::to('contractsrenew?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
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
          $('.date').on('changeDate', function(e){
            $(this).datepicker('hide');
        });
    });
</script>		 
@stop