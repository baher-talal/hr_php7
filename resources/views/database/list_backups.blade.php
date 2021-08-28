@extends('layouts.app')

@section('content')
<style>
    tr{
        height: 40px;
    }
    th,td{
            vertical-align: middle!important;
    }
</style>
<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3> Settings <small> DataBase </small></h3>
        </div>
        <ul class="breadcrumb">
            <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
            <li>DataBase</li>
            <li class="active">Backups</li>
        </ul>
    </div>  


    <div class="page-content-wrapper">   
        <div class="sbox animated fadeIn">
            <div class="sbox-title"><a href="{{ URL::to('export_DB') }}" class="tips btn btn-xs btn-default" title="export DB"><i class="fa fa-download"></i>&nbsp;Export DB</a>
                <div class="sbox-tools" >                    
                </div>
        </div>    <!-- <div class="sbox-title"> <h4> <i class="fa fa-table"></i> <?php // echo $pageTitle ;     ?></h4></div> -->
            <div class="sbox-content"> 
                <div class="table-responsive" >
                    <table class="table table-striped " >
                        <thead>
                            <tr> 
                                <th>#</th>
                                <th>Backup database name</th>
                                <th class="visible-md visible-lg">{{ Lang::get('core.btn_action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($databases as$k=> $database)
                            <tr>
                                <td>{{$k+1}}</td> 
                                <td>{{$database}}</td> 
                                <td>
                                    <a href="{{url('delete_backup?path='.$database)}}" class="tips btn btn-xs btn-white" title="" onclick="return confirm('Are you sure you want to delete this backup ?');"data-original-title="Delete This DB"><i class="fa fa-minus-circle"></i></a>
                                    <a href="{{url('download_backup?path='.$database)}}" class="tips btn btn-xs btn-white" title="" data-original-title="Download This DB"><i class="fa fa-download"></i></a>
                                    @if(Auth::user()->id == 1)
                                    <a href="{{url('import_DB?path='.$database)}}" class="tips btn btn-xs btn-white" title="" data-original-title="Import This DB"><i class="fa fa-upload"></i></a>
                                   @endif
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

@stop
