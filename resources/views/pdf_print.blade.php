<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>


    <body>
        
       
         
        <?php
        $ids_arr = Session::get('id_arr');
        $dir = "ltr";
        $textAlign = "";
        if (Session::get('lang') == 'ar') {
            $dir = "rtl";
            $textAlign = "right";
        }
        ?>
<!--        
        <p style="font-family: 'dejavu sans', sans-serif;
direction:rtl;
text-alignment:right;">english    عربي</p>-->

        <div  style="border: 1px solid #e5e5e5;" ><br/>
            <div style="margin:10px;">
                <div style="direction:<?php echo $dir; ?>;text-align:left;font-family:Open sans,Arial,sans-serif;color:#444;/*border-radius:1em*/box-shadow: 0px 0px 3px #b6b2a9;margin:2% auto 0 auto">

                    <table class="data-table" style="background:white;width:100%;padding: 5px 0px 20px 0px;">
                        <tr>
                            <td>
                                <table style="width:100%">
                                    <tr>
                                        <td style="width:80%">
                                            <p >  الشركة  com {{ Lang::get('core.Company') }}    : {{ $all['company_name'] }} </p>
                                            <p  >{{ Lang::get('core.Email') }}   :  {{ $all['email'] }}</p>
                                        </td>
                                        <td style="width:20%; text-align:right">
                                            <img src="/sximo/images/<?php echo $all['logo'] ?>" width="70px" style="padding: 15px;"/>  
                                        </td>
                                    </tr>
                                </table>

                            </td>
                        </tr>




                        <tr>
                            <td align="center"><h2 style="margin: 20px 0 20px 0;"> {{ $all['title'] }} </h2></td>
                        </tr>

                        <tr>
                            <td>

                                <?php
                                $count = 0;
                                $content = '';
                                $content .= ' <table class="data-table" style="width:95%;margin: 0 auto;text-align:center">';
                                $content .= '<tr>';
                                foreach ($all['fields'] as $f) {
                                    if ($f['download'] == '1') {
                                        if ($f['view'] == '1') {
                                            $content .= '<th   style="text-align:center;background:#d0d0d0" >' . Lang::get('core.' . $f["label"]) . '</th>';
                                        }
                                    }
                                }
                                $content .= '</tr>';

                                if ($ids_arr) {
                                    foreach ($rows as $row) {
                                        if (in_array($row->id, $ids_arr)) {
                                            if ($count % 2 == 0) { // even
                                                $background = 'background:#FFFFFF';
                                            } else {
                                                $background = 'background:#CEECF5';
                                            }
                                            $content .= '<tr style="' . $background . '">';
                                            foreach ($all['fields'] as $f) {
                                                if ($f['download'] == '1'):
                                                    if ($f['view'] == '1'):


                                                        $conn = (isset($f['conn']) ? $f['conn'] : array() );
                                                        $content .= '<td>' . \SiteHelpers::gridDisplay($row->$f['field'], $f['field'], $conn) . '</td>';


                                                    endif;
                                                endif;
                                            }
                                            $content .= '</tr>';
                                            $count++;
                                        }
                                    }
                                }else {
                                    foreach ($rows as $row) {
                                        if ($count % 2 == 0) { // even
                                            $background = 'background:#FFFFFF';
                                        } else {
                                            $background = 'background:#CEECF5';
                                        }
                                        $content .= '<tr style="' . $background . '">';

                                        foreach ($all['fields'] as $f) {
                                            if ($f['download'] == '1'):
                                                if ($f['view'] == '1'):


                                                    $conn = (isset($f['conn']) ? $f['conn'] : array() );
                                                    $content .= '<td>' . \SiteHelpers::gridDisplay($row->$f['field'], $f['field'], $conn) . '</td>';


                                                endif;
                                            endif;
                                        }
                                        $content .= '</tr>';
                                        $count++;
                                    }
                                }

                                $content .= '</table>';

                                echo $content;
                                ?>

                                <table style="width:100%;padding: 40px;">
                                    <tr>
                                        <?php
                                        if (Session::get('lang') == 'ar') {
                                            ?>
                                            <td style="width:50% ; text-align:right"><p>  {{ Lang::get('core.Created by') }}   :   <b><?php echo Auth::user()->username; ?></b></p></td>
                                            <td style="width:50%; text-align:left"><p> {{ Lang::get('core.Report Date') }}    :   <b><?php echo date("Y-m-d") ?></b></p></td>
                                            <?php
                                        } else {
                                            ?>
                                            <td style="width:50%"><p>Created by :   <b><?php echo Auth::user()->username; ?></b></p></td>
                                            <td style="width:50%; text-align:right"><p>Report Date :   <b><?php echo date("Y-m-d") ?></b></p></td>

                                            <?php
                                        }
                                        ?>



                                    </tr>
                                </table>


                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="margin: 0 14px;text-align: <?php echo $textAlign; ?>">
                                    <h4 style="margin-top: 40px;"> {{ Lang::get('core.Manager Signature') }} </h4>
                                    <img src="/sximo/images/signature.jpg" width="200px" style="margin-top: 10px;"/> 
                                </div>

                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>







        <style>



            p {
                margin: 5px 14px 0px 14px;
                font-size: 10px;
            }

            .data-table tr th{
                line-height: 20px;
                font-size: 10px;
            }
            .data-table tr td{
                line-height:20px;
                font-size: 10px;
            }

            tr.border_bottom td {
                border-bottom:1pt solid black;
            }
        </style>



    </body>
</html>

