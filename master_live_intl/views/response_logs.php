
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
                
<body>


<table id="tbl" style="margin: 0px auto;" class="gridtable"  width="60%">
<tr>
<th>Date</th>
<th>Date&Time</th>
<th>method_called</th>
<th>series</th>
<th>response</th>
<th>ip</th>
<th>api_key</th>
</tr>
<?php 
$i=1;
foreach($response_logs as $row){
       
   ?>    
		<tr>
		<td style="font-size:12px"><?php echo "$row->date"; ?></td>
        <td style="font-size:12px"><?php echo "$row->date_time"; ?></td>
		<td style="font-size:12px"><?php echo "$row->method_called"; ?></td>
		<td style="font-size:12px"><?php echo "$row->series"; ?></td>
		<td style="font-size:12px"><?php echo "$row->response"; ?></td>
        <td style="font-size:12px"><?php echo "$row->ip"; ?></td>
		<td style="font-size:12px"><?php echo "$row->api_key"; ?></td>
        </tr>
		<?php 
        $i++;
}
 
echo "</table>";
echo '<div class="pagination" style="text-align:center">';
echo "$links";
echo '</div>';
?>
</body>
</html>