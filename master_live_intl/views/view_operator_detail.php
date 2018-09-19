<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operator's Detail</title>
<script type="text/javascript" src="<?php echo base_url("js/jquery-1.5.2.min.js");?>"></script>
    <h1 align='center' style='font-size:18px'>Operator's Detail</h1>

<script>
    $(document).ready(function(){
$('#btn').click(function(){
      var optitle=$('#optitle').val();
            var firm_type=$('#firm_type').val();
            var name=$('#name').val();
            var address=$('#address').val();
            var location=$('#location').val();
             var contact_no=$('#contact_no').val();
              var fax_no=$('#fax_no').val();
               var email_id=$('#email_id').val();
                var pan_no=$('#pan_no').val();
                 var bank_name=$('#bank_name').val();
                  var bank_account_no=$('#bank_account_no').val();
                   var branch=$('#branch').val();
                    var ifsc_code=$('#ifsc_code').val();
                     var travel_id=$('#travel_id').val();
                      var user_name=$('#user_name').val();
                      var bill_type=$('#bill_type').val();
                      var bill_amt=$('#bill_amt').val();
                       var id=$('#hd').val();
               
                       $.post('<?php echo site_url("master_control/operator_detail_update");?>',{optitle:optitle,firm_type:firm_type,name:name,address:address,location:location,contact_no:contact_no,fax_no:fax_no,email_id:email_id,pan_no:pan_no,bank_name:bank_name,
         bank_account_no:bank_account_no,branch:branch,ifsc_code:ifsc_code,travel_id:travel_id,user_name:user_name,bill_type:bill_type,bill_amt:bill_amt,id:id},function(res){
                          // alert(res);
                           
    if(res==1){
        
            alert("successfully updated");
            }else{
                 alert("not updated");
            }
         
                           
                       });
                 
});
});
</script>
</head>
<?php
echo "<table align='center' cellspacing='10px' style='margin: 0px auto;'>";

      foreach($query as $row)
          {
            
                echo "<tr>
                 <td style='font-size:12px';>Operator Title:</td>
                 <td style='font-size:12px';> <input type='text' id='optitle' name='optitle' value='$row->operator_title'> </td>
                 </tr>
                 <tr>
                 <td style='font-size:12px';>Firm Type:</td>
                 <td  style='font-size:12px';>  <input type='text' id='firm_type' name='firm_type' value='$row->firm_type'> </td>
                 </tr>
                 <tr style='font-size:12px';>
                 <td>Name:</td>
                 <td  style='font-size:12px';> <input type='text' id='name' name='name' value='$row->name'>  </td>
                 </tr>
                 <tr style='font-size:12px';>
                 <td style='font-size:12px';>Address:</td>
                 <td  style='font-size:12px';>  <input type='text' id='address' name='address' value='$row->address'> </td>
                 </tr>
                 <tr>
                 <td style='font-size:12px';>Location:</td>
                 <td  style='font-size:12px';>  <input type='text' id='location' name='location' value='$row->location'> </td>
                 </tr>
                 <tr>
                 <td style='font-size:12px';>Contact No:</td>
                 <td  style='font-size:12px';>  <input type='text' id='contact_no' name='contact_no' value='$row->contact_no'> </td>
                 </tr>
                 <tr>
                 <td style='font-size:12px';>Fax No:</td>
                 <td  style='font-size:12px';> <input type='text' id='fax_no' name='fax_no' value='$row->fax_no'> </td>
                 </tr>
                 <tr>
                 <td style='font-size:12px';>Email id:</td>
                 <td  style='font-size:12px';> <input type='text' id='email_id' name='email_id' value='$row->email_id'>  </td>
                 </tr>
                 <tr>
                 <td style='font-size:12px';>Pan No:</td>
                 <td  style='font-size:12px';><input type='text' id='pan_no' name='pan_no' value='$row->pan_no'>  </td>
                 </tr>
                 <tr>
                 <td style='font-size:12px';>Bank Name:</td>
                 <td  style='font-size:12px';> <input type='text' id='bank_name' name='bank_name' value='$row->bank_name'>  </td>
                 </tr>
                 <tr>
                 <td style='font-size:12px';>Bank account no:</td>
                 <td  style='font-size:12px';>  <input type='text' id='bank_account_no' name='bank_account_no' value='$row->bank_account_no'> </td>
                 </tr>
                 <tr>
                 <td style='font-size:12px';>Branch:</td>
                 <td  style='font-size:12px';>  <input type='text' id='branch' name='branch' value='$row->branch'> </td>
                 </tr>
                 <tr>
                 <td style='font-size:12px';>Ifsc Code:</td>
                 <td  style='font-size:12px';> <input type='text' id='ifsc_code' name='ifsc_code' value='$row->ifsc_code'>  </td>
                 </tr>
                 <tr>
                 <td style='font-size:12px';>Travel Id:</td>
                 <td  style='font-size:12px';> <input type='text' id='travel_id' name='travel_id' value='$row->travel_id'>  </td>
                 </tr>
                 <tr>
                 <td style='font-size:12px';>Username:</td>
                 <td  style='font-size:12px';> <input type='text' id='user_name' name='user_name' value='$row->user_name'>  </td>
                 </tr>
                  <tr>
                 <td style='font-size:12px';>Billed Type:</td>
                 <td  style='font-size:12px';> <input type='text' id='bill_type' name='bill_type' value='$row->bill_type'>  </td>
                 </tr>
                  <tr>
                 <td style='font-size:12px';>Billed Amount:</td>
                 <td  style='font-size:12px';> <input type='text' id='bill_amt' name='bill_amt' value='$row->bill_amt'>  </td>
                 </tr>
                 <tr>
                 <td><input type='hidden' id='hd' name='hd' value='$row->id'><input  type='button' id='btn' value='Update' />
                 </td>
                 </tr>";
           } 
        echo "</table>";   
 
?>
<span  id="rtst"> </span>
</html>