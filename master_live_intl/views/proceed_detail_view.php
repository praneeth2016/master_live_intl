<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>operator</title>
        <script type ="text/javascript" src="<?php echo base_url(); ?>js/datepicker/jquery-1.7.2.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" media="screen" />
        <style>
            .bg {background-color:#ffffff;
                 font-family: Arial, Helvetica, sans-serif; font-size:12px;
            }
            .bg1 {background-color:#eff3f5;
                  font-family: Arial, Helvetica, sans-serif; font-size:12px;
            }

            .bg:hover {background-color:#cfeeff;
                       font-family: Arial, Helvetica, sans-serif; font-size:12px;
            }
            .bg1:hover {background-color:#cfeeff;
                        font-family: Arial, Helvetica, sans-serif; font-size:12px;
            }
            #fixed { table-layout:fixed; width:90px; word-break:break-all;
            }
        </style>

        <script>
            function searchData()
            {
                var data1 = $('#search').val();
                var data = data1.trim();
                var cnt = $('#cnt').val();

                if (data == "")
                {
                    alert("enter search data");
                    $('#search').focus();
                    return false;
                }

                else
                {
                    // alert(cnt);
                    $.post('proceedDetail', {data: data, cnt: cnt}, function (res)
                    {
                        //alert(res);
                        $('#result').html(res);
                        $('#tbl').hide();
                        $('.pagination').hide();
                    });
                }
            }

        </script>
        <script>
            function showPassangerDetail(j)
            {
                var refno = $('#cnt' + j).val();
                // alert(refno);
                window.open('<?php echo base_url(); ?>index.php/master_control/show_Passanger_proceedDetail?refno=' + refno);
            }
        </script>
    </head>
</html>
<?php
echo '<table width="76%" border=""  >';
if ($data == '') {
    echo ' <tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; 
                       border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; 
                       border-left:#f2f2f2 solid 1px;">
        <td>Search :<input type="text" id="search" name="search" style=""><input type="button" value="Search" onclick="searchData()" id="bt"></td></tr></table>';
}
if ($query1->num_rows() == 0) {
    echo '<table border="0" id="tbl" align="center">
        <tr style="color:red; font-weight:bold; font-size:14px;" align="center">
        <td>No Records Found </td></table>';
} else {
    echo '<table width="76%"  id="tbl">
    <tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px;">
       <th>Booking Time</th>
       <th>Name</th>
       <th>Mobile</th>
       <th>Ref.No</th>
       <th>From - To</th>
       <th>Ticket Fare</th>
       <th>Status</th>
        </tr>';

    if ($k == 0)
        $i = 1;
    else
        $i = $k;

    foreach ($query1->result() as $value) {
        $this->load->database();
        $spno = $value->pnr;
        $ref = $value->refno;
        $tktno = $value->tktno;


        $res = $this->db->query("select * from master_booking where refno='$ref'")or die(mysql_error());

        if ($res->num_rows() > 0) {
            $rows = $res->row();
            $status = $rows->status;
        } else {
            $status = "Not confirmed";
        }

        $class = ($i % 2 == 0) ? 'bg' : 'bg1';
        echo '<tr class="' . $class . '">
     
       <td height="30"> ' . $value->tim . '</td>
       <td> ' . $value->custname . '</td>
       <td> ' . $value->mobile . '</td>
       <td> 
       <a href="#" onClick="showPassangerDetail(' . $i . ')" style="color:blue;text-decoration:underline">' . $value->refno . '</a></td>
       <input type="hidden" id="cnt' . $i . '" value="' . $ref . '">
       <td>' . $value->source . ' - ' . $value->dest . '</td>
       <td>' . $value->fare . '</td>
       <td>' . $status . '</td>
    </tr>';
        //echo "<tr><td id='sh$i' colspan='10'></td></tr>";
        $i++;
    }

    echo "</table>";
    echo "<input type='hidden' id='cnt' value=$i>";
    echo "<span id='result'> </span>";
    echo "<div class='pagination' style='text-align:center'>";
    echo $links;
    echo '</div>';
}
?>