<link href="<?php echo base_url('css/jquery-ui.css'); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url('js/jquery-ui.js'); ?>"></script>
<script>
    $(function ()
    {
        $("#from_date").datepicker(
                {
                    buttonText: 'Select From Date',
                    buttoncursor: 'pointer',
                    autoSize: true,
                    numberOfMonths: 1,
                    minDate: '0',
                    dateFormat: 'yy-mm-dd'
                });
        
    });
	function getservice(){
		 var opid = $('#operator').val();		
		 $.post('getservices_vehi', {id: opid}, function (res)
                {
					$('#service').html(res);
                });
	
	}

    function validate()
    {
        var opid = $('#operator').val();
        var service_num = $('#service_num').val();
        var set = $('#set').val();		
        if (opid == 0)
        {
            alert("Please Select Operator");
            $("#operator").focus();
            return false;
        }
        if (service_num == 0)
        {
            alert("Please Select service number");
            $("#promocode").focus();
            return false;
        }
		if (set == 0)
        {
            alert("Please Select NO");
            $("#from_date").focus();
            return false;
        }        
        else
        { 
		$.post('update_vehicalasign1', {opid: opid, service_num: service_num,set: set}, function (res)
                {
                    //alert(res);
                    if (res == 1)
                    {
                        alert("Status changed Successfully");
                        window.location = "<?php echo base_url('operator/update_vehicalasign'); ?>";
                    }
                    else
                    {
                        alert("Not Changed");
                    }
                });
        }
    }

</script>
<table  border="0" cellpadding="0" cellspacing="0" align="center" width="60%">
    <tr>
        <td height="30" class="space" style="border-bottom:#f2f2f2 solid 1px;">Vehical Asignment Status Change </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td height="35" align="right" class="size">Operator</td>
                    <td align="center"><strong>:</strong></td>
                    <td><?php
                        $js = 'id="operator" onchange="getservice()"';
                        echo form_dropdown('operator', $operators, '', $js);
                        ?>
					</td>                    
                </tr>                
                <tr>
                    <td height="35" align="right" class="size">Services</td>
                    <td align="center"><strong>:</strong></td>
                    <td id="service"></td>                    
                </tr>                
                <tr>
                    <td height="35" align="right" class="size">Set Vehicle Assignment </td>
                    <td align="center"><strong>:</strong></td>
                    <td><select  name="set" id="set">
					<option value="0" >--Select--</option>
					<option value="no" >NO</option>
                    	</select>
                    </td>
                </tr>
                
                <tr>
                    <td height="35" colspan="4" align="center" class="size"><input type="button" name="search" id="search" value="Submit" onClick="validate();" /></td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>

