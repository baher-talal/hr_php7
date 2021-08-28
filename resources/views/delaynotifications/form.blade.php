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
		<li><a href="{{ URL::to('delaynotifications?return='.$return) }}">{{ $pageTitle }}</a></li>
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

		 {!! Form::open(array('url'=>'delaynotifications/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> Delay Notifications</legend>

								  <div class="form-group hidethis " style="display:none;">
									<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
									<div class="col-md-6">
									  {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="User" class=" control-label col-md-4 text-left"> User <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='user_id' rows='5' id='user_id' class='select2 ' required  >
                                          @php $users= DB::table('tb_users')->get()@endphp

                                          @isset($users)

                                              @if(count($users) > 0)

                                                  @foreach($users as $user)

                                                      <option value="{{$user->id}}" {{ isset($row) && $row->user_id == $user->id ? "Selected" : "" }}>{{$user->username }}</option>

                                                  @endforeach

                                              @endif

                                          @endisset
                                      </select>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Delay Date" class=" control-label col-md-4 text-left"> Delay Date <span class="asterix"> * </span></label>
									<div class="col-md-6">

				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('delay_date', $row['delay_date'],array('class'=>'form-control date', 'required'=>'true' )) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Subject" class=" control-label col-md-4 text-left"> Subject <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('subject', $row['subject'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Message" class=" control-label col-md-4 text-left"> Message <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <textarea name='message' rows='5' id='message' class='form-control '
				         required  >{{ $row['message'] }}</textarea>
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div> </fieldset>
			</div>




			<div style="clear:both"></div>


				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">
<!--					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>-->
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="window.location.href='{{ URL::to('delaynotifications?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>

				  </div>

		 {!! Form::close() !!}
	</div>
</div>
</div>
</div>
   <script type="text/javascript">
	$(document).ready(function() {


		$("#user_id").jCombo("{{ URL::to('delaynotifications/comboselectuser?filter=tb_users:id:first_name|last_name') }}",
		{  selected_value : '{{ $row["user_id"] }}' });


		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();
			return false;
		});

	});
	</script>
@stop
