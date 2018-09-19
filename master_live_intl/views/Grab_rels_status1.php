<?php error_reporting(0); ?>

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
	padding:3px;	
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;	
	padding:3px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}
</style>
        
	</head>             
</html>
<div align="right"><h4><a href="<?php echo base_url('master_control/grab_rels_history'); ?>">Go back</a></h4></div>
<?php
echo "<table cellspacing='0' cellpadding='0' align='center' style='margin: 0px auto;' class='gridtable' width='500'>";
echo "<tr>";
echo "<th>service_num</th>";
echo "<th width='40%'>seat_name</th>";
echo "<th>available</th>";
echo "<th>available_type</th>";
echo "<th>ip</th>";
echo "<th>tim</th>";
echo "<th>updated_by_id</th>";
echo "<th>updated_by</th>";
echo "</tr>";
$i=1;
foreach($grab as $row){
       $uid=$row->id;
	   $seat = $row->seat_name;
	   $str = str_replace(","," ",$seat);
		echo "<tr>";
		echo "<td style='font-size:12px';>".$row->service_num."</td>";
        echo "<td style='font-size:12px';>".$str."</td>";
		echo "<td style='font-size:12px';>".$row->available."</td>";
		echo "<td style='font-size:12px;'>".$row->available_type."</td>";
		echo "<td style='font-size:12px;'>".$row->ip."</td>";
        echo "<td style='font-size:12px;'>".$row->tim."</td>";
		echo "<td style='font-size:12px;'>".$row->updated_by_id."</td>";
		echo "<td style='font-size:12px;'>".$row->updated_by."</td>";
        echo "</tr>";
        $i++;
}
echo "</table>";
echo "<div class='pagination' style='text-align:center'>";
echo "$links";
echo '</div>';
?>