<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>operator</title>
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
</head>
</html>
<?php
if($query1->num_rows()==0){
    echo '<table width="100%" border="0" id="tbl"><tr style="color:red; font-weight:bold; font-size:14px;" align="center">
        <td>No Records Found on Selected Data</td></table>';
} 
else {
echo '<table width="100%" border="1" id="tbl"><tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; 
                       border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; 
                       border-left:#f2f2f2 solid 1px;">
        <th>S.No</th>
        <th>Operator Name</th>
        <th>Ticket No</th>
        <th>PNR No</th>
        <th>Source</th>
        <th>Destination</th>
		<th>Booking Date</th>
        <th>Journey Date</th>
        <th> status</th>
        <th>Fare</th>
<th>Booked By</th>
<th>Portal</th>
        </tr>';
      $i=1;
       foreach ($query1->result() as $value) {
$agent_id = $value->agent_id;
$operator_agent_type = $value->operator_agent_type;

if($value->agent_id == "" || $value->agent_id == 0)
{
$agent_id = $value->book_pay_agent;
}

$travel_id = $value->travel_id;
//echo $agent_id."".$travel_id;
if($agent_id == 125 || $agent_id == 161 || $agent_id == 204)
{
	$sql = mysql_query("select name from agents_operator where id='$agent_id'");
}
else
{
	$sql = mysql_query("select name from agents_operator where operator_id='$travel_id' and id='$agent_id'");
}	
//echo "select name from agents_operator where operator_id='$travel_id' and id='$agent_id'";
$row = mysql_fetch_array($sql);


	$name = $row['name'];

         $class = ($i%2 == 0)? 'bg': 'bg1'; 
        echo "<tr class=$class>
        <td align='center' height='30'>$i </td>
        <td align='center'> $value->travels</td>
        <td align='center'> $value->tkt_no</td>
        <td align='center'> $value->pnr</td>
        <td align='center'> $value->source</td>
        <td align='center'> $value->dest</td>
		<td align='center'> $value->bdate</td>
        <td align='center'>"; 
		if($value->status == "confirmed")
		{
			echo $value->jdate;
		}
		else
		{
			echo $value->cdate;
		}	
		echo"</td>
        <td align='center'> $value->status</td>
        <td align='center'>";
		if($value->status == "confirmed")
		{
			echo $value->tkt_fare;
		}
		else
		{
			echo $value->refamt;
		}
		 echo"</td>
<td align='center'>";
if($agent_id == 125 || $agent_id == 161 || $agent_id == 204)
{
	$booked = "Ticket Engine";
}
else if($operator_agent_type == 4)
{
	$booked = "Website";
}
else
{
	$booked = $name;
}
echo $booked;
echo"</td>
<td align='center'> $name</td>
    </tr>";
  $i++;
  }
        echo "</table>";
echo "<div class='pagination' style='text-align:center'>";
echo $links;
echo '</div>';
} 
?>