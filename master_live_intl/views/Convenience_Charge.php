<script>
    function validate()
    {
        var opid = $('#operator').val();
        var conv = $('#conv').val();

        var RE = /^-{0,1}\d*\.{0,1}\d+$/;

        if (opid == "0")
        {
            alert("Please Select Operator");
            $("#operator").focus();
            return false;
        }
        else
        {

            var r = confirm("Are You Sure You Want To Give Convenience Charge");
                    if (r == true)
            {
                $.post('conv_give',
                        {opid: opid, conv: conv},
                function (res)
                {
                    //alert(res);
                    if (res == 1)
                    {
                        alert("Convenience Charge Added Successfully");
                        window.location = "<?php echo base_url('operator/convenience_charge'); ?>";
                    }
                    else
                    {
                        alert("Not Updated");
                    }
                });

            }
        }
    }
    function getconv() {
        var opid = $('#operator').val();
        $.post('getconv', {opid: opid}, function (res) {
            // alert(res);

            $('#conv').val(res);

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
                    <td width="165" height="35" align="right" class="size">Operator</td>
                    <td width="79" align="center">:</td>
                    <td width="120"><?php
                        $js = 'id="operator" onchange="getconv()"';
                        echo form_dropdown('operator', $operators, '', $js);
                        ?>
                        <!--select name="select" id="select">
<option value="" selected="selected">-- select --</option>

</select--></td>
                    <td width="174">&nbsp;</td>
                </tr>
                <tr>
                    <td height="35" align="right" class="size"> Convenience Charge </td>
                    <td align="center"><strong>:</strong></td>
                    <td height="30"><input type='text' name='conv' id='conv' value=''/></td>
                    <td> ex : 1.4 </td>
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
