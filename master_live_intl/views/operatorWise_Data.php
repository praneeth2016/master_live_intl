<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" href="<?php echo base_url();?>css/datepicker2/jdpicker.css" type="text/css" />
<script type ="text/javascript" src="<?php echo base_url();?>js/datepicker/jquery-1.7.2.min.js"></script>
<script type ="text/javascript" src="<?php echo base_url();?>js/datepicker2/jquery.jdpicker.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script src="<?php echo base_url("js/jquery.min.js");?>" type="text/javascript"></script>
     
<style>
.bg {background-color:#ffffff;
font-family: Arial, Helvetica, sans-serif; font-size:12px;
}
.bg1 {background-color:#eff3f5;
font-family: Arial, Helvetica, sans-serif; font-size:12px;
}
</style>
</head>
	
	 <table width="747"  style="border:#5f2c28 solid 0px;"  align="center">
                      <tr>
					  <td width="91" height="25"></td>
                        <td width="91" height="25">From:</td>
                        <td width="160" height="25">
        <input type="text"  size="20" name="date_from" id="date_from" class="jdpicker" value='<?php echo(Date("Y/m/d")); ?>' style="background-image:url(<?php echo base_url('images/calendar.gif')?>); background-repeat:no-repeat;border:#898989 solid 1px; padding-top:1px; padding-bottom:1px; padding-left:25px; background-position:left; background-color:#FFFFFF; height:18px; width:100px;"  /></td>
                        <td width="43" height="25">To:</td>
                        <td width="160" height="25"><input type="text" size="20" name="date_to" id="date_to" class="jdpicker" value='<?php echo(Date("Y/m/d")); ?>' style="background-image:url(<?php echo base_url('images/calendar.gif')?>); background-repeat:no-repeat;border:#898989 solid 1px; padding-top:1px; padding-bottom:1px; padding-left:25px; background-position:left; background-color:#FFFFFF; height:18px; width:100px;" /></td>
                        <td width="366"><input name="button2" type="button" onclick="getReport()" value="Submit" /></td>
                      </tr>
                    </table>
        <span id="loadd"></span>
</html>
   <script>
	getReport();	
        function getReport()
        {
          var fdate=$('#date_from').val();  
          var tdate=$('#date_to').val();
          $.post('display_operatorWise_report',{fdate:fdate,tdate:tdate},function(res){          
            $('#loadd').html(res);
           
          });
    
        }
              
        </script>