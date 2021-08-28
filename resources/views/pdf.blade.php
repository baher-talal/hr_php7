<?php
$ids_arr = array();
 $ids_arr = Session::get('id_arr');
$dir = "ltr";
$textAlign = "";
$alignTitle = "text-align: right";
if (\Session::get('lang') == 'ar') {
    $dir = "rtl";
    $textAlign = "right";
    $alignTitle = "text-align: left";
}
?>




    <div>
        <div >

            <table>
                
                <tr style="margin-bottom: 150px;">
                <td>
                    <table>
                        <tr>
                            <td>
                                <img src="sximo/images/<?php echo $all['logo'] ?>" width="70px" />  
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>


                <tr>
                    <td>  
                          <table   style="border-collapse: collapse;padding: 5px;" cellspacing="6" cellpadding="4">
                            <tr style="margin:10px;">
                                <td  colspan="2" >
                                {{ Lang::get('core.Company') }} : {{  $all['company_name'] }} 
                                </td>   
                                <td colspan="1"   >
                                   {{ Lang::get('core.Email') }} : {{ $all['email'] }}
                                </td> 
                                
                            </tr>
                        </table>

                    </td>
                </tr>




                <tr>     
                     <td ><h2  style="text-align: center"> <?php echo $all['title'] ?> </h2></td>
                </tr>

                <tr>
                    <td>

                           <?php
                        $count = 0 ;
                        $content = '';
                        $content .= ' <table style="border-collapse: collapse" cellspacing="6" cellpadding="4"  >';
                        $content .= '<tr>';
                        foreach ($all['fields'] as $f) {
                            if ($f['download'] == '1') {
                                if ($f['view'] == '1') {
                                    $content .= '<th    bgcolor="#f3f3f3"  style="text-align:center;" ><b>' . Lang::get('core.'.$f["label"] ) . '</b></th>';
                                }
                            }
                        }
                        $content .= '</tr>';

                        if ($ids_arr) {
                            foreach ($rows as $row) {
                                 if (in_array($row->id, $ids_arr)) {
                                      if($count % 2 == 0){ // even
                                         $background = '#FFFFFF'; 
                                      }  else {
                                          $background = '#CEECF5'; 
                                      }  
                                $content .= '<tr bgcolor="'.$background.'">';
                                foreach ($all['fields'] as $f) {
                                    if ($f['download'] == '1'):
                                        if ($f['view'] == '1'):


                                            $conn = (isset($f['conn']) ? $f['conn'] : array() );
                                            $content .= '<td>' . \SiteHelpers::gridDisplay($row->$f['field'], $f['field'], $conn) . '</td>';


                                        endif;
                                    endif;
                                }
                                $content .= '</tr>';
                                $count++ ;
                            }
                            }
                        }else {
                            foreach ($rows as $row) {
                                  if($count % 2 == 0){ // even
                                         $background = '#FFFFFF'; 
                                      }  else {
                                          $background = '#CEECF5'; 
                                      }  
                                $content .= '<tr  bgcolor="'.$background.'">';
                              
                                    foreach ($all['fields'] as $f) {
                                        if ($f['download'] == '1'):
                                            if ($f['view'] == '1'):


                                                $conn = (isset($f['conn']) ? $f['conn'] : array() );
                                                $content .= '<td>' . \SiteHelpers::gridDisplay($row->$f['field'], $f['field'], $conn) . '</td>';


                                            endif;
                                        endif;
                                    }
                                    $content .= '</tr>';
                                     $count++ ;
                                }
                           
                        }

                        $content .= '</table>';

                        echo $content;
                        ?>
                        
                        
                        
                        <table   style="border-collapse: collapse" cellspacing="10" cellpadding="10">
                            <tr >
                                <td   colspan="2" >
                                    {{  Lang::get('core.Created by') }} : {{ Auth::user()->username }}
                                </td>   
                                <td colspan="1"   >
                                    {{ Lang::get('core.Report Date') }} : {{  date("Y-m-d") }}
                                </td> 
                            </tr>
                        </table>


                       


                    </td>
                </tr>
                <tr>
                    <td>
                        <div>
                            <h4> {{ Lang::get('core.Manager Signature') }} : </h4>
<!--                            <img src="sximo/images/signature.jpg" width="200px" style="margin-top: 10px;"/> -->
                        </div>
                    </td>
                </tr>
            </table>

        </div>
    </div>
