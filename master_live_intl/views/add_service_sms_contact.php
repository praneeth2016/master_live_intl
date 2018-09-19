<?php error_reporting(0); ?>

<html>
    <head>
     <link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />
        <title>Api sms update</title>
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
				//alert(op);
                $.post('view_service_sms_update',{op:op},function(res){
				//alert(res);
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
            $.post("update_api_status",{status:s,id:uid},function(res){
			//alert(res);
                 if(res==1)
                     {
                         alert('status has been changed');
                         setTimeout('window.location = "update_contact_number"');
                     }
                 else{
                     alert('There was a problem');
                    }
               }); 
              }
              else return false; 
        }
        
		function getServices() {
			var op=$('#operators').val();
			if(op != 0) {
				//alert(op);
    	        $.post('getServices',{op:op},function(res){
					//alert(res);
            		$('#service_num').html(res);             	
	            });            
			}	
		}
		
		function save_service_sms_contact() {
			var travel_id=$('#operators').val();
			var service_num=$('#service_num').val();
			var contact=$('#contact').val();
			
			if(travel_id == 0) {
				//alert(op);
				alert('Select Operator');
				return false;    	                    
			}
			if(service_num == 0) {
				//alert(op);
				alert('Select service_num');
				return false;    	                    
			}
			if(contact == '') {
				//alert(op);
				alert('Provide Contact');
				return false;    	                    
			}
			else {
				$.post('save_service_sms_contact',{travel_id:travel_id,service_num:service_num,contact:contact},function(res){
					//alert(res);
            		if(res==1)
                    {
                    	alert('contact has been saved');
                        setTimeout('window.location = "add_service_sms_contact"');
                    }
                 	else if(res==1){
                    	alert('There was a problem');
                    } else {
						alert(res);
					}
	            });
			}
		}
       
        </script>
	</head>
        <h4 align='center'>Add Service Sms Number</h4>
		
<table width="980" border="0" cellspacing="1" cellpadding="1" align="center">
  <tr>
    <td>Select operator:</td>
    <td><?php $op_id = 'id="operators" style="width:150px; font-size:12px" onChange="getServices()"';
                     echo form_dropdown('operators',$operators,"",$op_id);?></td>
    <td>&nbsp;</td>
    <td>Select Service:</td>
    <td><select id="service_num" name="service_num">
					 <option>Select</option>
    </select></td>
    <td>&nbsp;</td>
    <td>Mobile:</td>
    <td><input type="text" name="contact" id="contact" value="" maxlength="10"></td>
    <td>&nbsp;</td>
    <td><input type="button" name="save" id="save" value="Save Contact" onClick="save_service_sms_contact()"></td>
  </tr>
</table>
<br />             
<?php
echo "<table id='tbl' style='margin: 0px auto;' class='gridtable'  width='550'>";
echo "<tr>";
echo "<th>Name</th>";
echo "<th>Travel Id </th>";
echo "<th>Service Number </th>";
echo "<th>contact No </th>";
echo "<th>Status</th>";
echo "<th>Option</th>";
echo "</tr>";
$i=1;
foreach($query as $row){
       $uid=$row->id;
       $status= $row->status;
       if($status==1)
       {
        $x='Active';   
       }
       else {
           //$status=0;
         $x='Inactive';  
       }
	echo "<tr>";
        
	echo "<td style='font-size:12px';>".$row->operator_title."</td>";
        echo "<td style='font-size:12px';>".$row->travel_id."</td>";
		echo "<td style='font-size:12px';>".$row->service_num."</td>";
	echo "<td style='font-size:12px;'>".$row->contact."</td>";
        echo "<td style='font-size:12px;'>".$x."</td>";
	//echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;'onclick='status(".$i.",".$status.",".$uid.")'>".$x."</span></td>";
	echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;'>".anchor('master_control/edit_service_sms_contact?uid='.$uid, 'Update', '')."</span></td>";
        
        echo "</tr>";
        $i++;
}
echo "</table>";

?>

<div id="sp">
    
</div>
</html>