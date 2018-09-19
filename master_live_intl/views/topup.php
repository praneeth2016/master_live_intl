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
echo "<div style='width:760px;overflow-x:auto; margin:0 auto'><table cellspacing='0' cellpadding='0' align='center' class='gridtable'>";
echo "<tr>";
echo "<th>Operator_Name	</th>";
echo "<th>travel_id</th>";
echo "<th>agent_id</th>";
echo "<th>agent_type</th>";
echo "<th>agent_name</th>";
echo "<th>pay_mode</th>";
echo "<th>user_name</th>";
echo "<th>bal_before_txn</th>";
echo "<th>net_amt</th>";
echo "<th>comm</th>";
echo "<th>bal_after_txn</th>";
echo "<th>top_up_amt</th>";
echo "<th>remarks</th>";
echo "<th>txn_id</th>";
echo "<th>txn_date</th>";
echo "<th>date_time</th>";
echo "<th>ip</th>";
echo "<th>topup_by</th>";
echo "</tr>";
$i=1;
foreach($topup as $row){
       $uid=$row->id;
       $msg = urldecode($row->msg);
       
		echo "<tr>";
		echo "<td style='font-size:12px';>".$row->Operator_Name."</td>";
        echo "<td style='font-size:12px';>".$row->travel_id."</td>";
		echo "<td style='font-size:12px';>".$row->agent_id."</td>";
		echo "<td style='font-size:12px;'>".$row->agent_type."</td>";
		echo "<td style='font-size:12px;'>".$row->agent_name."</td>";
        echo "<td style='font-size:12px;'>".$row->pay_mode."</td>";
		echo "<td style='font-size:12px';>".$row->user_name."</td>";
        echo "<td style='font-size:12px';>".$row->bal_before_txn."</td>";
		echo "<td style='font-size:12px';>".$row->net_amt."</td>";
		echo "<td style='font-size:12px;'>".$row->comm."</td>";
		echo "<td style='font-size:12px;'>".$row->bal_after_txn."</td>";
        echo "<td style='font-size:12px;'>".$row->top_up_amt."</td>";
		echo "<td style='font-size:12px';>".$row->remarks."</td>";
        echo "<td style='font-size:12px';>".$row->txn_id."</td>";
		echo "<td style='font-size:12px';>".$row->txn_date."</td>";
		echo "<td style='font-size:12px;'>".$row->date_time."</td>";
		echo "<td style='font-size:12px;'>".$row->ip."</td>";
        echo "<td style='font-size:12px;'>".$row->topup_by."</td>";
        echo "</tr>";
        $i++;
}
echo "</table></div>";
echo "<div class='pagination' style='text-align:center'>";
echo "$links";
echo '</div>';
?>