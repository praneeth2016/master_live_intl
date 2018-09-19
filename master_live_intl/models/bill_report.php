<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bill_report extends CI_Model {

    function __construct() {

        parent::__construct();
        $this->db1 = $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('forum', TRUE);
    }

    function displayReports($travel_id, $from, $to, $agentname, $agents1) {
        //echo $travel_id . " - " . $from . " - " . $to . " - " . $agentname. "-" . $agents1;
        //echo $from." - ".$to." - ".$agentname." - ".$agents;
        if ($agents1 == 'postpaid' || $agents1 == 'prepaid') {
            $agents = '2';
        } else {
            $agents = $agents1;
        }

        if ($travel_id == "all") {
            if ($agents == 'all') {
                $query = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and (status='Confirmed' || status='confirmed')");
            } else if ($agents == 'all' && $agentname == 'all') {
                $query = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and (status='Confirmed' || status='confirmed')");
            } else if ($agents == '4') {
                $query = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and (status='Confirmed' || status='confirmed') and operator_agent_type='4' and (agent_id is NULL or agent_id='') ");
            } else if ($agents == 'tg') {
                $query = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and (status='Confirmed' || status='confirmed') and operator_agent_type='3' and agent_id='125' ");
            } else if ($agents == 'tr') {
                $query = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and (status='Confirmed' || status='confirmed') and operator_agent_type='3' and agent_id='161' ");
            } else {
                if ($agents == 'te') {
                    if ($agentname == 'all') {
                        $query1 = $this->db->query("select DISTINCT agent_id from master_booking  INNER JOIN agents_operator ON master_booking.agent_id=agents_operator.id where (master_booking.jdate BETWEEN '" . $from . "' AND '" . $to . "') and (master_booking.status='Confirmed' || master_booking.status='confirmed') and master_booking.operator_agent_type='3' and agents_operator.api_type<>'op'");
                    } else {
                        $query1 = $this->db->query("select DISTINCT agent_id from master_booking  INNER JOIN agents_operator ON master_booking.agent_id=agents_operator.id where (master_booking.jdate BETWEEN '" . $from . "' AND '" . $to . "') and (master_booking.status='Confirmed' || master_booking.status='confirmed') and master_booking.operator_agent_type='3' and master_booking.agent_id='$agentname' and agents_operator.api_type<>'op'");
                    }
                } else {
                    if ($agents != 'all' && $agentname != 'all') {
                        $query1 = $this->db->query("select DISTINCT agent_id from master_booking  INNER JOIN agents_operator ON master_booking.agent_id=agents_operator.id where (master_booking.jdate BETWEEN '" . $from . "' AND '" . $to . "') and (master_booking.status='Confirmed' || master_booking.status='confirmed') and master_booking.operator_agent_type='$agents' and master_booking.agent_id='$agentname' and agents_operator.api_type<>'te'");
                    } else if ($agents != 'all' && $agentname == 'all') {
                        $query1 = $this->db->query("select DISTINCT agent_id from master_booking  INNER JOIN agents_operator ON master_booking.agent_id=agents_operator.id where (master_booking.jdate BETWEEN '" . $from . "' AND '" . $to . "') and (master_booking.status='Confirmed' || master_booking.status='confirmed') and 
master_booking.operator_agent_type='$agents' and agents_operator.api_type<>'te'");
                    }
                }
                if ($query1->num_rows() > 0) {
                    foreach ($query1->result() as $value) {
                        $agent_id = $value->agent_id;
                        //echo $agent_id."<br />"; 
                        $query2 = $this->db->query("select * from agents_operator where id='$agent_id'");

                        if ($agents == "te") {
                            $agents = 3;
                        }

                        if ($travel_id == "all") {
                            $query3 = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and (status='Confirmed' || status='confirmed') and operator_agent_type='$agents' and agent_id='$agent_id'");
                        } else {
                            $query3 = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$travel_id' and (status='Confirmed' || status='confirmed') and operator_agent_type='$agents' and agent_id='$agent_id'");
                        }
                        if ($query3->num_rows() > 0) {
                            foreach ($query3->result() as $value) {
                                $operator = $value->travels;
                            }
                            foreach ($query2->result() as $val) {
                                $name = $val->name;
                                $margin = $val->margin;                                
                                //for print data
                                echo '<script>
						function printBooking()
  						{
    						var printButton = document.getElementById("printpagebutton");
       						printButton.style.visibility = "hidden";
        					window.print()
							printButton.style.visibility = "visible";

  						}
						</script>';
                                echo '<div style="background-color:#f2f2f2;"> <b>End Users booking list</b></div>';
                                echo '<table width="100%" id="tbl" style="border:#f2f2f2 solid 2px; border-collapse:collapse;">';
                                echo '<tr><td colspan="2" style="font-size:14px;">Agent name:</td><td  colspan="10" style="font-size:14px;"> ' . $name . '<!--span style="padding-left:10px">Operator : ' . $operator . '</span--></td></tr>
        <tr style="font-size:14px;border:#f2f2f2 solid 1px;">
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">S.No</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Ticket No</th>
		<th style="font-size:14px;border:#f2f2f2 solid 1px;">Service No</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Journey Date</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Booking Date</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Source</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Destination</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Seat Nos.</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Passenger Details</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Ticket Amount</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Comm.</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Net Fare</th>
        </tr>';
                                $tkt_amt = 0;
                                $com = 0;
                                $net = 0;
                                $seats = 0;
                                $i = 1;

                                foreach ($query3->result() as $value) {
                                    $jour_date = $value->jdate;
                                    $ex1 = explode("-", $jour_date);
                                    $jdate = $ex1[2] . "-" . $ex1[1] . "-" . $ex1[0];
                                    $book_date = $value->bdate;
                                    $ex2 = explode("-", $book_date);
                                    $bdate = $ex2[2] . "-" . $ex2[1] . "-" . $ex2[0];
                                    $seats = $seats + $value->pass;
                                    $tkt_amt = round($tkt_amt + $value->tkt_fare, 2);

                                    if ($agent_id == '12' || $agent_id == '15' || $agent_id == '125' || $agent_id == '144' || $agent_id == '161' || $agent_id == '204') {
                                        $comm = (($value->tkt_fare) * 12) / 100;
                                        $tf = ($value->tkt_fare) - $comm;
                                        $net = round($net + $tf, 2);
                                    } else {
                                        /*$net = round($net + $value->paid, 2);

                                        if ($value->paid != '')
                                            $tf = round($value->paid, 2);
                                        else
                                            $tf = round($value->tkt_fare, 2);

                                        if ($value->save == '') {
                                            $comm = 0;
                                        } else {
                                            $comm = round($value->tkt_fare - $tf, 2);
                                        }*/
                                        $comm = (($value->tkt_fare) * $margin) / 100;
                                        $tf = ($value->tkt_fare) - $comm;
                                        $net = round($net + $tf, 2);
                                    }
                                    $com = round($com + $comm, 2);
                                    echo "<tr>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $i</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->tkt_no</td>
		<td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->service_no</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $jdate</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $bdate</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->source</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->dest</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->seats<br/> 
             $value->pass Seats</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->pname<br/> 
             $value->pmobile</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'>$value->tkt_fare</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'>$comm</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $tf</td>
        </tr>";
                                    $i++;
                                }
                                echo "<tr>
        <td  align='right' colspan='9' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>Totals</b></td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>$tkt_amt</b></td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>$com</b></td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>$net</b></td>
        </tr>";
                                echo "<tr>
        <td  align='right' colspan='3' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>Total no. of Seats=$seats</b></td>
        <td  align='center' colspan='9' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>Total Booking amount=$net</b></td>
        </tr>";

                                echo "</table><br/>";
                                //cancellation                          

                                echo '<table width="100%" id="tbl" style="border:#f2f2f2 solid 2px;border-collapse:collapse;">
        <tr> 
        <td colspan="12" align="left" style="background-color:#f2f2f2; color:#000000;margin-left: 140px">
        <b>Ticket Cancellation List</b></td></tr>';

                                if ($travel_id == "all") {
                                    $query4 = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and status='cancelled' and (agent_id='$agent_id' )");
                                } else {
                                    $query4 = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$travel_id' and status='cancelled' and (agent_id='$agent_id' )");
                                }
                                echo '<tr>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">S.No</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Ticket No</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Journey Date</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Booking Date</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Source</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Destination</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Seat Nos.</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Passenger Details</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Fare(A)</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Cancel Amount(.Rs)(B)</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Commission(.Rs)(C)</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;"> Net Amounts D=A-(B+C)</th>
        </tr>';
                                $can_seats = 0;
                                $commission = 0;
                                $net_can = 0;
                                $fare = 0;
                                $netamt = 0;
                                $j = 1;

                                foreach ($query4->result() as $value) {
                                    $jour_date = $value->jdate;
                                    $ex1 = explode("-", $jour_date);
                                    $jdate = $ex1[2] . "-" . $ex1[1] . "-" . $ex1[0];
                                    $can_date = $value->cdate;
                                    $ex2 = explode("-", $can_date);
                                    $cdate = $ex2[2] . "-" . $ex2[1] . "-" . $ex2[0];
                                    $refund = round($value->tkt_fare - $value->camt, 2);
                                    $can_seats = $can_seats + $value->pass;
                                    $fare = $fare + $value->tkt_fare;
                                    $cancellamout = round($value->camt, 2);

                                    //changing cancellation amount if api agent redbus or abhibus
                                    $agent_type = $value->operator_agent_type;
                                    $agent_id = $value->agent_id;
                                    $sql = $this->db->query("select api_type,margin from agents_operator where id='$agent_id'")or die(mysql_error());
                                    foreach ($sql->result() as $rows) {
                                        $api_type = $rows->api_type;
                                        $margin = $rows->margin;
                                    }

                                    if ($agent_type == 3 && $api_type == 'op') {
                                        $cancellamout1 = round($cancellamout / 2, 2);
                                        $net_can = round($net_can + $cancellamout1, 2);
                                    } else {
                                        $cancellamout1 = round($cancellamout, 2);
                                        $net_can = round($net_can + $value->camt, 2);
                                    }

                                    if ($agent_id == '12' || $agent_id == '15' || $agent_id == '125' || $agent_id == '144' || $agent_id == '161' || $agent_id == '204') {
                                        $commm = round((($value->tkt_fare) * 12) / 100, 2);
                                    } else {
                                        /*if ($value->save == '') {
                                            $commm = 0;
                                        } else {
                                            $commm = round($value->tkt_fare - $value->paid, 2);
                                        }*/
                                        $commm = round((($value->tkt_fare) * $margin) / 100, 2);
                                    }

                                    $netamt = 0;

                                    $netamt1 = round($value->tkt_fare - ($cancellamout1 + $commm), 2);
                                    $commission = round($commission + ($commm), 2);
                                    $netamt = round($fare - ($net_can + $commission), 2);

                                    echo "<tr>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'>$j</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->tkt_no</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $jdate</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $cdate</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->source</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->dest</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->pass </td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->pname<br/> 
             $value->pmobile</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->tkt_fare</td>
             <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $cancellamout1</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $commm</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $netamt1</td>
        </tr>";
                                    $j++;
                                }
                                echo "<tr>
        <td  align='right' colspan='8' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>Totals</b></td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>$fare</b></td>
            <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>$net_can</b></td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>$commission</b></td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>$netamt</b></td>
        </tr>";

                                echo "<tr>
        <td  align='right' colspan='4' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>Total no. of Cancelled Seats = $can_seats</b></td>
        <td  align='center' colspan='9' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>Total Cancellation Amount = Rs. $netamt</b></td>
        </tr>";

                                echo "</table><br />";
                                $total = $seats - $can_seats;
                                $netam = round($net - $netamt, 2);
                                echo '<table width="100%" id="tbl">
             <tr>
                 <td align="center" colspan="11" style="color:red;font-size:14px"><b>Total Amount to be Paid: ' . $net . ' - ' . $netamt . ' = ' . $netam . '</b></td>';
                                echo "</table><br/><br/>";
                            }//for each $query2 result
                        }//if query3 num rows          	

                        echo '<table align="center" style="margin: 0px auto;">
        <tr align="center"><td>
        <input type="button" class="newsearchbtn" name="print" id="printpagebutton" value="Print" onClick="printBooking();">
        </td></tr>
        </table>';
                    }// for each query1 result
                }//if
                else {
                    //echo "else";
                    echo '<table align="center" style="margin: 0px auto;color:red">
        <tr align="center" style="color:red"><td>
       No Records Found on selected date
        </td></tr>
        </table>';
                }
            }
        } else {
            if ($agents == 'all') {
                $query = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$travel_id' and (status='Confirmed' || status='confirmed')");
            } else if ($agents == 'all' && $agentname == 'all') {
                $query = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$travel_id' and (status='Confirmed' || status='confirmed')");
            } else if ($agents == '4') {
                $query = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$travel_id' and (status='Confirmed' || status='confirmed') and operator_agent_type='4' and (agent_id is NULL or agent_id='') ");
            } else if ($agents == 'tg') {
                $query = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$travel_id' and (status='Confirmed' || status='confirmed') and operator_agent_type='3' and agent_id='125' ");
            } else if ($agents == 'tr') {
                $query = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$travel_id' and (status='Confirmed' || status='confirmed') and operator_agent_type='3' and agent_id='161' ");
            }
            /* else if($agents == 'te')
              {
              $query=$this->db->query("select * from master_booking where (jdate BETWEEN '".$from."' AND '".$to."') and travel_id='$travel_id' and (status='Confirmed' || status='confirmed') and operator_agent_type='3' and (agent_id='12' || agent_id='15' || agent_id='125' || agent_id='144' || agent_id='161' || agent_id='204')");
              } */ else {
                if ($agents == 'te') {
                    if ($agentname == 'all') {
                        $query1 = $this->db->query("select DISTINCT agent_id from master_booking  INNER JOIN agents_operator ON master_booking.agent_id=agents_operator.id where (master_booking.jdate BETWEEN '" . $from . "' AND '" . $to . "') and (master_booking.status='Confirmed' || master_booking.status='confirmed') and master_booking.operator_agent_type='3' and agents_operator.api_type<>'op'");
                    } else {
                        $query1 = $this->db->query("select DISTINCT agent_id from master_booking  INNER JOIN agents_operator ON master_booking.agent_id=agents_operator.id where (master_booking.jdate BETWEEN '" . $from . "' AND '" . $to . "') and (master_booking.status='Confirmed' || master_booking.status='confirmed') and master_booking.operator_agent_type='3' and master_booking.agent_id='$agentname' and agents_operator.api_type<>'op'");
                    }
                } else {
                    if ($agents != 'all' && $agentname != 'all') {
                        $query1 = $this->db->query("select DISTINCT agent_id from master_booking  INNER JOIN agents_operator ON master_booking.agent_id=agents_operator.id where (master_booking.jdate BETWEEN '" . $from . "' AND '" . $to . "') and                master_booking.travel_id='$travel_id' and (master_booking.status='Confirmed' || master_booking.status='confirmed') and master_booking.operator_agent_type='$agents' and master_booking.agent_id='$agentname' and agents_operator.api_type<>'te'");
                    } else if ($agents != 'all' && $agentname == 'all') {
                        $query1 = $this->db->query("select DISTINCT agent_id from master_booking  INNER JOIN agents_operator ON master_booking.agent_id=agents_operator.id where (master_booking.jdate BETWEEN '" . $from . "' AND '" . $to . "') and               master_booking.travel_id='$travel_id' and (master_booking.status='Confirmed' || master_booking.status='confirmed') and 
master_booking.operator_agent_type='$agents' and agents_operator.api_type<>'te'");
                    }
                }
                if ($query1->num_rows() > 0) {
                    foreach ($query1->result() as $value) {
                        $agent_id = $value->agent_id;
                        //echo $agent_id."<br />";          

                        $query2 = $this->db->query("select * from agents_operator where id='$agent_id'");
                        if ($agents == "te") {
                            $agents = 3;
                        }
                        if ($travel_id == "all") {
                            $query3 = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and (status='Confirmed' || status='confirmed') and operator_agent_type='$agents' and agent_id='$agent_id'");
                        } else {
                            $query3 = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$travel_id' and (status='Confirmed' || status='confirmed') and operator_agent_type='$agents' and agent_id='$agent_id'");
                        }
                        if ($query3->num_rows() > 0) {
                            foreach ($query3->result() as $value) {
                                $operator = $value->travels;
                            }
                            foreach ($query2->result() as $val) {
                                $name = $val->name;
                                $margin = $val->margin;

                                //for print data
                                echo '<script>
						function printBooking()
  						{
    						var printButton = document.getElementById("printpagebutton");
       						printButton.style.visibility = "hidden";
        					window.print()
							printButton.style.visibility = "visible";

  						}
						</script>';
                                echo '<div style="background-color:#f2f2f2;"> <b>End Users booking list</b></div>';
                                echo '<table width="100%" id="tbl" style="border:#f2f2f2 solid 2px; border-collapse:collapse;">';
                                echo '<tr><td colspan="2" style="font-size:14px;">Agent name:</td><td  colspan="10" style="font-size:14px;">' . $name . '<!--span style="padding-left:10px">Operator : ' . $operator . '</span--></td></tr>
        <tr style="font-size:14px;border:#f2f2f2 solid 1px;">
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">S.No</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Ticket No</th>
		<th style="font-size:14px;border:#f2f2f2 solid 1px;">Service No</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Journey Date</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Booking Date</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Source</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Destination</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Seat Nos.</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Passenger Details</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Ticket Amount</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Comm.</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Net Fare</th>
        </tr>';
                                $tkt_amt = 0;
                                $com = 0;
                                $net = 0;
                                $seats = 0;
                                $i = 1;

                                foreach ($query3->result() as $value) {
                                    $jour_date = $value->jdate;
                                    $ex1 = explode("-", $jour_date);
                                    $jdate = $ex1[2] . "-" . $ex1[1] . "-" . $ex1[0];
                                    $book_date = $value->bdate;
                                    $ex2 = explode("-", $book_date);
                                    $bdate = $ex2[2] . "-" . $ex2[1] . "-" . $ex2[0];
                                    $seats = $seats + $value->pass;
                                    $tkt_amt = round($tkt_amt + $value->tkt_fare, 2);

                                    if ($agent_id == '12' || $agent_id == '15' || $agent_id == '125' || $agent_id == '144' || $agent_id == '161' || $agent_id == '204') {
                                        $comm = (($value->tkt_fare) * 12) / 100;
                                        $tf = ($value->tkt_fare) - $comm;
                                        $net = round($net + $tf, 2);
                                    } else {
                                        /*$net = round($net + $value->paid, 2);

                                        if ($value->paid != '')
                                            $tf = round($value->paid, 2);
                                        else
                                            $tf = round($value->tkt_fare, 2);

                                        if ($value->save == '') {
                                            $comm = 0;
                                        } else {
                                            $comm = round($value->tkt_fare - $tf, 2);
                                        }*/
                                        $comm = (($value->tkt_fare) * $margin) / 100;
                                        $tf = ($value->tkt_fare) - $comm;
                                        $net = round($net + $tf, 2);
                                    }
                                    $com = round($com + $comm, 2);
                                    echo "<tr>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $i</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->tkt_no</td>
		<td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->service_no</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $jdate</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $bdate</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->source</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->dest</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->seats<br/> 
             $value->pass Seats</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->pname<br/> 
             $value->pmobile</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'>$value->tkt_fare</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'>$comm</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $tf</td>
        </tr>";
                                    $i++;
                                }
                                echo "<tr>
        <td  align='right' colspan='9' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>Totals</b></td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>$tkt_amt</b></td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>$com</b></td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>$net</b></td>
        </tr>";
                                echo "<tr>
        <td  align='right' colspan='3' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>Total no. of Seats=$seats</b></td>
        <td  align='center' colspan='9' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>Total Booking amount=$net</b></td>
        </tr>";

                                echo "</table><br/>";
                                //cancellation                          

                                echo '<table width="100%" id="tbl" style="border:#f2f2f2 solid 2px;border-collapse:collapse;">
        <tr> 
        <td colspan="12" align="left" style="background-color:#f2f2f2; color:#000000;margin-left: 140px">
        <b>Ticket Cancellation List</b></td></tr>';

                                if ($travel_id == "all") {
                                    $query4 = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and status='cancelled' and (agent_id='$agent_id' )");
                                } else {
                                    $query4 = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$travel_id' and status='cancelled' and (agent_id='$agent_id' )");
                                }
                                echo '<tr>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">S.No</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Ticket No</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Journey Date</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Booking Date</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Source</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Destination</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Seat Nos.</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Passenger Details</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Fare(A)</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Cancel Amount(.Rs)(B)</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;">Commission(.Rs)(C)</th>
        <th style="font-size:14px;border:#f2f2f2 solid 1px;"> Net Amounts D=A-(B+C)</th>
        </tr>';
                                $can_seats = 0;
                                $commission = 0;
                                $net_can = 0;
                                $fare = 0;
                                $netamt = 0;
                                $j = 1;

                                foreach ($query4->result() as $value) {
                                    $jour_date = $value->jdate;
                                    $ex1 = explode("-", $jour_date);
                                    $jdate = $ex1[2] . "-" . $ex1[1] . "-" . $ex1[0];
                                    $can_date = $value->cdate;
                                    $ex2 = explode("-", $can_date);
                                    $cdate = $ex2[2] . "-" . $ex2[1] . "-" . $ex2[0];
                                    $refund = round($value->tkt_fare - $value->camt, 2);
                                    $can_seats = $can_seats + $value->pass;
                                    $fare = $fare + $value->tkt_fare;
                                    $cancellamout = round($value->camt, 2);

                                    //changing cancellation amount if api agent redbus or abhibus
                                    $agent_type = $value->operator_agent_type;
                                    $agent_id = $value->agent_id;
                                    $sql = $this->db->query("select api_type,margin from agents_operator where id='$agent_id'")or die(mysql_error());
                                    foreach ($sql->result() as $rows) {
                                        $api_type = $rows->api_type;
                                        $margin = $rows->margin;
                                    }

                                    if ($agent_type == 3 && $api_type == 'op') {
                                        $cancellamout1 = round($cancellamout / 2, 2);
                                        $net_can = round($net_can + $cancellamout1, 2);
                                    } else {
                                        $cancellamout1 = round($cancellamout, 2);
                                        $net_can = round($net_can + $value->camt, 2);
                                    }

                                    if ($agent_id == '12' || $agent_id == '15' || $agent_id == '125' || $agent_id == '144' || $agent_id == '161' || $agent_id == '204') {
                                        $commm = round((($value->tkt_fare) * 12) / 100, 2);
                                    } else {
                                        /*if ($value->save == '') {
                                            $commm = 0;
                                        } else {
                                            $commm = round($value->tkt_fare - $value->paid, 2);
                                        }*/
                                        $commm = round((($value->tkt_fare) * $margin) / 100, 2);
                                    }

                                    $netamt = 0;

                                    $netamt1 = round($value->tkt_fare - ($cancellamout1 + $commm), 2);
                                    $commission = round($commission + ($commm), 2);
                                    $netamt = round($fare - ($net_can + $commission), 2);

                                    echo "<tr>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'>$j</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->tkt_no</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $jdate</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $cdate</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->source</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->dest</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->pass </td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->pname<br/> 
             $value->pmobile</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $value->tkt_fare</td>
             <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $cancellamout1</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $commm</td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'> $netamt1</td>
        </tr>";
                                    $j++;
                                }
                                echo "<tr>
        <td  align='right' colspan='8' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>Totals</b></td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>$fare</b></td>
            <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>$net_can</b></td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>$commission</b></td>
        <td align='center' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>$netamt</b></td>
        </tr>";

                                echo "<tr>
        <td  align='right' colspan='4' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>Total no. of Cancelled Seats = $can_seats</b></td>
        <td  align='center' colspan='9' style='font-size:14px;border:#f2f2f2 solid 1px;'><b>Total Cancellation Amount = Rs. $netamt</b></td>
        </tr>";

                                echo "</table><br />";
                                $total = $seats - $can_seats;
                                $netam = round($net - $netamt, 2);
                                echo '<table width="100%" id="tbl">
             <tr>
                 <td align="center" colspan="11" style="color:red;font-size:14px"><b>Total Amount to be Paid: ' . $net . ' - ' . $netamt . ' = ' . $netam . '</b></td>';
                                echo "</table><br/><br/>";
                            }//for each $query2 result
                        }//if query3 num rows          	

                        echo '<table align="center" style="margin: 0px auto;">
        <tr align="center"><td>
        <input type="button" class="newsearchbtn" name="print" id="printpagebutton" value="Print" onClick="printBooking();">
        </td></tr>
        </table>';
                    }// for each query1 result
                }//if
                else {
                    //echo "else";
                    echo '<table align="center" style="margin: 0px auto;color:red">
        <tr align="center" style="color:red"><td>
       No Records Found on selected date
        </td></tr>
        </table>';
                }
            }
        }
        //}
        return $query->result();
        //print_r($query->result());
    }

    function displayCanReports($travel_id, $from, $to, $agentname, $agents) {
        if ($travel_id == "all") {
            if ($agents == 'all') {
                $query1 = $this->db->query("select * from master_booking where ( jdate BETWEEN '" . $from . "' AND '" . $to . "') and status='cancelled'");
            } else if ($agents == 'all' && $agentname == 'all') {
                $query1 = $this->db->query("select * from master_booking where ( jdate BETWEEN '" . $from . "' AND '" . $to . "') and status='cancelled'");
            } else if ($agents == '4') {
                $query1 = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and (status='Cancelled' || status='cancelled') and operator_agent_type='4' and (agent_id is NULL or agent_id='')");
            } else if ($agents == 'tg') {
                $query1 = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and (status='Cancelled' || status='cancelled') and operator_agent_type='3' and agent_id='125'");
            } else if ($agents == 'tr') {
                $query1 = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and (status='Cancelled' || status='cancelled') and operator_agent_type='3' and agent_id='161'");
            } else if ($agents == "te") {
                $query1 = $this->db->query("select * from master_booking where 
           (jdate BETWEEN '" . $from . "' AND '" . $to . "') and (status='Cancelled' || status='cancelled') and operator_agent_type='3' and (agent_id='12' || agent_id='15' || agent_id='125' || agent_id='144' || agent_id='161' || agent_id='204')");
            } else {
                $query1 = $this->db->query("select * from master_booking INNER JOIN agents_operator ON master_booking.agent_id=agents_operator.id where ( master_booking.jdate BETWEEN '" . $from . "' AND '" . $to . "') and master_booking.status='cancelled' and (master_booking.agent_id='$agentname' )");
            }
        } else {
            if ($agents == 'all') {
                $query1 = $this->db->query("select * from master_booking where ( jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$travel_id' and status='cancelled'");
            } else if ($agents == 'all' && $agentname == 'all') {
                $query1 = $this->db->query("select * from master_booking where ( jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$travel_id' and status='cancelled'");
            } else if ($agents == '4') {
                $query1 = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$travel_id' and (status='Cancelled' || status='cancelled') and operator_agent_type='4' and (agent_id is NULL or agent_id='')");
            } else if ($agents == 'tg') {
                $query1 = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$travel_id' and (status='Cancelled' || status='cancelled') and operator_agent_type='3' and agent_id='125'");
            } else if ($agents == 'tr') {
                $query1 = $this->db->query("select * from master_booking where (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$travel_id' and (status='Cancelled' || status='cancelled') and operator_agent_type='3' and agent_id='161'");
            } else if ($agents == "te") {
                $query1 = $this->db->query("select * from master_booking where 
           (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$travel_id' and (status='Cancelled' || status='cancelled') and operator_agent_type='3' and (agent_id='12' || agent_id='15' || agent_id='125' || agent_id='144' || agent_id='161' || agent_id='204')");
            } else {
                $query1 = $this->db->query("select * from master_booking INNER JOIN agents_operator ON master_booking.agent_id=agents_operator.id where ( master_booking.jdate BETWEEN '" . $from . "' AND '" . $to . "') and master_booking.travel_id='$travel_id' and master_booking.status='cancelled' and (master_booking.agent_id='$agentname' )");
            }
        }
        return $query1->result();
    }

}

?>
