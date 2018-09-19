<link href="<?php echo base_url('css/jquery-ui.css'); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url('js/jquery-ui.js'); ?>"></script>
<script>
    function getservices() {

        var opid = $("#operators").val();
        $.post('getservice', {opid: opid}, function (res) {

            $('#service').html(res);
        });
    }
    function getServiceDetails()
    {
        var opid = $("#operators").val();
        var service = $('#service').val();
        if (service == 0)
        {
            alert("Please Provide Service Number");
            $("#service").focus();
            return false;
        }
        else
        {
            $.post("add_pakag_details", {service: service, opid: opid}, function (res) {
                // alert(res);
                if (res == 0)
                    $('#tbl').html("<span style='color:red;margin:200px'>No data available on selected service</span>");
                else
                    $('#tbl').html(res);
            });
        }
    }
    function add_pkg(srvno, travid) {
        var from_id = $('#from_id').val();
        var to_id = $('#to_id').val();
        var details = $('#details').val();
        if (from_id == 0)
        {
            alert("Select From Name");
            $('#from_id').focus();
            return false;
        }
        if (to_id == 0)
        {
            alert("Select To Name");
            $('#to_id').focus();
            return false;
        }
        if (details == 0)
        {
            alert("Write Details");
            $('#details').focus();
            return false;
        }

        var r = confirm('Are you sure,you want to Modify?');
        if (r == true)
        {
            // alert(seat);
            $.post('add_pakag_details_db', {service_no:srvno, travel_id:travid, from_id:from_id, to_id:to_id, details:details}, function (res) {
                alert(res);
                if (res == 1)
                {
                    alert("successfully saved");                    
                }
                else if(res == 0){
                    alert("not saved");
                } else{
                    alert("Something wrong ");
                }
            });
        }
        else
        {
            return false;
        }
    }
    
</script>
<table width="72%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td height="35" align="center" class="size">Operator</td>
        <td align="center"><strong>:</strong></td>
        <td><?php
            $js = 'id="operators" onchange="getservices()"';
            echo form_dropdown('operators', $operators, '', $js);
            ?></td>
        <td>&nbsp;</td>
        <td><span class="size">Services</span></td>
        <td align="center"><strong>:</strong></td>
        <td><select name="service" id="service" class="inputfield" style="width:150px;">
                <option value="0">---Select---</option>
            </select></td>
        <td>&nbsp;</td>
        <td>
            <input  type="button" class="newsearchbtn" name="search" id="search" value="Submit" onclick="getServiceDetails()" />
        </td>
    </tr>
    <tr>
        <td height="35" colspan="9" align="center" class="size" id="tbl">&nbsp;</td>
    </tr>
</table>
