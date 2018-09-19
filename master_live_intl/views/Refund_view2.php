<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>operator</title>
        <script type ="text/javascript" src="<?php echo base_url(); ?>js/datepicker/jquery-1.7.2.min.js"></script>
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
            #fixed { table-layout:fixed; width:90px; word-break:break-all;}
        </style>

        <script>
            function searchData() {
                var data = $('#search').val();
                var cnt = $('#cnt').val();
                if (data == "") {
                    alert("enter search data");
                    $('#search').focus();
                    return false;
                }

                else {
                    // alert(cnt);
                    $.post('refundCancelAmount', {data: data, cnt: cnt}, function(res) {
                        //alert(res);
                        $('#result').html(res);
                        $('#tbl').hide();

                    });
                }
            }
           
        </script>
        <script>
            function showRefundForm(j) {
                var count=$('#cnt').val();
                var paid=$('#paid'+j).val();
                var ccharge=$('#ccharge'+j).val();
                var camt=$('#camt'+j).val();
                var refamt=$('#refamt'+j).val();
                
                $.post('showRefundFormdata', {j: j,paid:paid,ccharge:ccharge,camt:camt,refamt:refamt}, function(res) {
                    //alert(res);
              
              
                $('#sh'+j).html(res);

$('#sh'+j).show();
for(var i=1;i<count;i++)
{
$('#sh'+i).hide();
}
$('#sh'+j).show();
});


            }
            
             function doRefund(k) {
        //alert(k);
                var amt = $('#amt' + k).val();
                var rem = $('#rem' + k).val();
                var ser = $('#ser' + k).val();
                var tra = $('#tra' + k).val();
                var ticket = $('#tik' + k).val();
                var agid = $('#agid' + k).val();
                var pnr = $('#pnr' + k).val();
                if (amt == '')
                {
                    alert("Kindly enter refund amount");
                    $('#amt' + k).focus();
                    return false;
                }
                else {
                    $.post('do_amountRefund', {amt: amt, rem: rem, ser: ser, tra: tra, ticket: ticket, agid:agid, pnr:pnr}, function(res) {
                        alert(res);
                        if (res == 1)
                        {
                            alert("refunded");
                            setTimeout('window.location="refundCancelAmount"', 500);
                        }
                        else {
                            alert("");
                        }
                    });
                }
            }
           
         function doServiceRefund(k){
         //alert(k);
                var amt1 = $('#amtx'+ k).val();
                var ser1 = $('#ser'+ k).val();
                var tra1 = $('#tra'+ k).val();
                var ticket1 = $('#tik'+ k).val();
                var agid1 = $('#agid'+ k).val();
                var pnr1 = $('#pnr'+ k).val();
                
                    $.post('do_amountRefund', {amt: amt1, ser: ser1, tra: tra1, ticket: ticket1, agid:agid1, pnr:pnr1}, function(res) {
                       // alert(res);
                        if (res == 1)
                        {
                            confirm("Are you sure you want to refund money?");
                            alert("refunded");
                            
                            setTimeout('window.location="refundServiceCancel"', 500);
                            
                        }
                        else {
                            alert("Problem occured while refunding");
                        }
                    });
 
                
         }

        </script>
        <script>
            function showPassangerDetail(j)
	     {
            	var refno=$('#cnt'+j).val();
               	alert(refno);
                window.open('<?php echo base_url();?>index.php/master_control/show_Passanger_proceedDetail?refno='+refno);
             }
        </script>
    </head>
</html>
<?php
echo '<table width="76%" border=""  >';
if ($data == '')
{
    echo ' <tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; 
                       border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; 
                       border-left:#f2f2f2 solid 1px;">
        <td>Search :<input type="text" id="search" name="search" style=""><input type="button" value="Search" onclick="searchData()" id="bt"></td></tr></table>';
}
if ($query1->num_rows()==0)
{
	echo '<table border="0" id="tbl" align="center">
        <tr style="color:red; font-weight:bold; font-size:14px;" align="center">
        <td>No Records Found </td></table>';
}
else
{
       
	echo '<table width="76%"  id="tbl">
    <tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; 
                      ">
       <th width="65">Booking Time</th>
       <th width="120">Name</th>
       <th width="77">Mobile</th>
       <th width="60">Ticket No.</th>
       <th width="77">Ref.No</th>
       <th width="105" height="30">Source<br/>
             ( to) <br/>
       Destination</th>
       <th width="60">Travels</th>
       <th width="30">Fare</th>
       <th width="50">Status</th>
        </tr>';
    
	if ($k == 0)
        $i = 1;
    else
        $i = $k;
   
    foreach ($query1->result() as $value)
	{
    	$refund=$value->is_refunded;
      	$spno=$value->refno;
        $status = $value->status;
        //$is_refund = $value->refund_amount;
        
		if (($status == 'cancelled' || $status == 'Cancelled' || $status == 'Service cancelled') && $refund=='NULL')
		{
                   $status = 'Cancelled';
		}
		else if (($status == 'cancelled' || $status == 'Cancelled' || $status == 'Service cancelled') && $refund=='1')
		{
		   $status = 'Refunded';
		}
    	
		$class = ($i % 2 == 0) ? 'bg' : 'bg1';
        echo '<tr class="'.$class.'" id="fixed">
       <td align="center" style="font-size:12px;width:50px" > '.$value->time.'</td>
       <td align="center" style="font-size:12px;width:120px" > '.$value->pname.'</td>
       <td align="center" style="font-size:12px;width:95px" height="30px"> '.$value->pmobile.'</td>
       <td align="center" style="font-size:12px;width="60px" > '.$value->tkt_no.'</td>
       <td align="center" style="font-size:12px;width="77px" > 
       <a href="#" onclick="showPassangerDetail('.$i.')" style="color:blue;text-decoration:underline">'.$value->refno.'</a></td>
       <input type="hidden" id="cnt'.$i.'" value="'.$spno.'">
       <td align="center" style="font-size:12px;width="105px" >'. $value->source.' <br/>(To)<br/> '.$value->dest.'</td>
       <td align="center" style="font-size:12px;width="80px"> '.$value->travels.'</td>
       <td align="center" style="font-size:12px;width="60px" > '.$value->tkt_fare.'</td>
       <td align="center" style="font-size:12px;width="60px" > ';
        if($status == 'cancelled')
	   {
	       echo "<span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;' onclick='showRefundForm(".$i.")'>".$status."</span>";
	   }
           else
	   {
	   	   echo $status;
	   }
           echo '<input type="hidden" value="'.$value->service_no.'" id="ser'.$i.'" name="ser'.$i.'">       
                 <input type="hidden" value="'.$value->tkt_no.'" id="tik'.$i.'" name="tik'.$i.'">
                 <input type="hidden" value="'.$value->agent_id.'" id="agid'.$i.'" name="agid'.$i.'">        
                 <input type="hidden" value="'.$value->pnr.'" id="pnr'.$i.'" name="pnr'.$i.'">
                 <input type="hidden" value="'.$value->travel_id.'" id="tra'.$i.'" name="tra'.$i.'">
</td>            <input type="hidden" value="'.$value->paid.'" id="paid'.$i.'" name="paid'.$i.'">
                 <input type="hidden" value="'.$value->ccharge.'" id="ccharge'.$i.'" name="ccharge'.$i.'">        
                 <input type="hidden" value="'.$value->camt.'" id="camt'.$i.'" name="camt'.$i.'">
                 <input type="hidden" value="'.$value->refamt.'" id="refamt'.$i.'" name="refamt'.$i.'">
</td>
    </tr>
    <tr >
		<td colspan="10" style="font-size:14px; display:none" id="sh'.$i.'" align="center">
        </td></tr>';
        //echo "<tr><td id='sh$i' colspan='10'></td></tr>";
        $i++;
    }

    echo "</table>";
    ?>
   <input type='hidden' id='cnt' value='<?php echo $i ?>'>
    <?php
           echo "<span id='result'> </span>";
   
    echo "<div class='pagination' style='text-align:center'>";
    echo $links;
    echo '</div>';
}
?>