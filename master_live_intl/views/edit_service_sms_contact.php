<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Details</title>
<script type="text/javascript" src="<?php echo base_url("js/jquery.min.js");?>"></script>
<script>
$(document).ready(function(){
            
			$('#update').click(function(){
            var uid = $("#uid").val();
            var contact = $("#contact").val();
            
            var status = $("#status").val();
            var filter=/^\d+(,\d+)*$/;
        
         
        
            if(contact === "" ||!filter.test(contact))
            {
            alert("Please Provide Your Contact No");
            $("#contact").focus();
            return false;
             }
         
             else
            {
			
                $.post('update_service_sms_contact',{id:uid,status:status,contact:contact},function(res)
				{
                //alert(res);         
                  if(res==1)
                     {
                      alert('Updated successfully'); 
					  setTimeout('window.location = "add_service_sms_contact"');  
                     }
                     else{
                      alert('not Updated ');   
                     }
				});
            }
          });
          });
        
</script>

</head>

<p align="right" style="padding-right:220px; padding-top:10px;"><?php echo anchor('master_control/add_service_contact_number','Go Back'); ?></p>
<h4 align="center">Edit Details</h4>
<?php
foreach ($query as $rows) {
    $id=$rows->id;
    $status = $rows->status;
	
?>    
  <table align="center" cellspacing="10" style="margin: 0px auto;" id="tbl">
        
        <tr align="center" style="font-size:12px;">
        <td align="right">Operator:</td>
        <td align="left"><input type="text" id="travel_id" nam="travel_id" value="<?php echo $rows->operator_title;?>" readonly="" ></td>
        </tr>
		<tr align="center" style="font-size:12px;">
        <td align="right">Service Number:</td>
        <td align="left"><input type="text" id="service_num" nam="service_num" value="<?php echo $rows->service_num;?>" readonly="" ></td>
        </tr>
		<tr align="center" style="font-size:12px;">
        <td align="right">SMS Number:</td>
        <td align="left"><input type="text" id="contact" nam="contact" value="<?php echo $rows->contact;?>" ></td>
        </tr>
        
        <tr align="center" style="font-size:12px;">
        <td align="right">API SMS Status:</td>
        <td align="left"><select id="status">
		<?php
                                if($status == 0)
								{
		?>						
                                <option value="0" selected="selected">Inactive</option>
                                <option value="1">Active</option>
								<?php
								}
								else
								{
								?>
								<option value="0">Inactive</option>
                                <option value="1" selected="selected">Active</option>
								<?php
								}
								?>
                            </select></td>
        </tr>
        
        <tr align="center" style="font-size:12px; margin: 0px auto;">
        <td colspan="3" align="center" border="0">
<input type="hidden" name="uid" id="uid" value="<?php echo $id;?>">        
<input type="button" name="update" id="update" value="Update" ></td>
        </tr>
          </table>
  <?php       
}

?>


</html>
           