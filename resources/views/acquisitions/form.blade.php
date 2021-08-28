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
            <li><a href="{{ URL::to('acquisitions?return='.$return) }}">{{ $pageTitle }}</a></li>
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

                {!! Form::open(array('url'=>'acquisitions/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
                <div class="col-md-12">
                    <fieldset><legend> Acquisitions</legend>

                        <div class="form-group hidethis " style="display:none;">
                            <label for="Id" class=" control-label col-md-4 text-left"> Id </label>
                            <div class="col-md-6">
                                {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div> 
                        <div class="form-group  " >
                            <label for="Provider Id" class=" control-label col-md-4 text-left"> Provider Id <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <select name='provider_id' rows='5' id='provider_id' class='select2 ' required  ></select>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div> 
                        <div class="form-group  " >
                            <label for="Business Case" class=" control-label col-md-4 text-left"> Business Case </label>
                            <div class="col-md-6">
                                <input  type='file' name='business_case' id='business_case' @if($row['business_case'] =='') class='required' @endif style='width:150px !important;'  />
                                        <div >
                                    {!! SiteHelpers::showUploadedFile($row['business_case'],'/uploads/acquisitions/') !!}

                                </div>

                            </div>
                            <div class="col-md-2">

                            </div>
                        </div> 
                        <div class="form-group  " >
                            <label for="Brand Manager " class=" control-label col-md-4 text-left"> Brand Manager  <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <select name='brand_manager_id' rows='5' id='brand_manager_id' class='select2 ' required  ></select>
                            </div>
                            <div class="col-md-2" id="brand_manager_info">
                                @if($row['brand_manager_id'])
                                {{$brand_manager_info->email}}
                                {{$brand_manager_info->phone_number}}
                                @endif
                            </div>
                        </div> 
                        <div class="form-group  " >
                            <label for="Wikipedia" class=" control-label col-md-4 text-left"> Wikipedia </label>
                            <div class="col-md-6">
                                {!! Form::text('wikipedia', $row['wikipedia'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div> 

                        <div class="form-group  " >
                            <label for="Youtube" class=" control-label col-md-4 text-left"> Youtube </label>
                            <div class="col-md-6">
                                {!! Form::text('youtube', $row['youtube'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div> 
                        <div class="form-group  " >
                            <label for="Facebook" class=" control-label col-md-4 text-left"> Facebook </label>
                            <div class="col-md-6">
                                {!! Form::text('facebook', $row['facebook'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div> 

                        <div class="form-group  " >
                            <label for="Twitter" class=" control-label col-md-4 text-left"> Twitter </label>
                            <div class="col-md-6">
                                {!! Form::text('twitter', $row['twitter'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div> 
                        <div class="form-group  " >
                            <label for="Instagram" class=" control-label col-md-4 text-left"> Instagram </label>
                            <div class="col-md-6">
                                {!! Form::text('instagram', $row['instagram'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div> 
                        <div class="form-group  " >
                            <label for="Sample Links" class=" control-label col-md-4 text-left"> Sample Links </label>
                            <div class="col-md-6">
                                <textarea name='sample_links' rows='5' id='sample_links' class='form-control '
                                          >{{ $row['sample_links'] }}</textarea>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div> 
                        <div class="form-group  " >
                            <label for="Content Type" class=" control-label col-md-4 text-left"> Content Type <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <?php
                                $content_type = explode(',', $row['content_type']);
                                $content_type_opt = array('1' => 'In', '2' => 'Out',);
                                ?>
                                <select name='content_type' rows='5' required  class='select2 '  > 
                                    <?php
                                    foreach ($content_type_opt as $key => $val) {
                                        echo "<option  value ='$key' " . ($row['content_type'] == $key ? " selected='selected' " : '' ) . ">$val</option>";
                                    }
                                    ?></select>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div> 
                        <div class="form-group  " >
                            <label for="Content Classification" class=" control-label col-md-4 text-left"> Content Classification <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <?php
                                $content_classification = explode(',', $row['content_classification']);
                                $content_classification_opt = array('rbt' => 'Rbt', 'alert' => 'Alert', 'both' => 'Both', 'other' => 'Other',);
                                ?>
                                <select name='content_classification' rows='5' required  class='select2 '  > 
                                    <?php
                                    foreach ($content_classification_opt as $key => $val) {
                                        echo "<option  value ='$key' " . ($row['content_classification'] == $key ? " selected='selected' " : '' ) . ">$val</option>";
                                    }
                                    ?></select>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <a class="btn btn-success btn-xs pull-right" id="AddNewCoun"><i class="fa fa-plus-circle"></i> Add More</a>
                        <br/>
                        <div class="region_div">
                            @if($id)
                            @foreach($acquisition_contries as $k => $country)
                            <div class="region">
                                <a class="btn btn-danger btn-xs delCoun" ><i class="fa fa-trash-o"></i> Delete</a> 

                                <div class="form-group  " >
                                    <label for="countries" class=" control-label col-md-4 text-left"> Country <span class="asterix"> * </span></label>
                                    <div class="col-md-6">                                
                                        <select name="countries_{{$k}}" id='countries' rows='5' required  class='form-control countries'  > 
                                            <option  value ='' ></option>                                   
                                            @foreach ($countries as $key => $val) 
                                            <option  value ='{{$val->id}}' @if($acquisition_contries &&  $val->id == $country) selected @endif >{{$val->country}}</option>
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
                                            <option  value ='{{$val->id}}' @if($acquisition_operator && in_array($val->id, $acquisition_operator[$k])) selected @endif > {{$val->name }}</option> 

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
                                            <option  value ='{{$val->id}}'  >{{$val->country}}</option>
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
                                            <option  value ='{{$val->id}}' > {{$val->name }}</option> 

                                            @endforeach
                                        </select> 
                                    </div> 
                                    <div class="col-md-2">

                                    </div>
                                </div> 		
                            </div> 		
                            @endif
                        </div>  
                    </fieldset>
                </div>




                <div style="clear:both"></div>	


                <div class="form-group">
                    <label class="col-sm-4 text-right">&nbsp;</label>
                    <div class="col-sm-8">	
                        <button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
                        <button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
                        <button type="button" onclick="location.href ='{{ URL::to('acquisitions?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
                    </div>	  

                </div> 

                {!! Form::close() !!}
            </div>
        </div>		 
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
<script type="text/javascript">
            $(document).ready(function () {


    $("#provider_id").jCombo("{{ URL::to('acquisitions/comboselect?filter=providers:id:provider_name') }}",
    {selected_value: '{{ $row["provider_id"] }}'});
            $("#brand_manager_id").jCombo("{{ URL::to('acquisitions/comboselect?filter=tb_users:id:first_name|last_name') }}",
    {selected_value: '{{ $row["brand_manager_id"] }}'});
            $('.removeCurrentFiles').on('click', function () {
    var removeUrl = $(this).attr('href');
            $.get(removeUrl, function (response) {
            });
            $(this).parent('div').empty();
            return false;
    });
            $(document).on('change', '.countries', function () {
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
                    }
            });
    });
    });
            // add more 
            @if ($id)
            var k = <?= count($acquisition_contries) - 1 ?>;
            @else
             var k = 0;
            @endif
            $(document).on('click', '#AddNewCoun', function(){
    k++;
            $(".region_div").append($("#region").html());
            $(".form-horizontal .region").last().find("select.operator").attr('name', "operator_id_" + k + "[]");
            $(".form-horizontal .region").last().find("select.countries").attr('name', "countries_" + k);
    });
            // delete country
            $(document).on('click', '.delCoun', function(){
                $(this).parent('.region').remove();
           });
            $(document).on('change', '#brand_manager_id', function () {
                           var id = $(this).val()
                            $.ajax({
                            method: "get",
                                    url: "<?= url('acquisitions/userinfo') ?>",
                                    data: {'id': id},
                                    success: function (data) {
                                    $('#brand_manager_info').html(data.email + '<br/>' + data.phone)
                                    }
                            });
    });
</script>		 
@stop