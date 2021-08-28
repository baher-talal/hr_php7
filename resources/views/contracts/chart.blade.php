@extends('layouts.app')

@section('content')

<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
        </div>

        <ul class="breadcrumb">
            <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ul>	  

    </div>


    <div class="page-content-wrapper m-t">	 	

        <div class="sbox animated fadeInRight">
            <div class="sbox-title"> <h5> <i class="fa fa-table"></i> </h5>
                <div class="sbox-tools" >
                    @if(Session::get('gid') ==1)
                    <a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="btn btn-xs btn-white tips" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa fa-cog"></i></a>
                    @endif 
                </div>
            </div>
            <div class="sbox-content"> 	
               
                <div id="piechart" style="width: 900px; height: 500px;"></div>
            
             
            </div>
        </div>	
    </div>	  
</div>	

 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Contract Status', 'Count','link'],
          ['Expired',     {{$expired}},"{{ URL::to('contracts?status=danger') }}"],  // title  , count  , link 
          ['Not Expired',      {{$notExpired}},"{{ URL::to('contracts?status=success') }}"],
          ['{{ContractMonthCheck}} Month to Expired',  {{$fourExpired}},"{{ URL::to('contracts?status=info') }}"],
          ['1 Month or less to Expired', {{$oneExpired}},"{{ URL::to('contracts?status=warning') }}"]
         
        ]);

        var options = {
          title: 'Contracts',
          slices: {0: {color: 'red'}, 1:{color: '#109618'}, 2:{color: 'blue'}, 3: {color: 'orange'}}

        };
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1]);
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
        
        // this code to make link on each segment on pi chart to work
        // active link
        var selectHandler = function(e) {
         window.location = data.getValue(chart.getSelection()[0]['row'], 2 );
        }
        // Add our selection handler.
        google.visualization.events.addListener(chart, 'select', selectHandler);
        
        
      }
</script>		
@stop