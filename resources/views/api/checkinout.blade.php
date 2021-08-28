



<form class="form-horizontal" role="form" method="POST" action="{{ url('api/check') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
 
    <div class="form-group">
        <label class="col-md-4 control-label">Mobile Token :</label>
        <div class="col-md-6">
              <input type="text" name="mobile_token" value="35802105839829222"> 
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">ip :</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="ip" value="192.168.1.100">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">network name :</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="network_name" value="network100">
        </div>
    </div>



    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary">submit</button>


        </div>
    </div>
</form>