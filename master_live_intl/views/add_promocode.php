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
        var promocode = $('#promocode').val();
        var promovalue = $('#promovalue').val();
        var promovalue_type = $('#promovalue_type').val();
        var from_date = $('#from_date').val();
        var to_date = $("#to_date").val();

        if (opid == "0")
        {
            alert("Please Select Operator");
            $("#operator").focus();
            return false;
        }
        if (promocode == "")
        {
            alert("Please Select promocode");
            $("#promocode").focus();
            return false;
        }
        if (promovalue == 0)
        {
            alert("Please Select promovalue");
            $("#promovalue").focus();
            return false;
        }
        if (promovalue_type == 0)
        {
            alert("Please Select promovalue type");
            $("#promovalue_type").focus();
            return false;
        }
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
        else
        {
            var r = confirm('Are You Sure You Want To Add Promo code');
            if (r == true)
            {
                $.post('promocodes_add', {opid: opid, promocode: promocode, promovalue: promovalue, from_date: from_date, to_date: to_date, promovalue_type: promovalue_type}, function (res)
                {
                    //alert(res);
                    if (res == 1)
                    {
                        alert("promo code Added Successfully");
                        window.location = "<?php echo base_url('operator/promocode'); ?>";
                    }
                    else
                    {
                        alert("Not Added");
                    }
                });
            }
        }
    }

</script>
<table  border="0" cellpadding="0" cellspacing="0" align="center" width="60%">
    <tr>
        <td height="30" class="space" style="border-bottom:#f2f2f2 solid 1px;">Add Promo Codes </td>
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
                    <td height="35" align="right" class="size">Promo Code</td>
                    <td align="center"><strong>:</strong></td>
                    <td><input type="text" name="promocode" id="promocode" /></td>                    
                </tr>
                <tr>
                    <td height="35" align="right" class="size">Value</td>
                    <td align="center"><strong>:</strong></td>
                    <td><input type="text" name="promovalue" id="promovalue" /></td>                    
                </tr>
                <tr>
                    <td height="35" align="right" class="size">Value Type</td>
                    <td align="center"><strong>:</strong></td>
                    <td><select name="promovalue_type" id="promovalue_type">
                            <option value="0">-- select --</option>
                            <option value="percent">Percent</option>
                            <option value="rupee" >Rupee</option>
                        </select>
                    </td>                    
                </tr>
                <tr>
                    <td height="35" align="right" class="size">From date</td>
                    <td align="center"><strong>:</strong></td>
                    <td><input type="text" size='12' name="from_date" id="from_date" class="jdpicker" value='<?php echo(Date("Y-m-d")); ?>' style="cursor:pointer;background-image:url(<?php echo base_url('images/calendar.gif') ?>);background-repeat: no-repeat; background-position:right; vertical-align: middle; width:107px;"  /></td>                    
                </tr>
                <tr>
                    <td height="35" align="right" class="size">To date</td>
                    <td align="center"><strong>:</strong></td>
                    <td><input type="text" size='12' name="to_date" id="to_date" class="jdpicker" value='<?php echo(Date("Y-m-d")); ?>' style="cursor:pointer;background-image:url(<?php echo base_url('images/calendar.gif') ?>);background-repeat: no-repeat; background-position:right; vertical-align: middle; width:107px;"  /></td>                    
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

