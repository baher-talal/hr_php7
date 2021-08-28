@extends('aggregator_interface.layout')

@section('content')
<div id="wrapper">
  @include('aggregator_interface.sidemenu')
</div>
<div class="gray-bg " id="page-wrapper">
  @include('aggregator_interface.headmenu')
  <div class="row">
      <div class="col-md-12">
          <div class="box">
              <div class="box-title">
                  <h3><i class="fa fa-bars"></i>Search in RBTs</h3>
                  <div class="box-tool">

                  </div>
              </div>
              <div class="box-content col-md-12">
                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label">Rbt Name English </label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input1"  name = "search_field[]"  type="text" value="" class="form-control input-lg" >
                      </div>
                  </div>

                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label"  for="track_title_en">Rbt Name Arabic </label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input2" name = "search_field[]" type="text" class="form-control input-lg" >
                      </div>
                  </div>

                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label"  for="track_title_en">Artist Name English </label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input3"  name = "search_field[]"  type="text" class="form-control input-lg" >
                      </div>
                  </div>

                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label">Artist Name Arabic </label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input4" name = "search_field[]" type="text" class="form-control input-lg" >
                      </div>
                  </div>
                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label"  for="track_title_en">Album  </label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input5"  name = "search_field[]"  type="text" class="form-control input-lg"  >
                      </div>
                  </div>



                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label"  for="code">Code </label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input6" name = "search_field[]" type="text" class="form-control input-lg" >
                      </div>
                  </div>

                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label"  for="social_media_code">Social Media Code</label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input7" name = "search_field[]" type="text" class="form-control input-lg">
                      </div>
                  </div>



                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label"  for="owner">Owner </label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input8" name = "search_field[]" type="text" class="form-control input-lg"  >
                      </div>
                  </div>

                  <div class="form-group  col-md-6">
                    <label for="From" class=" control-label col-md-2 text-left"> From <span class="asterix"> * </span></label>
                    <div class="col-md-10">

                    <div class="input-group m-b" style="width:150px !important;">
                      <input class="form-control date parsley-validated" id="input9" required="required" name="search_field[]" type="text" value="" autocomplete="off">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                               </div>
                    <div class="col-md-2">

                     </div>
                  </div>

                  <div class="form-group  col-md-6">
                    <label for="From" class=" control-label col-md-2 text-left"> To <span class="asterix"> * </span></label>
                    <div class="col-md-10">

                    <div class="input-group m-b" style="width:150px !important;">
                      <input class="form-control date parsley-validated" id="input10"  required="required" name="search_field[]" type="text" value="" autocomplete="off">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                               </div>
                    <div class="col-md-2">

                     </div>
                  </div>


                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label">Operators Select </label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <select id="input11" class="form-control chosen" data-placeholder="Choose a Operators" name="search_field[]" tabindex="1" >
                              <option value=""></option>
                              @foreach($operators as $key => $value)
                                  <option value="{{$key}}">{{$value}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>

                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label">Occasions Select </label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <select id="input12" class="form-control chosen" data-placeholder="Choose a Occasions" name="search_field[]" tabindex="1" >
                              <option value=""></option>
                              @foreach($occasions as $key => $value)
                                  <option value="{{$key}}">{{$value}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>


                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label">Content Owner Select</label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <select id="input14" class="form-control chosen" data-placeholder="Choose a provider" name="search_field[]">
                              <option value=""></option>
                              @foreach($providers as $key => $value)
                                  <option value="{{$key}}">{{$value}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>


                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label">Excel Type Select</label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <select id="input15" class="form-control chosen" name="search_field[]">
                              <option value=""></option>
                              <option value="0">Old Excel</option>
                              <option value="1">New Excel</option>
                          </select>
                      </div>
                  </div>



                  <div class="form-group col-md-6">
                      <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                          <button class="btn btn-primary" onclick="send_request()">Search</button>
                      </div>
                  </div>


                  <div class="box-content col-md-12" id="search_result">

                  </div>

              </div>

          </div>
      </div>

  </div>
</div>

<script>
  $('#rpt').addClass('active');
  $('#rpt-search').addClass('active');
</script>
<script>
    function send_request() {
        var search_field = [] ;
        for(var i = 1 ; i <= 15 ; i++)
        {
            search_field[i] = $('#input'+i).val() ;
        }
        $.ajax({
            type: "POST",
            url : "{{url('rbt/search')}}",
            data: {"search_field":search_field},
            success: function(result){
                $('#search_result').html('') ;
                var table = '<div class="row">\
                                <div class="col-md-12">\
                                <div class="box">\
                                <div class="box-title">\
                                <h3><i class="fa fa-table"></i>Search Result</h3>\
                                <div class="box-tool">\
                                <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>\
                                <a data-action="close" href="#"><i class="fa fa-times"></i></a>\
                                </div>\
                                </div>\
                                <div class="box-content">\
                                <button id="btnExport" onclick="export_excel()" class="btn btn-circle btn-fill btn-bordered btn-success btn-to-info"><i class="fa fa-save"></i></button>\
                                    <div class="table-responsive" id="table_wrapper">\
                                        <table class="table table-striped table-hover fill-head">\
                                            <thead>\
                                                <tr>\
                                                    <th>#</th>\
                                                    <th>Type</th>\
                                                    <th>Title</th>\
                                                    <th>Code</th>\
                                                    <th>Track File</th>\
                                                    <th>Content Owner</th>\
                                                    <th>Operator</th>\
                                                    <th>Occasion Title</th>\
                                                </tr>\
                                            </thead>\
                                            <tbody id="table_body">\
                                            </tbody>\
                                        </table>\
                                    </div>\
                                </div>\
                                </div>\
                                </div>\
                             </div>';
                $('#search_result').append(table).hide().fadeIn(600) ;
                result.forEach(append_result);
                play_pause();
            }
        });
    }
    function play_pause() {
        $("audio").on("play", function() {
            $("audio").not(this).each(function(index, audio) {
                audio.pause();
            });
        });
    }

    function append_result(record) {
        var type  ;
        var track_path = "" ;
        var path = '{{url('')}}'+'/' ;
        var edit_path = '{{url('rbt/')}}'+'/update/'+record.id+'?return=' ;
        var delete_path = '{{url('rbt/')}}'+'/delete/'+record.id ;
        if (record.type)
           type = "OLD";
        else
           type = "NEW" ;
        if(record.track_file)
        {
            track_path = '<audio id="trackId" width="100%"  controls>'+
                          '<source src="'+path+record.track_file+'" >'+
                         ' </audio>' ;
        }

        var str = '<tr>'+
                    '<td>'+record.id+'</td>'+
                    '<td>'+type+'</td>'+
                    '<td>'+record.track_title_en+'</td>'+
                    '<td>'+record.code+'</td>'+
                    '<td>'+track_path+'</td>'+
                    '<td>'+record.provider_title+'</td>'+
                    '<td>'+record.operator_title+'</td>'+
                    '<td>'+record.occasion_title+'</td>'+
                  '</tr>';
        $('#table_body').append(str);
    }

    function export_excel() {


        //getting data from our table
        var data_type = 'data:application/vnd.ms-excel';
        var table_div = document.getElementById('table_wrapper');
        var table_html = table_div.outerHTML.replace(/ /g, '%20');

        var a = document.createElement('a');
        a.href = data_type + ', ' + table_html;
        a.download = 'exported_table_' + Math.floor((Math.random() * 9999999) + 1000000) + '.xls';
        a.click();

    }
</script>
@stop
