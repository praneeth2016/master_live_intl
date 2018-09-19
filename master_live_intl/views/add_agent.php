<html>
    <head>
        <title>Add External Agents</title>
       <script src="<?php echo base_url("js/jquery.min.js"); ?>" type="text/javascript"></script>
         <link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />
        <script type="text/javascript">
            
        function validate(){
		
       var name=$('#name').val();
           
     var username=$('#user_name').val();
            
     var email=$('#email_address').val();
             
     var str=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-zA-Z]/;
     var pword=$('#password').val();
             
     var con_pas=$('#con_password').val();
            
     var con=$('#contact').val();
             
     var add=$('#address').val();
             
     var locat=$('#locat').val();
     var margin  =$('#margin').val();
     var api_key =$('#api_key').val();
     var payment_type=$('#list').val();
     var limit=$('#txt').val();
     if(limit=='')
        limit=0
     var margins=/^[-]?[0-9]*\.?[0-9]+$/;
     var contact=/^\d+(,\d+)*$/;
     var lpay=/^[0-9]*\.?[0-9]+$/;
        
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
             else if(api_key=='')
             {
              alert('Provide your API Key!'); 
              $('#api_key').focus();
              return false;   
             }
              else if(add=='')
             {
              alert('Provide your address !'); 
              document.getElementById('address').focus();
              return false;   
             }
             else if(locat=='')
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
			 
		else{
                 var agent_type='3';
                 var agent_type_name='api agent';
                 $.post("get_agent_formdetails",
                 {name:name,username:username,password:pword,email_address:email ,contact:con,address:add,
                     locat:locat ,agent_type:agent_type,agent_type_name:agent_type_name,
                     payment_type:payment_type,margin:margin,limit:limit,api_key:api_key 
            },function(res){
			//alert(res);
                 if(res==2){
                   $('#result').html('Email Already Exit,Try with another email ID!!');  
                   $('#email_address').focus();
                 }
                 else if(res==1){
                   $('#result').html('Agent Registered Successfully!!');  
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
                   $('#margin').val('');
                 }
              else {
                   $('#result').html('Problem in storing, Contact us!!');     
                 }
                 });
             }
           
             
        }

</script>
    </head>
    <body>
<p align="right" style="padding-right:220px; padding-top:10px;"><?php echo anchor('master_control/api_agents','Go Back'); ?></p>

<table align="center"  style="margin: 0px auto;" cellspacing="10">

<h4 align='center'>Create New Agent</h4>
  
		<tr style='font-size: 12px;'>
			<td>Name:</td>
			<td><input type="text" id="name" name="name" value="<?php echo set_value('name'); ?>" /></td>
                </tr>
                <tr style='font-size: 12px;'>
			<td>Username:</td>
			<td><input type="text" id="user_name" name="user_name" value="<?php echo set_value('user_name'); ?>" /></td>
		</tr>
		<tr style='font-size: 12px;'>
			<td>Your Email:</td>
			<td><input type="text" id="email_address" name="email_address" value="<?php echo set_value('email_address'); ?>" /></td>
		</tr>
		<tr style='font-size: 12px;'>
			<td>Password:</td>
			<td><input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" /></td>
		</tr>
		<tr style='font-size: 12px;'>
			<td>Confirm Password:</td>
			<td><input type="password" id="con_password" name="con_password" value="<?php echo set_value('con_password'); ?>" /></td>
		</tr>  
                <tr style='font-size: 12px;'>
			<td>Contact No:</td>
			<td><input type="text" id="contact" name="contact" value="<?php echo set_value('contact'); ?>" /></td>
		</tr> 
                <tr style='font-size: 12px;'>
			<td>Margin:</td>
			<td><input type="text" id="margin" name="margin" value="<?php echo set_value('margin'); ?>"/></td>
		</tr>
                
                <tr style='font-size: 12px;'>
			<td>API Key:</td>
			<td><input type="text" id="api_key" name="api_key" value="<?php echo set_value('api_key'); ?>"/></td>
		</tr>
                <tr style='font-size: 12px;'>
			<td>Pay type:</td>
			<td><select id="list">
                                <option value="0">----Select----</option>
                                <option value="prepaid">prepaid</option>
                                <option value="postpaid">postpaid</option>
                            </select></td>
		</tr>
                <tr style='font-size: 12px;'>
                        <td>Pay limit:</td>
                        <td><input type='text' id='txt' name='txt' size='15' value='<?php echo set_value("txt"); ?>'/></td>
		</tr>
         <tr style='font-size: 12px;'>
			<td>Location:</td>
			<td>
                            <?php 
                     $ide24 = 'id="locat"';
                     echo form_dropdown('locat', $location, '', $ide24);
                            ?>
                        </td>
		</tr>                
        <tr style='font-size: 12px;'>
			<td>Address:</td>
			<td><textarea rows="4" cols="25" id="address" name="address" value="<?php echo set_value('address'); ?>" ></textarea></td>
		</tr>
               
                <tr>
			<td></td>
			<td><input type="submit" id="add_new" name="add_new" value="Add" onClick="validate();" /></td>
		</tr>  <tr>
			<td colspan="2" id="result"></td>
		</tr> 
		
  </table>                  
    </body>
</html>
