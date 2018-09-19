<?php
foreach ($query1->result() as $value) {
echo '<table width="563" border="0" cellpadding="0" cellspacing="0" style="border: #666666 solid 1px" align="center">
  <tr style="background-color:#e6f0f3" >
    <td height="30" colspan="3" align="center" style="padding-right:15px;color:#990000">
        <strong>Journey Deatils</strong></td>
  </tr>
  <tr>
    <td width="256" height="30" align="right" style="padding-right:15px"><strong>Reference Number</strong></td>
    <td width="7">:</td>
    <td width="298" align="left" style="padding-left:15px">'.$value->pnr.'</td>
  </tr>
   <tr >
    <td height="30" align="right" style="padding-right:15px; "><strong>Ticket Status</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->status.'</td>
  </tr>
   <tr>
    <td height="30" align="right" style="padding-right:15px"><strong>Ticket Number</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->tkt_no.'</td>
  </tr>
  <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>PNR Number</strong> </td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->pnr.'</td>
  </tr>
  <tr>
    <td height="30" align="right" style="padding-right:15px"><strong>Service Number</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->service_no.'</td>
  </tr>
  <tr >
    <td height="30" align="right" style="padding-right:15px"> <strong>Bookind Date</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->bdate.'</td>
  </tr>
  <tr>
    <td height="30" align="right"><strong>Journey Date&nbsp;</strong>&nbsp;&nbsp;&nbsp;&nbsp; </td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->jdate.'</td>
  </tr>
   <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>Source</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->source.'</td>
  </tr>
  <tr >
    <td height="30" align="right"  style="padding-right:15px"><strong>Destination</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->dest.'</td>
  </tr>
  <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>Travels Name</strong></td>
    <td>:</td>
    <td align="left"style="padding-left:15px">'.$value->travels.'</td>
  </tr>
  <tr>
    <td height="30" align="right" style="padding-right:15px"><strong>Bus Type</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->bus_model.'</td>
  </tr>
  <tr>
    <td height="30" align="right" style="padding-right:15px"><strong>No.of Passengers</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->pass.'</td>
  </tr>
  <tr>
    <td height="30" align="right" style="padding-right:15px"><strong>Seat Numbers</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->seats.'</td>
  </tr>
   <tr>
    <td height="30" align="right" style="padding-right:15px"><strong>Starting Time</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->start_time.'</td>
  </tr>
    <td height="30" align="right" style="padding-right:15px"><strong>Boarding Point</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->board_point.'</td>
  </tr>
  <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>Land Mark</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->land_mark.'</td>
  </tr>
  <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>Ticket Fare</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->tkt_fare.'</td>
  </tr>
   
  <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>Saved Fare</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->save.'</td>

  </tr>
  <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>Paid Fare</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->paid.'</td></tr>
    <tr >
   
    </tr>
  <tr style="background-color:#e6f0f3" >
    <td height="30" colspan="3" align="center" style="padding-right:15px;color:#990000"><strong>Passenger Deatils</strong></td>
  </tr>
  <tr >
    <td height="30" align="right"  style="padding-right:15px"><strong> Name</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->pname.'</td>
  </tr>
   <tr >
    <td height="30" align="right" style="padding-right:15px"><strong> Mobile</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->pmobile.'</td>
  </tr>
  <tr >
    <td height="30" align="right"  style="padding-right:15px"><strong> Email</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->pemail.'</td>
  </tr>
   <tr >
    <td height="30" align="right" style="padding-right:15px"><strong> Address</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->padd.'</td>
  </tr>
  <tr >
    <td height="30" align="right"  style="padding-right:15px"><strong> Alternate Num</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->alter_ph.'</td>
  </tr>
   <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>Gender</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->gender.'</td>
  </tr>
  <tr >
    <td height="30" align="right"  style="padding-right:15px"><strong>Age</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">'.$value->age.'</td>
  </tr>
</table>';
}
?>