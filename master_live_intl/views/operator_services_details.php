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
    <h1 align='center' style='font-size:18px'>Operator's Service</h1>
    <script>
    function boarding(t){
       var serviceno=$('#hd'+t).val();
       var cnt=$('#cnt').val();
     //alert($(this).attr("href"));
    $.post('<?php echo site_url("master_control/Service_bording_details");?>',{serviceno:serviceno},function(res1){
     for(var k=1;k<=cnt;k++){
       $('#sh'+k).hide();     
     }
        $('#sh'+t).html(res1); 
        $('#sh'+t).show();     
    }); 
    }
    
  function eminities(t){
        var serviceno1=$('#hd'+t).val();
        var cnt=$('#cnt').val();
   $.post('<?php echo site_url("master_control/Service_eminities_details");?>',{serviceno1:serviceno1},function(res1){
    for(var k=1;k<=cnt;k++){
       $('#sh'+k).hide();     
     }
        $('#sh'+t).html(res1); 
        $('#sh'+t).show();  
    }); 
    }
     function layout(t){
        var serviceno2=$('#hd'+t).val();
         var cnt=$('#cnt').val();
    $.post('<?php echo site_url("master_control/Service_Layout_details");?>',{serviceno2:serviceno2},function(res3){
        for(var k=1;k<=cnt;k++){
       $('#sh'+k).hide();     
     }
        $('#sh'+t).html(res3); 
        $('#sh'+t).show();    
    }); 
    }
        </script>
    
    
    
<script>
function services_OfOperator(){
    var opid=$('#opname').val();
    $.post('Operator_Service_details',{opid:opid},function(res){
     $('#shservices').html(res);   
    });
    
}</script>


<table align="center"><tr><td>
            Select operator Name:<?php 
            $id1='id="opname"';
            echo form_dropdown('opname',$opname,'',$id1);?>
        </td><td><input type="button" value="submit" onclick="services_OfOperator()"></td></tr></table>
<span id="shservices"> </span>
<span id="shbording"> </span>

