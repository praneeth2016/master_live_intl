<style type="text/css">
    .space
    {
        padding-left:10px;
        font-size:14px;
    }	
</style>
<script type="text/javascript">
    function validate()
    {
        var city_id = $("#city_id").val();
        var city_name = $("#city_id option:selected").text();
        var board_drop = $("#board_drop").val();
        var board_drop_type = $("#board_drop_type").val();

        if (city_id == 0)
        {
            alert("Please Select City");
            $("#city_id").focus();
            return false;
        }
        if (board_drop == "")
        {
            alert("Please Select Point Name");
            $("#board_drop").focus();
            return false;
        }
        if (board_drop_type == 0)
        {
            alert("Please Select Point Type");
            $("#board_drop_type").focus();
            return false;
        }
        else
        {
            $.post("<?php echo base_url('index.php/operator/board_drop_db'); ?>",
                    {
                        city_id: city_id,
                        city_name: city_name,
                        board_drop: board_drop,
                        board_drop_type: board_drop_type
                    }, function (res)
            {
                //alert(res);
                if (res == 1)
                {
                    alert("Inserted Successfully");
                    window.location = "<?php echo base_url('/operator/board_drop'); ?>";
                }
                else if (res == 2)
                {
                    alert("Already Exist");
                }
                else
                {
                    alert("Not Inserted");
                }
            });
        }
    }
</script>
<table width="70%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td height="30">&nbsp;</td>
        <td height="30" colspan="3" class="space" align="center">Add Operator Boarding and Dropping Points </td>
        <td height="30">&nbsp;</td>
    </tr>
    <tr>
        <td height="30">&nbsp;</td>
        <td height="30" class="space">&nbsp;</td>
        <td height="30" align="center">&nbsp;</td>
        <td height="30">&nbsp;</td>
        <td height="30">&nbsp;</td>
    </tr>
    <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="left" class="space">City </td>
        <td height="30" align="center"><strong>:</strong></td>
        <td height="30">
            <?php
            $js = 'id="city_id" style="width:135px"';
            echo form_dropdown('city_id', $cities, '', $js);
            ?>	</td>
        <td height="30">&nbsp;</td>
    </tr>
    <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="left" class="space"> Point Name </td>
        <td height="30" align="center"><strong>:</strong></td>
        <td height="30"><input type="text" name="board_drop" id="board_drop"></td>
        <td height="30">&nbsp;</td>
    </tr>
    <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="left" class="space">Point Type </td>
        <td height="30" align="center"><strong>:</strong></td>
        <td height="30">
            <select name="board_drop_type" id="board_drop_type">
                <option value="0">select</option>
                <option value="board">board</option>
                <option value="drop">drop</option>
            </select>    </td>
        <td height="30">&nbsp;</td>
    </tr>
    <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="left" class="space">&nbsp;</td>
        <td height="30" align="center">&nbsp;</td>
        <td height="30"><input type="button" name="Submit" value="Add Point" onclick="return validate();" style="padding:5px 15px;" /></td>
        <td height="30">&nbsp;</td>
    </tr>
</table>
