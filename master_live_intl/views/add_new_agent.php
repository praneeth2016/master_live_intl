         <link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />
        <script type="text/javascript">
		function checkUser()
		{
		   
		   var uname=$('#user_name').val();
		   $("#un").empty();
		   $.post("checkUser",{uname:uname},function(res){
		   if(res==1)
		   {
		     $("#un").html("User Already Exist !!");
		   }
		   
		   });

    	}
		
		
		function getapi(){
		var agenttype = $('#agenttype').val();
		//alert(agenttype);
		if(agenttype==3)
		{
		$("#ak").show();
		$("#apt").show();
		$("#ip1").show();
		}
		else {
		$("#ak").hide();
		$("#apt").hide();
		$("#ip1").hide();
		}
		
		}

function validate()
{	
	var opid=$('#operators').val();
	var appname=$('#apname').val();
	var name=$('#name').val();
    var username=$('#user_name').val();
	var pword=$('#password').val();
	var con_pas=$('#con_password').val();
    var email=$('#email_address').val();
	
    var str=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-zA-Z]/;
	
    var con=$('#contact').val();
	var locat=$('#locat').val();
	var state=$('#state').val();
	var add=$('#address').val();
	var agenttype=$('#agenttype').val();
	
	var agentypename=$('#agentypename').val();
	var date=$('#date').val();
	var status=$('#status').val();
	var ip=$('#ip').val();
	var blnc=$('#blnc').val();
	var blnclmt=$('#blnclmt').val();
	var comm_type=$('#comm_type').val();
	//alert(comm_type);
	var margin=$('#margin').val();
	var paytype=$('#paytype').val();
	var blnc1=$('#blnc1').val();
	var blnclmt1=$('#blnclmt1').val();
	var margin1=$('#margin1').val();
	var paytype1=$('#paytype1').val();
	var apikey=$('#apikey').val();
	var apitype=$('#apitype').val();
	var execu=$('#execu').val();
	var lmap=$('#lmap').val();
	var landline=$('#landline').val();
	var branch=$('#branch').val();
	var branch_address=$('#branch_address').val();
	var op_comm=$('#op_comm').val();
	
	var contact=/^\d+(,\d+)*$/;
    var lpay=/^[0-9]*\.?[0-9]+$/;
	
	
	
	//alert(opid);
	if(opid=='all'){
	
		alert('Kindly Select Operator!'); 
        $('#operators').focus();
        return false;
	}
	else if(appname=='')
    {
    	alert('Provide App Name!');
        $('#apname').focus();
        return false;
    } 
	else if(name=='')
    {
    	alert('Provide Name !');
        $('#name').focus();
        return false;
    }            
    else if(username=='')
    {
    	alert('Provide Username !'); 
        document.getElementById('user_name').focus();
        return false;   
    }
	else if(pword=='')
    {
    	alert('Provide Password !'); 
      	document.getElementById('password').focus();
      	return false;   
    }
	else if(con_pas=='')
    {
    	alert('Provide Conform Password !'); 
      	document.getElementById('con_password').focus();
      	return false;   
    }
    else if(con_pas=='' || con_pas!=pword)
    {
    	alert('Provide same Password !'); 
      	document.getElementById('con_password').focus();
      	return false;   
    }
	else if(email=='')
    {
    	alert('Provide Email !'); 
        document.getElementById('email_address').focus();
        return false;   
    } 
    else if(email=='' || !str.test(email))
    {
    	alert('Provide correct email !'); 
        document.getElementById('email_address').focus();
        return false;   
    } 
    else if(con=='')
    {
    	alert('Provide Contact number !'); 
      	document.getElementById('contact').focus();
      	return false;   
    }
    else if(con=='' || !contact.test(con))
    {
    	alert('Provide correct contact number !'); 
      	document.getElementById('contact').focus();
      	return false;   
    } 
    else if(locat=="")
    {
    	alert('Provide your location !'); 
      	document.getElementById('locat').focus();
      	return false;   
    }
	else if(add=="")
    {
    	alert('Provide your Address !'); 
      	document.getElementById('address').focus();
      	return false;   
    }
	else if(agenttype=="0")
    {
    	alert('Select Agent Type!'); 
      	document.getElementById('agenttype').focus();
      	return false;   
    }
	/*else if(agenttype !="3")
    {
    	ip = "";
		apikey = "";
		apitype = "";
      	return false;   
    }*/
	else if(agentypename=="0")
    {
    	alert('Select Agent Type Name!'); 
      	document.getElementById('agentypename').focus();
      	return false;   
    }
	else if(blnc=="")
    {
    	alert('Enter Balance!'); 
      	document.getElementById('blnc').focus();
      	return false;   
    }
	else if(blnclmt=="")
    {
    	alert('Enter Balance Limit!'); 
      	document.getElementById('blnclmt').focus();
      	return false;   
    }
	else if(margin=="")
    {
    	alert('Enter Margin!'); 
      	document.getElementById('margin').focus();
      	return false;   
    }
	else if(paytype=="")
    {
    	alert('Enter Pay type!'); 
      	document.getElementById('paytype').focus();
      	return false;   
    }
	
    /*else if(branch == 0)
    {
    	alert('Provide your Branch !'); 
      	document.getElementById('branch').focus();
      	return false;   
    }
	else if(branch_address == '')
    {
    	alert('Provide your Branch Address !'); 
      	document.getElementById('branch_address').focus();
      	return false;   
    } */   
      
    else
	{
		var by_cash = "";
		var by_phone = "";
		var by_phone_agent = "";
		var by_agent = "";
		var by_employee = "";
		var allowcanc = "";
		var allowmodification = "";
		
		if($('#by_cash').is(':checked'))
		{
			by_cash = "yes";
			//alert(by_cash);
		}
		
		else
		{
			by_cash = "no";
		}
		
		if($('#by_phone').is(':checked'))
		{
			by_phone = "yes";
		}
		else
		{
			by_phone = "no";
		}
		
		if($('#by_agent').is(':checked'))
		{
			by_agent = "yes";
		}
		else
		{
			by_agent = "no";
		}
		
		if($('#by_phone_agent').is(':checked'))
		{
			by_phone_agent = "yes";
		}
		else
		{
			by_phone_agent = "no";
		}
		
		if($('#by_employee').is(':checked'))
		{
			by_employee = "yes";
		}
		else
		{
			by_employee = "no";
		}
		if($('#allowcanc').is(':checked'))
		{
			allowcanc = "yes";
		}
		else
		{
			allowcanc = "no";
		}
		if($('#allowmodification').is(':checked'))
		{
			allowmodification = "yes";
		}
		else
		{
			allowmodification = "no";
		}
		
		var payment_reports = "";
		var booking_reports = "";
		var passenger_reports = "";
		var vehicle_assignment = "";
		var ticket_booking = "";
		var check_fare = "";
		var ticket_status = "";
		var ticket_cancellation = "";
		var ticket_modify = "";
		var board_passenger_reports = "";
		var ticket_reschedule = "";
		var group_boarding_passenger_reports = "";
		var branchlogins = "";
				
		if($('#payment_reports').is(':checked'))
		{
			payment_reports = "yes";
		}
		else
		{
			payment_reports = "no";
		}
		
		if($('#booking_reports').is(':checked'))
		{
			booking_reports = "yes";
		}
		else
		{
			booking_reports = "no";
		}
		
		if($('#passenger_reports').is(':checked'))
		{
			passenger_reports = "yes";
		}
		else
		{
			passenger_reports = "no";
		}
		
		if($('#vehicle_assignment').is(':checked'))
		{
			vehicle_assignment = "yes";
		}
		else
		{
			vehicle_assignment = "no";
		}
		
		if($('#ticket_booking').is(':checked'))
		{
			ticket_booking = "yes";
		}
		else
		{
			ticket_booking = "no";
		}				
		
		if($('#check_fare').is(':checked'))
		{
			check_fare = "yes";
		}
		else
		{
			check_fare = "no";
		}
		
		if($('#ticket_status').is(':checked'))
		{
			ticket_status = "yes";
		}
		else
		{
			ticket_status = "no";
		}
		
		if($('#ticket_cancellation').is(':checked'))
		{
			ticket_cancellation = "yes";
		}
		else
		{
			ticket_cancellation = "no";
		}
		
		if($('#ticket_modify').is(':checked'))
		{
			ticket_modify = "yes";
		}
		else
		{
			ticket_modify = "no";
		}
		
		if($('#board_passenger_reports').is(':checked'))
		{
			board_passenger_reports = "yes";
		}
		else
		{
			board_passenger_reports = "no";
		}
		
		if($('#ticket_reschedule').is(':checked'))
		{
			ticket_reschedule = "yes";
		}
		else
		{
			ticket_reschedule = "no";
		}
		
		if($('#group_boarding_passenger_reports').is(':checked'))
		{
			group_boarding_passenger_reports = "yes";
		}
		else
		{
			group_boarding_passenger_reports = "no";
		}
		
		if($('#ispay').is(':checked'))
		{
			ispay = "1";
		}
		else
		{
			ispay = "0";
		}
		if($('#ishover').is(':checked'))
		{
			ishover = "1";
		}
		else
		{
			ishover = "0";
		}	
		if($('#isip').is(':checked'))
		{
			isip = "1";
		}
		else
		{
			isip = "0";
		}
		if($('#headoff').is(':checked'))
		{
			headoff = "yes";
		}
		else
		{
			headoff = "no";
		}
		if($('#show_avil_seat').is(':checked'))
		{
			show_avil_seat = "yes";
		}
		else
		{
			show_avil_seat = "no";
		}
		if($('#bus_mgmt').is(':checked'))
		{
			bus_mgmt = "yes";
		}
		else
		{
			bus_mgmt = "no";
		}
		
		if($('#seat_mgmt').is(':checked'))
		{
			seat_mgmt = "yes";
		}
		else
		{
			seat_mgmt = "no";
		}
		
		if($('#login_mgmt').is(':checked'))
		{
			login_mgmt = "yes";
		}
		else
		{
			login_mgmt = "no";
		}
		
		if($('#branchlogins').is(':checked'))
		{
			branchlogins = "yes";
		}
		else
		{
			branchlogins = "no";
		}
		
		if($('#ind_seat_fare').is(':checked'))
		{
			ind_seat_fare = "yes";
		}
		else
		{
			ind_seat_fare = "no";
		}
 		
		if($('#agent_charge').is(':checked'))
		{
			agent_charge = "yes";
		}
		else
		{
			agent_charge = "no";
		}
		if($('#other_service').is(':checked'))
		{
			other_service = "yes";
		}
		else
		{
			other_service = "no";
		}
		
		if($('#price_edit').is(':checked'))
		{
			price_edit = "yes";
		}
		else
		{
			price_edit = "no";
		}
        
		var r = window.confirm("Are You Sure Want To Add  Agent");
		
		if(r == true)
		{
			$.post("<?php echo base_url('master_control/Add_agents1');?>",{
			
			appname:appname,
			name:name,
			username:username,
			password:pword,
			email_address:email,
			contact:con,
			locat:locat,
			state:state,
			address:add,
			opid:opid,
			agent_type:agenttype,
			agent_type_name:agentypename,
			date:date,
			status:status,
			ip:ip,
			blnc:blnc,
			blnclmt:blnclmt,
			comm_type:comm_type,
			margin:margin,
			paytype:paytype,
			blnc1:blnc1,
			blnclmt1:blnclmt1,
			margin1:margin1,
			paytype1:paytype1,
			apikey:apikey,
			apitype:apitype,
			execu:execu,
			lmap:lmap,
			landline:landline,
			branch:branch,
			branch_address:branch_address,
			op_comm:op_comm,
			
			by_cash:by_cash,
			by_phone:by_phone,
			by_agent:by_agent,
			by_phone_agent:by_phone_agent,
			by_employee:by_employee,
			allowcanc:allowcanc,
			allowmodification:allowmodification,
			
			payment_reports:payment_reports,
			booking_reports:booking_reports,
			passenger_reports:passenger_reports,
			vehicle_assignment:vehicle_assignment,
			ticket_booking:ticket_booking,
			check_fare:check_fare,
			ticket_status:ticket_status,
			ticket_cancellation:ticket_cancellation,
			ticket_modify:ticket_modify,
			board_passenger_reports:board_passenger_reports,
			ticket_reschedule:ticket_reschedule,
			group_boarding_passenger_reports:group_boarding_passenger_reports,
			
			ispay:ispay,
			ishover:ishover,
			isip:isip,
			headoff:headoff,
			show_avil_seat:show_avil_seat,
			bus_mgmt:bus_mgmt,
			seat_mgmt:seat_mgmt,
			login_mgmt:login_mgmt,
			branchlogins:branchlogins,
			ind_seat_fare:ind_seat_fare,
			agent_charge:agent_charge,
			other_service:other_service,
			price_edit:price_edit
			},function(res)
			{
				//alert(res);
				 if(res==1)
				{
					alert('Agent Registered Successfully!!');
					window.location = '<?php echo base_url("master_control/Add_gents");?>';
        	    }
            	else
				{    
					alert('Problem in storing, Kindly Contact us!!');
        	    }
	        });
    	}
	}
}
</script>
    <table width="593" align="center" cellspacing="2"   style="margin: 0px auto;">
      <tr>
        <td height="29" colspan="4" align="center"><span style="padding-left:20px;">Add New Agent</span></td>
        <td width="191">&nbsp;</td>
      </tr>
      <tr>
        <td width="2" height="29">&nbsp;</td>
        <td width="141">&nbsp;</td>
        <td width="13">&nbsp;</td>
        <td width="222" align="right">&nbsp;</td>
        <td align="right"><span style="padding-top:10px; padding-right:10px"><?php echo anchor('master_control/Add_gents','Go Back'); ?></span></td>
      </tr>
      <tr>
        <td height="29">&nbsp;</td>
        <td>Select operator:</td>
        <td>&nbsp;</td>
        <td><?php $op_id = 'id="operators" style="width:150px; font-size:12px" onChange="ChangeData()"';
                     echo form_dropdown('operators',$operators,"",$op_id);?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>App Name:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="apname" name="apname" value="<?php echo set_value('name'); ?>" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td> Name:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="name" name="name" value="<?php echo set_value('name'); ?>" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Username:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="user_name" name="user_name"  value="<?php echo set_value('user_name'); ?>" onchange="checkUser();" /></td>
        <td align="left"><span id="un" style="color:#FF0000"></span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Password:</td>
        <td>&nbsp;</td>
        <td><input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Confirm Password:</td>
        <td>&nbsp;</td>
        <td><input type="password" id="con_password" name="con_password" value="<?php echo set_value('con_password'); ?>" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Your Email:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="email_address" name="email_address" value="<?php echo set_value('email_address'); ?>" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Contact No:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="contact" name="contact" value="<?php echo set_value('contact'); ?>" maxlength="10" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Location:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="locat" name="locat" value="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>State:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="state" name="state" value="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td> Address:</td>
        <td>&nbsp;</td>
        <td><textarea rows="3" cols="18" id="address" name="address" value="<?php echo set_value('address'); ?>" ></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Agent Type:</td>
        <td>&nbsp;</td>
        <td><select name="agenttype" id="agenttype" onchange="getapi()">
            <option value="0">--select--</option>
			<option value="3">API</option>
            <option value="1">Branch</option>
            <option value="2">Prepaid</option>
            <option value="2">Postpaid</option>
            <option value="3">Ticket Engine</option>
        </select></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Agent Type Name:</td>
        <td>&nbsp;</td>
        <td><select name="agentypename" id="agentypename">
			<option value="0">--select--</option>
            <option value="inhouse">Inhouse</option>
            <option value="api">API</option>
            <option value="external">External</option>
            
        </select></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Date:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="date" name="date" value="<?php echo date("Y-m-d"); ?>" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Status:</td>
        <td>&nbsp;</td>
        <td><select name="status" id="status">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select></td>
        <td>&nbsp;</td>
      </tr>
      <tr id="ip1">
        <td>&nbsp;</td>
        <td>IP:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="ip" name="ip" value="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Balance:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="blnc" name="blnc" value="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Balance limit:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="blnclmt" name="blnclmt" value="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
      	<td>&nbsp;</td>
      	<td>Commision Type </td>
      	<td>&nbsp;</td>
      	<td><select name="comm_type" id="comm_type">
	  <option value="0">-- select --</option>
	  <option value="percent">percent</option>
	  <option value="rupees">rupees</option>
    </select></td>
      	<td>&nbsp;</td>
      	</tr>
      <tr>
        <td>&nbsp;</td>
        <td>Commision:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="margin" name="margin" value="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Pay Type:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="paytype" name="paytype" value="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Balance1:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="blnc1" name="blnc1" value="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Balance limit1:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="blnclmt1" name="blnclmt1" value="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Margin1:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="margin1" name="margin1" value="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Pay Type1:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="paytype1" name="paytype1" value="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr id="ak">
        <td>&nbsp;</td>
        <td>API Key:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="apikey" name="apikey" value="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr id="apt">
        <td>&nbsp;</td>
        <td>API type:</td>
        <td>&nbsp;</td>
        <td><select name="apitye" id="apitype">
			<option value="">--Select--</option>
            <option value="op">Operator</option>
            <option value="te">TE</option>
        </select></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Executive:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="execu" name="execu" value="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Location map:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="lmap" name="lmap" value="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Land Line:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="landline" name="landline" value="<?php echo set_value('landline'); ?>" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Branch:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="branch" name="branch" value="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Branch Address:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="branch_address" name="branch_address" value="<?php echo set_value('branch_address'); ?>" /></td>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
        <td>Operator Comm:</td>
        <td>&nbsp;</td>
        <td><input type="text" id="op_comm" name="op_comm"  /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Booking Type : </td>
        <td>&nbsp;</td>
        <td colspan="2">
            <input name="by_cash" id="by_cash" type="checkbox" value="" />
          By Cash:
          <input name="by_phone" id="by_phone" type="checkbox" value="" />
          By Phone:
          <input name="by_agent" id="by_agent" type="checkbox" value="" />
          By Agent: 
            
              <input name="by_phone_agent" id="by_phone_agent" type="checkbox" value="" />
              By Phone Agent:
              <input name="by_employee" id="by_employee" type="checkbox" value="" />
              By Employee:</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Booking Type Privileges:</td>
        <td>&nbsp;</td>
        <td colspan="2"><input name="allowcanc" id="allowcanc"  type="checkbox" />
          Allow Cancellation
          <input name="allowmodification" id="allowmodification" type="checkbox">
          Allow Modification</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td colspan="3" style="background-color:#CCCCCC"><strong>User Privilages </strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="payment_reports" id="payment_reports" value="" />
          &nbsp;&nbsp;PAYMENT REPORTS</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="booking_reports" id="booking_reports" value="" />
          &nbsp;&nbsp;BOOKING REPORTS</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="passenger_reports" id="passenger_reports" value="" />
          &nbsp;&nbsp;PASSENGER REPORTS</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="vehicle_assignment" id="vehicle_assignment" value="" />
          &nbsp;&nbsp;VEHICLE ASSIGNMENT</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="ticket_booking" id="ticket_booking" value="" />
          &nbsp;&nbsp;TICKET BOOKING</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="check_fare" id="check_fare" value="" />
          &nbsp;&nbsp;CHECK FARE</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="ticket_status" id="ticket_status" value="" />
          &nbsp;&nbsp;TICKET STATUS</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="ticket_cancellation" id="ticket_cancellation" value="" />
          &nbsp;&nbsp;TICKET CANCELLAION</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="ticket_modify" id="ticket_modify" value="" />
          &nbsp;&nbsp;TICKET MODIFY</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="board_passenger_reports" id="board_passenger_reports" value="" />
          &nbsp;&nbsp;BOARDING PASSENGER REPORT</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="ticket_reschedule" id="ticket_reschedule" value="" />
          &nbsp;&nbsp;TICKET RESCHEDULE</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="group_boarding_passenger_reports" id="group_boarding_passenger_reports" value="" />
          &nbsp;&nbsp;GROUP BOARDING PASSENGER REPORTS</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="ispay" id="ispay" value="" />
          &nbsp;&nbsp;IS PAY</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="ishover" id="ishover" value="" />
          &nbsp;&nbsp;IS HOVER</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="isip" id="isip" value="" />
          &nbsp;&nbsp;IS IP</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="headoff" id="headoff" value="" />
          &nbsp;&nbsp;HEAD OFFICE</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="show_avil_seat" id="show_avil_seat" value="" />
          &nbsp;&nbsp;SHOW AVILABLE SEATS</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="bus_mgmt" id="bus_mgmt" value="" />
          &nbsp;&nbsp;BUS MANAGEMENT</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="seat_mgmt" id="seat_mgmt" value="" />
          &nbsp;&nbsp;SEAT MANAGEMENT</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="login_mgmt" id="login_mgmt" value="" />
          &nbsp;&nbsp;LOGIN MANAGEMENT</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="branchlogins" id="branchlogins" value="" />
&nbsp;BRANCH LOGINS </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="ind_seat_fare" id="ind_seat_fare" value="" />
          &nbsp;&nbsp;INDIVIDUAL SEAT FARE</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="agent_charge" id="agent_charge" value="" />
          &nbsp;&nbsp;AGENT CHARGE</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="other_service" id="other_service" value="" />
          &nbsp;&nbsp;OTHER SERVICES</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="22" colspan="3"><input type="checkbox" name="price_edit" id="price_edit" value="" />
          &nbsp;&nbsp;PRICE EDIT</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td><input type="submit" id="add_new" name="add_new" value="Add" onclick="validate()" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" id="result"></td>
      </tr>
    </table>
    