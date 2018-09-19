<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of changedfare
 *
 * @author svprasadk
 */
class changedfare extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('cookie');
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->helper('csv');
        $this->load->helper('pdf');
        $this->load->library('table');
        $this->load->model('changedfare1'); //calling the model
        $this->load->model('createbus_model'); //calling the model
        $this->load->model('modellogin');
    }
	
	public function getservice(){
	
	$service = $this->changedfare1->getservic_modify();
	print_r($service);
	
	}

    public function changefare() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['operators'] = $this->modellogin->get_operator();
            
            $this->load->view('bus/changefare', $data);
        }
    }

    //to display the selected service or all services 
    function getRoutes() {
        $travel_id = $this->input->post('opid');
        $service_num = $this->input->post('service_num');
        $service_name = $this->input->post('service_name');
        $current_date = date('Y-m-d');
        $city_id = $this->input->post('city_id');
        $service_route = $this->input->post('service_route');
        //echo $service_num."#".$service_route."#".$city_id;
        $query = $this->changedfare1->getRoutesFromDb($travel_id, $service_num, $service_name, $service_route, $city_id);
        //print_r($query->result());		        	    

        foreach ($query->result() as $row) {
            $model = $row->model;
            $bus_type = $row->bus_type;
            $from_id = $row->from_id;
            $from_name = $row->from_name;
            $to_id = $row->to_id;
            $to_name = $row->to_name;
        }

        $query1 = $this->changedfare1->getfaresFromDb($travel_id, $service_num, $service_name, $current_date, $from_id, $to_id);
        foreach ($query1->result() as $row1) {
            $mseat_fare = $row1->seat_fare;
            $mlberth_fare = $row1->lberth_fare;
            $muberth_fare = $row1->uberth_fare;
        }
        $sql = mysql_query("select * from master_price where service_num='$service_num' and from_id='$from_id' and to_id='$to_id' and travel_id='$travel_id' and journey_date='$current_date'") or die(mysql_error());

        if (mysql_num_rows($sql) == 0) {
            $sql = mysql_query("select * from master_price where service_num='$service_num'  and from_id='$from_id' and to_id='$to_id'  and travel_id='$travel_id' and journey_date IS NULL") or die(mysql_error());

            if (mysql_num_rows($sql) == 0) {
                $sql2 = mysql_query("select * from buses_list where service_num='$service_num' and from_id='$from_id' and to_id='$to_id' and travel_id='$travel_id' and journey_date='$current_date'");
            }
        }

        $row = mysql_fetch_assoc($sql);

        $seat_fare = $row['seat_fare'];
        $lberth_fare = $row['lberth_fare'];
        $uberth_fare = $row['uberth_fare'];
        $seat_fare_changed = $row['seat_fare_changed'];
        $lberth_fare_changed = $row['lberth_fare_changed'];
        $uberth_fare_changed = $row['uberth_fare_changed'];

        echo '
	<style type="text/css">
	.tdborder
	{
            border:#CCCCCC solid 1px;
            padding-left:5px;
	}
        .input
        {
            width:40px;
            height:30px;
            text-align:center;
        }    
	</style>
	<script type="text/javascript">
	$(function() 
	{                                              
            $( "#fdate" ).datepicker({ dateFormat: "yy-mm-dd",numberOfMonths: 1, showButtonPanel: false,minDate: 0});
	    $( "#tdate" ).datepicker({ dateFormat: "yy-mm-dd",numberOfMonths: 1, showButtonPanel: false,minDate: 0});
	});
	
	</script>
	<script type="text/javascript"> 


$(document).ready(function()
{ 

	$("#price_mode").change(function()
	{ 
	   var price=$("#price_mode").val();
    	
		if(price=="permanently" || price == "")
		{
		$("#tbl").hide();
		}
		else
		{
		$("#tbl").show();
    
	    }
		
  	});
});
</script>
	<table width="73%" align="center" cellpadding="0" cellspacing="0" style="border:#CCCCCC solid 1px;">
            <tr>
		<td height="27" colspan="4" bgcolor="#2FA4E7" style="color:#FFFFFF; padding-left:5px;"><strong>' . $service_route . '</strong></td>
            </tr>
            <tr>
                <td width="146" height="31"  class="tdborder"><strong>Source:</strong></td>
		<td class="tdborder">' . $from_name . '</td>
		<td width="88" class="tdborder"><strong>Destination:</strong></td>
		<td width="115" class="tdborder">' . $to_name . '</td>
            </tr>
            <tr>
                <td height="37" class="tdborder"><strong>Service mode: </strong></td>
		<td class="tdborder">Daily</td>
		<td class="tdborder"><strong>Bus Type: </strong></td>
		<td class="tdborder"> ' . $model . '</td>
            </tr>
	</table>
	<br/><br/>
        <table width="73%" border="0" align="center">
  <tr>
    <td>Fare Save Mode</td>
    <td><select id="price_mode" name="price_mode" class="inputfield" >
      <option value=""> -- Select  Mode --</option>
      <option value="permanently"> Permanent </option>
      <option value="temporary"> Temporary </option>
    </select></td>
    <td>&nbsp;</td>
    <td>Fare Save Route</td>
    <td>';
        $result = $this->changedfare1->getroute2($service_num, $city_id ,$travel_id);
        echo'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr id="tbl" style="display:none">
    <td>From  Date</td>
    <td><input type="text" name="fdate"  class="inputfield" id="fdate" value="' . Date("Y-m-d") . '"   /></td>
    <td>&nbsp;</td>
    <td>To    Date</td>
    <td><input type="text" name="tdate" class="inputfield" id="tdate"   value="' . Date("Y-m-d") . '"/></td>
  </tr>
</table>
        <table width="83%" border="0" align="center" style="border:#CCCCCC solid 1px;">
            <tr>
                <td width="100%" bgcolor="#2FA4E7" style="color:#FFFFFF"><strong>Individual Seat Fare</strong>*</td>
            </tr>
            <tr>
                <td height="26" align="center">';
        if ($bus_type == "seater") {
            //$sfare = $row->seat_fare;

            $query1 = $this->db->query("select max(row) as mrow,max(col) as mcol from master_layouts where service_num='$service_num' and travel_id='$travel_id'")or die(mysql_error());
            foreach ($query1->result() as $row1) {
                $lower_rows = $row1->mrow;
                $lower_cols = $row1->mcol;
            }

            echo '<table border="0" cellspacing="1" cellpadding="1" style="padding:5px 5px 5px 5px; font-size:16px; calibri;">';
            for ($i = 1; $i <= $lower_cols; $i++) {
                echo '<tr>';
                for ($j = 1; $j <= $lower_rows; $j++) {
                    $query2 = mysql_query("select * from master_layouts where service_num='$service_num' and travel_id='$travel_id' and row='$j' and col='$i' and seat_type='s'")or die(mysql_error());
                    $row2 = mysql_fetch_array($query2);
                    $seat_name = trim($row2['seat_name']);

                    $seat_fare_changed2 = explode('@', $seat_fare_changed);
                    for ($a = 0; $a < count($seat_fare_changed2); $a++) {
                        $seat_fare_changed3 = explode('#', $seat_fare_changed2[$a]);
                        $fseat = $seat_fare_changed3[0];
                        $ffare = $seat_fare_changed3[1];

                        if ($fseat == $seat_name) {
                            $seat_fare1 = $ffare;
                            break;
                        } else {
                            $seat_fare1 = $seat_fare;
                        }
                    }
                    if ($seat_name != "") {
                        echo '<td width="50" height="50" align="center">' . $seat_name . '<br /><input type="hidden" name="ltxt' . $j . '-' . $i . '" id="ltxt' . $j . '-' . $i . '" value="' . $seat_name . '" class="input" /><input type="text" name="sfare' . $j . '-' . $i . '" id="sfare' . $j . '-' . $i . '" value="' . $seat_fare1 . '" class="input" /></td>';
                    } else {
                        echo '<td width="50" height="50" align="center">&nbsp;</td>';
                    }
                }
                echo '</tr><tr><td>&nbsp;</td></tr>';
            }
            echo '</table>';
        }
        if ($bus_type == "sleeper") {
            //$lfare = $row->lberth_fare; 
            //$ufare = $row->uberth_fare;
            $query = $this->db->query("select count(distinct seat_name) as seats_count from master_layouts where service_num='$service_num' and travel_id='$travel_id'")or die(mysql_error());
            foreach ($query->result() as $row) {
                $seats_count = $row->seats_count;
            }

            $query1 = $this->db->query("select max(row) as mrow,max(col) as mcol from master_layouts where service_num='$service_num' and travel_id='$travel_id' and seat_type='U'")or die(mysql_error());
            foreach ($query1->result() as $row1) {
                $upper_rows = $row1->mrow;
                $upper_cols = $row1->mcol;
            }

            $query3 = $this->db->query("select max(row) as mrow,max(col) as mcol from master_layouts where service_num='$service_num' and travel_id='$travel_id' and seat_type='L'")or die(mysql_error());
            foreach ($query3->result() as $row3) {
                $lower_rows = $row3->mrow;
                $lower_cols = $row3->mcol;
            }

            if ($seats_count >= 30 || $seats_count <= 40) {
                echo '<table width="50%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td height="30">&nbsp;</td>
    <td align="center">Double Berth </td>
    <td align="center">Single Berth </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td align="center"><input type="text" name="double_berth" id="double_berth" value="" class="input" /></td>
    <td align="center"><input type="text" name="single_berth" id="single_berth" value="" class="input" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td><input type="hidden" name="seats_count" id="seats_count" value="' . $seats_count . '" class="input" />
	<input type="hidden" name="max_rows" id="max_rows" value="' . $upper_rows . '" class="input" />
	<input type="hidden" name="max_cols" id="max_cols" value="' . $upper_cols . '" class="input" />
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
';
                //Upper 
                for ($i = 1; $i <= $upper_cols; $i++) {
                    for ($j = 1; $j <= $upper_rows; $j++) {
                        $query2 = $this->db->query("select * from master_layouts where service_num='$service_num' and travel_id='$travel_id' and row='$j' and col='$i' and seat_type='U'")or die(mysql_error());
                        foreach ($query2->result() as $row2) {
                            $seat_name = trim($row2->seat_name);

                            echo '
									<input type="hidden" name="utxt' . $j . '-' . $i . '" id="utxt' . $j . '-' . $i . '" value="' . $seat_name . '" class="input" />									                  
									<input type="hidden" name="ucol' . $j . '-' . $i . '" id="ucol' . $j . '-' . $i . '" value="' . $i . '" class="input" />';
                        }
                    }
                }

                //Lower                    
                for ($i = 1; $i <= $lower_cols; $i++) {
                    for ($j = 1; $j <= $lower_rows; $j++) {
                        $query2 = $this->db->query("select * from master_layouts where service_num='$service_num' and travel_id='$travel_id' and row='$j' and col='$i' and seat_type='L'")or die(mysql_error());
                        foreach ($query2->result() as $row2) {
                            $seat_name = trim($row2->seat_name);

                            echo '<input type="hidden" name="ltxt' . $j . '-' . $i . '" id="ltxt' . $j . '-' . $i . '" value="' . $seat_name . '" class="input" />									                  
									<input type="hidden" name="lcol' . $j . '-' . $i . '" id="lcol' . $j . '-' . $i . '" value="' . $i . '" class="input" />';
                        }
                    }
                }
            } else {
                echo '<table border="0" cellspacing="1" cellpadding="1" style="padding:5px 5px 5px 5px; font-size:16px; calibri;">';
                echo '<tr><td>Upper</td></tr><tr><td>&nbsp;</td></tr>';
                for ($i = 1; $i <= $upper_cols; $i++) {
                    echo '<tr>';
                    for ($j = 1; $j <= $upper_rows; $j++) {
                        $query2 = mysql_query("select * from master_layouts where service_num='$service_num' and travel_id='$travel_id' and row='$j' and col='$i' and seat_type='U'")or die(mysql_error());
                        $row2 = mysql_fetch_array($query2);
                        $seat_name = trim($row2['seat_name']);

                        $uberth_fare_changed2 = explode('@', $uberth_fare_changed);
                        for ($a = 0; $a < count($uberth_fare_changed2); $a++) {
                            $uberth_fare_changed3 = explode('#', $uberth_fare_changed2[$a]);
                            $fseat = trim($uberth_fare_changed3[0]);
                            $ffare = $uberth_fare_changed3[1];

                            if ($fseat == $seat_name) {
                                $uberth_fare1 = $ffare;
                                break;
                            } else {
                                $uberth_fare1 = $uberth_fare;
                            }
                        }
                        if ($seat_name != '') {
                            echo '<td width="50" height="50" align="center">' . $seat_name . '<br /><input type="hidden" name="utxt' . $j . '-' . $i . '" id="utxt' . $j . '-' . $i . '" value="' . $seat_name . '" class="input" /><input type="text" name="ufare' . $j . '-' . $i . '" id="ufare' . $j . '-' . $i . '" value="' . $uberth_fare1 . '" class="input" /></td>';
                        } else {
                            echo '<td width="50" height="50" align="center">&nbsp;</td>';
                        }
                    }
                    echo '</tr><tr><td>&nbsp;</td></tr>';
                }
                echo '</table><br />';


                echo '<table border="0" cellspacing="1" cellpadding="1" style="padding:5px 5px 5px 5px; font-size:16px; calibri;">';
                echo '<tr><td>Lower</td></tr><tr><td>&nbsp;</td></tr>';
                for ($i = 1; $i <= $lower_cols; $i++) {
                    echo '<tr>';
                    for ($j = 1; $j <= $lower_rows; $j++) {
                        $query2 = mysql_query("select * from master_layouts where service_num='$service_num' and travel_id='$travel_id' and row='$j' and col='$i' and seat_type='L'")or die(mysql_error());
                        $row2 = mysql_fetch_array($query2);
                        $seat_name = trim($row2['seat_name']);

                        $lberth_fare_changed2 = explode('@', $lberth_fare_changed);
                        for ($a = 0; $a < count($lberth_fare_changed2); $a++) {
                            $lberth_fare_changed3 = explode('#', $lberth_fare_changed2[$a]);
                            $fseat = $lberth_fare_changed3[0];
                            $ffare = $lberth_fare_changed3[1];

                            if ($fseat == $seat_name) {
                                $lberth_fare1 = $ffare;
                                break;
                            } else {
                                $lberth_fare1 = $lberth_fare;
                            }
                        }
                        if ($seat_name != '') {
                            echo '<td width="50" height="50" align="center">' . $seat_name . '<br /><input type="hidden" name="ltxt' . $j . '-' . $i . '" id="ltxt' . $j . '-' . $i . '" value="' . $seat_name . '" class="input" /><input type="text" name="lfare' . $j . '-' . $i . '" id="lfare' . $j . '-' . $i . '" value="' . $lberth_fare1 . '" class="input" /></td>';
                        } else {
                            echo '<td width="50" height="50" align="center">&nbsp;</td>';
                        }
                    }
                    echo '</tr><tr><td>&nbsp;</td></tr>';
                }
                echo '</table>';
            }
        }
        if ($bus_type == "seatersleeper") {
            //$sfare = $row->seat_fare;
            //$lfare = $row->lberth_fare; 
            //$ufare = $row->uberth_fare;

            $query1 = $this->db->query("select max(row) as mrow,max(col) as mcol from master_layouts where service_num='$service_num' and travel_id='$travel_id' and seat_type='U'")or die(mysql_error());
            foreach ($query1->result() as $row1) {
                $upper_rows = $row1->mrow;
                $upper_cols = $row1->mcol;
            }

            echo '<table border="0" cellspacing="1" cellpadding="1" style="padding:5px 5px 5px 5px; font-size:16px; calibri;">';
            echo '<tr><td>Upper</td></tr><tr><td>&nbsp;</td></tr>';
            for ($i = 1; $i <= $upper_cols; $i++) {
                echo '<tr>';
                for ($j = 1; $j <= $upper_rows; $j++) {
                    $query2 = mysql_query("select * from master_layouts where service_num='$service_num' and travel_id='$travel_id' and row='$j' and col='$i' and seat_type='U'")or die(mysql_error());
                    $row2 = mysql_fetch_array($query2);
                    $seat_name = trim($row2['seat_name']);

                    $uberth_fare_changed2 = explode('@', $uberth_fare_changed);
                    for ($a = 0; $a < count($uberth_fare_changed2); $a++) {
                        $uberth_fare_changed3 = explode('#', $uberth_fare_changed2[$a]);
                        $fseat = $uberth_fare_changed3[0];
                        $ffare = $uberth_fare_changed3[1];

                        if ($fseat == $seat_name) {
                            $uberth_fare1 = $ffare;
                            break;
                        } else {
                            $uberth_fare1 = $uberth_fare;
                        }
                    }
                    if ($seat_name != '') {
                        echo '<td width="50" height="50" align="center">' . $seat_name . '<br /><input type="hidden" name="utxt' . $j . '-' . $i . '" id="utxt' . $j . '-' . $i . '" value="' . $seat_name . '" class="input" /><input type="text" name="ufare' . $j . '-' . $i . '" id="ufare' . $j . '-' . $i . '" value="' . $uberth_fare1 . '" class="input" /></td>';
                    } else {
                        echo '<td width="50" height="50" align="center">&nbsp;</td>';
                    }
                }
                echo '</tr><tr><td>&nbsp;</td></tr>';
            }
            echo '</table><br />';

            $query3 = $this->db->query("select max(row) as mrow,max(col) as mcol from master_layouts where service_num='$service_num' and travel_id='$travel_id' and (seat_type='L:b' OR seat_type='L:s')")or die(mysql_error());
            foreach ($query3->result() as $row3) {
                $lower_rows = $row3->mrow;
                $lower_cols = $row3->mcol;
            }
            echo '<table border="0" cellspacing="1" cellpadding="1" style="padding:5px 5px 5px 5px; font-size:16px; calibri;">';
            echo '<tr><td>Lower</td></tr><tr><td>&nbsp;</td></tr>';
            for ($i = 1; $i <= $lower_cols; $i++) {
                echo '<tr>';
                for ($j = 1; $j <= $lower_rows; $j++) {
                    $query2 = mysql_query("select * from master_layouts where service_num='$service_num' and travel_id='$travel_id' and row='$j' and col='$i' and (seat_type='L:b' OR seat_type='L:s')")or die(mysql_error());
                    $row2 = mysql_fetch_array($query2);
                    $seat_name = trim($row2['seat_name']);
                    $seat_type = trim($row2['seat_type']);

                    if ($seat_type == "L:s") {
                        $fare = $seat_fare;
                    } else if ($seat_type == "L:b") {
                        $fare = $lberth_fare;
                    }

                    $lberth_fare_changed2 = explode('@', $lberth_fare_changed);
                    for ($a = 0; $a < count($lberth_fare_changed2); $a++) {
                        $lberth_fare_changed3 = explode('#', $lberth_fare_changed2[$a]);
                        $fseat = $lberth_fare_changed3[0];
                        $ffare = $lberth_fare_changed3[1];

                        if ($fseat == $seat_name) {
                            $fare1 = $ffare;
                            break;
                        } else {
                            $fare1 = $fare;
                        }
                    }
                    if ($seat_name != "") {
                        echo '<td width="50" height="50" align="center">' . $seat_name . '<br /><input type="hidden" name="ltxt' . $j . '-' . $i . '" id="ltxt' . $j . '-' . $i . '" value="' . $seat_name . '" class="input" /><input type="text" name="lfare' . $j . '-' . $i . '" id="lfare' . $j . '-' . $i . '" value="' . $fare1 . '" class="input" /></td>';
                    } else {
                        echo '<td width="50" height="50" align="center">&nbsp;</td>';
                    }
                }
                echo '</tr><tr><td>&nbsp;</td></tr>';
            }
            echo '</table>';
        }
        echo'</td>
            </tr>
            <tr>
                <td height="26" align="center">
                <input type="button" value="update" name="up" id="up" onClick="updateFare()" class="newsearchbtn">
                <input type="hidden" value="' . $bus_type . '" name="bus_type" id="bus_type">
                <input type="hidden" value="' . $service_num . '" name="service_num" id="service_num">
                <input type="hidden" value="' . $travel_id . '" name="travel_id" id="travel_id">
                <input type="hidden" value="' . $mseat_fare . '" name="sfare" id="sfare">
                <input type="hidden" value="' . $mlberth_fare . '" name="lfare" id="lfare">
                <input type="hidden" value="' . $muberth_fare . '" name="ufare" id="ufare">
                <input type="hidden" value="' . $lower_rows . '" name="lower_rows" id="lower_rows">
                <input type="hidden" value="' . $lower_cols . '" name="lower_cols" id="lower_cols">
                <input type="hidden" value="' . $upper_rows . '" name="upper_rows" id="upper_rows">
                <input type="hidden" value="' . $upper_cols . '" name="upper_cols" id="upper_cols">
				<input type="hidden" value="' . $from_id . '" name="from_id" id="from_id">
				<input type="hidden" value="' . $to_id . '" name="to_id" id="to_id">
				<input type="hidden" value="' . $from_name . '" name="from_name" id="from_name">
				<input type="hidden" value="' . $to_name . '" name="to_name" id="to_name">
                </td>
            </tr> 			
        </table>';
    }

    function getroute() {
        $service_num = $this->input->post('service_num');
		$opid = $this->input->post('opid');
        $result = $this->changedfare1->getroute1($service_num,$opid);

        return $result;
    }

    public function addnewfare() {
        $result = $this->changedfare1->addnewfare1();

        return $result;
    }

}

?>
