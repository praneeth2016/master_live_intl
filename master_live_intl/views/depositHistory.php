<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/datepicker2/jdpicker.css" type="text/css" />
<script type ="text/javascript" src="<?php echo base_url();?>js/datepicker/jquery-1.7.2.min.js"></script>
<script type ="text/javascript" src="<?php echo base_url();?>js/datepicker2/jquery.jdpicker.js"></script>
</head>
<script>
function getUpdatebox(i)
{
 var cc=$('#cc').val();

 for(j = 1;j <= cc;j++)
	{
if(j==i)
 {
$("#netr"+j).show();
}
else
{
$("#netr"+j).hide();
}
}


}
function updateBal(i)
{

             var travelid=$('#travelid'+i).val(); 
             var agentid=$('#agentid'+i).val();
			 var amt=$('#amt'+i).val();
			 var jrno=$('#jrno'+i).val();
            $.post('depositUpdate', {travelid:travelid, agentid:agentid,amt:amt,jrno:jrno}, function(res)
		    {
			
			if(res==1)
			{
			
			$('#netr'+i).hide();
			$('#up'+i).html("updated");
			alert("Updated Successfully");
			
			}
			else
			{
			alert("Update is not done");
			}
                      
            });

}
</script>
<script>
        function Report()
        {
            var from=$('#date_from').val(); 
            var to=$('#date_to').val();
       
          $.post('depositDetail', {from1: from, to1: to}, function(res)
		    {
                      $('#tbl1').empty();
  $('#tbl').empty();
					  
					   $('#div').html(res);
					   //$('.upd').hide();
            });
        }
</script>
<body>
  <table align="center" style="margin: 0px auto;font-family: sans-serif;font-size: 12px">
       <tr>
                           
                           <td width="55" height="30">From:</td>
                           <td width="100" height="30"><input type="text" size='12' name="date_from" id="date_from" class="jdpicker" style="background-image:url(<?php echo base_url('images/calendar.gif')?>); background-repeat:no-repeat;border:#898989 solid 1px; padding-top:1px; padding-bottom:1px; padding-left:25px; background-position:left; background-color:#FFFFFF; height:18px; width:100px;" value='<?php echo(Date("Y/m/d")); ?>' /></td>
                           <td width="10" height="30"></td>
			  <td width="31" height="30">To:</td>
                           <td width="100" height="30"><input style="background-image:url(<?php echo base_url('images/calendar.gif')?>); background-repeat:no-repeat;border:#898989 solid 1px; padding-top:1px; padding-bottom:1px; padding-left:25px; background-position:left; background-color:#FFFFFF; height:18px; width:100px;" type="text" size='12' name="date_to" id="date_to" class="jdpicker" value='<?php echo(Date("Y/m/d")); ?>' /></td> <td></td> <td><input type="button" name="submit" id="submit" value="submit" onClick='Report();'></td>
                          
                         </tr>
    </table>
    <br />
   


<?php
if($query->num_rows()==0){
    echo '<table width="960px" border="0" id="tbl"><tr style="color:red; font-weight:bold; font-size:14px;" align="center">
        <td>No Records Found</td></table>';
} 
else {
echo '<table width="960px" border="0" id="tbl1"><tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; 
                       border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; 
                       border-left:#f2f2f2 solid 1px;">
        <th>S.No</th>
		 <th>Agent name</th>
        <th>A/C No</th>
        <th>Deposit Date</th>
        <th>Reference No</th>
        <th>Payment Type</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Received Date</th>
		<th>  </th>
       </tr>';
      $i=1;
 foreach ($query->result() as $value)
  {
		$agent_id = $value->agent_id;
		$travel_id = $value->travel_id;
		$acno = $value->ac_no;
		$depdate = $value->deposit_date;
		$journal_no = $value->journal_no;
		$agname = $value->agent_name;
		$deptype = $value->deposit_type;
		$amt = $value->amount;
		$status=$value->status;
        $class = ($i%2 == 0)? 'bg': 'bg1'; 
        echo "<tr class=$class>
        <td align='center'> $i </td>
		<td align='center'> $agname</td>
        <td align='center'> $acno</td>
        <td align='center'> $depdate</td>
        <td align='center'> $journal_no</td>
        <td align='center'> $deptype </td>
        <td align='center'> $amt</td>
        <td align='center' id='st$i'> $status</td>
        <td align='center'> $depdate</td>
        <td align='center' id='up$i'> 
		<input type='button' value='update'  onclick='getUpdatebox($i)' >
		</td>
		 </tr>";
		 echo "<tr class=$class id='netr$i' style='display:none'>
		 <td align='center'> </td>
		 <td align='center'> </td>
        <td align='center'> Amount : </td>
		<td align='center'> </td>
        <td align='center'> <input type='text' value='$amt' id='amt$i' name='amt$i' ></td>
        <td align='center'> 
		<input type='button' value='submit'  onclick='updateBal($i)'>
		</td>
		<input type='hidden' name='agentid$i' id='agentid$i' value='$agent_id'> 
		<input type='hidden' name='travelid$i' id='travelid$i' value='$travel_id'> 
		<input type='hidden' name='jrno$i' id='jrno$i' value='$journal_no'>   
        </tr>";
       $i++;
  }
   echo'<input type="hidden" id="cc" value="'.$i.'">';
        echo "</table>";
		
}
		
		?>
		<div id="div"> </div>
	</body>
</html>