<?php

class Quota_update_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function geAgentName($id,$travel_id) {
        
        $this->db->select("id,name");
        // $this->db->distinct();
        $this->db->order_by("name", "asc");
        $this->db->where("agent_type", $id);
        $this->db->where("operator_id", $travel_id);
        $query = $this->db->get("agents_operator");
        $data = array();
        //echo $query->num_rows();
        if ($query->num_rows() > 0) {
            //$data['all']='All';
            $data[''] = '--select--';
            foreach ($query->result() as $rows) {
                $data[$rows->id] = $rows->name;
            }
            return $data;
        } else {
            $data['0'] = '--select--';
            return $data;
        }
    }

//close busmodel()

    function getServicesList() {
        $travel_id = $this->session->userdata('travel_id');
        $srvno = $this->input->post('service');

        $this->db->distinct();
        $this->db->select('service_num');
        $this->db->where("travel_id", $travel_id);
        $query = $this->db->get("master_buses");

        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where("travel_id", $travel_id);
        $this->db->group_by("service_num", $query->result());
        //$this->db->group_by(array("service_num", $query->result())); 
        $query2 = $this->db->get("master_buses");

        return $query2->result();
    }

    //get service data for displaying quta details
    function getServicesListDetails() {

        $travel_id = $this->input->post('opid');
        $srvno = $this->input->post('service');

        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where("travel_id", $travel_id);
        $this->db->where("service_num", $srvno);
        $this->db->group_by("service_num");
        $query2 = $this->db->get("master_buses");
        $s = 1;

        if ($query2->num_rows() > 0) {
            echo ' <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  
                  <tr>
                    <td valign="top">

                    <table width="100%" border="0"  align="center">
  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    
  </tr>
  <tr style="font-weight:bold;">
    <td width="123" height="30" class="space">ServiceNumber</td>
    <td width="292"  class="space">Route</td>
    
    <td width="273"  class="space">BusType</td>
    <td width="85"  class="space">Departure</td>
    <td width="94" class="space" >Update Quota</td>
    <td width="82"  class="space">Show Quota</td>
  </tr>';
            foreach ($query2->result() as $row) {
                $travel_id = $row->travel_id;
                //$class = ($s%2 == 0)? 'bg': 'bg1';

                echo "<tr>
        
        <td  class='space' height='30'>" . $row->service_num . "</td>
        <td  class='space' height='30'>" . $row->service_route . "</td>
        <td  class='space' height='30'>" . $row->model . "</td>
        <td  class='space' height='30'>" . date('h:i A', strtotime($row->start_time)) . "</td>
        <td  class='space' height='30'><input type='button' class='newsearchbtn'name='uq" . $s . "' id='uq" . $s . "' value='Update Quota'  onClick='showLayout(\"" . $row->service_num . "\"," . $travel_id . "," . $s . ")'/></td>
        <td  class='space' height='30'><input type='button' class='newsearchbtn' value='View Quota' onClick='viewLayoutQuota(\"" . $row->service_num . "\"," . $travel_id . "," . $s . ")'/><input type='hidden' name='grab_seats' id='grab_seats' value='' />
        </td></tr>
        <tr>
        <td colspan='6' style='font-size:14px; display:none' id='trr" . $s . "' align='center'>
        </td></tr>";
            }
            echo '</table>
    <input type="hidden" id="hf" value="' . $s . '">
                  </td>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr> ';
        } else {
            echo 0;
        }
    }

    //get service data for displaying quta details  
    function getLayoutForQuotaDb($sernum, $travel_id, $s) {
        $travel_id = $travel_id;
        //query for getting seat_type
        $seat_name = '';
        $res_seats = '';
        $query = $this->db->query("select layout_id,seat_type from master_layouts where service_num='$sernum' and travel_id='$travel_id'  ");
        foreach ($query->result() as $r) {
            $layout_id = $r->layout_id;
            $seat_type = $r->seat_type;
            $lid = explode("#", $layout_id);
        }
        echo '<table width="100%" border="0" align="center" style="border:#f2f2f2 solid 0px;">
          ';
        echo'
     <tr>
      <td align="center">';
        if ($lid[1] == 'seater') {
            //getting max of row and col from master_layouts
            $sq = $this->db->query("select max(row) as mrow,max(col) as mcol from master_layouts where service_num='$sernum' and travel_id='$travel_id' ") or die(mysql_error());
            foreach ($sq->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }
            echo "<input type='hidden' name='mrow' id='mrow' value='$mrow' />
		<input type='hidden' name='mcol' id='mcol' value='$mcol' />";

            echo "<table border='0' cellpadding='10' cellspacing='4' align='center' >";

            for ($i = 1; $i <= $mcol; $i++) {
                echo "<tr>";
                for ($j = 1; $j <= $mrow; $j++) {
                    $sql3 = $this->db->query("select * from master_layouts where row='$j' and col='$i' and service_num='$sernum' and travel_id='$travel_id' ") or die(mysql_error());
                    $sql3->result();
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $seat_type = $row2->seat_type;
                        $available = $row2->available;
                        $seat_status = $row2->seat_status;
                    }
                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else { //if($available==1)
                        if (($available != 1 || $available != 2) && $seat_status == 0) {//available for booking
                            $id = "c$i$j";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" onclick="chkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';
                        }
                        if ($seat_status == 1) {
                            $ck = "<input type='checkbox' name='c$i$j' id='c$i$j' value='$seat_name' checked='checked'  disabled='disabled' />";
                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        if (($available == 1 || $available == 2) && $seat_status == 0) {
                            //$x=explode("#",$available_type);
                            $style = "style='background-color: #E4E4E4; width:20px'";
                            $id = "c$i$j";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" checked="checked" onclick="unchkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';

                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        echo "<td style='background-color: #E4E4E4;'>$seat_name$ck";

                        echo "</td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo '</table>
                               <tr>
    <td align="center">';
            echo '<table width="100%" border="0" id="chkd' . $s . '" style="font-size:12px; display:none;">
        <tr>
          <td height="27" align="center">&nbsp;</td>
            <td align="right">New Quota Seats are : </td>
            <td style="max-width:10px;" id="gb' . $s . '" align="left"></td>
          </tr>
          <tr>
            <td width="131" height="31" align="center">&nbsp;</td>
            <td width="230" align="center"><span id="updtspan' . $s . '" class="label">Kindly Select Agent Type to give the Quota :</span></td>
            <td width="200"><select class="inputfield" name="atype' . $s . '" id="atype' . $s . '" onChange="agentType(' . $s . ')">
              <option value="">--select--</option>
              <option value="1">Branch</option>
              <option value="2">Agent</option>
            </select></td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td ><span style="color:#000;display:none;" id="uqa' . $s . '" class="label">Select Agent Name TO Give  the Quota:</span>
     <span style="color:#000;display:none;" id="uqi' . $s . '" class="label">Select Branch Name to Update the Quota </span>   </td>
            <td> <span id="uqii' . $s . '"></span></td>
          </tr>
         <tr>
            <td colspan="3" align="center"><input type="hidden" id="res_seats' . $s . '" name="res_seats' . $s . '" value="' . $res_seats . '" />
            <input type="button" class="newsearchbtn" name="gbupdt' . $s . '" id="gbupdt' . $s . '" value="Save Changes" onClick="quotaUpdate(\'' . $sernum . '\',' . $travel_id . ',' . $s . ',1)"></td>
          </tr>
        </table>

<table width="100%" border="0" id="unchkd' . $s . '" style="font-size:12px;  display:none;">
        <tr>
            <td width="137" height="31" align="right">&nbsp;</td>
            <td width="162" align="left">Quota Removing Seats are : </td>
            <td width="280" align="left" style="max-width:10px;" id="rl' . $s . '"></td>
  </tr>
         <tr>
		 <td height="34"></td>
            <td align="right"><input type="button" class="newsearchbtn" name="rlupdt' . $s . '" id="rlupdt' . $s . '" value="Save Changes" onclick="quotaUpdate(\'' . $sernum . '\',' . $travel_id . ',' . $s . ',2)" /></td>
            <td colspan="1" align="left"><input type="hidden" id="res_seats' . $s . '" name="res_seats' . $s . '" value="' . $res_seats . '" /></td>
          </tr>
        </table>
</td>
  </tr>
  <tr>
    <td align="center">
    <span id="updtspan' . $s . '"  style="font-size:12; font-weight:normal;"></span></td>
  </tr>
  </td>
  </tr>
</table>';
        }
        else if ($lid[1] == 'sleeper') {
            //getting max of row and col from master_layouts
            //UpperDeck
            $sq2 = $this->db->query("select max(row) as mrow,max(col) as mcol from master_layouts where service_num='$sernum' and travel_id='$travel_id' and seat_type='U' ");
            foreach ($sq2->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }
            echo "<span style='font-size:14px; font-weight:bold;'>UpperDeck</span> <br/>";
            echo "<table border='0' cellpadding='10' cellspacing='4'>";
            for ($k = 1; $k <= $mcol; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mrow; $l++) {
                    $sq3 = $this->db->query("select * from master_layouts where row='$l' and col='$k' and service_num='$sernum' and travel_id='$travel_id' and seat_type='U' ");
                    foreach ($sq3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $seat_type = $row2->seat_type;
                        $available = $row2->available;
                        $seat_status = $row2->seat_status;
                    }
                    if ($seat_name == '') {
                        echo "<td style='border:none;'>&nbsp;</td>";
                    } else { //if($available==1)
                        if (($available != 1 || $available != 2) && $seat_status == 0) {//available for booking
                            $id = "cu$k$l";

                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" onclick="chkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';
                        }
                        if ($seat_status == 1) {
                            $ck = "<input type='checkbox' name='cu$k$l' id='cu$k$l' value='$seat_name' checked='checked'  disabled='disabled' />";
                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        if (($available == 1 || $available == 2) && $seat_status == 0) {
                            //$x=explode("#",$available_type);
                            $style = "style='background-color: #E4E4E4; width:20px'";
                            $id = "cu$k$l";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" checked="checked" onclick="unchkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';

                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        echo "<td style='background-color: #E4E4E4;'>$seat_name$ck";

                        echo "</td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo "</table><br/>";


            // Lower Deck
            $sq4 = $this->db->query("select max(row) as mroww,max(col) as mcoll from master_layouts where service_num='$sernum' and travel_id='$travel_id' and seat_type='L' ") or die(mysql_error());
            foreach ($sq4->result() as $roww) {
                $mroww = $roww->mroww;
                $mcoll = $roww->mcoll;
            }
            echo "<span style='font-size:14px; font-weight:bold;'>LowerDeck</span><br/>";
            echo "<table border='0' cellpadding='10' cellspacing='4'>";
            for ($k = 1; $k <= $mcoll; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mroww; $l++) {
                    $sql3 = $this->db->query("select * from master_layouts where row='$l' and col='$k' and service_num='$sernum' and travel_id='$travel_id' and seat_type='L' ") or die(mysql_error());
                    $sql3->result();
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $seat_type = $row2->seat_type;
                        $available = $row2->available;
                        $seat_status = $row2->seat_status;
                    }

                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else { //if($available==1)
                        if (($available != 1 || $available != 2) && $seat_status == 0) {//available for booking
                            $id = "cl$k$l";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" onclick="chkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';
                        }
                        if ($seat_status == 1) {
                            $ck = "<input type='checkbox' name='cl$k$l' id='cl$k$l' value='$seat_name' checked='checked'  disabled='disabled' />";
                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        if (($available == 1 || $available == 2) && $seat_status == 0) {
                            //$x=explode("#",$available_type);
                            $style = "style='background-color: #f2f2f2; width:20px'";
                            $id = "cl$k$l";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" checked="checked" onclick="unchkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';

                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        echo "<td style='background-color: #E4E4E4;'>$seat_name$ck";

                        echo "</td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo '</table><tr>
    <td align="center">';
            echo '<table width="100%" border="0" id="chkd' . $s . '" style="font-size:12px; display:none;">
        <tr>
          <td height="27" align="center">&nbsp;</td>
            <td align="right">New Quota Seats are : </td>
            <td style="max-width:10px;" id="gb' . $s . '" align="left"></td>
          </tr>
          <tr>
            <td width="131" height="31" align="center">&nbsp;</td>
            <td width="230" align="center"><span id="updtspan' . $s . '" >Kindly Select Agent Type to give the Quota :</span></td>
            <td width="200"><select name="atype' . $s . '" id="atype' . $s . '" onChange="agentType(' . $s . ')">
              <option value="">--select--</option>
              <option value="1">Branch</option>
              <option value="2">Agent</option>
            </select></td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td ><span style="font-size:12px; color:#000;display:none;" id="uqa' . $s . '" >Select Agent Name TO Give  the Quota:</span>
     <span style="font-size:12px;color:#000;display:none;" id="uqi' . $s . '" >Select Branch Name to Update the Quota </span>   </td>
            <td> <span id="uqii' . $s . '"></span></td>
          </tr>
         <tr>
            <td colspan="3" align="center"><input type="hidden" id="res_seats' . $s . '" name="res_seats' . $s . '" value="' . $res_seats . '" />
            <input type="button" class="newsearchbtn" name="gbupdt' . $s . '" id="gbupdt' . $s . '" value="Save Changes" onClick="quotaUpdate(\'' . $sernum . '\',' . $travel_id . ',' . $s . ',1)"></td>
          </tr>
        </table>

<table width="100%" border="0" id="unchkd' . $s . '" style="font-size:12px;  display:none;">
        <tr>
            <td width="137" height="31" align="right">&nbsp;</td>
            <td width="162" align="left">Quota Removing Seats are : </td>
            <td width="280" align="left" style="max-width:10px;" id="rl' . $s . '"></td>
  </tr>
         <tr>
		 <td height="34"></td>
            <td align="right"><input type="button" class="newsearchbtn" name="rlupdt' . $s . '" id="rlupdt' . $s . '" value="Save Changes" onclick="quotaUpdate(\'' . $sernum . '\',' . $travel_id . ',' . $s . ',2)" /></td>
            <td colspan="1" align="left"><input type="hidden" id="res_seats' . $s . '" name="res_seats' . $s . '" value="' . $res_seats . '" /></td>
          </tr>
        </table>
</td>
  </tr>
  <tr>
    <td align="center">
    <span id="updtspan' . $s . '"  style="font-size:12; font-weight:normal;"></span></td>
  </tr>
  </td>
  </tr>
</table>';
        }// else if(sleeper)
        else if ($lid[1] == 'seatersleeper') {
            //getting max of row and col from master_layouts
            //UpperDeck
            $this->db->select_max('row', 'mrow');
            $this->db->select_max('col', 'mcol');
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where("(seat_type='U' OR seat_type='U')");
            $sqll = $this->db->get('master_layouts');

            foreach ($sqll->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }
            echo "<span style='font-size:14px; font-weight:bold;'>UpperDeck</span> <br/>";
            echo "<table border='0' cellpadding='10' cellspacing='4'>";
            for ($k = 1; $k <= $mcol; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mrow; $l++) {
                    $this->db->select('*');
                    $this->db->where('row', $l);
                    $this->db->where('col', $k);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where("(seat_type='U' OR seat_type='U')");
                    $sql3 = $this->db->get('master_layouts');

                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $available = $row2->available;
                        $seat_type = $row2->seat_type;
                        $seat_status = $row2->seat_status;
                    }
                    if ($seat_type == 'U')
                        $st = "(B)";
                    else if ($seat_type == 'U')
                        $st = "(S)";


                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else { //if($available==1)
                        if (($available != 1 || $available != 2) && $seat_status == 0) {//available for booking
                            $id = "cu$k$l";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" onclick="chkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';
                        }
                        if ($seat_status == 1) {
                            $ck = "<input type='checkbox' name='cu$k$l' id='cu$k$l' value='$seat_name' checked='checked'  disabled='disabled' />";
                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        if (($available == 1 || $available == 2) && $seat_status == 0) {
                            //$x=explode("#",$available_type);
                            $style = "style='background-color: #f2f2f2; width:20px'";
                            $id = "cu$k$l";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" checked="checked" onclick="unchkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';

                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        echo "<td style='background-color: #E4E4E4;'>$seat_name$ck";

                        echo "</td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo "</table><br/>";


            // Lower Deck


            $this->db->select_max('row', 'mroww');
            $this->db->select_max('col', 'mcoll');
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where("(seat_type='L:b' OR seat_type='L:s')");
            $sql3 = $this->db->get('master_layouts');
            foreach ($sql3->result() as $roww) {
                $mroww = $roww->mroww;
                $mcoll = $roww->mcoll;
            }

            echo "<span style='font-size:14px; font-weight:bold;'>LowerDeck</span><br/>";
            echo "<table border='0' cellpadding='10' cellspacing='4'>";
            for ($k = 1; $k <= $mcoll; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mroww; $l++) {
                    $this->db->select('*');
                    $this->db->where('row', $l);
                    $this->db->where('col', $k);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where("(seat_type='L:b' OR seat_type='L:s')");
                    $sql3 = $this->db->get('master_layouts');
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $available = $row2->available;
                        $seat_type = $row2->seat_type;
                        $seat_status = $row2->seat_status;
                    }
                    if ($seat_type == 'L:b')
                        $st = "(B)";
                    else if ($seat_type == 'L:s')
                        $st = "(S)";
                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else { //if($available==1)
                        if (($available != 1 || $available != 2) && $seat_status == 0) {//available for booking
                            $id = "cl$k$l";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" onclick="chkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';
                        }
                        if ($seat_status == 1) {
                            $ck = "<input type='checkbox' name='cl$k$l' id='cl$k$l' value='$seat_name' checked='checked'  disabled='disabled' />";
                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        if (($available == 1 || $available == 2) && $seat_status == 0) {
                            //$x=explode("#",$available_type);
                            $style = "style='background-color: #E4E4E4; width:20px'";
                            $id = "cl$k$l";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" checked="checked" onclick="unchkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';

                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        echo "<td style='background-color: #E4E4E4;'>$seat_name$ck";

                        echo "</td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo '</table><tr>
    <td align="center">';
            echo '<table width="100%" border="0" id="chkd' . $s . '" style="font-size:12px; display:none;">
        <tr>
          <td height="27" align="center">&nbsp;</td>
            <td align="right">New Quota Seats are : </td>
            <td style="max-width:10px;" id="gb' . $s . '" align="left"></td>
          </tr>
          <tr>
            <td width="131" height="31" align="center">&nbsp;</td>
            <td width="230" align="center"><span id="updtspan' . $s . '" >Kindly Select Agent Type to give the Quota :</span></td>
            <td width="200"><select name="atype' . $s . '" id="atype' . $s . '" onChange="agentType(' . $s . ')">
              <option value="">--select--</option>
              <option value="1">Branch</option>
              <option value="2">Agent</option>
            </select></td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td ><span style="font-size:12px; color:#000;display:none;" id="uqa' . $s . '" >Select Agent Name TO Give  the Quota:</span>
     <span style="font-size:12px;color:#000;display:none;" id="uqi' . $s . '" >Select Branch Name to Update the Quota </span>   </td>
            <td> <span id="uqii' . $s . '"></span></td>
          </tr>
         <tr>
            <td colspan="3" align="center"><input type="hidden" id="res_seats' . $s . '" name="res_seats' . $s . '" value="' . $res_seats . '" />
            <input type="button" class="newsearchbtn" name="gbupdt' . $s . '" id="gbupdt' . $s . '" value="Save Changes" onClick="quotaUpdate(\'' . $sernum . '\',' . $travel_id . ',' . $s . ',1)"></td>
          </tr>
        </table>

<table width="100%" border="0" id="unchkd' . $s . '" style="font-size:12px;  display:none;">
        <tr>
            <td width="137" height="31" align="right">&nbsp;</td>
            <td width="162" align="left">Quota Removing Seats are : </td>
            <td width="280" align="left" style="max-width:10px;" id="rl' . $s . '"></td>
  </tr>
         <tr>
		 <td height="34"></td>
            <td align="right"><input type="button" class="newsearchbtn" name="rlupdt' . $s . '" id="rlupdt' . $s . '" value="Save Changes" onclick="quotaUpdate(\'' . $sernum . '\',' . $travel_id . ',' . $s . ',2)" /></td>
            <td colspan="1" align="left"><input type="hidden" id="res_seats' . $s . '" name="res_seats' . $s . '" value="' . $res_seats . '" /></td>
          </tr>
        </table>
</td>
  </tr>
  <tr>
    <td align="center">
    <span id="updtspan' . $s . '"  style="font-size:12; font-weight:normal;"></span></td>
  </tr>
  </td>
  </tr>
</table>';
        }//close else if(seatersleeper) 
    }

    function getAgentName($id) {

        $travel_id = $this->session->userdata('travel_id');
        $sql = $this->db->query("select id,appname,name from agents_operator where agent_type='$id' and operator_id='$travel_id'");
        //  return $sql->result_array();
        $data = array();
        $data[0] = "All";
        foreach ($sql->result() as $rows) {
            if ($id == 1)
                $name = $rows->name . " ( " . $rows->appname . " )";
            else
                $name = $rows->name;
            $data[$rows->id] = $name;
        }
        return $data;
    }

    function updateQuota($sernum, $travel_id, $seats, $agent_id, $agent_type, $c) {

        $user_id = $this->session->userdata('user_id');
        $name = $this->session->userdata('name');

        if ($c == 1) {
            $st = explode(",", $seats);
            $ip = $this->input->ip_address();
            for ($i = 0; $i < count($st); $i++) {
                //storing in quota_update_history table
                $data_insert = array(
                    'service_num' => $sernum,
                    'travel_id' => $travel_id,
                    'seat_name' => $st[$i],
                    'available' => $agent_type,
                    'available_type' => $agent_id,
                    'ip' => $ip,
                    'updated_by_id' => $user_id,
                    'updated_by' => $name
                );
                $this->db->insert('quota_update_history', $data_insert);
                $this->db->set('t1.available', $agent_type);
                $this->db->set('t1.available_type', $agent_id);
                $this->db->set('t2.available_type', $agent_id);
                $this->db->set('t2.available', $agent_type);
                $array3 = array('t1.service_num' => $sernum, 't1.travel_id' => $travel_id, 't1.seat_name' => $st[$i], 't2.service_num' => $sernum, 't2.travel_id' => $travel_id, 't2.seat_name' => $st[$i]);
                $this->db->where($array3);
                $query = $this->db->update('master_layouts as t1,layout_list as t2');
            }//for
        } else if ($c == 2) {
            $st = explode(",", $seats);
            for ($i = 0; $i < count($st); $i++) {
                //storing in quota_update_history table
                $data_insert = array(
                    'service_num' => $sernum,
                    'travel_id' => $travel_id,
                    'seat_name' => $st[$i],
                    'available' => 0,
                    'available_type' => 0,
                    'ip' => $ip,
                    'updated_by_id' => $user_id,
                    'updated_by' => $name
                );
                $this->db->insert('quota_update_history', $data_insert);
                //storing in quota_update_history table 
                $this->db->set('t1.available', 0);
                $this->db->set('t1.available_type', 0);
                $this->db->set('t2.available_type', 0);
                $this->db->set('t2.available', 0);
                $array3 = array('t1.service_num' => $sernum, 't1.travel_id' => $travel_id, 't1.seat_name' => $st[$i], 't2.service_num' => $sernum, 't2.travel_id' => $travel_id, 't2.seat_name' => $st[$i]);
                $this->db->where($array3);
                $query2 = $this->db->update('master_layouts as t1,layout_list as t2');
            }//for
        }

        if ($query)
            echo 1;
        else
            echo 2;
    }

    function ListOfService($date, $serno, $opid) {
        $travid = $opid;
        $this->db->select('*');
        $this->db->from('buses_list as b');
        $this->db->where('b.travel_id', $travid);
        $this->db->where('b.journey_date', $date);
        $this->db->where('b.status', 1);
        $this->db->join('master_buses as mb', 'mb.service_num = b.service_num');
        $this->db->where('mb.service_num', $serno);
        $this->db->group_by('b.service_num');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            echo '<table width="100%" style="margin-top:15px;" border="0"  align="center" cellspacing="0" cellpadding="0">
                          <tr>
                          <td height="30">ServiceNumber</td>
                          <td height="30" >Source</td>
                          <td height="30" >Destination</td>
                          <td height="30" >BusType</td>
                          <td height="30" >Quota</td>
                          <td height="30" >Status</td>
                          </tr>
                          </tr>';
            $s = 1;
            $travel_id = $opid;
            foreach ($result->result() as $row) {
                //$class = ($s%2 == 0)? 'bg': 'bg1';
                echo'<tr>
                          <td height="30">' . $row->service_num . '</td>
                          <td height="30">' . $row->from_name . '</td>
                          <td height="30">' . $row->to_name . '</td>
                          <td height="30">' . $row->bus_type . '</td>
                          <td height="30"><input type="button" class="newsearchbtn" name="uq' . $s . '" id="uq' . $s . '" value="Grab and Release" onClick="showLayout(\'' . $row->service_num . '\',' . $travel_id . ',' . $s . ',\'' . $date . '\')" /></td>
                                <td height="30"><input type="button" class="newsearchbtn" name="vq' . $s . '" id="vq' . $s . '" value="View Updated Quota"  onClick="showUpdatedLayout(\'' . $row->service_num . '\',' . $travel_id . ',' . $s . ',\'' . $date . '\')" />
	                        <input type="hidden" value="' . $date . '" name="dt' . $s . '" id="dt' . $s . '" />
	                  </td></tr> <tr>
                          <td colspan="6" style="font-size:14px; display:none" id="trr' . $s . '" aligin="center"></td>
                          </tr>';
                $s++;
            }
            echo "<input type='hidden' id='hf' value='" . $s . "'/></table>";
        } else {
            echo 0;
        }
    }

    function getLayoutOfGrabRelease($sernum, $travel_id, $s, $date) {
        //echo $s;
        $travel_id = $travel_id;
        //query for getting seat_type
        $seat_name = '';
        $res_seats = '';
        $query = $this->db->query("select layout_id,seat_type from layout_list where service_num='$sernum' and travel_id='$travel_id' and journey_date='$date' ");
        foreach ($query->result() as $r) {
            $layout_id = $r->layout_id;
            $seat_type = $r->seat_type;
            $lid = explode("#", $layout_id);
        }
        echo '<table width="100%" border="0" align="center" style="border:#f2f2f2 solid 0px; margin-top:15px;">
          ';
        echo'
     <tr>
      <td align="center">';
        if ($lid[1] == 'seater') {
            //getting max of row and col from master_layouts
            $sq = $this->db->query("select max(row) as mrow,max(col) as mcol from layout_list where service_num='$sernum' and travel_id='$travel_id' and journey_date='$date' ") or die(mysql_error());
            foreach ($sq->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }
            echo "<input type='hidden' name='mrow' id='mrow' value='$mrow' />
		<input type='hidden' name='mcol' id='mcol' value='$mcol' />";

            echo "<table border='0' cellpadding='10' cellspacing='4' align='center'>";

            for ($i = 1; $i <= $mcol; $i++) {
                echo "<tr>";
                for ($j = 1; $j <= $mrow; $j++) {
                    $sql3 = $this->db->query("select * from layout_list where row='$j' and col='$i' and service_num='$sernum' and travel_id='$travel_id' and journey_date='$date' ") or die(mysql_error());
                    $sql3->result();
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $seat_type = $row2->seat_type;
                        $available = $row2->available;
                        $seat_status = $row2->seat_status;
                    }
                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else { //if($available==1)
                        if (($available != 1 || $available != 2) && $seat_status == 0) {//available for booking
                            $id = "c$i$j";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" onclick="chkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';
                        }
                        if ($seat_status == 1) {
                            $ck = "<input type='checkbox' name='c$i$j' id='c$i$j' value='$seat_name' checked='checked'  disabled='disabled' />";
                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        if (($available == 1 || $available == 2) && $seat_status == 0) {
                            //$x=explode("#",$available_type);
                            $style = "style='background-color: #f2f2f2; width:20px'";
                            $id = "c$i$j";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" checked="checked" onclick="unchkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';

                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        echo "<td class='gruseat'>$seat_name$ck";

                        echo "</td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo '</table>
                               <tr>
    <td align="center">';
            echo '<table width="100%" border="0" id="chkd' . $s . '" style="font-size:12px; display:none;">
        <tr>
          <td height="27" align="center">&nbsp;</td>
            <td align="right">New Quota Seats are : </td>
            <td style="max-width:10px;" id="gb' . $s . '" align="left"></td>
          </tr>
          <tr>
            <td width="131" height="31" align="center">&nbsp;</td>
            <td width="230" align="center"><span id="updtspan' . $s . '" >Kindly Select Agent Type to give the Quota :</span></td>
            <td width="200"><select name="atype' . $s . '" id="atype' . $s . '" onChange="agentType(' . $s . ',1)">
              <option value="">--select--</option>
              <option value="1">Branch</option>
              <option value="2">Agent</option>
            </select></td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td ><span style="font-size:12px; color:#000;display:none;" id="uqa' . $s . '" >Select Agent Name TO Give  the Quota:</span>
     <span style="font-size:12px;color:#000;display:none;" id="uqi' . $s . '" >Select Branch Name to Update the Quota </span>   </td>
            <td> <span id="uqii' . $s . '"></span></td>
          </tr>
         <tr>
            <td colspan="3" align="center"><input type="hidden" id="res_seats' . $s . '" name="res_seats' . $s . '" value="' . $res_seats . '" />
            <input type="button" class="newsearchbtn" name="gbupdt' . $s . '" id="gbupdt' . $s . '" value="Save Changes" onClick="quotaUpdate(\'' . $sernum . '\',' . $travel_id . ',' . $s . ',1)"></td>
          </tr>
        </table>

<table width="100%" border="0" id="unchkd' . $s . '" style="font-size:12px;  display:none;">
        <tr>
            <td width="137" height="31" align="right">&nbsp;</td>
            <td width="182" align="left">Quota Removing Seats are : </td>
            <td width="180" align="left" style="max-width:10px;" id="rl' . $s . '"></td>
      </tr>
      
      <tr>
            <td width="131" height="31" align="center">&nbsp;</td>
            <td width="270" align="center"><span id="updtspan' . $s . '" >Kindly Select Agent Type to Release the Seats :</span></td>
            <td width="200"><select name="res_atype' . $s . '" id="res_atype' . $s . '" onChange="agentType(' . $s . ',2)">
              <option value="">--select--</option>
              <option value="1">Branch</option>
              <option value="2">Agent</option>
              <option value="0">Open to all</option>
            </select></td>
          </tr>
     <tr>
            <td >&nbsp;</td>
            <td ><span style="font-size:12px; color:#000;display:none;" id="rsuqa' . $s . '" >Select Agent Name TO Remove the Quota:</span>
     <span style="font-size:12px;color:#000;display:none;" id="rsuqi' . $s . '" >Select Branch Name to Remove the Quota </span>   </td>
            <td> <span id="rsuqii' . $s . '"></span></td>
          </tr>
         <tr>
		 <td height="34"></td>
            <td align="right"><input type="button" class="newsearchbtn" name="rlupdt' . $s . '" id="rlupdt' . $s . '" value="Save Changes" onclick="quotaUpdate(\'' . $sernum . '\',' . $travel_id . ',' . $s . ',2)" /></td>
            <td colspan="1" align="left"><input type="hidden" id="res_seats' . $s . '" name="res_seats' . $s . '" value="' . $res_seats . '" /></td>
          </tr>
        </table>
</td>
  </tr>
  <tr>
    <td align="center">
    <span id="updtspan' . $s . '"  style="font-size:12; font-weight:normal;"></span></td>
  </tr>
  </td>
  </tr>
</table>';
        }
        else if ($lid[1] == 'sleeper') {
            //getting max of row and col from master_layouts
            //UpperDeck
            $sq2 = $this->db->query("select max(row) as mrow,max(col) as mcol from layout_list where service_num='$sernum' and travel_id='$travel_id' and seat_type='U' and journey_date='$date'");
            foreach ($sq2->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }
            echo "<span style='font-size:14px; font-weight:bold;'>UpperDeck</span> <br/>";
            echo "<table border='0' cellpadding='10' cellspacing='4'>";
            for ($k = 1; $k <= $mcol; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mrow; $l++) {
                    $sq3 = $this->db->query("select * from layout_list where row='$l' and col='$k' and service_num='$sernum' and travel_id='$travel_id' and seat_type='U' and journey_date='$date' ");
                    foreach ($sq3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $seat_type = $row2->seat_type;
                        $available = $row2->available;
                        $seat_status = $row2->seat_status;
                    }
                    if ($seat_name == '') {
                        echo "<td style='border:none;'>&nbsp;</td>";
                    } else { //if($available==1)
                        if (($available != 1 || $available != 2) && $seat_status == 0) {//available for booking
                            $id = "cu$k$l";

                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" onclick="chkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';
                        }
                        if ($seat_status == 1) {
                            $ck = "<input type='checkbox' name='cu$k$l' id='cu$k$l' value='$seat_name' checked='checked'  disabled='disabled' />";
                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        if (($available == 1 || $available == 2) && $seat_status == 0) {
                            //$x=explode("#",$available_type);
                            $style = "style='background-color: #E4E4E4; width:20px'";
                            $id = "cu$k$l";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" checked="checked" onclick="unchkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';

                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        echo "<td style='background-color: #E4E4E4;'>$seat_name$ck";

                        echo "</td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo "</table><br/>";


            // Lower Deck
            $sq4 = $this->db->query("select max(row) as mroww,max(col) as mcoll from layout_list where service_num='$sernum' and travel_id='$travel_id' and seat_type='L' and journey_date='$date'") or die(mysql_error());
            foreach ($sq4->result() as $roww) {
                $mroww = $roww->mroww;
                $mcoll = $roww->mcoll;
            }
            echo "<span style='font-size:14px; font-weight:bold;'>LowerDeck</span><br/>";
            echo "<table border='0' cellpadding='10' cellspacing='4'>";
            for ($k = 1; $k <= $mcoll; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mroww; $l++) {
                    $sql3 = $this->db->query("select * from layout_list where row='$l' and col='$k' and service_num='$sernum' and travel_id='$travel_id' and seat_type='L' and journey_date='$date'") or die(mysql_error());
                    $sql3->result();
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $seat_type = $row2->seat_type;
                        $available = $row2->available;
                        $seat_status = $row2->seat_status;
                    }

                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else { //if($available==1)
                        if (($available != 1 || $available != 2) && $seat_status == 0) {//available for booking
                            $id = "cl$k$l";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" onclick="chkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';
                        }
                        if ($seat_status == 1) {
                            $ck = "<input type='checkbox' name='cl$k$l' id='cl$k$l' value='$seat_name' checked='checked'  disabled='disabled' />";
                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        if (($available == 1 || $available == 2) && $seat_status == 0) {
                            //$x=explode("#",$available_type);
                            $style = "style='background-color: #f2f2f2; width:20px'";
                            $id = "cl$k$l";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" checked="checked" onclick="unchkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';

                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        echo "<td style='background-color: #E4E4E4;'>$seat_name$ck";

                        echo "</td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo '</table><tr>
    <td align="center">';
            echo '<table width="600" border="0" id="chkd' . $s . '" style="font-size:12px; display:none;">
        <tr>
          <td height="27" align="center">&nbsp;</td>
            <td align="right">New Quota Seats are : </td>
            <td style="max-width:10px;" id="gb' . $s . '" align="left"></td>
          </tr>
          <tr>
            <td width="131" height="31" align="center">&nbsp;</td>
            <td width="230" align="center"><span id="updtspan' . $s . '" >Kindly Select Agent Type to give the Quota :</span></td>
            <td width="200"><select name="atype' . $s . '" id="atype' . $s . '" onChange="agentType(' . $s . ',1)">
              <option value="">--select--</option>
              <option value="1">Branch</option>
              <option value="2">Agent</option>
            </select></td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td ><span style="font-size:12px; color:#000;display:none;" id="uqa' . $s . '" >Select Agent Name TO Give  the Quota:</span>
     <span style="font-size:12px;color:#000;display:none;" id="uqi' . $s . '" >Select Branch Name to Update the Quota </span>   </td>
            <td> <span id="uqii' . $s . '"></span></td>
          </tr>
         <tr>
            <td colspan="3" align="center"><input type="hidden" id="res_seats' . $s . '" name="res_seats' . $s . '" value="' . $res_seats . '" />
            <input type="button" class="newsearchbtn" name="gbupdt' . $s . '" id="gbupdt' . $s . '" value="Save Changes" onClick="quotaUpdate(\'' . $sernum . '\',' . $travel_id . ',' . $s . ',1)"></td>
          </tr>
        </table>

<table width="593" border="0" id="unchkd' . $s . '" style="font-size:12px;  display:none;">
        <tr>
            <td width="137" height="31" align="right">&nbsp;</td>
            <td width="182" align="left">Quota Removing Seats are : </td>
            <td width="180" align="left" style="max-width:10px;" id="rl' . $s . '"></td>
  </tr>
  
   <tr>
            <td width="131" height="31" align="center">&nbsp;</td>
            <td width="270" align="center"><span id="updtspan' . $s . '" >Kindly Select Agent Type to Release the Seats :</span></td>
            <td width="200"><select name="res_atype' . $s . '" id="res_atype' . $s . '" onChange="agentType(' . $s . ',2)">
              <option value="">--select--</option>
              <option value="1">Branch</option>
              <option value="2">Agent</option>
              <option value="0">Open to all</option>
            </select></td>
          </tr>
     <tr>
            <td >&nbsp;</td>
            <td ><span style="font-size:12px; color:#000;display:none;" id="rsuqa' . $s . '" >Select Agent Name TO Remove the Quota:</span>
     <span style="font-size:12px;color:#000;display:none;" id="rsuqi' . $s . '" >Select Branch Name to Remove the Quota </span>   </td>
            <td> <span id="rsuqii' . $s . '"></span></td>
          </tr>
         <tr>
		 <td height="34"></td>
            <td align="right"><input type="button" class="newsearchbtn" name="rlupdt' . $s . '" id="rlupdt' . $s . '" value="Save Changes" onclick="quotaUpdate(\'' . $sernum . '\',' . $travel_id . ',' . $s . ',2)" /></td>
            <td colspan="1" align="left"><input type="hidden" id="res_seats' . $s . '" name="res_seats' . $s . '" value="' . $res_seats . '" /></td>
          </tr>
        </table>
</td>
  </tr>
  <tr>
    <td align="center">
    <span id="updtspan' . $s . '"  style="font-size:12; font-weight:normal;"></span></td>
  </tr>
  </td>
  </tr>
</table>';
        }// else if(sleeper)
        else if ($lid[1] == 'seatersleeper') {
            //getting max of row and col from master_layouts
            //UpperDeck
            $this->db->select_max('row', 'mrow');
            $this->db->select_max('col', 'mcol');
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where("(seat_type='U' OR seat_type='U')");
            $this->db->where('journey_date', $date);
            $sqll = $this->db->get('layout_list');

            foreach ($sqll->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }
            echo "<span style='font-size:14px; font-weight:bold;'>UpperDeck</span> <br/>";
            echo "<table border='0' cellpadding='10' cellspacing='4'>";
            for ($k = 1; $k <= $mcol; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mrow; $l++) {
                    $this->db->select('*');
                    $this->db->where('row', $l);
                    $this->db->where('col', $k);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where("(seat_type='U' OR seat_type='U')");
                    $this->db->where('journey_date', $date);
                    $sql3 = $this->db->get('layout_list');

                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $available = $row2->available;
                        $seat_type = $row2->seat_type;
                        $seat_status = $row2->seat_status;
                    }
                    if ($seat_type == 'U')
                        $st = "(B)";
                    else if ($seat_type == 'U')
                        $st = "(S)";


                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else { //if($available==1)
                        if (($available != 1 || $available != 2) && $seat_status == 0) {//available for booking
                            $id = "cu$k$l";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" onclick="chkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';
                        }
                        if ($seat_status == 1) {
                            $ck = "<input type='checkbox' name='cu$k$l' id='cu$k$l' value='$seat_name' checked='checked'  disabled='disabled' />";
                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        if (($available == 1 || $available == 2) && $seat_status == 0) {
                            //$x=explode("#",$available_type);
                            $style = "style='background-color: #E4E4E4; width:20px'";
                            $id = "cu$k$l";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" checked="checked" onclick="unchkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';

                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        echo "<td style='background-color: #E4E4E4;'>$seat_name$ck";

                        echo "</td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo "</table><br/>";


            // Lower Deck


            $this->db->select_max('row', 'mroww');
            $this->db->select_max('col', 'mcoll');
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where("(seat_type='L:b' OR seat_type='L:s')");
            $this->db->where('journey_date', $date);
            $sql3 = $this->db->get('layout_list');
            foreach ($sql3->result() as $roww) {
                $mroww = $roww->mroww;
                $mcoll = $roww->mcoll;
            }

            echo "<span style='font-size:14px; font-weight:bold;'>LowerDeck</span><br/>";
            echo "<table border='1'  cellpadding='2' cellspacing='4'>";
            for ($k = 1; $k <= $mcoll; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mroww; $l++) {
                    $this->db->select('*');
                    $this->db->where('row', $l);
                    $this->db->where('col', $k);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where('journey_date', $date);
                    $this->db->where("(seat_type='L:b' OR seat_type='L:s')");
                    $sql3 = $this->db->get('layout_list');
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $available = $row2->available;
                        $seat_type = $row2->seat_type;
                        $seat_status = $row2->seat_status;
                    }
                    if ($seat_type == 'L:b')
                        $st = "(B)";
                    else if ($seat_type == 'L:s')
                        $st = "(S)";
                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else { //if($available==1)
                        if (($available != 1 || $available != 2) && $seat_status == 0) {//available for booking
                            $id = "cl$k$l";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" onclick="chkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';
                        }
                        if ($seat_status == 1) {
                            $ck = "<input type='checkbox' name='cl$k$l' id='cl$k$l' value='$seat_name' checked='checked'  disabled='disabled' />";
                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        if (($available == 1 || $available == 2) && $seat_status == 0) {
                            //$x=explode("#",$available_type);
                            $style = "style='background-color: #E4E4E4; width:20px'";
                            $id = "cl$k$l";
                            $ck = '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $seat_name . '" checked="checked" onclick="unchkk(\'' . $seat_name . '\',' . $s . ',\'' . $id . '\')"/>';

                            if ($res_seats == '')
                                $res_seats = $seat_name;
                            else
                                $res_seats = $res_seats . "," . $seat_name;
                        }
                        echo "<td style='background-color: #E4E4E4;'>$seat_name$ck";

                        echo "</td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo '</table><tr>
    <td align="center">';
            echo '<table width="600" border="0" id="chkd' . $s . '" style="font-size:12px; display:none;">
        <tr>
          <td height="27" align="center">&nbsp;</td>
            <td align="right">New Quota Seats are : </td>
            <td style="max-width:10px;" id="gb' . $s . '" align="left"></td>
          </tr>
          <tr>
            <td width="131" height="31" align="center">&nbsp;</td>
            <td width="230" align="center"><span id="updtspan' . $s . '" >Kindly Select Agent Type to give the Quota :</span></td>
            <td width="200"><select name="atype' . $s . '" id="atype' . $s . '" onChange="agentType(' . $s . ',1)">
              <option value="">--select--</option>
              <option value="1">Branch</option>
              <option value="2">Agent</option>
            </select></td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td ><span style="font-size:12px; color:#000;display:none;" id="uqa' . $s . '" >Select Agent Name TO Give  the Quota:</span>
     <span style="font-size:12px;color:#000;display:none;" id="uqi' . $s . '" >Select Branch Name to Update the Quota </span>   </td>
            <td> <span id="uqii' . $s . '"></span></td>
          </tr>
         <tr>
            <td colspan="3" align="center"><input type="hidden" id="res_seats' . $s . '" name="res_seats' . $s . '" value="' . $res_seats . '" />
            <input type="button" class="newsearchbtn" name="gbupdt' . $s . '" id="gbupdt' . $s . '" value="Save Changes" onClick="quotaUpdate(\'' . $sernum . '\',' . $travel_id . ',' . $s . ',1)"></td>
          </tr>
        </table>

<table width="593" border="0" id="unchkd' . $s . '" style="font-size:12px;  display:none;">
        <tr>
            <td width="137" height="31" align="right">&nbsp;</td>
            <td width="182" align="left">Quota Removing Seats are : </td>
            <td width="180" align="left" style="max-width:10px;" id="rl' . $s . '"></td>
  </tr>
  
  <tr>
            <td width="131" height="31" align="center">&nbsp;</td>
            <td width="270" align="center"><span id="updtspan' . $s . '" >Kindly Select Agent Type to Release the Seats :</span></td>
            <td width="200"><select name="res_atype' . $s . '" id="res_atype' . $s . '" onChange="agentType(' . $s . ',2)">
              <option value="">--select--</option>
              <option value="1">Branch</option>
              <option value="2">Agent</option>
              <option value="0">Open to all</option>
            </select></td>
          </tr>
     <tr>
            <td >&nbsp;</td>
            <td ><span style="font-size:12px; color:#000;display:none;" id="rsuqa' . $s . '" >Select Agent Name TO Remove the Quota:</span>
     <span style="font-size:12px;color:#000;display:none;" id="rsuqi' . $s . '" >Select Branch Name to Remove the Quota </span>   </td>
            <td> <span id="rsuqii' . $s . '"></span></td>
          </tr>
         <tr>
		 <td height="34"></td>
            <td align="right"><input type="button" class="newsearchbtn" name="rlupdt' . $s . '" id="rlupdt' . $s . '" value="Save Changes" onclick="quotaUpdate(\'' . $sernum . '\',' . $travel_id . ',' . $s . ',2)" /></td>
            <td colspan="1" align="left"><input type="hidden" id="res_seats' . $s . '" name="res_seats' . $s . '" value="' . $res_seats . '" /></td>
          </tr>
        </table>
</td>
  </tr>
  <tr>
    <td align="center">
    <span id="updtspan' . $s . '"  style="font-size:12; font-weight:normal;"></span></td>
  </tr>
  </td>
  </tr>
</table>';
        }//close else if(seatersleeper) 
    }

    function getAgentOfGrab($s) {

        echo '<select name="at' . $s . '" id="at' . $s . '" onchange="agentType(' . $s . ')">
                      <option value="0">--Select--</option>   
                      <option value="1">Branch</option>
                      <option value="2">Agent</option>';
        echo "</select>";
    }

    function getAgentOfRelease($s) {

        echo '<select name="at' . $s . '" id="at' . $s . '" onchange="agentType(' . $s . ')">
                      <option value="0">--Select--</option>
                      <option value="1">Branch</option>
                      <option value="2">Agent</option>
                      <option value="3">Open to all</option>';

        echo "</select>";
    }

    function updateGrabRelease($sernum, $seats, $travel_id, $agent_type, $agent_id, $date, $c) {
        //echo $available."#".$available_type;
        $user_id = $this->session->userdata('user_id');
        $name = $this->session->userdata('name');
        $ip = $_SERVER['REMOTE_ADDR'];
        $tim = date('Y-m-d H:i:s');
        if ($c == 1) {
            $st = explode(",", $seats);

            for ($i = 0; $i < count($st); $i++) {
                //storing in quota_update_history table
                //$this->db->set('t1.available',$agent_type);
                //$this->db->set('t1.available_type',$agent_id); 
                $this->db->set('t2.available_type', $agent_id);
                $this->db->set('t2.available', $agent_type);
                //$array3=array('t1.service_num'=>$sernum,'t1.travel_id'=>$travel_id,'t1.seat_name'=>$st[$i],'t2.service_num'=>$sernum,'t2.travel_id'=>$travel_id,'t2.seat_name'=>$st[$i],'t2.journey_date'=>$date);
                $array3 = array('t2.service_num' => $sernum, 't2.travel_id' => $travel_id, 't2.seat_name' => $st[$i], 't2.journey_date' => $date);
                $this->db->where($array3);
                //$query=$this->db->update('master_layouts as t1,layout_list as t2');
                $query = $this->db->update('layout_list as t2');
                //print_r($query->result()); 
            }
            mysql_query("insert into grabandreleasehistory(service_num,travel_id,seat_name,available,available_type,ip,tim,updated_by_id,updated_by) values('$sernum','$travel_id','$seats','$agent_type','$agent_id','$ip','$tim','$user_id','$name')");
            //for
        } else if ($c == 2) {
            $st = explode(",", $seats);

            for ($i = 0; $i < count($st); $i++) {
                //storing in quota_update_history table
                //echo $agent_id."#".$agent_type."#".$st[$i]."#".$sernum."#".$travel_id."#".$date; 
                //$this->db->set('t1.available',$agent_type);
                //$this->db->set('t1.available_type',$agent_id); 
                $this->db->set('t2.available_type', $agent_id);

                $this->db->set('t2.available', $agent_type);
                // $array3=array('t1.service_num'=>$sernum,'t1.travel_id'=>$travel_id,'t1.seat_name'=>$st[$i],'t2.service_num'=>$sernum,'t2.travel_id'=>$travel_id,'t2.seat_name'=>$st[$i],'t2.journey_date'=>$date);
                $array3 = array('t2.service_num' => $sernum, 't2.travel_id' => $travel_id, 't2.seat_name' => $st[$i], 't2.journey_date' => $date);
                $this->db->where($array3);
                // $query2=$this->db->update('master_layouts as t1,layout_list as t2');
                $query2 = $this->db->update('layout_list as t2');
                //print_r($query->result()); 
            }
            mysql_query("insert into grabandreleasehistory(service_num,travel_id,seat_name,available,available_type,ip,tim,updated_by_id,updated_by) values('$sernum','$travel_id','$seats','$agent_type','$agent_id','$ip','$tim','$user_id','$name')");
        }

        if ($query)
            echo 1;
        else if ($query2)
            echo 2;
        else
            echo 0;
    }

    function display_LayoutOfQuota($sernum, $travel_id) {
        $this->db->select('layout_id,seat_type');
        $this->db->where('service_num', $sernum);
        $this->db->where('travel_id', $travel_id);
        $sql = $this->db->get('master_layouts');
        foreach ($sql->result() as $row) {
            $layout_id = $row->layout_id;
            $seat_type = $row->seat_type;
            $lid = explode("#", $layout_id);
        }
        echo '<table width="100%" border="0" align="center" cellpadding="10px" style="border:#f2f2f2 solid 1px;">
  <tr >
    <td align="left" style="border-bottom:#f2f2f2 solid 2px;font-weight:bold; font-size:12px;">&nbsp;</td>
    <td align="center" style="border-bottom:#f2f2f2 solid 2px;font-weight:bold; font-size:12px;">Layout</td>
    <td align="center" style="border-bottom:#f2f2f2 solid 2px;font-weight:bold; font-size:12px;">Reserved Seats</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="center"><table border="0" style="font-size:12px;">';
        if ($lid[1] == 'seater') {
            //getting max of row and col from mas_layouts
            $this->db->select_max('row', 'mrow');
            $this->db->select_max('col', 'mcol');
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $sq11 = $this->db->get('master_layouts');
            $seat_name = '';
            foreach ($sq11->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }
            echo "<table border='1' cellpadding='0' align='center' >";
            for ($i = 1; $i <= $mcol; $i++) {
                echo "<tr>";
                for ($j = 1; $j <= $mrow; $j++) {
                    $this->db->select('*');
                    $this->db->where('row', $j);
                    $this->db->where('col', $i);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $sql3 = $this->db->get('master_layouts');
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $seat_type = $row2->seat_type;
                        $available = $row2->available;
                        $available_type = $row2->available_type;
                    }
                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else {
                        if ($available == 1 || $available == 2) {
                            echo "<td class='grublockseats'>$seat_name</td>";
                            $seat_name = '';
                        } else {
                            echo "<td class='grureleaseseats'>$seat_name</td>";
                            $seat_name = '';
                        }
                    }
                }
                echo "</tr>";
            }

            echo '</table></td>';

            echo '<td align="center"><table border="0" style="font-size:12px;">';

            $this->db->distinct();
            $this->db->select('available_type');
            $this->db->where('available', 1);
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $inhouse = $this->db->get("master_layouts");

            //if seats reserved to branches
            if ($inhouse->num_rows() > 0) {
                echo '<tr><td valign="top" colspan="2" style="font-weight:normal;text-decoration:underline" align="center">For Branch </td></tr>';
                echo '<tr>';
                //getting available type
                foreach ($inhouse->result() as $rows) {
                    $inhouse_res = '';
                    $available_type = $rows->available_type;
                    $this->db->select('seat_name');
                    $this->db->where('available', 1);
                    $this->db->where('available_type', $available_type);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $get_seats = $this->db->get("master_layouts");
                    //getting seats numbers
                    foreach ($get_seats->result() as $rows2) {
                        $seats = $rows2->seat_name;
                        if ($inhouse_res == '')
                            $inhouse_res = $seats;
                        else
                            $inhouse_res = $inhouse_res . ", " . $seats;
                    }
                    //getting branch name
                    if ($available_type == 'all')
                        $aname = "ALL";
                    else {
                        $this->db->select('name');
                        $this->db->where('id', $available_type);
                        $this->db->where('operator_id', $travel_id);
                        $get_branch = $this->db->get("agents_operator");
                        foreach ($get_branch->result() as $rows3) {
                            $aname = $rows3->name;
                        }
                    }

                    echo '<td width="104" height="26" style="font-weight:normal;">' . $aname . ':</td><td width="152">' . $inhouse_res . '</td></tr>';
                }//for each
            }//if
            //agent code
            $this->db->distinct();
            $this->db->select('available_type');
            $this->db->where('available', 2);
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $agent = $this->db->get("master_layouts");
            if ($agent->num_rows() > 0) {
                echo '<tr>
  <td height="22" colspan="2"  align="center" style="font-weight:normal; text-decoration:underline">For Agents </td>
  </tr>
<tr>';
                //getting available type
                foreach ($agent->result() as $rows) {
                    $inhouse_res2 = '';
                    $available_type2 = $rows->available_type;
                    $this->db->select('seat_name');
                    $this->db->where('available', 2);
                    $this->db->where('available_type', $available_type2);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $get_seats2 = $this->db->get("master_layouts");
                    //getting seats numbers
                    foreach ($get_seats2->result() as $rows2) {
                        $seats2 = $rows2->seat_name;
                        if ($inhouse_res2 == '')
                            $inhouse_res2 = $seats2;
                        else
                            $inhouse_res2 = $inhouse_res2 . ", " . $seats2;
                    }
                    //getting branch name
                    if ($available_type2 == 'all')
                        $aname2 = "ALL";
                    else {
                        $this->db->select('name');
                        $this->db->where('id', $available_type2);
                        $this->db->where('operator_id', $travel_id);
                        $get_branch2 = $this->db->get("agents_operator");
                        foreach ($get_branch2->result() as $rows3) {
                            $aname2 = $rows3->name;
                        }
                    }

                    echo '<td width="104" height="26" style="font-weight:normal;">' . $aname2 . ':</td><td width="152">' . $inhouse_res2 . '</td></tr>';
                }//for each
            }//if
            echo '</table></td>
                        </tr>
                </table>';
        } else if ($lid[1] == 'sleeper') {
            //getting max of row and col from mas_layouts
            //UpperDeck
            $this->db->select_max('row', 'mrow');
            $this->db->select_max('col', 'mcol');
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where('seat_type', 'U');
            $sq1 = $this->db->get('master_layouts');
            foreach ($sq1->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }


            echo "<span style='font-size:14px; font-weight:bold;'>UpperDeck</span> <br/>";
            echo "<table border='1' cellpadding='0'>";
            for ($k = 1; $k <= $mcol; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mrow; $l++) {
                    $this->db->select('*');
                    $this->db->where('row', $l);
                    $this->db->where('col', $k);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where('seat_type', 'U');
                    $sql3 = $this->db->get('master_layouts');
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $available = $row2->available;
                    }
                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else {
                        if ($available == 1 || $available == 2) {
                            echo "<td style='grublockseats'>$seat_name</td>";
                            $seat_name = '';
                        } else {
                            echo "<td class='grureleaseseats'>$seat_name</td>";
                            $seat_name = '';
                        }
                    }
                }
                echo "</tr>";
            }
            echo "</table><br/>";
            // Lower Deck
            $this->db->select_max('row', 'mroww');
            $this->db->select_max('col', 'mcoll');
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where('seat_type', 'L');
            $sq1l = $this->db->get('master_layouts');
            foreach ($sq1l->result() as $roww) {
                $mroww = $roww->mroww;
                $mcoll = $roww->mcoll;
            }
            echo "<span style='font-size:14px; font-weight:bold;'>LowerDeck</span><br/>";
            echo "<table border='1' cellpadding='0'>";
            for ($k = 1; $k <= $mcoll; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mroww; $l++) {
                    $this->db->select('*');
                    $this->db->where('row', $l);
                    $this->db->where('col', $k);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where('seat_type', 'L');
                    $sql3 = $this->db->get('master_layouts');
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $available = $row2->available;
                    }
                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else {
                        if ($available == 1 || $available == 2) {
                            echo "<td style='grublockseats'>$seat_name</td>";
                            $seat_name = '';
                        } else {
                            echo "<td class='grureleaseseats'>$seat_name</td>";
                            $seat_name = '';
                        }
                    }
                }
                echo "</tr>";
            }
            echo '</table></td>';

            echo '<td align="center"><table border="0" style="font-size:12px;" width="350">';
            $this->db->distinct();
            $this->db->select('available_type');
            $this->db->where('available', 1);
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $inhouse = $this->db->get("master_layouts");

            //if seats reserved to branches
            if ($inhouse->num_rows() > 0) {
                echo '<tr><td valign="top" colspan="2" style="font-weight:normal;text-decoration:underline;" align="center">For Branch </td></tr>';
                echo '<tr>';
                //getting available type
                foreach ($inhouse->result() as $rows) {
                    $inhouse_res = '';
                    $available_type = $rows->available_type;
                    $this->db->select('seat_name');
                    $this->db->where('available', 1);
                    $this->db->where('available_type', $available_type);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $get_seats = $this->db->get("master_layouts");
                    //getting seats numbers
                    foreach ($get_seats->result() as $rows2) {
                        $seats = $rows2->seat_name;
                        if ($inhouse_res == '')
                            $inhouse_res = $seats;
                        else
                            $inhouse_res = $inhouse_res . ", " . $seats;
                    }
                    //getting branch name
                    if ($available_type == 'all')
                        $aname = "ALL";
                    else {
                        $this->db->select('name');
                        $this->db->where('id', $available_type);
                        $this->db->where('operator_id', $travel_id);
                        $get_branch = $this->db->get("agents_operator");
                        foreach ($get_branch->result() as $rows3) {
                            $aname = $rows3->name;
                        }
                    }

                    echo '<td width="104" height="26" style="font-weight:normal;">' . $aname . ':</td><td width="152">' . $inhouse_res . '</td></tr>';
                }//for each
            }//if
            //agent code
            $this->db->distinct();
            $this->db->select('available_type');
            $this->db->where('available', 2);
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $agent = $this->db->get("master_layouts");
            if ($agent->num_rows() > 0) {
                echo '<tr>
  <td height="22" colspan="2"  align="center" style="font-weight:normal; text-decoration:underline">For Agents </td>
  </tr>
<tr>';
                //getting available type
                foreach ($agent->result() as $rows) {
                    $inhouse_res2 = '';
                    $available_type2 = $rows->available_type;
                    $this->db->select('seat_name');
                    $this->db->where('available', 2);
                    $this->db->where('available_type', $available_type2);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $get_seats2 = $this->db->get("master_layouts");
                    //getting seats numbers
                    foreach ($get_seats2->result() as $rows2) {
                        $seats2 = $rows2->seat_name;
                        if ($inhouse_res2 == '')
                            $inhouse_res2 = $seats2;
                        else
                            $inhouse_res2 = $inhouse_res2 . ", " . $seats2;
                    }
                    //getting branch name
                    if ($available_type2 == 'all')
                        $aname2 = "ALL";
                    else {
                        $this->db->select('name');
                        $this->db->where('id', $available_type2);
                        $this->db->where('operator_id', $travel_id);
                        $get_branch2 = $this->db->get("agents_operator");
                        foreach ($get_branch2->result() as $rows3) {
                            $aname2 = $rows3->name;
                        }
                    }

                    echo '<td width="104" height="26" style="font-weight:normal;">' . $aname2 . ':</td><td width="152">' . $inhouse_res2 . '</td></tr>';
                }//for each
            }//if
            echo '</table></td>
                        </tr>
                </table>';
        } else if ($lid[1] == 'seatersleeper') {

            //getting max of row and col from mas_layouts
            //UpperDeck
            $this->db->select_max('row', 'mrow');
            $this->db->select_max('col', 'mcol');
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where("(seat_type='U' OR seat_type='U')");
            $sqll = $this->db->get('master_layouts');
            foreach ($sqll->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }
            echo "<span style='font-size:14px; font-weight:bold;'>UpperDeck</span> <br/>";
            echo "<table border='1' cellpadding='0'>";
            for ($k = 1; $k <= $mcol; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mrow; $l++) {
                    $this->db->select('*');
                    $this->db->where('row', $l);
                    $this->db->where('col', $k);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where("(seat_type='U' OR seat_type='U')");
                    $sql3 = $this->db->get('master_layouts');
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $available = $row2->available;
                        $available_type = $row2->available_type;
                        $seat_type = $row2->seat_type;
                    }
                    if ($seat_type == 'U')
                        $st = "(B)";
                    else if ($seat_type == 'U')
                        $st = "(S)";

                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else {
                        if ($available == 1 || $available == 2) {
                            echo "<td class='grublockseats'>$seat_name</td>";
                            $seat_name = '';
                        } else {
                            echo "<td class='grureleaseseats'>$seat_name</td>";
                            $seat_name = '';
                        }
                    }
                }
                echo "</tr>";
            } //outer for
            echo "</table><br/>";
            // Lower Deck

            $this->db->select_max('row', 'mroww');
            $this->db->select_max('col', 'mcoll');
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where("(seat_type='L:b' OR seat_type='L:s')");
            $sq1l = $this->db->get('master_layouts');
            foreach ($sq1l->result() as $roww) {
                $mroww = $roww->mroww;
                $mcoll = $roww->mcoll;
            }
            echo "<span style='font-size:14px; font-weight:bold;'>LowerDeck</span><br/>";
            echo "<table border='1' cellpadding='0'>";
            for ($k = 1; $k <= $mcoll; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mroww; $l++) {
                    $this->db->select('*');
                    $this->db->where('row', $l);
                    $this->db->where('col', $k);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where("(seat_type='L:b' OR seat_type='L:s')");
                    $sql3 = $this->db->get('master_layouts');
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $available = $row2->available;
                        $available_type = $row2->available_type;
                        $seat_type = $row2->seat_type;
                    }
                    if ($seat_type == 'L:b')
                        $st = "(B)";
                    else if ($seat_type == 'L:s')
                        $st = "(S)";
                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else {
                        if ($available == 1 || $available == 2) {
                            echo "<td class='grublockseats'>$seat_name</td>";
                            $seat_name = '';
                        } else {
                            echo "<td class='grureleaseseats'>$seat_name</td>";
                            $seat_name = '';
                        }
                    }
                }
                echo "</tr>";
            }
            echo '</table></td>';

            echo '<td align="center"><table border="0" style="font-size:12px;">';
            $this->db->distinct();
            $this->db->select('available_type');
            $this->db->where('available', 1);
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $inhouse = $this->db->get("master_layouts");

            //if seats reserved to branches
            if ($inhouse->num_rows() > 0) {
                echo '<tr><td valign="top" colspan="2" style="font-weight:normal;text-decoration:underline" align="center">For Branch </td></tr>';
                echo '<tr>';
                //getting available type
                foreach ($inhouse->result() as $rows) {
                    $inhouse_res = '';
                    $available_type = $rows->available_type;
                    $this->db->select('seat_name');
                    $this->db->where('available', 1);
                    $this->db->where('available_type', $available_type);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $get_seats = $this->db->get("master_layouts");
                    //getting seats numbers
                    foreach ($get_seats->result() as $rows2) {
                        $seats = $rows2->seat_name;
                        if ($inhouse_res == '')
                            $inhouse_res = $seats;
                        else
                            $inhouse_res = $inhouse_res . ", " . $seats;
                    }
                    //getting branch name
                    if ($available_type == 'all')
                        $aname = "ALL";
                    else {
                        $this->db->select('name');
                        $this->db->where('id', $available_type);
                        $this->db->where('operator_id', $travel_id);
                        $get_branch = $this->db->get("agents_operator");
                        foreach ($get_branch->result() as $rows3) {
                            $aname = $rows3->name;
                        }
                    }

                    echo '<td width="104" height="26" style="font-weight:normal;">' . $aname . ':</td><td width="152">' . $inhouse_res . '</td></tr>';
                }//for each
            }//if
            //agent code
            $this->db->distinct();
            $this->db->select('available_type');
            $this->db->where('available', 2);
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $agent = $this->db->get("master_layouts");
            if ($agent->num_rows() > 0) {
                echo '<tr>
  <td height="22" colspan="2"  align="center" style="font-weight:normal; text-decoration:underline">For Agents </td>
  </tr>
<tr>';
                //getting available type
                foreach ($agent->result() as $rows) {
                    $inhouse_res2 = '';
                    $available_type2 = $rows->available_type;
                    $this->db->select('seat_name');
                    $this->db->where('available', 2);
                    $this->db->where('available_type', $available_type2);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $get_seats2 = $this->db->get("master_layouts");
                    //getting seats numbers
                    foreach ($get_seats2->result() as $rows2) {
                        $seats2 = $rows2->seat_name;
                        if ($inhouse_res2 == '')
                            $inhouse_res2 = $seats2;
                        else
                            $inhouse_res2 = $inhouse_res2 . ", " . $seats2;
                    }
                    //getting branch name
                    if ($available_type2 == 'all')
                        $aname2 = "ALL";
                    else {
                        $this->db->select('name');
                        $this->db->where('id', $available_type2);
                        $this->db->where('operator_id', $travel_id);
                        $get_branch2 = $this->db->get("agents_operator");
                        foreach ($get_branch2->result() as $rows3) {
                            $aname2 = $rows3->name;
                        }
                    }

                    echo '<td width="104" height="26" style="font-weight:normal;">' . $aname2 . ':</td><td width="152">' . $inhouse_res2 . '</td></tr>';
                }//for each
            }//if
            echo '</table></td>
                        </tr>
                </table>';
        }//if(seatersleeper)
    }

    function display_LayoutOfGrabRelease($sernum, $travel_id, $date) {
        $this->db->select('layout_id,seat_name,seat_type,');
        $this->db->where('service_num', $sernum);
        $this->db->where('travel_id', $travel_id);
        $this->db->where('journey_date', $date);
        $this->db->where('status', 1);
        $sql = $this->db->get('layout_list');
        foreach ($sql->result() as $row) {
            $layout_id = $row->layout_id;
            $seat_type = $row->seat_type;
            $seat_name = $row->seat_name;
            $lid = explode("#", $layout_id);
        }
        echo '<table width="100%" border="0" align="center" cellpadding="0" style="margin-top:15px;">
  <tr >
    <td align="left">&nbsp;</td>
    <td align="center">Layout</td>
    <td align="center">&nbsp;</td>
	<td align="left">Reserved Seats</td>
	
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="center"><table border="0" style="font-size:12px;">';
        if ($lid[1] == 'seater') {
            //getting max of row and col from mas_layouts
            $this->db->select_max('row', 'mrow');
            $this->db->select_max('col', 'mcol');
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where('journey_date', $date);
            $sq11 = $this->db->get('layout_list');
            $seat_name = '';
            foreach ($sq11->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }
            echo "<table border='1' cellpadding='0' cellspacing='3' align='center' >";
            for ($i = 1; $i <= $mcol; $i++) {
                echo "<tr>";
                for ($j = 1; $j <= $mrow; $j++) {
                    $this->db->select('*');
                    $this->db->where('row', $j);
                    $this->db->where('col', $i);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where('journey_date', $date);
                    $sql3 = $this->db->get('layout_list');
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $seat_type = $row2->seat_type;
                        $available = $row2->available;
                        $available_type = $row2->available_type;
                    }
                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else {
                        if ($available == 1 || $available == 2) {
                            echo "<td class='grublockseats'>$seat_name</td>";
                            $seat_name = '';
                        } else {
                            echo "<td class='grureleaseseats'>$seat_name</td>";
                            $seat_name = '';
                        }
                    }
                }
                echo "</tr>";
            }

            echo '</table></td>';

            echo '<td align="center"><table border="0" style="font-size:12px;">';

            $this->db->distinct();
            $this->db->select('available_type');
            $this->db->where('available', 1);
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where('journey_date', $date);
            $inhouse = $this->db->get("layout_list");

            //if seats reserved to branches
            if ($inhouse->num_rows() > 0) {
                echo '<tr><td valign="top" colspan="2" style="font-weight:normal;text-decoration:underline" align="center">For Branch </td></tr>';
                echo '<tr>';
                //getting available type
                foreach ($inhouse->result() as $rows) {
                    $inhouse_res = '';
                    $available_type = $rows->available_type;
                    $this->db->select('seat_name');
                    $this->db->where('available', 1);
                    $this->db->where('available_type', $available_type);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where('journey_date', $date);
                    $get_seats = $this->db->get("layout_list");
                    //getting seats numbers
                    foreach ($get_seats->result() as $rows2) {
                        $seats = $rows2->seat_name;
                        if ($inhouse_res == '')
                            $inhouse_res = $seats;
                        else
                            $inhouse_res = $inhouse_res . ", " . $seats;
                    }
                    //getting branch name
                    if ($available_type == 'all')
                        $aname = "ALL";
                    else {
                        $this->db->select('name');
                        $this->db->where('id', $available_type);
                        $this->db->where('operator_id', $travel_id);
                        $get_branch = $this->db->get("agents_operator");
                        foreach ($get_branch->result() as $rows3) {
                            $aname = $rows3->name;
                        }
                    }

                    echo '<td width="104" height="26" style="font-weight:normal;">' . $aname . ':</td><td width="152">' . $inhouse_res . '</td></tr>';
                }//for each
            }//if
            //agent code
            $this->db->distinct();
            $this->db->select('available_type');
            $this->db->where('available', 2);
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where('journey_date', $date);
            $agent = $this->db->get("layout_list");
            if ($agent->num_rows() > 0) {
                echo '<tr>
  <td height="22" colspan="2"  align="center" style="font-weight:normal; text-decoration:underline">For Agents </td>
  </tr>
<tr>';
                //getting available type
                foreach ($agent->result() as $rows) {
                    $inhouse_res2 = '';
                    $available_type2 = $rows->available_type;
                    $this->db->select('seat_name');
                    $this->db->where('available', 2);
                    $this->db->where('available_type', $available_type2);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where('journey_date', $date);
                    $get_seats2 = $this->db->get("layout_list");
                    //getting seats numbers
                    foreach ($get_seats2->result() as $rows2) {
                        $seats2 = $rows2->seat_name;
                        if ($inhouse_res2 == '')
                            $inhouse_res2 = $seats2;
                        else
                            $inhouse_res2 = $inhouse_res2 . ", " . $seats2;
                    }
                    //getting branch name
                    if ($available_type2 == 'all')
                        $aname2 = "ALL";
                    else {
                        $this->db->select('name');
                        $this->db->where('id', $available_type2);
                        $this->db->where('operator_id', $travel_id);
                        $get_branch2 = $this->db->get("agents_operator");
                        foreach ($get_branch2->result() as $rows3) {
                            $aname2 = $rows3->name;
                        }
                    }

                    echo '<td width="104" height="26" style="font-weight:normal;">' . $aname2 . ':</td><td width="152">' . $inhouse_res2 . '</td></tr>';
                }//for each
            }//if
            echo '</table></td>
                        </tr>
                </table>';
        } else if ($lid[1] == 'sleeper') {
            //getting max of row and col from mas_layouts
            //UpperDeck
            $this->db->select_max('row', 'mrow');
            $this->db->select_max('col', 'mcol');
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where('seat_type', 'U');
            $this->db->where('journey_date', $date);
            $this->db->where('journey_date', $date);
            $sq1 = $this->db->get('layout_list');
            foreach ($sq1->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }


            echo "<span style='font-size:14px; font-weight:bold;'>UpperDeck</span> <br/>";
            echo "<table border='1' cellpadding='0'>";
            for ($k = 1; $k <= $mcol; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mrow; $l++) {
                    $this->db->select('*');
                    $this->db->where('row', $l);
                    $this->db->where('col', $k);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where('seat_type', 'U');
                    $this->db->where('journey_date', $date);
                    $sql3 = $this->db->get('layout_list');
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $available = $row2->available;
                    }
                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else {
                        if ($available == 1 || $available == 2) {
                            echo "<td class='grublockseats'>$seat_name</td>";
                            $seat_name = '';
                        } else {
                            echo "<td class='grureleaseseats'>$seat_name</td>";
                            $seat_name = '';
                        }
                    }
                }
                echo "</tr>";
            }
            echo "</table><br/>";
            // Lower Deck
            $this->db->select_max('row', 'mroww');
            $this->db->select_max('col', 'mcoll');
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where('seat_type', 'L');
            $this->db->where('journey_date', $date);
            $sq1l = $this->db->get('layout_list');
            foreach ($sq1l->result() as $roww) {
                $mroww = $roww->mroww;
                $mcoll = $roww->mcoll;
            }
            echo "<span style='font-size:14px; font-weight:bold;'>LowerDeck</span><br/>";
            echo "<table border='1' cellpadding='0'>";
            for ($k = 1; $k <= $mcoll; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mroww; $l++) {
                    $this->db->select('*');
                    $this->db->where('row', $l);
                    $this->db->where('col', $k);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where('seat_type', 'L');
                    $this->db->where('journey_date', $date);
                    $sql3 = $this->db->get('layout_list');
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $available = $row2->available;
                    }
                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else {
                        if ($available == 1 || $available == 2) {
                            echo "<td class='grublockseats'>$seat_name</td>";
                            $seat_name = '';
                        } else {
                            echo "<td class='grureleaseseats'>$seat_name</td>";
                            $seat_name = '';
                        }
                    }
                }
                echo "</tr>";
            }
            echo '</table></td>';

            echo '<td align="center" valign="top"><table border="0" width="100%" cellpadding="0" cellspacing="0">';
            $this->db->distinct();
            $this->db->select('available_type');
            $this->db->where('available', 1);
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where('journey_date', $date);
            $inhouse = $this->db->get("layout_list");

            //if seats reserved to branches
            if ($inhouse->num_rows() > 0) {
                echo '<tr><td valign="top" colspan="2" style="font-weight:normal;text-decoration:underline" align="center">For Branch </td></tr>';
                echo '<tr>';
                //getting available type
                foreach ($inhouse->result() as $rows) {
                    $inhouse_res = '';
                    $available_type = $rows->available_type;
                    $this->db->select('seat_name');
                    $this->db->where('available', 1);
                    $this->db->where('available_type', $available_type);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where('journey_date', $date);
                    $get_seats = $this->db->get("layout_list");
                    //getting seats numbers
                    foreach ($get_seats->result() as $rows2) {
                        $seats = $rows2->seat_name;
                        if ($inhouse_res == '')
                            $inhouse_res = $seats;
                        else
                            $inhouse_res = $inhouse_res . ", " . $seats;
                    }
                    //getting branch name
                    if ($available_type == 'all')
                        $aname = "ALL";
                    else {
                        $this->db->select('name');
                        $this->db->where('id', $available_type);
                        $this->db->where('operator_id', $travel_id);
                        $get_branch = $this->db->get("agents_operator");
                        foreach ($get_branch->result() as $rows3) {
                            $aname = $rows3->name;
                        }
                    }

                    echo '<td width="104" height="26" style="font-weight:normal;">' . $aname . ':</td><td width="152">' . $inhouse_res . '</td></tr>';
                }//for each
            }//if
            //agent code
            $this->db->distinct();
            $this->db->select('available_type');
            $this->db->where('available', 2);
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where('journey_date', $date);
            $agent = $this->db->get("layout_list");
            if ($agent->num_rows() > 0) {
                echo '<tr>
  <td height="22" colspan="2"  align="center" style="font-weight:normal; text-decoration:underline">For Agents </td>
  </tr>
<tr>';
                //getting available type
                foreach ($agent->result() as $rows) {
                    $inhouse_res2 = '';
                    $available_type2 = $rows->available_type;
                    $this->db->select('seat_name');
                    $this->db->where('available', 2);
                    $this->db->where('available_type', $available_type2);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where('journey_date', $date);
                    $get_seats2 = $this->db->get("layout_list");
                    //getting seats numbers
                    foreach ($get_seats2->result() as $rows2) {
                        $seats2 = $rows2->seat_name;
                        if ($inhouse_res2 == '')
                            $inhouse_res2 = $seats2;
                        else
                            $inhouse_res2 = $inhouse_res2 . ", " . $seats2;
                    }
                    //getting branch name
                    if ($available_type2 == 'all')
                        $aname2 = "ALL";
                    else {
                        $this->db->select('name');
                        $this->db->where('id', $available_type2);
                        $this->db->where('operator_id', $travel_id);
                        $get_branch2 = $this->db->get("agents_operator");
                        foreach ($get_branch2->result() as $rows3) {
                            $aname2 = $rows3->name;
                        }
                    }

                    echo '<td width="104" height="26" style="font-weight:normal;">' . $aname2 . ':</td><td width="152">' . $inhouse_res2 . '</td></tr>';
                }//for each
            }//if
            echo '</table></td>
                        </tr>
                </table>';
        } else if ($lid[1] == 'seatersleeper') {

            //getting max of row and col from mas_layouts
            //UpperDeck
            $this->db->select_max('row', 'mrow');
            $this->db->select_max('col', 'mcol');
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where("(seat_type='U' OR seat_type='U')");
            $this->db->where('journey_date', $date);
            $sqll = $this->db->get('layout_list');
            foreach ($sqll->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }
            echo "<span style='font-size:14px; font-weight:bold;'>UpperDeck</span> <br/>";
            echo "<table border='1' cellspacing='3' cellpadding='0'>";
            for ($k = 1; $k <= $mcol; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mrow; $l++) {
                    $this->db->select('*');
                    $this->db->where('row', $l);
                    $this->db->where('col', $k);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where("(seat_type='U' OR seat_type='U')");
                    $this->db->where('journey_date', $date);
                    $sql3 = $this->db->get('layout_list');
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $available = $row2->available;
                        $available_type = $row2->available_type;
                        $seat_type = $row2->seat_type;
                    }
                    if ($seat_type == 'U')
                        $st = "(B)";
                    else if ($seat_type == 'U')
                        $st = "(S)";

                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else {
                        if ($available == 1 || $available == 2) {
                            echo "<td class='grublockseats'>$seat_name</td>";
                            $seat_name = '';
                        } else {
                            echo "<td class='grureleaseseats'>$seat_name</td>";
                            $seat_name = '';
                        }
                    }
                }
                echo "</tr>";
            } //outer for
            echo "</table><br/>";
            // Lower Deck

            $this->db->select_max('row', 'mroww');
            $this->db->select_max('col', 'mcoll');
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where("(seat_type='L:b' OR seat_type='L:s')");
            $sq1l = $this->db->get('layout_list');
            $this->db->where('journey_date', $date);
            foreach ($sq1l->result() as $roww) {
                $mroww = $roww->mroww;
                $mcoll = $roww->mcoll;
            }
            echo "<span style='font-size:14px; font-weight:bold;'>LowerDeck</span><br/>";
            echo "<table border='1' cellspacing='3' cellpadding='0'>";
            for ($k = 1; $k <= $mcoll; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mroww; $l++) {
                    $this->db->select('*');
                    $this->db->where('row', $l);
                    $this->db->where('col', $k);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where("(seat_type='L:b' OR seat_type='L:s')");
                    $this->db->where('journey_date', $date);
                    $sql3 = $this->db->get('layout_list');
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $available = $row2->available;
                        $available_type = $row2->available_type;
                        $seat_type = $row2->seat_type;
                    }
                    if ($seat_type == 'L:b')
                        $st = "(B)";
                    else if ($seat_type == 'L:s')
                        $st = "(S)";
                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else {
                        if ($available == 1 || $available == 2) {
                            echo "<td class='grublockseats'>$seat_name</td>";
                            $seat_name = '';
                        } else {
                            echo "<td class='grureleaseseats'>$seat_name</td>";
                            $seat_name = '';
                        }
                    }
                }
                echo "</tr>";
            }
            echo '</table></td>';

            echo '<td align="center" valign="top"><table border="0" cellspacing="0" cellpadding="0" width="100%">';
            $this->db->distinct();
            $this->db->select('available_type');
            $this->db->where('available', 1);
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where('journey_date', $date);
            $inhouse = $this->db->get("layout_list");

            //if seats reserved to branches
            if ($inhouse->num_rows() > 0) {
                echo '<tr><td valign="top" colspan="2" style="font-weight:normal;text-decoration:underline" align="center">For Branch </td></tr>';
                echo '<tr>';
                //getting available type
                foreach ($inhouse->result() as $rows) {
                    $inhouse_res = '';
                    $available_type = $rows->available_type;
                    $this->db->select('seat_name');
                    $this->db->where('available', 1);
                    $this->db->where('available_type', $available_type);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('journey_date', $date);
                    $this->db->where('travel_id', $travel_id);
                    $get_seats = $this->db->get("layout_list");
                    //getting seats numbers
                    foreach ($get_seats->result() as $rows2) {
                        $seats = $rows2->seat_name;
                        if ($inhouse_res == '')
                            $inhouse_res = $seats;
                        else
                            $inhouse_res = $inhouse_res . ", " . $seats;
                    }
                    //getting branch name
                    if ($available_type == 'all')
                        $aname = "ALL";
                    else {
                        $this->db->select('name');
                        $this->db->where('id', $available_type);
                        $this->db->where('operator_id', $travel_id);
                        $get_branch = $this->db->get("agents_operator");
                        foreach ($get_branch->result() as $rows3) {
                            $aname = $rows3->name;
                        }
                    }

                    echo '<td width="104" height="26" style="font-weight:normal;">' . $aname . ':</td><td width="152">' . $inhouse_res . '</td></tr>';
                }//for each
            }//if
            //agent code
            $this->db->distinct();
            $this->db->select('available_type');
            $this->db->where('available', 2);
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
            $this->db->where('journey_date', $date);
            $agent = $this->db->get("layout_list");
            if ($agent->num_rows() > 0) {
                echo '<tr>
  <td height="22" colspan="2"  align="center" style="font-weight:normal; text-decoration:underline">For Agents </td>
  </tr>
<tr>';
                //getting available type
                foreach ($agent->result() as $rows) {
                    $inhouse_res2 = '';
                    $available_type2 = $rows->available_type;
                    $this->db->select('seat_name');
                    $this->db->where('available', 2);
                    $this->db->where('available_type', $available_type2);
                    $this->db->where('service_num', $sernum);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where('journey_date', $date);
                    $get_seats2 = $this->db->get("layout_list");
                    //getting seats numbers
                    foreach ($get_seats2->result() as $rows2) {
                        $seats2 = $rows2->seat_name;
                        if ($inhouse_res2 == '')
                            $inhouse_res2 = $seats2;
                        else
                            $inhouse_res2 = $inhouse_res2 . ", " . $seats2;
                    }
                    //getting branch name
                    if ($available_type2 == 'all')
                        $aname2 = "ALL";
                    else {
                        $this->db->select('name');
                        $this->db->where('id', $available_type2);
                        $this->db->where('operator_id', $travel_id);
                        $get_branch2 = $this->db->get("agents_operator");
                        foreach ($get_branch2->result() as $rows3) {
                            $aname2 = $rows3->name;
                        }
                    }

                    echo '<td width="104" height="26" style="font-weight:normal;">' . $aname2 . ':</td><td width="152">' . $inhouse_res2 . '</td></tr>';
                }//for each
            }//if
            echo '</table></td>
                        </tr>
                </table>';
        }//if(seatersleeper)
    }

}

?>