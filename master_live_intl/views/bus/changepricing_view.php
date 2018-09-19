<?php error_reporting(0); ?>

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
        $("#fdate").datepicker({dateFormat: 'yy-mm-dd', numberOfMonths: 1, showButtonPanel: false
        });

    });

</script>

<script type="text/javascript">

    function getservices() {

        var opid = $("#operators").val();

        $.post('getservice', {opid: opid}, function (res) {

            $('#svc').html(res);
        });
    }

    $(function () {

        /* For zebra striping */

        $("table tr:nth-child(even)").addClass("odd-row");

        /* For cell text alignment */

        $("table td:first-child, table th:first-child").addClass("first");

        /* For removing the last border */

        $("table td:last-child, table th:last-child").addClass("last");

    });



    function getRoutes() {

        var opid = $("#operators").val();
        $('#ress').html("");

        var svc = $('#svc').val();

        $('#hid').val('');

        if (svc == 0) {

            alert('select service number');

            return false;

        }

        else {

            $.post("getRoutes", {svc: svc, opid: opid}, function (res) {

//alert(res);

                $('#resp').html(res);

            });

        }//else

    }//getRoutes()



    function getFares(srvnum, travid, fid, tid, s) {

        $.post("getFares", {srvnum: srvnum, travid: travid, fid: fid, tid: tid}, function (res) {

//alert(res);

            var cnt = $('#hdd').val();

            for (var k = 1; k <= cnt; k++) {

                $('#cp' + k).hide();

                $('#cpp' + k).empty();

            }

            $('#hid').val('');

            $('#cp' + s).show();

            $('#cpp' + s).html(res);

        });



    }//getFares()

    function checkAll(cls)//values would be like cls0 or cls5 or cls6

    {

        var tmp = cls.replace('cls', '');

        var tmp1 = 0;

        if ($('#call' + tmp).is(':checked'))

        {

            //alert('in if:'+tmp)

            $("#tab ." + cls).attr('checked', true);

            $('#tab .' + cls).each(
                    function ()

                    {

                        tmp1++;//i++;

                    });

            for (var i = 1; i <= tmp1; i++)

            {

                var get = $('#fg' + i + "" + tmp + ' input:checkbox').val();

                if (typeof get != "undefined")

                {

                    clk($('#fg' + i + "" + tmp + ' input:checkbox').val());

                }



            }

            $('#tab .chkcls' + tmp).attr('disabled', false);

            //alert(val);

            $("#hid").val(val);

        }

        else

        {

            //alert('in else'+tmp)

            $("#tab ." + cls).attr('checked', false);

            $('#tab .' + cls).each(
                    function ()

                    {

                        tmp1++;//i++;

                    });

            //alert(tmp1)

            for (var i = 1; i < tmp1; i++)

            {

                var get = $('#fg' + i + "" + tmp + ' input:checkbox').val();

                if (typeof get != "undefined")

                {

                    clk($('#fg' + i + "" + tmp + ' input:checkbox').val());

                }

            }

            $('#tab .chkcls' + tmp).attr('disabled', true);

            //$('#tab .chkcls'+tmp).val('');

            // $('#tab .chkcls'+tmp).attr('disabled',true)

        }

    }



//calls when click on check box

    function clk(jdt)

    {

        var tmp, tmp1;

        var btype = $('#btype').val();

        var val = $("#hid").val();

        if (btype == 'seater') {

            tmp1 = jdt.replace('chk', '');

            if (!$('#' + jdt).is(':checked'))//(val.indexOf("#"+jdt)!= -1)//already clicked

            {

                $('#sp' + tmp1).attr('disabled', true);

                tmp = val.replace("#" + jdt, '');

                val = tmp;

            }

            else //if we click on checkbox

            {

                $('#sp' + tmp1).attr('disabled', false);//enableing the textbox

                val = val + "#" + jdt; //adding to variable all selected checkboxes((#chk2013-08-28#chk2013-08-29))

            }

        }//seater close

        if (btype === 'sleeper') {

            tmp1 = jdt.replace('chk', '');

            if (!$('#' + jdt).is(':checked'))//(val.indexOf("#"+jdt)!= -1)//already clicked

            {

                $('#lb' + tmp1).attr('disabled', true);

                $('#ub' + tmp1).attr('disabled', true);

                tmp = val.replace("#" + jdt, '');

                val = tmp;

            }

            else //if we click on checkbox

            {

                $('#lb' + tmp1).attr('disabled', false);

                $('#ub' + tmp1).attr('disabled', false);
                ;//enableing the textbox

                val = val + "#" + jdt; //adding to variable all selected checkboxes((#chk2013-08-28#chk2013-08-29))

            }

        }//sleeper close

        if (btype === 'seatersleeper') {

            tmp1 = jdt.replace('chk', '');

            if (!$('#' + jdt).is(':checked'))//(val.indexOf("#"+jdt)!= -1)//already clicked

            {

                $('#lb' + tmp1).attr('disabled', true);

                $('#ub' + tmp1).attr('disabled', true);

                $('#sp' + tmp1).attr('disabled', true);

                tmp = val.replace("#" + jdt, '');

                val = tmp;

            }

            else //if we click on checkbox

            {

                $('#lb' + tmp1).attr('disabled', false);

                $('#ub' + tmp1).attr('disabled', false);

                $('#sp' + tmp1).attr('disabled', false);//enableing the textbox

                val = val + "#" + jdt; //adding to variable all selected checkboxes((#chk2013-08-28#chk2013-08-29))

            }

        }

        //alert(val);

        $("#hid").val(val); //storing all selected checkboxes values to hidden box (#chk2013-08-28#chk2013-08-29)

    }

    function showhide()

    {

        var rc = $('#routecount').val();// route count

        var i = 1;

        var val = 0;

        //val= $("input[type='checkbox'].route1:checked").val();

        val = $('#sequence').val();

        //alert("show hide::"+val)

        var rid = val;



        getFare(rid);

        $('#hid').val('');

        $('#dv' + rid).show();

    }//showhide();

    function updateFare()
    {
        var i = $("#hdd").val();
        var fdate = $('#fdate').val();
        var tdate = $('#tdate').val();
        var service = $('#svc').val();
        var travelid = $("#operators").val();
        var btype = $('#btype').val();
        var sfare = "";
        var lbfare = "";
        var fid = "";
        var tid = "";
        var ubfare = "";

        var t = $.datepicker.formatDate('yy-mm-dd', new Date());

        for (var j = 1; j <= i; j++)
        {
            if (sfare == "")
            {
                sfare = $("#sfare" + j).val();
            }
            else
            {
                sfare = sfare + "/" + $("#sfare" + j).val();
            }
            if (lbfare == "")
            {
                lbfare = $("#lbfare" + j).val();
            }
            else
            {
                lbfare = lbfare + "/" + $("#lbfare" + j).val();
            }
            if (ubfare == "")
            {
                ubfare = $("#ubfare" + j).val();
            }
            else
            {
                ubfare = ubfare + "/" + $("#ubfare" + j).val();

            }
            if (fid == "")
            {
                fid = $("#fid" + j).val();
            }
            else
            {
                fid = fid + "/" + $("#fid" + j).val();
            }
            if (tid == "")
            {
                tid = $("#tid" + j).val();
            }
            else
            {
                tid = tid + "/" + $("#tid" + j).val();
            }
            if (typeof sfare == "undefined")
            {
                sfare = "";
            }
            if (typeof lbfare == "undefined")
            {
                lbfare = "";
            }
            if (typeof ubfare == "undefined")
            {
                ubfare = "";
            }
            //alert(sfare);
            // alert(tid+"##"+fid); 
        }
        if (fdate < t || tdate < t)
        {
            alert("Date shoud not less than today date");
        }
        else if (tdate < fdate)
        {
            alert("To date shoud not less than From date");
        }
        else
        {
            var con = confirm("Are You Sure You Want To Update Fares");
            if (con == true)
            {
                $("#up").val("Please Wait..");
                $("#up").attr("disabled", true);
                //alert(fdate);alert(tdate);alert(service);alert(btype);alert(fid);alert(tid);alert(travelid);alert(lbfare);alert(ubfare);alert(sfare);
                $.post("updatePrice", {fdate: fdate, tdate: tdate, serno: service, btype: btype, fid: fid, tid: tid, travelid: travelid, lbfare: lbfare, ubfare: ubfare, sfare: sfare}, function (res)
                {
                    //alert(res);
                    if (res == 0)
                    {
                        $('#ress').html("<span style='color:red;margin:200px'>Not updated</span>");

                    }
                    else
                    {
                        $('#ress').html("<span style='color:red;margin:200px'> updated</span>");
                    }
                    $("#up").val("Update");
                    $("#up").attr("disabled", false);
                });
            }

        }
    }

    function updatePrice(svc, travid, fid, tid, btype)

    {

        var val = $("#hid").val();// alert(val);

        var dates = val.split('#');

        var i = 1, tmp1, tmp2;

        var fares = "", lbf = '', ubf = '';

        var btype, tmp, date = '';

        var tmpf;

        //var ft=$("input[type='radio'].route:checked").val();

        var ft = $('#fromto').val()

        var id = $("#sequence").val();

        //alert(ft+"---"+id)

        //alert(dates.length)

        if (dates.length === 1)

        {

            alert('You haven\'t made any Updations..')

            $('#stat').text(' No Updation made.. ')

            $('#sequence').val('');

            return false;

        }

        var rid, xyz;

        //alert(val+"  length:"+dates.length);

        if (btype === 'seater')

        {

            for (; i <= (dates.length) - 1; i++)

            {

                tmp = dates[i].replace('chk', '');

                date = date + "#" + tmp;

                tmpf = $('#sp' + tmp).val();

                if (tmpf === '')

                {

                    alert('Please enter fare at ' + tmp);

                    $('#sp' + tmp).focus();

                    return false;

                }

                fares = fares + "#" + tmpf;

            }

            //alert(fares);

            $.post("updatePrice", {svc: svc, travid: travid, fid: fid, tid: tid, btype: btype, dates: date, fares: fares}, function (res)

            {

                // alert(res);

                //alert(date);

                if (res == 1) {

                    $('#stat').html("Prices Modified Successfully!!");

                    $('#call0').attr('checked', false);

                    $('#call5').attr('checked', false);

                    $('#call6').attr('checked', false);

                    for (var k = 1; k < (dates.length); k++) {

                        $('#' + dates[k]).attr('checked', false);

                        clk(dates[k]);

                    }





                    $('#sequence').val('');

                }

                else {

                    $('#stat').html("Problem occured in change Pricing!!");

                }

            });

        }

        else if (btype == 'sleeper')

        {

            for (; i <= (dates.length) - 1; i++)

            {

                tmp = dates[i].replace('chk', '');

                date = date + "#" + tmp;

                tmp1 = $('#lb' + tmp).val();

                tmp2 = $('#ub' + tmp).val();

                if (tmp1 == '')

                {
                    alert('Please enter Lower berth fare at ' + tmp);

                    $('#lb' + tmp).focus();

                    return false;

                }

                lbf = lbf + "#" + tmp1;

                if (tmp2 == '')

                {
                    alert('Please enter Upper berth fare at ' + tmp);

                    $('#ub' + tmp).focus();

                    return false;

                }

                ubf = ubf + "#" + tmp2;

            }



            //alert(lbf+"--"+ubf+"---date"+date);

            $.post("updatePrice", {svc: svc, travid: travid, fid: fid, tid: tid, btype: btype, dates: date, lbf: lbf, ubf: ubf},
            function (res)

            {

                // alert(res);

                //alert(date);

                if (res == 1) {

                    $('#stat').html("Prices Modified Successfully!!");

                    $('#call0').attr('checked', false);

                    $('#call5').attr('checked', false);

                    $('#call6').attr('checked', false);

                    for (var k = 1; k < (dates.length); k++) {

                        $('#' + dates[k]).attr('checked', false);

                        clk(dates[k]);

                    }

                    $('#sequence').val('');

                }

                else {

                    $('#stat').html("Problem occured in change Pricing!!");

                }



            });

        }//sleeper

        else//seatersleeper

        {

            for (; i <= (dates.length) - 1; i++)

            {

                tmp = dates[i].replace('chk', '');

                date = date + "#" + tmp;

                tmpf = $('#sp' + tmp).val();

                if (tmpf === '')

                {

                    alert('Please enter fare at ' + tmp);

                    $('#sp' + tmp).focus();

                    return false;

                }

                fares = fares + "#" + tmpf;

                tmp1 = $('#lb' + tmp).val();

                tmp2 = $('#ub' + tmp).val();

                if (tmp1 === '')

                {
                    alert('Please enter Lower berth fare at ' + tmp);

                    $('#lb' + tmp).focus();

                    return false;

                }

                lbf = lbf + "#" + tmp1;

                if (tmp2 === '')

                {
                    alert('Please enter Upper berth fare at ' + tmp);

                    $('#ub' + tmp).focus();

                    return false;

                }

                ubf = ubf + "#" + tmp2;

            }



            //alert(lbf+"--"+ubf+"---date"+date);

            $.post("updatePrice", {svc: svc, travid: travid, fid: fid, tid: tid, btype: btype, dates: date, fares: fares, lbf: lbf, ubf: ubf},
            function (res)

            {

                // alert(res);

                //alert(date);

                if (res == 1) {

                    $('#stat').html("Prices Modified Successfully!!");

                    $('#call0').attr('checked', false);

                    $('#call5').attr('checked', false);

                    $('#call6').attr('checked', false);

                    for (var k = 1; k < (dates.length); k++) {

                        $('#' + dates[k]).attr('checked', false);

                        clk(dates[k]);

                    }

                    $('#sequence').val('');

                }

                else {

                    $('#stat').html("Problem occured in change Pricing!!");

                }



            });

        }

    }

</script>
<table width="73%" border="0" cellspacing="1" cellpadding="1" style="margin-top:15px; font-size:14px">
    <tr>   
        <td height="40" colspan="5" style="padding-left:10px; border-bottom:#999999 solid 1px"><strong>Change Pricing</strong> </td>
    </tr>
    <tr>
        <td height="30" colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="center">Select Operator : </td>
        <td height="30" align="center"><?php
            $op_id = 'id="operators" style="width:150px; font-size:12px" onchange="getservices();"';
            echo form_dropdown('operators', $operators, "", $op_id);
            ?></td>
        <td height="30" align="center">&nbsp;</td>
        <td height="30">&nbsp;</td>
    </tr>
    <tr>
        <td width="9%" height="30">&nbsp;</td>
        <td width="20%" height="30" align="center"><span class="label">Service Name:</span></td>
        <td width="21%" height="30" align="center"><select name="svc" id="svc" class="inputfield" style="width:150px;">
                <option value="0">---Select---</option>
            </select></td>
        <td width="24%" height="30" align="center"><input  type="button" class="newsearchbtn" name="btn" id='btn' value="Submit" onclick="getRoutes()" /></td>
        <td width="26%" height="30"><input type="hidden" name="hid" id='hid' value=''/>
            <input type='hidden' name='fromto' id='fromto' val=''/>
            <input type='hidden' name='sequence' id='sequence' val=''/></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="4" id="resp">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="4" id="ress">&nbsp;</td>
    </tr>
</table>
