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
		<li><a href="{{ URL::to('rbt?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> RBT Tracks  </li>
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
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>Add RBT tracks form</h3>
                </div>
                <div class="box-content">
                    {{-- {!! Form::open(array('url'=>'tracks/upload', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!} --}}
                    <form name="form_id" id="form_id" class="form-horizontal" action="javascript:void(0);" enctype="multipart/form-data" >

                        <div class="col-md-12">
                            <fieldset><legend> Tracks</legend>


                                <div class="form-group  " >
                                    <label for="Artist" class=" control-label col-md-5 text-left"> Tracks <span class="asterix"> * </span></label>
                                    <div class="col-md-4">
                                        <input type="file" name="vasplus_multiple_files" id="vasplus_multiple_files" multiple="multiple" style="padding:5px;" required accept="audio/wav" />
                                    </div><br><br>
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
                            <label class="col-sm-5 text-right">&nbsp;</label>
                            <div class="col-sm-6">
                            <!--<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>-->
                                <button type="submit" name="submit" class="btn btn-success btn-sm" ><i class="fa  fa-save "></i> Save</button>
                                <button type="button" onclick="location.href='{{url('rbt/upload_tracks')}}' " class="btn btn-danger btn-sm "><i class="fa  fa-arrow-circle-left "></i>Cancel</button>
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
                    <!-- Modal -->


                    <div id="myModal" class="modal fade" role="dialog" style="padding-top: 10%">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tracks</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h1 style="text-align: center;color: green;">Tracks Uploaded Successfully</h1>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
	</div>
</div>
</div>
</div>
   <script type="text/javascript">
	$(document).ready(function() {

  		$("#operator_id").jCombo("{{ URL::to('rbt/comboselect?filter=tb_operators:id:name') }}",
  		{  selected_value : '{{ $row["operator_id"] }}' });

  		$("#aggregator_id").jCombo("{{ URL::to('rbt/comboselect?filter=aggregators:id:aggregator_name') }}",
  		{  selected_value : '{{ $row["aggregator_id"] }}' });

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();
			return false;
		});

	});
	</script>
  <script type="text/javascript" src="{{url('sximo/js/vpb_uploader.js')}}"></script>
  <script type='text/javascript'>
      $(document).ready(function()
      {
          // Call the main function
          new vpb_multiple_file_uploader
          ({
              vpb_form_id: "form_id", // Form ID
              autoSubmit: true,
              vpb_server_url: "{{url('rbt/save_tracks')}}"
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
