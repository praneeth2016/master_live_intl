<?php 
foreach($query as $row)
{
   $pay=$row->pay_type; 
}
?>
<html>
    <head>
        <title>View profile</title>
        <script type="text/javascript" src="<?php echo base_url("js/jquery.min.js");?>"></script>
                 <link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />

	
    </head>
<p align="right" style="padding-right:220px; padding-top:10px;"><?php echo anchor('master_control/prepaid_agents','Go Back'); ?></p>

        <?php
echo "<table align='center' cellspacing='10px' style='margin: 0px auto;'>";
foreach($query as $row)
          {
            
                echo "<tr>      
	       <h4 align='center' >View Prepaid Agent's Profile</h4>
	  </tr> 
         
          <tr style='font-size:12px;'>      
	  <td>Name:</td>
	  <td>$row->name</td>
	 </tr> 
         <tr style='font-size:12px;'>      
	 <td>Username:</td>
	  <td>$row->uname</td>
	 </tr> 
         <tr style='font-size:12px;'>      
	  <td>Contact No:</td>
	  <td>$row->mobile</td>
	 </tr> 
         <tr style='font-size:12px;'>      
	  <td>Email ID:</td>
	  <td>$row->email</td>
	 </tr>
         <tr style='font-size:12px;'>      
	  <td>Payment type:</td>
	  <td>$row->pay_type</td>
	 </tr>
         <tr style='font-size:12px;'>
           <td>Pay limit:</td>
           <td>$row->bal_limit</td>
	</tr>
         <tr style='font-size:12px;'>      
	  <td>Margin:</td>
	  <td>$row->margin</td>
	 </tr>
         <tr style='font-size:12px;'>      
	  <td>Balance:</td>
	  <td>$row->balance</td>
	 </tr>
         <tr style='font-size:12px;'>      
	  <td>Address:</td>
	  <td>$row->address</td>
	 </tr>";
  }
   
	echo '</table>';
        echo '<span id="h"></span>';
        ?>
       
</html>


