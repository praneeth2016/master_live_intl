<?php error_reporting(0); ?>
<html>
    <head>
      <link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />
      <link rel="stylesheet" href="<?php echo base_url("css/table_ebs.css") ?>" type="text/css" />
  
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
        <script>
            function ChangeData(){
                var op=$('#operators').val();
                $.post('getPrepaid_db',{op:op},function(res){
                 $('#sp').html(res); 
                 $('#tbl').hide(); 
                });
            }
            </script>
			<script>
            var r;
        function status(i,s,uid)
        {
        if(s===1)
            r="Inactivate";
           else
            r="Activate";
          var con=confirm("Are you sure, you want to " +r +" this agent.");
          if(con===true)
           {
            $.post("prepaid_change_status",{status:s,id:uid},function(res){
                 if(res==1)
                     {
                         alert('status has been changed');
                         setTimeout('window.location = "prepaid_agents"');
                     }
                 else{
                     alert('There was a problem');
                    }
               }); 
              }
              else return false; 
        }
        
       
        </script>
	</head>

		  <h4 align="center" >Prepaid Agents List</h4>
                  <table align="center"  cellspacing="10" width="740">
		<tr>
                    <td style='font-size:12px;' align="right">Select operator:</td>
		  <td>
                     <?php $op_id = 'id="operators" style="width:150px; font-size:12px" onChange="ChangeData()"';
                     echo form_dropdown('operators',$operators,"",$op_id);?>
                  </td>
		 
  </tr>
		    
		  </table>
                              
</html>
<?php
echo "<table id='tbl' class='gridtable' style='margin: 0px auto; width='550'>";
echo "<tr >";
echo "<th>Name</th>";
echo "<th>Username</th>";
echo "<th>Password</th>";
echo "<th>Contact No.</th>";
echo "<th>Email Id</th>";
echo "<th>Balance</th>";
echo "<th>Margin</th>";
echo "<th>Pay Type</th>";
echo "<th>Limit</th>";
echo "<th>Status</th>";
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
	
	echo '<tr  align="center">';
        
	echo "<td style='font-size:12px';>".$row->name."</td>";
         echo "<td style='font-size:12px';>".$row->uname."</td>";
		 echo "<td style='font-size:12px';>".$row->password."</td>";
	echo "<td style='font-size:12px;'>".$row->mobile."</td>";
	echo "<td style='font-size:12px;'>".$row->email."</td>";
        echo "<td style='font-size:12px;'>".$row->balance."</td>";
        echo "<td style='font-size:12px;'>".$row->margin."</td>";
        echo "<td style='font-size:12px;'>".$row->pay_type."</td>";
        echo "<td style='font-size:12px;'>".$row->bal_limit."</td>";
		echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;' onclick='status(".$i.",".$status.",".$uid.")'>".$x."</span></td>";
	echo "<td>".anchor('master_control/UpdateDet?id='.$uid, 'Update', '')."</td>";
        echo "</tr>";
        $i++;
}
echo "</table>";

?>
<div id="sp">
    
</div>