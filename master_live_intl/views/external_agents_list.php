<?php error_reporting(0); ?>
<html>
    <head>
      <link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />
        <title>External agents</title>
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
         <meta charset="utf-8"/>
	<script src="<?php echo base_url("js/jquery.min.js");?>" type="text/javascript"></script>
        
	</head>
<table align="center"  cellspacing="10" width="650">
		<tr>
		  <td></td>
                <h4 align='center'>Offline Agents List</h4>
  </tr>
		        
		  </table>                
</html>
<?php
echo "<table  style='margin: 0px auto;' class='gridtable'  width='550'>";
echo "<tr>";
echo "<th>Name</th>";
echo "<th>Username</th>";
echo "<th>Contact No.</th>";
echo "<th>Email Id</th>";
echo "<th>Balance</th>";
echo "<th>Margin</th>";
echo "<th>Pay Type</th>";
echo "<th>Limit</th>";
echo "<th>Option</th>";
echo "</tr>";
$i=1;
foreach($query as $row){
       $uid=$row->id;
       $status= $row->status;
        $e='Edit';
       if($status==1)
       {
        $x='Active';   
       }
       else {
           $status=0;
         $x='Inactive';  
       }
	echo "<tr>";
        
	echo "<td style='font-size:12px';>".$row->name."</td>";
        echo "<td style='font-size:12px';>".$row->uname."</td>";
	echo "<td style='font-size:12px;'>".$row->mobile."</td>";
	echo "<td style='font-size:12px;'>".$row->email."</td>";
        echo "<td style='font-size:12px;'>".$row->balance."</td>";
        echo "<td style='font-size:12px;'>".$row->margin."</td>";
        echo "<td style='font-size:12px;'>".$row->pay_type."</td>";
        echo "<td style='font-size:12px;'>".$row->bal_limit."</td>";
	echo "<td>".anchor('master_control/view_external?uid='.$uid, 'View', '')."</td>";
        echo "</tr>";
        $i++;
}
echo "</table>";

?>