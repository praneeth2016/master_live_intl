<link href="<?php echo base_url('css/jquery-ui.css'); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url('js/jquery-ui.js'); ?>"></script>
<script>
    $(document).ready(function ()
    {
        $("#discount_type").change(function ()
        {
            var discount_type = $("#discount_type").val();

            if (discount_type == "temporary")
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
        var discount_type = $('#discount_type').val();
        var discount_for = $('#discount_for').val();
        var service_num = $('#service_num').val();
        var from_date = $('#from_date').val();
        var to_date = $("#to_date").val();
        var discount = $('#discount').val();
        var dtype = $("#dtype").val();
        var RE = /^-{0,1}\d*\.{0,1}\d+$/;

        if (opid == "0")
        {
            alert("Please Select Operator");
            $("#operator").focus();
            return false;
        }
        if (discount_type == "")
        {
            alert("Please Select Discount Type");
            $("#discount_type").focus();
            return false;
        }
        if (discount_for == 0)
        {
            alert("Please Select Discount for");
            $('#discount_for').focus();
            return false;
        }
        if (service_num == 0)
        {
            alert("Please Select Service");
            $("#service_num").focus();
            return false;
        }
        if (discount_type == "temporary")
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
        if (discount == "")
        {
            alert("Please Provide Discount");
            $("#discount").focus();
            return false;
        }
        if (discount < 0)
        {
            alert("Please Provide Discount greater than zero");
            $("#discount").focus();
            return false;
        }
        if (!RE.test(discount))
        {
            alert("Please Provide Discount as Integer ");
            $("#discount").focus();
            return false;
        }
        if (dtype == "")
        {
            alert("Please Select Amount Type");
            $("#dtype").focus();
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
            var r = confirm("Are You Sure You Want To Give Discount " + discount_type + "ly");
            if (r == true)
            {
                var r1 = confirm("Are You Sure You Want To Give Discount For " + x + " " + discount_type + "ly");
                if (r1 == true)
                {
                    var r2 = confirm("Are You Sure You Want To Give Discount For " + discount_for + "");
                    if (r2 == true)
                    {
                        $.post('discount_con', {opid: opid, discount_type: discount_type, discount_for: discount_for, service_num: service_num, from_date: from_date, to_date: to_date, discount: discount, dtype: dtype}, function (res)
                        {
                            //alert(res);
                            if (res == 1)
                            {
                                alert("Discount Added Successfully");
                                window.location = "<?php echo base_url('operator/discount'); ?>";
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
    }
    function getservice() {
        var opid = $('#operator').val();
		var key = "discount";
        $.post('getservices', {id: opid,key:key}, function (res) {
            //alert(res);

            $('#service_no').html(res);

        });

    }



</script>
<table  border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
        <td height="30" class="space" style="border-bottom:#f2f2f2 solid 1px;">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><table width="538" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td height="35" align="right" class="size">Operator</td>
                    <td align="center"><strong>:</strong></td>
                    <td width="206"><?php
                        $js = 'id="operator" onchange="getservice()"';
                        echo form_dropdown('operator', $operators, '', $js);
                        ?>
                        <!--select name="select" id="select">
<option value="" selected="selected">-- select --</option>

</select--></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td height="35" align="right" class="size">Discount Type </td>
                    <td align="center"><strong>:</strong></td>
                    <td><select name="discount_type" id="discount_type">
                            <option value="" selected="selected">-- select --</option>
                            <option value="permanent">Permanent</option>
                            <option value="temporary">Temporary</option>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td height="35" align="right" class="size">Discount For </td>
                    <td align="center"><strong>:</strong></td>
                    <td><select name="discount_for" id="discount_for">
                            <option value="0">--Select--</option>
                            <option value="all">All</option>
                            <option value="web">Web</option>
                            <option value="api">Api</option>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="128" height="35" align="right" class="size">Service No/ Name:</td>
                    <td width="37" align="center"><strong>:</strong></td>
                    <td height="30"><span id="service_no"></span></td>
                    <!--td width="111"><?php
                    /* $js = 'id="service_num"';
                      echo form_dropdown('service_num', $services, '', $js); */
                    ?></td-->
                    <td width="102">&nbsp;</td>
                </tr>
                <tr id="fromdate" style="display:none">
                    <td height="35" align="right" class="size">From Date </td>
                    <td align="center"><strong>:</strong></td>
                    <td><input type="text" size='12' name="from_date" id="from_date" class="jdpicker" value='<?php echo(Date("Y-m-d")); ?>' style="cursor:pointer;background-image:url(<?php echo base_url('images/calendar.gif') ?>);background-repeat: no-repeat; background-position:right; vertical-align: middle; width:107px;"  /></td>
                    <td></td>
                </tr>
                <tr id="todate" style="display:none">
                    <td height="35" align="right" class="size">To Date</td>
                    <td align="center"><strong>:</strong></td>
                    <td><input type="text" size='12' name="to_date" id="to_date" class="jdpicker" value='<?php echo(Date("Y-m-d")); ?>' style="cursor:pointer;background-image:url(<?php echo base_url('images/calendar.gif') ?>);background-repeat: no-repeat; background-position:right; vertical-align: middle; width:107px;"  /></td>
                    <td></td>
                </tr>
                <tr>
                    <td height="35" align="right" class="size">Discount</td>
                    <td align="center"><strong>:</strong></td>
                    <td><input type="text" name="discount" id="discount"></td>
                    <td><select name="dtype" id="dtype">
                            <option value="" selected="selected">-- select --</option>
                            <option value="percent">Percentage</option>
                            <option value="rupee">Rupees</option>
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
