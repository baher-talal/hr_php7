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
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>

    </div>

 	<div class="page-content-wrapper">

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
      @if(Session::has('message'))
      {!! Session::get('message') !!}
      @endif
		</ul>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content">

		 {!! Form::open(array('url'=>'rbt/excel?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> Rbt</legend>

              <div class="form-group  " >
              <label for="Type" class=" control-label col-md-4 text-left"> Type <span class="asterix"> * </span></label>
              <div class="col-md-6">

                <?php $type = explode(',',$row['type']);
                  $type_opt = array( '0' => 'Old Excel' ,  '1' => 'NewExcel' , ); ?>
                  <select name='type' rows='5' required  class='select2 ' onchange="change_sample_link(this)" >
                    <?php
                    foreach($type_opt as $key=>$val)
                    {
                      echo "<option  value ='$key' ".($row['type'] == $key ? " selected='selected' " : '' ).">$val</option>";
                    }
                    ?></select>
                 </div>
                 <div class="col-md-2">

                 </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4 col-md-4 control-label">Excel file <span class="asterix"> * </span></label>
                  <div class="col-sm-6 col-md-6 controls">
                     <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="input-group">
                           <div class="form-control uneditable-input">
                              <i class="fa fa-file fileupload-exists"></i>
                              <span class="fileupload-preview"></span>
                           </div>
                           <div class="input-group-btn">
                               <a class="btn bun-default btn-file">
                                   <span class="fileupload-new">Select file</span>
                                   <span class="fileupload-exists">Change</span>
                                   <input type="file" name="fileToUpload" required class="file-input">
                               </a>
                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                           </div>
                        </div>
                        <span id="sample_link"><a href="{{url('rbt/downloadSample')}}">Download Sample</a></span>
                     </div>
                  </div>
                  <div class="col-md-2">

                  </div>
                </div>

                <div class="form-group  " >
                    <label for="countries" class=" control-label col-md-4 text-left"> Operator <span class="asterix"> * </span></label>
                    <div class="col-md-6">
                        <select name="operator_id" id='countries' rows='5' required  class='select2'  >
                            <option  value ='' >--Please Select--</option>
                            @foreach ($operators as $key => $val)
                            <option  value ='{{$val->id}}' @if($row["operator_id"] == $val->id) selected @endif >{{$val->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">

                    </div>
                </div>


								  <div class="form-group  " >
									<label for="Aggregator" class=" control-label col-md-4 text-left"> Aggregator</label>
									<div class="col-md-6">
									  <select name='aggregator_id' rows='5' id='aggregator_id' class='select2 '   ></select>
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
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('rbt?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>

				  </div>

		 {!! Form::close() !!}
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

  function change_sample_link(element) {
      var link ;
      $('#sample_link').html('');
      if(element.value==0)
      {
          link = '<a href="{{url('rbt/downloadSample')}}">Download Sample</a>' ;
      }
      else {
          link = '<a href="{{url('rbt/downloadSampleNew')}}">Download Sample (New)</a>' ;
      }
      $('#sample_link').append(link).hide().fadeIn(600) ;
  }
	</script>
@stop
