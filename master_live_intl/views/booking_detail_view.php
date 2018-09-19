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
        </style>

        <script>
            function searchData() {
            
                var data1 = $('#search').val();
                var data=data1.trim();
                var cnt = $('#cntt').val();
                if (data == "")
                {
                    alert("enter search data");
                    $('#search').focus();
                    return false;
                }

                else {
                     //alert(data);
                    $.post('bookingDetail', {data: data, cnt: cnt}, function(res) {
                        //alert(res);
                        $('#result').html(res);
                        $('#tbl').hide();
                        $('.pagination').hide();

                    });
                }
            }
           
        </script>
        <script>
            function show_booking_PassangerDetail(j)
            {
                var refno=$('#cnt'+j).val();
                //alert(refno);
                window.open('<?php echo base_url();?>index.php/master_control/show_Passanger_bookingDetail?refno='+refno);
            }
        </script>
    </head>
</html>
<?php
$type = "";
echo '<table width="76%" border=""  >';
if ($data == '') 
    {
    echo ' <tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; 
                       border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; 
                       border-left:#f2f2f2 solid 1px;">
        <td>Search :<input type="text" id="search" name="search" style="">
                    <input type="button" value="Search" onClick="searchData()" id="bt">
        </td>
        </tr>
        </table>';
   }
 if ($query1->num_rows() == 0) 
    {
    echo '<table border="0" id="tbl" align="center">
        <tr style="color:red; font-weight:bold; font-size:14px;" align="center">
        <td>No Records Found </td>
        </table>';
   }
   else 
      {

    echo '<table width="750"  id="tbl">
        <tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; 
                      ">
        <th>Source</th>
        <th>Booking Time</th>
        <th>Ticket No.</th>
        <th>Source( to) Destination</th>
        <th>Travels</th>
        <th>Ref.No</th>
        <th>Ticket Fare</th>
        <th>Status</th>
        </tr>';
  if ($k == 0)
        $i = 1;
  else
        $i = $k;
    
   foreach ($query1->result() as $value) 
          {
$tktno=$value->tkt_no;
       /*$x=explode("-",$tktno);
        if($x[0]=='TE'){
            $type='Ticketengine';
        }*/
$agent_id = $value->agent_id;
if($value->agent_id == "" || $value->agent_id == 0)
{
$agent_id = $value->book_pay_agent;
}
$sql = mysql_query("select name from agents_operator where id='$agent_id'");
//echo "select name from agents_operator where operator_id='$travel_id' and id='$agent_id'";
$row = mysql_fetch_array($sql);

$name = $row['name'];

if($value->status == "Confirmed" || $value->status == "confirmed")
{
	$time = $value->time;
}
else
{
	$time = $value->cdate." ".$value->ctime;
}
        $class = ($i % 2 == 0) ? 'bg' : 'bg1';
     echo '<tr class=$class>
     
       <td align="center" style="font-size:12px" height="60px">'.$name.'</td>
       <td align="center" style="font-size:12px" > '.$time.'</td>
       <td align="center" style="font-size:12px" > '.$value->tkt_no.'</td>
       <td align="center" style="font-size:12px" >'. $value->source.' <br/>(To)<br/> '.$value->dest.'</td>
       <td align="center" style="font-size:12px" > '.$value->travels.'</td>
       <td align="center" style="font-size:12px" > 
       <a href="#" onclick="show_booking_PassangerDetail('.$i.')" style="color:blue;text-decoration:underline">'.$value->pnr.'</a></td>
       <input type="hidden" id="cnt'.$i.'" value="'.$value->pnr.'">
       <td align="center" style="font-size:12px"> '.$value->tkt_fare.'</td>
       <td align="center" style="font-size:12px"> '.$value->status.'</td>
       </tr>';
     
        //echo "<tr><td id='sh$i' colspan='10'></td></tr>";
       $i++;
      
    }

    echo "</table>";
    echo "<input type='hidden' id='cntt' value=$i>";
    echo "<span id='result'> </span>";
   
    echo "<div class='pagination' style='text-align:center'>";
    echo "<br />";
    echo $links;
    echo '</div>';
}
?>