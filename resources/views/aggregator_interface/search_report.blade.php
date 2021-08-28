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
                  <h3><i class="fa fa-bars"></i>Search in reports</h3>
                  <div class="box-tool">
                      <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                      <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                  </div>
              </div>
              <div class="box-content col-md-12">

                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label">Year</label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input1" name = "search_field[]" type="number" class="form-control input-lg" >
                      </div>
                  </div>

                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label">Month</label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input2"  name = "search_field[]"  type="text" class="form-control input-lg" >
                      </div>
                  </div>
                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label" >Classification</label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input3"  name = "search_field[]"  type="text" class="form-control input-lg"  >
                      </div>
                  </div>


                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label">Code</label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input4" name = "search_field[]" type="number" class="form-control input-lg" >
                      </div>
                  </div>

                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label">Rbt title</label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input5"  name = "search_field[]"  type="text" class="form-control input-lg" >
                      </div>
                  </div>

                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label">Rbt id</label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input6"  name = "search_field[]"  type="number" class="form-control input-lg" >
                      </div>
                  </div>

                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label" >Download</label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input7" name = "search_field[]" type="number" class="form-control input-lg" >
                      </div>
                  </div>

                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label">Total revenue</label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input8" name = "search_field[]" type="text" class="form-control input-lg">
                      </div>
                  </div>



                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label" >Revenue share</label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <input id="input9" name = "search_field[]" type="text" class="form-control input-lg"  >
                      </div>
                  </div>



                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label">Operator</label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <select id="input10" class="form-control chosen" data-placeholder="Choose a Operators" name="search_field[]" tabindex="1" >
                              <option value=""></option>
                              @foreach($operators as $key => $value)
                                  <option value="{{$key}}">{{$value}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>



                  <div class="form-group col-md-6">
                      <label class="col-sm-3 col-lg-2 control-label">Provider</label>
                      <div class="col-sm-9 col-lg-10 controls">
                          <select id="input11" class="form-control chosen" data-placeholder="Choose a provider" name="search_field[]">
                              <option value=""></option>
                              @foreach($providers as $key => $value)
                                  <option value="{{$key}}">{{$value}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>

                  <div class="form-group  col-md-6">
                    <label for="From" class=" control-label col-md-2 text-left"> From <span class="asterix"> * </span></label>
                    <div class="col-md-10">

                    <div class="input-group m-b" style="width:150px !important;">
                      <input class="form-control date parsley-validated" id="input13" required="required" name="search_field[]" type="text" value="" autocomplete="off">
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
                      <input class="form-control date parsley-validated" id="input14"  required="required" name="search_field[]" type="text" value="" autocomplete="off">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                               </div>
                    <div class="col-md-2">

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
    var i = 0 ;
    function send_request() {
        var search_field = [] ;
        for(var j = 1 ; j <= 15 ; j++)
        {
            search_field[j] = $('#input'+j).val() ;
        }

        $.ajax({
            type: "POST",
            url : "search",
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
                                    <button id="btnExport" onclick="export_report()" class="btn btn-circle btn-fill btn-bordered btn-success btn-to-info"><i class="fa fa-save"></i></button>\
                                    <div class="table-responsive" id="table_wrapper">\
                                        <table class="table table-striped table-hover fill-head" id="dvData">\
                                            <thead>\
                                                <tr>\
                                                    <th>#</th>\
                                                    <th>RBT ID</th>\
                                                    <th>RBT Title</th>\
                                                    <th>Year</th>\
                                                    <th>Month</th>\
                                                    <th>Code</th>\
                                                    <th>Classification</th>\
                                                    <th>Download #</th>\
                                                    <th>Total Revenue</th>\
                                                    <th>Revenue share</th>\
                                                    <th>Provider</th>\
                                                    <th>Operator</th>\
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


            }
        });
    }

    var revenue_share_counter = 0 ;
    function append_result(record) {

        revenue_share_counter += parseFloat(record.revenue_share) ;

        var type  ;
        var track_path = "" ;
        var path = '{{url('')}}'+'/' ;
        var edit_path = '{{url('report/')}}'+'/'+record.id+'/edit' ;
        var delete_path = '{{url('report/')}}'+'/'+record.id+'/delete' ;

        var str = '<tr>'+
                    '<td>'+record.id+'</td>'+
                    '<td>'+record.rbt_id+'</td>'+
                    '<td>'+record.rbt_name+'</td>'+
                    '<td>'+record.year+'</td>'+
                    '<td>'+record.month+'</td>'+
                    '<td>'+record.code+'</td>'+
                    '<td>'+record.classification+'</td>'+
                    '<td>'+record.download_no+'</td>'+
                    '<td>'+record.total_revenue+'</td>'+
                    '<td>'+record.revenue_share+'</td>'+
                    '<td>'+record.provider_title+'</td>'+
                    '<td>'+record.operator_title+'</td>'+
                  '</tr>';
        $('#table_body').append(str);
    }

    function export_excel() {
        e.preventDefault();

        //getting data from our table
        var data_type = 'data:application/vnd.ms-excel';
        var table_div = document.getElementById('table_wrapper');
        var table_html = table_div.outerHTML.replace(/ /g, '%20');

        var a = document.createElement('a');
        a.href = data_type + ', ' + table_html;
        a.download = 'exported_table_' + Math.floor((Math.random() * 9999999) + 1000000) + '.xls';
        a.click();

    }

        function export_report() {
            var revenue_share_element = '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>Total IVAS revenue share</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>'+revenue_share_counter+'</td><td></td><td></td><td></td></tr>' ;
            //getting data from our table
            var data_type = 'data:application/vnd.ms-excel';
            $('#dvData').append(revenue_share_element) ;
            var table_div = document.getElementById('table_wrapper');
            var table_html = table_div.outerHTML.replace(/ /g, '%20');

            var d = new Date() ;
            var a = document.createElement('a');
            a.href = data_type + ', ' + table_html ;
            a.download = 'report ' + d + '.xls';
            a.click();
        }


</script>
<script>
    $('#report').addClass('active');
    $('#report-search').addClass('active');
</script>
@stop

@section('script')

@stop
