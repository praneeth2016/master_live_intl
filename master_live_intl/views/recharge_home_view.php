<html>
    <head>
        <title>Top Up</title>
        <link rel="stylesheet" href="<?php echo base_url("css/TableCSSCode.css") ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />
 <script src="<?php echo base_url("js/jquery.min.js"); ?>" type="text/javascript"></script>
  <link href="<?php echo base_url("css/datepicker/jquery-ui.css"); ?>" rel="stylesheet" type="text/css"/>
  <script src="<?php echo base_url("js/datepicker/jquery-ui-1.8.22.custom.min.js"); ?>"></script>
  <script type="text/javascript">
 $(function() {
		/* For zebra striping */
        $("table tr:nth-child(even)").addClass("odd-row");
		/* For cell text alignment */
		$("table td:first-child, table th:first-child").addClass("first");
		/* For removing the last border */
		$("table td:last-child, table th:last-child").addClass("last");
});
</script>
<script>
    function getAgents()
    {
        var agent_title = $("#agtype").val();
        $.post("getagents",{agent_title:agent_title},function(res){
       // alert(res);
        $("#aglist").html(res);             	
        });
    }
    function getAgentVal()
    {
        var agid = $("#agentname").val(); 
        $.post("agentDetails",{agid:agid},function(res){
        //alert(res);
        var res1=res.split("#");
        $('#uname').val(res1[0]);
        $('#comm').val(res1[1]);
        $('#pbal').val(res1[2]);
        $('#paytype').val(res1[3]);
        $('#hdd').val(res1[4]);
        });
    }
    function getAmount()
    {
     
        var paymode = $("#paymode").val();
         var tamt = $("#tamt").val();
        var paytype = $("#paytype").val();
        var comm = $("#comm").val();
       
        var camt1=tamt*(comm/100);
        //var camt=(tamt+camt1);
        var camt = parseFloat(tamt)+parseFloat(camt1);
        if(paytype=='prepaid')
            {
              $('#amtc').show();
              $('#camt').val(camt);
            }
       
    }
    function update()
     {
       
        var agtype = $("#agtype").val();
        var agentid = $("#agentname").val();
        var paymode = $("#paymode").val();
        var uname = $("#uname").val();
        var paytype = $("#paytype").val();
        var comm = $("#comm").val();
        var pbal = $("#pbal").val();
        var tamt = $("#tamt").val();
        var camt=$('#camt').val();
        var remarks = $("#remarks").val();
        var agname= $("#hdd").val();
        var regx= /^[0-9]+\.?[0-9]*$/;
                
        if(agtype=="")
        {
            alert("Please Select Agent Type ");
            $("#agtype").focus();
            return false;
        }
        if(agentname=="")
        {
            alert("Please Select Agent Name");
            $("#agentname").focus();
            return false;
        }
        if(paymode=="")
        {
            alert("Please Select PayMode");
            $("#paymode").focus();
            return false;
        }
        if(tamt=="")
        {
            alert("Please Enter Top Up Amount");
            $("#tamt").focus();
            return false;
        }
        if(!regx.test(tamt))
            {
            alert("Please Enter nnumbers Only");
            $("#tamt").focus();
            return false; 
            }
        
        
        else
        {
        	$.post("update_AgentTopUp",{agtype:agtype,agentid:agentid,agname:agname,paymode:paymode,paytype:paytype,uname:uname,comm:comm,pbal:pbal,tamt:tamt,camt:camt,remarks:remarks},function(res){
        	//alert(res);
        	if(res==1) //success
        	{
                //$('#myTable').table( "refresh" );
        	$('#spn').html("Top Up Successfully Completed");
                setTimeout('window.location = "recharge_type"',2000);
        	else //failure
        	{
        	$('#spn').html("There was Problem in Top Up!");		
        	}	
        	});
        }
        
    }

        </script>

   <style type="text/css">
<!--
.style1 {font-family: Arial, Helvetica, sans-serif; font-weight:normal;font-size: 12px}
-->
   </style>
   </head>
    <body>

	
	
	<table border="0" bgcolor="#E8E8FF" cellspacing="1" cellpadding="1" width="700" style="border:#5a5a5a solid 2px; font-size:10px;">
            <tr>
              <td>
			    <table width="648" border="0" cellpadding="1" cellspacing="1" style="margin-top:0px; margin-left:20px; margin-right:20px; margin-bottom:0px;">
                  <tr>
                    <td style="background-color:#898989; color:#FFFFFF; padding-left:20px;"> Recharge Account </td>
                  </tr>
                  <tr>
                    <td valign="top"><table width="645" border="0" cellpadding="1" cellspacing="1" >
                      
                    </table></td>
                  </tr>
                  <tr>
                    <td height="5" style="border:#5f2c28 solid 1px;"><table width="364"  border="0" align="center" cellpadding="0" cellspacing="0">
                    
                    <tr >
                      <td width="158" height="30" ><span class="style1">Agent Type </span></td>
                      <td width="11" height="30" bgcolor="#E8E8FF"><span class="style1">:</span></td>
                      <td width="195" height="30" bgcolor="#E8E8FF"><span class="style1">
                      <input name="hdd" type="hidden" id="hdd" value="'.$agname.'" >
                        <select name="agtype" id="agtype" style="width:145px" onChange="getAgents()">
                          <option value="">- - - Select - - -</option>
                          <option value="2">Prepaid Agents </option>
                          <option value="3">API Agents</option>
                          </select>
                      </span></td>
                    </tr>
                    <tr>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">Agent Name </span></td>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">:</span></td>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1" id="aglist">
                        <select name="agname" id="agname" style="width:145px">
                          <option value="">- - - Select - - -</option>
                        </select>
                      </span></td>
                    </tr>
                    <tr>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">Pay Mode </span></td>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">:</span></td>
                      <td height="30" bgcolor="#E8E8FF"><span style="font-family: Arial, Helvetica, sans-serif">
                        <select name="paymode" id="paymode" style="width:145px" >
                          <option value="">- - - Select - - -</option>
                          <option value="credit">Credit</option>
                          <option value="debit">Debit</option>
                        </select>
                      </span></td>
                    </tr>
                    <tr>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">Payment Type </span></td>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">:</span></td>
                      <td height="30" bgcolor="#E8E8FF"><input name="paytype" type="text" id="paytype" readonly /></td>
                    </tr>
                    <tr>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">User Name </span></td>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">:</span></td>
                      <td height="30" bgcolor="#E8E8FF"><input name="uname" type="text" id="uname" readonly /></td>
                    </tr>
                    <tr>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">Margin</span></td>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">:</span></td>
                      <td height="30" bgcolor="#E8E8FF"><input name="comm" type="text" id="comm" readonly /></td>
                    </tr>
                    <tr>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">Current Balance </span></td>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">:</span></td>
                      <td height="30" bgcolor="#E8E8FF"><input name="pbal" type="text" id="pbal" readonly /></td>
                    </tr>
                    <tr>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">Top Up Amount </span></td>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">:</span></td>
                      <td height="30" bgcolor="#E8E8FF"><input name="tamt" type="text" id="tamt" onKeyUp="getAmount()"   /></td>
                    </tr>
                    <tr style="display:none;" id="amtc">
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">Amount with Comm</span></td>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">:</span></td>
                      <td height="30" bgcolor="#E8E8FF"><input name="camt" type="text" id="camt"  readonly  /></td>
                    </tr>
                    <tr>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">Remarks</span></td>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">:</span></td>
                      <td height="30" bgcolor="#E8E8FF"><span class="style1">
                        <textarea name="remarks" id="remarks" rows="3" cols="20"></textarea>
                      </span></td>
                    </tr>
                    <tr>
                      <td height="30" colspan="3" align="center" bgcolor="#E8E8FF">
                          <input name="Top Up" type="submit" onClick="update()" value="Top Up" /></td>
                    </tr>
                    <tr>
                      <td colspan="3" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="30" colspan="3" align="center" ><span id="spn"></span></td>
                    </tr>
                  </table></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>                  
                </table>
		      </td>
            </tr>
          </table>
   
		  
    </body>
</html>