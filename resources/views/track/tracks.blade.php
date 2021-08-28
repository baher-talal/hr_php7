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
		<li><a href="{{ URL::to('albums?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>

    </div>

 	<div class="page-content-wrapper" >

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content">

		 {{-- {!! Form::open(array('url'=>'tracks/upload', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!} --}}
		 <form name="form_id" id="form_id" class="form-horizontal" action="javascript:void(0);" enctype="multipart/form-data" >

					<div class="col-md-12">
						<fieldset><legend> Tracks</legend>


						  <div class="form-group  " >
							<label for="Artist" class=" control-label col-md-4 text-left"> Tracks <span class="asterix"> * </span></label>
							<div class="col-md-4">
							  {{-- <input type="file" name="excelFile" class="form-control" required='true' multiple> --}}
							  <input type="file" name="vasplus_multiple_files" id="vasplus_multiple_files" multiple="multiple" style="padding:5px;" required />
							 </div>
							 <div class="progress">
							  <div class="progress-bar" role="progressbar" aria-valuenow="0"
							  aria-valuemin="0" aria-valuemax="100" style="width:0%">
							    0%
							  </div>
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
					<button type="button" onclick="location.href='{{ URL::to('albums?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>

				  </div>
		 	</form>
		 {{-- {!! Form::close() !!} --}}
		 <center>

			<table class="table table-striped table-bordered" style="width:60%;" id="add_files">
				<thead>
					<tr>
					    <th style="color:blue; text-align:center;">Number</th>
						<th style="color:blue; text-align:center;">File Name</th>
						<th style="color:blue; text-align:center;">Status</th>
						<th style="color:blue; text-align:center;">File Size</th>
						<th style="color:blue; text-align:center;">Action</th>
					<tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		 </center>
	</div>
</div>
</div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" style="padding-top: 10%">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <br>
        {{-- <h4 class="modal-title">Modal title</h4> --}}
      </div>
      <div class="modal-body">
      	<h1 style="text-align: center;color: green;">Your Upload is Finished</h1>
      </div>
    </div>

  </div>
</div>
{{-- <script src="{{url('sximo/js/jquery.js')}}" type="text/javascript"></script> --}}
        {{-- <script src="{{url('sximo/js/bootstrap.js')}}" type="text/javascript"></script> --}}
        <script type="text/javascript" charset="utf-8" language="javascript" src="{{url('sximo/js/jquery.dataTables.js')}}"></script>
        <script type="text/javascript" charset="utf-8" language="javascript" src="{{url('sximo/js/DT_bootstrap.js')}}"></script>
        {{-- <script type="text/javascript" src="{{url('sximo/js/jquery_1.5.2.js')}}"></script> --}}
        <script type="text/javascript" src="{{url('sximo/js/vpb_uploader.js')}}"></script>
        <script type='text/javascript'>
            $(document).ready(function()
            {
                // Call the main function
                new vpb_multiple_file_uploader
                ({
                    vpb_form_id: "form_id", // Form ID
                    autoSubmit: true,
                    vpb_server_url: "{{url('track/upload')}}" 
                });
            });
        </script>
   <script type="text/javascript">
	$(document).ready(function() {



		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();
			return false;
		});

	});
	</script>
@stop
