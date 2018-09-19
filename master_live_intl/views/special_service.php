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
