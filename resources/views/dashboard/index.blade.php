@extends('layouts.app')


@section('content')


<?php // session_start(); session_destroy();
 $_SESSION["check"] = false; ?>


<style>
    .sbox {
        // border: 1px solid #ddd;
        clear: both;
        margin-bottom: 25px;
        margin-top: 0;
        padding: 0;
    }
</style>

<div class="page-content row">
    <div class="page-header">
        <div class="page-title">
            <h3><i class="fa fa-desktop"></i> {{ Lang::get('core.Dashboard') }}
        </div>

    </div>
    <div class="page-content-wrapper">


        @if(Auth::check() )

        <section>
            <div class="row m-l-none m-r-none m-t  white-bg shortcut ">

                @if(Auth::user()->group_id == 1)
                <div class="col-sm-6 col-md-3 b-r  p-sm">
                    <span class="pull-left m-r-sm "> <i class="fa fa-users"></i></span>
                    <a href="{{ URL::to('core/users') }}" class="clear">
                        <span class="h3 block m-t-xs text-uppercase"><strong> {{$total_user}}
                                {{ Lang::get('core.Users') }}</strong>
                        </span> <small class="text-muted text-uc"> {{ Lang::get('core.registered_on_system') }} </small>
                    </a>
                </div>

                <div class="col-sm-6 col-md-3 b-r  p-sm">
                    <span class="pull-left m-r-sm text-warning"> <i class="icon-tags"></i></span>
                    <a href="{{ URL::to('core/groups') }}" class="clear">
                        <span class="h3 block m-t-xs text-uppercase"><strong> {{$total_groups}}
                                {{ Lang::get('core.user_groups') }} </strong></span>
                        <small class="text-muted text-uc">included on system</small> </a>
                </div>

                <div class="col-sm-6 col-md-3 b-r  p-sm">
                    <span class="pull-left m-r-sm text-danger"> <i class="icon-cloud-download"></i></span>
                    <a href="{{ URL::to('originalcontents') }}" class="clear">
                        <span class="h3 block m-t-xs text-uppercase"><strong> {{ App\Models\Originalcontents::count() }}
                                Original Content </strong></span>
                        <small class="text-muted text-uc">The setting of original contents </small> </a>
                </div>

                <div class="col-sm-6 col-md-3 b-r  p-sm">
                    <span class="pull-left m-r-sm text-info"> <i class="icon-crop"></i></span>
                    <a href="{{ URL::to('bitrates') }}" class="clear">
                        <span class="h3 block m-t-xs text-uppercase"><strong> {{ App\Models\Originalcontents::count() }}
                                Specs Content </strong></span>
                        <small class="text-muted text-uc">The setting of original contents </small> </a>
                </div>



                @endif



            </div>
        </section>



        <?php
             $sign_check = \SiteHelpers::signcheck();

?>

        <?php



            ?>

        <span id="check" style="display:none;">

            @if( $sign_check['sign_in'] == 1 || $sign_check['sign_out'] == 1 )
            <!--<div class="sbox animated fadeInRight">
                <div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
                <div class="sbox-content">

                    {!! Form::open(array('url'=>'attendance/sign', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
                    <div class="col-md-12">
                        <fieldset><legend> Punch</legend>
                        </fieldset>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 text-right">&nbsp;</label>
                        <div class="col-sm-8">
                            @if(isset($sign_check['sign_in']) &&   $sign_check['sign_in'] == 1 )
                            <button type="submit" name="sign_in" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> Sign In</button>
                            @endif
                                @if(isset($sign_check['sign_out']) &&   $sign_check['sign_out'] == 1 )
                                <button type="submit" name="sign_out" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> Sign Out</button>
                                @endif
                        </div>

                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
-->
            @endif

    </div>

    @endif

</div>

</span>

</div>

</div>

@stop


@section('punch')
<script>
    window.onload = function()
  { document.getElementById("check").style.display = "none"; }

$(document).ready(function(){
 $("#check").css("display","none") ;


var request = $.ajax({
  url: "http://10.2.10.10/~hrivashosting/check",
  type: "POST" ,
    data:{
        key: '{{$encrypted}}',
    },
});

request.done(function(msg) {
 $("#check").css("display","block") ;

});

request.fail(function(jqXHR, textStatus) {
   $("#check").css("display","none") ;
   $("#check").empty();
})

});


</script>

@stop
