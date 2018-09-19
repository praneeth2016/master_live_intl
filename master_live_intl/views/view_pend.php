<html> 
    <head>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" media="screen" />
        <script src="<?php echo base_url("js/jquery-1.5.2.min.js");?>" type="text/javascript"></script>
        <!--<script>
            
        function status(i,s,uid)
        {
             var r;
             if(s===0)
              
               r="Active";
          var con=confirm("Are you sure you want to " +r);
          if(con===true)
              {
               $.post("active_in",{status:s,id:uid},function(res){
                 alert(res); 
                 if(res==1){
                     alert('status has been changed');
                     setTimeout('window.location = "pend_operator"',2000);
                 }
                 else
                     {
                     alert('status has been changed');
                     setTimeout('window.location = "pend_operator"',2000);
                     }
                    }); 
              }
              else
                  {
                   return false; 
                  }
        }
        </script>-->
		<script> 
		function  abc(){
		alert("Are You sure want to change");
		}
		</script>
    </head>
    
    
    <h1 align='center' style='font-size:16px'>Pending Operators</h1>
</html>
<?php

echo "<table align='center' cellspacing='15px' cellpadding='10px' style='margin: 0px auto;'>";
echo "<tr>";

echo "<th style='font-size:14px'>Operator Title</th>";
echo "<th style='font-size:14px'>Travel Id</th>";
echo "<th style='font-size:14px'>Name</th>";
echo "<th style='font-size:14px'>Contact No.</th>";
echo "<th style='font-size:14px'>Email Id</th>";
echo "<th style='font-size:14px'>Status</th>";
echo "<th style='font-size:14px'>ViewStatus </th>";
echo "</tr>";
$i=1;
foreach($query as $row){
       $uid=$row->id;
       $opt= $row->operator_title;
       $status= $row->status;
	   $view = $row->central_agent;
       if($status==1)
       {
        $x='Active';   
       }
       else {
           $status=0;
         $x='Inactive';  
       }
	   if ($view == yes){
	$v = 'Switch to Old';
	}
	else {
	$view = "no";
	$v = 'Switch To New';
	}
	echo "<tr>";
        
	echo "<td style='font-size:12px';>".anchor('master_control/view_detail'.'/'.$uid,$opt)."</td>";
echo "<td style='font-size:12px;'>".$row->travel_id."</td>";	
echo "<td style='font-size:12px;'>".$row->name."</td>";
	echo "<td style='font-size:12px;'>".$row->contact_no."</td>";
	echo "<td style='font-size:12px;'>".$row->email_id."</td>";
        /*echo "<td><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;' onclick='status(".$i.",".$st.",".$uid.")'>".$x."</span></td>";*/
		echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;'onclick='abc()'>" . anchor('master_control/active_in?id=' . $uid, "$x") . "</td>";
		echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;' onclick='abc()'>" . anchor('master_control/active_view?id=' . $uid, "$v") . "</td>";
	echo "</tr>";
        $i++;
}
echo "</table>";
echo "<div class='pagination' style='text-align:center'>";
echo $links;
echo '</div>';
?>