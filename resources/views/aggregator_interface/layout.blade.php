<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>AggregatorInterface</title>
<link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">

		<link href="{{ asset('sximo/js/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
		<link href="{{ asset('sximo/css/sximo.css')}}" rel="stylesheet">
		<link href="{{ asset('sximo/css/animate.css')}}" rel="stylesheet">
		<link href="{{ asset('sximo/css/icons.min.css')}}" rel="stylesheet">
		<link href="{{ asset('sximo/fonts/awesome/css/font-awesome.min.css')}}" rel="stylesheet">
		<link href="{{ asset('sximo/css/sximo-dark-blue.css')}}" rel="stylesheet">
		<link href="{{ asset('sximo/css/style.css')}}" rel="stylesheet">
		<link rel="stylesheet" href="{{url('sximo/js/plugins/data-tables/bootstrap3/dataTables.bootstrap.css')}}" />
		<link href="{{ asset('sximo/js/plugins/datepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
		        <link href="{{ asset('sximo/js/plugins/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
		<script src="//use.edgefonts.net/source-sans-pro.js"></script>

		<script type="text/javascript" src="{{ asset('sximo/js/plugins/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/parsley.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/bootstrap/js/bootstrap.js') }}"></script>
		<script type="text/javascript" src="{{url('sximo/js/plugins/data-tables/jquery.dataTables.js')}}"></script>
		<script type="text/javascript" src="{{url('sximo/js/plugins/data-tables/bootstrap3/dataTables.bootstrap.js')}}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
		<script type="text/javascript">
			$(document).ready(function() {
					$('#example').DataTable();
					$('#example1').datepicker({
							format: "yyyy-mm-dd",
							rtl: true,
					});

					$('.date').datepicker({
							format: "yyyy-mm-dd",
							rtl: true,

					});

					$('.input-group-addon').click(function(){
						$(this).prev('.form-control').focus()
					})

			});
		</script>
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->



  	</head>
<body class="sxim-init">

      @yield('content')


</body>
</html>
