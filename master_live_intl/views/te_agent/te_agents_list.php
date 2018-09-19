<?php error_reporting(0); ?>

      <link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />
        <title>External agents</title>
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

         <meta charset="utf-8"/>
	
        <script>
            var r;
        function status(i,s,uid)
        {
         
        if(s==1)
               r="Inactive";
           else
               r="Active";
          var con=confirm("Are you sure you want to " +r);
          if(con==true)
              {
               $.post("active_new_agent",{status:s,id:uid},function(res){
                 
                 if(res==1)
                     {
                         alert('status has been changed');
                         setTimeout('window.location = "te_agents"');
                     }
                 else
                     alert('');
               }); 
              }
              else
                  {
                   return false; 
                  }
        }
       
        </script>
	
            <table width="73%" border="0" cellpadding="0" cellspacing="0" align="center">
                  <tr>
                    <td height="40" style="padding-left:10px;">Ticket Engine Agents</td>
                  </tr>
                 <tr>
                     <td></td>
                 </tr>
                  <tr>
                    <td style="border-top:#f2f2f2 solid 1px;"> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	
		<tr>
		<td></td>
		<td align="right">
        <?php echo anchor('master_control/addteagent', 'Add Ticket Engine Agent', 'title="new Ticket Engine agent"'); ?>      </td>
		<td>&nbsp;</td>
                </tr>
                <tr>
                      <td height="30" colspan="3" align="center" ></td>
                    </tr>
                                   

<?php
echo "<table align='center' style='font-size:11px;' width='100%'>";
echo "<tr>";
echo "<td height='30' class='space'><strong>Name</strong></td>";
echo "<td class='space'><strong>Username</strong></td>";
echo "<td class='space'><strong>Password</strong></td>";
echo "<td class='space'><strong>Contact No</strong>.</td>";
echo "<td class='space'><strong>Email Id</strong></td>";
echo "<td class='space'><strong>Balance</strong></td>";
echo "<td class='space'><strong>Margin</strong></td>";
echo "<td class='space'><strong>Pay Type</strong></td>";
echo "<td class='space'><strong>Limit</strong></td>";
echo "<td class='space'><strong>Status</strong></td>";
echo "<td class='space'><strong>Option</strong></td>";
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
        
	echo "<td  height='30' class='space'>".$row->name."</td>";
         echo "<td  class='space'>".$row->uname."</td>";
		 echo "<td  class='space'>".$row->password."</td>";
	echo "<td class='space'>".$row->mobile."</td>";
	echo "<td class='space'>".$row->email."</td>";
        echo "<td class='space'>".$row->balance."</td>";
        echo "<td class='space'>".$row->margin."</td>";
        echo "<td class='space'>".$row->pay_type."</td>";
        echo "<td class='space'>".$row->bal_limit."</td>";
        echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;' onclick='status(".$i.",".$status.",".$uid.")'>".$x."</span></td>";
	echo "<td class='space'>".anchor('master_control/UpdateDet?id='.$uid, 'Update', '')."</td>";
        echo "</tr>";
        $i++;
}
echo "</table>";

?>
                    <tr>
                      <td height="30" colspan="3" align="center" ></td>
                    </tr>
                        
		  </table> 
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr> 
                  
                </table>