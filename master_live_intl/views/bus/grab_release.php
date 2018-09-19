<link rel="stylesheet" href="<?php echo base_url("css/table_ebs.css") ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url("css/table_ebs.css") ?>" type="text/css" />

<link href="<?php echo base_url('css/jquery-ui.css'); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url('js/jquery-1.10.2.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery-ui.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/onlinescript.js'); ?>"></script>
<script type="text/javascript">
    $(function ()
    {
        $("#txtdate").datepicker({dateFormat: 'yy-mm-dd', numberOfMonths: 1, showButtonPanel: false, minDate: 0
        });
    });
</script>


<script>
    function getservices() {

        var opid = $("#operators").val();
        //alert(opid);

        $.post('getservice', {opid: opid}, function (res) {

            $('#service').html(res);
        });
    }
    function validate() {

        var opid = $("#operators").val();
        var txtdate = $('#txtdate').val();
        var service = $('#service').val();



        if (service == 0)
        {
            alert("Please Provide Service Number");
            $("#service").focus();
            return false;
        }
        else if (txtdate == '')
        {
            alert('Kindly Select the Date!');
            return false;
        }
        else
        {
            $("#subb").attr('disabled', true);
            $("#subb").val("Please Wait...");
            $.post("GetServiceList", {txtdate: txtdate, serno: service, opid: opid}, function (res) {
                //alert(res);
                if (res == 0)
                {
                    $('#content').html("<span style='color:red;margin:200px'>No data available on selected service</span>");
                    $("#subb").attr('disabled', false);
                    $("#subb").val("submit");
                }
                else
                {
                    $("#subb").attr('disabled', false);
                    $("#subb").val("submit");
                    $('#content').html(res);
                }
            });
        }


    }

    function showLayout(sernum, travel_id, s, date)
    {

        
        var cnt = $('#hf').val();
        $("#uq" + s).attr('disabled', true);
        $("#uq" + s).val("Please Wait...");
        $.post("GrabReleaseLayout", {sernum: sernum, travel_id: travel_id, s: s, txtdate: date}, function (res) {
            //alert(res);
            $("#uq" + s).attr('disabled', false);
            $("#uq" + s).val("Grab and Release");
            $('#trr' + s).html(res);
            $('#uqi' + s).hide();
            $('#uqii' + s).show();
            for (var i = 1; i <= cnt; i++)
            {
                $('#trr' + i).hide();
            }
            $('#trr' + s).show();
        });

    }
    function agentType(s, h)
    {
        if (h == 1) {
            var id = $('#atype' + s).val();
        }
        else if (h == 2) {
            var id = $('#res_atype' + s).val();
        }
		var opid = $('#operators').val();
        //alert(opid);

        $.post("SelectAgentType", {id: id, s: s,opid:opid}, function (res) {
            if (id == 1)
            {
                if (h == 1) {
                    $('#uqi' + s).show();
                    $('#uqa' + s).hide();
                    $('#uqii' + s).html(res);
                    $('#uqii' + s).show();
                }
                else if (h == 2) {
                    $('#rsuqi' + s).show();
                    $('#rsuqa' + s).hide();
                    $('#rsuqii' + s).html(res);
                    $('#rsuqii' + s).show();
                }
            }
            else if (id == 2)
            {

                if (h == 1) {
                    $('#uqi' + s).show();
                    $('#uqa' + s).hide();
                    $('#uqii' + s).html(res);
                    $('#uqii' + s).show();
                }
                else if (h == 2) {
                    $('#rsuqi' + s).show();
                    $('#rsuqa' + s).hide();
                    $('#rsuqii' + s).html(res);
                    $('#rsuqii' + s).show();
                }
            }
            else if (id == 0) {
                $('#uqa' + s).hide();
                $('#uqi' + s).hide();
                $('#uqii' + s).hide();
                $('#rsuqa' + s).hide();
                $('#rsuqi' + s).hide();
                $('#rsuqii' + s).html("selected seats will be release to all");
                $('#rsuqii' + s).show();
            }
            else
            {
                $('#uqa' + s).hide();
                $('#uqi' + s).hide();
                $('#uqii' + s).hide();
                $('#rsuqa' + s).hide();
                $('#rsuqi' + s).hide();
                $('#rsuqii' + s).hide();
            }
        });
    }

    function  chkk(seatname, s, idd) {
        //$('#chkd'+s).show(); 
        if ($('#unchkd' + s).is(':visible')) {
            alert('Giving new quota and removing the quota cannot be performed at a time!');
            $("#" + idd).attr('checked', false);
            return false;
        } else {

            if ($('#chkd' + s).is(':visible')) {
                $("#chkd" + s).show();
            } else {
                $("#chkd" + s).show();
            }
            var gg2 = '';
            var gg = $("#gb" + s).html();

            // if check box is checked 
            if ($("#" + idd).is(":checked")) {
                if (gg == '' || gg == '&nbsp;')
                    gg2 = seatname;
                else
                    gg2 = gg + "," + seatname;
                $("#gb" + s).html(gg2);

            } else {//check box not chcked
                //alert("dfsf");
                var test = "," + seatname;
                if (gg.indexOf(test) != "-1")
                    test = "," + seatname;
                else
                    test = seatname;

                var result = gg.replace(test, '');
                $("#gb" + s).html(result);


            }
            var ggg = $("#gb" + s).html();
            if (ggg == '' || ggg == '&nbsp;')
                $("#chkd" + s).hide();
            $("#unchkd" + s).hide();
        }

    }
    function  unchkk(seatname, s, idd) {
        if ($('#chkd' + s).is(':visible')) {
            alert('Giving new quota and removing the quota cannot be performed at a time!');
            $("#" + idd).attr('checked', true);
            return false;
        } else {
            //$('#unchkd'+s).show();

            if ($('#unchkd' + s).is(':visible')) {
                $("#unchkd" + s).show();
            } else {
                $("#unchkd" + s).show();
            }
            var gg2 = '';
            var gg = $("#rl" + s).html();

            // if check box is checked 
            if ($("#" + idd).is(":checked")) {
                var test = "," + seatname;
                if (gg.indexOf(test) != "-1")
                    test = "," + seatname;
                else
                    test = seatname;

                var result = gg.replace(test, '');
                $("#rl" + s).html(result);

            } else {//check box nt chcked
                if (gg == '' || gg == '&nbsp;')
                    gg2 = seatname;

                else
                    gg2 = gg + "," + seatname;
                $("#rl" + s).html(gg2);

            }
            var ggg = $("#rl" + s).html();
            if (ggg == '' || ggg == '&nbsp;')
                $("#unchkd" + s).hide();
            $("#chkd" + s).hide();

        }//else
    }

    function quotaUpdate(sernum, travel_id, s, c)
    {
        var seats = '';
        var txtdate = $('#txtdate').val();
        //var td2=txtdate2.split("/");
        //var txtdate=td2[2]+"-"+td2[1]+"-"+td2[0];
        if (c == 1)//grab
            seats = $("#gb" + s).html();
        else if (c == 2)//release
            seats = $("#rl" + s).html();
        if (c == 1) {
            var agent_type = $('#atype' + s).val();
        }
        else if (c == 2) {
            var agent_type = $('#res_atype' + s).val();
        }
        var agent_id = $('#ag' + s).val();
        var ga = $('#ag' + s).val();
        var status = '';


        if (c == 1) {
            if ((agent_type == '') && c == 1)
            {
                alert('please select Agent Type!');
                return false;
            }
            if ((agent_id == '' || agent_id == 0) && c == 1)
            {
                alert('Kindly Select Agent Name and update the quota!');
                return false;
            }
            status = "success";
        }
        if (c == 2) {
            if ((agent_type == '') && c == 2)
            {
                alert('please select Agent Type!');
                return false;
            }
            if ((agent_id == '' || agent_id == 0) && c == 2)
            {
                alert('Kindly Select Agent Name and update the quota!');
                return false;
            }
            status = "success";
        }
        if (status = "success")
        {
            var r = confirm("Are sure,you want Update Quota!");
            if (r == true)
            {
                if (c == 1)//grab
                    $('#gbupdt' + s).html('Please wait...');
                else if (c == 2)
                    $('#rlupdt' + s).html('Please wait...');
//alert(arr);
                $.post("SaveGrabRelease", {service_num: sernum, seat_names: seats, travel_id: travel_id, agent_type: agent_type, agent_id: agent_id, date: txtdate, c: c}, function (res) {
//alert(res);
                    if (res == 1)//for grabbing
                    {
                        alert('Seats are Grabbed successfully!');
                        $("#chkd" + s).hide();
                        $("#gb" + s).html('');//making span value as null
                        $('#gbupdt' + s).html('Save Changes');
//viewLayoutQuota(sernum,travel_id,s); 
                        showUpdatedLayout(sernum, travel_id, s, txtdate)
                    }
                    else if (res == 2) { // for release
                        alert('Seats are Released successfully!');
                        $("#unchkd" + s).hide();
                        $("#rl" + s).html('');  //making span value as null 
                        $('#rlupdt' + s).html('Save Changes');
//showLayout(sernum,travel_id,s,txtdate);
//viewLayoutQuota(sernum,travel_id,s);
                        showUpdatedLayout(sernum, travel_id, s, txtdate)
                    }
                    else
                    {
                        alert('There was a problem occured, Kindly contact 040-6613 6613');
                    }
                });
            }
            else
            {
                return false;
            }
        }
    }
    function viewLayoutQuota(sernum, travel_id, s)
    {
        $('#trr' + s).show();
        $('#trr' + s).html('please wait..');
        var cnt = $('#hf').val();
        $.post("DisplayLayoutForQuota", {sernum: sernum, travel_id: travel_id}, function (res) {
            $('#trr' + s).html(res);
            for (var i = 1; i <= cnt; i++)
            {
                $('#trr' + i).hide();
            }
            $('#trr' + s).show();
        });
    }
    function showUpdatedLayout(sernum, travel_id, s, txtdate)
    {

        $('#trr' + s).show();
        $('#trr' + s).html('please wait..');
        var cnt = $('#hf').val();
        $.post("GrabReleaseUpdatedLayout", {service_num: sernum, travel_id: travel_id, journey_date: txtdate}, function (res) {
            //alert(cnt);
            $('#trr' + s).html(res);
            for (var i = 1; i < cnt; i++)
            {
                $('#trr' + i).hide();
            }
            $('#trr' + s).show();
        });
    }

</script>
<table width="73%" border="0" cellspacing="1" cellpadding="1" style="margin-top:15px;">
    <tr>
        <td height="40" colspan="7" style="padding-left:10px; border-bottom:#999999 solid 1px"><strong>Grab and Release</strong> </td>
    </tr>
    <tr>
        <td height="35" colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td height="35">&nbsp;</td>
        <td height="35"><span class="label" style="padding-left:15px">Select Operator :</span></td>
        <td height="35"><?php
            $op_id = 'id="operators" style="width:150px; font-size:12px" onchange="getservices();"';
            echo form_dropdown('operators', $operators, "", $op_id);
            ?></td>
        <td height="35">&nbsp;</td>
    </tr>
    <tr>
        <td width="2%" height="35">&nbsp;</td>
        <td width="40%" height="35"><span class="label">Select Service No/Name:</span></td>
        <td width="56%" height="35"><span class="quick_demos">
                <select name="service" id="service" class="inputfield" style="width:150px;">
                    <option value="0">---Select---</option>
                </select>
            </span></td>
        <td width="2%" height="35">&nbsp;</td>
    </tr>
    <tr>
        <td height="35">&nbsp;</td>
        <td height="35">Select Date To Perform Grab  and Release</td>
        <td height="35"><span class="quick_demos">
                <input type="text" name="txtdate" class="inputfield" id="txtdate"   value='<?php echo(Date("Y-m-d")); ?>'/>
            </span></td>
        <td height="35">&nbsp;</td>
    </tr>
    <tr>
        <td height="35">&nbsp;</td>
        <td height="35">&nbsp;</td>
        <td height="35">
            <input  type="button" class="newsearchbtn" name="subb" id="subb" value="Submit" onclick="validate();" />
            <input type="hidden" name="service_type" id="service_type" value="0" />
            <input type="hidden" name="grab_seats" id="grab_seats" value="">                </td>
        <td height="35">&nbsp;</td>
    </tr>
    <tr>
        <td height="35">&nbsp;</td>
        <td height="35" colspan="2" id="content">&nbsp;</td>
        <td height="35">&nbsp;</td>
    </tr>
</table>
