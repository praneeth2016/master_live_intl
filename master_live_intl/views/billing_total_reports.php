<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>operator</title>
<script type ="text/javascript" src="<?php echo base_url();?>js/datepicker/jquery-1.7.2.min.js"></script>
<style>
table
{
border-collapse:collapse;
}
table, td, th
{
border:#f2f2f2 solid 1px;
}
</style>
<style type="text\css" media="print">
  #myFooter, #myHeader
  {
    display: none;
  }
  </style>
<script>
function printBooking()
  {
 var printButton = document.getElementById("print");
 printButton.style.visibility = "hidden";
        window.print()
printButton.style.visibility = "visible";
  }
</script>
</head>
</html>
<div style="background-color:#f2f2f2; padding:10px;"> <b>End User's booking list</b></div>
<table width="100%" id="tbl" style="border:#f2f2f2 solid 2px;border-top: #f2f2f2 solid 5px">
        
        <tr>
        <th>S.No</th>
        <th>Ticket No</th>
		<th>Service No</th>
        <th>Journey Date</th>
        <th>Booking Date</th>
		<th>P.T</th>
        <th>Source</th>
        <th>Destination</th>
        <th>Seat Nos.</th>
        <th>Passenger Details</th>
        <th>Ticket Amount</th>
        <th>Comm.</th>
        <th>Net Fare</th>
        </tr>
        <?php		
       $tkt_amt=0;
       $com=0;
       $net=0;
       $seats=0;
       $i=1;
       foreach ($query as $value) {
           $agent_type=$value->operator_agent_type;
           $agent_id=$value->agent_id;		   
           $jour_date=$value->jdate;
           $ex1=  explode("-", $jour_date);
           $jdate=$ex1[2]."-".$ex1[1]."-".$ex1[0];
           $book_date=$value->bdate;
           $ex2=  explode("-", $book_date);
           $bdate=$ex2[2]."-".$ex2[1]."-".$ex2[0];
           $seats=$seats+$value->pass;
           
           $tkt_amt=round($tkt_amt+$value->tkt_fare,2);
          // $com=$com+$value->save;
           if($agent_id=='12' || $agent_id=='15' || $agent_id=='125' || $agent_id=='144' || $agent_id=='161' || $agent_id=='204')
           {
                $comm=(($value->tkt_fare)*12)/100;
                $tf=  ($value->tkt_fare)-$comm;
                $net=round($net+$tf,2);
           }
           else
           {
		   		
               $query2 = $this->db->query("select * from agents_operator where id='$agent_id'");			  
			   foreach($query2->result() as $row){
			   $margin = $row->margin;			  
			   }
				/*$net=round($net+$value->paid,2);
          
                if($value->paid!='')
                $tf=round($value->paid,2);
                else
                $tf=round($value->tkt_fare,2);
                if($value->save=='')
                {
                    $comm=0;
                }
                else
                {
                    $comm=round($value->tkt_fare-$tf,2);
                } */ 
				$comm=(($value->tkt_fare)* $margin)/100;
                $tf=  ($value->tkt_fare)-$comm;
                $net=round($net+$tf,2);
           }
           
           
		   $com=round($com+$comm,2);
        echo "<tr>
		
        <td align='center' style='font-size:14px;'> $i</td>
        <td align='center' style='font-size:14px;'> $value->tkt_no</td>
		<td align='center' style='font-size:14px;'> $value->service_no</td>
        <td align='center' style='font-size:14px;'> $jdate</td>
        <td align='center' style='font-size:14px;'> $bdate</td>
		<td align='center' style='font-size:14px;'> $value->pay</td>
        <td align='center' style='font-size:14px;'> $value->source</td>
        <td align='center' style='font-size:14px;'> $value->dest</td>
        <td align='center' style='font-size:14px;'> $value->seats<br/> 
             $value->pass Seats</td>
        <td align='center' style='font-size:14px;'> $value->pname<br/> 
             $value->pmobile</td>
        <td align='center' style='font-size:14px;'>$value->tkt_fare</td>
        <td align='center' style='font-size:14px;'>$comm</td>
        <td align='center' style='font-size:14px;'>$tf</td>
        </tr>";
        $i++;
        }
        echo "<tr>
        <td  align='right' colspan='9'><b>Totals</b></td>
        <td align='center'><b>$tkt_amt</b></td>
        <td align='center'><b>$com</b></td>
        <td align='center'><b>$net</b></td>
        </tr>";
        
        echo "<tr>
        <td  align='right' colspan='3'><b>Total no. of Seats=$seats</b></td>
        <td  align='center' colspan='9'><b>Total Collection Amount=Rs. $net</b></td>
        </tr>";
        
        echo "</table>";
     
?>
<br/>
<br/>

            <table width="100%" id="tbl" style="border:#f2f2f2 solid 2px;">
        <tr><th colspan='12' align="left" style="background-color:#f2f2f2; padding-left:10px;">
                <b>Ticket Cancellation List</b></th>
        <tr>
		<th>S.No</th>
        <th>Ticket No</th>
        <th>Journey Date</th>
        <th>Cancelled Date</th>
        <th>Source</th>
        <th>Destination</th>
        <th>No. of seats</th>
        <th>Passenger Details</th>
        <th> Fare(A)</th>
        <th>Cancel Amount(.Rs)(B)</th>
        <th>Commission(.Rs)(C)</th>
        <th> Net Amounts D=A-(B+C)</th>
        </tr>
        <?php
       
       $can_seats=0;
       $commission=0;
       $net_can=0;
       $fare=0;
       $j=1;
       $netamt=0; 
       foreach ($query1 as $value) {
           $agent_type=$value->operator_agent_type;
           $agent_id=$value->agent_id;
		   $sql = $this->db->query("select api_type from agents_operator where id='$agent_id'")or die(mysql_error());
			foreach ($sql->result() as $rows)
			{
		   		$api_type=$rows->api_type;
			}
           $jour_date=$value->jdate;
           $ex1=  explode("-", $jour_date);
           $jdate=$ex1[2]."-".$ex1[1]."-".$ex1[0];
           $can_date=$value->cdate;
           $ex2=  explode("-", $can_date);
           $cdate=$ex2[2]."-".$ex2[1]."-".$ex2[0];
           
           $refund=round($value->tkt_fare-$value->camt,2);
           $can_seats=$can_seats+$value->pass;
           $fare=$fare+$value->tkt_fare;
           /*  */
		   //changing cancellation amount if api agent redbus or abhibus
		  
		   $cancellamout=round($value->camt,2);
		   /*if($agent_type==3 && $api_type == 'op')
		   {*/	
		   		$cancellamout1=round($cancellamout/2,2);
		   		$net_can=round($net_can+$cancellamout1,2);
		   /*}
		   else
		   {
		   		$cancellamout1=round($cancellamout,2);
		   		$net_can=round($net_can+$value->camt,2);
		   }*/   
           if($agent_id=='12' || $agent_id=='15' || $agent_id=='125' || $agent_id=='144' || $agent_id=='161' || $agent_id=='204')
           {
                $commm= round((($value->tkt_fare)*12)/100,2);                
           }
           else
           {              
               if($value->save=='')
               {
                    $commm=0;
               }
               else
               {
                    $commm= round($value->tkt_fare-$value->paid,2);
               }               
           }          
           $netamt1=round($value->tkt_fare-($cancellamout1+$commm),2);
           $commission=round($commission+($commm),2);
           $netamt=round($fare-($net_can+$commission),2);
          
        echo "<tr>
        <td align='center' style='font-size:14px;'>$j</td>
        <td align='center' style='font-size:14px;'> $value->tkt_no</td>
        <td align='center' style='font-size:14px;'> $jdate</td>
        <td align='center' style='font-size:14px;'> $cdate</td>
        <td align='center' style='font-size:14px;'> $value->source</td>
        <td align='center' style='font-size:14px;'> $value->dest</td>
        <td align='center' style='font-size:14px;'> $value->pass </td>
        <td align='center' style='font-size:14px;'> $value->pname<br/> 
             $value->pmobile</td>
        <td align='center' style='font-size:14px;'> $value->tkt_fare</td>
             <td align='center' style='font-size:14px;'>$cancellamout1 </td>
        <td align='center' style='font-size:14px;'> $commm</td>
        <td align='center' style='font-size:14px;'> $netamt1</td>
        </tr>";
        $j++;
        }
        echo "<tr>
        <td  align='right' colspan='8'><b>Totals</b></td>
        <td align='center'><b>$fare</b></td>
            <td align='center'><b>$net_can</b></td>
        <td align='center'><b>$commission</b></td>
        <td align='center'><b>$netamt</b></td>
        </tr>";
        
        echo "<tr>
        <td  align='right' colspan='4'><b>Total no. of Cancelled Seats = $can_seats</b></td>
        <td  align='center' colspan='9'><b>Total Cancellation Amount = Rs. $netamt</b></td>
        </tr>";
       $totalamt=round($net- $netamt,2);
        echo "<tr>
        <td  align='center' colspan='12' style='color:red;font-size:14px'><b>Total amount = $net - ($netamt) = $totalamt</b></td>
        </tr>";
        
        
        
        echo "</table><br /><br />";
        
        /*echo '<table align="center" style="margin: 0px auto;">
        <tr align="center"><td><input  type="button" class="newsearchbtn" name="print" id="print" value="Print" onClick="printBooking();"></td></tr>
        </table>';*/

         echo '<div align="center"><input  type="button" class="newsearchbtn" name="print" id="print" value="Print" onClick="printBooking();"></div>';
     
?>