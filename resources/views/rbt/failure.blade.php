<table>
    <tr>
      <th>rbt_name</th>
      <th>code</th>
      <th>social_media_code</th>
      <th>content_owner</th>
      <th>occasion</th>
    </tr>
    @foreach($arr_faild as $value)
    <tr>
      <td @if(!$value['rbt_name']) style="background-color:#11943f" @endif >{{$value['rbt_name']}}</td>
      <td @if(!$value['code']) style="background-color:#11943f" @endif>{{$value['code']}}</td>
      <td>@if(isset($value['social_media_code'])) {{$value['social_media_code']}} @endif</td>
      <td @if(!$value['content_owner']) style="background-color:#11943f" @endif>{{$value['content_owner']}}</td>
      <td>{{$value['occasion']}}</td>
    </tr>
    @endforeach

</table>
