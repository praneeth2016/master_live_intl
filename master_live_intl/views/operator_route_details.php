<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operator's  Services Detail</title>
<style>
.bg {background-color:#ffffff;
font-family: Arial, Helvetica, sans-serif; font-size:12px;
}
.bg1 {background-color:#eff3f5;
font-family: Arial, Helvetica, sans-serif; font-size:12px;
}
</style>
<script type="text/javascript" src="<?php echo base_url("js/jquery-1.5.2.min.js");?>"></script>

    <link rel="stylesheet" href="<?php echo base_url();?>css/datepicker2/jdpicker.css" type="text/css" />
<script type ="text/javascript" src="<?php echo base_url();?>js/datepicker/jquery-1.7.2.min.js"></script>
<script type ="text/javascript" src="<?php echo base_url();?>js/datepicker2/jquery.jdpicker.js"></script>
    <h1 align='center' style='font-size:18px'>Operator's Service</h1>
   
    
<script>
function routes_OfOperator(){
    var opid=$('#opname').val();
     var fdate=$('#date_from').val();  
     var tdate=$('#date_to').val();
    $.post('operator_Route_details',{opid:opid,fdate:fdate,tdate:tdate},function(res){
     $('#shservices').html(res);   
    });
    
}</script>


<table align="center"><tr><td>
            Select operator Name:<?php 
            $id1='id="opname"';
            echo form_dropdown('opname',$opname,'',$id1);?>
        </td><td >From:</td>
                        <td >
                        <input type="text" size='12' name="date_from" id="date_from" class="jdpicker" value='<?php echo(Date("Y/m/d")); ?>' style="background-image:url(<?php echo base_url('images/calendar.gif')?>); background-repeat:no-repeat;border:#898989 solid 1px; padding-top:1px; padding-bottom:1px; padding-left:25px; background-position:left; background-color:#FFFFFF; height:18px; width:100px;"  /></td>
                        <td >To:</td>
                        <td>
                        <input type="text" size='12' name="date_to" id="date_to" class="jdpicker" value='<?php echo(Date("Y/m/d")); ?>' style="background-image:url(<?php echo base_url('images/calendar.gif')?>); background-repeat:no-repeat;border:#898989 solid 1px; padding-top:1px; padding-bottom:1px; padding-left:25px; background-position:left; background-color:#FFFFFF; height:18px; width:100px;" /></td>
        <td><input type="button" value="submit" onclick="routes_OfOperator()"></td>
    </tr></table>
<span id="shservices"> </span>

