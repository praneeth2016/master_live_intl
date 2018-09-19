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
	
	 <table style="border:#5f2c28 solid 0px;"  align="center">
                      <tr>
					  
                        <td width="57" height="25">From:</td>
                        <td width="124" height="25">
        <input type="text"  size="20" name="date_from" id="date_from" class="jdpicker" value='<?php echo(Date("Y/m/d")); ?>' style="background-image:url(<?php echo base_url('images/calendar.gif')?>); background-repeat:no-repeat;border:#898989 solid 1px; padding-top:1px; padding-bottom:1px; padding-left:25px; background-position:left; background-color:#FFFFFF; height:18px; width:100px;"  /></td>
                        <td width="28" height="25">To:</td>
                        <td width="124" height="25"><input type="text" size="20" name="date_to" id="date_to" class="jdpicker" value='<?php echo(Date("Y/m/d")); ?>' style="background-image:url(<?php echo base_url('images/calendar.gif')?>); background-repeat:no-repeat;border:#898989 solid 1px; padding-top:1px; padding-bottom:1px; padding-left:25px; background-position:left; background-color:#FFFFFF; height:18px; width:100px;" /></td>
                        <td width="71">Operator:</td>
                        <td width="95">
						<?php 
            $id1='id="opname"';
            echo form_dropdown('opname',$opname,'',$id1);?>                        </td>
                        <td>&nbsp;</td>
                        <td><input name="button2" type="button" onclick="showdata()" value="Submit" /></td>
                      </tr>
                    </table>
        <span id="loadd"></span>
</html>

<script>
showdata();	
function showdata()
{
	var fdate=$('#date_from').val();  
    var tdate=$('#date_to').val();
	var opid=$('#opname').val();
    $.post('apiwise_report',{fdate:fdate,tdate:tdate,opid:opid},function(res)
	{          
    	//alert(res);
		$('#loadd').html(res);           
    });
}

function SelectAll()
{
	//for selecting all checkboxes
    if($('#selectck').is(":checked"))
	{
    	$('.chkbox').attr('checked',true); //checknig all cheeckboxes  
        $('.tbox').attr('disabled',false);
    }
    else
	{
    	$('.chkbox').attr('checked',false);   //unchecking all select boxes 
        $('.tbox').attr('disabled',true); 
    }
}

function submitData()
{
	var fdate=$('#date_from').val();  
    var tdate=$('#date_to').val();
	var opid=$('#opname').val();
	
	var tot='';
    var chk='';
	var name = "";
	var balance = "";    
	
	$(".chkbox").each(function()
	{
    	if (this.checked) 
        {
        	chk=this.value;
		 	//alert(chk);
	     	if(chk=="on")
	       		tot='';
         	else
         	{
           		if(tot=='')
            		tot=chk;
           		else
            		tot=tot+"#"+chk;
         	}
			
			var name1=$('#name'+chk).val();
         	var balance1=$('#balance'+chk).val();
         	
			if(name=='')
           		name=name1;
         	else
           		name=name+"#"+name1; 
				
         	if(balance=='')
           		balance=balance1;
         	else
           		balance=balance+"#"+balance1; 
        }		
    });
	
	//alert(name);
	
	if(chk=='')
    {
    	alert('Please select atleast one checkbox');
    }
	else 
    {    
		//alert("else");         
        $.post('sendsms_apiagent',{fdate:fdate,tdate:tdate,opid:opid,tot:tot,name:name,balance:balance},function(res)
		{
        	//alert(res);
            if(res==1)
			{
            	alert('SMS has been Sent');
                showdata();
            }
            else
			{
            	alert('There was a problem,kindly contact 040-6613 9994');
                return false;
            }
        });    
    }	
}
</script>