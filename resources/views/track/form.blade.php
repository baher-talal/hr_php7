@extends('layouts.app')

@section('content')

<?php
if(isset($_REQUEST['album_id'] )){
  $albumId = $_REQUEST['album_id'];
}else{
       $albumId = "";
}


?>

<div class="page-content row" >
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
        </div>
        <ul class="breadcrumb">
            <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
            <li><a href="{{ URL::to('track?return='.$return) }}">{{ $pageTitle }}</a></li>
            <!--            <li class="active">{{ Lang::get('core.addedit') }} </li>-->
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

                {!! Form::open(array('url'=>'track/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
                <div class="col-md-12">
                    <fieldset><legend> tracks</legend>

                        <div class="form-group hidethis " style="display:none;">
                            <label for="Id" class=" control-label col-md-4 text-left"> Id </label>
                            <div class="col-md-6">
                                {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>


                        <div class="form-group  " >
                            <label for="Album Id" class=" control-label col-md-4 text-left"> Album  <span class="asterix"> * </span> </label>
                            <div class="col-md-6">
                                <select name='album_id' rows='5' id='album_id' class='select2 ' required  ></select>
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="Select Album"><i class="icon-question2"></i></a>
                            </div>
                        </div>


                        <div class="form-group  " >
                            <label for="Web Audition Preview" class=" control-label col-md-4 text-left"> RBT file name .wav <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('web_audition_preview', $row['web_audition_preview'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true','id'=>'web_audition_preview'  )) !!}
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="RBT1.wav"><i class="icon-question2"></i></a>
                            </div>
                        </div>

                        {!! Form::hidden('aip_play_rbt', $row['aip_play_rbt'],array('class'=>'form-control', 'placeholder'=>'', 'id'=>'aip_play_rbt'  )) !!}
                        {!! Form::hidden('wap_audition_rbt', $row['wap_audition_rbt'],array('class'=>'form-control', 'placeholder'=>'',  'id'=>'wap_audition_rbt'  )) !!}
                        {!! Form::hidden('language_prompt_rbt', $row['language_prompt_rbt'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' ,'id'=>'language_prompt_rbt'  )) !!}
                        {!! Form::hidden('rbt_name', $row['rbt_name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' ,  'id'=>'rbt_name' )) !!}
                        {!! Form::hidden('initial_rbt_name', $row['initial_rbt_name'],array('class'=>'form-control', 'placeholder'=>'', 'id'=>'initial_rbt_name' )) !!}



                        <div class="form-group  " >
                            <label for="Singer Name" class=" control-label col-md-4 text-left"> Singer name En <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('singer_name', $row['singer_name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' , 'id'=>'singer_name' )) !!}
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="Singer name in english"><i class="icon-question2"></i></a>
                            </div>
                        </div>

                        {!! Form::hidden('initial_singer_name', $row['initial_singer_name'],array('class'=>'form-control', 'placeholder'=>'',  'id'=>'initial_singer_name' )) !!}





                        <div class="form-group  " >
                            <label for="Singer Gender" class=" control-label col-md-4 text-left"> Singer Gender <span class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <label class='radio radio-inline'>
                                    <input type='radio' name='singer_gender' value ='1' required @if($row['singer_gender'] == '1') checked="checked" @endif > male </label>
                                <label class='radio radio-inline'>
                                    <input type='radio' name='singer_gender' value ='2' required @if($row['singer_gender'] == '2') checked="checked" @endif > female </label>
                                <label class='radio radio-inline'>
                                    <input type='radio' name='singer_gender' value ='-1' required @if($row['singer_gender'] == '-1') checked="checked" @endif > singer group </label>
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="Singer Gender"><i class="icon-question2"></i></a>
                            </div>
                        </div>


                        <div class="form-group  " >
                            <label for="Value Of Category" class=" control-label col-md-4 text-left"> Value Of Category <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('value_of_category', $row['value_of_category'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number'   )) !!}
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="Select from list"><i class="icon-question2"></i></a>
                            </div>
                        </div>


                        <div class="form-group  " >
                            <label for="Rbt Information" class=" control-label col-md-4 text-left"> Rbt Information </label>
                            <div class="col-md-6">
                                {!! Form::text('rbt_information', $row['rbt_information'],array('class'=>'form-control', 'placeholder'=>'', 'readonly' ,  'id'=>'rbt_information' )) !!}
                            </div>

                            <div class="col-md-2">
                                <a id="rbt_information_enable" href="javascript:void(0)"  >Enable</a>
                                &nbsp; &nbsp;
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="Any Additional information or description"><i class="icon-question2"></i></a>

                            </div>

                        </div>



                        {!! Form::hidden('rbt_price', 5 ,array('class'=>'form-control', 'placeholder'=>'', 'readonly'  )) !!}



                        <div class="form-group  " >
                            <label for="Validity Period Rbt" class=" control-label col-md-4 text-left"> Validity Period Rbt <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <?php
                                if($row['validity_period_rbt']){
                                    $validity_period_rbt =  $row['validity_period_rbt'] ;
                                }else{
                                    $validity_period_rbt = '2030-12-09';
                                }

                                  ?>
                                <div class="input-group m-b" style="width:150px !important;">
                                    {!! Form::text('validity_period_rbt', $validity_period_rbt,array('class'=>'form-control' ,'id'=>'validity_period_rbt' )) !!}
                                    <span    class="input-group-addon  date_set"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="an Absolute Validity Period of an RBT"><i class="icon-question2"></i></a>
                            </div>
                        </div>


                        <div class="form-group  " >
                            <label for="Language Code" class=" control-label col-md-4 text-left"> Language Code <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('language_code', 3,array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number'   )) !!}
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="Always 3 for English"><i class="icon-question2"></i></a>
                            </div>
                        </div>


                        <div class="form-group  " >
                            <label for="Relative Expiry Rbt" class=" control-label col-md-4 text-left"> Relative Expiry Rbt </label>
                            <div class="col-md-6">
                                {!! Form::text('relative_expiry_rbt', 30 ,array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="Default Value is 30"><i class="icon-question2"></i></a>
                            </div>
                        </div>


                        <div class="form-group  " >
                            <label for="Allowed Cut" class=" control-label col-md-4 text-left"> Allowed Cut </label>
                            <div class="col-md-6">
                                {!! Form::text('allowed_cut',0,array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="0"><i class="icon-question2"></i></a>
                            </div>
                        </div>


                        <div class="form-group  " >
                            <label for="Movie Name" class=" control-label col-md-4 text-left"> Movie Name </label>
                            <div class="col-md-6">
                                {!! Form::text('movie_name', $row['movie_name'],array('class'=>'form-control', 'placeholder'=>''  )) !!}
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="Movie Name"><i class="icon-question2"></i></a>
                            </div>
                        </div>


                        {!! Form::hidden('sub_cp_id', $row['sub_cp_id'],array('class'=>'form-control', 'placeholder'=>'',  'readonly'   )) !!}





                        <div class="form-group  " >
                            <label for="Price Group Id" class=" control-label col-md-4 text-left"> Price Group Id </label>
                            <div class="col-md-6">
                                {!! Form::text('price_group_id',10001,array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="add tarrif ID usually 10001"><i class="icon-question2"></i></a>
                            </div>
                        </div>



                        {!! Form::hidden('company_lyrics', $row['company_lyrics'],array('class'=>'form-control', 'placeholder'=>'',  'readonly'  )) !!}
                        {!! Form::hidden('dt_lyrics', $row['dt_lyrics'],array('class'=>'form-control', 'placeholder'=>'',  'readonly'  )) !!}
                        {!! Form::hidden('company_id_tune', $row['company_id_tune'],array('class'=>'form-control', 'placeholder'=>'',  'readonly'  )) !!}



                        <div class="form-group  " >
                            <label for="Date Tune" class=" control-label col-md-4 text-left"> Validity tune date <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                <?php
                                if($row['date_tune']){
                                    $dateTune =  $row['date_tune'] ;
                                }else{
                                    $dateTune = '2030-12-09';
                                }

                                  ?>
                                <div class="input-group m-b" style="width:150px !important;">
                                    {!! Form::text('date_tune', $dateTune ,array('class'=>'form-control')) !!}
                                    <span class="input-group-addon date_set"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="'Is it fine to put 2020-12-31 for all?
yes, it's fine"><i class="icon-question2"></i></a>
                            </div>
                        </div>


                     {!! Form::hidden('company_id', $row['company_id'],array('class'=>'form-control', 'placeholder'=>'' , 'readonly'   )) !!}
                      {!! Form::hidden('validity_date', $row['validity_date'],array('class'=>'form-control', 'placeholder'=>'',  'readonly'  )) !!}







                        <div class="form-group  " >
                            <label for="Allowed Channels" class=" control-label col-md-4 text-left"> Allowed Channels </label>
                            <div class="col-md-6">
                                {!! Form::text('allowed_channels','ALL',array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="you can set it ALL or use different channel names seprated by comma"><i class="icon-question2"></i></a>
                            </div>
                        </div>


                        <div class="form-group  " >
                            <label for="Renew Allowed" class=" control-label col-md-4 text-left"> Renew Allowed </label>
                            <div class="col-md-6">
                                {!! Form::text('renew_allowed',1,array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="1"><i class="icon-question2"></i></a>
                            </div>
                        </div>


                    {!! Form::hidden('max_download_times', $row['max_download_times'],array('class'=>'form-control', 'placeholder'=>'',  'placeholder'=>'' , 'readonly'   )) !!}





                        <div class="form-group  " >
                            <label for="Multiple Language Code" class=" control-label col-md-4 text-left"> Multiple Language Code </label>
                            <div class="col-md-6">
                                {!! Form::text('multiple_language_code',4,array('class'=>'form-control', 'placeholder'=>'',   )) !!}
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="Always 4 for arabic"><i class="icon-question2"></i></a>
                            </div>
                        </div>


                        <div class="form-group  " >
                            <label for="Rbt Name Ml" class=" control-label col-md-4 text-left"> Rbt Name AR <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('rbt_name_ml', $row['rbt_name_ml'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="Rbt Name in Arabic"><i class="icon-question2"></i></a>
                            </div>
                        </div>


                        <div class="form-group  " >
                            <label for="Singer Name Ml" class=" control-label col-md-4 text-left"> Singer Name AR <span class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('singer_name_ml', $row['singer_name_ml'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="tooltip" placement="left" class="tips" title="Singer name in Arabic"><i class="icon-question2"></i></a>
                            </div>
                        </div>

                        <div class="form-group  " >
    						<label for="track_path" class=" control-label col-md-4 text-left"> Track File <span class="asterix"> * </span></label>
    						<div class="col-md-6">
    						  {!! Form::file('track_path',array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true', 'accept' => 'audio/*'  )) !!}
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
                        <!--<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>-->
                        <button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
                        <button type="button" onclick="location.href ='{{ URL::to('track?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
                    </div>

                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<?php
if( isset( $row['id'])  &&  $row['id'] != ""){
    $album_id = $row["album_id"] ;
}else{
   $album_id =  $albumId ;
}
?>

<script type="text/javascript">
    $(document).ready(function () {


        $("#album_id").jCombo("{{ URL::to('track/comboselect?filter=tb_albums:id:name') }}",
                {selected_value: '{{ $album_id }}'});


        $('.removeCurrentFiles').on('click', function () {
            var removeUrl = $(this).attr('href');
            $.get(removeUrl, function (response) {
            });
            $(this).parent('div').empty();
            return false;
        });
    });</script>



<script type="text/javascript">
    $(document).ready(function () {

        $("#web_audition_preview").blur(function () {
            var web_audition_preview = $("#web_audition_preview").val();
            $("#aip_play_rbt").val(web_audition_preview);
            $("#wap_audition_rbt").val(web_audition_preview);
            $("#language_prompt_rbt").val(web_audition_preview);
            // to remove .wav from name
            var rbt_name = web_audition_preview.replace('.wav', '');
            $("#rbt_name").val(rbt_name);
            // to get inital = first character
            $("#initial_rbt_name").val(rbt_name.charAt(0));
        });
        $("#singer_name").blur(function () {
            var singer_name = $("#singer_name").val();
            // to get inital = first character
            $("#initial_singer_name").val(singer_name.charAt(0));
        });
        $("#rbt_information_enable").click(function () {
            var text = $("#rbt_information_enable").html();
            if (text == "Enable") {
                $("#rbt_information").removeAttr('readonly');
                $("#rbt_information_enable").html("Disable");
            } else {
                $("#rbt_information").attr("readonly", "true");
                $("#rbt_information_enable").html("Enable");
            }

        });
    });</script>





<script type="text/javascript">
    $(document).ready(function () {


        $('.date_set').datepicker().on('changeDate', function (ev) {
            var select_date = new Date(ev.date.valueOf());
            var res = select_date.toISOString().substring(0, 10);
            // to get nearest prev  input  = prve  [ we can use next to get nearest next input]
            $(this).prev('input').val(res);
        });
    });
</script>


@stop
