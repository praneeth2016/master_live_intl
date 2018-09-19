         <link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />
        <script type="text/javascript">
function checkUser()
{
	var uname=$('#user_name').val();
	$("#un").empty();
	$.post("checkUser",{uname:uname},function(res){
	 if(res==1)
	 {
	    $("#un").html("User Name Already Exist !!");
	 }
	});
}
function validate()
{
	var name=$('#name').val();
    var username=$('#user_name').val();
    var email=$('#email_address').val();
    var str=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-zA-Z]/;
    var pword=$('#password').val();
    var con_pas=$('#con_password').val();
    var con=$('#contact').val();
	var landline=$('#landline').val();
    var add=$('#address').val();   
    var margin  =$('#margin').val();     
    //var payment_type=$('#list').val();
	var payment_type='postpaid';
    var limit=$('#txt').val();
     if(limit=='')
        limit=0
    var margins=/^[-]?[0-9]*\.?[0-9]+$/;
    var contact=/^\d+(,\d+)*$/;
    var lpay=/^[0-9]*\.?[0-9]+$/;
	var locat=$('#locat').val();
    var branch=$('#branch').val();
	var branchAddress=$('#branchAddress').val();
	
	//checkbox values	
	if($('#allowcanc').is(':checked'))           
      var allowcanc='yes';
    else
	  var allowcanc='no';
	  
	if($('#allowmodification').is(':checked'))           
      var allowmodification='yes';
    else
	  var allowmodification='no';
	
	if($('#payment_reports').is(':checked'))           
      var payment_reports='yes';
    else
	  var payment_reports='no';
	  
	if($('#booking_reposts').is(':checked'))           
      var booking_reposts='yes';
    else
	  var booking_reposts='no';
	
	if($('#pass_reports').is(':checked'))           
      var pass_reports='yes';
    else
	  var pass_reports='no';
	  
	if($('#vehicle_ass').is(':checked'))           
      var vehicle_ass='yes';
    else
	  var vehicle_ass='no';
	
	if($('#ticket_booking').is(':checked'))           
      var ticket_booking='yes';
    else
	  var ticket_booking='no';
	
	if($('#checkfare').is(':checked'))           
      var checkfare='yes';
    else
	  var checkfare='no';
	
	if($('#ticket_status').is(':checked'))           
      var ticket_status='yes';
    else
	  var ticket_status='no';
	
	if($('#ticket_canc').is(':checked'))           
      var ticket_canc='yes';
    else
	  var ticket_canc='no';
	  
	if($('#ticket_modify').is(':checked'))           
      var ticket_modify='yes';
    else
	  var ticket_modify='no';
	  
	if($('#boardpass').is(':checked'))           
      var boardpass='yes';
    else
	  var boardpass='no';
	  
	if($('#ticket_reschedule').is(':checked'))           
      var ticket_reschedule='yes';
    else
	  var ticket_reschedule='no';
	  
	if($('#groupboardpass').is(':checked'))           
      var groupboardpass='yes';
    else
	  var groupboardpass='no';  
	        
    if(name=='')
    {
       alert('Provide Name !');  
       document.getElementById('name').focus();
       return false;
    }
    else if(username=='')
    {
       alert('Provide Username !'); 
       document.getElementById('user_name').focus();
       return false;   
    }
    else if(email=='' || !str.test(email))
    {
       alert('Provide correct email !'); 
       document.getElementById('email_address').focus();
       return false;   
    } 
    else if(pword=='')
    {
       alert('Provide Password !'); 
       document.getElementById('password').focus();
       return false;   
    }
    else if(con_pas=='' || con_pas!=pword)
    {
       alert('Provide same Password !'); 
       document.getElementById('con_password').focus();
      return false;   
    } 
         
    else if(con=='' || !contact.test(con))
    {
       alert('Provide correct contact number !'); 
       document.getElementById('contact').focus();
       return false;   
    } 
    else if(margin=='' || !margins.test(margin))
    {
       alert('Provide your margin !'); 
       document.getElementById('margin').focus();
       return false;   
    }
    else if(payment_type=='0')
    {
       alert('Provide your payment type !'); 
       $('#list').focus();
       return false;   
    }
    /*else if(add=='')
    {
       alert('Provide your address !'); 
       document.getElementById('address').focus();
       return false;   
    }*/
    else if(locat=='0')
    {
       alert('Provide your location !'); 
       document.getElementById('locat').focus();
       return false;   
    }
    else if(!lpay.test(limit))
    {
       alert('Provide your pay limit in numbers!'); 
       document.getElementById('txt').focus();
       return false;   
    }
	else if(branch=='0')
    {
       alert('Please Select Branch !'); 
       document.getElementById('branch').focus();
       return false;   
    }  
	else if(branchAddress=='')
    {
       alert('Provide Branch Address!'); 
       document.getElementById('branchAddress').focus();
       return false;   
    }
	
	else
	{
    	var agent_type='te_agent';
       	var agent_type_name='external';
       	var api_type='';
	   	var payment_type='prepaid';
	   	var r=confirm("Are You Sure, you want to add the Agent!!");
	   	//alert(r);
	   	if(r==true)
	   	{
       		$.post("get_postpaid_agent_formdetails",
           	{
		   		name:name,username:username,password:pword,email_address:email ,contact:con,address:add,locat:locat,landline:landline,address:add,branch:branch,branchAddress:branchAddress,allowcanc:allowcanc,allowmodification:allowmodification,payment_reports:payment_reports,booking_reposts:booking_reposts,pass_reports:pass_reports,vehicle_ass:vehicle_ass,ticket_booking:ticket_booking,checkfare:checkfare,ticket_status:ticket_status,ticket_canc:ticket_canc,ticket_modify:ticket_modify,boardpass:boardpass,ticket_reschedule:ticket_reschedule,groupboardpass:groupboardpass,agent_type:agent_type,agent_type_name:agent_type_name,payment_type:payment_type,margin:margin,limit:limit,api_type:api_type
            },function(res)
			{
				//alert(res);
                if(res==2)
				{
                	$('#result').html('User Name Already Exit,Try with another User Name!!');  
                   	$('#email_address').focus();
                }
                else if(res==1)
				{
					alert("Agent Added Successfully!!!");
				 	window.location='<?php echo base_url("index.php/master_control/addteagent")?>';
                  	/* $('#result').html('Agent Registered Successfully!!');  
                   	$('#email_address').val('');
                   	$('#name').val('');
                   	$('#user_name').val('');
                   	$('#password').val('');
                   	$('#con_password').val('');
                   	$('#contact').val('');
                   	$('#address').val('');
                   	$('#locat').val('');
                   	$('#list').val('');
                   	$('#txt').val('');
                   	$('#margin').val('');*/
                }
             	else
				{
                	//$('#result').html('Problem in storing, Contact us!!');  
				   	alert("There was a problem, Kindly Contact");   
                }
            });
        }
	}
}
</script>
<table width="73%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td height="30" class="space">Add Ticket Engine Agents</td>
  </tr>
  <tr>
    <td height="30" class="space" align="right"><span style="padding-right:20px;"><?php echo anchor('master_control/te_agents','Go Back'); ?></span></td>
  </tr>
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">      
      <tr>
        <td width="2%" height="30">&nbsp;</td>
        <td height="30" colspan="3" align="center"><strong>Add New Ticket EngineAgent </strong></td>
        <td width="2%" height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td width="45%" height="30" align="right">Name</td>
        <td width="2%">&nbsp;</td>
        <td width="49%" height="30"><input type="text" id="name" name="name" value="<?php echo set_value('name'); ?>" /></td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="right">Username</td>
        <td>&nbsp;</td>
        <td height="30"><input type="text" id="user_name" name="user_name" value="<?php echo set_value('user_name'); ?>" onChange="checkUser();" /></td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="right">Password</td>
        <td>&nbsp;</td>
        <td height="30"><input type="password" id="password" name="password"  /></td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="right">Confirm Password</td>
        <td>&nbsp;</td>
        <td height="30"><input type="password" id="con_password" name="con_password"  /></td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="right">Your Email</td>
        <td>&nbsp;</td>
        <td height="30"><input type="text" id="email_address" name="email_address"  /></td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="right">Main Address</td>
        <td>&nbsp;</td>
        <td height="30"><input type="text" id="address" name="address"  /></td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="right">Mobile</td>
        <td>&nbsp;</td>
        <td height="30"><input type="text" id="contact" name="contact"  maxlength="11" /></td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="right">Land Line</td>
        <td>&nbsp;</td>
        <td height="30"><input type="text" id="landline" name="landline"  /></td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="right">Margin</td>
        <td>&nbsp;</td>
        <td height="30"><input type="text" id="margin" name="margin" /></td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="right">Pay Limit</td>
        <td>&nbsp;</td>
        <td height="30"><input type='text' id='txt' name='txt' size='15' /></td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="right">Booking Type Privileges</td>
        <td>&nbsp;</td>
        <td height="30"><input name="allowcanc" id="allowcanc"  type="checkbox">
          Allow Cancellation 
          <input name="allowmodification" id="allowmodification" type="checkbox" >
          Allow Modification</td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="right">Location</td>
        <td>&nbsp;</td>
        <td height="30"><?php 
                     $ide24 = 'id="locat"';
                     echo form_dropdown('locat', $location, '', $ide24);
                            ?></td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="right">Branch</td>
        <td>&nbsp;</td>
        <td height="30"><?php 
                     $ide24 = 'id="branch"';
                     echo form_dropdown('locat', $branch, '', $ide24);
                            ?></td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="right">Branch Address</td>
        <td>&nbsp;</td>
        <td height="30"><input type="text" id="branchAddress" name="branchAddress"  /></td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" align="right">&nbsp;</td>
        <td>&nbsp;</td>

        <td height="30">&nbsp;</td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" colspan="3" align="center"><strong>User Privilages </strong></td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td height="30" colspan="3" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="2%" height="30">&nbsp;</td>
            <td width="45%" height="30" align="right"><input name="payment_reports" id="payment_reports" type="checkbox" ></td>
            <td width="2%" align="right">&nbsp;</td>
            <td width="47%" height="30">PAYMENT REPORTS</td>
            <td width="4%" height="30">&nbsp;</td>
          </tr>
          <tr>
            <td height="30">&nbsp;</td>
            <td height="30" align="right"><input name="booking_reposts" id="booking_reposts" type="checkbox" ></td>
            <td align="right">&nbsp;</td>
            <td height="30">BOOKING REPORTS</td>
            <td height="30">&nbsp;</td>
          </tr>
          <tr>
            <td height="30">&nbsp;</td>
            <td height="30" align="right"><input name="pass_reports" id="pass_reports" type="checkbox" ></td>
            <td align="right">&nbsp;</td>
            <td height="30">PASSENGER REPORTS</td>
            <td height="30">&nbsp;</td>
          </tr>
          <tr>
            <td height="30">&nbsp;</td>
            <td height="30" align="right"><input name="vehicle_ass" id="vehicle_ass" type="checkbox"></td>
            <td align="right">&nbsp;</td>
            <td height="30">VEHICLE ASSIGNMENT</td>
            <td height="30">&nbsp;</td>
          </tr>
          <tr>
            <td height="30">&nbsp;</td>
            <td height="30" align="right"><input name="ticket_booking" id="ticket_booking" type="checkbox" ></td>
            <td align="right">&nbsp;</td>
            <td height="30">TICKET BOOKING</td>
            <td height="30">&nbsp;</td>
          </tr>
          <tr>
            <td height="30">&nbsp;</td>
            <td height="30" align="right"><input name="checkfare" id="checkfare" type="checkbox" ></td>
            <td align="right">&nbsp;</td>
            <td height="30">CHECK FARE</td>
            <td height="30">&nbsp;</td>
          </tr>
          <tr>
            <td height="30">&nbsp;</td>
            <td height="30" align="right"><input name="ticket_status" id="ticket_status" type="checkbox" ></td>
            <td align="right">&nbsp;</td>
            <td height="30">TICKET STATUS</td>
            <td height="30">&nbsp;</td>
          </tr>
          <tr>
            <td height="30">&nbsp;</td>
            <td height="30" align="right"><input name="ticket_canc" id="ticket_canc" type="checkbox" ></td>
            <td align="right">&nbsp;</td>
            <td height="30">TICKET CANCELLAION</td>
            <td height="30">&nbsp;</td>
          </tr>
          <tr>
            <td height="30">&nbsp;</td>
            <td height="30" align="right"><input name="ticket_modify" id="ticket_modify" type="checkbox"></td>
            <td align="right">&nbsp;</td>
            <td height="30">TICKET MODIFY</td>
            <td height="30">&nbsp;</td>
          </tr>
          <tr>
            <td height="30">&nbsp;</td>
            <td height="30" align="right"><input name="boardpass" id="boardpass" type="checkbox"></td>
            <td align="right">&nbsp;</td>
            <td height="30">BOARDING PASSENGER REPORT</td>
            <td height="30">&nbsp;</td>
          </tr>
          <tr>
            <td height="30">&nbsp;</td>
            <td height="30" align="right"><input name="ticket_reschedule" id="ticket_reschedule" type="checkbox"></td>
            <td align="right">&nbsp;</td>
            <td height="30">TICKET RESCHEDULE</td>
            <td height="30">&nbsp;</td>
          </tr>
          <tr>
            <td height="30">&nbsp;</td>
            <td height="30" align="right"><input name="groupboardpass" id="groupboardpass" type="checkbox"></td>
            <td align="right">&nbsp;</td>
            <td height="30">GROUP BOARDING PASSENGER REPORTS</td>
            <td height="30">&nbsp;</td>
          </tr>
        </table></td>
        <td height="30">&nbsp;</td>
      </tr>
      <tr>
        <td height="40">&nbsp;</td>
        <td height="40" colspan="3" align="center"><input type="submit" id="add_new" name="add_new" value="Add" onClick="validate();" style="padding:5px 15px;" /></td>
        <td height="40">&nbsp;</td>
      </tr>
      <tr>
        <td height="40">&nbsp;</td>
        <td height="40" colspan="3" align="center" id="result"></td>
        <td height="40">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
			 