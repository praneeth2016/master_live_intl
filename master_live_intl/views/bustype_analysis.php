<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />
       <link rel="stylesheet" href="<?php echo base_url("css/table_ebs.css") ?>" type="text/css" />

    <link rel="stylesheet" href="<?php echo base_url();?>css/datepicker2/jdpicker.css" type="text/css" />
<script type ="text/javascript" src="<?php echo base_url();?>js/datepicker/jquery-1.7.2.min.js"></script>
<script type ="text/javascript" src="<?php echo base_url();?>js/datepicker2/jquery.jdpicker.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script src="<?php echo base_url("js/jquery.min.js");?>" type="text/javascript"></script>
<script>

function getReport(){
    var fdate=$('#date_from').val();  
    var tdate=$('#date_to').val();
    var op=$('#operators').val();
  
    $.post('display_bustype_report',{fdate:fdate,tdate:tdate,op:op},function(res){ 
       // alert(res);
            $('#load').html(res);
           
          });
}

</script>    

</head>
	
			    <table width="748" border="0" cellpadding="1" cellspacing="1" style="margin-top:0px; margin-left:20px; margin-right:20px; margin-bottom:226px;">
                  <tr>
                    <td width="0" valign="top">
				    <td width="92" height="25" style='font-size:12px';> Select operator: </td>
                        <td width="141" align="left"> <?php $op_id = 'id="operators" style="width:150px; font-size:12px" ';
                     echo form_dropdown('operators',$operators,"",$op_id);?> </td>
                        <td width="19" height="25" style='font-size:12px';>&nbsp;</td>
                        <td width="68" style='font-size:12px';>From:</td>
                    <td width="116" height="25"><input type="text" size='18' name="date_from" id="date_from" class="jdpicker" value='<?php echo(Date("Y/m/d")); ?>' style="background-image:url(<?php echo base_url('images/calendar.gif')?>); background-repeat:no-repeat;border:#898989 solid 1px; padding-top:1px; padding-bottom:1px; padding-left:25px; background-position:left; background-color:#FFFFFF; height:22px; width:100px;"  /></td>
                        <td width="43" height="25" style='font-size:12px';>To:</td>
                    <td width="109" height="25"><input type="text" size='15' name="date_to" id="date_to" class="jdpicker" value='<?php echo(Date("Y/m/d")); ?>' style="background-image:url(<?php echo base_url('images/calendar.gif')?>); background-repeat:no-repeat;border:#898989 solid 1px; padding-top:1px; padding-bottom:1px; padding-left:25px; background-position:left; background-color:#FFFFFF; height:22px; width:100px;" /></td>
                    <td width="132"><input name="button2" type="button" onclick="getReport()" value="Submit" /></td>
                  </tr>
                  <tr>
                    <td valign="top">                  
                    <td height="25" style='font-size:12px';>&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td height="25" style='font-size:12px';>&nbsp;</td>
                    <td style='font-size:12px';>&nbsp;</td>
                    <td height="25">&nbsp;</td>
                    <td height="25" style='font-size:12px';>&nbsp;</td>
                    <td height="25">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td valign="top">                  
                    <td height="25" colspan="8" align="left" id="load">&nbsp;</td>
                  </tr>
                    </table>
			    
		      
 
</html>
<script>getReport();</script>
