



<form class="form-horizontal" role="form" method="POST" action="{{ url('api/avatar') }}"  enctype="multipart/form-data" >
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
 
    <div class="form-group">
        <label class="col-md-4 control-label">Mobile Token :</label>
        <div class="col-md-6">
              <input type="text" name="mobile_token" value="35802105839829222"> 
        </div>
    </div><br>
    
    <div class="form-group">
        <label class="col-md-4 control-label"> binary image  :</label>
        <div class="col-md-6">
            <textarea  name="binary" >iVBORw0KGgoAAAANSUhEUgAAABIAAAAMCAIAAADgcHrrAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDowNjZDRDA3QTQwRDQxMUU1ODhENzkzNkMzNkUwMENERCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDowNjZDRDA3QjQwRDQxMUU1ODhENzkzNkMzNkUwMENERCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjA2NkNEMDc4NDBENDExRTU4OEQ3OTM2QzM2RTAwQ0REIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjA2NkNEMDc5NDBENDExRTU4OEQ3OTM2QzM2RTAwQ0REIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+PGfGDQAAAFRJREFUeNpifK/JQAZgYmAY/NoY////jyn6/8vHf38+MrEIMPLwkWDbL+aHv5ju/2J+gMs2FuyG/fnw7887RkZG0rT9/Cf35w8TM5MEG8PIAwABBgCD9hjJBujW6QAAAABJRU5ErkJggg==</textarea>
                  


            
        </div>
    </div> <br>
    
    
     <div class="form-group">
        <label class="col-md-4 control-label"> image extension :</label>
        <div class="col-md-6">
              <input type="text" name="image_ext" value="png"> 
        </div>
    </div><br>



    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary">submit</button>


        </div>
    </div>
</form>