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
echo "<table id='tbl' style='margin: 0px auto;' class='gridtable'  width='550'>";
echo "<tr>";
echo "<th>service_no</th>";
echo "<th>bus_no</th>";
echo "<th>driver_name</th>";
echo "<th>mobile</th>";
echo "<th>journey_date</th>";
echo "<th>travel_id</th>";
echo "</tr>";
$i=1;
foreach($data as $row){
       $uid=$row->id;
		echo "<tr>";
		echo "<td style='font-size:12px';>".$row->service_no."</td>";
        echo "<td style='font-size:12px';>".$row->bus_no."</td>";
		echo "<td style='font-size:12px';>".$row->driver_name."</td>";
		echo "<td style='font-size:12px;'>".$row->mobile."</td>";
		echo "<td style='font-size:12px;'>".$row->journey_date."</td>";
        echo "<td style='font-size:12px;'>".$row->travel_id."</td>";
        echo "</tr>";
        $i++;
}
echo "</table>";
echo "<div class='pagination' style='text-align:center'>";
echo "$links";
echo '</div>';
?>