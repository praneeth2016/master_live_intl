<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Createbus_new extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('cookie');
        $this->load->helper('url');
        $this->load->model('createbus_model_new');
        $this->load->model('modellogin');
    }

    public function getHour() {
        $data = array();
        $data[HH] = "HH";
        for ($i = 0; $i <= 12; $i++) {
            if ($i < 10)
                $i = "0" . $i;
            $data[$i] = $i;
        }
        return $data;
    }
     public function getJourneyHours() {
        $data = array();
        $data[HH] = "HH";
        for ($i = 0; $i <= 50; $i++) {
            if ($i < 10)
                $i = "0" . $i;
            $data[$i] = $i;
        }
        return $data;
    }
    
    

//getHour()

    public function getHours() {
        $data = array();
        for ($i = 0; $i < 24; $i++) {
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
    /*     * ******************** method for checking *********************** */

    public function checkUser() {
        $data = $this->createbus_model_new->check_user();
        echo $data;
    }

    public function getbusmodel() {

        $data = $this->createbus_model_new->busmodel();
        print_r($data);
    }

//checkUser()
//method for manual bus creation

    public function createBus() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['operators'] = $this->modellogin->get_operator();
            $data['cities'] = $this->createbus_model_new->getAllCity();
            //$data['busmodel'] = $this->createbus_model_new->busmodel();
            $this->load->view('bus/serviceCreationView.php', $data);
        }
    }

// createBus()

    public function getServiceLayout() {
        $lay = $this->createbus_model_new->getLayoutDb();
        echo $lay;
    }

//getServiceLayout()
//getting halts and fare

    public function getHaltsAndFares() {
        $opid = $this->input->post('opid');
        $nstops = $this->input->post('halts');
        $busmodel = $this->input->post('busmodel');
        //echo "$busmodel";
        $getroutes = $this->createbus_model_new->getAllCity();
        $bustype = $this->createbus_model_new->getbustype($busmodel, $opid);
        $getCurrency = $this->createbus_model_new->getCurrencyList();
        //echo "$bustype";  
        if ($nstops > 0) {
            echo '<table width="100%" border="0">
  <tr>
  <td><strong>City Order</strong></td>
    <td><strong>Source </strong></td>
    <td><strong>Destination</strong></td>
    <td><strong>Start Time </strong></td>
    <td><strong>Arrival Time</strong></td>
    <td><strong>Journey Time</strong></td>
    <td><strong>Currency</strong></td>';
            if ($bustype == "seater") {
                echo '<td><strong>Seat Fare </strong></td>';
            } else if ($bustype == "sleeper") {
                echo '<td><strong>Lower Berth Fare </strong></td>
    	<td><strong>Upper Berth Fare </strong></td>';
            } else if ($bustype == "seatersleeper") {
                echo '<td><strong>Seat Fare </strong></td>
		<td><strong>Lower Berth Fare </strong></td>
    	<td><strong>Upper Berth Fare </strong></td>';
            }
            echo'</tr>';
            for ($i = 1; $i <= $nstops; $i++) {
											
                $id = 'id="from' . $i . '" style="width:150px"';
                $name = 'name="from' . $i . '"';

                $id2 = 'id="to' . $i . '" style="width:150px"';
                $name2 = 'name="to' . $i . '"';
                
                $curid = 'id="currency' . $i . '" style="width:50px"';
                $curname = 'name="currency' . $i . '"';

                $hours = $this->getHour();

                $timehrST = 'id="timehrST' . $i . '" ';
                $timenST = 'name="timehrST' . $i . '" ';

                $timehrAT = 'id="timehrAT' . $i . '" ';
                $timenAT = 'name="timehrAT' . $i . '" ';
                
                $jhours = $this->getJourneyHours();
                $jtimehrid = 'id="jtimehr' . $i . '" ';
                $jtimehr = 'name="jtimehr' . $i . '" ';
                
                $jtimemnid = 'id="jtimemn' . $i . '" ';
                $jtimemn = 'name="jtimemn' . $i . '" ';
                
                $hours1 = $this->getMinutes();

                $timemiST = 'id="timemST' . $i . '"';
                $timemnST = 'name="timemST' . $i . '"';

                $timemiAT = 'id="timemAT' . $i . '"';
                $timemnAT = 'name="timemAT' . $i . '"';

                $tfidST = 'id="tfmST' . $i . '" ';
                $tfnameST = 'name="tfm' . $i . '" style="width:50px"';

                $tfidAT = 'id="tfmAT' . $i . '" ';
                $tfnameAT = 'name="tfmAT' . $i . '" style="width:50px"';

                $tfv = array("AMPM" => "-select-", "AM" => "AM", "PM" => "PM");

                echo'
  <tr>
  <td align="center"><input type="text" name="stageorder'.$i.'" id="stageorder'.$i. '" style="width:25px" value="'.$i.'" readonly="readonly">
    <td height="30">' . form_dropdown($name, $getroutes, "", $id) . '</td>
    <td>' . form_dropdown($name2, $getroutes, "", $id2) . '</td>
	
    <td>' . form_dropdown($timenST, $hours, $hr, $timehrST) . '' . form_dropdown($timemnST, $hours1, $hr1, $timemiST) . '' . form_dropdown($tfnameST, $tfv, $tf[1], $tfidST) . '</td>
    <td>' . form_dropdown($timenAT, $hours, $hr, $timehrAT) . '' . form_dropdown($timemnAT, $hours1, $hr1, $timemiAT) . '' . form_dropdown($tfnameAT, $tfv, $tf[1], $tfidAT) . '</td>
   <td>' . form_dropdown($jtimehr, $jhours, $hr, $jtimehrid) . '' . form_dropdown($jtimemn, $hours1, $hr1, $jtimemnid) .'</td>
    <td>' . form_dropdown($curname, $getCurrency, "", $curid) . '</td>';
               
                if ($bustype == "seater") {
                    echo '<td align="center"><input type="text" name="sfare' . $i . '" id="sfare' . $i . '" style="width:70px" value=""></td>';
                } else if ($bustype == "sleeper") {
                    echo '<td align="center"><input type="text" name="lbfare' . $i . '" id="lbfare' . $i . '" style="width:70px" value=""></td>
    	<td align="center"><input type="text" name="ubfare' . $i . '" id="ubfare' . $i . '" style="width:70px" value=""></td>';
                } else if ($bustype == "seatersleeper") {
                    echo '<td align="center"><input type="text" name="sfare' . $i . '" id="sfare' . $i . '" style="width:70px" value=""></td>
		<td align="center"><input type="text" name="lbfare' . $i . '" id="lbfare' . $i . '" style="width:70px" value=""></td>
    	<td align="center"><input type="text" name="ubfare' . $i . '" id="ubfare' . $i . '" style="width:70px" value=""></td>';
                }
                echo'</tr>';
            }//for
            if($nstops==1) 
            {
                echo '';
            }
            else {
            echo "<tr><td colspan='10'>All city order is for source cities except city order $nstops . </td></tr>";
            echo "<tr><td colspan='10'>City Order $nstops is for destination city . </td></tr>";
            }
            echo '</table>';
        } else {
            echo 0;
        }
    }

//getHaltsAndFares()
//Selecting board points related code

    public function getBoard() {
        $from = $this->input->get('froms');
        $fid = $this->input->get('fids');
        $snum = $this->input->get('snum');
        $halts = $this->input->get('halts');
        $opid = $this->input->get('opid');
        //echo "$opid";

        $data = $this->createbus_model_new->getBoardDb($fid, $from, $snum, $halts, $opid);
    }

//
//selecting Dropping points 

    public function getDrop() {
        $to = $this->input->get('tos');
        $tid = $this->input->get('tids');
        $snum = $this->input->get('snum');
        $halts = $this->input->get('halts');
        $opid = $this->input->get('opid');

        $data = $this->createbus_model_new->getDropDb($tid, $to, $snum, $halts, $opid);
    }

//getDrop()
//saving boarding points in temp table

    public function saveBoard() {
        $sernum = $this->input->post('sernum');
        $city_name = $this->input->post('city_name');
        $city_id = $this->input->post('city_id');
        $board_point = $this->input->post('board_point');
        $bpid = $this->input->post('bpid');
        $lm = $this->input->post('lm');
        $hhST = $this->input->post('hhST');
        $mmST = $this->input->post('mmST');
        $ampmST = $this->input->post('ampmST');
        $opid = $this->input->post('opid');
        $data = $this->createbus_model_new->saveBoardDb($sernum, $city_name, $city_id, $board_point, $bpid, $lm, $hhST, $mmST, $ampmST, $opid);
    }

//saveBoard()
//saving Drop points in temp table

    public function saveDrop() {
        $sernum = $this->input->post('sernum');
        $city_name = $this->input->post('city_name');
        $city_id = $this->input->post('city_id');
        $board_point = $this->input->post('drop_point');
        $bpid = $this->input->post('dpid');
        $lm = $this->input->post('lm');
        $hhST = $this->input->post('hhST');
        $mmST = $this->input->post('mmST');
        $ampmST = $this->input->post('ampmST');
        $opid = $this->input->post('opid');

        $data = $this->createbus_model_new->saveDropDb($sernum, $city_name, $city_id, $board_point, $bpid, $lm, $hhST, $mmST, $ampmST, $opid);
    }

//saveDrop()
//checking boarding points are insertesd or not
    public function getBoardOrDropVal() {
        $data = $this->createbus_model_new->getBoardOrDropValDb();
    }

//getBoardOrDropVal()
//save bus

    public function saveBusDetails() {
        $data = $this->createbus_model_new->saveBusDetailsDb();
    }

//saveBusDetails
    public function pakage() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['operators'] = $this->modellogin->get_operator_from_db();
        $this->load->view('Add_trip_details', $data);
    }

    public function getservice() {

        $service = $this->modellogin->getservic_pkg();
        echo $service;
    }

    function add_pakag_details() {
        $this->createbus_model_new->addpakage_details();
    }

    public function add_pakag_details_db() {
        $responce = $this->createbus_model_new->addpakage_details_db1();
        echo $responce;
    }

    public function get_pkg_details_db() {
        $responce = $this->createbus_model_new->get_pkg_details_db1();
        echo $responce;
    }

}

//
?>