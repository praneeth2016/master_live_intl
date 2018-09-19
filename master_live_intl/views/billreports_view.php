<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>operator</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/datepicker2/jdpicker.css" type="text/css" />
        <script type ="text/javascript" src="<?php echo base_url(); ?>js/datepicker/jquery-1.7.2.min.js"></script>
        <script type ="text/javascript" src="<?php echo base_url(); ?>js/datepicker2/jquery.jdpicker.js"></script>
        <!--<script  src="<?php echo base_url(); ?>js/jquery-1.8.0.min.js"></script>-->
        <script>
            function Report()
            {
                var opid = $('#opid').val();
                var from = $('#date_from').val();
                var to = $('#date_to').val();
                var agentype = $('#agentype').val();
                var ag_name = $('#agent').val();
                //alert(ag_name);
                var output = $("input[name='output']:checked").val();
                if (output == 'screen')
                {
                    window.open('GetbillReport?from=' + from + '&to=' + to + '&output=' + output + '&opid=' + opid + '&agentype=' + agentype + '&ag_name=' + ag_name);
                }
                else if (output == 'csv')
                {
                    document.location.href = "exportbillreport?output1=" + output + "&date_from=" + from + "&date_to=" + to + '&opid=' + opid + '&agentype=' + agentype;
                }
                else if (output == 'xls')
                {
                    document.location.href = "exportbillreport?output1=" + output + "&date_from=" + from + "&date_to=" + to + '&opid=' + opid + '&agentype=' + agentype;
                }

            }
            function agentType()
            {

                var ag_type = $('#agentype').val();
                var opid = $('#opid').val();
                

                $.post('ShowAgent1', {agenttype: ag_type, id: opid}, function (res) {
                    //alert(res);
                    if (ag_type == 'all' || ag_type == '4' || ag_type == 'tg' || ag_type == 'tr')
                    {
                        $('#uq').hide();
                        $('#agname').html("");
                    }
                    else
                    {
                        $('#uq').show();
                        $('#agname').html(res);
                    }
                });
            }
        </script>
        <style type="text/css">
<!--
.style1 {
	font-size: 14px;
	font-weight: bold;
	color: #000000;
}
-->
        </style>
</head>

    <body>
        <table align="center" width="60%" style="margin: 0px auto;font-family: sans-serif;font-size: 12px">
            <tr>
              <td height="30" colspan="4" align="center"><span class="style1">Billing Reports </span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
                <td height="30"> Operator Name:</td>
                <td height="30">
                    <?php
                    $id1 = 'id="opid"';
                    echo form_dropdown('opid', $operators, '', $id1);
                    ?>                </td>
                <td height="30">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td height="30">From:</td>
              <td height="30"><input type="text" size='12' name="date_from" id="date_from" class="jdpicker" style="background-image:url(<?php echo base_url('images/calendar.gif') ?>); background-repeat:no-repeat;border:#898989 solid 1px; padding-top:1px; padding-bottom:1px; padding-left:25px; background-position:left; background-color:#FFFFFF; height:18px; width:100px;" value='<?php echo(Date("Y/m/d")); ?>' /></td>
              <td height="30">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td height="30">To:</td>
              <td height="30"><input style="background-image:url(<?php echo base_url('images/calendar.gif') ?>); background-repeat:no-repeat;border:#898989 solid 1px; padding-top:1px; padding-bottom:1px; padding-left:25px; background-position:left; background-color:#FFFFFF; height:18px; width:100px;" type="text" size='12' name="date_to" id="date_to" class="jdpicker" value='<?php echo(Date("Y/m/d")); ?>' /></td>
              <td height="30">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td height="30">AgentType:</td>
              <td height="30"><select name="agentype" id="agentype" onchange="agentType()">
                <option value="all">All</option>
                <option value="3">API</option>
                <option value="1">Branch</option>
                <option value="prepaid">Prepaid</option>
                <option value="postpaid">Postpaid</option>
                <option value="4">Website</option>
                <option value="te">Ticket Engine</option>
              </select></td>
              <td height="30">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td height="30"><span style="font-size:12px; font-weight:bold; color:#747474;display:none;" id="uq">Agent</span></td>
              <td height="30"><span id="agname"></span></td>
              <td height="30">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td height="30"><i>Output:</i></td>
              <td height="30"><input type="radio" name="output" value="screen" id="output1" checked="checked" />
              Onscreen
              <!--<input type="radio" name="output" value="csv" id="output2"/>
              As CSV
              <input type="radio" name="output" value="xls" id="output3"/>
              As Excel--></td>
              <td height="30">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td height="30">&nbsp;</td>
              <td height="30"><input type="button" name="submit" id="submit" value="submit" onclick='Report();' /></td>
              <td height="30">&nbsp;</td>
            </tr>
        </table>
        <br />
    </body>
</html>