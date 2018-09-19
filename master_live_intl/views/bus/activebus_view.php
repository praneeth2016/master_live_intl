<?php error_reporting(0); ?>     
<link rel="stylesheet" href="<?php echo base_url("css/TableCSSCode.css") ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />
<link href="<?php echo base_url('css/jquery-ui.css'); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url('js/jquery-ui.js'); ?>"></script>
<script type="text/javascript">
    $(function () {
        /* For zebra striping */
        $("table tr:nth-child(even)").addClass("odd-row");
        /* For cell text alignment */
        $("table td:first-child, table th:first-child").addClass("first");
        /* For removing the last border */
        $("table td:last-child, table th:last-child").addClass("last");
    });
</script>

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
        var key = '<?php echo $key; ?>';
        if (service == 0)
        {
            alert("Please Provide Service Number");
            $("#service").focus();
            return false;
        }
        else
        {
            $.post("servicesListActiveOrDeactive", {service: service, key: key, opid:opid}, function (res) {
                // alert(res);
                if (res == 0)
                    $('#tbl').html("<span style='color:red;margin:200px'>No data available on selected service</span>");
                else
                    $('#tbl').html(res);
            });

        }
    }
    function activateBus(svc, travid, s, stat, fromid, toid)
    {
        var cnt = $('#hdd').val();
        var servtype = $('#sertype' + s).val();
        //alert(servtype);
        $.post("getForwordBookingDays", {svc: svc, travid: travid, s: s, status: stat, fromid: fromid, toid: toid, servtype: servtype}, function (res)
        {//alert(res);
            if (res == 0)
            {
                alert('Add Forward booking days to activate the  bus by using Forward Booking Option!');
            }
            else
            {
                for (var i = 1; i <= cnt; i++)
                {
                    if (i == s)
                        $('#tr' + i).show();
                    $('#tr' + i).hide();
                }
                $('#tr' + s).show();
                $('#dp' + s).html(res);

//datepicker
                var date = new Date();
                var currentMonth = date.getMonth();
                var currentDate = date.getDate();
                var currentYear = date.getFullYear();
                $('#txtdate' + s).datepicker({
                    // minDate: new Date(currentDate, currentMonth, currentYear),
                    minDate: new Date(currentYear, currentMonth, currentDate),
                    numberOfMonths: 2,
                    minDate: '0',
                            //dateFormat:"dd-mm-yy"
                            dateFormat: "yy-mm-dd"

                });
                $('#txtdatee' + s).datepicker({
                    // minDate: new Date(currentDate, currentMonth, currentYear),
                    minDate: new Date(currentYear, currentMonth, currentDate),
                    numberOfMonths: 2,
                    minDate: '0',
                            //dateFormat:"dd-mm-yy"
                            dateFormat: "yy-mm-dd"

                });

            }
        });

    }
    function deactivateBus(svc, travid, s, stat, fromid, toid, key)
    {

        var st = key;

        if (key == 'Delete')
        {
            var r = confirm("Are sure,You want Delete The service!!");

        }
        else
        {
            var r = confirm("Are sure,you want DeActive The service!!");

        }
        if (r == true)
        {
            if (key == 'Delete')
            {
                var rq = confirm("Are sure,You want Delete The service!!,Once It deleted,You cann't get Back It's Details!!");
            }
            else
            {
                var rq = confirm("Are sure,Tickets booked in this service will be cancel. !!");
            }
            if (rq == true)
            {
                $('#act' + travid + s).val("Please Wait...");
                $('#act' + travid + s).attr("disabled", true);

                $.post("deActivateBusPermanent", {svc: svc, travid: travid, s: s, status: stat, fromid: fromid, toid: toid, st: key}, function (res)
                {
                    //alert(res);	

                    if (res == 1)
                    {
                        $('#act' + travid + s).val(st);
                        $('#act' + travid + s).attr("disabled", false);
                        if (key == 'Delete')
                        {
                            alert("Service Deleted !!");
                            window.location = '<?php echo base_url("createbus/dispDeleteServicesList"); ?>';
                        }
                        else {
                            alert("Service Deactivated !!");
                            window.location = '<?php echo base_url("createbus/dispServicesList"); ?>';
                        }

                    }
                    else
                    {
                        $('#act' + travid + s).val(st);
                        $('#act' + travid + s).attr("disabled", false);
                        alert('There was a problem Occured!');
                    }
                });
            }
            /*else
             {
             window.location = '<?php echo base_url("createbus/dispServicesList"); ?>';
             }*/
        }
        /*else
         {
         window.location = '<?php echo base_url("createbus/dispServicesList"); ?>';
         }*/

    }//deactivateBus()


    function getTodate(fwdb, i)
    {
        var date = $('#txtdate' + i).val();
        $.post("getActivateDates", {sdate: date, fwd: fwdb}, function (res) {
            $('#fwddate').val(res);
            $('#txt' + i).html('This Service Will be active from ' + date + ' to ' + res);
        });

    }
    function getTodateForSpecialService(fwdb, i)
    {
        var date = $('#txtdate' + i).val();
        var datee = $('#txtdatee' + i).val();
        $('#txt' + i).html('This Service Will be active from ' + date + ' to ' + datee);

    }
//updation
    function updateStatus(sernum, travid, fwd, status, s, fromid, toid)
    {
        var servtype = $('#sertype' + s).val();
        var fdate = $('#txtdate' + s).val();
        if (servtype == "normal" || servtype == "weekly")
            var tdate = $('#fwddate').val();
        else
            var tdate = $('#txtdatee' + s).val();
        //alert(tdate);
        if (fdate == '')
        {
            alert('Please Select Date !');
            return false;
        }
        else if ($('#txtdatee' + s).val() == '')
        {
            alert('Please Select end Date !');
            return false;
        }
        else if ($('#txtdatee' + s).val() < fdate)
        {
            alert('Please Select end Date more than start Date !');
            return false;
        }
        else if ($('#updt' + s).val() == 'Update')
        {
            var r = confirm("Are sure,you want Update The service!!");
            if (r == true)
            {
                $('#updt' + s).val('please wait...');
                $('#updt' + s).attr("disabled", true)
                $.post("activeBusStatus", {sernum: sernum, travid: travid, fwd: fwd, fdate: fdate, tdate: tdate, status: status, s: s, fromid: fromid, toid: toid, servtype: servtype}, function (res) {
                    //alert(res);
                    if (res == 1)
                    {
                        $('#updt' + s).val('Update');
                        $('#updt' + s).attr("disabled", false)
                        //$('#txtdate'+s).val('');
                        $('#txt' + s).html('');
                        $('#spnmsg' + s).html('Service Activated From ' + fdate + ' to ' + tdate);
                    }
                    else
                    {
                        $('#updt' + s).val('Update');
                        $('#updt' + s).attr("disabled", false)
                        $('#spnmsg' + s).html('There was a problem Occured!');
                    }
                });
            }
        }
        else
        {
            window.location = '<?php echo base_url("createbus/dispServicesList"); ?>';
        }
    }

</script>
</head>
<body>
    <table width="73%" border="0" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <?php
                if ($key == 'Delete')
                    $key = "Delete Bus";
                else
                    $key = "Active/Deactive Bus";
                ?>
                <td height="40" colspan="4" style="padding-left:10px; border-bottom:#999999 solid 1px"><strong><?php echo "$key"; ?></strong> </td>
            </tr>

            <tr>
                <td colspan="4" height="30" class="space" style="border-bottom:#f2f2f2 solid 1px;"></td>
            </tr>
            <tr>
                <td  height="29" class="space" style="border-bottom:#f2f2f2 solid 1px;"></td>
                <td height="29" align="center" class="label" style="padding-left:15px">Select Operator : </td>
                <td align="center" ><?php $op_id = 'id="operators" style="width:150px; font-size:12px" onchange="getservices();"';
                echo form_dropdown('operators', $operators, "", $op_id);
                ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td width="31%"  height="27" class="space" style="border-bottom:#f2f2f2 solid 1px;"></td>
                <td width="36%"  height="27" align="center" class="space" style="border-bottom:#f2f2f2 solid 1px;"><span class="label">Service No / Route : </span></td>
                <td width="12%"  height="27" align="center" class="space" style="border-bottom:#f2f2f2 solid 1px;"><select name="service" id="service" class="inputfield" style="width:150px;">
                        <option value="0">---Select---</option>
                    </select></td>
                <td width="21%"  height="27" align="center" class="space" style="border-bottom:#f2f2f2 solid 1px;"><span class="size">
                        <input  type="button" class="newsearchbtn" name="search" id="search" value="Submit" onClick="getServiceDetails()" />
                    </span></td>
            </tr>
            <tr >
                <td  height="2" colspan="4" class="space" id="tbl" style="border-bottom:#f2f2f2 solid 1px;"></td>
            </tr>
        <thead>
        <tbody>
            <?php
            $i = 1;
            //print_r($query);
            foreach ($query as $row) {
                $srvtype2 = $row->serviceType;
                $srvno = $row->service_num;


                if ($srvtype2 == '' || $srvtype2 == 'normal') {
                    $srvtype = "Normal";
                } else {
                    $srvtype = "Special";
                }
                $travid = $row->travel_id;
                if ($row->status == 0 || $row->status == '')
                    $st = '<input  type="button" class="newsearchbtn" name="act' . $travid . $s . '" id="act' . $travid . $i . '" value="InActive" 
              onclick="activateBus(\'' . $srvno . '\',' . $travid . ',' . $i . ',' . $row->status . ',' . $row->from_id . ',
                  ' . $row->to_id . ')">';
                else
                    $st = 'Activated';

                echo '<tr >
    <td height="30" class="space">' . $i . '</td>
    <td height="30" class="space">' . $srvtype . '</td>
        <input type="hidden"  value="' . $srvtype . '" id="sertype' . $i . '" name="sertype' . $i . '">
    <td height="30" class="space">' . $srvno . '</td>
    <td height="30" class="space">' . $row->from_name . '</td>
    <td height="30" class="space">' . $row->to_name . '</td>
    <td height="30" class="space">' . $row->bus_type . '</td>
    <td height="30" class="space">' . $st . ' </td>
    </tr>
    <tr  style="display:none;" >
 <td  colspan="6"  align="center" height="30" class="space" ></td>
  </tr>
  <tr id="tr' . $i . '"  style="display:none;">
 <td  colspan="6" id="dp' . $i . '" align="center" height="30" class="space" ></td>
  </tr>    
';
                $i++;
            }
            echo '<input type="hidden" id="hdd" value="' . $i . '" >';
            ?>
        <tbody>
    </table>
