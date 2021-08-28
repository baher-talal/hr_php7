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
        <li class="active"> Rbt Tracks</li>
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
                    <h3><i class="fa fa-bars"></i>File System for RBTs</h3>
                    <div class="box-tool">
                        <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                        <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    <div class="embed-responsive embed-responsive-16by9">
                          <div id="elfinder"></div>
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
  <link rel="stylesheet" type="text/css" media="screen" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/pepper-grinder/jquery-ui.css" />
  <script type="text/javascript" src="{{ asset('sximo/js/plugins/jquery-ui.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('sximo/js/plugins/elfinder/js/elfinder.min.js') }}"></script>
  <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('sximo/js/plugins/elfinder/css/elfinder.min.css')}}" />
  <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('sximo/js/plugins/elfinder/css/theme.css')}}" />
  <style>
      .elfinder .elfinder-button:not(.elfinder-button-search) {
          width: 25px;
          height: 25px;
          padding: 5px;}
      .elfinder-cwd-view-icons .elfinder-cwd-file input{
          color: #000;
      }
  </style>



  <script type="text/javascript" charset="utf-8">
  $().ready(function () {
      var elf = $('#elfinder').elfinder({
          // lang: 'ru',             // language (OPTIONAL)
          url: '{{ url("rbt/file_system/content") }}', // connector URL (REQUIRED)
          height: 500,
      }).elfinder('instance');
  });
  </script>
@stop
