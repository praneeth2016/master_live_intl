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
            
            function getservice()
            { 
                var opid = $('#opid').val();
				$.post('getservices', {id: opid}, function (res) {
                    //alert(res);
						
                        $('#agname').html(res);
                    
                });
            }
			
			function report()
            { 
                var opid = $('#opid').val();
				var service_num = $('#service_num').val();
				$.post('getbplist', {id: opid,service_num:service_num}, function (res) {
                    //alert(res);
						
                        $('#bplist').html(res);
                    
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
              <td height="30" colspan="4" align="center"><span class="style1">Update Boarding Points </span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
                <td height="30"> Operator Name:</td>
                <td height="30">
                    <?php
                    $id1 = 'id="opid" onchange="getservice()"';
                    echo form_dropdown('opid', $operators, '', $id1);
                    ?>                </td>
                <td height="30">&nbsp;</td>
            </tr>
              
            
            <tr>
              <td>&nbsp;</td>
			  <td height="30"><span id="uq">Services</span>
              <td height="30"><span id="agname"></span></td>
              <td height="30">&nbsp;</td>
            </tr>
           
              <td>&nbsp;</td>
              <td height="30">&nbsp;</td>
              <td height="30"><input type="button" name="submit" id="submit" value="submit" onclick='report();' /></td>
              <td height="30">&nbsp;</td>
            </tr>
        </table>
        <br />
		<span id="bplist"></span>
    </body>
</html>