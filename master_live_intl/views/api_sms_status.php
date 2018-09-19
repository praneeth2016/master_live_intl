
<html>
    <head>
     <link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />
        <title>Inhouse agents</title>
<style type="text/css">
table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:12px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}
</style>
        
	</head>
                
</html>

<?php 
echo "<table id='tbl' style='margin: 0px auto;' class='gridtable'  width='60%'>";
echo "<tr>";
echo "<th>Date</th>";
echo "<th>Date&Time</th>";
echo "<th>Sender_id</th>";
echo "<th>Contact</th>";
echo "<th>Messege</th>";
echo "<th>Status</th>";
echo "</tr>";
$i=1;
foreach($sms_api as $row){
       $uid=$row->id;
       $msg = urldecode($row->msg);
       
		echo "<tr>";
		echo "<td style='font-size:12px';>".$row->date."</td>";
        echo "<td style='font-size:12px';>".$row->date_time."</td>";
		echo "<td style='font-size:12px';>".$row->sender_id."</td>";
		echo "<td style='font-size:12px;'>".$row->contact."</td>";
		echo "<td style='font-size:12px;'>".$msg."</td>";
        echo "<td style='font-size:12px;'>".$row->status."</td>";
        echo "</tr>";
        $i++;
}
 
echo "</table>";
echo "<div class='pagination' style='text-align:center'>";
echo "$links";
echo '</div>';
?>