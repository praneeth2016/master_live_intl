<html>
<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" media="screen" />
<script src="<?php echo base_url("js/jquery-1.5.2.min.js");?>" type="text/javascript"></script>
<!--<script>
            
        function status(i,s,uid)
        {
            var r;
            if(s===1)
               r="Inactive";
           
          var con=confirm("Are you sure you want to " +r);
          if(con===true)
              {
               $.post("active_in",{status:s,id:uid},function(res){
                 
                 if(res===1){
                     alert('status has been changed');
                     setTimeout('window.location = "active_operator"',2000);
                 }
                 else
                     {
                     alert('status has been changed');
                     setTimeout('window.location = "active_operator"',2000);
                    
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

<h1 align='center' style='font-size:16px'>Active Operators</h1>
</html>
<?php

echo "<table align='center' cellspacing='15px' cellpadding='10px' style='margin: 0px auto;'>";
echo "<tr>";

echo "<th style='font-size:14px'>Operator Title</th>";
echo "<th style='font-size:14px'>Travel Id</th>";
echo "<th style='font-size:14px'>Name</th>";
echo "<th style='font-size:14px'>Contact No.</th>";
//echo "<th style='font-size:14px'>Email Id</th>";
echo "<th style='font-size:14px'>Status</th>";
echo "<th style='font-size:14px'>ViewStatus </th>";
echo "<th style='font-size:14px'>Home Page </th>";
echo "</tr>";
$i=1;
foreach($query as $row){
       $uid= $row->id;	
       $status= $row->status;
       $opt= $row->operator_title;
	   $view = $row->central_agent;
	   $home_page = $row->home_page; 
	  
       if($status==1)
       {
        $x='Active';   
       }
       else {
           $status=0;
         $x='Inactive';  
       }
	   if ($view == yes){
	$v = 'Switch To Old';
	}
	else {
	$view = "no";
	$v = 'Switch To New';
	}
	if($home_page == yes){
	$home_page1 = 'Switch To Booking';
	}else if($home_page == no ){	
	$home_page1 = 'Switch To Home';
	}
	
      
	echo "<tr>";
        
	echo "<td style='font-size:12px';>".anchor('master_control/view_detail'.'/'.$uid,$opt)."</td>";
echo "<td style='font-size:12px';>". $row->travel_id."</td>";
	echo "<td style='font-size:12px';>". $row->name."</td>";
	echo "<td style='font-size:12px';>". $row->contact_no."</td>";
	//echo "<td style='font-size:12px';>". $row->email_id."</td>";
        /*echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;' onclick='status(".$i.",".$status.",".$uid.")'>".$x."</span></td>";*/
		echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;'onclick='abc()'>" . anchor('master_control/active_in?id=' . $uid, "$x") . "</td>";
		echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;' onclick='abc()'>" . anchor('master_control/active_view?id=' . $uid, "$v") . "</td>";
		echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;' onclick='abc()'>" . anchor('master_control/active_view_home?id=' . $uid, "$home_page1") . "</td>";
		
	echo "</tr>";
        $i++;
}
echo "</table>";
echo "<div class='pagination' style='text-align:center'>";
echo $links;
echo '</div>';
?>
