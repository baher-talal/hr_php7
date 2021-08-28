
    <h2 class="text-center" style="text-align: center;">{{ $row->title }}</h2>               
   
        @foreach($items as $value)                             
       
            
        <p style="margin: 15px 0">{!! str_replace(["<sa>","</sa>"],"&nbsp;",str_replace(['&nbsp;',"<o:p></o:p>","<o:p> </o:p>"],"", $value->item)) !!}</p>
           
            

        @endforeach
   
