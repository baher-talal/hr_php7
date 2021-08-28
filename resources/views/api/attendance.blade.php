



<form class="form-horizontal" role="form" method="POST" action="{{ url('api/attendance') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
 
    <div class="form-group">
        <label class="col-md-4 control-label">Mobile Token :</label>
        <div class="col-md-6">
              <input type="text" name="mobile_token" value="35802105839829222"> 
        </div>
    </div>
    
     <div class="form-group">
        <label class="col-md-4 control-label"> month_back :</label>
        <div class="col-md-6">
              <input type="text" name="month_back" value="0"> 
        </div>
    </div>



    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary">submit</button>


        </div>
    </div>
</form>