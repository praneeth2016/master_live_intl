<?php error_reporting(0); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/datepicker2/jdpicker.css" type="text/css" />
<script type ="text/javascript" src="<?php echo base_url(); ?>js/datepicker/jquery-1.7.2.min.js"></script>
<script type ="text/javascript" src="<?php echo base_url(); ?>js/datepicker2/jquery.jdpicker.js"></script>
<!--<script  src="<?php echo base_url(); ?>js/jquery-1.8.0.min.js"></script>-->
<link rel="stylesheet" href="<?php echo base_url("css/table_ebs.css") ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" /> 
<link href="<?php echo base_url('css/jquery-ui.css'); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url('js/jquery-1.10.2.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery-ui.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/onlinescript.js'); ?>"></script>
<script>

    function getservices(){

        var opid = $("#operators").val();

        $.post('getservice1', {opid: opid}, function (res) {

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
            $.post("GetServiceReport", {service: service,opid:opid}, function (res) {
                // alert(res);
                if (res == 0)
                    $('#tbl').html("<span style='color:red;margin:200px'>No data available on selected service</span>");
                else
                    $('#tbl').html(res);
            });

        }
    }


    function deActivateBus(key, svc, travid, s, stat, fromid, toid)
    {
        var cnt = $('#hdd').val();
        $.post("deActivateBusDatePickers", {key: key, svc: svc, travid: travid, s: s, status: stat, fromid: fromid, toid: toid}, function (res)
        {
//alert(res);
            for (var i = 1; i <= cnt; i++)
            {
                if (i == s)
                    $('#tr' + i).show();
                $('#tr' + i).hide();
            }
            if (key == 'Deactive')
            {
//alert(key);
                $('#tr' + s).show();
                $('#dp' + s).html(res);
                $('#radio' + s).show();
				$('#checkbox' + s).hide();
            }
            else
            {
                $('#tr' + s).show();
                $('#dp' + s).html(res);
                $('#radio' + s).hide();
				$('#checkbox' + s).show();
            }

//datepicker
            var date = new Date();
            var currentMonth = date.getMonth();
            var currentDate = date.getDate();
            var currentYear = date.getFullYear();
            $('#txtdatee' + s).datepicker({
                // minDate: new Date(currentDate, currentMonth, currentYear),
                minDate: new Date(currentYear, currentMonth, currentDate),
                numberOfMonths: 1,
                minDate: '0',
                        //dateFormat:"dd-mm-yy"
                        dateFormat: "dd-mm-yy"});
            $('#txtdateee' + s).datepicker({
                // minDate: new Date(currentDate, currentMonth, currentYear),
                minDate: new Date(currentYear, currentMonth, currentDate),
                numberOfMonths: 1,
                minDate: '0',
                        //dateFormat:"dd-mm-yy"
                        dateFormat: "dd-mm-yy"

            });

        });

    }
    function getFromTo(i, key)
    {
        var date = $('#txtdatee' + i).val();
        var res = $('#txtdateee' + i).val();
        if (date == '')
        {
            $('#spnmsg' + i).html('Kindly select From date!');
        }
        else if (date > res && res != '')
        {
            $('#spnmsg' + i).html('From date should be less than To date!');
        }
        else if (date != '' && res != '')
        {
            $('#spnmsg' + i).html('This Service Will be ' + key + ' from ' + date + ' to ' + res);
        }
    }
    function onChge(i, key)
    {
        getFromTo(i);
    }

//function for update status as inactive
    function updateStatusAsDeAct(key, sernum, travid, status, s, fromid, toid)
    {
//alert(key+"/"+sernum+"/"+travid+"/"+s+"/"+fromid+"/"+toid);
        var cnt = $('#hdd').val();
        var fdate = $('#txtdatee' + s).val();
        var tdate = $('#txtdateee' + s).val();
        if (key == 'Deactive')
        {
            var chkRadio = $('input[name=ser' + s + ']:checked').val();
			var checkbox = '0';
        }
        else
        {
            var chkRadio = '0';
			var checkbox = $('input[name=release' + s + ']:checked').val();
        }
//alert(chkRadio);
        if (fdate == '')
        {
            alert('Please Select From Date !');
            $('#txtdatee' + s).focus();
            return false;
        }
        if (tdate == '')
        {
            alert('Please Select To Date !');
            $('#txtdateee' + s).focus();
            return false;
        }
        if (fdate > tdate)
        {
            alert('From Date should be less than To date!');
            return false;
        }
        if (key == 'Deactive')
        {
            //alert(key);
            if ($('input[name=ser' + s + ']:checked').length <= 0)
            {
                alert("Please select the radio button ");
                return false;
            }
        }
        if ($('#updt' + s).val() == 'Update')
        {
            var cnf = confirm("Are you sure, want to " + key + " the bus !");
            if (cnf)
            {
                $('#updt' + s).val('please wait...');
                $.post("deActivateBus", {key: key, sernum: sernum, travid: travid, fdate: fdate, tdate: tdate, status: status, cnt: cnt, s: s, fromid: fromid, toid: toid, chkRadio: chkRadio, checkbox:checkbox}, function (res) {
                    alert(res);
                    $('#tbl1').html(res);
                    if (res == 1)
                    {
                        $('#updt' + s).val('Update');
                        $('#txtdatee' + s).val('');
                        $('#txtdateee' + s).val('');
                        $('#spnmsg' + s).html('');
                        $('#spnmsg' + s).html('Service ' + key + 'd From ' + fdate + ' to ' + tdate);
                        $.post("mailForBusCancelController", {key: key, sernum: sernum, travid: travid, fdate: fdate, tdate: tdate, status: status, cnt: cnt, s: s, fromid: fromid, toid: toid}, function (response) {
                            //alert(response);
                            if (res == 0) {
//      var cn=confirm('Few seats are already booked for bus cancelled dates !! \n\
//                           \n\
//                   \n\
//                 DO you want to send Mails to customers  ');
//      if(cn){
//           alert('Mails has been sent!');     
//          }

                            }
                        });
                    }
                    else if (res == 2) {
                        $('#updt' + s).val('Update');
                        alert('bus is already deactivated');
                    }
                    else
                    {
                        $('#updt' + s).val('Update');
                        $('#spnmsg' + s).html('There was a problem Occured!');
                    }
                });
            }
        }
        else {
            return false;
        }
    }


</script>
<table width="73%" border="0" cellpadding="0" cellspacing="0">

    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td height="40" colspan="4" style="padding-left:10px; border-bottom:#999999 solid 1px"><strong>Cancel Service</strong> </td>
    </tr>
    <tr>
        <td><table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
                <tr>
                    <td width="348" height="35" align="center" class="label"><span class="label" style="padding-left:15px">Select Operator :</span></td>
                    <td align="center"><?php $op_id = 'id="operators" style="width:150px; font-size:12px" onchange="getservices();"';
echo form_dropdown('operators', $operators, "", $op_id);
?></td>
                    <td width="184" height="35" align="center">&nbsp;</td>
                </tr>
                <tr>
                    <td height="35" align="center" class="label">Service No / Name <strong>:</strong></td>
                    <td width="180" align="center"><select name="service" id="service" class="inputfield" style="width:150px;">
                            <option value="0">---Select---</option>
                        </select></td>
                    <td height="35" align="center"><input  type="button" class="newsearchbtn" name="search" id="search" value="Submit" onClick="getServiceDetails()" /></td>
                </tr>

            </table></td>
    </tr>
    <tr>
        <td id="tbl">&nbsp;</td>
    </tr>
    <tr>
        <td id="tbl1">&nbsp;</td>
    </tr>
</table>
<br />
<br />


