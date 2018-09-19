<script type="text/javascript">
function validate()
{
	var agent = $('#agent').val();
	var agent_name = $('#agent option:selected').text();
    var operator = $('#operator').val();
	var operator_name = $('#operator option:selected').text();
	var commission = $('#commission').val();
	
	if(agent == '0')
    {
       alert('Please Select Agent!'); 
       document.getElementById('agent').focus();
       return false;   
    }
	
	if(operator == '')
    {
       alert('Provide your Operator !'); 
       document.getElementById('operator').focus();
       return false;   
    }
	
	if(commission == '')
    {
       alert('Provide your Commission!'); 
       document.getElementById('commission').focus();
       return false;   
    }
	
	else
	{
		var r=confirm("Are You Sure, you want to add Commission to the Agent!!");
		
		if(r == true)
	   	{
       		$.post("add_commission",
           	{
				agent:agent,agent_name:agent_name,operator:operator,operator_name:operator_name,commission:commission
			}
			,function(res)
			{
//alert(res);				
if(res==2)
				{
                	alert('Data Already Exists!');                     	
                }
				else if(res==1)
				{
					alert("Commission Added Successfully!!!");
				 	window.location='<?php echo base_url("index.php/master_control/operator_commission")?>';                  	
                }
             	else
				{                	
				   	alert("Database Error");   
                }
			});
		}	
	}
}
</script>
<table width="75%" border="0" cellspacing="1" cellpadding="1" align="center">
  <tr>
    <td height="30" colspan="4" align="center">Set Operator Commision to Agent </td>
  </tr>
  <tr>
    <td height="30" align="center">Agent</td>
    <td align="center">Operator</td>
    <td height="30" align="center">Commission</td>
    <td height="30" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" align="center">
	<?php 
        $ide24 = 'id="agent"';
        echo form_dropdown('agent', $agent, '', $ide24);
    ?>
	</td>
    <td align="center"><?php 
        $ide24 = 'id="operator"';
        echo form_dropdown('operator', $operator, '', $ide24);
    ?></td>
    <td height="30" align="center"><input type="text" name="commission" id="commission" /></td>
    <td height="30" align="center"><input type="button" id="submit" name="Submit" value="Submit" onclick="validate()" /></td>
  </tr>
</table>