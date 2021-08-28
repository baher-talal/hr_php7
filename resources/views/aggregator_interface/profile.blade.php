@extends('aggregator_interface.layout')

@section('content')
  <div id="wrapper">
    @include('aggregator_interface.sidemenu')
  </div>
  <div id="page-wrapper">
    @include('aggregator_interface.headmenu')
    <div class="page-content row">
          <!-- Page header -->
        <div class="page-header">
            <div class="page-title">
              <h3> {{ Lang::get('core.m_account') }}  <small>{{ Lang::get('core.m_account_detail') }}</small></h3>
            </div>

            <ul class="breadcrumb">
              <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
      		    <li class="active">{{ Lang::get('core.m_account') }} </li>
            </ul>
      	  </div>
      	<div class="page-content-wrapper m-t">
          	@if(Session::has('message'))
          		   {!! Session::get('message') !!}
          	@endif
          	<ul>
          		@foreach($errors->all() as $error)
          			<li>{{ $error }}</li>
          		@endforeach
          	</ul>
          	<ul class="nav nav-tabs" >
          	  <li class="active"><a href="#info" data-toggle="tab"> {{ Lang::get('core.personalinfo') }} </a></li>
          	  <li ><a href="#pass" data-toggle="tab">{{ Lang::get('core.changepassword') }} </a></li>
          	</ul>

        	  <div class="tab-content">
        	  <div class="tab-pane active m-t" id="info">
          		{!! Form::open(array('url'=>'aggregator/saveprofile/', 'class'=>'form-horizontal ' ,'files' => true)) !!}
          		  <div class="form-group">
            			<label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.username') }} </label>
            			<div class="col-md-8">
            			     <input name="aggregator_name" type="text" id="username"  class="form-control input-sm" required  value="{{ $info->aggregator_name }}" />
            			</div>
          		  </div>
                <div class="form-group">
            			<label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.Phone Number') }} </label>
            			<div class="col-md-8">
            			     <input name="aggregator_mobile" type="text" id="phone_number"  class="form-control input-sm" required  value="{{ $info->aggregator_mobile }}" />
            			</div>
          		  </div>
          		  <div class="form-group">
            			<label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.email') }} </label>
            			<div class="col-md-8">
                    <p  class="form-control input-sm"  disabled="disabled"  >   {{ $info->aggregator_email }} </p>
            			</div>
          		  </div>
                <div class="form-group">
            			<label for="ipt" class=" control-label col-md-4 text-right"> Image </label>
            			<div class="col-md-8">
              			<div class="fileinput fileinput-new" data-provides="fileinput">
              			  <span class="btn btn-primary btn-file">
              			  	<span class="fileinput-new">Image</span><span class="fileinput-exists">Change</span>
              					<input type="file" name="aggregator_img">
              				</span>
              				<span class="fileinput-filename"></span>
              				<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
              			</div>
              			<br />
              			 {{ Lang::get('core.avatar_image_size') }}<br />
              		 	 {!! SiteHelpers::showUploadedFile($info->aggregator_img,'/uploads/user/') !!}

            			</div>
          		  </div>
          		  <div class="form-group">
            			<label for="ipt" class=" control-label col-md-4">&nbsp;</label>
            		 	 <div class="col-md-8">
            				     <button class="btn btn-success" type="submit"> {{ Lang::get('core.sb_savechanges') }}</button>
            			 </div>
          		  </div>
          		{!! Form::close() !!}
        	  </div>
        	  <div class="tab-pane m-t" id="pass">
          		{!! Form::open(array('url'=>'aggregator/savepassword/', 'class'=>'form-horizontal ')) !!}
          		  <div class="form-group">
            			<label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.newpassword') }} </label>
            			<div class="col-md-8">
            			     <input name="password" type="password" id="password" class="form-control input-sm" value="" />
            			</div>
          		  </div>
          		  <div class="form-group">
            			<label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.conewpassword') }}  </label>
            			<div class="col-md-8">
            			     <input name="password_confirmation" type="password" id="password_confirmation" class="form-control input-sm" value="" />
            			</div>
          		  </div>
          		  <div class="form-group">
            			<label for="ipt" class=" control-label col-md-4">&nbsp;</label>
            			<div class="col-md-8">
            				<button class="btn btn-danger" type="submit"> {{ Lang::get('core.sb_savechanges') }} </button>
            			</div>
          		  </div>
          		{!! Form::close() !!}
        	  </div>
          </div>
        </div>
      </div>
  </div>

@endsection
