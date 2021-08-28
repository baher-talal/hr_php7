@extends('template')
@section('page_title')
    Operators-Tracks Index
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-black">
                        <div class="box-title">
                            <h3><i class="fa fa-table"></i>Operators Tracks Table</h3>
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
                                        <th>track Name</th>
                                        <th>Operator</th>
                                        <th>type</th>
                                        <th>Track Code</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($operators_tracks as $operators_track)
                                        <tr>
                                            <td>{{$operators_track->id}}</td>
                                            <td>
                                                <label>{{$operators_track->track->title}}</label>
                                            </td>
                                            <td>
                                                <label>{{$operators_track->operator->title}}</label>
                                            </td>
                                            <td>
                                                <label>{{$operators_track->track->album->type->type}}</label>
                                            </td>
                                            <td>
                                                <label>{{$operators_track->code}}</label>
                                            </td>
                                            <td class="visible-md visible-lg">
                                                <div class="btn-group">
                                                    {!! Form::open(["url"=>"operator_track/$operators_track->id","method"=>"delete","onsubmit" => "return ConfirmDelete()"]) !!}
                                                    <a class="btn btn-sm show-tooltip" title="" href="{{url("operator_track/$operators_track->id/edit")}}" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                    {!! Form::button('<a class="show-tooltip" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>',['type'=>'submit','class'=>'btn btn-sm btn-danger show-tooltip']) !!}
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
        $('#operator-track').addClass('active');
        $('#operator_track-index').addClass('active');
    </script>
@stop