@extends('layouts.app')
@section('page_title')
    All Tracks
@stop
@section('content')
  <ul class="parsley-error-list">
    @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
  <div class="row">
      <div class="col-md-12">

          <div class="row">
              <div class="col-md-12">
                  <div class="box box-black">
                      <div class="box-title">
                          <h3><i class="fa fa-table"></i>tracks Table</h3>
                          <div class="box-tool">
                              <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                              <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                          </div>
                      </div>
                      <div class="box-content">
                          {{--<div class="btn-toolbar pull-right">--}}
                              {{--<div class="btn-group">--}}
                                  {{--<a class="btn btn-circle show-tooltip" title="" href="{{url('track/create')}}" data-original-title="Add new record"><i class="fa fa-plus"></i></a>--}}
                              {{--</div>--}}
                          {{--</div>--}}
                          {{--<br><br>--}}
                          <div class="table-responsive" style="border:0">
                              <table id="example" class="table table-striped dt-responsive" cellspacing="0" width="100%">
                                  <thead>
                                  <tr>
                                      <th>id</th>
                                      <th>track Name</th>
                                      <th>Album</th>
                                      <th>Type</th>
                                      <th>Track</th>
                                      <th>Operator(if any)</th>
                                      <th>Code</th>
                                      <th>Action</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  @foreach($tracks as $track)
                                      <tr>
                                          <td>{{$track->id}} </td>
                                          <td>
                                              <label>{{$track->title}}</label>
                                          </td>
                                          <td>
                                              <label>{{$track->album->name}}</label>
                                          </td>
                                          <td>
                                              <label>{{$track->album->type->type}}</label>
                                          </td>
                                          <td>
                                              @if($track->album->type->type=="Audio")
                                                  <audio id="trackId" width="100%"  controls>
                                                      <source src="{!! url($track->track_file) !!}">
                                                  </audio>
                                              @elseif($track->album->type->type=="Video")
                                                  <video id="trackId" width="70%" @if($track->track_poster) poster="{{url($track->track_poster)}}" @endif  controls>
                                                      <source src="{{url($track->track_file)}}" >
                                                  </video>
                                              @endif
                                          </td>
                                          <td>
                                              <a class="btn btn-sm btn-primary show-tooltip" href="{{url("playtrack?track_id=".$track->id)}}" data-original-title="play track" target="_blank"><label>Listen</label><br></a>
                                          </td>
                                          <td>
                                              @for($i=0;$i<count($track->operators);$i++)
                                                  <label>{{$track->operators[$i]->name}} / {{$track->operators[$i]->country->country}} : {{$track->operators[$i]->pivot->code}}</label><br>
                                              @endfor
                                          </td>
                                          <td class="visible-md visible-lg">
                                              <div class="btn-group">
                                                  {!! Form::open(["url"=>"campaigntrack/$track->id","method"=>"delete","onsubmit" => "return ConfirmDelete()"]) !!}
                                                  <a class="btn btn-sm btn-info show-tooltip" title="" href="{{url("update_track?track_id=".$track->id)}}" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                  {!! Form::button('<a class="show-tooltip" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>',['type'=>'submit','class'=>'btn btn-sm btn-danger show-tooltip']) !!}
                                                  <a class="btn btn-sm btn-success show-tooltip" title="" href="{{url("operator_track/$track->id")}}" data-original-title="Add Operator"><i class="fa fa-plus"></i></a>
                                                  {!! Form::close() !!}
                                              </div>
                                          </td>
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

  </div>

@stop

@section('script')
    <script>
        $('#album').addClass('active');
        $('#album-index').addClass('active');
    </script>
@stop
