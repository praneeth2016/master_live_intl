<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: New BUS Operator</title>
<script>
$(document).ready(function()
{
	$('#submit').click(function()
	{
		if($('#optitle').val() == "")
		{
	 		alert("Please Enter Operator Title"); 
 			$('#optitle').focus();
 			return false;  
		}
		else if($('#uname').val() == "")
		{
	 		alert("Please enter User Name"); 
	 		$('#uname').focus();
	 		return false;
		}
		else if($('#pwd').val() == "")
		{
	 		alert("Please Enter Password"); 
	 		$('#pwd').focus();
	 		return false;
		}
		else if($('#firmtype').val() == "")
		{
	 		alert("Please Select Firm Type"); 
	 		$('#firmtype').focus();
	 		return false;
		}
		else if($('#name').val() == "")
		{
	 		alert("Please Enter Nmae");	 		
	 		$('#name').focus();
	 		return false;
		}
		else if($('#address').val() == "")
		{
	 		alert("Prode Address"); 
	 		$('#address').focus();
	 		return false;
		}
		else if($('#location').val() == "")
		{
	 		alert("Please Select Location"); 
	 		$('#location').focus();
	 		return false;
		}
		else if($('#contactno').val() == "")
		{
	 		alert("Please Provide Contact Number"); 
	 		$('#contactno').focus();
	 		return false;
		}
		/*
		else if($('#faxno').val() == "")
		{
	 		alert("Please Enter FAX NO"); 
	 		$('#faxno').focus();
	 		return false;
		} */
		else if($('#emailid').val() == "")
		{
	 		alert("Please Enter Email ID"); 
	 		$('#emailid').focus();
	 		return false;
		}
		
		else if($('#trlid').val() == "")
		{
	 		alert("Please Write travel ID"); 
	 		$('#trlid').focus();
	 		return false;
		}
		
		else if($('#fbd').val() == "")
		{
	 		alert("Please select  Forword Booking Days"); 
	 		$('#fbd').focus();
	 		return false;
		}
		
		else if($('#canctrms').val() == "")
		{
	 		alert("Please select  Cancellation Terms"); 
	 		$('#canctrms').focus();
	 		return false;
		}
		else if($('#auname').val() == "")
		{
	 		alert("Please select  Admin User Name"); 
	 		$('#auname').focus();
	 		return false;
		}
		else if($('#apwd').val() == "")
		{
	 		alert("Please select  Admin Password"); 
	 		$('#apwd').focus();
	 		return false;
		}
		
		else if($('#Acancltrms').val() == "")
		{
	 		alert("Please select Agent Cancellation Terms"); 
	 		$('#Acancltrms').focus();
	 		return false;
		}
		
		else if($('#tktno').val() == "")
		{
	 		alert("Please select Ticket Number"); 
	 		$('#tktno').focus();
	 		return false;
		}
		
		else if($('#opurl').val() == "")
		{
	 		alert("Please select URL"); 
	 		$('#opurl').focus();
	 		return false;
		}
		
		else if($('#opmail').val() == "")
		{
	 		alert("Please select MAIL"); 
	 		$('#opmail').focus();
	 		return false;
		}

		/*else if($('#bankname').val() == "")
		{
	 		alert("Please Enter Bank Name"); 
	 		$('#bankname').focus();
	 		return false;
		}
		else if($('#bankacno').val() == "")
		{
	 		alert("Please Provide Bank Account NO"); 
	 		$('#bankacno').focus();
	 		return false;
		}
		else if($('#ifsccode').val() == "")
		{
	 		alert("Please Enter IFSC Code"); 
	 		$('#ifsccode').focus();
	 		return false;
		}
		else if($('#firmtype').val() == "")
		{
	 		alert("Please Select Firm Type"); 
	 		$('#firmtype').focus();
	 		return false;
		}*/
		
		else if($('#ck').val() == 1)
 		{
     		alert("UserName is Already Exist");
     		$('#uname').focus();
     		return false;
 		}
  		else if($('#ck3').val() == 1)
 		{
     		alert("password must contain 8 letters");
     		$('#pwd').focus();
     		return false;
 		}
 		else if($('#ck2').val() == 1)
 		{
     		alert("You must enter a valid phone number");
     		$('#contactno').focus();
     		return false;
 		}
 		else if($('#ck1').val() == 1)
 		{
     		alert("You must enter a valid e-mail address");
     		$('#emailid').focus();
     		return false;
 		}
		/*else if($('#package').val() == "")
		{
	 		alert("Please Select Tour Packages"); 
	 		$('#package').focus();
	 		return false;
		}*/
		else
		{
			$.post("<?php echo base_url('operator/opr_reg1');?>",
			{ 
				 optitle : $('#optitle').val(),
				 uname : $('#uname').val(),
				 pwd : $('#pwd').val(),
				 firmtype : $('#firmtype').val(),
				 name : $('#name').val(),
				 address : $('#address').val(),
				 location : $('#location').val(),
				 contactno : $('#contactno').val(),
				 emailid : $('#emailid').val(),
				 panno : $('#panno').val(),
				 bankname : $('#bankname').val(),
				 bankacno : $('#bankacno').val(),
				 branch : $('#branch').val(),
				 ifsccode : $('#ifsccode').val(),
				 mode : $('#mode').val(),
				 status : $('#status').val(),
				 travelid : $('#trlid').val(),
				 date : $('#date').val(),
				 ip : $('#ip').val(),
				 fbd : $('#fbd').val(),
				 cancleterms : $('#canctrms').val(),
				 rid : $('#rid').val(),
				 Auname : $('#auname').val(),
				 Apwd : $('#apwd').val(),
				 acesstype : $('#acsstype').val(),
				 billtype : $('#biltype').val(),
				 billamt : $('#bilamt').val(),
				 Acancleterms : $('#Acancltrms').val(),
				 senderid : $('#sendid').val(),
				 apisms : $('#apsms').val(),
				 othercantact : $('#contactno').val(),
				 tktno : $('#tktno').val(),
				 opurl : $('#opurl').val(),
				 opmail : $('#opmail').val(),
				 livedate : $('#ldate').val(),
				 central_agent : $('#CA').val() 
			},function(res)
    		{ alert(res);
	    		if(res == 1)
    			{
			    	alert("Successfully Registered");
					window.location = "<?php echo base_url('operator/opr_reg');?>";
		    	}
				else
				{ 	alert(res);
					alert("Problem in Registration");
				}
		    });
		}
	});    
});

function checkUser()
{
    var uname=$('#uname').val();
    $.post("<?php echo base_url('operator/chkuser');?>",{uname:uname},function(res)
    {
	    if(res == 1)
    	{
	    	$('#uncheck').html('UserName is Already Exist');
			$('#ck').val(1);
    	}
		else
		{ 
			$('#uncheck').html('');
	  		$('#ck').val(0);
		}
    });
}

function checkMail()
{
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  	var demail=$('#emailid').val();
  	
	if(!regex.test(demail))
  	{
    	$('#mailcheck').html('Enter a valid e-mail address');
    	$('#ck1').val(1);
  	}
  	else
  	{
    	$('#mailcheck').html('');
		$('#ck1').val(0);
  	}
}

function checkPhone()
{
	var phoneRegExp = /^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/;
  	var phoneVal = $('#contactno').val();
  	var numbers = phoneVal.split("").length;
  	
	if (!phoneRegExp.test(phoneVal))
  	{
  		$('#phonecheck').html('Enter a valid phone number');
    	$('#ck2').val(1);
  	}
  	else
  	{
    	$('#phonecheck').html('');
		$('#ck2').val(0);
  	}
}

function checkPassword()
{
	var pass = $('#pwd').val();
  	var pwdlength = $("#pwd").val().length;
  	
	if (pwdlength>=8)
  	{
		$('#passcheck').html('');
		$('#ck3').val(0);
  	}
  	else
  	{
    	$('#passcheck').html('password must contain 8 letters');
    	$('#ck3').val(1);
  	}
}
</script>
</head>

<body>
<table width="67%" border="0" cellspacing="5" cellpadding="5" align="center">
  <tr>
    
    <td colspan="3" align="center"><u> NEW OPERATOR REGISTRATION</u> </td>   
  </tr>
  <tr>
    
  </tr>
  <tr>
    <td align="right">Operator  Title</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="optitle" id="optitle" /></td>
  </tr>
  <tr>
    <td align="right">User Name</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="hidden" id="ck" name="ck"/><input type="text" name="uname" id="uname" onblur="checkUser()"/><span id="uncheck" style="color:#FF3300; font-weight:normal;font-family:"Times New Roman", Times, serif"></span></td>
  </tr>
  <tr>
    <td align="right">Password</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="hidden" id="ck3" name="ck3"/><input type="password" name="pwd" id="pwd" onblur="checkPassword()" /><span id="passcheck" style="color:#FF3300; font-weight:normal;font-family:"Times New Roman", Times, serif"></span></td>
  </tr>
  <tr>
    <td align="right">Firm  Type</td>
    <td align="center"><strong>:</strong></td>
    <td><select name="firmtype" id="firmtype" style="width:145px">
      <option value="" selected="selected">  - - select - -  </option>
      <option value="Proprietor">Proprietor</option>
      <option value="Pvt Ltd/">Pvt Ltd/</option>
      <option value="Public Limited">Public Limited</option>
      </select></td>
  </tr>
  <tr>
    <td align="right">Name</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="name" id="name" /></td>
  </tr>
  <tr>
    <td align="right">Address</td>
    <td align="center"><strong>:</strong></td>
    <td><textarea name="address" id="address" cols="18" rows="3"></textarea></td>
  </tr>
  <tr>
    <td align="right">Location</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" id="location" name="location"  /></td>
  </tr>
  <tr>
    <td align="right">Contact Number</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="hidden" id="ck2" name="ck2"/>
      <input type="text" name="contactno" id="contactno" onblur="checkPhone()" /><span id="phonecheck" style="color:#FF3300; font-weight:normal;font-family:"Times New Roman", Times, serif"></span></td>
  </tr>
  <tr>
    <td align="right">Email  ID</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="hidden" id="ck1" name="ck1"/>
      <input type="text" name="emailid" id="emailid" onblur="checkMail()" /><span id="mailcheck" style="color:#FF3300 ; font-weight:normal;font-family:"Times New Roman", Times, serif"></span></td>
  </tr>
  <tr>
    <td align="right">PAN Card Number </td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="panno" id="panno" /></td>
  </tr>
  <tr>
    <td align="right">Bank Name</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="bankname" id="bankname" /></td>
  </tr>
  <tr>
    <td align="right">Bank  Account No </td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="bankacno" id="bankacno" /></td>
  </tr>
  <tr>
    <td align="right">Branch</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="branch" id="branch" /></td>
  </tr>
  <tr>
    <td align="right">IFSC Code</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="ifsccode" id="ifsccode" /></td>
  </tr>
  <tr>
    <td align="right">Mode</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="mode" id="mode" /></td>
  </tr>
  <tr>
    <td align="right">Status</td>
    <td align="center"><strong>:</strong></td>
    <td><select name="status" id="status" style="width:145px">
      <option value="1" selected="selected">Active</option>
      <option value="0">Inactive</option>
      </select></td>
  </tr>
  <tr>
    <td align="right">Travel ID </td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="trlid" id="trlid" value="<?php echo $travel_id;?>" disabled="disabled" /></td>
  </tr>
  <tr>
    <td align="right">Date</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="date" id="date" /></td>
  </tr>
  <tr>
    <td align="right">IP</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="ip" id="ip" /></td>
  </tr>
  <tr>
    <td align="right">Forword Booking Days</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="fbd" id="fbd" /></td>
  </tr>
  <tr>
    <td align="right">Cancellation Terms </td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="canctrms" id="canctrms" /></td>
  </tr>
  <!--<tr>
  <tr>
    <td width="30%">Cancellation Terms </td>
	<td align="center"><strong>:</strong></td>
    <td width="20%">From</td>
    <td width="18%">To</td>
    <td width="32%"> Percentage</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
    <td><input type="text" name="f1" id="f1"  size="5"/></td>
     <td><input type="text" name="f2" id="f2" size="5"/></td>
     <td><input type="text" name="f3" id="f3" size="5"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
     <td><input type="text" name="t1" id="t1" size="5"/></td>
    <td><input type="text" name="t2" id="t2" size="5"/></td>
     <td><input type="text" name="t3" id="t3" size="5"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
     <td><input type="text" name="p1" id="p1" size="5"/></td>
     <td><input type="text" name="p2" id="p2" size="5"/></td>
     <td><input type="text" name="p3" id="p3" size="5"/></td>
  </tr>
  </tr>-->
  <tr>
    <td align="right">R ID </td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="rid" id="rid" /></td>
  </tr>
  <tr>
    <td align="right">Admin UserName</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="auname" id="auname" /></td>
  </tr>
  <tr>
    <td align="right">Admin Password</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="password" name="apwd" id="apwd" /></td>
  </tr>
  <tr>
    <td align="right">Access Type</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="acsstype" id="acsstype" /></td>
  </tr>
  <tr>
    <td align="right">Bill Type </td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="biltype" id="biltype" /></td>
  </tr>
  <tr>
    <td align="right">Bill Amount </td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="bilamt" id="bilamt" /></td>
  </tr>
  <tr>
    <td align="right">Agent Cancellation Terms</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="Acancltrms" id="Acancltrms" /></td>
  </tr>
  <tr>
    <td align="right">Sender ID </td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="sendid" id="sendid" /></td>
  </tr>
  <tr>
    <td align="right">Is API SMS </td>
    <td align="center"><strong>:</strong></td>
    <td><select name="apsms" id="apsms" style="width:145px">
      <option value="1" selected="selected">Yes</option>
      <option value="0">No</option>
      </select></td>
  </tr>
  <tr>
    <td align="right">Other Contact Number</td>
    <td align="center"><strong>:</strong></td>
    <td><input type="hidden" id="ck2" name="ck2"/>
      <input type="text" name="o_contactno" id="o_contactno" /></td>
  </tr>
  <tr>
    <td align="right">Ticket Number </td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="tktno" id="tktno" /></td>
  </tr>
  <tr>
    <td align="right">OP Url </td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="opurl" id="opurl" /></td>
  </tr>
  <tr>
    <td align="right">OP Email </td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="opmail" id="opmail" /></td>
  </tr>
  <tr>
    <td align="right">Live Date </td>
    <td align="center"><strong>:</strong></td>
    <td><input type="text" name="ldate" id="ldate" /></td>
  </tr>
  <tr>
    <td align="right">Cental_agent </td>
    <td align="center"><strong>:</strong></td>
    <td><select name="CA" id="CA" style="width:145px">
      <option value="yes" selected="selected">Yes</option>
      <option value="no">No</option>
      </select></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td><input type="submit" name="submit" id="submit" value="Submit"  /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
