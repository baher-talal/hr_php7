@extends('aggregator_interface.layout')

@section('content')
<div id="wrapper">
  @include('aggregator_interface.sidemenu')
</div>
<div class="gray-bg " id="page-wrapper">
  @include('aggregator_interface.headmenu')
  <div class="row">
      <div class="col-md-12">
          <div class="box box-blue">
              <div class="box-title">
                  <h3><i class="fa fa-table"></i> Report Table</h3>
                  <div class="box-tool">
                      <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                      <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                  </div>
              </div>
              <div class="box-content">

                  <div class="table-responsive" style="padding:9px">
                      <table id="example" class="table table-striped dt-responsive" cellspacing="0" width="100%">
                          <thead>
                          <tr>
                              <th>Rbt Id</th>
                              <th>Rbt Title</th>
                              <th>Year</th>
                              <th>Month</th>
                              <th>Code</th>
                              <th>Classification</th>
                              <th>Download Number</th>
                              <th>Total Revenue</th>
                              <th>Revenue Share</th>
                              <th>Provider Title</th>
                              <th>Operator Title</th>
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($reports as $report)
                              <tr>
                                  <td>{{$report->rbt_id}}</td>
                                  <td>{!!$report->rbt_name!!}</td>
                                  <td>{!!$report->year!!}</td>
                                  <td>{!!$report->month!!}</td>
                                  <td>{!!$report->code!!}</td>
                                  <td>{!!($report->classification) ? $report->classification : '--'!!}</td>
                                  <td>{!!($report->download_no) ? $report->download_no : '--'!!}</td>
                                  <td>{!!($report->total_revenue)!!}</td>
                                  <td>{!!$report->revenue_share!!}</td>
                                  <td><?php ($report->provider_id) ?  \App\Models\providers::where('id',$report->provider_id)->first()->provider_name : '--' ?></td>
                                  <td><?php ($report->operator_id) ?  \App\Models\Operator::where('id',$report->operator_id)->first()->name : '--' ?></td>

                              </tr>
                          @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<script>
    $('#report').addClass('active');
    $('#report-index').addClass('active');
</script>
@stop

@section('script')

@stop
