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
                  <h3><i class="fa fa-table"></i> RBT Table</h3>
                  <div class="box-tool">
                      <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                      <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                  </div>
              </div>
              <div class="box-content">
                  <div class="table-responsive" style="border:0;padding:9px">
                      <table class="table table-advance"  id="example" >
                          <thead>
                          <tr>
                              <th>id</th>
                              <th>Type</th>
                              <th>Title</th>
                              <th>Code</th>
                              <th>Artist</th>
                              <th>Track File</th>
                              <th>Operator Title</th>
                              <th>Occasion Title</th>
                              <th>Provider</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php $x = 0; ?>
                          @foreach($rbts as $rbt)
                              <tr>
                                  <td>{{  $rbt->id  }}</td>
                                  <td>{{ ($rbt->type)?'NEW':'OLD' }}</td>
                                  <td>{{$rbt->track_title_en}}</td>
                                  <td>{{$rbt->code}}</td>

                                  <td><?php ($rbt->provider_id) ?  \App\Models\providers::where('id',$rbt->provider_id)->first() : '--' ?></td>
                                  @if($rbt->track_file)
                                      <td>
                                          <audio  class="rbt_audios" controls >
                                            <source src="{{url($rbt->track_file)}}" >
                                          </audio>
                                      </td>
                                  @else
                                      <td>--</td>
                                  @endif
                                  <td><?php ($rbt->operator_id) ?  \App\Models\Operator::where('id',$rbt->operator_id)->first() : '--' ?></td>
                                  <td><?php ($rbt->occasion_id) ?  \App\Models\Occasions::where('id',$rbt->occasion_id)->first() : '--' ?></td>

                                  @if($rbt->owner)
                                      <td>{!!$rbt->owner!!}</td>
                                  @else
                                      <td>--</td>
                                  @endif
                              </tr>
                              <?php $x++; ?>
                          @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@stop

@section('script')
  <script>

      $('#rbt').addClass('active');
      $('#rbt-index').addClass('active');
  </script>

@stop
