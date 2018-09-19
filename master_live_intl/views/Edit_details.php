<?php 
foreach($query as $rows)
{
   $status=$rows->status; 
   $api_type=$rows->api_type;
   $pay_type=$rows->pay_type;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Details</title>
<script type="text/javascript" src="<?php echo base_url("js/jquery.min.js");?>"></script>
<script>
$(document).ready(function(){
            


        var status="<?php echo $status ?>";
          $('#ag_status').val(status);
         var api_type="<?php echo $api_type ?>";
          $('#ag_api_type').val(api_type);
         var pay_type="<?php echo $pay_type ?>";
          $('#ag_pay').val(pay_type); 
          
          if(api_type=='te')
              {
               $('input:text').removeAttr("readonly");
               $('#ag_api_type').attr('disabled', false);
               $('#ag_pay').attr('disabled', false);
               $('#ag_status').attr('disabled', false);
              }
              else if(api_type=='op'){
                  $('#ag_name').attr("readonly",true);
                  $('#ag_uname').attr("readonly",true);
                  $('#ag_mobile').attr("readonly",true);
                  $('#ag_email').attr("readonly",true);
                  $('#ag_address').attr("readonly",true);
                  $('#ag_password').attr("readonly",true);
                  $('#ag_margin').attr("readonly",true);
                  $('#ag_limit').attr("readonly",true);
                  $('#ag_balance').attr("readonly",true);
                  
                  
              }
          $('#Save').click(function(){
            var name = $("#ag_name").val();
            var uid = $("#hdn").val();
            var uname = $("#ag_uname").val();
            var mobile = $("#ag_mobile").val();
            var email= $("#ag_email").val();
            var address = $("#ag_address").val();
            var apitype = $("#ag_api_type").val();
            var api_key = $("#ag_api_key").val();
            var ip = $("#ag_ip").val();
            var api_pas = $("#ag_password").val();
            var margin = $("#ag_margin").val();
            var pay = $("#ag_pay").val();
            var limit = $("#ag_limit").val();
            var balance = $("#ag_balance").val();
            var st = $("#ag_status").val();
            var contact=/^\d+(,\d+)*$/;
        
         if(name === "")
        {
            alert("Please Provide Your Name");
            $("#ag_name").focus();
            return false;
        }
        
        
        else if(mobile === "" ||!contact.test(mobile))
        {
            alert("Please Provide Your Contact No");
            $("#ag_mobile").focus();
            return false;
        }
         
        else if(email === "")
        {
            alert("Please Provide Your Email Id");
            $("#ag_email").focus();
            return false;
        }
        
        else if(address === "")
        {
            alert("Please Provide Your Address");
            $("#ag_address").focus();
            return false;
        }
        
        else if(api_key === "")
        {
            alert("Please Provide Your API Key");
            $("#ag_api_key").focus();
            return false;
        }
        
        else if(uname === "")
        {
            alert("Please Provide Your Username");
            $("#ag_uname").focus();
            return false;
        }
        
        else if(api_pas === "")
        {
            alert("Please Provide Your Password");
            $("#ag_password").focus();
            return false;
        }
        
        else if(apitype === '0')
        {
            alert("Please Provide Your API Type");
            $("#ag_api_type").focus();
            return false;
        }
        
        else if(balance === "")
        {
            alert("Please Provide Your Balance");
            $("#ag_balance").focus();
            return false;
        }
        
        else if(limit === "")
        {
            alert("Please Provide Your Pay Limit");
            $("#ag_limit").focus();
            return false;
        }
        
        else if(pay === "")
        {
            alert("Please Provide Your Pay Type");
            $("#ag_pay").focus();
            return false;
        }
        
        else if(margin === "")
        {
            alert("Please Provide Your Margin");
            $("#ag_margin").focus();
            return false;
        }
        
        else if(ip === '')
        {
            alert("Please Provide Your IP Address");
            $("#ag_ip").focus();
            return false;
        }
        
        
        
        else
            {
                $.post('Updatedetails',{id:uid,name:name,mobile:mobile,email:email,address:address,api_key:api_key,apitype:apitype,uname:uname,pass:api_pas,status:st,ip:ip,margin:margin,pay:pay,limit:limit,balance:balance},function(res){
                //alert(res);         
                  if(res==1)
                     {
                      alert('Updated successfully');   
                     }
                     else{
                      alert('not Updated ');   
                     }
                });
            }
          });
          });
        
</script>

</head>

<p align="right" style="padding-right:220px; padding-top:10px;"><?php echo anchor('master_control/api_agents','Go Back'); ?></p>
<h4 align="center">Api Agents Edit Details</h4>
<?php
foreach ($query as $rows) {
    $id=$rows->id;
    
    
  echo "<table align='center' cellspacing='10' style='margin: 0px auto;' id='tbl'>
        <tr align='center' style='font-size:12px;'>
        <td align='right'>Name:</td>
        <td align='left'><input type='text' id='ag_name' nam='ag_name' value=$rows->name ></td>
        </tr>
        <tr align='center' style='font-size:12px;'>
        <td align='right'>Email:</td>
        <td align='left'><input type='text' id='ag_email' nam='ag_email' value=$rows->email ></td>
        </tr>
        <tr align='center' style='font-size:12px;'>
        <td align='right'>Mobile:</td>
        <td align='left'><input type='text' id='ag_mobile' nam='ag_mobile' value=$rows->mobile ></td>
        </tr>
        <tr align='center' style='font-size:12px;'>
        <td align='right'>Address:</td>
        <td align='left'><input type='text' id='ag_address' nam='ag_address' value=$rows->address ></td>
        </tr>
        <tr align='center' style='font-size:12px;'>
        <td align='right'>API Key:</td>
        <td align='left'><input type='text' id='ag_api_key' nam='ag_api_key' value=$rows->api_key></td>
        </tr>
        <tr align='center' style='font-size:12px;'>
        <td align='right'>IP Address:</td>
        <td align='left'><input type='text' id='ag_ip' nam='ag_ip' value=$rows->ip></td>
        </tr>
        <tr align='center' style='font-size:12px;'>
        <td align='right'>API Type:</td>
        <td align='left'><select id='ag_api_type' disabled>
                                <option value='0'>----Select----</option>
                                <option value='te'>Ticket Engine</option>
                                <option value='op'>Operator</option>
                            </select></td>
        </tr>
        <tr align='center' style='font-size:12px;'>
        <td align='right'>Margin:</td>
        <td align='left'><input type='text' id='ag_margin' nam='ag_margin' value=$rows->margin ></td>
        </tr>
        <tr align='center' style='font-size:12px;'>
        <td align='right'>Pay type:</td>
        <td align='left'><select id='ag_pay' disabled>
                                
                                <option value='prepaid'>Prepaid</option>
                                <option value='postpaid'>Postpaid</option>
                            </select></td>
        </tr>
        <tr align='center' style='font-size:12px;'>
        <td align='right'>Limit:</td>
        <td align='left'><input type='text' id='ag_limit' nam='ag_limit' value=$rows->bal_limit ></td>
        </tr>
        <tr align='center' style='font-size:12px;'>
        <td align='right'>Balance:</td>
        <td align='left'><input type='text' id='ag_balance' nam='ag_balance' value=$rows->balance ></td>
        </tr>
        <tr align='center' style='font-size:12px;'>
        <td align='right'>Username:</td>
        <td align='left'><input type='text' id='ag_uname' nam='ag_uname' value=$rows->uname ></td>
        </tr>
        <tr align='center' style='font-size:12px;'>
        <td align='right'>Password:</td>
        <td align='left'><input type='text' id='ag_password' nam='ag_password' value=$rows->password ></td>
        </tr>
        <tr align='center' style='font-size:12px;'>
        <td align='right'>Status:</td>
        <td align='left'><select id='ag_status' disabled>
                                
                                <option value='0'>Inactive</option>
                                <option value='1'>Active</option>
                            </select></td>
        </tr>
        
        <tr align='center' style='font-size:12px; margin: 0px auto;'>
        <td colspan='3' align='center' border='0'>
<input type='hidden' name='hdn' id='hdn' value='$id'>        
<input type='button' name='Save' id='Save' value='Update' ></td>
        </tr>
          </table>";
         
}

?>


</html>
           