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
            <li><a href="{{ URL::to('templateitems?return='.$return) }}">{{ $pageTitle }}</a></li>
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

                {!! Form::open(array('url'=>'templateitems/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
                <div class="col-md-12">
                    <fieldset><legend> template_items</legend>

                        <div class="form-group  " >
                            <label for="Item" class=" control-label col-md-4 text-left"> Item <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <textarea name='item' rows='5' id='editor' class='form-control editor1 '  
                                          required >{{ $row['item'] }}</textarea> 
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 					
                        <div class="form-group  " >
                            <label for="Template Id" class=" control-label col-md-4 text-left"> Template Id <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <select name='template_id' rows='5' id='template_id' class='select2 ' required  ></select> 
                            </div> 
                            <div class="col-md-2">

                            </div>
                        </div> 					
                        <div class="form-group  " >
                            <label for="Department Id" class=" control-label col-md-4 text-left"> Department Id </label>
                            <div class="col-md-6">
                                <select name='department_id' rows='5' id='department_id' class='select2 '   ></select> 
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
                        <button type="button" onclick="location.href ='{{ URL::to('templateitems?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
                    </div>	  

                </div> 

                {!! Form::close() !!}
            </div>
        </div>		 
    </div>	
</div>			 
<script type="text/javascript">
    $(document).ready(function () {


        $("#template_id").jCombo("{{ URL::to('templateitems/comboselect?filter=templates:id:id') }}",
                {selected_value: '{{ $row["template_id"] }}'});

        $("#department_id").jCombo("{{ URL::to('templateitems/comboselect?filter=tb_departments:id:id') }}",
                {selected_value: '{{ $row["department_id"] }}'});


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