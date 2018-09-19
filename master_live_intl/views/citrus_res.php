<html>
    <head>
     
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
<?php
echo "<div style='width:760px;overflow-x:auto; margin:0 auto'><table cellspacing='0' cellpadding='0' align='center' class='gridtable'>";
echo "<tr>";
echo "<th>name</th>";
echo "<th>txnstatus</th>";
echo "<th>pgTxnNo</th>";
echo "<th>issuerrefno</th>";
echo "<th>authIdCode</th>";
echo "<th>txnid</th>";
echo "<th>amount</th>";
echo "<th>pgRespCode</th>";
//echo "<th>tim</th>";
echo "<th>ip</th>";
//echo "<th>today</th>";
echo "<th>tran_time</th>";
echo "</tr>";
$i=1;
foreach($cit_res as $row){
       $uid=$row->id;
       $msg = urldecode($row->msg);
       $tktfare = $row->amount;
	   if($tktfare!=""){
		echo "<tr>";
		echo "<td style='font-size:12px';>".$row->name."</td>";
        echo "<td style='font-size:12px';>".$row->txnstatus."</td>";
		echo "<td style='font-size:12px';>".$row->pgTxnNo."</td>";
		echo "<td style='font-size:12px;'>".$row->issuerrefno."</td>";
		echo "<td style='font-size:12px;'>".$row->authIdCode."</td>";
        echo "<td style='font-size:12px;'>".$row->txnid."</td>";
		echo "<td style='font-size:12px';>".$row->amount."</td>";
		echo "<td style='font-size:12px';>".$row->pgRespCode."</td>";
		//echo "<td style='font-size:12px;'>".$row->tim."</td>";
		echo "<td style='font-size:12px;'>".$row->ip."</td>";
        //echo "<td style='font-size:12px;'>".$row->today."</td>";
		echo "<td style='font-size:12px;'>".$row->tran_time."</td>";
        echo "</tr>";
        $i++;
		}
}
echo "</table></div>";
echo "<div class='pagination' style='text-align:center'>";
echo "$links";
echo '</div>';
?>