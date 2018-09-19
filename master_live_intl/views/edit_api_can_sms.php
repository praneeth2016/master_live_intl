<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Details</title>
<script type="text/javascript" src="<?php echo base_url("js/jquery.min.js");?>"></script>
<script>
$(document).ready(function(){
            
			$('#Save').click(function(){
            var uid = $("#hdn").val();
            var mobile = $("#ag_mobile").val();
            
            var st = $("#ag_status").val();
            var contact=/^\d+(,\d+)*$/;
        
         
        
            if(mobile === "" ||!contact.test(mobile))
            {
            alert("Please Provide Your Contact No");
            $("#ag_mobile").focus();
            return false;
             }
         
             else
            {
			
                $.post('modify_api_can_sms',{id:uid,status:st,mobile:mobile},function(res)
				{
                //alert(res);         
                  if(res==1)
                     {
                      alert('Updated successfully'); 
					  setTimeout('window.location = "update_cancel_sms_number"');  
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

<p align="right" style="padding-right:220px; padding-top:10px;"><?php echo anchor('master_control/update_cancel_sms_number','Go Back'); ?></p>
<h4 align="center">Edit Details</h4>
<?php
foreach ($query as $rows) {
    $id=$rows->id;
    $api_can_sms = $rows->api_can_sms;
	
?>    
  <table align="center" cellspacing="10" style="margin: 0px auto;" id="tbl">
        
        <tr align="center" style="font-size:12px;">
        <td align="right">Cancellation SMS Number:</td>
        <td align="left"><input type="text" id="ag_mobile" nam="ag_mobile" value="<?php echo $rows->contact_no;?>" ></td>
        </tr>
        
        <tr align="center" style="font-size:12px;">
        <td align="right">API Cancellation SMS Status:</td>
        <td align="left"><select id="ag_status">
		<?php
                                if($api_can_sms == 0)
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
<input type="hidden" name="hdn" id="hdn" value="<?php echo $id;?>">        
<input type="button" name="Save" id="Save" value="Update" ></td>
        </tr>
          </table>
  <?php       
}

?>


</html>
           