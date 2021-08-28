@extends('layouts.login')

@section('content')

<!-- Login wrapper -->
<div class="sbox">
    <div class="sbox-title">
        <span class="text-semibold"><i class="icon-user-plus"></i> {{ CNF_APPNAME}}</span>
    </div>
    <div class="sbox-content">
        <div class="text-center">
                <!--<img src="{{ asset('sximo/images/logo-sximo.png')}}" width="90" height="90" />-->
                @if(file_exists(public_path().'/sximo/images/'.$tb_config->cnf_logo) && $tb_config->cnf_logo !='')
                <img src="{{ asset('sximo/images/'.$tb_config->cnf_logo)}}" alt="{{ CNF_APPNAME }}" />
                @else
                <img src="{{ asset('sximo/images/logo.png')}}" alt="{{ CNF_APPNAME }}" />
                @endif
        </div>
        {!! Form::open(array('url' => 'user/doreset/'.$verCode, 'class'=>'form-vertical')) !!}

        <!--
        @if(Session::has('message'))
                        {{ Session::get('message') }}
                @endif
        -->


        <div class="form-group has-feedback" style="margin-top: 10px;">
            <ul class="parsley-error-list">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        <div class="form-group has-feedback">
            <label>New Password </label>
            {!! Form::password('password',  array('class'=>'form-control', 'placeholder'=>'New Password')) !!}
            <i class="icon-lock form-control-feedback"></i>
        </div>

        <div class="form-group has-feedback">
            <label>Re-type Password</label>
            {!! Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) !!}
            <i class="icon-lock form-control-feedback"></i>
        </div>
        <div class="form-group has-feedback">
            <label></label>
            <div class="col-xs-6">
                <button type="submit" class="btn btn-primary pull-right">Reset My Password</button>
            </div>
        </div>


        {!! Form::close() !!}
    </div>
</div>
</div>
<!-- /login wrapper -->

@endsection
