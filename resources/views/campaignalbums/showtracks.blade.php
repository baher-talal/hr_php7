@extends('layouts.app')
@section('page_title')
   {{$album->name}} tracks
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
                                        <h3><i class="fa fa-table"></i>Tracks for each album </h3>
                                        <div class="box-tool">
                                            <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                                            <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                    <div class="box-content">
                                        <div class="table-responsive" style="border:0">
                                            <table id="example" class="table table-striped dt-responsive" cellspacing="0" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>id</th>
                                                   {{-- <th>#</th>--}}
                                                    <th>track Name</th>
                                                    <th>Operator</th>
                                                    <th>Link Version 2</th>
                                                    <th>Link with BG</th>
                                                    <th>type</th>
                                                    <th>Track Code</th>
                                                    <th>Track</th>
                                                    <th>Delete track for all operators</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @for($i=0;$i<count($tt);$i++)
                                                    @if($tt[$i]->album->id == $album->id)
                                                        <tr>
                                                            <?php  $trackId = $tt[$i]->id ;  ?>
                                                            <td>{{$trackId}}</td>

                                                            <td>
                                                                <label>{{$tt[$i]->title}}</label>
                                                            </td>
                                                            <td>
                                                                @for($j = 0 ; $j < count($tt[$i]->operators); $j++)
                                                                    <a class="btn btn-sm btn-primary show-tooltip" href="{{url("playtrack?track_id=".$tt[$i]->id."&operator_id=".$tt[$i]->operators[$j]->pivot->id)}}" data-original-title="play track" target="_blank"><label>{{$tt[$i]->operators[$j]->country->country}}-{{$tt[$i]->operators[$j]->name}}</label><br></a>
                                                                @endfor
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-sm btn-info show-tooltip" href="{{url('playtrack_v2/'.$tt[$i]->id)}}" data-original-title="play track" target="_blank"><label>Listen track</label><br></a>
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-sm btn-info show-tooltip" href="{{url('playtrack_v3/'.$tt[$i]->id)}}" data-original-title="play track" target="_blank"><label>Listen track</label><br></a>
                                                            </td>
                                                            <td>
                                                                <label>{{$tt[$i]->album->type->type}}</label>
                                                            </td>
                                                            <td>
                                                                @for($j = 0 ; $j < count($tt[$i]->operators); $j++)
                                                                    <label>{{$tt[$i]->operators[$j]->country->country}}/{{$tt[$i]->operators[$j]->name}} : {{$tt[$i]->operators[$j]->pivot->code}}</label><br>
                                                                @endfor
                                                            </td>
                                                            <td>
                                                                @if($tt[$i]->album->type->type=="Audio")
                                                                    <audio id="trackId" width="70%"  controls>
                                                                        <source src="{!! url($tt[$i]->track_file) !!}">
                                                                    </audio>
                                                                @elseif($tt[$i]->album->type->type=="Video")
                                                                    <video id="trackId" width="70%"  @if($tt[$i]->track_poster) poster="{{url($tt[$i]->track_poster)}}" @endif controls>
                                                                        <source src="{{url($tt[$i]->track_file)}}" >
                                                                    </video>
                                                                @endif
                                                            </td>

                                                           <td>
                                                            {!! Form::open(["url"=>"campaigntrack/$trackId","method"=>"delete","onsubmit" => "return ConfirmDelete()"]) !!}
                                                            {!! Form::button('<a class="show-tooltip" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>',['type'=>'submit','class'=>'btn btn-sm btn-danger show-tooltip']) !!}
                                                               {!! Form::close() !!}
                                                            </td>

                                                            <td class="visible-md visible-lg">
                                                                <div class="btn-group">
                                                                    <a class="btn btn-sm btn-primary show-tooltip" title="" href="{{url("update_track?track_id=".$tt[$i]->id)}}" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                                    <a class="btn btn-sm btn-success show-tooltip" title="" href="{{url("operator_track/".$tt[$i]->id)}}" data-original-title="Add Operator"><i class="fa fa-plus"></i></a>

                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endfor

                                                </tbody>
                                            </table>
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

@stop

@section('script')
    <script>
        $('#album').addClass('active');
        $('#album-index').addClass('active');
    </script>
@stop
