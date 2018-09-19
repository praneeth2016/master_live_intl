<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Home controller class
 * This is only viewable to those members that are logged in
 */

class Createbus_model_new extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->database();
    }

    public function getAllCity() {
        $this->db->select('city_id,city_name');
        $query = $this->db->get('master_cities');
        $data = array();
        $data[0] = '-------select-------';
        foreach ($query->result() as $rows) {
            $data[$rows->city_id] = $rows->city_name;
        }
        return $data;
    }
    
     public function getCurrencyList() {
        $this->db->select('currency');
        $query = $this->db->get('currency');
        $data = array();
        $data[0] = '-------select-------';
        foreach ($query->result() as $rows) {
            $data[$rows->currency] = $rows->currency;
        }
        return $data;
    }

    public function getAllCity1() {
        $this->db->select('city_id,city_name');
        $query = $this->db->get('master_cities');
        $data = array();
        $data[0] = '-------select-------';
        foreach ($query->result() as $rows) {
            $data[$rows->city_name] = $rows->city_name;
        }
        return $data;
    }

    public function getbustype($busmodel, $opid) {
        //$travel_id=$this->session->userdata('travel_id');
        $this->db->select('layout_id');
        $this->db->where('model', $busmodel);
        $this->db->where('travel_id', $opid);
        $query = $this->db->get('operator_layouts');

        foreach ($query->result() as $rows) {
            $layout_id = $rows->layout_id;
        }
        //echo $layout_id."jhfj";
        $layout_id1 = explode('#', $layout_id);
        return $layout_id1[1];
    }

    public function getHour() {
        $data = array();
        for ($i = 0; $i <= 12; $i++) {
            if ($i < 10)
                $i = "0" . $i;
            $data[$i] = $i;
        }
        return $data;
    }

//getHour()

    public function getHours() {
        $data = array();
        $data[HH] = "HH";
        for ($i = 0; $i <= 12; $i++) {
            if ($i < 10)
                $i = "0" . $i;
            $data[$i] = $i;
        }
        return $data;
    }

//getHours()

    public function getMinutes() {
        $data = array();
        $data[MM] = "MM";
        for ($i = 0; $i <= 60; $i++) {
            if ($i < 10)
                $i = "0" . $i;
            $data[$i] = $i;
        }
        return $data;
    }

//getMinutes()
    /*     * ************ method for checking username of agent************ */

    public function check_user($sname) {
        $sname = $this->input->post('sname');
        $snum = $this->input->post('snum');
        $vall = $this->input->post('vall');
        if ($vall == "SNO") {
            $this->db->where('service_num', $snum);
        } else {
            $this->db->where('service_name', $sname);
        }
        $query = $this->db->get("master_buses");
        $rws = $query->num_rows();
        if ($rws > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /* method for getting all the buses model */

    public function busmodel() {
        //$travel_id=$this->session->userdata('travel_id');
        $travel_id = $this->input->post('opid');
        $this->db->distinct();
        $this->db->select("model");
        $this->db->where('travel_id', $travel_id);
        $this->db->order_by("model", "asc");
        $query = $this->db->get("operator_layouts");
        $list = '<option value="0">---Select---</option>';
        foreach ($query->result() as $rows) {
            $list = $list . '<option value="' . $rows->model . '">' . $rows->model . '</option>';
        }
        return $list;
    }

//close busmodel()  
    //gettting service layout From Operator Layouts

    public function getLayoutDb() {
        $travel_id = $this->input->post('opid');
        $busmodel = $this->input->post('busmodel');

        $query = $this->db->query("select layout_id,seat_type from operator_layouts where model='$busmodel' and travel_id='$travel_id'  ");
        foreach ($query->result() as $r) {
            $layout_id = $r->layout_id;
            $seat_type = $r->seat_type;
            $lid = explode("#", $layout_id);
        }
        $layout_type = $lid[1];
        echo '<input type="hidden" name="layout_type" id="layout_type" value="' . $layout_type . '">';

        if ($lid[1] == 'seater') {
            //getting max of row and col from master_layouts
            $sq = $this->db->query("select max(row) as mrow,max(col) as mcol from operator_layouts where model='$busmodel' and travel_id='$travel_id' ") or die(mysql_error());
            foreach ($sq->result() as $row1) {
                $rows = $row1->mrow;
                $cols = $row1->mcol;
            }
            echo "<input type='hidden' name='rows' id='rows' value='$rows' />
	        <input type='hidden' name='cols' id='cols' value='$cols' />";

            echo '<table border="0" cellspacing="1" cellpadding="1"  align="center" style="padding-top:10px;padding-bottom:10px;"><tr><td  colspan="2">Select All : <input type="checkbox" name="selectall" id="selectall" onClick="selectAll()"></td></tr></table>';
            echo '<table border="0" cellspacing="1" cellpadding="1"  align="center" style="padding-top:10px;padding-bottom:10px;">';

            for ($i = 1; $i <= $rows; $i++) {
                echo '<tr>';
                for ($j = 1; $j <= $cols; $j++) {

                    $sql3 = mysql_query("select * from operator_layouts where row='$i' and col='$j' and model='$busmodel' and travel_id='$travel_id' ") or die(mysql_error());
                    $row2 = mysql_fetch_array($sql3);

                    $seat_name = $row2['seat_name'];
                    $seat_type = $row2['seat_type'];
                    $available = $row2['available'];
                    $seat_status = $row2['seat_status'];

                    if ($seat_name != "") {

                        echo '<td align="center" width="40" height="40" style="border:#666666 solid 2px"><input onchange="document.getElementById(\'ltxt' . $i . '-' . $j . '\').disabled=!this.checked;" class="chkbox" type="checkbox" name="lchk' . $i . '-' . $j . '" id="lchk' . $i . '-' . $j . '"/><input type="text" name="ltxt' . $i . '-' . $j . '" class="textbox" id="ltxt' . $i . '-' . $j . '" value="' . $seat_name . '" size="1" disabled="disabled" style="text-align:center"></td>';
                    } else {
                        echo '<td width="40">&nbsp;</td>';
                    }
                }
                echo "</tr>";
            }
            echo "</table>";
        }//if(Seater)
        else if ($lid[1] == 'sleeper') {
            $sqsl = $this->db->query("select max(row) as upper_rows,max(col) as upper_cols from operator_layouts where model='$busmodel' and travel_id='$travel_id'  and seat_type='U'") or die(mysql_error());
            foreach ($sqsl->result() as $row2) {
                $upper_rows = $row2->upper_rows;
                $upper_cols = $row2->upper_cols;
            }
            echo "<input type='hidden' name='upper_rows' id='upper_rows' value='$upper_rows' />
	        <input type='hidden' name='upper_cols' id='upper_cols' value='$upper_cols' />";

            echo '<table border="0" cellspacing="1" cellpadding="1"  align="center" style="padding-top:10px;padding-bottom:10px;"><tr><td  colspan="2">Select All : <input type="checkbox" name="selectall" id="selectall" onClick="selectAll()"></td></tr></table>';
            echo '<table border="0" cellspacing="1" cellpadding="1"  align="center" style="padding-top:10px;padding-bottom:10px;">
                    <tr>
                      <td colspan="' . $upper_cols . '">Upper Deck</td>
                    </tr>  
                 ';
            for ($i = 1; $i <= $upper_rows; $i++) {
                echo '<tr>';
                for ($j = 1; $j <= $upper_cols; $j++) {
                    $sql3 = mysql_query("select * from operator_layouts where row='$i' and col='$j' and model='$busmodel' and travel_id='$travel_id' and seat_type='U' ") or die(mysql_error());
                    $row2 = mysql_fetch_array($sql3);

                    $seat_name = $row2['seat_name'];
                    $seat_type = $row2['seat_type'];
                    $available = $row2['available'];
                    $seat_status = $row2['seat_status'];
                    if ($seat_name != "") {

                        echo '<td align="center" width="40" height="40" style="border:#666666 solid 2px"><input onchange="document.getElementById(\'utxt' . $i . '-' . $j . '\').disabled=!this.checked;" class="chkbox" type="checkbox" name="uchk' . $i . '-' . $j . '" id="uchk' . $i . '-' . $j . '"/><input type="text" name="utxt' . $i . '-' . $j . '" class="textbox" id="utxt' . $i . '-' . $j . '" value="' . $seat_name . '" size="1" disabled="disabled"></td>';
                    } else {
                        echo '<td>&nbsp;</td>';
                    }
                }
                echo "</tr>";
            }
            echo "</table><br /> ";
            $sq = $this->db->query("select max(row) as lower_rows,max(col) as lower_cols from operator_layouts where model='$busmodel' and travel_id='$travel_id'  and seat_type='L'") or die(mysql_error());
            foreach ($sq->result() as $row1) {
                $lower_rows = $row1->lower_rows;
                $lower_cols = $row1->lower_cols;
            }
            echo "<input type='hidden' name='lower_rows' id='lower_rows' value='$lower_rows' />
	        <input type='hidden' name='lower_cols' id='lower_cols' value='$lower_cols' />";
            echo '<table border="0" cellspacing="1" cellpadding="1"  align="center" style="padding-top:10px;padding-bottom:10px;">
                    <tr>
                      <td colspan="' . $lower_cols . '">Lower Deck</td>
                    </tr>  
                 ';
            for ($i = 1; $i <= $lower_rows; $i++) {
                echo '<tr>';
                for ($j = 1; $j <= $lower_cols; $j++) {
                    $sql3 = mysql_query("select * from operator_layouts where row='$i' and col='$j' and model='$busmodel' and travel_id='$travel_id' and seat_type='L' ") or die(mysql_error());
                    $row2 = mysql_fetch_array($sql3);

                    $seat_name = $row2['seat_name'];
                    $seat_type = $row2['seat_type'];
                    $available = $row2['available'];
                    $seat_status = $row2['seat_status'];
                    if ($seat_name != "") {

                        echo '<td align="center" width="40" height="40" style="border:#666666 solid 2px"><input onchange="document.getElementById(\'ltxt' . $i . '-' . $j . '\').disabled=!this.checked;" class="chkbox" type="checkbox" name="lchk' . $i . '-' . $j . '" id="lchk' . $i . '-' . $j . '" /><input type="text" name="ltxt' . $i . '-' . $j . '" class="textbox" id="ltxt' . $i . '-' . $j . '" value="' . $seat_name . '" size="1" disabled="disabled"></td>';
                    } else {
                        echo '<td>&nbsp;</td>';
                    }
                }
                echo "</tr>";
            }
            echo "</table>";
        }//else if(sleeper)
        //getting sleeperSeater Layout
        else if ($lid[1] == 'seatersleeper') {
            $sq = $this->db->query("select max(row) as upper_rows,max(col) as upper_cols from operator_layouts where model='$busmodel' and travel_id='$travel_id'  and seat_type='U'") or die(mysql_error());
            foreach ($sq->result() as $row1) {
                $upper_rows = $row1->upper_rows;
                $upper_cols = $row1->upper_cols;
            }
            echo "<input type='hidden' name='upper_rows' id='upper_rows' value='$upper_rows' />
	        <input type='hidden' name='upper_cols' id='upper_cols' value='$upper_cols' />";

            echo '<table border="0" cellspacing="1" cellpadding="1"  align="center" style="padding-top:10px;padding-bottom:10px;"><tr><td  colspan="2">Select All : <input type="checkbox" name="selectall" id="selectall" onClick="selectAll()"></td></tr></table>';
            echo '<table border="0" cellspacing="1" cellpadding="1"  align="center" style="padding-top:10px;padding-bottom:10px;">';
            echo '<tr>
                      <td colspan="' . $upper_cols . '">Upper Deck</td>
                    </tr>  
                 ';
            for ($i = 1; $i <= $upper_rows; $i++) {
                echo '<tr>';
                for ($j = 1; $j <= $upper_cols; $j++) {
                    $sql3 = mysql_query("select * from operator_layouts where row='$i' and col='$j' and model='$busmodel' and travel_id='$travel_id' and seat_type='U' ") or die(mysql_error());
                    $row2 = mysql_fetch_array($sql3);

                    $seat_name = $row2['seat_name'];
                    $seat_type = $row2['seat_type'];
                    $available = $row2['available'];
                    $seat_status = $row2['seat_status'];
                    if ($seat_name != "") {

                        echo '<td align="center" width="40" height="40" style="border:#666666 solid 2px"><input onchange="document.getElementById(\'utxt' . $i . '-' . $j . '\').disabled=!this.checked;" class="chkbox" type="checkbox" name="uchk' . $i . '-' . $j . '" id="uchk' . $i . '-' . $j . '"/><input type="text" name="utxt' . $i . '-' . $j . '" class="textbox" id="utxt' . $i . '-' . $j . '" value="' . $seat_name . '" size="1"  disabled="disabled"><input type="hidden" name="uppertype' . $i . $j . '" id="uppertype' . $i . $j . '" value="' . $seat_type . '" /></td>';
                    } else {
                        echo '<td width="40">&nbsp;</td>';
                    }
                }
                echo "</tr>";
            }
            echo "</table> <br /> <br />";

            echo '<table border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td colspan="' . $lower_cols . '">Lower Deck</td>
                    </tr>  
                 ';
            echo '<tr>
                    <td colspan="' . $lower_cols . '">';
            $sq = $this->db->query("select max(row) as lower_rows,max(col) as lower_cols from operator_layouts where model='$busmodel' and travel_id='$travel_id'  and (seat_type='L:s' or seat_type='L:b')") or die(mysql_error());
            foreach ($sq->result() as $row1) {
                $lower_rows = $row1->lower_rows;
                $lower_cols = $row1->lower_cols;
            }
            echo "<input type='hidden' name='lower_rows' id='lower_rows' value='$lower_rows' />
	        <input type='hidden' name='lower_cols' id='lower_cols' value='$lower_cols' />";

            echo '<table border="0" cellspacing="1" cellpadding="1">';
            for ($k = 1; $k <= $lower_rows; $k++) {
                echo '<tr>';
                for ($l = 1; $l <= $lower_cols; $l++) {
                    $sql3 = mysql_query("select * from operator_layouts where row='$k' and col='$l' and model='$busmodel' and travel_id='$travel_id' and (seat_type='L:s' or seat_type='L:b') ") or die(mysql_error());
                    $row2 = mysql_fetch_array($sql3);

                    $seat_name = $row2['seat_name'];
                    $seat_type = $row2['seat_type'];
                    $available = $row2['available'];
                    $seat_status = $row2['seat_status'];
                    if ($seat_name != "") {

                        echo '<td align="center" width="40" height="40" style="border:#666666 solid 2px"><input onchange="document.getElementById(\'ltxt' . $k . '-' . $l . '\').disabled=!this.checked;" class="chkbox" type="checkbox" name="lchk' . $k . '-' . $l . '" id="lchk' . $k . '-' . $l . '"/><input type="text" name="ltxt' . $k . '-' . $l . '" class="textbox" id="ltxt' . $k . '-' . $l . '" value="' . $seat_name . '" size="1" disabled="disabled"><input type="hidden" name="lowertype' . $k . $l . '" id="lowertype' . $k . $l . '" value="' . $seat_type . '" /></td>';
                    } else {
                        echo '<td width="40">&nbsp;</td>';
                    }
                }
                $i++;
                echo "</tr>";
            }
            echo "</table></td></tr></table>";
        }//else if($lid[1]=='seatersleeper')
    }

//getLayoutDb()
    //getting boarding points from table

    public function getBoardDb($fid, $from, $snum, $halts, $opid) {

        //echo "$opid";

        $fid12 = explode(",", $fid);
        $fid1_imp = array_unique($fid12);
        $imp = implode(",", $fid1_imp);
        $fid1 = explode(",", $imp);
        //print_r($fid1);

        $from12 = explode(",", $from);
        $from1_imp = array_unique($from12);
        $from_imp = implode(",", $from1_imp);
        $from1 = explode(",", $from_imp);

        $n = count($fid1);

        echo '
		 <script type="text/javascript" src="' . base_url('js/jquery-1.5.2.min.js') . '"></script>
		 <script type="text/javascript">
		
		
		function saveBoard()
		{
			var city_name="";
			var city_id="";
			var board_point="";
			var bpid="";
			var lm="";
			var hhST="";
			var mmST="";
			var ampmST="";
			var ival=$("#nval").val();
			
			var sernum=$("#sernum").val();
			var opid = $("#opid").val();
			
			
			for(var i=0;i<ival;i++)
			{
				var jval=$("#jval"+i).val();
				for(var j=0;j<jval;j++)
				{	
					if($("#timehrST"+i+j).val()!="HH" && $("#timemST"+i+j).val()!="MM" && $("#tfmST"+i+j).val()!="AMPM")
					{					
					
						if(city_name=="")
						{
							city_name=$("#cityname"+i+j).val();
						}
						else
						{
							city_name=city_name+"#"+$("#cityname"+i+j).val();
						} 
						if(city_id=="")
						{
							city_id=$("#cityid"+i+j).val();
						}
						else
						{
							city_id=city_id+"#"+$("#cityid"+i+j).val();
						} 
						if(board_point=="")
						{
							board_point=$("#bpname"+i+j).val();
						}
						else
						{
							board_point=board_point+"#"+$("#bpname"+i+j).val();
						} 
						if(bpid=="")
						{
							bpid=$("#bpid"+i+j).val();
						}
						else
						{
							bpid=bpid+"#"+$("#bpid"+i+j).val();
						}
						if(lm=="")
						{
							lm=$("#lm"+i+j).val();
						}
						else
						{
							lm=lm+"#"+$("#lm"+i+j).val();
						}  
						if(hhST=="")
						{
							hhST=$("#timehrST"+i+j).val();
						}
						else
						{
							hhST=hhST+"#"+$("#timehrST"+i+j).val();
						}
						if(mmST=="")
						{
							mmST=$("#timemST"+i+j).val();
						}
						else
						{
							mmST=mmST+"#"+$("#timemST"+i+j).val();
						}
						if(ampmST=="")
						{
							ampmST=$("#tfmST"+i+j).val();
						}
						else
						{
							ampmST=ampmST+"#"+$("#tfmST"+i+j).val();
						}										
					}					
					
				}				
			}				
			if(hhST=="" && mmST=="" && ampmST=="")
			{
				alert("Please select atleast one boarding point time");
				return false;
			}
			//alert(sernum);alert(city_name);alert(city_id);alert(board_point);alert(bpid);
			//alert(lm);
							$.post("saveBoard",{sernum:sernum,city_name:city_name,city_id:city_id,board_point:board_point,bpid:bpid,lm:lm,hhST:hhST,mmST:mmST,ampmST:ampmST,opid:opid},function(res)
			{
				//alert(res);
				if(res==1)
				{
					alert("Boarding points are saved successfully !!");
					window.close();
				}
				else
				{
					alert("There was a problem occurred, Try again");
				}
				
    		});
			 			 
		}
		</script>
		 
		 
		 
		 <table width="100%" border="1" >
		 		 <tr>
    <td width="19%" height="36" ><strong>City Name </strong></td>
    <td width="34%" >
    <strong>Board Point Name </strong></td>
    <td width="25%" ><strong>Time</strong></td>
    <td width="22%" ><strong>Landmark</strong></td>
  </tr>';

        for ($i = 0; $i < $n; $i++) {

            echo '<tr>
    				<td height="35"><strong>' . $from1[$i] . '</strong></td>
    				';
            echo'<td colspan="3">
					<table width="100%" border="0">
					';
            $sql = mysql_query("select * from board_drop_points where city_id='$fid1[$i]' and city_name='$from1[$i]' order by board_drop")or die(mysql_error());
            //$sql=mysql_query("select * from board_drop_points where city_id='$fid1[$i]'")or die(mysql_error());
            $j = 0;
            while ($row = mysql_fetch_array($sql)) {
                $hours = $this->getHours();
                $timehrST = 'id="timehrST' . $i . $j . '" ';
                $timenST = 'name="timehrST' . $i . $j . '" ';

                $hours1 = $this->getMinutes();

                $timemiST = 'id="timemST' . $i . $j . '"';
                $timemnST = 'name="timemST' . $i . $j . '"';

                $tfidST = 'id="tfmST' . $i . $j . '" ';
                $tfnameST = 'name="tfm' . $i . $j . '" style="width:50px"';

                $tfv = array("AMPM" => "-select-", "AM" => "AM", "PM" => "PM");

                $board_drop = $row['board_drop'];
                $id = $row['id'];
                echo '<tr>
        						<td width="42%" height="35"><strong>' . $board_drop . '</strong>
								<input type="hidden" name="cityname' . $i . $j . '" id="cityname' . $i . $j . '" value="' . $from1[$i] . '">
								<input type="hidden" name="cityid' . $i . $j . '" id="cityid' . $i . $j . '" value="' . $fid1[$i] . '">
								<input type="hidden" name="bpname' . $i . $j . '" id="bpname' . $i . $j . '" value="' . $board_drop . '">
								<input type="hidden" name="bpid' . $i . $j . '" id="bpid' . $i . $j . '" value="' . $id . '">
								<input type="hidden" name="opid" id="opid" value="' . $opid . '">
								</td>
						        <td width="31%">
								' . form_dropdown($timenST, $hours, $hr, $timehrST) . '' . form_dropdown($timemnST, $hours1, $hr1, $timemiST) . '' . form_dropdown($tfnameST, $tfv, $tf[1], $tfidST) . '</td>
						        <td width="27%"><input type="text" name="lm' . $i . $j . '" id="lm' . $i . $j . '" /></td>
							      </tr>';
                $j++;
            }

            echo'</table><input type="hidden" name="jval' . $i . '" id="jval' . $i . '" value="' . $j . '"></td>    				
  				 </tr>';
        }
        echo '<tr>
		 		   <input type="hidden" name="nval" id="nval" value="' . $n . '">
				   <input type="hidden" name="sernum" id="sernum" value="' . $snum . '">
		 		   <td height="36" colspan="4" align="center" ><input type="button" class="newsearchbtn" value="Save Boarding Poings" onClick="saveBoard()"></td>
		 		   </tr></table>';
    }

//getBoardDb()
    //getting droping points from database

    public function getDropDb($tid, $to, $snum, $halts, $opid) {
        //echo "$opid";

        $tid12 = explode(",", $tid);
        $tid1_imp = array_unique($tid12);
        $imp = implode(",", $tid1_imp);
        $tid1 = explode(",", $imp);
        //print_r($tid1);

        $to12 = explode(",", $to);
        $to1_imp = array_unique($to12);
        $to_imp = implode(",", $to1_imp);
        $to1 = explode(",", $to_imp);
        //print_r($to1);
        $n = count($tid1);

        echo '
		  <script type="text/javascript" src="' . base_url('js/jquery-1.5.2.min.js') . '"></script>
		 <script type="text/javascript">
		
		
		function saveDrop()
		{
			var city_name="";
			var city_id="";
			var drop_point="";
			var dpid="";
			var lm="";
			var hhST="";
			var mmST="";
			var ampmST="";
			var ival=$("#nval").val();
			
			var sernum=$("#sernum").val();
			var opid = $("#opid").val();
			for(var i=0;i<ival;i++)
			{
				var jval=$("#jval"+i).val();
				for(var j=0;j<jval;j++)
				{
					if($("#timehrST"+i+j).val()!="HH" && $("#timemST"+i+j).val()!="MM" && $("#tfmST"+i+j).val()!="AMPM")
					{					
					
						if(city_name=="")
						{
							city_name=$("#cityname"+i+j).val();
						}
						else
						{
							city_name=city_name+"#"+$("#cityname"+i+j).val();
						} 
						if(city_id=="")
						{
							city_id=$("#cityid"+i+j).val();
						}
						else
						{
							city_id=city_id+"#"+$("#cityid"+i+j).val();
						} 
						if(drop_point=="")
						{
							drop_point=$("#dpname"+i+j).val();
						}
						else
						{
							drop_point=drop_point+"#"+$("#dpname"+i+j).val();
						} 
						if(dpid=="")
						{
							dpid=$("#dpid"+i+j).val();
						}
						else
						{
							dpid=dpid+"#"+$("#dpid"+i+j).val();
						}
						if(lm=="")
						{
							lm=$("#lm"+i+j).val();
						}
						else
						{
							lm=lm+"#"+$("#lm"+i+j).val();
						}  
						if(hhST=="")
						{
							hhST=$("#timehrST"+i+j).val();
						}
						else
						{
							hhST=hhST+"#"+$("#timehrST"+i+j).val();
						}
						if(mmST=="")
						{
							mmST=$("#timemST"+i+j).val();
						}
						else
						{
							mmST=mmST+"#"+$("#timemST"+i+j).val();
						}
						if(ampmST=="")
						{
							ampmST=$("#tfmST"+i+j).val();
						}
						else
						{
							ampmST=ampmST+"#"+$("#tfmST"+i+j).val();
						}										
					}					
				}				
			}				
			if(hhST=="" && mmST=="" && ampmST=="")
			{
				alert("Please select atleast one Drop point time");
				return false;
			}
			//alert(sernum);alert(city_name);alert(city_id);alert(drop_point);alert(dpid);
			//alert(lm);
							$.post("saveDrop",{sernum:sernum,city_name:city_name,city_id:city_id,drop_point:drop_point,dpid:dpid,lm:lm,hhST:hhST,mmST:mmST,ampmST:ampmST,opid:opid},function(res)
			{
				//alert(res);
				if(res==1)
				{
					alert("Drop points are saved successfully !!");
					window.close();
				}
				else
				{
					alert("There was a problem occurred, Try again");
				}
				
    		});
			 			 
		}
		</script>
		 
		 <table width="100%" border="1" >
		 		 <tr>
    <td width="19%" height="36" ><strong>City Name </strong></td>
    <td width="34%" >
    <strong>Drop Point Name </strong></td>
    <td  align="center"><strong>Time</strong></td>
	<td width="22%" ><strong>Landmark</strong></td>
  </tr>';

        for ($i = 0; $i < $n; $i++) {

            echo '<tr>
    				<td height="35"><strong>' . $to1[$i] . '</strong></td>
    				';
            echo'<td colspan="3">
					<table width="100%" border="0">
					';
            $sql = mysql_query("select * from board_drop_points where city_id='$tid1[$i]' and city_name='$to1[$i]'")or die(mysql_error());
            $j = 0;
            while ($row = mysql_fetch_array($sql)) {
                $hours = $this->getHours();
                $timehrST = 'id="timehrST' . $i . $j . '" ';
                $timenST = 'name="timehrST' . $i . $j . '" ';

                $hours1 = $this->getMinutes();

                $timemiST = 'id="timemST' . $i . $j . '"';
                $timemnST = 'name="timemST' . $i . $j . '"';

                $tfidST = 'id="tfmST' . $i . $j . '" ';
                $tfnameST = 'name="tfm' . $i . $j . '" style="width:50px"';

                $tfv = array("AMPM" => "-select-", "AM" => "AM", "PM" => "PM");
                $board_drop = $row['board_drop'];
                $id = $row['id'];
                echo '<tr>
        						<td width="42%" height="35"><strong>' . $board_drop . '</strong>
								<input type="hidden" name="cityname' . $i . $j . '" id="cityname' . $i . $j . '" value="' . $to1[$i] . '">
								<input type="hidden" name="cityid' . $i . $j . '" id="cityid' . $i . $j . '" value="' . $tid1[$i] . '">
								<input type="hidden" name="dpname' . $i . $j . '" id="dpname' . $i . $j . '" value="' . $board_drop . '">
								<input type="hidden" name="dpid' . $i . $j . '" id="dpid' . $i . $j . '" value="' . $id . '">
								<input type="hidden" name="opid" id="opid" value="' . $opid . '">
								</td>
						        <td width="31%" colspan="2">
								' . form_dropdown($timenST, $hours, $hr, $timehrST) . '' . form_dropdown($timemnST, $hours1, $hr1, $timemiST) . '' . form_dropdown($tfnameST, $tfv, $tf[1], $tfidST) . '</td>
								<td width="27%"><input type="text" name="lm' . $i . $j . '" id="lm' . $i . $j . '" /></td>
						        </tr>';
                $j++;
            }

            echo'</table><input type="hidden" name="jval' . $i . '" id="jval' . $i . '" value="' . $j . '"></td>    				
  				 </tr>';
        }
        echo '<tr>
		 		   <input type="hidden" name="nval" id="nval" value="' . $n . '">
				   <input type="hidden" name="sernum" id="sernum" value="' . $snum . '">
		 		   <td height="36" colspan="4" align="center" ><input type="button" class="newsearchbtn" value="Save Drop Poings" onClick="saveDrop()"></td>
		 		   </tr></table>
';
    }

//getDropDb()
    //storing boarding points in temp table

    public function saveBoardDb($sernum, $city_name, $city_id, $board_point, $bpid, $lm, $hhST, $mmST, $ampmST, $opid) {
        //$travel_id=$this->session->userdata('travel_id');
        $travel_id = $opid;
        $city_names = explode("#", $city_name);
        $city_ids = explode("#", $city_id);
        $board_points = explode("#", $board_point);
        $hhSTs = explode("#", $hhST);
        $mmSTs = explode("#", $mmST);
        $ampmSTs = explode("#", $ampmST);
        $bpids = explode("#", $bpid);
        $lms = explode("#", $lm);
        $n = count($city_names);

        $sql1 = mysql_query("delete from temp_board where service_num='$sernum' and board_or_drop_type='board'") or die(mysql_error());
        //$d =date('H:i:s', strtotime($start_time1));
        for ($i = 0; $i < $n; $i++) {
            $arr_time1 = $hhSTs[$i] . ":" . $mmSTs[$i] . " " . $ampmSTs[$i];
            $d1 = date('H:i:s', strtotime($arr_time1));
            $bpname = $board_points[$i] . "#" . $d1 . "#" . $lms[$i];

            $sql = mysql_query("insert into temp_board(service_num,travel_id,city_id,city_name,board_or_drop_type,board_drop,board_time,bpdp_id,timing) values('$sernum','$travel_id','$city_ids[$i]','$city_names[$i]','board','$bpname','$d1','$bpids[$i]','$arr_time1')")or die(mysql_error());
        }
        if ($sql) {
            echo 1;
        } else {
            echo 0;
        }
    }

//saveBoardDb()
    //storing saveDropDb points in temp table

    public function saveDropDb($sernum, $city_name, $city_id, $board_point, $bpid, $lm, $hhST, $mmST, $ampmST, $opid) {
        $travel_id = $opid;

        $city_names = explode("#", $city_name);
        $city_ids = explode("#", $city_id);
        $board_points = explode("#", $board_point);
        $hhSTs = explode("#", $hhST);
        $mmSTs = explode("#", $mmST);
        $ampmSTs = explode("#", $ampmST);
        $bpids = explode("#", $bpid);
        $lms = explode("#", $lm);
        $n = count($city_names);

        $sql1 = mysql_query("delete from temp_board where service_num='$sernum' and board_or_drop_type='drop'") or die(mysql_error());

        for ($i = 0; $i < $n; $i++) {
            $arr_time1 = $hhSTs[$i] . ":" . $mmSTs[$i] . " " . $ampmSTs[$i];
            $d1 = date('h:i A', strtotime($arr_time1));
            $bpname = $board_points[$i] . "#" . $d1 . "#" . $lms[$i];

            $sql = mysql_query("insert into temp_board(service_num,travel_id,city_id,city_name,board_or_drop_type,board_drop,board_time,bpdp_id,timing) values('$sernum','$travel_id','$city_ids[$i]','$city_names[$i]','drop','$bpname','$d1','$bpids[$i]','$arr_time1')")or die(mysql_error());
        }
        if ($sql) {
            echo 1;
        } else {
            echo 0;
        }
    }

//saveDropDb()
    //checking boarding and drop points are inserted or not

    public function getBoardOrDropValDb() {
        $travel_id = $this->input->post('opid');
        $snum = $this->input->post('snum');
        $fids = $this->input->post('fids');
        $tids = $this->input->post('tids');

        $fid12 = explode(",", $fids);
        $fid1_imp = array_unique($fid12);
        $imp = implode(",", $fid1_imp);
        $fid1 = explode(",", $imp);
        $m = count($fid1);

        $tid12 = explode(",", $tids);
        $tid1_imp = array_unique($tid12);
        $imp = implode(",", $tid1_imp);
        $tid1 = explode(",", $imp);
        $n = count($tid1);

        $bp = 0;
        $dp = 0;
        for ($i = 0; $i < $m; $i++) {
            $sql = mysql_query("select count(*) as cnt from temp_board where service_num='$snum' and travel_id='$travel_id' and city_id='$fid1[$i]'")or die(mysql_error());
            //echo "select count(*) as cnt from temp_board where service_num='$snum' and travel_id='$travel_id' and city_id='$fid1[$i]'";
            while ($row = mysql_fetch_array($sql)) {
                $cnt = $row['cnt'];
            }
            if ($cnt > 0) {
                $bp = 1;
            }
        }

        for ($j = 0; $j < $n; $j++) {
            $sql1 = mysql_query("select count(*) as cnt1 from temp_board where service_num='$snum' and travel_id='$travel_id' and city_id='$tid1[$j]'")or die(mysql_error());
            //echo "select count(*) as cnt1 from temp_board where service_num='$snum' and travel_id='$travel_id' and city_id='$tid1[$j]'";
            while ($row = mysql_fetch_array($sql1)) {
                $cnt1 = $row['cnt1'];
            }
            if ($cnt1 > 0) {
                $dp = 1;
            }
        }
        if ($bp == 0) {
            echo 1; //boarding points
        } else if ($dp == 0) {
            echo 2; //drop points
        } else {
            echo 3; //success
        }
    }

//getBoardOrDropValDb()
    //***************** Save bus related code *******************/

    public function saveBusDetailsDb() {

        $travel_id = $this->input->post('opid');
        $sname = $this->input->post('sname');
        $snum = $this->input->post('snum');
        $service_from = $this->input->post('service_from');
        $service_to = $this->input->post('service_to');
		 $service_from_id = $this->input->post('service_from_id');
        $service_to_id = $this->input->post('service_to_id');
        $busmodel = $this->input->post('busmodel');
        $stype = $this->input->post('stype');
        $weeks = $this->input->post('weeks');
        $halts = $this->input->post('halts');
        $layout_type = $this->input->post('layout_type');
        $lower_seat_no1 = $this->input->post('lower_seat_no');
        $upper_seat_no1 = $this->input->post('upper_seat_no');
        $lower_rowcols1 = $this->input->post('lower_rowcols');
        $upper_rowcols1 = $this->input->post('upper_rowcols');
        $rows = $this->input->post('rows');
        $cols = $this->input->post('cols');
        $lower_rows = $this->input->post('lower_rows');
        $lower_cols = $this->input->post('lower_cols');
        $upper_rows = $this->input->post('upper_rows');
        $upper_cols = $this->input->post('upper_cols');
        $fids = $this->input->post('fids');
        $tids = $this->input->post('tids');
        $froms = $this->input->post('froms');
        $tos = $this->input->post('tos');
        $sfares = $this->input->post('sfares');
        $lbfares = $this->input->post('lbfares');
        $ubfares = $this->input->post('ubfares');
        $hhST = $this->input->post('hhST');
        $mmST = $this->input->post('mmST');
        $ampmST = $this->input->post('ampmST');
        $hhAT = $this->input->post('hhAT');
        $mmAT = $this->input->post('mmAT');
        $ampmAT = $this->input->post('ampmAT');
        $lowertype1 = $this->input->post('lowertype');
        $uppertype1 = $this->input->post('uppertype');
        $title = $this->input->post('title');
        $trip_type = $this->input->post('trip_type');
        $service_tax = $this->input->post('service_tax');
        
        $jtimehr = $this->input->post('jtimehr');
        $jtimemn = $this->input->post('jtimemn');
        $currency = $this->input->post('currency');
		$stageorder = $this->input->post('stageorder');
		$ssmd = $this->input->post('ssmd'); //sigle source multi destination
		
		

        $fids1 = explode(",", $fids);
        $tids1 = explode(",", $tids);
        $froms1 = explode(",", $froms);
        $tos1 = explode(",", $tos);
        $sfares1 = explode(",", $sfares);
        $lbfares1 = explode(",", $lbfares);
        $ubfares1 = explode(",", $ubfares);
        $hhST1 = explode(",", $hhST);
        $mmST1 = explode(",", $mmST);
        $ampmST1 = explode(",", $ampmST);
        $hhAT1 = explode(",", $hhAT);
        $mmAT1 = explode(",", $mmAT);
        $ampmAT1 = explode(",", $ampmAT);
        
         $currency1 = explode(",", $currency);
         $jtimemn1 = explode(",", $jtimemn);
         $jtimehr1 = explode(",", $jtimehr);
		 $stageorder1 = explode(",", $stageorder);

        $sql_ser = mysql_query("select count(*) as cnt from master_buses where service_num='$snum'") or die(mysql_error());
        $row1 = mysql_fetch_array($sql_ser);
        $cnt = $row1['cnt'];
		
		
		$sql_routes = mysql_query("select count(*) as cnt from master_routes_international where service_num='$snum'") or die(mysql_error());
        $row2 = mysql_fetch_array($sql_routes);
        $cnt2 = $row2['cnt'];
		
		$route_id = 0;
		
		$sql_stage = mysql_query("select count(*) as cnt from master_operator_stages where service_num='$snum'") or die(mysql_error());
        $row3 = mysql_fetch_array($sql_stage);
        $cnt3 = $row3['cnt'];

        if ($cnt == 0  && $cnt2==0 && $cnt3==0) {
			
			$insert_route_sql = mysql_query("INSERT INTO master_routes_international (source_id, source_name, destination_id,destination_name,operator_id,service_num) VALUES ('$service_from_id', '$service_from', '$service_to_id', '$service_to', '$travel_id', '$snum')") or die(mysql_error());
			
			 
			  if($insert_route_sql)
			  {
			     $resultt = mysql_query("SELECT route_id FROM master_routes_international where service_num='$snum' ");
			     $roww = mysql_fetch_array($resultt);
			     $route_id = $roww['route_id'];
			  }
			  
			  

            /*             * ******************** Boarding Points Related ******************* */

            $sqlb = mysql_query("select * from temp_board where service_num='$snum' and travel_id='$travel_id' and city_id<>'undefined'") or die(mysql_error());
            while ($row = mysql_fetch_array($sqlb)) {
                $service_num = $row['service_num'];
                $travel_id = $row['travel_id'];
                $city_id = $row['city_id'];
                $city_name = $row['city_name'];
                $board_or_drop_type = $row['board_or_drop_type'];
                $board_drop = $row['board_drop'];
                $board_time = $row['board_time'];
                $bpdp_id = $row['bpdp_id'];
                $timing = $row['timing'];

                $sqlI = mysql_query("insert into boarding_points(is_van,service_num,travel_id,city_id,city_name,board_or_drop_type,board_drop,board_time,bpdp_id,contact,bus_no,timing) values('no','$service_num','$travel_id','$city_id','$city_name','$board_or_drop_type','$board_drop','$board_time','$bpdp_id','','','$timing')") or die(mysql_error());
            }

            /*             * ******************** Boarding Points Related End******************* */
            /*             * ************************** Layout related ***************** */

            $lower_seat_no2 = explode('#', $lower_seat_no1);
            $lower_rowcols2 = explode('#', $lower_rowcols1);
            $upper_seat_no2 = explode('#', $upper_seat_no1);
            $upper_rowcols2 = explode('#', $upper_rowcols1);
            $lowertype2 = explode('#', $lowertype1);
            $uppertype2 = explode('#', $uppertype1);

            $chkcnt = count($lower_seat_no2);

            if ($layout_type == 'seater') {

                for ($l = 0; $l < $chkcnt; $l++) {
                    $lower_seat_no = $lower_seat_no2[$l];

                    $lower_rowcols = explode('-', $lower_rowcols2[$l]);

                    $lower_row = $lower_rowcols[0];
                    $lower_col = $lower_rowcols[1];

                    if ($rows == 1) {
                        $window = 1;
                    }
                    if ($rows == 2 || $rows == 3) {
                        if ($lower_row == 1) {
                            $window = 1;
                        } else {
                            $window = 0;
                        }
                    } else if ($rows == 4) {
                        if ($lower_row == 1 || $lower_row == 4) {
                            $window = 1;
                        } else {
                            $window = 0;
                        }
                    } else if ($rows == 5) {
                        if ($lower_row == 1 || $lower_row == 5) {
                            $window = 1;
                        } else {
                            $window = 0;
                        }
                    } else {
                        $window = 0;
                    }

                    $seat_type = "s";
                    $is_ladies = 0;
                    $layout_id = $travel_id . "#" . $layout_type;

                    $sql2 = $this->db->query("insert into master_layouts(travel_id,layout_id,seat_name,row,col,seat_type,window,is_ladies,service_num,seat_status,available,available_type,fare,lberth_fare,uberth_fare,status) values('$travel_id','$layout_id','$lower_seat_no','$lower_col','$lower_row','$seat_type','$window','$is_ladies','$snum','0','0','0','0','0','0','0')");
                }
            }//if($layout_type=='seater')
            else if ($layout_type == 'sleeper') {
                for ($l = 0; $l < count($lower_seat_no2); $l++) {
                    $lower_seat_no = $lower_seat_no2[$l];

                    $lower_rowcols = explode('-', $lower_rowcols2[$l]);

                    $lower_row = $lower_rowcols[0];
                    $lower_col = $lower_rowcols[1];

                    if ($lower_rows == 1 || $lower_rows == 2) {
                        $window = 1;
                    } else if ($lower_rows == 4) {
                        if ($lower_row == 1 || $lower_row == 4) {
                            $window = 1;
                        } else {
                            $window = 0;
                        }
                    } else if ($lower_rows == 5) {
                        if ($lower_row == 1 || $lower_row == 5) {
                            $window = 1;
                        } else {
                            $window = 0;
                        }
                    }

                    $seat_type = "L";
                    $is_ladies = 0;
                    $layout_id = $travel_id . "#" . $layout_type;

                    //echo "lower_rows".$lower_rows." # window".$window;

                    $sql2 = $this->db->query("insert into master_layouts(travel_id,layout_id,seat_name,row,col,seat_type,window,is_ladies,service_num,seat_status,available,available_type,fare,lberth_fare,uberth_fare,status) values('$travel_id','$layout_id','$lower_seat_no','$lower_col','$lower_row','$seat_type','$window','$is_ladies','$snum','0','0','0','0','0','0','0')");
                }

                for ($u = 0; $u < count($upper_seat_no2); $u++) {
                    $upper_seat_no = $upper_seat_no2[$u];

                    $upper_rowcols = explode('-', $upper_rowcols2[$u]);

                    $upper_row = $upper_rowcols[0];
                    $upper_col = $upper_rowcols[1];

                    if ($upper_rows == 1 || $upper_rows == 2) {
                        $window = 1;
                    } else if ($upper_rows == 4) {
                        if ($upper_row == 1 || $upper_row == 4) {
                            $window = 1;
                        } else {
                            $window = 0;
                        }
                    } else if ($upper_rows == 5) {
                        if ($upper_row == 1 || $upper_row == 5) {
                            $window = 1;
                        } else {
                            $window = 0;
                        }
                    }

                    $seat_type = "U";
                    $is_ladies = 0;
                    $layout_id = $travel_id . "#" . $layout_type;

                    $sql3 = $this->db->query("insert into master_layouts(travel_id,layout_id,seat_name,row,col,seat_type,window,is_ladies,service_num,seat_status,available,available_type,fare,lberth_fare,uberth_fare,status) values('$travel_id','$layout_id','$upper_seat_no','$upper_col','$upper_row','$seat_type','$window','$is_ladies','$snum','0','0','0','0','0','0','0')");
                }
            }//else if($layout_type=='sleeper')
            else if ($layout_type == 'seatersleeper') {

                for ($l = 0; $l < count($lower_seat_no2); $l++) {
                    $lower_seat_no = $lower_seat_no2[$l];

                    $lower_rowcols = explode('-', $lower_rowcols2[$l]);

                    $lower_row = $lower_rowcols[0];
                    $lower_col = $lower_rowcols[1];

                    if ($lower_rows == 1 || $lower_rows == 2) {
                        $window = 1;
                    } else if ($lower_rows == 4) {
                        if ($lower_row == 1 || $lower_row == 4) {
                            $window = 1;
                        } else {
                            $window = 0;
                        }
                    } else if ($lower_rows == 5) {
                        if ($lower_row == 1 || $lower_row == 5) {
                            $window = 1;
                        } else {
                            $window = 0;
                        }
                    }

                    $seat_type = $lowertype2[$l];
                    $is_ladies = 0;
                    $layout_id = $travel_id . "#" . $layout_type;

                    $sql2 = $this->db->query("insert into master_layouts(travel_id,layout_id,seat_name,row,col,seat_type,window,is_ladies,service_num,seat_status,available,available_type,fare,lberth_fare,uberth_fare,status) values('$travel_id','$layout_id','$lower_seat_no','$lower_col','$lower_row','$seat_type','$window','$is_ladies','$snum','0','0','0','0','0','0','0')");
                }

                for ($u = 0; $u < count($upper_seat_no2); $u++) {
                    $upper_seat_no = $upper_seat_no2[$u];

                    $upper_rowcols = explode('-', $upper_rowcols2[$u]);

                    $upper_row = $upper_rowcols[0];
                    $upper_col = $upper_rowcols[1];

                    if ($upper_rows == 1 || $upper_rows == 2) {
                        $window = 1;
                    } else if ($upper_rows == 4) {
                        if ($upper_row == 1 || $upper_row == 4) {
                            $window = 1;
                        } else {
                            $window = 0;
                        }
                    } else if ($upper_rows == 5) {
                        if ($upper_row == 1 || $upper_row == 5) {
                            $window = 1;
                        } else {
                            $window = 0;
                        }
                    }

                    $seat_type = $uppertype2[$u];
                    $is_ladies = 0;
                    $layout_id = $travel_id . "#" . $layout_type;

                    $sql3 = $this->db->query("insert into master_layouts(travel_id,layout_id,seat_name,row,col,seat_type,window,is_ladies,service_num,seat_status,available,available_type,fare,lberth_fare,uberth_fare,status) values('$travel_id','$layout_id','$upper_seat_no','$upper_col','$upper_row','$seat_type','$window','$is_ladies','$snum','0','0','0','0','0','0','0')");
                }
            }//seatersleeper





            /*             * ************************** Layout related End ***************** */
            /*             * ********* inserting master buses ************* */

            //code for seat count
            if ($layout_type == 'seater') {
                $seat_nos = count($lower_seat_no2);
                $lowerdeck_nos = 0;
                $upperdeck_nos = 0;
            } else if ($layout_type == 'sleeper') {
                $seat_nos = 0;
                $lowerdeck_nos = count($lower_seat_no2);
                $upperdeck_nos = count($upper_seat_no2);
            } else {
                $seat_nos = 0;
                $lowerdeck_nos = count($lower_seat_no2);
                $upperdeck_nos = count($upper_seat_no2);
            }
            //code for service type ex: normal or special or weekly
            if ($stype == 'daily') {
                $serviceType = "normal";
            } else if ($stype == 'special') {
                $serviceType = "special";
            } else if ($stype == 'weekly') {
                $serviceType = "weekly";
            }
            $service_num = $snum;
            $travel_id = $travel_id;
            $model = $busmodel;
            $bus_type = $layout_type;


            $status = 0;
            //$service_route = $service_from." To ".$service_to;
            $service_name = $sname;

            for ($i = 0; $i < $halts; $i++) {
                $from_id = $fids1[$i];
                $from_name = $froms1[$i];
                $to_id = $tids1[$i];
                $to_name = $tos1[$i];
                $service_route = $from_name . " To " . $to_name;
                if ($layout_type == 'seater') {
                    $seat_fare = $sfares1[$i];
                    $lberth_fare = "";
                    $uberth_fare = "";
                } else if ($layout_type == 'sleeper') {
                    $seat_fare = "";
                    $lberth_fare = $lbfares1[$i];
                    $uberth_fare = $ubfares1[$i];
                } else {
                    $seat_fare = $sfares1[$i];
                    $lberth_fare = $lbfares1[$i];
                    $uberth_fare = $ubfares1[$i];
                }

                $start_time1 = $hhST1[$i] . ":" . $mmST1[$i] . " " . $ampmST1[$i];
                $arr_time1 = $hhAT1[$i] . ":" . $mmAT1[$i] . "" . $ampmAT1[$i];
                $d = date('H:i:s', strtotime($start_time1));
                $d1 = date('H:i:s', strtotime($arr_time1));
                $d2 = strtotime($d);
                $d3 = strtotime($d1);
                $diff = $d2 - $d3;


                $start_time = $d;
                $arr_time = $arr_time1;
               // $journey_time = date('H:i:s', ($diff));
               // $journey_time = '0:0:0';
               $journey_time1=$jtimehr1[$i] . ":" . $jtimemn1[$i];
               $journey_time = date('H:i:s', strtotime($journey_time1));
               $cur =  $currency1[$i] ;

                //echo $start_time."#".$start_time1."#".$arr_time1."#".$d1."#".$journey_time."#".$diff;		
                if($halts==1) $rr = 1;
                else  $rr = $halts-1;
                
				 if($insert_route_sql &&  $i!=$rr && $ssmd==0)
			  {
                $cityOrder = $stageorder1[$i];
				$stagordersql = mysql_query("INSERT INTO master_operator_stages (operator_id,stage_city_id,stage_city_name,stage_order,route_id,service_num) VALUES ('$travel_id', '$from_id', '$from_name', '$cityOrder', '$route_id', '$service_num')")  or die(mysql_error());
				
			  }
			  
			  if($ssmd==1)
			  {
			    
			    if($i==0)
			    {
			      $cityOrder =1;
			      $stagordersql = mysql_query("INSERT INTO master_operator_stages (operator_id,stage_city_id,stage_city_name,stage_order,route_id,service_num) VALUES ('$travel_id', '$from_id', '$from_name', '$cityOrder', '$route_id', '$service_num')")  or die(mysql_error());
				   
			    }
			      $cityOrder =2;
			      $stagordersql = mysql_query("INSERT INTO master_operator_stages (operator_id,stage_city_id,stage_city_name,stage_order,route_id,service_num) VALUES ('$travel_id', '$to_id', '$to_name', '$cityOrder', '$route_id', '$service_num')")  or die(mysql_error());
				    
			    
				
			  }
			  
			  
			    $sql = mysql_query("insert into master_buses(serviceType,service_num,travel_id,from_id,from_name,to_id,to_name,start_time,journey_time,arr_time,model,bus_type,seat_nos,lowerdeck_nos,upperdeck_nos,seat_fare,lberth_fare,uberth_fare,status,service_route,service_name,service_days,title,service_tax,trip_type,currency) values('$serviceType','$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$start_time','$journey_time','$arr_time','$model','$bus_type','$seat_nos','$lowerdeck_nos','$upperdeck_nos','$seat_fare','$lberth_fare','$uberth_fare','$status','$service_route','$service_name','$weeks','$title','$service_tax','$trip_type','$cur')") or die(mysql_error());
                echo "insert into master_buses(serviceType,service_num,travel_id,from_id,from_name,to_id,to_name,start_time,journey_time,arr_time,model,bus_type,seat_nos,lowerdeck_nos,upperdeck_nos,seat_fare,lberth_fare,uberth_fare,status,service_route,service_name,service_days,title,service_tax,trip_type) values('$serviceType','$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$start_time','$journey_time','$arr_time','$model','$bus_type','$seat_nos','$lowerdeck_nos','$upperdeck_nos','$seat_fare','$lberth_fare','$uberth_fare','$status','$service_route','$service_name','$weeks','$title','$service_tax','$trip_type')";
                $query = mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,seat_fare,lberth_fare,uberth_fare) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$seat_fare','$lberth_fare','$uberth_fare')");
            }

        if($halts==1) $so = $halts+1;
        else $so = $halts;
        if($stagordersql && $ssmd==0){
        $stagordersql2 = mysql_query("INSERT INTO master_operator_stages (operator_id, stage_city_id, stage_city_name, stage_order, route_id,service_num) VALUES ('$travel_id', '$service_to_id', '$service_to', '$so', '$route_id', '$service_num')")  or die(mysql_error());
        }	
            /*             * ********* inserting master buses ************* */
        }//service is there or not
        else {
            echo 1;
        }
    }

//saveBusDetailsDb()
    //***************** Save bus related code *******************/
    function addpakage_details() {
        $srvno = $this->input->post('service');
        $travid = $this->input->post('opid');

        $stmt = "select distinct from_id,from_name from master_buses where service_num='$srvno' and travel_id='$travid'";
        $query = $this->db->query($stmt);

        $stmt1 = "select distinct to_id,to_name from master_buses where service_num='$srvno' and travel_id='$travid'";
        $query1 = $this->db->query($stmt1);

        echo '<table width="72%" cellspacing="1" cellpadding="1" style="margin-top:40px;">
	<tr>
		<td height="30">&nbsp;</td>
		<td>From</td>
		<td><select name="from_id" id="from_id">
                <option value="0">-- Select --</option>';
        foreach ($query->result() as $row) {
            echo '<option value="' . $row->from_id . '">' . $row->from_name . '</option>';
        }
        echo'
		</select>		</td>
		<td>&nbsp;</td>
		<td>To</td>
		<td><select name="to_id" id="to_id">
                <option value="0">-- Select --</option>';
        foreach ($query1->result() as $row) {
            echo '<option value="' . $row->to_id . '">' . $row->to_name . '</option>';
        }
        echo'
		</select>		</td>
		<td>&nbsp;</td>
		<td>Details</td>
		<td><textarea name="details" id="details"></textarea></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height="30">&nbsp;</td>
		<td colspan="8" align="center"><input type="button" class="newsearchbtn" id="save" value="Save" onClick="add_pkg(\'' . $srvno . '\',' . $travid . ')" style="padding:5px 20px"></td>
		<td>&nbsp;</td>
	</tr>
</table>
';
    }

    public function addpakage_details_db1() {
        $service_num = $this->input->post('service_no');
        $travel_id = $this->input->post('travel_id');
        $from_id = $this->input->post('from_id');
        $to_id = $this->input->post('to_id');
        $details = $this->input->post('details');
        $sql = mysql_query("select * from package_details where service_num ='$service_num' and from_id ='$from_id' and to_id ='$to_id'") or die(mysql_error());
        
        if (mysql_num_rows($sql) != "") {
            $sql1 = mysql_query("update package_details set trip_details = '$details' where service_num ='$service_num' and from_id ='$from_id' and to_id ='$to_id' ") or die(mysql_error());
        } else {
            $sql1 = mysql_query("insert into package_details(travel_id,service_num,from_id,to_id,trip_details) values('$travel_id','$service_num','$from_id','$to_id','$details')") or die(mysql_error());
        }

        if ($sql1) {
            return 1;
        } else {
            return 0;
        }
    }

}

//class
?>