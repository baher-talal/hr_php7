@extends('aggregator_interface.layout')

@section('content')

<div class="sbox container" style="width:30%;margin-top:7%">
	<!--<div class="sbox-title">

				<h3 >{{ CNF_APPNAME }} <small> {{ CNF_APPDESC }} </small></h3>

	</div>-->
	<div class="sbox-content">
	<div class="text-center  animated fadeIn delayp1">
		@if(file_exists(public_path().'/sximo/images/'.CNF_LOGO) && CNF_LOGO !='')
                <img src="{{ asset('sximo/images/'.CNF_LOGO)}}" alt="{{ CNF_APPNAME }}"    style="opacity: 1.0;" />
		 	@else
			<img src="{{ asset('sximo/images/logo-sximo')}}" alt="{{ CNF_APPNAME }}" width="70" height="70"/>
			@endif
	</div>

	    	@if(Session::has('message'))
				{!! Session::get('message') !!}
			@endif
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>

	<ul class="nav nav-tabs" >
            <li class="active"><a href="#tab-sign-in" data-toggle="tab"   >  {{ Lang::get('core.signin') }} </a></li>
	   <li ><a href="#tab-forgot" data-toggle="tab"> {{ Lang::get('core.forgotpassword') }} </a></li>
	   @if(CNF_REGIST =='true')
	   <li><a href="{{ URL::TO('user/register')}}" >  {{ Lang::get('core.signup') }} </a></li>
	   @endif

	</ul>
	<div class="tab-content" >
		<div class="tab-pane active m-t" id="tab-sign-in">
		<form method="post" action="{{ url('aggregator/reset-password/'.$verCode)}}" class="form-vertical">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="form-group has-feedback animated fadeIn delayp1">
				<!--<label>{{ Lang::get('core.username') }}	</label>-->
				<input type="password" name="password" placeholder="Password" class="form-control" autocomplete="off" />

				<i class="icon-eye form-control-feedback"></i>
			</div>

			<div class="form-group has-feedback animated fadeIn delayp1">
				<!--<label>{{ Lang::get('core.username') }}	</label>-->
				<input type="password" name="password_confirmation" placeholder="password confirmation" class="form-control" autocomplete="off" />

				<i class="icon-eye form-control-feedback"></i>
			</div>

			<div class="form-group  has-feedback text-center  animated fadeIn delayp1" style=" margin-bottom:20px;" >

        <button type="submit" class="btn btn-info btn-sm btn-block"  style="background-color:  #0192AF !important ; border-color : #fff ;" ><i class="fa fa-sign-in"></i> {{ Lang::get('core.signin') }}</button>

			<div class="clr"></div>

			</div>

		   </form>
		</div>

		<div class="text-center"><strong>Copyright</strong> © {{ date('Y')}} . HR System <br> Designed & Developed by <strong><a href="http://ivas.mobi/" target="_blank" >IVAS </a></strong>.</div>
	</div>

  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#or').click(function(){
		$('#fr').toggle();
		});
	});
</script>
@stop
