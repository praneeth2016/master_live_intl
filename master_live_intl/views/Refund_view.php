<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>operator</title>
<script type ="text/javascript" src="<?php echo base_url();?>js/datepicker/jquery-1.7.2.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" media="screen" />
<style>
.bg {background-color:#ffffff;
font-family: Arial, Helvetica, sans-serif; font-size:12px;
}
.bg1 {background-color:#eff3f5;
font-family: Arial, Helvetica, sans-serif; font-size:12px;
}

.bg:hover {background-color:#cfeeff;
font-family: Arial, Helvetica, sans-serif; font-size:12px;
}
.bg1:hover {background-color:#cfeeff;
font-family: Arial, Helvetica, sans-serif; font-size:12px;
}
</style>

<script>
function searchData(){
    var data=$('#search').val();
    var cnt=$('#cnt').val();
    if(data==""){
        alert("enter search data");
        $('#search').focus();
        return false;
    }
    else{
    $.post('refundCancelAmount',{data:data,cnt:cnt},function(res){
        //alert(res);
      $('#result').html(res);  
       $('#tbl').hide();  
     
    });
    }
    }
function doRefund(k){
//alert(k);
var amt=$('#amt'+k).val();
var rem=$('#rem'+k).val();
var ser=$('#ser'+k).val();
var tra=$('#tra'+k).val();
var ticket=$('#tik'+k).val();
if(amt=='')
    {
        alert("kindly enter refund amount");
        $('#amt'+k).focus();
        return false;
    }
else{
    $.post('do_amountRefund',{amt:amt,rem:rem,ser:ser,tra:tra,ticket:ticket},function(res){
   // alert(res)
        if(res==1)
        {
            alert("refunded");
            setTimeout('window.location="refundCancelAmount"',500);
        }
        else{
            alert("not refunded"); 
        }
    });
}
}


</script>
<script>
function showRefundForm(j){
     
$.post('showRefundFormdata',{j:j},function(res){
   for(var g=1;g<j;g++)
    {
         $('#sh'+g).html('');
     }
     
   $('#sh'+g).html(res); 
   
});
 
}
</script>
</head>
</html>
<?php
echo '<table width="750" border=""  >';
if($data==''){
echo ' <tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; 
                       border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; 
                       border-left:#f2f2f2 solid 1px;">
        <td><input type="text" id="search" name="search" style=""><input type="button" value="Search" onclick="searchData()" id="bt"></td></tr></table>';
}if($query1->num_rows()==0){
    echo '<table border="0" id="tbl" align="center">
        <tr style="color:red; font-weight:bold; font-size:14px;" align="center">
        <td>No Records Found </td></table>';
} 
else {
   
echo '<table width="750" border="1" id="tbl">
    <tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; 
                       border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; 
                       border-left:#f2f2f2 solid 1px;">
        <th>S.No</th>
         <th>Service No.</th>
       <th>Agent Name</th>
        <th>Ticket No</th>
        <th>Mobile</th>
       <th>Source</th>
        <th>Destination</th>
        <th>Journey Date</th>
        <th> status</th>
        <th>Fare</th>
        </tr>';
  if($k==0)
      $i=1;
  else
      $i=$k;
       foreach ($query1->result() as $value) {
       $this->db2 = $this->load->database('forum', TRUE);   
       $status=$value->status;
       $is_refund=$value->is_refunded;
       if(($status=='cancelled' || $status=='Cancelled') && ($is_refund=='NULL' || $is_refund==''))
           $status='Pending';
       $agtype=$value->operator_agent_type;
           $query1= $this->db2->query("select * from agents_operator where agent_type='$agtype'");
            foreach ($query1->result() as $value1) {
             $agname=$value1->name;   
            }
         $class = ($i%2 == 0)? 'bg': 'bg1'; 
        echo "<tr class=$class>
        <td align='center'>$i </td>
            <td align='center'> $value->service_no</td>
       <td align='center'> $agname</td>
        <td align='center'> $value->tkt_no</td>
             <td align='center'> $value->pmobile</td>
         <td align='center'> $value->source</td>
        <td align='center'> $value->dest</td>
        <td align='center'> $value->jdate</td>
       <td align='center'> <input type='button' value='$status' onclick='showRefundForm($i)'>
           <input type='hidden' value='$value->service_no' id='ser$i' name='ser$i'>
           <input type='hidden' value='$value->travel_id' id='tra$i' name='tra$i'>
               <input type='hidden' value='$value->tkt_no' id='tik$i' name='tik$i'></td>
        <td align='center'> $value->tkt_fare</td>
    </tr>";
        echo "<tr><td id='sh$i' colspan='10'></td></tr>";
       $i++;
  }
        echo "</table>";
        echo "<input type='hidden' id='cnt' value=$i>";
     echo "<span id='result'> </span>";
echo "<div class='pagination' style='text-align:center'>";
echo $links;
echo '</div>';
} 
?>