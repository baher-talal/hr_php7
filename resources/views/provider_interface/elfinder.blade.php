@extends('provider_interface.layout')

@section('content')
<div id="wrapper">
  @include('provider_interface.sidemenu')
</div>
<div class="gray-bg" id="page-wrapper">
  @include('provider_interface.headmenu')
  <div class="page-content row">
      <!-- Page header -->
      <div class="page-header">
          <div class="page-title">
              <h3> File Manager <small> My File Manager </small></h3>
          </div>
      </div>

      <div class="page-content-wrapper m-t">
          <div class="">
              <div id="elfinder"></div>
          </div>
      </div>

  </div>
</div>
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
        url: '{{ url("provider/content") }}', // connector URL (REQUIRED)
        height: 500,
    }).elfinder('instance');
});
</script>
@stop
