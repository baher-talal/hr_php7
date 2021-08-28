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
            <li><a href="{{ URL::to('commitments?return='.$return) }}">{{ $pageTitle }}</a></li>
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

                {!! Form::open(array('url'=>'commitments/save?return='.$return, 'class'=>'form-horizontal','files' => true )) !!}
                <div class="col-md-12">
                    <fieldset><legend> Commitments</legend>
                        @if(!$row['id'])
                        <button class="btn btn-warning pull-right addMore">Add More</button>
                        @endif
                        <div id="Detials" >
                            <div class="form-group hidethis " style="display:none;">
                                <label for="Id" class=" control-label col-md-4 text-left"> Id </label>
                                <div class="col-md-6">
                                    {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
                                </div> 
                                <div class="col-md-2">

                                </div>
                            </div>
                            @if($contract_id)                            
                            <div class="form-group hidethis " style="display:none;" >
                                <label for="Contract Id" class=" control-label col-md-4 text-left"> Contract <span class="asterix"> * </span></label>
                                <div class="col-md-6">
                                    {!! Form::text('contract_id', $contract_id,array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
                                </div> 
                                <div class="col-md-2">

                                </div>
                            </div> 
                            @else
                            <div class="form-group  " >
                                <label for="Contract Id" class=" control-label col-md-4 text-left"> Contract </label>
                                <div class="col-md-6">
                                    <select name='contract_id' rows='5' id='contract_id' class='select2 '   ></select> 
                                </div> 
                                <div class="col-md-2">

                                </div>
                            </div> 
                            @endif
                            <div class="form-group  " >
                                <label for="Project Id" class=" control-label col-md-4 text-left"> Project </label>
                                <div class="col-md-6">
                                    <select name='project_id' rows='5' id='project_id' class='select2 '   ></select> 
                                </div> 
                                <div class="col-md-2">

                                </div>
                            </div>
                            <div id="CommitmentDetials" >
                                <div class="Commitmentblock" >
                                    <div class="form-group  " >
                                        <label for="Department Id" class=" control-label col-md-4 text-left"> Department <span class="asterix"> * </span></label>
                                        <div class="col-md-6">
                                            <select name='department_id[]' rows='5' id='department_id' class='form-control ' required  ></select> 
                                        </div> 
                                        <div class="col-md-2">

                                        </div>
                                    </div> 					

                                    <div class="form-group  " >
                                        <label for="Commitment" class=" control-label col-md-4 text-left"> Commitment <span class="asterix"> * </span></label>
                                        <div class="col-md-6">
                                            <textarea name='commitment[]' rows='5' class='commitment form-control ' data-parsley-trigger="change"
                                                      required  >{{ $row['commitment'] }}</textarea> 
                                        </div> 
                                        <div class="col-md-2">

                                        </div>
                                    </div> 					
                                    <div class="form-group  " >
                                        <label for="Notes" class=" control-label col-md-4 text-left"> Notes </label>
                                        <div class="col-md-6">
                                            <textarea name='notes[]' rows='5' id='notes' class='form-control '  
                                                      >{{ $row['notes'] }}</textarea> 
                                        </div> 
                                        <div class="col-md-2">

                                        </div>
                                    </div> 
                                    <div class="form-group  " >
                                        <label for="Priority" class=" control-label col-md-4 text-left"> Priority <span class="asterix"> * </span></label>
                                        <div class="col-md-6">
                                            <select name='priority[]' rows='5' id='priority' class='form-control'  required ></select> 
                                        </div> 
                                        <div class="col-md-2">

                                        </div>
                                    </div>
                                    <hr/>
                                </div>                          
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
                        <button type="button" onclick="location.href ='{{ URL::to('commitments?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
                        @if(!$row['id'])
                        <button class="btn btn-warning addMore">Add More</button>
                        @endif
                    </div>	  

                </div> 

                {!! Form::close() !!}
            </div>
        </div>		 
    </div>	
</div>			 
<script type="text/javascript">
    $(document).ready(function () {

        $("#contract_id").jCombo("{{ URL::to('commitments/comboselect?filter=tb_contracts:id:title') }}",
                {selected_value: '{{ $row["contract_id"] }}'});

        $("#department_id").jCombo("{{ URL::to('commitments/comboselect?filter=tb_departments:id:title') }}",
                {selected_value: '{{ $row["department_id"] }}'});

        $("#priority").jCombo("{{ URL::to('commitments/comboselect?filter=priorities:id:value') }}",
                {selected_value: '{{ $row["priority"] }}'});

        $("#project_id").jCombo("{{ URL::to('commitments/comboselect?filter=projects:id:name') }}",
                {selected_value: '{{ $row["project_id"] }}'});
                
        $('.removeCurrentFiles').on('click', function () {
            var removeUrl = $(this).attr('href');
            $.get(removeUrl, function (response) {
            });
            $(this).parent('div').empty();
            return false;
        });

        $('.addMore').on('click', function (event) {
            event.preventDefault();
            $('#Detials').append("<a class='del btn btn-danger pull-right' href='javascript:void(0);'><i class='fa fa-trash-o'></i></a>");
            $('#Detials').append($('#CommitmentDetials').html());

        });
    });
    $(document).on("click", ".del", function () {
        $(this).next('.Commitmentblock').remove();
        $(this).remove();
    });
    
    // to remove current employee department after all ajax  complete 
    $('body').ajaxComplete(function () {
        $('#department_id option[value="{{\Auth::user()->department_id}}"]').remove();
    });

</script>		 
@stop