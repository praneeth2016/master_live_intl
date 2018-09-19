<?php
foreach ($query1->result() as $value) {
    $refno = $value->refno;
    $travel_id = $value->travel_id;
    
    $res = $this->db->query("select * from master_booking where refno='$refno'")or die(mysql_error());
    if ($res->num_rows() > 0) {		
        $rows = $res->row();
        $refno = $rows->refno;
        $status = $rows->status;
        $tkt_no = $rows->tkt_no;
        $pnr = $rows->pnr;
        $service_no = $rows->service_no;
        $bdate = $rows->bdate;
        $jdate = $rows->jdate;
        $source = $rows->source;
        $dest = $rows->dest;
        $travels = $rows->travels;
        $bus_type = $rows->bus_type;        
        $pass = $rows->pass;
        $seats = $rows->seats;
        $start_time = $rows->start_time;
        $board_point = $rows->board_point;
        $land_mark = $rows->land_mark;
        $tkt_fare = $rows->tkt_fare;
        $promo_code = $rows->promo_code;
        $save = $rows->save;
        $paid = $rows->paid;
        $ip = $rows->ip;
        $pname = $rows->pname;
        $pmobile = $rows->pmobile;
        $pemail = $rows->pemail;
        $padd = $rows->padd;
        $alter_ph = $rows->alter_ph;
        $gender = $rows->gender;
        $age = $rows->age;        
    } else {	
        $refno = $value->refno;
        $status = 'Not confirmed';
        $tkt_no = $value->tkt_no;
        $pnr = $value->pnr;
        $service_no = $value->service_no;
        $bdate = $value->bdate;
        $jdate = $value->jdate;
        $source = $value->source;
        $dest = $value->dest;
        $travels = $value->travels;
        $bus_type = $value->bus_type;        
        $pass = $value->pass;
        $seats = $value->seatno;
        $start_time = $value->start_time;
        $board_point = $value->brdpt;
        $land_mark = $value->lm;
        $tkt_fare = $value->tkt_fare;
        $promo_code = $value->promo_code;
        $save = $value->save;
        $paid = $value->paid;
        $ip = $value->ip;
        $pname = $value->custname;
        $pmobile = $value->mobile;
        $pemail = $value->email;
        $padd = $value->address;
        $alter_ph = $value->altph;
        $gender = $value->pgen;
        $age = $value->age;
    }

    $res1 = $this->db->query("select * from registered_operators where travel_id='$travel_id'")or die(mysql_error());

    $rows1 = $res1->row();
    $travel_name = $rows1->operator_title;
    
    echo '<table width="563" border="0" cellpadding="0" cellspacing="0" style="border: #666666 solid 1px" align="center">
   <tr style="background-color:#e6f0f3" >
      <td height="30" colspan="3" align="center" style="padding-right:15px;color:#990000">
        <strong>
        Journey Details
        </strong>
      </td>
  </tr>
  <tr>
     <td width="256" height="30" align="right" style="padding-right:15px"><strong>Reference Number</strong></td>
     <td width="7">:</td>
     <td width="298" align="left" style="padding-left:15px">' . $refno . '</td>
  </tr>
  <tr >
     <td height="30" align="right" style="padding-right:15px; "><strong>Ticket Status</strong></td>
     <td>:</td>
     <td align="left" style="padding-left:15px">' . $status . '</td>
  </tr>
  <tr>
    <td height="30" align="right" style="padding-right:15px"><strong>Ticket Number</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $tkt_no . '</td>
   </tr>
   <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>PNR Number</strong> </td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $pnr . '</td>
   </tr>
   <tr>
    <td height="30" align="right" style="padding-right:15px"><strong>Service Number</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $service_no . '</td>
   </tr>
   <tr >
    <td height="30" align="right" style="padding-right:15px"> <strong>Bookind Date</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $bdate . '</td>
   </tr>
   <tr>
    <td height="30" align="right"><strong>Journey Date&nbsp;</strong>&nbsp;&nbsp;&nbsp;&nbsp; </td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $jdate . '</td>
   </tr>
   <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>Source</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $source . '</td>
   </tr>
   <tr >
    <td height="30" align="right"  style="padding-right:15px"><strong>Destination</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $dest . '</td>
   </tr>
   <tr>
    <td height="30" align="right" style="padding-right:15px"><strong>Travel Name</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $travel_name . '</td>
    </tr>
    <tr>
   <tr>
    <td height="30" align="right" style="padding-right:15px"><strong>Bus Type</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $bus_type . '</td>
    </tr>
    <tr>
    <td height="30" align="right" style="padding-right:15px"><strong>No.of Passengers</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $pass . '</td>
    </tr>
    <tr>
    <td height="30" align="right" style="padding-right:15px"><strong>Seat Numbers</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $seats . '</td>
    </tr>
    <tr>
    <td height="30" align="right" style="padding-right:15px"><strong>Starting Time</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $start_time . '</td>
    </tr>
    <td height="30" align="right" style="padding-right:15px"><strong>Boarding Point</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $board_point . '</td>
    </tr>
    <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>Land Mark</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $land_mark . '</td>
    </tr>
    <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>Ticket Fare</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $tkt_fare . '</td>
    </tr>
    <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>Promo Code</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $promo_code . '</td>
    </tr>
    <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>Saved Fare</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $save . '</td>

    </tr>
    <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>Paid Fare</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $paid . '</td></tr>
    </tr>
    <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>IP Address</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $ip . '</td></tr>
    
    </tr>
    <tr style="background-color:#e6f0f3" >
    <td height="30" colspan="3" align="center" style="padding-right:15px;color:#990000"><strong>Passenger Deatils</strong></td>
    </tr>
    <tr >
    <td height="30" align="right"  style="padding-right:15px"><strong> Name</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $pname . '</td>
    </tr>
    <tr >
    <td height="30" align="right" style="padding-right:15px"><strong> Mobile</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $pmobile . '</td>
    </tr>
    <tr >
    <td height="30" align="right"  style="padding-right:15px"><strong> Email</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $pemail . '</td>
    </tr>
    <tr >
    <td height="30" align="right" style="padding-right:15px"><strong> Address</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $padd . '</td>
    </tr>
    <tr >
    <td height="30" align="right"  style="padding-right:15px"><strong> Alternate Num</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $alter_ph . '</td>
    </tr>
    <tr >
    <td height="30" align="right" style="padding-right:15px"><strong>Gender</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $gender . '</td>
    </tr>
    <tr >
    <td height="30" align="right"  style="padding-right:15px"><strong>Age</strong></td>
    <td>:</td>
    <td align="left" style="padding-left:15px">' . $age . '</td>
    </tr>
    </table>';
}
?>