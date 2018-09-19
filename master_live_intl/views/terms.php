<link href="<?php echo base_url('css/jquery-ui.css'); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url('js/jquery-ui.js'); ?>"></script>
<script>
    $(document).ready(function ()
    {
        $("#term_type").change(function ()
        {
            var term_type = $("#term_type").val();

            if (term_type == "temporary")
            {
                $("#fromdate").show();
                $("#todate").show();
            }
            else
            {
                $("#fromdate").hide();
                $("#todate").hide();
            }
        });
    });
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
        $("#to_date").datepicker(
                {
                    buttonText: 'Select To Date',
                    buttoncursor: 'pointer',
                    autoSize: true,
                    numberOfMonths: 1,
                    minDate: '0',
                    dateFormat: 'yy-mm-dd'
                });
    });

    function validate()
    {
        var opid = $('#operator').val();
        var term_type = $('#term_type').val();        
        var service_num = $('#service_num').val();
        var from_date = $('#from_date').val();
        var to_date = $("#to_date").val();
        var terms = $('#terms').val();        

        if (opid == "0")
        {
            alert("Please Select Operator");
            $("#operator").focus();
            return false;
        }
        if (term_type == "")
        {
            alert("Please Select Discount Type");
            $("#term_type").focus();
            return false;
        }        
        if (service_num == 0)
        {
            alert("Please Select Service");
            $("#service_num").focus();
            return false;
        }
        if (term_type == "temporary")
        {
            if (from_date == "")
            {
                alert("Please Select From Date");
                $("#from_date").focus();
                return false;
            }
            if (to_date == "")
            {
                alert("Please Select To Date");
                $("#to_date").focus();
                return false;
            }
            if (from_date > to_date)
            {
                alert("From date should not less than to date");
                $("#from_date").focus();
                return false;
            }
        }
        if (terms == "")
        {
            alert("Please Provide terms");
            $("#terms").focus();
            return false;
        }
        if (terms < 0)
        {
            alert("Please Provide terms greater than zero");
            $("#terms").focus();
            return false;
        }        
        else
        {
            var x = "";
            if (service_num == "all")
            {
                x = "All Services";
            }
            else
            {
                x = service_num;
            }
            var r = confirm("Are You Sure You Want To Add terms " + term_type + "ly");
            if (r == true)
            {
                var r1 = confirm("Are You Sure You Want To Add terms For " + x + " " + term_type + "ly");
                if (r1 == true)
                {
                    $.post('terms_add', {opid: opid, term_type: term_type, service_num: service_num, from_date: from_date, to_date: to_date, terms: terms}, function (res)
                    {
                        //alert(res);
                        if (res == 1)
                        {
                            alert("Terms Added Successfully");
                            window.location = "<?php echo base_url('operator/terms'); ?>";
                        }
                        else
                        {
                            alert("Not Updated");
                        }
                    });
                }
            }
        }
    }
	
    function getservice() {
        var opid = $('#operator').val();
		var key = "terms";
        $.post('getservices', {id: opid,key:key}, function (res) {
            //alert(res);

            $('#service_no').html(res);

        });

    }



</script>
<table  border="0" cellpadding="0" cellspacing="0" align="center" width="60%">
    <tr>
        <td height="30" class="space" style="border-bottom:#f2f2f2 solid 1px;">Miscellaneous >> Cancellation Terms</td>
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
                        <!--select name="select" id="select">
<option value="" selected="selected">-- select --</option>

</select--></td>                    
                </tr>
                <tr>
                    <td height="35" align="right" class="size">Term Type </td>
                    <td align="center"><strong>:</strong></td>
                    <td><select name="term_type" id="term_type">
                            <option value="" selected="selected">-- select --</option>
                            <option value="permanent">Permanent</option>
                            <option value="temporary">Temporary</option>
                        </select>                    </td>                    
                </tr>
                <tr>
                    <td width="128" height="35" align="right" class="size">Service No/ Name:</td>
                    <td width="37" align="center"><strong>:</strong></td>
                    <td height="30"><span id="service_no"></span></td>
                    <!--td width="111"><?php
                    /* $js = 'id="service_num"';
                      echo form_dropdown('service_num', $services, '', $js); */
                    ?></td-->                    
                </tr>
                <tr id="fromdate" style="display:none">
                    <td height="35" align="right" class="size">From Date </td>
                    <td align="center"><strong>:</strong></td>
                    <td><input type="text" size='12' name="from_date" id="from_date" class="jdpicker" value='<?php echo(Date("Y-m-d")); ?>' style="cursor:pointer;background-image:url(<?php echo base_url('images/calendar.gif') ?>);background-repeat: no-repeat; background-position:right; vertical-align: middle; width:107px;"  /></td>                    
                </tr>
                <tr id="todate" style="display:none">
                    <td height="35" align="right" class="size">To Date</td>
                    <td align="center"><strong>:</strong></td>
                    <td><input type="text" size='12' name="to_date" id="to_date" class="jdpicker" value='<?php echo(Date("Y-m-d")); ?>' style="cursor:pointer;background-image:url(<?php echo base_url('images/calendar.gif') ?>);background-repeat: no-repeat; background-position:right; vertical-align: middle; width:107px;"  /></td>                    
                </tr>
                <tr>
                    <td height="35" align="right" class="size">Terms</td>
                    <td align="center"><strong>:</strong></td>
                    <td><input type="text" name="terms" id="terms"></td>                    
                </tr>
                <tr>
                  <td height="35" align="right" class="size">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td>Eg : 00#03#100@03#12#50@12#240#10<br />If there is No cancellation,fill NO in the textbox</td>                  
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
<br />
<br />
<table width="804" border="0" cellpadding="0" style="display:none" cellspacing="0" align="center"  id="fa">
    <tr>
        <td  height="30" style="background-color:#999999; color:#FFFFFF"><strong> Ticket Information</strong></td>
    </tr>
    <br />
    <tr >
        <td id="fare">&nbsp;</td>
    </tr>
</table>
