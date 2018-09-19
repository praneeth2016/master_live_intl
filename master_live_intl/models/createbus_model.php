<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Createbus_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->database();
    }

    /* method for getting all the buses model */

    public function busmodel() {
        $this->db->select("model");
        $this->db->order_by("model", "asc");
        $query = $this->db->get("buses_model");
        $data = array();
        $data['0'] = '--select--';
        foreach ($query->result() as $rows) {
            $data[$rows->model] = $rows->model;
        }
        return $data;
    }

//close busmodel()




    /* method for getting all the bustypes */

    function bustypes() {
        $this->db->select("bus_type");
        $this->db->order_by("bus_type", "asc");
        $query = $this->db->get("buses_type");
        $data = array();
        $data['0'] = '--select--';
        foreach ($query->result() as $rows) {
            $data[$rows->bus_type] = $rows->bus_type;
        }
        return $data;
    }

//close bustypes()

    /* method for getting seats arrangement */

    public function seats_arrangement() {
        $this->db->select("id,seat_arr");
        $this->db->order_by("id", "asc");
        $query = $this->db->get('seats_arrangement');
        $data = array();
        $data['0'] = '--select--';
        foreach ($query->result() as $rows) {
            $data[$rows->seat_arr] = $rows->seat_arr;
        }
        return $data;
    }

    /* closing the seats_arrangement() */

    /* method for deciding no.of rows and columns for layout 
     * calling bulidmethod to build the layout */

    public function setLayoutModel($btype, $nos, $sarr, $dc1, $dc2) {
        $x = explode('+', $sarr);
        $x1 = $x[0];
        $x2 = $x[1];
        $sarr1 = $x1 + $x2;
        if ($btype == 'seater') {
            $rows = floor($nos / $sarr1) + 1;
            $cols = $sarr1 + 1;
            /* method calling */
            $this->buildLay1($sarr, $rows, $cols, 1, $x1, $x2);
        }//seater
        else if ($btype == 'sleeper') {
            if ($sarr == "1+1") {
                $rows = $dc1;
                $cols = $sarr1 / 2;
            } else {
                $rows = floor($dc1 / $sarr1) + 1;
                $cols = $sarr1 + 1;
            }

//once for upper deck
            echo "Lower Deck:";
            /* method calling */
            $this->buildLay($sarr, $rows, $cols, 1, $x1, $x2);
//once for lower deck
            if ($sarr == "1+1") {
                $rows = $dc2;
            } else {
                $rows = floor($dc2 / $sarr1) + 1;
            }

            echo "Upper Deck:";
            /* method calling */
            $this->buildLay($sarr, $rows, $cols, 2, $x1, $x2);
        }//sleeper
        else {

            echo "Lower Deck:";
            $rows = 13;
            $cols = $sarr1 + 1;
            /* method calling */
            $this->buildSslLay($sarr, $rows, $cols, 1, $x1, $x2);
            $rows = floor($dc2 / $sarr1) + 1;
            echo "Upper Deck:";
            /* method calling */
            $this->buildSslLay($sarr, $rows, $cols, 2, $x1, $x2);
        }//seater sleeper
    }

    function buildLay($sarr, $rows, $cols, $deck, $x1, $x2) {// here $cols is unused I think0
        if ($sarr != "1+1") {
//echo "$sarr,$rows,$cols,$deck"."<br/>";
            echo "<table border='1' cellpadding='5' name='sorsl$deck' id='sorsl$deck'>";
            $i = $x1;
            $j = $x2;

//before GW
            for ($c = 1; $c <= $i; $c++) {
                echo "<tr>";
                for ($r = 1; $r <= $rows; $r++) {
                    echo "<td style='background-color: #f2f2f2;'><input type='checkbox' name='c$deck$c$r' id='c$deck$c$r' checked='checked' style='width:2em; height:2em'/><input type='text' name='s$deck$c$r' id='s$deck$c$r' value='' style='display: none;width:20px;'></td>";
                }
                echo "</tr>";
            }
//GW
            echo "<tr>";
            for ($r = 1; $r <= $rows; $r++) {
                $c = $i + 1;
                $cp = $rows - 1;
                if ($r == $rows) {
                    echo "<td style='background-color: #f2f2f2;'><input type='checkbox' style='width:2em; height:2em' name='c$deck$c$r' id='c$deck$c$r' checked='checked'/><input type='text' name='s$deck$c$r' id='s$deck$c$r' value='' size='2' style='display: none;width:20px;'></td>";
                } else if ($r == 1) {
                    echo "<td colspan='$cp' align='center'>Gangway</td>";
                }
            }
            echo "</tr>";
//after GW
            for ($c = $i + 2; $c <= $i + 1 + $j; $c++) {
                echo "<tr>";
                for ($r = 1; $r <= $rows; $r++) {
                    echo "<td style='background-color: #f2f2f2;'><input type='checkbox' style='width:2em; height:2em' name='c$deck$c$r' id='c$deck$c$r' checked='checked'/><input type='text' name='s$deck$c$r' id='s$deck$c$r' value='' size='2' style='display: none;width:20px;'></td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
//echo "$sarr,$rows,$cols,$deck"."<br/>";
            echo "<table border='1' cellpadding='5' name='sorsl$deck' id='sorsl$deck'>";
            $i = $x1;
            $j = $x2;

//before GW
            for ($c = 1; $c <= $i; $c++) {
                echo "<tr>";
                for ($r = 1; $r <= $rows; $r++) {
                    echo "<td style='background-color: #f2f2f2;'><input type='checkbox' name='c$deck$c$r' id='c$deck$c$r' checked='checked' style='width:2em; height:2em'/><input type='text' name='s$deck$c$r' id='s$deck$c$r' value='' style='display: none;width:20px;'></td>";
                }
                echo "</tr>";
            }
//GW
            echo "<tr>";
            for ($r = 1; $r < $rows; $r++) {
                $c = $i + 1;
                $cp = $rows - 1;
                if ($r == $rows) {
                    echo "<td style='background-color: #f2f2f2;'><input type='checkbox' style='width:2em; height:2em' name='c$deck$c$r' id='c$deck$c$r' checked='checked'/><input type='text' name='s$deck$c$r' id='s$deck$c$r' value='' size='2' style='display: none;width:20px;'></td>";
                } else if ($r == 1) {
                    echo "<td colspan='$cp' align='center'>Gangway</td>";
                }
            }
            echo "</tr>";
//after GW          
            echo "</table>";
        }
    }

//close buildLay()

    function buildLay1($sarr, $rows, $cols, $deck, $x1, $x2) {// here $cols is unused I think0
//echo "$sarr,$rows,$cols,$deck"."<br/>";
        echo "<table border='1' cellpadding='5' name='sorsl$deck' id='sorsl$deck'>";
        $i = $x1;
        $j = $x2;

//before GW
        for ($c = 1; $c <= $i; $c++) {
            echo "<tr>";
            for ($r = 1; $r <= $rows; $r++) {
                echo "<td style='background-color: #f2f2f2;'><input type='checkbox' name='c$deck$c$r' id='c$deck$c$r' checked='checked' style='width:2em; height:2em'/><input type='text' name='s$deck$c$r' id='s$deck$c$r' value='' style='display: none;width:20px;'></td>";
            }
            echo "</tr>";
        }
//GW
        echo "<tr>";
        for ($r = 1; $r <= $rows; $r++) {
            $c = $i + 1;
            $cp = $rows - 1;
            if ($r == $rows) {
                echo "<td style='background-color: #f2f2f2;'><input type='checkbox' style='width:2em; height:2em' name='c$deck$c$r' id='c$deck$c$r' checked='checked'/><input type='text' name='s$deck$c$r' id='s$deck$c$r' value='' size='2' style='display: none;width:20px;'></td>";
            } else if ($r == 1) {
                echo "<td colspan='$cp' align='center'>Gangway</td>";
            }
        }
        echo "</tr>";
//after GW
        for ($c = $i + 2; $c <= $i + 1 + $j; $c++) {
            echo "<tr>";
            for ($r = 1; $r <= $rows; $r++) {
                echo "<td style='background-color: #f2f2f2;'><input type='checkbox' style='width:2em; height:2em' name='c$deck$c$r' id='c$deck$c$r' checked='checked'/><input type='text' name='s$deck$c$r' id='s$deck$c$r' value='' size='2' style='display: none;width:20px;'></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

//close buildLay1()

    function buildSslLay($sarr, $rows, $cols, $deck, $x1, $x2) {// here $cols is unused I think
//echo "$sarr,$rows,$cols,$deck"."<br/>";
        if ($deck == 1) {
            $sb = 'seat';
            $sb1 = 'berth';
            $sbv = 's';
            $sbv1 = 'b';
        } else {
            $sb1 = 'seat';
            $sb = 'berth';
            $sbv1 = 's';
            $sbv = 'b';
        }

        echo "<table id='sslinfo' style='display: none;'><tr><td bgcolor='#F38383'>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Seat</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td bgcolor='#AEFF00'>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Berth</td></tr></table>";
        echo "<table border='1' cellpadding='5' name='ssl$deck' id='ssl$deck'>";
        $i = $x1;
        $j = $x2;

//before GW
        for ($c = 1; $c <= $i; $c++) {
            echo "<tr>";
            for ($r = 1; $r <= $rows; $r++) {
                echo "<td style='background-color: #f2f2f2;' id='td$deck$c$r'><input type='checkbox' name='c$deck$c$r' id='c$deck$c$r' checked='checked'/><select name='ssl$deck$c$r' id='ssl$deck$c$r'><option value='$sbv' selected='selected'> $sb </option><option value='$sbv1'> $sb1 </option></select><input type='text' name='s$deck$c$r' id='s$deck$c$r' value='' style='display: none;width:20px;'></td>";
            }
            echo "</tr>";
        }
//GW
        echo "<tr>";
        for ($r = 1; $r <= $rows; $r++) {
            $c = $i + 1;
            if ($r == $rows)
                echo "<td style='background-color: #f2f2f2;' id='td$deck$c$r'><input type='checkbox' name='c$deck$c$r' id='c$deck$c$r' checked='checked'/><select name='ssl$deck$c$r' id='ssl$deck$c$r'><option value='s'> seat </option><option value='b' selected='selected'> berth </option></select><input type='text' name='s$deck$c$r' id='s$deck$c$r' value='' style='display: none;width:20px;'></td>";
            else
                echo "<td>&nbsp;</td>";
        }
        echo "</tr>";
//after GW
        for ($c = $i + 2; $c <= $i + 1 + $j; $c++) {
            echo "<tr>";
            for ($r = 1; $r <= $rows; $r++) {
                echo "<td style='background-color: #f2f2f2;' id='td$deck$c$r'><input type='checkbox' name='c$deck$c$r' id='c$deck$c$r' checked='checked'/><select name='ssl$deck$c$r' id='ssl$deck$c$r'><option value='s'> seat </option><option value='b' selected='selected'> berth </option></select><input type='text' name='s$deck$c$r' id='s$deck$c$r' value='' style='display: none;width:20px;'></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    /**
     * Saves layout into database
     * @param mixed $svc     service number
     * @param mixed $btype   Bus type
     * @param mixed $sarr    seating arrangement
     * @param mixed $start   start value of row in displayed layout 
     * @param mixed $end     end value of row in displayed layout
     * @param mixed $start1  start value of row in displayed layout for sleeper/ seater+ sleeper purpose
     * @param mixed $end1    end value of row in displayed layout for sleeper/ seater+ sleeper purpose
     * @param mixed $seat_array  string which consits of lower deck seat nums(for seater as well)
     * @param mixed $seat_array1 string which consits of Upper deck seat nums(for sleeper & seater+sleeper)
     */
    public function saveLayoutDb($svc, $btype, $sarr, $start, $end, $start1, $end1, $seat_array, $seat_array1) {
        $svc = strtoupper($svc);
        $travel_id = $this->session->userdata('travel_id');
        $this->db->select("service_num");
        $this->db->where("service_num", $svc);
        $q = $this->db->get("master_layouts");
        if ($q->num_rows() > 0) {
            return "2";
        } else {
            $saa = explode(',', $seat_array);
            $sa = array_filter($saa);
            $sa1 = explode(',', $seat_array1);
            $sa1 = array_filter($sa1);
//operator travel id from session
            $tr = $travel_id;
            if ($btype == 'seater') {
                $sarr2 = explode('+', $sarr);
                $x = $sarr2[0] + $sarr2[1];
                $size = $end - $start + 1;
//echo $seat_array;
                for ($j = 1; $j <= count($sa); $j++) {

                    $tmpp = explode('#', $sa[$j]);
                    $tmp = array_filter($tmpp);
                    $l = count($tmp);

                    for ($i = 1; $i <= $l; $i++) {     // for rows//when i=1 && i=L =>window
                        $tmp1 = explode('-', $tmp[$i]);
                        $sname = $tmp1[0];
                        $tmp2 = explode(':', $tmp1[1]);
                        $col = $tmp2[0];
                        $row = $tmp2[1];
                        if ($i == 1 || $i == $l) {
                            $w = 1;
                        } else
                            $w = 0;

                        $lay_id = $tr . "#" . $btype . "#" . $sarr;
                        $data = array('travel_id' => $travel_id, 'layout_id' => $lay_id, 'seat_name' => $sname, 'row' => $row, 'col' => $col, 'seat_type' => 's', 'window' => $w, 'is_ladies' => '0', 'service_num' => $svc, 'available' => 0, 'status' => 0);
                        $query = $this->db->insert('master_layouts', $data); //inserting into the database
                    }
                }
            }
            else { //sleeper or seater-sleeper
                $sarr2 = explode('+', $sarr);
                $x = $sarr2[0] + $sarr2[1];
                $size = $end - $start + 1;
                for ($j = 1; $j <= count($sa); $j++) {
                    $tmpp = explode('#', $sa[$j]);
                    $tmp = array_filter($tmpp);
                    $l = sizeof($tmp);
                    for ($i = 1; $i <= $l; $i++) {     // for rows//when i=1 && i=L =>window
                        $tmp11 = explode('-', $tmp[$i]);
                        $tmp1 = array_filter($tmp11);
                        $temp = explode('|', $tmp1[0]);
                        $sname = $temp[0];
                        $stype = $temp[1];
                        $tmp22 = explode(':', $tmp1[1]);
                        $tmp2 = array_filter($tmp22);
                        $col = $tmp2[0];
                        $row = $tmp2[1];
                        if ($i == 1 || $i == $l) {
                            $w = 1;
                        } else
                            $w = 0;
                        $lay_id = $tr . "#" . $btype . "#" . $sarr;

                        $data = array('travel_id' => $travel_id, 'layout_id' => $lay_id, 'seat_name' => $sname, 'row' => $row, 'col' => $col, 'seat_type' => $stype, 'window' => $w, 'is_ladies' => '0', 'service_num' => $svc, 'available' => 0, 'status' => 0);
                        $query = $this->db->insert('master_layouts', $data); //inserting into the database
                    }
                }
                for ($j = 1; $j <= count($sa1); $j++) {
                    $tmpe = explode('#', $sa1[$j]);
                    $tmp = array_filter($tmpe);
                    $l = sizeof($tmp);
                    for ($i = 1; $i <= $l; $i++) {     // for rows//when i=1 && i=L =>window
                        $tmp1 = explode('-', $tmp[$i]);
                        $temp = explode('|', $tmp1[0]);
                        $sname = $temp[0];
                        $stype = $temp[1];
                        $tmp2 = explode(':', $tmp1[1]);
                        $col = $tmp2[0];
                        $row = $tmp2[1];
                        if ($i == 1 || $i == $l) {
                            $w = 1;
                        } else
                            $w = 0;

                        $lay_id = $tr . "#" . $btype . "#" . $sarr;

                        $data = array('travel_id' => $travel_id, 'layout_id' => $lay_id, 'seat_name' => $sname, 'row' => $row, 'col' => $col, 'seat_type' => $stype, 'window' => $w, 'is_ladies' => '0', 'service_num' => $svc, 'available' => 0, 'status' => 0);
                        $query = $this->db->insert('master_layouts', $data); //inserting into the database
                    }
                }
            }

            if ($query) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    function getroutes() {
        $this->db->select("city_id,city_name");
        $this->db->order_by("city_name", "asc");
        $query = $this->db->get("master_cities");
        $data = array();
        $data['0'] = '--select--';
        foreach ($query->result() as $rows) {
            $data[$rows->city_id] = $rows->city_name;
        }//foreach
        return $data;
    }

//close bustypes()

    public function getHour() {
        $data = array();

        for ($i = 0; $i <= 12; $i++) {
            if ($i < 10)
                $i = "0" . $i;
            $data[$i] = $i;
        }
        return $data;
    }

    public function getHours() {
        $data = array();

        for ($i = 0; $i < 24; $i++) {
            if ($i < 10)
                $i = "0" . $i;
            $data[$i] = $i;
        }
        return $data;
    }

    public function getMinutes() {
        $data = array();

        for ($i = 0; $i <= 60; $i++) {
            if ($i < 10)
                $i = "0" . $i;
            $data[$i] = $i;
        }
        return $data;
    }

    public function getHours1() {
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

    public function getMinutes1() {
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

    public function getHoursForJT() {
        $data = array();

        for ($i = 0; $i <= 48; $i++) {
            if ($i < 10)
                $i = "0" . $i;
            $data[$i] = $i;
        }
        return $data;
    }

    public function arrivalTimCal($start, $journey) {

        function getnum($value) {
            $pieces = explode(':', $value);
            if (count($pieces) > 0) {
                return (intval($pieces[0]) * 60) + intval($pieces[1]);
            }
            return 0;
        }

        ;
        $start_num = getnum($start); //calling function
        $journey_num = getnum($journey);
//echo $start_num."#".$journey_num;
        $time = $journey_num + $start_num;
//echo $time."#";
        $hour = intval($time / 60);
        $min = ($time % 60);
//echo $hour."#";
//echo $min."#";
        /* hour calculation */
        if ($hour >= 24 && $hour < 48)
            $hour1 = $hour - 24;
        else if ($hour >= 48)
            $hour1 = $hour - 48;
        else
            $hour1 = $hour;
        /* if minute lessthan 10 adding Zero before that. */
        if ($min < 10)
            $min = '0' . $min;
        /* If hour1 is more than 12 */
        if ($hour1 >= 12) {
            $hour1 = $hour1 - 12;
            if ($hour1 == 0) {
                return str_replace('0', '12', $hour1) . ':' . $min . 'PM';
            } else
                return $hour1 . ':' . $min . 'PM';
        }
        else {
            return $hour1 . ':' . $min . 'AM';
        }
    }

//close arrivalTimCal()

    function saveBusModel($servicetype, $nstops, $srvno, $fid, $from, $tid, $to, $model, $btype, $nos, $nobl, $nobu, $start, $journey, $arrtime, $sfare, $lbfare, $ubfare) {

        $srvno = strtoupper($srvno);
        $travel_id = $this->session->userdata('travel_id');
        $this->db->select("service_num");
        $this->db->where("service_num", $srvno);
        $q = $this->db->get("master_buses");
        if ($q->num_rows() > 0) {
            return 2;
        }//if
        else {
//save bus
//another for for no.of stops
            $fid1 = explode("#", $fid);
            $from1 = explode("#", $from);
            $tid1 = explode('#', $tid);
            $to1 = explode('#', $to);
            $start1 = explode('#', $start);
            $journey1 = explode('#', $journey);
            $arrtime1 = explode('#', $arrtime);
            if ($sfare != '')
                $sfare1 = explode('#', $sfare);
            else
                $sfare1 = array();


            if ($lbfare != '')
                $lbfare1 = explode('#', $lbfare);
            else
                $lbfare1 = array();

            if ($ubfare != '')
                $ubfare1 = explode('#', $ubfare);
            else
                $ubfare1 = array();

            for ($i = 1; $i <= $nstops; $i++) {
                if ($btype == 'seater') {
                    $data = array('serviceType' => $servicetype, 'service_num' => $srvno, 'travel_id' => $travel_id, 'from_id' => $fid1[$i], 'from_name' => $from1[$i], 'to_id' => $tid1[$i], 'to_name' => $to1[$i], 'start_time' => $start1[$i] . ":00", 'journey_time' => $journey1[$i] . ":00", 'arr_time' => $arrtime1[$i], 'model' => $model, 'bus_type' => $btype, 'seat_nos' => $nos, 'seat_fare' => $sfare1[$i], 'status' => 0);
                    $data1 = array('travel_id' => $travel_id, 'from_id' => $fid1[$i], 'from_name' => $from1[$i], 'to_id' => $tid1[$i], 'to_name' => $to1[$i]);
                } else if ($btype == 'sleeper') {
                    $nos = $nobl + $nobu;
                    $data = array('serviceType' => $servicetype, 'service_num' => $srvno, 'travel_id' => $travel_id, 'from_id' => $fid1[$i], 'from_name' => $from1[$i], 'to_id' => $tid1[$i], 'to_name' => $to1[$i], 'start_time' => $start1[$i] . ":00", 'journey_time' => $journey1[$i] . ":00", 'arr_time' => $arrtime1[$i], 'model' => $model, 'bus_type' => $btype, 'seat_nos' => $nos, 'lowerdeck_nos' => $nobl, 'upperdeck_nos' => $nobu, 'lberth_fare' => $lbfare1[$i], 'uberth_fare' => $ubfare1[$i], 'status' => 0);
                    $data1 = array('travel_id' => $travel_id, 'from_id' => $fid1[$i], 'from_name' => $from1[$i], 'to_id' => $tid1[$i], 'to_name' => $to1[$i]);
                } else if ($btype == 'seatersleeper') {
                    $nos = $nobl + $nobu;
                    $data = array('serviceType' => $servicetype, 'service_num' => $srvno, 'travel_id' => $travel_id, 'from_id' => $fid1[$i], 'from_name' => $from1[$i],
                        'to_id' => $tid1[$i], 'to_name' => $to1[$i], 'start_time' => $start1[$i] . ":00",
                        'journey_time' => $journey1[$i] . ":00", 'arr_time' => $arrtime1[$i],
                        'model' => $model, 'bus_type' => $btype, 'seat_nos' => $nos, 'lowerdeck_nos' => $nobl,
                        'upperdeck_nos' => $nobu, 'seat_fare' => $sfare1[$i], 'lberth_fare' => $lbfare1[$i],
                        'uberth_fare' => $ubfare1[$i], 'status' => 0);
                    $data1 = array('travel_id' => $travel_id, 'from_id' => $fid1[$i], 'from_name' => $from1[$i], 'to_id' => $tid1[$i], 'to_name' => $to1[$i]);
                }

                $sql = $this->db->insert('master_buses', $data);
                $sql2 = $this->db->insert('master_routes', $data1);
            }//for
        }//else
        if ($sql && $sql2)
            return 1;
        else
            return 0;
    }

//saveBusModel()


    /*     * ********************Boarding Point Related Methods******************************* */

    function getBpSourcesDb() {
        $svc = $this->input->post('svc');
        $isvan = $this->input->post('isvan');
        $travel_id = $this->session->userdata('travel_id');
        $this->db->distinct();
        $this->db->select('from_id,from_name');
        $array = array('service_num' => $svc, 'travel_id' => $travel_id);
        $query = $this->db->get_where('master_buses', $array);
        $s = 1;
        $count = $query->num_rows();

        foreach ($query->result() as $rows) {
            $from_id = $rows->from_id;
            $fromm = $rows->from_name;
//code for hours
            $data = $this->getHours();
            $bptimehi = 'id="bptimeh' . $isvan . $from_id . $s . '" ';
            $bptimehn = 'id="bptimeh' . $isvan . $from_id . $s . '" ';
//code for minutes dropdown
            $data2 = $this->getMinutes();
            $bptimemi = 'id="bptimem' . $isvan . $from_id . $s . '" ';
            $bptimemn = 'id="bptimem' . $isvan . $from_id . $s . '" ';
            echo ' <input type="hidden" name="fid' . $isvan . $s . '" id="fid' . $isvan . $s . '" value="' . $from_id . '"> <input type="hidden" name="servno' . $isvan . $from_id . $s . '" id="servno' . $isvan . $from_id . $s . '" value="' . $svc . '">
      <input type="hidden" name="travid' . $isvan . $from_id . $s . '" id="travid' . $isvan . $from_id . $s . '" value="' . $travel_id . '">
      <input type="hidden" name="from_name' . $isvan . $from_id . $s . '" id="from_name' . $isvan . $from_id . $s . '" value="' . $fromm . '">
      <input type="hidden" name="from_id' . $isvan . $from_id . $s . '" id="from_id' . $isvan . $from_id . $s . '" value="' . $from_id . '">
      <input type="hidden" name="count' . $isvan . $from_id . $s . '" id="count' . $isvan . $from_id . $s . '" value="' . $count . '">';
            echo ' <table width="600" align="right" border="0" id="bpTable' . $isvan . $s . '" style="font-size:12px;" >
       <tr id="' . $isvan . $from_id . $s . '">
       <td width="9"  >  </td>
      <td width="102"  align="left">' . $fromm . ' </td>
      <td width="147" ><input type="text" name="bp' . $isvan . $from_id . $s . '" id="bp' . $isvan . $from_id . $s . '"></td>
      <td width="144" ><input type="text" name="lm' . $isvan . $from_id . $s . '" id="lm' . $isvan . $from_id . $s . '"></td>
      <td width="110" >' . form_dropdown($bptimehn, $data, "", $bptimehi) . '' . form_dropdown($bptimemn, $data2, "", $bptimemi) . '</td>
     
   <td width="63" ><input type="button" class="newsearchbtn" name="bps' . $isvan . $from_id . $s . '" id="bps' . $isvan . $from_id . $s . '" value="+" onClick="bpadd(\'' . $svc . '\',' . $travel_id . ',\'' . $fromm . '\',' . $from_id . ',' . $count . ',' . $s . ',' . $isvan . ')"></td> </tr>
  
    </table>';
            $s++;
        }//foreach
        $c = $s - 1;
        echo '<table border="0" align="right">
  <tr>
    <td width="600" align="center"><input type="button" class="newsearchbtn" value="Save Boarding Points" name="saveb" id="saveb" onClick="saveBp(\'' . $svc . '\',' . $from_id . ',' . $travel_id . ',' . $c . ',' . $isvan . ')"/></td>
  </tr>
</table>';
    }

//getting destinations for adding dropping points
    function getDestinationsBpDb() {
        $svc = $this->input->post('svc');
        $travel_id = $this->session->userdata('travel_id');
        $this->db->distinct();
        $this->db->select('to_id,to_name');
        $array = array('service_num' => $svc, 'travel_id' => $travel_id);
        $query = $this->db->get_where('master_buses', $array);
        $s = 1;
        $count = $query->num_rows();
        $s = 1;
        foreach ($query->result() as $rows) {
            $to_id = $rows->to_id;
            $too = $rows->to_name;
            echo ' <input type="hidden" name="tid' . $s . '" id="tid' . $s . '" value="' . $to_id . '"> ';
            echo '<table width="469" border="0" id="dpTable' . $s . '" style="font-size:12px;" >
<tr id="' . $to_id . $s . '">
       <td width="15%"><input type="hidden" name="servno' . $to_id . $s . '" id="servno' . $to_id . $s . '" value="' . $svc . '">
      <input type="hidden" name="travid' . $to_id . $s . '" id="travid' . $to_id . $s . '" value="' . $travel_id . '">
      <input type="hidden" name="to_name' . $to_id . $s . '" id="to_name' . $to_id . $s . '" value="' . $too . '">
      <input type="hidden" name="to_id' . $to_id . $s . '" id="to_id' . $to_id . $s . '" value="' . $to_id . '">
      
      <input type="hidden" name="count' . $to_id . $s . '" id="count' . $to_id . $s . '" value="' . $count . '">  </td>
    <td width="27%" align="left">' . $too . ' </td>
    <td width="43%"><input type="text" name="dp' . $to_id . $s . '" id="dp' . $to_id . $s . '"></td>
    
  <td width="15%"><input type="button" class="newsearchbtn" name="dps' . $to_id . $s . '" id="dps' . $to_id . $s . '" value="+" onClick="dpadd(\'' . $svc . '\',' . $travel_id . ',\'' . $too . '\',' . $to_id . ',' . $count . ',' . $s . ')"></td> </tr>
  
</table> ';
            $s++;
        }
        $c = $s - 1;
        echo '<table border="0" >
  <tr>
    <td width="460" align="center"><input type="button" class="newsearchbtn" value="Save Dropping Points" name="saved" id="saved" onClick="saveDp(\'' . $svc . '\',' . $to_id . ',' . $travel_id . ',' . $c . ')"/></td>
  </tr>
</table>';
    }

//saving boarding points
    function saveBoardingsDb() {
        $servno = $this->input->post('servno');
        $travelid = $this->session->userdata('travel_id');
        $from_name = $this->input->post('from_name');
        $from_id = $this->input->post('from_id');
        $bp = $this->input->post('bp');
        $lm = $this->input->post('lm');
        $bptime = $this->input->post('bptime');
        $isvan = $this->input->post('isvan');
        $tim = time();
        $servno1 = explode("#", $servno);
        $from_name1 = explode("#", $from_name);
        $from_id1 = explode("#", $from_id);
        $bp1 = explode("#", $bp);
        $cnt = count($bp1);
        $lm1 = explode("#", $lm);
        $bptime1 = explode("#", $bptime);
        for ($i = 0; $i < $cnt; $i++) {
            if ($servno1[$i] != 'u') {
                $servno2 = $servno1[$i];
                $from_id2 = $from_id1[$i];
                $from_name2 = $from_name1[$i];
                $bp2 = $bp1[$i];
                $lm2 = $lm1[$i];
                $bptime2 = $bptime1[$i];
                $cbp = $bp2 . "#" . $bptime2 . "#" . $lm2;
                $bpid = $travelid . $servno2 . $from_id2 . $i . $isvan . $tim;
                if ($isvan == '1') {//if it is vanpickup
                    $isvanp = 'yes';
                } else {
                    $isvanp = 'no';
                }
                $data = array('is_van' => $isvanp, 'service_num' => $servno2, 'travel_id' => $travelid, 'city_id' => $from_id2, 'city_name' => $from_name2, 'board_or_drop_type' => 'board', 'board_drop' => $cbp, 'bpdp_id' => $bpid);
                $query = $this->db->insert('boarding_points', $data);
            }
        }
        if ($query) {
            echo "1";
        } else {
            echo "0";
        }
    }

//saving Dropping points
    function saveDroppingsDb() {
        $servno = $this->input->post('servno');
        $travelid = $this->session->userdata('travel_id');
        $to_name = $this->input->post('to_name');
        $to_id = $this->input->post('to_id');
        $dp = $this->input->post('dp');
        $servno1 = explode("#", $servno);
        $to_name1 = explode("#", $to_name);
        $to_id1 = explode("#", $to_id);
        $dp1 = explode("#", $dp);
        $cnt = count($dp1);
        $tim = time();
        for ($i = 0; $i < $cnt; $i++) {
            if ($servno1[$i] != 'u') {
                $servno2 = $servno1[$i];
                $to_id2 = $to_id1[$i];
                $to_name2 = $to_name1[$i];
                $dp2 = $dp1[$i];
                $dpid = $travelid . $servno2 . $to_id2 . $i . $tim;
                $data = array('service_num' => $servno2, 'travel_id' => $travelid, 'city_id' => $to_id2, 'city_name' => $to_name2, 'board_or_drop_type' => 'drop', 'board_drop' => $dp2, 'bpdp_id' => $dpid);
                $query = $this->db->insert('boarding_points', $data);
            }
        }
        if ($query)
            echo 1;
        else
            echo 0;
    }

//getting stored boarding points
    function getStoredBpFromDb() {
        $serno = $this->input->post('svc');
        $isvan = $this->input->post('isvan');
        $travid = $this->session->userdata('travel_id');
        $cnt = 1;
        if ($isvan == 1) {
            $isvanp = 'yes';
            $txt = 'Click Here to Delete VanPickup(s)';
        } else {
            $isvanp = 'no';
            $txt = 'Click Here to Delete Boarding Point(s)';
        }
        $this->db->distinct();
        $this->db->select('service_num,travel_id,city_id,city_name,board_or_drop_type,board_drop,bpdp_id');
        $where = array('service_num' => $serno, 'travel_id' => $travid, 'is_van' => $isvanp, 'board_or_drop_type' => 'board');
        $this->db->order_by('city_name', 'asc');
        $query = $this->db->get_where('boarding_points', $where);
        foreach ($query->result_array() as $row) {
            $bpid = $row['bpdp_id'];
            $bp_dp = $row['board_drop'];
            $city_name = $row['city_name'];
            $city_id = $row['city_id'];
            $x = explode("#", $bp_dp);
            $bp = $x['0'];
            $bptime = $x['1'];
            $lm = $x['2'];
            if ($bpid != '') {
                echo '<table border="0" id="showbpTable" width="600" cellpadding="0" cellspacing="0" align="right" style="border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; border-left:#f2f2f2 solid 1px; font-size:12px">
    <tr>
    <td width="12" align="center">
    <input type="checkbox" name="ck' . $cnt . '" id="ck' . $cnt . '" value="' . $bpid . '">    </td>
    <td width="103">
    <input type="hidden" name="cid' . $cnt . '" id="cid' . $cnt . '" value="' . $city_id . '">' . $city_name . '</td>
    <td width="144"><input type="hidden" name="bp' . $cnt . '" id="bp' . $cnt . '" value="' . $bp . '">' . $bp . '</td>
    <td width="143" align="center"><input type="hidden" name="lm' . $cnt . '" id="lm' . $cnt . '" value="' . $lm . '">' . $lm . '</td> 
    <td width="98" align="center"><input type="hidden" name="bptime' . $cnt . '" id="bptime' . $cnt . '" value="' . $bptime . '">' . $bptime . '</td>
     <td width="63">&nbsp;</td> 
  </tr>
</table>';
            } else {
                echo "0";
            }
            $cnt++;
        }
        if ($bpid != '') {
            echo '<table border="1" align="center" bordercolor="#f2f2f2">
  <tr>
    <td width="736" align="center">
      <span style="font-size:12px;"> ' . $txt . '</span>
      <input type="button" class="newsearchbtn" name="delbp' . $isvan . '" id="delbp' . $isvan . '" value="Delete" onClick="delBp(' . $cnt . ',' . $isvan . ')">
      <span id="deleted' . $isvan . '"><span>
   </td>
  </tr>
</table>';
        }
    }

//deleting boarding points from the database
    function deleteBpFromDb() {
        $cnt = $this->input->post('cnt');
        $bpdp_id = $this->input->post('arr');
        $bpdp = explode(',', $bpdp_id);
        for ($i = 1; $i < count($bpdp); $i++) {
            $this->db->where('bpdp_id', $bpdp[$i]);
            $query = $this->db->delete('boarding_points');
        }
        if ($query)
            echo 1;
        else
            echo 0;
    }

//deleteBp()
//getting stored dropping points

    function getStoredDpFromDb() {
        $serno = $this->input->post('svc');
        $travid = $this->session->userdata('travel_id');
        $cnt = 1;
        $this->db->distinct();
        $this->db->select('service_num,travel_id,city_id,city_name,board_or_drop_type,board_drop,bpdp_id');
        $where = array('service_num' => $serno, 'travel_id' => $travid, 'board_or_drop_type' => 'drop');
        $this->db->order_by('city_name', 'asc');
        $query = $this->db->get_where('boarding_points', $where);
        foreach ($query->result_array() as $row) {
            $dpid = $row['bpdp_id'];
            $dp = $row['board_drop'];
            $city_name = $row['city_name'];
            $city_id = $row['city_id'];
            if ($dpid != '') {
                echo '<table border="0" id="showbpTable" width="466" cellpadding="0" cellspacing="0" style="border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; border-left:#f2f2f2 solid 1px; font-size:12px">
  <tr>
    <td width="15%" align="center">
    <input type="checkbox" name="ck' . $cnt . '" id="ck' . $cnt . '" value="' . $dpid . '">    </td>
    <td width="27%">
    <input type="hidden" name="cid' . $cnt . '" id="cid' . $cnt . '" value="' . $city_id . '">' . $city_name . '</td>
    <td width="58%"><input type="hidden" name="dp' . $cnt . '" id="dp' . $cnt . '" value="' . $dp . '">' . $dp . '</td> 
  </tr>
</table>';
            } else {
                echo "0";
            }
            $cnt++;
        }
        if ($dpid != '') {
            $drop = 2;
            echo '<table border="1" bordercolor="#f2f2f2">
  <tr>
    <td width="456" align="center">
      <span style="font-size:12px;">Click Here to Delete Dropping Point(s)</span>
      <input type="button" class="newsearchbtn" name="deldp" id="deldp" value="Delete" onClick="delBp(' . $cnt . ',' . $drop . ')">
      <span id="deleteddp"><span>
   </td>
  </tr>
</table>';
        }
    }

    /*     * *******************End of boarding points******************** */
    /*     * *******************Eminities******************** */

    function storeEminitiesDb() {

        $sernum = $this->input->post('sernum');
        $others = $this->input->post('oth');
        $arr = $this->input->post('arr');
        $travid = $this->session->userdata('travel_id');
        $x = explode('#', $arr);
        $data = array('service_num' => $sernum, 'travel_id' => $travid, 'water_bottle' => $x[0], 'blanket' => $x[1], 'video' => $x[2], 'charging_point' => $x[3], 'other' => $others);
        $sql = $this->db->insert('eminities', $data);
//print_r($data);
        if ($sql)
            echo "1";
        else
            echo "0";
    }

    /*     * *******************Eminities End******************** */

    /*     * *******************Methods related to Activating the Bus******************** */

    function getServicesListActiveOrDeactive() {

        $travel_id = $this->input->post('opid');
        $srvno = $this->input->post('service');
        $key = $this->input->post('key');
        $this->db->distinct();
        $this->db->select('*');
        $this->db->from('master_buses');
        $this->db->where('travel_id', $travel_id);
        $this->db->where("service_num", $srvno);
//$this->db->join('master_layouts l','l.service_num = m.service_num');
        $this->db->group_by('service_num');
        $query2 = $this->db->get();
//return $query2->result();

        echo '<table width="99%" border="0" cellspacing="0" cellpadding="0">
<thead>
  <tr>
    <td height="43" colspan="2" style="border-bottom:#f2f2f2 solid 1px;"  ><strong>Service Type</strong></td>
     <td width="13%" height="43" align="center" class="space" style="border-bottom:#f2f2f2 solid 1px;"><strong>Service Number</strong></td>
    <td width="27%" height="43" align="center" class="space" style="border-bottom:#f2f2f2 solid 1px;"><strong>Route</strong></td>
    <td width="23%" height="43" align="center" class="space" style="border-bottom:#f2f2f2 solid 1px;"><strong>Bus Type</strong></td>
    <td width="9%" height="43" align="center" class="space"  style="border-bottom:#f2f2f2 solid 1px;" ><strong>Status</strong></td>
    <td width="12%" align="center" class="space" style="border-bottom:#f2f2f2 solid 1px;"><strong>Action</strong></td>
  </tr><thead><tbody>
    ';
        $i = 1;
//print_r($query);
        foreach ($query2->result() as $row) {
            $srvtype2 = $row->serviceType;
            $srvno = $row->service_num;


            if ($srvtype2 == '' || $srvtype2 == 'normal') {
                $srvtype = "normal";
            } else if ($srvtype2 == 'special') {
                $srvtype = "special";
            } else if ($srvtype2 == 'weekly') {
                $srvtype = "weekly";
            }
            $travid = $row->travel_id;
            if ($key == 'Delete') {
                $edit = '<input type="button" class="newsearchbtn" name="act' . $travid . $s . '" id="act' . $travid . $i . '" value="Delete" 
             onclick="deactivateBus(\'' . $srvno . '\',' . $travid . ',' . $i . ',' . $row->status . ',' . $row->from_id . ',
                  ' . $row->to_id . ',\'' . $key . '\')">';
                if ($row->status == 0 || $row->status == '') {
                    $st = 'DeActivated';
                } else {
                    $st = 'Activated';
                }
            } else {

                if ($row->status == 0 || $row->status == '') {
                    $edit = '<input type="button" class="newsearchbtn" name="act' . $travid . $s . '" id="act' . $travid . $i . '" value="Active" 
             onclick="activateBus(\'' . $srvno . '\',' . $travid . ',' . $i . ',' . $row->status . ',' . $row->from_id . ',
                  ' . $row->to_id . ')">';
                    $st = 'DeActivated';
                } else {
                    $st = 'Activated';
                    $edit = '<input type="button" class="newsearchbtn" name="act' . $travid . $s . '" id="act' . $travid . $i . '" value="DeActive" 
              onclick="deactivateBus(\'' . $srvno . '\',' . $travid . ',' . $i . ',' . $row->status . ',' . $row->from_id . ',
                  ' . $row->to_id . ',\'' . $key . '\')">';
                }
            }

            echo '<tr >
    <td height="38" colspan="2" align="center" class="space" style="border-bottom:#f2f2f2 solid 1px;">' . $srvtype . '</td>
    <input type="hidden"  value="' . $srvtype . '" id="sertype' . $i . '" name="sertype' . $i . '">
    <td height="38" align="center" class="space" style="border-bottom:#f2f2f2 solid 1px;">' . $srvno . '</td>
    <td height="38" align="center" class="space" style="border-bottom:#f2f2f2 solid 1px;">' . $row->service_route . '</td>
    <td height="38" align="center" class="space" style="border-bottom:#f2f2f2 solid 1px;">' . $row->model . '</td>
    <td height="38" align="center" class="space" style="border-bottom:#f2f2f2 solid 1px;">' . $st . ' </td>
    <td align="center" class="space" style="border-bottom:#f2f2f2 solid 1px;">' . $edit . ' </td>
       </tr>
    <tr  style="display:none;" >
 <td  colspan="7"  align="center" height="30" class="space" style="border-bottom:#f2f2f2 solid 1px;" ></td>
  </tr>
  <tr id="tr' . $i . '"  style="display:none;">
 <td  colspan="7" id="dp' . $i . '" align="center" height="30" class="space" style="border-bottom:#f2f2f2 solid 1px;" ></td>
  </tr>    
';
            $i++;
        }
        echo '<input type="hidden" id="hdd" value="' . $i . '" >
        <td width="8%"></tr><tbody>
</table>
';
    }

    /* Method for getting servive name and service no where status =1 .this method is used for showing all servive no in all view pages except in active bus */

    function getServicesList($key) {
        $travel_id = $this->session->userdata('travel_id');
        $other_services = $this->session->userdata('other_services');
        $sql = mysql_query("select distinct to_id,to_name,from_id,from_name,service_name from master_buses where  status='1' and travel_id='$travel_id'") or die(mysql_error());
        while ($res = mysql_fetch_array($sql)) {
            $from_name = $res['from_name'];
            $to_name = $res['to_name'];
            $from_id = $res['from_id'];
            $to_id = $res['to_id'];
            $service_name = $res['service_name'];
        }
//echo $from_id."/".$to_id."/".$service_name;
        $this->db->distinct();
        $this->db->select('*');
        $this->db->from('master_buses m');
        if ($other_services == "yes") {
            if ($key == '1') {

                $this->db->where('m.from_id ', $from_id);
                $this->db->or_where('m.to_id ', $to_id);
                $this->db->where('m.travel_id  <>', $travel_id);
                $this->db->where('m.service_name  <>', $service_name);
            } else
                $this->db->where('m.travel_id ', $travel_id);
        }
        else {
            $this->db->where('m.travel_id', $travel_id);
        }
        $this->db->where('m.status', 1);
// $this->db->join('master_layouts l','l.service_num = m.service_num');
// $this->db->group_by('m.service_num');
        $query2 = $this->db->get();
        $slist = array();
        $slist['0'] = '- - - Select - - -';
        foreach ($query2->result() as $rows) {
            $slist[$rows->service_num] = $rows->service_name . "(" . $rows->service_num . ")";
        }
        return $slist;
// return $query2->result();
    }

    function getServicesListForActiveOrDeactive() {
        $travel_id = $this->session->userdata('travel_id');
        $this->db->distinct();
        $this->db->select('*');
        $this->db->from('master_buses m');
        $this->db->where('m.travel_id', $travel_id);
        $this->db->join('master_layouts l', 'l.service_num = m.service_num');
        $this->db->group_by('m.service_num');
        $query2 = $this->db->get();
        $slist = array();
        $slist['0'] = '- - - Select - - -';
        foreach ($query2->result() as $rows) {
            $slist[$rows->service_num] = $rows->service_name . "(" . $rows->service_num . ")";
        }
        return $slist;
// return $query2->result();
    }

//getting serrvice details
    function getServicesListDetails() {
        $travel_id = $this->input->post('opid');
        $srvno = $this->input->post('service');
        $this->db->distinct();
        $this->db->select('*');
        $this->db->from('master_buses m');
        $this->db->join('master_layouts l', 'l.service_num = m.service_num');
        $this->db->where('m.travel_id', $travel_id);
        $this->db->where('m.service_num', $srvno);
        $this->db->where('l.service_num', $srvno);
        $this->db->group_by('m.service_num');
        $query2 = $this->db->get();
        $i = 1;
        if ($query2->num_rows() > 0) {
            echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  
                  <tr>
                    <td height="106" valign="top"><table width="108%" border="0" cellpadding="0" cellspacing="0" style="border-top:#f2f2f2 solid 5px;">
                       
                               
                                <tr>
                                  <td class="space" >&nbsp;</td>
                                  <td class="space" >&nbsp;</td>
                                  <td class="space" >&nbsp;</td>
                                  <td class="space" >&nbsp;</td>
                                  <td class="space" >&nbsp;</td>
                                  <td class="space" >&nbsp;</td>
                                  
                                </tr>
                                <tr style="font-weight:bold;">
                                  <td height="48" class="space" >SNo.</td>
                                   <td height="48" class="space" >ServiceRoute<td><span class="space">ServiceNumber</span>
                                  <td height="48" class="space" >Bus Type</td>
                                   <td height="48" class="space" >View </td>
                                   <td height="48" class="space" >Action</td>
                                  
                                </tr>
                              </thead>
                              <tbody>';
            foreach ($query2->result() as $row) {

                $travid = $row->travel_id;
                if ($row->status != 0 || $row->status != '') {
//values for Active or Deactive

                    $key1 = 'Deactive';
                    $key2 = 'Active';
//$st='<input type="button" class="newsearchbtn" name="act'.$travid.$i.'" id="act'.$travid.$i.'" value="Click To Deactive" onClick="deActivateBus(\''.$srvno.'\','.$travid.','.$i.','.$row->status.','.$row->from_id.','.$row->to_id.')">';
                    $st = '<a class="newsearchbtn" onClick="deActivateBus(\'' . $key1 . '\',\'' . $srvno . '\',' . $travid . ',' . $i . ',' . $row->status . ',' . $row->from_id . ',' . $row->to_id . ')">Cancel Service</a> | 
           <a class="newsearchbtn" onClick="deActivateBus(\'' . $key2 . '\',\'' . $srvno . '\',' . $travid . ',' . $i . ',' . $row->status . ',' . $row->from_id . ',' . $row->to_id . ')">Reactive Service</a>';
                    echo ' <tr >
    <td height="30" class="space" >' . $i . '</td> 
    <td  class="space">' . $row->service_route . '</td>       
    <td  class="space">' . $srvno . '</td>
   <td class="space" >' . $row->model . '</td>
    <td class="space"><a class="newsearchbtn" href="' . base_url() . 'createbus/ViewHistory?srvno=' . $srvno . '" target="_blank">View</a></td>    
    <td  class="space" >' . $st . '</td>
    </tr>
    <tr  style="display:none;"  >
 <td  colspan="7"  align="center"  ></td>
  </tr>
  <tr id="tr' . $i . '"  style="display:none;"  >
 <td height="6"  colspan="7" align="center" id="dp' . $i . '"  ></td>
  </tr>    
';
                }
            }
            echo '<input type="hidden" id="hdd" value="' . $i . '" >';
            echo ' </table></td>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>                  
                </table>';
        } else {
            echo 0;
        }
    }

//getServicesListDetails()

    function getForwordBookingDaysFromDb($travid) {
        $this->db->select('fwd');
        $this->db->where("travel_id", $travid);
        $query = $this->db->get("registered_operators");
        foreach ($query->result() as $row)
            $res = $row->fwd;
        return $res;
    }

    function activeBusStatusDb($travid, $sernum, $s, $fromid, $toid, $status, $fwd, $fdate, $tdate, $servtype) {
        /* getting the values from master_buses */
        $this->db->distinct();
        $array = array('service_num' => $sernum, 'travel_id' => $travid);
        $query = $this->db->get_where('master_buses', $array);

        /* getting the values from master_layouts */
        $this->db->select('*');
        $query2 = $this->db->get_where('master_layouts', $array);

        $fdate = date('Y-m-d', strtotime($fdate));
        $tdate = date('Y-m-d', strtotime($tdate));

        foreach ($query->result() as $rows) {
            $from_id = $rows->from_id;
            $to_id = $rows->to_id;
            $from_name = $rows->from_name;
            $to_name = $rows->to_name;
            $service_route = $rows->service_route;
            $service_name = $rows->service_name;
            $seat_fare = $rows->seat_fare;
            $lberth_fare = $rows->lberth_fare;
            $uberth_fare = $rows->uberth_fare;
            $travel_id = $travid;

            $fcheck = $this->db->query("select * from master_price where service_num='$sernum' and from_id='$from_id' and to_id='$to_id' and travel_id='$travel_id' and journey_date is NULL") or die(mysql_error());

            if ($fcheck->num_rows() <= 0) {
                $this->db->query("insert into master_price(service_num, travel_id, from_id, from_name, to_id, to_name, service_route, service_name, seat_fare, lberth_fare, uberth_fare) values('$sernum','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$seat_fare','$lberth_fare','$uberth_fare')");
            }
        }

        while ($fdate <= $tdate) {
//if service type is weekly 
            if ($servtype == 'weekly') {
                $sql = mysql_query("select  distinct(service_days) from master_buses where service_num='$sernum' and  travel_id='$travid' ")or die(mysql_error());
                while ($serdays = mysql_fetch_array($sql)) {
                    $ser_days1 = $serdays['service_days'];
                }
                $ser_days = explode('#', $ser_days1);
                $weekday = date('l', strtotime($fdate));
                if ($weekday == $ser_days[0] || $weekday == $ser_days[1]) {
                    /* deleteing deatils if already exist for particular date */
                    $tables = array('buses_list', 'layout_list');
                    $array2 = array('service_num' => $sernum, 'travel_id' => $travid, 'journey_date' => $fdate);
                    $this->db->where($array2);
                    $this->db->delete($tables);
                    foreach ($query->result() as $rows) {
                        if ($rows->service_num == $sernum) {
                            /* inserting into buses_list */
                            $data = array('service_num' => $sernum, 'from_id' => $rows->from_id, 'to_id' => $rows->to_id, 'travel_id' => $travid, 'status' => 1, 'journey_date' => $fdate, 'seat_fare' => $rows->seat_fare, 'lberth_fare' => $rows->lberth_fare, 'uberth_fare' => $rows->uberth_fare, 'available_seats' => $rows->seat_nos, 'lowerdeck_nos' => $rows->lowerdeck_nos, 'upperdeck_nos' => $rows->upperdeck_nos);
                            $insert_buses = $this->db->insert('buses_list', $data);
                        }//if
                    }//foreach
                    /* inserting into layout_list */
                    foreach ($query2->result() as $rows2) {
                        $data2 = array('travel_id' => $rows2->travel_id, 'layout_id' => $rows2->layout_id, 'seat_name' => $rows2->seat_name, 'row' => $rows2->row, 'col' => $rows2->col, 'seat_type' => $rows2->seat_type, 'window' => $rows2->window, 'is_ladies' => $rows2->is_ladies, 'service_num' => $rows2->service_num, 'available' => $rows2->available, 'available_type' => $rows2->available_type, 'fare' => $rows->seat_fare, 'lberth_fare' => $rows->lberth_fare, 'uberth_fare' => $rows->uberth_fare, 'journey_date' => $fdate, 'status' => 1);
                        $insert_layouts = $this->db->insert('layout_list', $data2);
                    }
                }
            } else {
                /* deleteing deatils if already exist for particular date */
                $tables = array('buses_list', 'layout_list');
                $array2 = array('service_num' => $sernum, 'travel_id' => $travid, 'journey_date' => $fdate);
                $this->db->where($array2);
                $this->db->delete($tables);
                foreach ($query->result() as $rows) {
                    if ($rows->service_num == $sernum) {
                        /* inserting into buses_list */
                        $data = array('service_num' => $sernum, 'from_id' => $rows->from_id, 'to_id' => $rows->to_id, 'travel_id' => $travid, 'status' => 1, 'journey_date' => $fdate, 'seat_fare' => $rows->seat_fare, 'lberth_fare' => $rows->lberth_fare, 'uberth_fare' => $rows->uberth_fare, 'available_seats' => $rows->seat_nos, 'lowerdeck_nos' => $rows->lowerdeck_nos, 'upperdeck_nos' => $rows->upperdeck_nos);
                        $insert_buses = $this->db->insert('buses_list', $data);
                    }//if
                }//foreach
                /* inserting into layout_list */
                foreach ($query2->result() as $rows2) {
                    $data2 = array('travel_id' => $rows2->travel_id, 'layout_id' => $rows2->layout_id, 'seat_name' => $rows2->seat_name, 'row' => $rows2->row, 'col' => $rows2->col, 'seat_type' => $rows2->seat_type, 'window' => $rows2->window, 'is_ladies' => $rows2->is_ladies, 'service_num' => $rows2->service_num, 'available' => $rows2->available, 'available_type' => $rows2->available_type, 'fare' => $rows->seat_fare, 'lberth_fare' => $rows->lberth_fare, 'uberth_fare' => $rows->uberth_fare, 'journey_date' => $fdate, 'status' => 1);
                    $insert_layouts = $this->db->insert('layout_list', $data2);
                }
            }


            $dat = strtotime("+1 day", strtotime($fdate));
            $fdate = date("Y-m-d", $dat);
        }//while

        if ($insert_buses && $insert_layouts) {
            /* updating bus status */
            $this->db->set('t1.status', '1');
            $this->db->set('t2.status', '1');
            $array3 = array('t1.service_num' => $sernum, 't1.travel_id' => $travid, 't2.service_num' => $sernum, 't2.travel_id' => $travid);
            $this->db->where($array3);
            $this->db->update('master_buses as t1, master_layouts as t2');
            return 1;
        }
    }

//method for deactivating the bus
    public function deActivateBusPermanentDb() {

        $travid = $this->input->post('travid');
        $s = $this->input->post('s');
        $sernum = $this->input->post('svc');
        $fromid = $this->input->post('fromid');
        $toid = $this->input->post('toid');
//$servtype=  $this->input->post('servtype');
//$tdate=  $this->input->post('tdate');
        $status = $this->input->post('status');
        $st = $this->input->post('st');
//echo $sernum;
//service deactive
        if ($st == 'DeActive') {
// updating status for refund of bus cancel  
            $this->db->set('t1.status', 0);
            $this->db->set('t2.status', 0);
            $this->db->set('t3.status', 0);
            $array3 = array('t1.service_num' => $sernum, 't1.travel_id' => $travid, 't2.service_num' => $sernum, 't2.travel_id' => $travid, 't3.service_num' => $sernum, 't3.travel_id' => $travid);

//$array3=array('t3.service_num'=>$sernum,'t3.travel_id'=>$travid);

            $this->db->where($array3);
            $sql = $this->db->update('buses_list as t1,layout_list as t2,master_buses as t3');
//$sql=$this->db->update('master_buses as t3');
//inserting cancelled service tickets in master table
            $date = date('Y-m-d');
            $curdate = date('Y-m-d');
            $now = date('Y-m-d H:i:s');
            $ip = $this->input->ip_address();

            $query5 = mysql_query("select * from master_booking where service_no='$sernum' and travel_id='$travid' and jdate>='$date'  and LOWER(status)='confirmed'");

            while ($val = mysql_fetch_array($query5)) {
// print_r($query5->result());
                if ($val[paid] == '' || $val[paid] == 0)
                    $paid = $val[tkt_fare];
                else
                    $paid = $val[paid];

                $agentid = $val[agent_id];

                $data1 = array('tkt_no' => $val[tkt_no], 'pnr' => $val[pnr], 'service_no' => $val[service_no], 'board_point' => $val[board_point], 'bpid' => $val[bpid], 'land_mark' => $val[land_mark], 'source' => $val[source], 'dest' => $val[dest], 'travels' => $val[travels], 'bus_type' => $val[bus_type], 'bdate' => $val[bdate], 'jdate' => $val[jdate], 'seats' => $val[seats], 'gender' => $val[gender], 'start_time' => $val[start_time], 'arr_time' => $val[arr_time], 'paid' => $val[paid], 'save' => $val[save], 'tkt_fare' => $val[tkt_fare], 'promo_code' => $val[promo_code], 'pname' => $val[pname], 'pemail' => $val[pemail], 'pmobile' => $val[pmobile], 'age' => $val[age], 'refno' => $val[refno], 'status' => 'cancelled', 'pass' => $val[pass], 'cseat' => $val[cseat], 'ccharge' => '0', 'camt' => '0', 'refamt' => $paid, 'travel_id' => $val[travel_id], 'mail_stat' => $val[mail_stat], 'sms_stat' => $val[sms_stat], 'ip' => $ip, 'time' => $val[time], 'cdate' => $curdate, 'ctime' => $now, 'id_type' => $val[id_type], 'id_num' => $val[id_num], 'padd' => $val[padd], 'alter_ph' => $val[alter_ph], 'fid' => $val[fid], 'tid' => $val[tid], 'operator_agent_type' => $val[operator_agent_type], 'agent_id' => $val[agent_id], 'is_buscancel' => 'yes', 'book_pay_type' => $val[book_pay_type], 'book_pay_agent' => $val[book_pay_agent]);
//print_r($data1);

                $st1 = $this->db->insert('master_booking', $data1);
//checking for agent balance.
                $query = mysql_query("select * from agents_operator where id='$agentid' and operator_id='$travid' ")or die(mysql_error());
                $res = mysql_fetch_array($query);
                $bal = $res['balance'];

                $ball = $bal + $paid;

                $sql7 = mysql_query("update agents_operator set balance='$ball' where id='$agentid' and operator_id='$travid' ")or die(mysql_error());
//sending SMS

                /* $user="pridhvi@msn.com:activa1525@";
                  $receipientno=$val[pmobile];
                  $senderID='SVTBUS';

                  $text="BUS CANCELLED for tck No. ".$val[tkt_no]." booked in ".$val[travels]." with DOJ ".$val[jdate]."";

                  $ch = curl_init();
                  curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                  curl_setopt($ch, CURLOPT_POST, 1);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$user&senderID=$senderID&receipientno=$receipientno&msgtxt=$text");
                  $buffer = curl_exec($ch);
                  $x=explode('=',$buffer);
                  $y=$x[1];
                  $z=explode(',',$y);
                  $stat=$z[0];
                  curl_close($ch); */
            }
            if ($sql) {
                echo 1;
            } else {
                echo 0;
            }
        }//if i.e service deactive
        else {
//	echo $sernum."".$travid;
            $sql1 = mysql_query("delete from master_buses where service_num='$sernum' and travel_id='$travid'") or die(mysql_error());
            $sql2 = mysql_query("delete  from master_layouts where service_num='$sernum' and travel_id='$travid'") or die(mysql_error());
            $sql3 = mysql_query("delete  from layout_list where service_num='$sernum' and travel_id='$travid'") or die(mysql_error());
            $sql4 = mysql_query("delete  from eminities where service_num='$sernum' and travel_id='$travid'") or die(mysql_error());
            $sql5 = mysql_query("delete  from buses_list where service_num='$sernum' and travel_id='$travid'") or die(mysql_error());
            $sql6 = mysql_query("delete  from boarding_points where service_num='$sernum' and travel_id='$travid'") or die(mysql_error());

            if ($sql1 && $sql2 && $sql3 && $sql4 && $sql5 && $sql6) {
                echo 1;
            } else {
                echo 0;
            }
        }//service delete
    }

//deActivateBusPermanentDb()

    function total_list($srvno) {
        $this->db->select('*');
        $this->db->where('service_num', $srvno);
        $this->db->where('status', 'Deactive');
        $query = $this->db->get('breakdown_history');

        return $query->num_rows();
    }

    function detail_breakdown($limit, $page, $srvno) {

        $this->db->limit($limit, $page);
        $this->db->select('*');
        $this->db->from('breakdown_history as b');
        $this->db->where('b.service_num', $srvno);
        $this->db->where('b.status', 'Deactive');
        $this->db->join('master_buses as bl', 'bl.service_num=b.service_num');
        $query = $this->db->get();
        return $query->result();
    }

    /*     * *******************End of Methods related to Activating the Bus******************** */

    /*     * *******************End of Methods related to Deactivating the Bus(BreakDown Updation)******************** */

    function mailForBusCancel($key, $sernum, $travid, $fdate, $tdate, $status, $cnt, $s, $fromid, $toid) {
        $check_fdate = date('Y-m-d', strtotime($fdate));
        $check_tdate = date('Y-m-d', strtotime($tdate));
        $count = 0;
//check is there anyone already book the seats  
        while ($check_fdate <= $check_tdate) {
            $array_where = array('service_no' => $sernum, 'jdate' => $fdate, 'travel_id' => $travid, 'fid' => $fromid, 'tid' => $toid);
            $this->db->select('*');
            $this->db->where($array_where);
            $sql_check = $this->db->get('master_booking');
            $count = $sql_check->num_rows();
            if ($count > 0)
                return 2;
            $check_dat = strtotime("+1 day", strtotime($check_fdate));
            $check_fdate = date("Y-m-d", $check_dat);
        }
        if ($count > 0)
            return 2;
        else
            return 0;
    }

    function deActivateBusDb($key, $sernum, $travid, $fdate, $tdate, $status, $cnt, $s, $fromid, $toid, $chkedRadio) {
        $user_id = $this->session->userdata('user_id');
        $name = $this->session->userdata('name');
		$checkbox = $this->input->post('checkbox');
		
        $sql = mysql_query("select distinct sender_id from registered_operators where travel_id='$travid'") or die(mysql_error());
        $row = mysql_fetch_array($sql);

        $senderID = $row['sender_id'];

        $fdate = date('Y-m-d', strtotime($fdate));
        $tdate = date('Y-m-d', strtotime($tdate));
        $curdate = date('Y-m-d');
        $now = date('Y-m-d H:i:s');
        $ip = $this->input->ip_address();

        if (trim($key) == 'Deactive') {
            $query = $this->db->query("select * from breakdown_history where service_num='$sernum' and travel_id='$travid' and from_id='$fromid' and to_id='$toid' and breakdown_date between '$fdate' and '$tdate' and current_date='$curdate' and status='Deactive'");
//echo "select * from breakdown_history where service_num='$sernum' and travel_id='$travid' and to_id='$toid' and breakdown_date between '$fdate' and '$tdate' and status='Deactive'";
// echo $query->num_rows();
            if ($query->num_rows() == 0) {
                while ($fdate <= $tdate) {
                    if ($chkedRadio == 'cancelled') {
// updating status for refund of bus cancel  
                        $this->db->set('t1.status', 2);
                        $this->db->set('t2.status', 2);
                        $array3 = array('t1.service_num' => $sernum, 't1.travel_id' => $travid, 't1.journey_date' => $fdate, 't2.service_num' => $sernum, 't2.travel_id' => $travid, 't2.journey_date' => $fdate);
                        $this->db->where($array3);
                        $sql = $this->db->update('buses_list as t1,layout_list as t2');
//inserting cancelled service tickets in master table 

                        $query5 = mysql_query("select * from master_booking where service_no='$sernum' and  jdate='$fdate' and travel_id='$travid' and LOWER(status)='confirmed'");

                        while ($val = mysql_fetch_array($query5)) {
// print_r($query5->result());
                            if ($val[paid] == '' || $val[paid] == 0)
                                $paid = $val[tkt_fare];
                            else {
                                $paid = $val[paid];
                            }
                            $agentid = $val[agent_id];
                            $tktno = $val[tkt_no];

                            $queryy = mysql_query("select * from master_booking where tkt_no='$tktno' and service_no='$sernum' and  jdate='$fdate' and travel_id='$travid' and LOWER(status)='cancelled'");
//echo "select * from master_booking where tkt_no='$tktno' service_no='$sernum' and  jdate='$fdate' and travel_id='$travid' and LOWER(status)='cancelled'";
//echo  mysql_num_rows($queryy)."/";
                            if (mysql_num_rows($queryy) <= 0) {
                                $data1 = array('tkt_no' => $val[tkt_no], 'pnr' => $val[pnr], 'service_no' => $val[service_no], 'board_point' => $val[board_point], 'bpid' => $val[bpid], 'land_mark' => $val[land_mark], 'source' => $val[source], 'dest' => $val[dest], 'travels' => $val[travels], 'bus_type' => $val[bus_type], 'bdate' => $val[bdate], 'jdate' => $val[jdate], 'seats' => $val[seats], 'gender' => $val[gender], 'start_time' => $val[start_time], 'arr_time' => $val[arr_time], 'paid' => $val[paid], 'save' => $val[save], 'tkt_fare' => $val[tkt_fare], 'promo_code' => $val[promo_code], 'pname' => $val[pname], 'pemail' => $val[pemail], 'pmobile' => $val[pmobile], 'age' => $val[age], 'refno' => $val[refno], 'status' => 'cancelled', 'pass' => $val[pass], 'cseat' => $val[cseat], 'ccharge' => '0', 'camt' => '0', 'refamt' => $paid, 'travel_id' => $val[travel_id], 'mail_stat' => $val[mail_stat], 'sms_stat' => $val[sms_stat], 'ip' => $ip, 'time' => $val[time], 'cdate' => $curdate, 'ctime' => $now, 'id_type' => $val[id_type], 'id_num' => $val[id_num], 'padd' => $val[padd], 'alter_ph' => $val[alter_ph], 'fid' => $val[fid], 'tid' => $val[tid], 'operator_agent_type' => $val[operator_agent_type], 'agent_id' => $val[agent_id], 'is_buscancel' => 'yes', 'book_pay_type' => $val[book_pay_type], 'book_pay_agent' => $val[book_pay_agent]);
//print_r($data1);

                                $st1 = $this->db->insert('master_booking', $data1);
                                $query = mysql_query("select * from agents_operator where id='$agentid' and operator_id='$travid' ")or die(mysql_error());
                                $res = mysql_fetch_array($query);
                                $bal = $res['balance'];

                                $ball = $bal + $paid;

                                $sql7 = mysql_query("update agents_operator set balance='$ball' where id='$agentid' and operator_id='$travid' ")or die(mysql_error());
                                $to = $val[pemail];

                                $subject = "Service Cancelled";

                                $message = '<html><head></head><body><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="25">Dear Customer, </td>
  </tr>
  <tr>
    <td height="25">&nbsp;</td>
  </tr>
  <tr>
    <td height="25">The below service is cancelled. Sorry for the inconvenice </td>
  </tr>
  <tr>
    <td height="25"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="25" align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="25" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="center">Ticket Number </td>
        <td align="center">' . $val[tkt_no] . '</td>
        <td align="center">&nbsp;</td>
        <td height="25" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="25" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="center">PNR Number </td>
        <td align="center">' . $val[pnr] . '</td>
        <td align="center">&nbsp;</td>
        <td height="25" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="25" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="center">Service Number </td>
        <td align="center">' . $val[service_no] . '</td>
        <td align="center">&nbsp;</td>
        <td height="25" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="25" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="center">Source</td>
        <td align="center">' . $val[source] . '</td>
        <td align="center">&nbsp;</td>
        <td height="25" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="25" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="center">Destination</td>
        <td align="center">' . $val[dest] . '</td>
        <td align="center">&nbsp;</td>
        <td height="25" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="25" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="center">Journey Date</td>
        <td align="center">' . $val[jdate] . '</td>
        <td align="center">&nbsp;</td>
        <td height="25" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="25" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="center">Seats</td>
        <td align="center">' . $val[seats] . '</td>
        <td align="center">&nbsp;</td>
        <td height="25" align="center">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table></body></html>';

                                mail($to, $subject, $message);


                                $user = "pridhvi@msn.com:activa1525@";
                                $receipientno = $val[pmobile];

                                $text = "BUS CANCELLED for tck No. " . $val[tkt_no] . " booked in " . $val[travels] . " with DOJ " . $val[jdate] . "";

                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POST, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$user&senderID=$senderID&receipientno=$receipientno&msgtxt=$text");
                                $buffer = curl_exec($ch);
                                $x = explode('=', $buffer);
                                $y = $x[1];
                                $z = explode(',', $y);
                                $stat = $z[0];
                                curl_close($ch);
                            }
                        }
                    }
//checking wether the record is already there or not
                    $query12 = $this->db->query("select * from breakdown_history where service_num='$sernum' and travel_id='$travid' and to_id='$toid'  and breakdown_date='$fdate' and status='Active'");
// echo $query->num_rows();
                    if ($query12->num_rows() == 0) {
                        $data = array(
                            'service_num' => $sernum,
                            'from_id' => $fromid,
                            'to_id' => $toid,
                            'current_date' => $curdate,
                            'breakdown_date' => $fdate,
                            'travel_id' => $travid,
                            'status' => $key,
                            'is_cancelled_or_alternative' => $chkedRadio,
                            'updated_by_id' => $user_id,
                            'updated_by' => $name
                        );
                        $st = $this->db->insert('breakdown_history', $data);
                    }//if($query12->num_rows()==0)
                    else {
                        $st = mysql_query("update breakdown_history set status='$key',is_cancelled_or_alternative='$chkedRadio' where service_num='$sernum' and travel_id='$travid' and to_id='$toid' and breakdown_date='$fdate' and status='Active'") or die(mysql_error());
                    }//else
//increamenting the date
                    $dat = strtotime("+1 day", strtotime($fdate));
                    $fdate = date("Y-m-d", $dat);
                }//while
                if ($chkedRadio == 'cancelled') {
                    $m = mysql_query("select distinct email from agents_operator where agent_type=='3'");
                    while ($row = mysql_fetch_array($m)) {
                        $email = $row['email'];
                        $subject = "Service Cancelled";
                        $message = '<html><head></head><body><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="25">Dear API Client, </td>
  </tr>
  <tr>
    <td height="25">&nbsp;</td>
  </tr>
  <tr>
    <td height="25">The <strong>' . $sernum . '</strong> service is cancelled from ' . $fdate . ' to ' . $tdate . '. </td>
  </tr>
  <tr>
    <td height="25">&nbsp;</td>
  </tr>
</table></body></html>';

                        mail($email, $subject, $message);
                    }

                    if ($sql && $st)
                        echo 1;
                    else
                        echo 0;
                }//if cancel
                else {
                    if ($st)
                        echo 1;
                    else
                        echo 0;
                }
            }//if deactive
            else {
                echo 2;
            }
        } else if (trim($key) == 'Active') {
            $fdate = date('Y-m-d', strtotime($fdate));
            $tdate = date('Y-m-d', strtotime($tdate));
            $curdate = date('Y-m-d');
            $now = date('H:i:s');

            while ($fdate <= $tdate) {
//checking in Db Whether the record is there or not
                $array4 = array('service_num' => $sernum, 'travel_id' => $travid, 'breakdown_date' => $fdate, 'from_id' => $fromid, 'to_id' => $toid, 'status' => Deactive);
                $this->db->select('*');
                $this->db->where($array4);

                $sql1 = $this->db->get('breakdown_history');

                $rowcount = $sql1->num_rows();

                if ($rowcount != 0) {
                    /*$this->db->set('status', 'Active');
                    $array5 = array('service_num' => $sernum, 'travel_id' => $travid, 'breakdown_date' => $fdate, 'from_id' => $fromid, 'to_id' => $toid, 'status' => Deactive);
                    $this->db->where($array5);
                    $sql2 = $this->db->update('breakdown_history');*/
					$sql2 = $this->db->query("update breakdown_history set status = 'Active',is_cancelled_or_alternative='reactivated' where service_num='$sernum' and travel_id='$travid' and breakdown_date='$fdate' and from_id='$fromid' and to_id='$toid' and status='Deactive'");
//updating status as active  in buses_list,layout_list
                    $this->db->set('t1.status', 1);
                    $this->db->set('t2.status', 1);
					
					if($checkbox == "release"){
                    $this->db->set('t2.is_ladies', 0);
                    $this->db->set('t2.seat_status', 0);					
					}else{
					$this->db->query("update master_booking set status = 'reactivated' where service_no='$sernum' and travel_id='$travid' and jdate='$fdate' and status='cancelled'");
					}
                    $array3 = array('t1.service_num' => $sernum, 't1.travel_id' => $travid, 't1.journey_date' => $fdate, 't2.service_num' => $sernum, 't2.travel_id' => $travid, 't2.journey_date' => $fdate);
                    $this->db->where($array3);
                    $sql = $this->db->update('buses_list as t1,layout_list as t2');
					
                }
                $dat = strtotime("+1 day", strtotime($fdate));
                $fdate = date("Y-m-d", $dat);
            }//while
            if ($sql2)
                echo 1;
            else
                echo 0;
        }
    }

//cancelled ticket informatiom

    function get_CancelDetails() {


        $sql = $this->db->query("select * from breakdown_history where status='Deactive' and is_cancelled_or_alternative='cancelled' ");
        return $sql;
    }

    function get_remarks_table() {
        $i = $this->input->post('j');
        $paid = $this->input->post('paid');

        echo "<table align='center'><tr style='font-size:12px' id='sh$i' align='center'>
            <td colspan='' align='right'>Refund Amount:</td><td align='left'><input type='text' id='amt$i' name='amt$i' value='$paid' size='13' readonly></td></tr>
            <tr style='font-size:12px' id='shh$i' align='center'>
            <td  colspan='' align='right'>Remarks:</td><td align='left'><textarea id='rem$i' name='rem$i' size='20px'></textarea></td></tr>
           <tr style='font-size:12px' id='shhh$i' align='center'>
            <td colspan='2'><input type='button' value='Submit' onclick='doRefund($i)'></td></tr>
           <tr style='font-size:12px' id='re$i' align='center'>
             <td colspan='2'>&nbsp;</td>
           </tr>
</table>
";
    }

//refunds 

    function do_amountRefundupdate() {
        $ramt = $this->input->post('amt');
        $rem = $this->input->post('rem');
        $serno = $this->input->post('ser');
        $traid = $this->input->post('tra');
        $tkt_no = $this->input->post('ticket');
        $agid = $this->input->post('agid');


        $ip = $this->input->ip_address();
        $refunddate = Date("Y-m-d");
        $reftime = Date("H:i:s");

//getting  agent balance
        $sql12 = mysql_query("select * from agents_operator where id='$agid'");
        $res = mysql_fetch_array($sql12);
        $bal = $res['balance'];

        $bal1 = $bal + $ramt;

//updating master booking as refunded

        $masBookingUppdate = mysql_query("update master_booking set  is_refunded='yes' where tkt_no='$tkt_no' and LOWER(status)='cancelled'")or die(mysql_error());


//updating agent amount
        $agOperatorUpdate = mysql_query("update agents_operator set  balance='$bal1' where id='$agid'")or die(mysql_error());

//inserting refund details into  master_pass_reports

        $query5 = mysql_query("select * from master_booking where tkt_no='$tkt_no'  and travel_id='$traid' and LOWER(status)='confirmed'");

        while ($val = mysql_fetch_array($query5)) {


            $tktno = $val[tkt_no];
            $pnr = $val[pnr];
            $pass_name = $val[pname];
            $source = $val[source];
            $destination = $val[dest];
            $tkt_fare = $val[tkt_fare];
            $refamt = $ramt;
            $dat = $refunddate;
            $ip = $ip;
            $agent_id = $val[agent_id];
            $travel_id = $val[travel_id];
            $status = 'cancelled';
            $remarks = 'ServiceCancelled';


            $value = mysql_query("insert into master_pass_reports(tktno,pnr,pass_name,source,destination,tkt_fare,refamt,dat,ip,agent_id,travel_id,status,remarks)values('$tktno','$pnr','$pass_name','$source','$destination','$tkt_fare','$refamt','$dat','$ip','$agent_id','$travel_id','$status','$remarks')")or die(mysql_error());
        }

//inserting refund details for tracking purpose

        $in = mysql_query("insert into online_refund(service_no,travel_id,ticket_no,refund_amt,refund_date,refund_time,remarks,ip) values('$serno','$traid','$tkt_no','$ramt','$refunddate','$reftime','$rem','$ip') ") or die(mysql_error());

        if ($in && $masBookingUppdate)
            echo 1;
        else {
            echo 0;
        }
    }

    /*     * **
     * *****************************CHANGE PRICING*********************************
     * ***********************************Get Service Numbers List**************** */

    public function getSericeNumbers() {
        $travel_id = $this->session->userdata('travel_id');
        $this->db->distinct();
        $this->db->select('*');
        $array = array('travel_id' => $travel_id, 'status' => 1);
        $this->db->where($array);
        $query = $this->db->get('master_buses');
        $data = array();
        $data['0'] = "--select--";
//$data['1']="All Services";
        foreach ($query->result() as $rows) {
            $data[$rows->service_num] = $rows->service_name . "(" . $rows->service_num . ")";
        }
        return $data;
    }

//to display the selected service or all services 
    function getRoutesFromDb($svc, $opid) {
        $travel_id = $opid;
        $this->db->distinct();
        $this->db->where('service_num', $svc);
        $this->db->where('travel_id', $travel_id);
        $query = $this->db->get('master_buses');
        return $query;
    }

//getRoutesFromDb()

    function updateFareDb() {
        $btype = $this->input->post('btype');
        $srvnum = $this->input->post('serno');
        $travid = $this->input->post('travelid');
        $fid = $this->input->post('fid');
        $tid = $this->input->post('tid');
        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');
        $lbfare = $this->input->post('lbfare');
        $ubfare = $this->input->post('ubfare');
        $sfare = $this->input->post('sfare');

        $fid1 = explode("/", $fid);
        $tid1 = explode("/", $tid);
        $sfare1 = explode("/", $sfare);
        $lbfare1 = explode("/", $lbfare);
        $ubfare1 = explode("/", $ubfare);
        $ip = $this->input->ip_address();
        $time = date('Y-m-d H:m:s', time());
        $user_id = $this->session->userdata('user_id');
        $name = $this->session->userdata('name');
        echo "$name";
//$fdate='2014-09-12';
//$tdate='2014-09-15';
        $dt = array();

        $iDateFrom = mktime(1, 0, 0, substr($fdate, 5, 2), substr($fdate, 8, 2), substr($fdate, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($tdate, 5, 2), substr($tdate, 8, 2), substr($tdate, 0, 4));

        if ($iDateTo >= $iDateFrom) {
            array_push($dt, date('Y-m-d', $iDateFrom)); // first entry
            while ($iDateFrom < $iDateTo) {
                $iDateFrom+=86400; // add 24 hours
                array_push($dt, date('Y-m-d', $iDateFrom));
            }
        }
//print_r($fid1);

        for ($i = 0; $i < count($dt); $i++) {
            for ($j = 0; $j < count($fid1); $j++) {
                $ssql = mysql_query("select * from master_price where from_id='$fid1[$j]' and to_id='$tid1[$j]' and service_num='$srvnum' and travel_id='$travid' and journey_date='$dt[$i]'");

                if (mysql_num_rows($ssql) > 0) {
                    mysql_query("update master_price set seat_fare='$sfare1[$j]',lberth_fare='$lbfare1[$j]' ,uberth_fare='$ubfare1[$j]',seat_fare_changed='',lberth_fare_changed='',uberth_fare_changed='' where service_num='$srvnum' and from_id='$fid1[$j]' and to_id='$tid1[$j]' and travel_id='$travid' and journey_date='$dt[$i]'");
                } else {
                    $sql = mysql_query("select * from master_buses where from_id='$fid1[$j]' and to_id='$tid1[$j]' and service_num='$srvnum' and travel_id='$travid'");
                    $row = mysql_fetch_assoc($sql);
                    $from_name = $row['from_name'];
                    $to_name = $row['to_name'];
                    $service_route = $row['service_route'];
                    $service_name = $row['service_name'];

//updating in master_price 
                    $data1 = mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,seat_fare,lberth_fare,uberth_fare,journey_date) 
            values('$srvnum','$travid','$fid1[$j]','$from_name','$tid1[$j]','$to_name','$service_route','$service_name','$sfare1[$j]','$lbfare1[$j]','$ubfare1[$j]','$dt[$i]')")or die(mysql_error());
                }

//insert into master_change_pricing table
                $data = mysql_query("insert into master_change_pricing(travel_id,service_num,from_id,to_id,new_seat_fare,new_lberth_fare,new_uberth_fare,change_time,ip_address,journey_date,updated_by_id,updated_by)values('$travid','$srvnum','$fid1[$j]','$tid1[$j]','$sfare1[$j]','$lbfare1[$j]','$ubfare1[$j]','$time','$ip','$dt[$i]','$user_id','$name')")or die(mysql_error());

//updating in buses_list table
                $da = mysql_query("update buses_list set seat_fare='$sfare1[$j]',lberth_fare='$lbfare1[$j]' ,uberth_fare='$ubfare1[$j]' where service_num='$srvnum' and from_id='$fid1[$j]' and to_id='$tid1[$j]' and travel_id='$travid' and journey_date='$dt[$i]'");
            }
        }

        if ($data && $da) {
            echo 1;
        } else {
            echo 0;
        }
    }

    /*     * ************method for getting fares day wise*************** */

    function getFaresDb() {

        $today = date("Y-m-d");
        $srvnum = $this->input->post('srvnum');
        $travid = $this->input->post('travid');
        $fid = $this->input->post('fid');
        $tid = $this->input->post('tid');
//query for getting the fares from master_buses
        $this->db->select('bus_type,seat_fare,lberth_fare,uberth_fare');
        $where1 = array('service_num' => $srvnum, 'travel_id' => $travid, 'from_id' => $fid, 'to_id' => $tid, 'status' => 1);
        $this->db->where($where1);
        $query = $this->db->get('master_buses');
        foreach ($query->result() as $rows1) {
            $base = $rows1->seat_fare;
            $base_lb = $rows1->lberth_fare;
            $base_ub = $rows1->uberth_fare;
            $btype = $rows1->bus_type;
        }//foreach
//query for getting the fares from master_buses
        /*  $this->db->select('journey_date,seat_fare,lberth_fare,uberth_fare');
          $this->db->order_by("journey_date",'asc');
          $where2=array('service_num'=>$srvnum,'travel_id'=>$travid,'from_id'=>$fid,'to_id'=>$tid,'journey_date >'=>$today);
          $this->db->where($where2);
          $query2=  $this->db->get('buses_list'); */
        $query2 = $this->db->query("SELECT journey_date,seat_fare,lberth_fare,uberth_fare FROM `buses_list` WHERE service_num='$srvnum' and travel_id='$travid' and from_id='$fid' and `to_id`='$tid' and journey_date >='$today' ORDER BY journey_date asc");
//foreach
        if ($query2->num_rows() <= 0) {
            echo "This service is Not Available!!";
        } else {
            if ($query2->num_rows() > 0) {//atleast one record should be there in buses_list.
//echo "<table align='center' valign='top'><tr><td>Base s : Seater Base Fare</td><td>&nbsp;</td>&nbsp;&nbsp;&nbsp;<td>New S : Seater New Fare</td></tr></table><br/>";
                if ($btype == 'seater')
                    echo '<span>Base s : Seat Base Fare&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New S : Seat New Fare</span>';
                else if ($btype == 'sleeper')
                    echo '<span>Base LB : Base LowerBerth Fare&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New LB : New LowerBerth Fare</span> </br><span>Base UB : Base UpperBerth Fare&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New UB : New UpperBerth Fare</span>';
                else
                    echo '<span>Base S : Seat Base Fare&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New S : Seat New Fare</span><br/><span>Base LB : Base LowerBerth Fare&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New LB : New LowerBerth Fare</span> </br><span>Base UB : Base UpperBerth Fare&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New UB : New UpperBerth Fare</span>';
                echo "<table  align='center'  border='0' id='tab' style='border: #F0F0F0 solid 1px;'><tr style='font: 14px Arial;color: #666666;background: #F0F0F0;'><th>&nbsp;<input type='checkbox' name='call0' id='call0' class='cls0' value='cls0' onclick='checkAll(this.value)'/>&nbsp;SUNDAY&nbsp;</th><th>&nbsp;MONDAY&nbsp;</th><th>&nbsp;TUESDAY&nbsp;</th><th>WEDNESDAY</th><th>&nbsp;THURSDAY&nbsp;</th><th>&nbsp;<input type='checkbox' name='call5' id='call5' class='cls5' value='cls5' onclick='checkAll(this.value)'/>&nbsp;FRIDAY&nbsp;</th><th>&nbsp;<input type='checkbox' name='call6' id='call6' class='cls6' value='cls6' onclick='checkAll(this.value)'/>&nbsp;SATURDAY&nbsp;</th></tr>";
            }//if()
            $ld = 's';
            $gg = 0;
            echo "<font style='font: arial 12px;'>";
            foreach ($query2->result() as $rows2) {

                $sfare = $rows2->seat_fare;
                $lbfare = $rows2->lberth_fare;
                $ubfare = $rows2->uberth_fare;
                $jdt = $rows2->journey_date;
                $d = date('w', strtotime($jdt));
                if ($ld > $d || $ld == 's') { //week start
                    if ($ld == 's') {
                        $gg++;
                        echo "<tr>";
                    } else {
                        $gg++;
                        echo "</tr><tr>";
                    }
                    for ($i = 0; $i < $d; $i++) {
                        echo "<td class='tdcss' id='fg$gg$d'>&nbsp;&nbsp;</td>";
                    }
                }//if
                if ($btype == 'seater') {
                    if ($base == $sfare) {
                        $sfare = '';
                    }
                    $snsl = "<td class='tddcss' id='fg$gg$d'><font style='font-family: arial; font-size: 14px;'><input type='checkbox' name='chk$jdt' id='chk$jdt' class='cls$d' value='chk$jdt' onclick='clk(this.value)'/> " . date('d M', strtotime($jdt)) . "<br/>Base S:$base<br/>New S:";
                    $snsl = $snsl . '<input type="text" name="sp' . $jdt . '" id="sp' . $jdt . '" value="' . $sfare . '" class="chkcls' . $d . '" disabled="disabled" style="width: 40px;"/></font></td>';
                } //if 
                else if ($btype == 'sleeper') {

                    if ($base_lb == $lbfare) {
                        $lbfare = '';
                    }
                    if ($base_ub == $ubfare) {
                        $ubfare = '';
                    }
                    $snsl = "<td class='tdcpsleeper' id='fg$gg$d'><font style='font-family: arial; font-size: 14px;'><input type='checkbox' name='chk$jdt' id='chk$jdt' value='chk$jdt' class='cls$d' onclick='clk(this.value)'/> " . date('d M', strtotime($jdt)) . "<br/>Base LB:$base_lb<br/>Base UB:$base_ub<br/>New LB:<input type='text' name='lb$jdt' id='lb$jdt' value='$lbfare' class='chkcls$d' style='width: 40px;' disabled='disabled'/><br/>New UB:<input type='text' name='ub$jdt' id='ub$jdt' value='$ubfare' class='chkcls$d' style='width: 40px;' disabled='disabled'/></font></td>";
                }//else if-sleeper
                else { //seatersleeper
                    if ($base == $sfare)
                        $sfare = '';
                    if ($base_lb == $lbfare)
                        $lbfare = '';
                    if ($base_ub == $ubfare)
                        $ubfare = '';
                    $snsl = "<td class='tdcpsleeper' id='fg$gg$d'><font style='font-family: arial; font-size: 14px;'><input type='checkbox' name='chk$jdt' id='chk$jdt' value='chk$jdt' class='cls$d' onclick='clk(this.value)'/> " . date('d M', strtotime($jdt)) . "<br/>Base S:$base<br/>Base LB:$base_lb<br/>Base UB:$base_ub<br/>New &nbsp;S:<input type='text' name='sp$jdt' id='sp$jdt' class='chkcls$d' style='width: 40px;' value='$sfare' disabled='disabled'/><br/>New LB:<input type='text' name='lb$jdt' id='lb$jdt' class='chkcls$d' style='width: 40px;' value='$lbfare' disabled='disabled'/><br/>New UB:<input type='text' name='ub$jdt' id='ub$jdt' style='width: 40px;' class='chkcls$d' value='$ubfare' disabled='disabled'/></font></td>";
                }//else
                echo $snsl;
                $ld = $d;
            }//foreach
            echo '</tr><tr><td colspan="7" align="center"><input type="button" class="newsearchbtn" name="update" id="update" value="Update Fare" onClick="updatePrice(\'' . $srvnum . '\',' . $travid . ',' . $fid . ',' . $tid . ',\'' . $btype . '\')"><input type="hidden" id="btype" value="' . $btype . '"><span id="stat"></span></td>
           </tr></table><br/>';
        }
    }

//getFaresDb()
    /* method for updating the fares in database for particular dates */

    function updatePriceDb() {
        $btype = $this->input->post('btype');
        $srvnum = $this->input->post('svc');
        $travid = $this->input->post('travid');
        $fid = $this->input->post('fid');
        $tid = $this->input->post('tid');
        $dates = $this->input->post('dates');
        $dt = explode("#", $dates);
        $ip = $this->input->ip_address();
        $time = date('Y-m-d H:m:s', time());
        $user_id = $this->session->userdata('user_id');
        $name = $this->session->userdata('name');
        if ($btype == 'seater') {
            $fares = $this->input->post('fares');
            $fr = explode("#", $fares);
            for ($i = 1; $i < count($dt); $i++) {
//insert into master_change_pricing table
                $data = array('travel_id' => $travid, 'service_num' => $srvnum, 'from_id' => $fid, 'to_id' => $tid, 'new_seat_fare' => $fr[$i], 'change_time' => $time, 'ip_address' => $ip, 'journey_date' => $dt[$i], 'updated_by_id' => $user_id, 'updated_by' => $name);
                $query2 = $this->db->insert('master_change_pricing', $data);
//updating in buses_list table
                $this->db->set('seat_fare', $fr[$i]);
                $check = array('service_num' => $srvnum, 'from_id' => $fid, 'to_id' => $tid, 'travel_id' => $travid, 'journey_date' => $dt[$i]);
                $this->db->where($check);
                $query = $this->db->update('buses_list');
//updating in layout_list
                $this->db->set('fare', $fr[$i]);
                $check2 = array('travel_id' => $travid, 'service_num' => $srvnum, 'journey_date' => $dt[$i]);
                $this->db->where($check2);
                $query_layout = $this->db->update('layout_list');
            }//for
        }//seater
        else if ($btype == 'sleeper') {
            $lbf = $this->input->post('lbf');
            $lb = explode("#", $lbf);
            $ubf = $this->input->post('ubf');
            $ub = explode("#", $ubf);

            for ($i = 1; $i < count($dt); $i++) {
//insert into master_change_pricing table
                $data = array('travel_id' => $travid, 'service_num' => $srvnum, 'from_id' => $fid, 'to_id' => $tid, 'new_lberth_fare' => $lb[$i], 'new_uberth_fare' => $ub[$i], 'change_time' => $time, 'ip_address' => $ip, 'journey_date' => $dt[$i], 'updated_by_id' => $user_id, 'updated_by' => $name);
                $query2 = $this->db->insert('master_change_pricing', $data);
//updating in layout_list table
                $this->db->set('lberth_fare', $lb[$i]);
                $this->db->set('uberth_fare', $ub[$i]);
                $check = array('service_num' => $srvnum, 'from_id' => $fid, 'to_id' => $tid, 'travel_id' => $travid, 'journey_date' => $dt[$i]);
                $this->db->where($check);
                $query = $this->db->update('buses_list');
//updating in layout_list
                $this->db->set('lberth_fare', $lb[$i]);
                $this->db->set('uberth_fare', $ub[$i]);
                $check2 = array('travel_id' => $travid, 'service_num' => $srvnum, 'journey_date' => $dt[$i]);
                $this->db->where($check2);
                $query_layout = $this->db->update('layout_list');
            }
        }//sleeper
        else {
            $lbf = $this->input->post('lbf');
            $lb = explode("#", $lbf);
            $ubf = $this->input->post('ubf');
            $ub = explode("#", $ubf);
            $fares = $this->input->post('fares');
            $fr = explode("#", $fares);
            for ($i = 1; $i < count($dt); $i++) {
//insert into master_change_pricing table
                $data = array('travel_id' => $travid, 'service_num' => $srvnum, 'from_id' => $fid, 'to_id' => $tid, 'new_seat_fare' => $fr[$i], 'new_lberth_fare' => $lb[$i], 'new_uberth_fare' => $ub[$i], 'change_time' => $time, 'ip_address' => $ip, 'journey_date' => $dt[$i], 'updated_by_id' => $user_id, 'updated_by' => $name);
                $query2 = $this->db->insert('master_change_pricing', $data);
//updating in layout_list table
                $this->db->set('seat_fare', $fr[$i]);
                $this->db->set('lberth_fare', $lb[$i]);
                $this->db->set('uberth_fare', $ub[$i]);
                $check = array('service_num' => $srvnum, 'from_id' => $fid, 'to_id' => $tid, 'travel_id' => $travid, 'journey_date' => $dt[$i]);
                $this->db->where($check);
                $query = $this->db->update('buses_list');
//updating in layout_list
                $this->db->set('fare', $fr[$i]);
                $this->db->set('lberth_fare', $lb[$i]);
                $this->db->set('uberth_fare', $ub[$i]);
                $check2 = array('travel_id' => $travid, 'service_num' => $srvnum, 'journey_date' => $dt[$i]);
                $this->db->where($check2);
                $query_layout = $this->db->update('layout_list');
            }
        }//seatersleeper
        if ($query2)
            echo 1;
        else
            echo 0;
    }

//updatePriceDb

    /*     * *****************************Service Deletion Code******************************** */

    function ShowBusService() {
        $travel_id = $this->session->userdata('travel_id');
        $this->db->distinct();
        $this->db->select('service_num');
        $this->db->where("travel_id", $travel_id);
        $query = $this->db->get("master_buses");
        $this->db->select('*');
        $this->db->where("travel_id", $travel_id);
        $this->db->group_by("service_num", $query->result());
        $query2 = $this->db->get("master_buses");
        return $query2->result();
    }

    function DeleteBusService($sernum, $travel_id) {
        $tables = array('master_layouts', 'master_buses', 'buses_list', 'layout_list');
        $this->db->where('service_num', $sernum);
        $this->db->where('travel_id', $travel_id);
        $this->db->delete($tables);
        $this->db->select('*');
        $array = array('service_num' => $sernum);
        $q = $this->db->get_where('master_buses', $array);

        if ($q->num_rows() <= 0)
            echo '1';
        else
            echo 0;
    }

    /*     * *****************************End of Service Deletion Code******************************** */

    /*     * ************************Show Layout******************************************** */

    function show_service() {
        $travel_id = $this->session->userdata('travel_id');
        $this->db->distinct();
        $this->db->select('service_num');
        $this->db->where('travel_id', $travel_id);
        $this->db->where('status', 1);
        $this->db->order_by("service_num", "asc");
        $records = $this->db->get('master_buses');

        $data = array();
        $data[0] = '----------select-----------';
        foreach ($records->result() as $row) {
            $data[$row->service_num] = $row->service_num;
        }
        return ($data);
    }

    function display_service_layout($travel_id, $sernum) {
        $this->db->select('layout_id,seat_type');
        $this->db->where('service_num', $sernum);
        $this->db->where('travel_id', $travel_id);
        $sql = $this->db->get('master_layouts');
        foreach ($sql->result() as $row) {
            $layout_id = $row->layout_id;
            $seat_type = $row->seat_type;
            $lid = explode("#", $layout_id);
        }


        $this->db->select('*');
        $this->db->where('service_num', $sernum);
        $this->db->where('travel_id', $travel_id);
        $sql2 = $this->db->get('master_buses');

//for getting bus details


        echo '<table width="70%" border="0" align="center" style="border:#f2f2f2 solid 4px;">
  <tr>
    <td width="10%" align="center"></td>
    <td width="50%" align="center"></td>
    <td width="50%" align="center"></td>
    <td width="5" align="center"></td>
  </tr>
  <tr >
    <td align="left" style="border-bottom:#f2f2f2 solid 2px;font-weight:bold; font-size:12px;">&nbsp;</td>
    <td align="left" style="border-bottom:#f2f2f2 solid 2px;font-weight:bold; font-size:12px;">Service Details</td>
    <td align="center" style="border-bottom:#f2f2f2 solid 2px;font-weight:bold; font-size:12px;">Layout </td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left"><table border="0" style="font-size:12px;">';
        $a = 1;
        foreach ($sql2->result() as $row2) {

            echo '<tr>
        
        <td width="250">Source to Destination :</td>
        <td width="250">' . $row2->from_name . '-' . $row2->to_name . '</td>
      </tr>
     
      <tr>
       
        <td>Bus Type :</td>
        <td>' . $row2->model . '</td>
      </tr>
      <tr>
        
        <td>Start Time :</td>
        <td>' . $row2->start_time . '</td>
      </tr>
      
      <tr>
        
        <td>Total seats :</td>
        <td>' . $row2->seat_nos . '</td>
      </tr>
      <tr>
        
        <td>Fare(s) :</td>
     <td>';



            if ($lid[1] == 'seater') {
                $fare = $row2->seat_fare;
            } else if ($lid[1] == 'sleeper') {
                $fare = $row2->lberth_fare . "(L)," . $row2->uberth_fare . "(U)";
            } else {
                $fare = $row2->seat_fare . "," . $row2->lberth_fare . "(L)," . $row2->uberth_fare . "(U)";
            }
            echo $fare;
            echo '</td>
                      <tr height="50px"><td> </td>
                      </tr>
                      
              </tr>';

            $a++;
        }
        echo '</table></td>
    <td align="center"  style="border-left:#f2f2f2 solid 4px;">';
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
                    } else { // if($available==1)
                        echo "<td style='background-color: #fff; width:35px'>$seat_name</td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo '</table></td></tr></table>
                </td>
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
                        echo "<td style='background-color: #fff; width:30px'>$seat_name</td>";
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
                        echo "<td style='background-color: #fff; width:30px'>$seat_name</td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo '</table> </td></tr></table>
                </td>
                </tr>
              </table>';
        }// if(sleeper)
        else if ($lid[1] == 'seatersleeper') {

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
                    $this->db->where("(seat_type='U:b' OR seat_type='U')");
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
                        echo "<td style='background-color: #E4E4E4; width:35px'>$seat_name$st</td>";
                    }//inner for
                    $seat_name = '';
                }//else
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
                        echo "<td style='background-color: #fff; width:35px'>$seat_name$st</td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo '</table> </td> </tr></table>
                                   </td>
                                 </tr>
                                </table>';
        }//if(seatersleeper) 
    }

    /*     * ************************End of show layout********************************* */
    /*     * ***********************View changed price history************************** */

    function service_List() {
//display all the services in listbox
        $this->db->select("service_num");
        $travel_id = $this->session->userdata('travel_id');
        $this->db->where('travel_id', $travel_id);
        $this->db->order_by("service_num", "asc");
        $query = $this->db->get("master_buses");
        $data = array();
        $data['0'] = '-----select-----';
        $data['1'] = 'All Services';
        foreach ($query->result() as $rows) {
            $data[$rows->service_num] = $rows->service_num;
        }
        return $data;
    }

    function display_servicelist() {
//display the table of the services in the page
        $travel_id = $this->session->userdata('travel_id');
        $sernum = $this->input->post('service_num');
        $this->db->select('*');
        if ($sernum == 1) {
            $this->db->where('travel_id', $travel_id);
        } else {
            $this->db->where('service_num', $sernum);
            $this->db->where('travel_id', $travel_id);
        }
        $query = $this->db->get('master_buses');

        echo '<table id="tablecss" width="660" cellspacing="0" cellpadding="0">
                 <tr class="trclass">

                    <th class="thcss">Service No.</th>
                    <th class="thcss">From</th>
                    <th class="thcss">To</th>
                    <th class="thcss">Bus Type</th>
                    <th class="thcss">Bus Model</th>
                    <th class="thcss">Action</th>
                    </tr>';

        $s = 1;
        foreach ($query->result() as $row) {
            $from = $row->from_id;
            $to = $row->to_id;
            $bustype = $row->bus_type;
            echo "<tr>";

            echo "<td class='tdcss'>" . $row->service_num . "</td>";
            echo "<td class='tdcss'>" . $row->from_name . "</td>";
            echo "<td class='tdcss'>" . $row->to_name . "</td>";
            echo "<td class='tdcss'>" . $row->bus_type . "</td>";
            echo "<td class='tdcss'>" . $row->model . "</td>";
            echo "<td class='tdcss' align='center'><input type='button' value='Get History' 
onClick='viewPriceHistory(\"" . $row->service_num . "\"," . $from . "," . $to . ",\"" . $bustype . "\"," . $s . ")'/></td>";
            echo "</tr>";
            echo "<td class='tdcss' colspan='6' style='font-size:14px; display:none' 
id='trr" . $s . "' align='center'>
</td>
  </tr>";
            $s++;
        }
        echo "</table><input type='hidden' id='cnt' value='" . $s . "'/>";
    }

    function display_history() {
//get the history of the services
        $sernum = $this->input->post('service_num');
        $from = $this->input->post('from_id');
        $to = $this->input->post('to_id');
        $bustype = $this->input->post('bus_type');

        if ($bustype == 'seater') {

            $this->db->select('*');
            $this->db->where('service_num', $sernum);
            $this->db->where('from_id', $from);
            $this->db->where('to_id', $to);
            $sql = $this->db->get('master_change_pricing');
            echo '<table  width="680" id="tablecss" cellspacing="0" cellpadding="0" >
                <tr class="trclass">
                <th class="thcss">Changed Seat fare</th>
                <th class="thcss">Journey date</th>
                <th class="thcss">Time</th>
                <th class="thcss">IP Address</th>
                </tr>';
            $p = 1;
            foreach ($sql->result() as $row) {
                echo '<tr>';
                echo "<td class='tdcss'>" . $row->new_seat_fare . "</td>";
                echo "<td class='tdcss'>" . $row->journey_date . "</td>";
                echo "<td class='tdcss'>" . $row->change_time . "</td>";
                echo "<td class='tdcss'>" . $row->ip_address . "</td>";
                echo "</tr>";
                $p++;
            }
            echo "</table>";
        } else if ($bustype == 'sleeper') {

            $this->db->select('*');
            $this->db->where('service_num', $sernum);
            $this->db->where('from_id', $from);
            $this->db->where('to_id', $to);
            $sql = $this->db->get('master_change_pricing');
            echo '<table width="680" id="tablecss" cellspacing="0" cellpadding="0">
                <tr class="trclass">
                <th class="thcss">Changed lower berth fare</th>
                <th class="thcss">Changed upper berth fare</th>
                <th class="thcss"Journey date</th>
                <th class="thcss">Time</th>
                <th class="thcss">IP Address</th>
                </tr>';
            $p = 1;
            foreach ($sql->result() as $row) {
                echo '<tr>';
                echo "<td class='tdcss'>" . $row->new_lberth_fare . "</td>";
                echo "<td class='tdcss'>" . $row->new_uberth_fare . "</td>";
                echo "<td class='tdcss'>" . $row->journey_date . "</td>";
                echo "<td class='tdcss'>" . $row->change_time . "</td>";
                echo "<td class='tdcss'>" . $row->ip_address . "</td>";
                echo "</tr>";
                $p++;
            }
            echo "</table>";
        } else if ($bustype == 'seatersleeper') {

            $this->db->select('*');
            $this->db->where('service_num', $sernum);
            $this->db->where('from_id', $from);
            $this->db->where('to_id', $to);
            $sql = $this->db->get('master_change_pricing');
            echo '<table width="680" id="tablecss" cellspacing="0" cellpadding="0">
                <tr class="trclass">
                <th class="thcss">Changed Seat fare</th>
                <th class="thcss">Changed lower berth fare</th>
                <th class="thcss">Changed upper berth fare</th>
                <th class="thcss">Journey date</th>
                <th class="thcss">Time</th>
                <th class="thcss">IP Address</th>
                </tr>';
            $p = 1;
            foreach ($sql->result() as $row) {
                echo '<tr>';
                echo "<td class='tdcss'>" . $row->new_seat_fare . "</td>";
                echo "<td class='tdcss'>" . $row->new_lberth_fare . "</td>";
                echo "<td class='tdcss'>" . $row->new_uberth_fare . "</td>";
                echo "<td class='tdcss'>" . $row->journey_date . "</td>";
                echo "<td class='tdcss'>" . $row->change_time . "</td>";
                echo "<td class='tdcss'>" . $row->ip_address . "</td>";
                echo "</tr>";
                $p++;
            }
            echo "</table>";
        }
    }

    /*     * *************************End of view changed price history******************** */
    /*     * ***************************Modify bus*************************************** */

    function displayServiceList() {

        $travel_id = $this->session->userdata('travel_id');
        $this->db->select('service_num');

        $this->db->where('travel_id', $travel_id);
        $this->db->where('status', 1);
        $query = $this->db->get('master_buses');
        $data = array();
        $data[0] = "------select------";

        foreach ($query->result() as $rows) {
            $data[$rows->service_num] = $rows->service_num;
        }
        return $data;
    }

    function getCity() {
        $srvno = $this->input->post('svrno');
        $this->db->select('city_name');

        $this->db->where('service_num', $srvno);
        $query = $this->db->get('boarding_points');
        $data = array();

        foreach ($query->result() as $rows) {
            $data[$rows->city_name] = $rows->city_name;
        }
        return $data;
    }

    function getAllCity() {

        $this->db->select('city_name');
        $query = $this->db->get('master_cities');
        $data = array();
        $data[0] = '-------select-------';
        foreach ($query->result() as $rows) {
            $data[$rows->city_name] = $rows->city_name;
        }
        return $data;
    }

    function vanpick() {
        $data = array();
        $data['no'] = 'no';
        $data['yes'] = 'yes';

        return $data;
    }

    public function modifyRequirements() {
        $srvno = $this->input->post('svrno');
        $travid = $this->input->post('opid');

        $sql1 = mysql_query("select distinct(from_id),from_name from master_buses where travel_id='$travid' and service_num='$srvno' order by from_name")or die(mysql_error());

        echo '<table width="100%" border="1" >
		 		 <tr>
    				<td width="19%" height="36" ><strong>City Name </strong></td>
				    <td width="34%" >
				    <strong>Board Point Name </strong></td>
				    <td width="25%" ><strong>Time</strong></td>
				    <td width="22%" ><strong>Landmark</strong></td>
				</tr>';

        $i = 0;
        while ($row = mysql_fetch_array($sql1)) {
            $from_id = $row['from_id'];
            $from_name = $row['from_name'];
            echo '<tr>
    				<td height="35"><strong>' . $from_name . '</strong></td>
    				';
            echo'<td colspan="3">
					<table width="100%" border="0">
					';
            $sql = mysql_query("select * from board_drop_points where city_id='$from_id' order by board_drop")or die(mysql_error());
//$sql=mysql_query("select * from board_drop_points where city_id='$fid1[$i]'")or die(mysql_error());
            $j = 0;
            while ($row = mysql_fetch_array($sql)) {
                $hours = $this->getHours1();
                $timehrST = 'id="timehrST' . $i . $j . '" ';
                $timenST = 'name="timehrST' . $i . $j . '" ';

                $hours1 = $this->getMinutes1();

                $timemiST = 'id="timemST' . $i . $j . '"';
                $timemnST = 'name="timemST' . $i . $j . '"';

                $tfidST = 'id="tfmST' . $i . $j . '" ';
                $tfnameST = 'name="tfm' . $i . $j . '" style="width:50px"';

                $tfv = array("AMPM" => "-select-", "AM" => "AM", "PM" => "PM");

                $board_drop = $row['board_drop'];
                $id = $row['id'];

                $sqlb = mysql_query("select * from boarding_points where bpdp_id='$id' and travel_id='$travid' and service_num='$srvno'  and board_or_drop_type='board'") or die(mysql_error());

                if (mysql_num_rows($sqlb) > 0) {

                    while ($row1 = mysql_fetch_array($sqlb)) {
                        $board = $row1['board_drop'];
                        $y = explode("#", $board);
                        $lm = $y[2];
//$z=explode(":",$y[1]);								
                        $tt = date("h:i A", strtotime($y[1]));
                        $tf = explode(" ", $tt);
                        $tft = explode(":", $tf[0]);
                        $hr = $tft[0];
                        $hr1 = $tft[1];
                    }
                } else {
                    $tf = '';
                    $hr = '';
                    $hr1 = '';
                    $lm = '';
                }
                echo '<tr>
        						<td width="42%" height="35"><strong>' . $board_drop . '</strong>
								<input type="hidden" name="cityname' . $i . $j . '" id="cityname' . $i . $j . '" value="' . $from_name . '">
								<input type="hidden" name="cityid' . $i . $j . '" id="cityid' . $i . $j . '" value="' . $from_id . '">
								<input type="hidden" name="bpname' . $i . $j . '" id="bpname' . $i . $j . '" value="' . $board_drop . '">
								<input type="hidden" name="bpid' . $i . $j . '" id="bpid' . $i . $j . '" value="' . $id . '">
								</td>
						        <td width="31%">
								' . form_dropdown($timenST, $hours, $hr, $timehrST) . '' . form_dropdown($timemnST, $hours1, $hr1, $timemiST) . '' . form_dropdown($tfnameST, $tfv, $tf[1], $tfidST) . '</td>
						        <td width="27%"><input type="text" name="lm' . $i . $j . '" id="lm' . $i . $j . '" value="' . $lm . '" /></td>
							      </tr>';
                $j++;
            }

            echo'</table><input type="hidden" name="jval' . $i . '" id="jval' . $i . '" value="' . $j . '"></td>    				
  				 </tr>';
            $i++;
        }
        echo '<tr>
		 		   <input type="hidden" name="nval" id="nval" value="' . $i . '">
				   <input type="hidden" name="sernum" id="sernum" value="' . $srvno . '">
		 		   <td height="36" colspan="4" align="center" ><input type="button" class="newsearchbtn" value="Save Boarding Poings" onClick="saveBoard()"></td>
		 		   </tr></table>';
    }

    function SaveModifytoDb() {
        $travid = $this->input->post('opid');        
        $sernum = $this->input->post('sernum');
        $city_name = $this->input->post('city_name');
        $city_id = $this->input->post('city_id');
        $board_point = $this->input->post('board_point');
        $bpid = $this->input->post('bpid');
        $lm = $this->input->post('lm');
        $hhST = $this->input->post('hhST');
        $mmST = $this->input->post('mmST');
        $ampmST = $this->input->post('ampmST');


        $city_names = explode("#", $city_name);
        $city_ids = explode("#", $city_id);
        $board_points = explode("#", $board_point);
        $hhSTs = explode("#", $hhST);
        $mmSTs = explode("#", $mmST);
        $ampmSTs = explode("#", $ampmST);
        $bpids = explode("#", $bpid);
        $lms = explode("#", $lm);
        $n = count($city_names);
        //echo "delete from boarding_points where service_num='$sernum' and board_or_drop_type='board' and travel_id='$travid'";
        $sql1 = mysql_query("delete from boarding_points where service_num='$sernum' and board_or_drop_type='board' and travel_id='$travid'") or die(mysql_error());

        for ($i = 0; $i < $n; $i++) {
            $arr_time1 = $hhSTs[$i] . ":" . $mmSTs[$i] . "" . $ampmSTs[$i];
            $d1 = date('H:i:s', strtotime($arr_time1));
            $bpname = $board_points[$i] . "#" . $d1 . "#" . $lms[$i];
            //echo "insert into boarding_points(service_num,travel_id,city_id,city_name,board_or_drop_type,board_drop,board_time,bpdp_id) values('$sernum','$travid','$city_ids[$i]','$city_names[$i]','board','$bpname','$d1','$bpids[$i]')";
            $sql = mysql_query("insert into boarding_points(service_num,travel_id,city_id,city_name,board_or_drop_type,board_drop,board_time,bpdp_id) values('$sernum','$travid','$city_ids[$i]','$city_names[$i]','board','$bpname','$d1','$bpids[$i]')")or die(mysql_error());

        }
        if ($sql) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function DeleteModifytoDb() {
        $srvno = $this->input->post('service_num');
        $travid = $this->session->userdata('travel_id');
        $del = $this->input->post('bp');
        $this->db->where('service_num', $srvno);
        $this->db->where('travel_id', $travid);
        $this->db->where('bpdp_id', $del);
        $query = $this->db->delete('boarding_points');
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function modify_Aminities() {
        $srvno = $this->input->post('svrno');
        $travid = $this->session->userdata('travel_id');

        $this->db->select('*');
        $this->db->where('service_num', $srvno);
        $this->db->where('travel_id', $travid);
        $query = $this->db->get('eminities');
        echo '<table align="center" >';
        foreach ($query->result() as $row) {
            $water = $row->water_bottle;
            $blanket = $row->blanket;
            $video = $row->video;
            $charging_point = $row->charging_point;
        }

        echo '
            <tr>
              <td></td>
              <td>&nbsp;</td>
              <td></td>
            </tr>
            <tr>
                  <td width="150"></td>
                 <td width="140"><input type="checkbox" name="ck" id="ck" value=' . $water . '><input type="hidden" name="val"  id="val" value=' . $water . '>water bottle</td>
                 <td width="100"></td>
                  </tr>
                  <tr>
                  <td></td>                  
                  </tr>
                  <tr>
                  <td width="150"></td>
                  <td width="140"><input type="checkbox" name="ck1" id="ck1" value=' . $blanket . ' ><input type="hidden" name="val1"  id="val1" value=' . $blanket . '>blanket</td>
				  <td width="100"></td>
                  </tr>
                  <tr>
                  <td></td>                  
                  </tr>
                  <tr>
                  <td width="150"></td>
                  <td width="140"><input type="checkbox" name="ck2" id="ck2" value=' . $video . '><input type="hidden" name="val2"  id="val2" value=' . $video . '>video</td>
				  <td width="100"></td>
                  </tr>
                  <tr>
                  <td></td>                  
                  </tr>
                  <tr>
                  <td width="150"></td>
                  <td width="140"><input type="checkbox" name="ck3" id="ck3" value=' . $charging_point . '><input type="hidden" name="val3"  id="val3" value=' . $charging_point . '>charging_point</td>
				  <td width="100"></td>
                  </tr>
                  
                  </table>
';
        echo '<table width="750">
                   <tr>
                   <td align="center"><input type="button" class="newsearchbtn" name="save" id="save" value="save" onClick="Saveaminities(\'' . $srvno . '\',' . $travid . ')" style="padding:5px 20px;"><td> ';
    }

    function modify_Aminitiesdb() {
        $srvno = $this->input->post('service_no');
        $travid = $this->input->post('travel_id');
        $arr = $this->input->post('tot');
        $s = explode("#", $arr);
        $this->db->set('water_bottle', $s[0]);
        $this->db->set('blanket', $s[1]);
        $this->db->set('video', $s[2]);
        $this->db->set('charging_point', $s[3]);
        $this->db->where('service_num', $srvno);
        $this->db->where('travel_id', $travid);
        $query = $this->db->update('eminities');
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function modify_Drop_point() {
        $srvno = $this->input->post('svrno');
        $travid = $this->input->post('opid');


        $sql1 = mysql_query("select distinct(to_id),to_name from master_buses where travel_id='$travid' and service_num='$srvno'")or die(mysql_error());
//echo "select distinct(from_id) from master_buses where travel_id='$travid' and service_num='$srvno'";
        echo '<table width="100%" border="1" >
		 		 <tr>
    <td width="19%" height="36" ><strong>City Name </strong></td>
    <td width="34%" >
    <strong>Drop Point Name </strong></td>
    <td  align="center"><strong>Time</strong></td>
	<td width="22%" ><strong>Landmark</strong></td>
  </tr>';
        $i = 0;
        while ($row = mysql_fetch_array($sql1)) {
            $to_id = $row['to_id'];
            $to_name = $row['to_name'];
            echo '<tr>
    				<td height="35"><strong>' . $to_name . '</strong></td>
    				';
            echo'<td colspan="3">
					<table width="100%" border="0">
					';
            $sql = mysql_query("select * from board_drop_points where city_id='$to_id'")or die(mysql_error());
            $j = 0;
            while ($row = mysql_fetch_array($sql)) {
                $hours = $this->getHours1();
                $timehrST = 'id="timehrST' . $i . $j . '" ';
                $timenST = 'name="timehrST' . $i . $j . '" ';

                $hours1 = $this->getMinutes1();

                $timemiST = 'id="timemST' . $i . $j . '"';
                $timemnST = 'name="timemST' . $i . $j . '"';

                $tfidST = 'id="tfmST' . $i . $j . '" ';
                $tfnameST = 'name="tfm' . $i . $j . '" style="width:50px"';

                $tfv = array("AMPM" => "-select-", "AM" => "AM", "PM" => "PM");
                $board_drop = $row['board_drop'];
                $id = $row['id'];
                $sqlb = mysql_query("select * from boarding_points where bpdp_id='$id' and travel_id='$travid' and service_num='$srvno' and board_or_drop_type='drop'") or die(mysql_error());

                if (mysql_num_rows($sqlb) > 0) {

                    while ($row1 = mysql_fetch_array($sqlb)) {
                        $board = $row1['board_drop'];
                        $y = explode("#", $board);
                        $lm = $y[2];
//$z=explode(":",$y[1]);								
                        $tt = date("h:i A", strtotime($y[1]));
                        $tf = explode(" ", $tt);
                        $tft = explode(":", $tf[0]);
                        $hr = $tft[0];
                        $hr1 = $tft[1];
                    }
                } else {
                    $tf = '';
                    $hr = '';
                    $hr1 = '';
                    $lm = '';
                }

                echo '<tr>
        						<td width="42%" height="35"><strong>' . $board_drop . '</strong>
								<input type="hidden" name="cityname' . $i . $j . '" id="cityname' . $i . $j . '" value="' . $to_name . '">
								<input type="hidden" name="cityid' . $i . $j . '" id="cityid' . $i . $j . '" value="' . $to_id . '">
								<input type="hidden" name="dpname' . $i . $j . '" id="dpname' . $i . $j . '" value="' . $board_drop . '">
								<input type="hidden" name="dpid' . $i . $j . '" id="dpid' . $i . $j . '" value="' . $id . '">
								</td>
						        <td width="31%" colspan="2">
								' . form_dropdown($timenST, $hours, $hr, $timehrST) . '' . form_dropdown($timemnST, $hours1, $hr1, $timemiST) . '' . form_dropdown($tfnameST, $tfv, $tf[1], $tfidST) . '</td>
								<td width="27%"><input type="text" name="lm' . $i . $j . '" id="lm' . $i . $j . '" value="' . $lm . '" /></td>
						        </tr>';
                $j++;
            }

            echo'</table><input type="hidden" name="jval' . $i . '" id="jval' . $i . '" value="' . $j . '"></td>    				
  				 </tr>';
            $i++;
        }
        echo '<tr>
		 		   <input type="hidden" name="nval" id="nval" value="' . $i . '">
				   <input type="hidden" name="sernum" id="sernum" value="' . $srvno . '">
		 		   <td height="36" colspan="4" align="center" ><input type="button" class="newsearchbtn" value="Save Drop Poings" onClick="saveDrop()"></td>
		 		   </tr></table>
';
    }

    public function SaveDPtoDb() {

        $travel_id = $this->input->post('opid');
        $sernum = $this->input->post('sernum');
        $city_name = $this->input->post('city_name');
        $city_id = $this->input->post('city_id');
        $board_point = $this->input->post('drop_point');
        $bpid = $this->input->post('dpid');
        $lm = $this->input->post('lm');
        $hhST = $this->input->post('hhST');
        $mmST = $this->input->post('mmST');
        $ampmST = $this->input->post('ampmST');

        $city_names = explode("#", $city_name);
        $city_ids = explode("#", $city_id);
        $board_points = explode("#", $board_point);
        $hhSTs = explode("#", $hhST);
        $mmSTs = explode("#", $mmST);
        $ampmSTs = explode("#", $ampmST);
        $bpids = explode("#", $bpid);
        $lms = explode("#", $lm);
        $n = count($city_names);

        $sql1 = mysql_query("delete from boarding_points where service_num='$sernum' and travel_id='$travel_id' and board_or_drop_type='drop'") or die(mysql_error());


        for ($i = 0; $i < $n; $i++) {
            $arr_time1 = $hhSTs[$i] . ":" . $mmSTs[$i] . "" . $ampmSTs[$i];
            $d1 = date('h:i A', strtotime($arr_time1));
            $bpname = $board_points[$i] . "#" . $d1 . "#" . $lms[$i];

            $sql = mysql_query("insert into boarding_points(service_num,travel_id,city_id,city_name,board_or_drop_type,board_drop,bpdp_id) values('$sernum','$travel_id','$city_ids[$i]','$city_names[$i]','drop','$bpname','$bpids[$i]')")or die(mysql_error());
        }
        if ($sql) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function modify_routes() {
        $srvno = $this->input->post('svrno');
        $travid = $this->input->post('opid');
        $this->db->select('*');
        $this->db->where('travel_id', $travid);
        $this->db->where('service_num', $srvno);
        $query = $this->db->get('master_buses');
        $num = $query->num_rows();
        foreach ($query->result() as $row) {
            $bus_type = $row->bus_type;
        }


        echo '<table border="0" id="routestb">
                       <tr>
                        <td class="space" height="30">&nbsp;</td>
                        <td class="space" height="30">From</td>
                        <td class="space" height="30">To</td>
                        <td class="space" height="30">Start Time</td>
                       
                        <td class="space" height="30">Arrival Time</td>';
        if ($bus_type == 'seater')
            echo '<td class="space" height="30">Seat price</td>';
        if ($bus_type == 'sleeper') {
            echo '<td class="space" height="30">Lower birth price</td>
                        <td class="space" height="30">Upper birth price</td>';
        }
        if ($bus_type == 'seatersleeper') {
            echo '<td class="space" height="30">Seat price</td>
                           <td class="space" height="30">Lower birth price</td>
                        <td class="space" height="30">Upper birth price</td>';
        }
        echo '</tr>';
        $i = 1;

        foreach ($query->result() as $row) {
            $serviceType = $row->serviceType;
            $service_route = $row->service_route;
            $service_name = $row->service_name;
            $from = $row->from_name;
            $to = $row->to_name;
            $fromid = $row->from_id;
            $toid = $row->to_id;
            $st_time = $row->start_time;
            $jtime = $row->journey_time;
            $arr_time = $row->arr_time;
            $seat_fare = $row->seat_fare;
            $lower_fare = $row->lberth_fare;
            $upper_fare = $row->uberth_fare;
            $bus_model = $row->model;
            $totseat = $row->seat_nos;
            $lowerseat = $row->lowerdeck_nos;
            $upperseat = $row->upperdeck_nos;
            $status = $row->status;
            $hours = $this->getHour();
// $timehr='id="timehr'.$i.'" onChange="arrtime('.$i.')"';
            $timehr = 'id="timehr' . $i . '" ';
            $timen = 'name="timehr' . $i . '" ';
            $hours1 = $this->getMinutes();
//$timemi='id="timem'.$i.'" onChange="arrtime('.$i.')"';
            $timemi = 'id="timem' . $i . '"';
            $timemn = 'name="timem' . $i . '"';
            $hoursa = $this->getHour();
// $timehrj='id="timehrj'.$i.'" onChange="arrtime('.$i.')"';
// $timehrj='id="timehrj'.$i.'"';

            $arrth = 'id="arrth' . $i . '"';
            $arrh1 = 'name="arrth' . $i . '" ';
            $arrtm = 'id="arrtm' . $i . '"';
            $arrtm1 = 'name="arrtm' . $i . '" ';
            $hoursa1 = $this->getMinutes();
// $timemij='id="timemj'.$i.'" onChange="arrtime('.$i.')"';
            $timemij = 'id="timemj' . $i . '"';
            $timemnj = 'name="timemj' . $i . '"';


            $x = explode(":", $st_time);
//  $h1=$x[0];
//  $m1=$x[1];
// $y=explode(":",$jtime);
            $y = explode(":", $arr_time);
            for ($j = 0; $j < count($y); $j++) {
                $y1 = substr($y[$j], 0, 2);
                $y2 = substr($y[$j], 2, 2);
            }


// $hr1=$y[0];
// $min1=$y[1];
//start time
            $t1 = $x[0] . ":" . $x[1];
            $tt1 = date("h:i A", strtotime($t1));
            $tf1 = explode(" ", $tt1);
            $tft1 = explode(":", $tf1[0]);
            $h1 = $tft1[0];
            $m1 = $tft1[1];
/// arr time
            $hr1 = $y[0];
            $min1 = $y1;
// echo $tf1[1];
// echo $hr1.":". $min1;
//time format
            $tfid = 'id="tfms' . $i . '" ';
            $tfname = 'name="tfms' . $i . '" ';
            $tfid1 = 'id="tfma' . $i . '" ';
            $tfname1 = 'name="tfma' . $i . '" ';
            $tfv = array("0" => "-select-", "AM" => "AM", "PM" => "PM");
///
            echo'<tr id="tr' . $i . '">
                             <td class="space" height="30"><input type="checkbox" name="ck' . $i . '" id="ck' . $i . '" value="' . $i . '"></td>
                             <td class="space" height="30"><input type="text" size="15" name="from' . $i . '" id="from' . $i . '" value="' . $from . '" readonly><input type="hidden" size="15" name="fromid' . $i . '" id="fromid' . $i . '" value="' . $fromid . '"><input type="hidden" size="15" name="bus" id="bus" value="' . $bus_type . '"><input type="hidden" size="15" name="sertype" id="sertype" value="' . $serviceType . '"></td>
                             <td class="space" height="30"><input type="text" size="15" name="to' . $i . '" id="to' . $i . '" value="' . $to . '" readonly><input type="hidden" size="15" name="toid' . $i . '" id="toid' . $i . '" value="' . $toid . '">
							 <input type="hidden" size="15" name="seroute" id="seroute" value="' . $service_route . '"> <input type="hidden" size="15" name="sername" id="sername" value="' . $service_name . '">
                                 <input type="hidden" size="15" name="busmodel" id="busmodel" value="' . $bus_model . '"><input type="hidden" size="15" name="tots" id="tots" value="' . $totseat . '"></td>
                             <td class="space" height="30">' . form_dropdown($timen, $hours, $h1, $timehr) . '' . form_dropdown($timemn, $hours1, $m1, $timemi) . '' . form_dropdown($tfname, $tfv, $tf1[1], $tfid) . '<input type="hidden" size="15" name="ls" id="ls" value="' . $lowerseat . '">
                              <input type="hidden" size="15" name="us" id="us" value="' . $upperseat . '"><input type="hidden" size="15" name="status" id="status" value="' . $status . '"></td>
                        <td class="space" height="30">' . form_dropdown($arrh1, $hoursa, $hr1, $arrth) . '' . form_dropdown($arrtm1, $hoursa1, $min1, $arrtm) . '' . form_dropdown($tfname1, $tfv, $y2, $tfid1) . '</td>';
            if ($bus_type == 'seater') {
                echo '<td class="space" height="30"><input type="text" size="8" name="seat_fare' . $i . '" id="seat_fare' . $i . '" value="' . $seat_fare . '"></td>';
            } else if ($bus_type == 'sleeper') {
                echo '<td class="space" height="30"><input type="text" size="8" name="lowerseat_fare' . $i . '" id="lowerseat_fare' . $i . '" value="' . $lower_fare . '"></td>
                                   <td class="space" height="30"><input type="text" size="8" name="upperseat_fare' . $i . '" id="upperseat_fare' . $i . '" value="' . $upper_fare . '"></td>';
            } else if ($bus_type == 'seatersleeper') {
                echo '<td class="space" height="30"><input type="text" size="8" name="seat_fare' . $i . '" id="seat_fare' . $i . '" value="' . $seat_fare . '"></td>
                                   <td class="space" height="30"><input type="text" size="8" name="lowerseat_fare' . $i . '" id="lowerseat_fare' . $i . '" value="' . $lower_fare . '"></td>
                                   <td class="space" height="30"><input type="text" size="8" name="upperseat_fare' . $i . '" id="upperseat_fare' . $i . '" value="' . $upper_fare . '"></td>';
            }
            echo '<td class="space" height="30"><span style="cursor:pointer; font-weight:bold; color:#81BEF7; text-decoration:underline;" onClick="DeleteRoutes(' . $i . ')">Delete</span></td>
                              </tr>';
            $i++;
        }
        $k = $i - 1;
        echo '</table>
                                <table width="83%">
                              <tr>
                                <td align="right">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td align="right">&nbsp;</td>
                              </tr>
                              <tr>
                              <td align="right"><input type="button" class="newsearchbtn" id="save" value="Save" onClick="saveRoutes(\'' . $srvno . '\',' . $travid . ',' . $i . ')" style="padding:5px 20px"></td><td>&nbsp;&nbsp;</td>    
                              <td align="right"><input type="hidden" value="' . $k . '" id="hidd" /><span style="cursor:pointer; font-weight:bold; text-decoration:underline;" onClick="addNewRoutes(\'' . $srvno . '\',' . $travid . ',' . $k . ',\'' . $bus_type . '\')">Add New Route</span></td>
                              </tr>';



        echo '<tr>
                                <td align="right">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td align="right">&nbsp;</td>
                              </tr>
							  </table>
 ';
    }

    function delete_routes() {
        $srvno = $this->input->post('svrno');
        $travid = $this->input->post('opid');
        $from = $this->input->post('fromid');
        $to = $this->input->post('toid');
        $del = array('master_buses', 'buses_list');
        $this->db->where('service_num', $srvno);
        $this->db->where('travel_id', $travid);
        $this->db->where('from_id', $from);
        $this->db->where('to_id', $to);
        $query = $this->db->delete($del);
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }

//<?php
    function save_routes_db() {
        $srvno = $this->input->post('service_no');
        $travid = $this->input->post('travel_id');
        $sertype = $this->input->post('sertype');
        $seroute = $this->input->post('seroute');
        $sername = $this->input->post('sername');
        $stime = $this->input->post('stime');
        //$jtime=$this->input->post('jtime');
        $seat = $this->input->post('seat');
        $lseat = $this->input->post('lseat');
        $useat = $this->input->post('useat');
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $ar = $this->input->post('art');
        $bus_type = $this->input->post('bus');
        $model = $this->input->post('model');
        $tseat = $this->input->post('tseat');
        $lseats = $this->input->post('lseats');
        $useats = $this->input->post('useats');
        $status = $this->input->post('status');
        
        
        $this->db->where("travel_id", $travid);
        $this->db->where("service_num", $srvno);
        $this->db->group_by('service_num');
        $trip_db = $this->db->get("master_buses");

        $strt1 = explode("!", $stime);
// $jout1=  explode("!",$jtime);
        $arr = explode("!", $ar);
        $fr = explode("!", $from);
        $too = explode("!", $to);

        if ($bus_type == 'seater') {
            $sfare = explode("!", $seat);
        } else {
            $sfare = "";
        }

        if ($bus_type == 'sleeper' || $bus_type == 'seatersleeper') {
            if ($bus_type == 'seatersleeper') {
                $sfare = explode("!", $seat);
                $lfare = explode("!", $lseat);
                $ufare = explode("!", $useat);
            } else {
                $sfare = "";
                $lfare = explode("!", $lseat);
                $ufare = explode("!", $useat);
            }
        } else {
            $lfare = "";
            $ufare = "";
        }

// print_r(ar1);

        for ($h = 0; $h < count($strt1); $h++) {
            $t1 = date("H:i:s", strtotime($strt1[$h]));
            $ta1 = date("H:i:", strtotime($arr[$h]));
//journey time calculation
            $start = explode(':', $t1);
            $end = explode(':', $ta1);

            if ($start[0] > $end[0]) {
                $end[0] += 24;
            }

            $jh = abs($end[0] - $start[0]);
            $jm = abs($end[1] - $start[1]);
            $js = abs($end[2] - $start[2]);

            if ($jm == '0')
                $jm = "00";
            if ($js == '0')
                $js = "00";

            if ($start[0] == $end[0]) {
                $jt = "24" . ":" . $jm . ":" . $js;
            } else {
                $jt = $jh . ":" . $jm . ":" . $js;
            }

//journey time calculation

            if ($h == 0) {
                $strt2 = $t1;
                $jout2 = $jt;
            } else {
                $strt2 = $strt2 . "!" . $t1;
                $jout2 = $jout2 . "!" . $jt;
            }
        }

        $strt = explode("!", $strt2);
        $jout = explode("!", $jout2);
// print_r($strt);

        for ($s = 0; $s < count($strt); $s++) {
            $seroute = $fr[$s] . " To " . $too[$s];

            $this->db->select('city_id');
            $this->db->where('city_name', $fr[$s]);
            $data1 = $this->db->get("master_cities");

            foreach ($data1->result() as $row) {
                $fromcity_id = $row->city_id;
            }

            $this->db->select('city_id');
            $this->db->where('city_name', $too[$s]);
            $data2 = $this->db->get("master_cities");

            foreach ($data2->result() as $row) {
                $tocity_id = $row->city_id;
            }
            $this->db->where("travel_id", $travid);
            $this->db->where("service_num", $srvno);
            $this->db->where("from_name", $fr[$s]);
            $this->db->where("to_name", $too[$s]);
            $query1 = $this->db->get("master_buses");

            $this->db->where("travel_id", $travid);
            $this->db->where("service_num", $srvno);
            $this->db->where("from_id", $fromcity_id);
            $this->db->where("to_id", $tocity_id);
            $this->db->where("journey_date is NULL", NULL);

            $ssql = $this->db->get("master_price");

            if ($query1->num_rows() > 0) {
                foreach ($trip_db->result() as $res) {
                    $trip_type = $res->trip_type;
                }
                $this->db->set('start_time', $strt[$s]);
                $this->db->set('journey_time', $jout[$s]);
                $this->db->set('arr_time', $arr[$s]);
                $this->db->set('seat_fare', $sfare[$s]);
                $this->db->set('lberth_fare', $lfare[$s]);
                $this->db->set('uberth_fare', $ufare[$s]);
                if ($trip_type == 'pkg') {
                    $this->db->set('trip_type', 'pkg');
                }
                $this->db->where("travel_id", $travid);
                $this->db->where("service_num", $srvno);
                $this->db->where("from_name", $fr[$s]);
                $this->db->where("to_name", $too[$s]);
                $query = $this->db->update('master_buses');

                if ($ssql->num_rows() > 0) {
                    $this->db->set('seat_fare', $sfare[$s]);
                    $this->db->set('lberth_fare', $lfare[$s]);
                    $this->db->set('uberth_fare', $ufare[$s]);
                    $this->db->set('seat_fare_changed', "");
                    $this->db->set('lberth_fare_changed', "");
                    $this->db->set('uberth_fare_changed', "");
                    $this->db->where("travel_id", $travid);
                    $this->db->where("service_num", $srvno);
                    $this->db->where("from_id", $fromcity_id);
                    $this->db->where("to_id", $tocity_id);
                    $this->db->where("journey_date is NULL", NULL);

                    $ssql1 = $this->db->update('master_price');
                } else {
                    $price = array(
                        'service_num' => $srvno,
                        'travel_id' => $travid,
                        'from_id' => $fromcity_id,
                        'from_name' => $fr[$s],
                        'to_id' => $tocity_id,
                        'to_name' => $too[$s],
                        'service_route' => $seroute,
                        'service_name' => $sername,
                        'seat_fare' => $sfare[$s],
                        'lberth_fare' => $lfare[$s],
                        'uberth_fare' => $ufare[$s],
                    );
                    $ssql2 = $this->db->insert('master_price', $price);
                }
            } else {
                foreach ($trip_db->result() as $result) {
                    $trip_type = $result->trip_type;
                }
                if ($trip_type == 'pkg') {
                    if ($bus_type == 'seater') {
                        $data = array(
                            'serviceType' => $sertype,
                            'service_num' => $srvno,
                            'travel_id' => $travid,
                            'from_id' => $fromcity_id,
                            'from_name' => $fr[$s],
                            'to_name' => $too[$s],
                            'to_id' => $tocity_id,
                            'start_time' => $strt[$s],
                            'journey_time' => $jout[$s],
                            'arr_time' => $arr[$s],
                            'seat_fare' => $sfare[$s],
                            'lberth_fare' => $lfare[$s],
                            'uberth_fare' => $ufare[$s],
                            'model' => $model,
                            'bus_type' => $bus_type,
                            'seat_nos' => $tseat,
                            'status' => $status,
                            'service_route' => $seroute,
                            'service_name' => $sername,
                            'trip_type' => 'pkg',
                        );
                    } else if ($bus_type == 'sleeper') {
                        $data = array(
                            'serviceType' => $sertype,
                            'service_num' => $srvno,
                            'travel_id' => $travid,
                            'from_id' => $fromcity_id,
                            'from_name' => $fr[$s],
                            'to_id' => $tocity_id,
                            'to_name' => $too[$s],
                            'start_time' => $strt[$s],
                            'journey_time' => $jout[$s],
                            'arr_time' => $arr[$s],
                            'seat_fare' => $sfare[$s],
                            'lberth_fare' => $lfare[$s],
                            'uberth_fare' => $ufare[$s],
                            'model' => $model,
                            'bus_type' => $bus_type,
                            'lowerdeck_nos' => $lseats,
                            'upperdeck_nos' => $useats,
                            'status' => $status,
                            'service_route' => $seroute,
                            'service_name' => $sername,
                            'trip_type' => 'pkg',
                        );
                    } else if ($bus_type == 'seatersleeper') {
                        $data = array(
                            'serviceType' => $sertype,
                            'service_num' => $srvno,
                            'travel_id' => $travid,
                            'from_id' => $fromcity_id,
                            'from_name' => $fr[$s],
                            'to_id' => $tocity_id,
                            'to_name' => $too[$s],
                            'start_time' => $strt[$s],
                            'journey_time' => $jout[$s],
                            'arr_time' => $arr[$s],
                            'seat_fare' => $sfare[$s],
                            'lberth_fare' => $lfare[$s],
                            'uberth_fare' => $ufare[$s],
                            'model' => $model,
                            'bus_type' => $bus_type,
                            'seat_nos' => $tseat,
                            'lowerdeck_nos' => $lseats,
                            'upperdeck_nos' => $useats,
                            'status' => $status,
                            'service_route' => $seroute,
                            'service_name' => $sername,
                            'trip_type' => 'pkg',
                        );
                    }
                } else {
                    if ($bus_type == 'seater') {
                        $data = array(
                            'serviceType' => $sertype,
                            'service_num' => $srvno,
                            'travel_id' => $travid,
                            'from_id' => $fromcity_id,
                            'from_name' => $fr[$s],
                            'to_name' => $too[$s],
                            'to_id' => $tocity_id,
                            'start_time' => $strt[$s],
                            'journey_time' => $jout[$s],
                            'arr_time' => $arr[$s],
                            'seat_fare' => $sfare[$s],
                            'lberth_fare' => $lfare[$s],
                            'uberth_fare' => $ufare[$s],
                            'model' => $model,
                            'bus_type' => $bus_type,
                            'seat_nos' => $tseat,
                            'status' => $status,
                            'service_route' => $seroute,
                            'service_name' => $sername,
                        );
                    } else if ($bus_type == 'sleeper') {
                        $data = array(
                            'serviceType' => $sertype,
                            'service_num' => $srvno,
                            'travel_id' => $travid,
                            'from_id' => $fromcity_id,
                            'from_name' => $fr[$s],
                            'to_id' => $tocity_id,
                            'to_name' => $too[$s],
                            'start_time' => $strt[$s],
                            'journey_time' => $jout[$s],
                            'arr_time' => $arr[$s],
                            'seat_fare' => $sfare[$s],
                            'lberth_fare' => $lfare[$s],
                            'uberth_fare' => $ufare[$s],
                            'model' => $model,
                            'bus_type' => $bus_type,
                            'lowerdeck_nos' => $lseats,
                            'upperdeck_nos' => $useats,
                            'status' => $status,
                            'service_route' => $seroute,
                            'service_name' => $sername,
                        );
                    } else if ($bus_type == 'seatersleeper') {
                        $data = array(
                            'serviceType' => $sertype,
                            'service_num' => $srvno,
                            'travel_id' => $travid,
                            'from_id' => $fromcity_id,
                            'from_name' => $fr[$s],
                            'to_id' => $tocity_id,
                            'to_name' => $too[$s],
                            'start_time' => $strt[$s],
                            'journey_time' => $jout[$s],
                            'arr_time' => $arr[$s],
                            'seat_fare' => $sfare[$s],
                            'lberth_fare' => $lfare[$s],
                            'uberth_fare' => $ufare[$s],
                            'model' => $model,
                            'bus_type' => $bus_type,
                            'seat_nos' => $tseat,
                            'lowerdeck_nos' => $lseats,
                            'upperdeck_nos' => $useats,
                            'status' => $status,
                            'service_route' => $seroute,
                            'service_name' => $sername,
                        );
                    }
                }

                if ($status == 0) {
                    $query = $this->db->insert('master_buses', $data);
                } else {
                    $query = $this->db->insert('master_buses', $data);
                    $curdate = date("Y-m-d");
                    $this->db->select_min('journey_date');
                    $this->db->where('service_num', $srvno);
                    $this->db->where('travel_id', $travid);
                    $data3 = $this->db->get('buses_list');

                    foreach ($data3->result() as $row) {
                        $stdate2 = $row->journey_date;
                    }

                    $this->db->select_max('journey_date');
                    $this->db->where('service_num', $srvno);
                    $this->db->where('travel_id', $travid);
                    $data2 = $this->db->get('buses_list');

                    foreach ($data2->result() as $row) {
                        $todate = $row->journey_date;
                    }

                    if ($stdate2 > $curdate) {
                        $stdate = $stdate2;
                    } else {
                        $stdate = $curdate;
                    }

                    while ($stdate <= $todate) {
                        if ($bus_type == 'seater') {
                            $dataq = array(
                                'service_num' => $srvno,
                                'from_id' => $fromcity_id,
                                'to_id' => $tocity_id,
                                'travel_id' => $travid,
                                'status' => 1,
                                'journey_date' => $stdate,
                                'seat_fare' => $sfare[$s],
                            );
                            $price = array(
                                'service_num' => $srvno,
                                'travel_id' => $travid,
                                'from_id' => $fromcity_id,
                                'from_name' => $fr[$s],
                                'to_id' => $tocity_id,
                                'to_name' => $too[$s],
                                'service_route' => $seroute,
                                'service_name' => $sername,
                                'seat_fare' => $sfare[$s],
                                'lberth_fare' => $lfare[$s],
                                'uberth_fare' => $ufare[$s],
                            );
                        } else if ($bus_type == 'sleeper') {
                            $dataq = array(
                                'service_num' => $srvno,
                                'from_id' => $fromcity_id,
                                'to_id' => $tocity_id,
                                'travel_id' => $travid,
                                'status' => 1,
                                'journey_date' => $stdate,
                                'lberth_fare' => $lfare[$s],
                                'uberth_fare' => $ufare[$s],
                            );
                            $price = array(
                                'service_num' => $srvno,
                                'travel_id' => $travid,
                                'from_id' => $fromcity_id,
                                'from_name' => $fr[$s],
                                'to_id' => $tocity_id,
                                'to_name' => $too[$s],
                                'service_route' => $seroute,
                                'service_name' => $sername,
                                'seat_fare' => $sfare[$s],
                                'lberth_fare' => $lfare[$s],
                                'uberth_fare' => $ufare[$s],
                            );
                        } else if ($bus_type == 'seatersleeper') {
                            $dataq = array(
                                'service_num' => $srvno,
                                'from_id' => $fromcity_id,
                                'to_id' => $tocity_id,
                                'travel_id' => $travid,
                                'status' => 1,
                                'journey_date' => $stdate,
                                'seat_fare' => $sfare[$s],
                                'lberth_fare' => $lfare[$s],
                                'uberth_fare' => $ufare[$s],
                            );
                            $price = array(
                                'service_num' => $srvno,
                                'travel_id' => $travid,
                                'from_id' => $fromcity_id,
                                'from_name' => $fr[$s],
                                'to_id' => $tocity_id,
                                'to_name' => $too[$s],
                                'service_route' => $seroute,
                                'service_name' => $sername,
                                'seat_fare' => $sfare[$s],
                                'lberth_fare' => $lfare[$s],
                                'uberth_fare' => $ufare[$s],
                            );
                        }

                        $query = $this->db->insert('buses_list', $dataq);
                        $ssql2 = $this->db->insert('master_price', $price);
                        $date = strtotime("+1 day", strtotime($stdate));
                        $stdate = date("Y-m-d", $date);
                    }
                }
            }
        }

        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function modify_seatname() {
        $service = $this->input->post('srvno');
        $travel_id = $this->session->userdata('travel_id');

        $this->db->select('*');
        $this->db->where('service_num', $service);
        $this->db->where('travel_id', $travel_id);
        $this->db->where('status', 1);
        $query = $this->db->get('master_layouts');
        foreach ($query->result() as $r) {
            $layout_id = $r->layout_id;
            $seat_name = $r->seat_name;
            $lid = explode("#", $layout_id);
        }
        if ($lid[1] == 'seater') {
//getting max of row and col from mas_layouts
            $this->db->select_max('row', 'mrow');
            $this->db->select_max('col', 'mcol');
            $this->db->where('service_num', $service);
            $this->db->where('travel_id', $travel_id);
            $sq11 = $this->db->get('master_layouts');
            $seat_name = '';
            foreach ($sq11->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }
            echo "<table border='1' cellpadding='0' align='center' width='83%' >";
            for ($i = 1; $i <= $mcol; $i++) {
                echo "<tr>";
                for ($j = 1; $j <= $mrow; $j++) {
                    $this->db->select('*');
                    $this->db->where('row', $j);
                    $this->db->where('col', $i);
                    $this->db->where('service_num', $service);
                    $this->db->where('travel_id', $travel_id);
                    $sql3 = $this->db->get('master_layouts');

                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $seat_type = $row2->seat_type;
                    }
                    if ($seat_name == '') {
                        echo "<td style=' border:none;'align='center' class='space'>&nbsp;</td>";
                    } else {
                        echo "<td style='background-color: #E4E4E4;'><input type='checkbox' name='c$i$j-$seat_name' id='c$i$j-$seat_name' value='$i$j-$seat_name' onclick='enabledit(this.value)'/><input type='text' size='1' name='seat$i$j-$seat_name' id='seat$i$j-$seat_name' value='$seat_name' disabled><input type='hidden' name='hid$i$j-$seat_name' id='hid$i$j-$seat_name' value=$seat_name></td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo '</table>';
            echo '<table width="83%" >
                  <tr>
                    <td align="center">&nbsp;</td>
                  </tr>
                  <tr>
                        <td align="center">
                          <input type="button" class="newsearchbtn" name="updt" id="updt" value="Save Changes" onClick="seatUpdate(\'' . $service . '\',' . $travel_id . ')" style="padding:5px 40px;"></td>
                      </tr>
                  <tr>
                    <td align="center">&nbsp;</td>
                  </tr>
                      </table>
                ';
            ;
        } else if ($lid[1] == 'sleeper') {
            $this->db->select_max('row', 'mrow');
            $this->db->select_max('col', 'mcol');
            $this->db->where('service_num', $service);
            $this->db->where('travel_id', $travel_id);
            $this->db->where('seat_type', 'U');
            $sq = $this->db->get('master_layouts');
            foreach ($sq->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }
            echo "<input type='hidden' name='mrow' id='mrow' value='$mrow' />
                    <input type='hidden' name='mcol' id='mcol' value='$mcol' />";

            echo "<table border='1' cellpadding='0' align='center' >";

            for ($i = 1; $i <= $mcol; $i++) {
                echo "<tr>";
                for ($j = 1; $j <= $mrow; $j++) {
                    $this->db->select("*");
                    $this->db->where('row', $j);
                    $this->db->where('col', $i);
                    $this->db->where('service_num', $service);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where('seat_type', 'U');
                    $sql3 = $this->db->get('master_layouts');
                    $sql3->result();
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                    }
                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else {
                        echo "<td style='background-color: #E4E4E4;'><input type='checkbox' name='c$i$j-$seat_name' id='c$i$j-$seat_name' value='$i$j-$seat_name' onclick='enabledit(this.value)'/><input type='text' size='1' name='seat$i$j-$seat_name' id='seat$i$j-$seat_name' value='$seat_name' disabled><input type='hidden' name='hid$i$j-$seat_name' id='hid$i$j-$seat_name' value=$seat_name></td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo "</table><br />";

            $this->db->select_max('row', 'mroww');
            $this->db->select_max('col', 'mcoll');
            $this->db->where('service_num', $service);
            $this->db->where('travel_id', $travel_id);
            $this->db->where('seat_type', 'L');
            $sq1 = $this->db->get('master_layouts');
            foreach ($sq1->result() as $row1) {
                $mroww = $row1->mroww;
                $mcoll = $row1->mcoll;
            }
            echo "<input type='hidden' name='mrow' id='mrow' value='$mrow' />
                            <input type='hidden' name='mcol' id='mcol' value='$mcol' />";

            echo "<table border='1' cellpadding='0' align='center' >";

            for ($i = 1; $i <= $mcoll; $i++) {
                echo "<tr>";
                for ($j = 1; $j <= $mroww; $j++) {
                    $this->db->select("*");
                    $this->db->where('row', $j);
                    $this->db->where('col', $i);
                    $this->db->where('service_num', $service);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where('seat_type', 'L');
                    $sql3 = $this->db->get('master_layouts');
                    $sql3->result();
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                    }
                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else {
                        echo "<td style='background-color: #E4E4E4;'><input type='checkbox' name='c$i$j-$seat_name' id='c$i$j-$seat_name' value='$i$j-$seat_name' onclick='enabledit(this.value)'/><input type='text' size='1' name='seat$i$j-$seat_name' id='seat$i$j-$seat_name' value='$seat_name' disabled><input type='hidden' name='hid$i$j-$seat_name' id='hid$i$j-$seat_name' value=$seat_name></td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo "</table>";

            echo '<table width="100%"><tr>
                        <td align="center">
                          <input type="button" class="newsearchbtn" name="updt" id="updt" value="Save Changes" onClick="seatUpdate(\'' . $service . '\',' . $travel_id . ')"></td>
                      </tr>
                      </table>';
        } else if ($lid[1] == 'seatersleeper') {
//UpperDeck
            $this->db->select_max('row', 'mrow');
            $this->db->select_max('col', 'mcol');
            $this->db->where('service_num', $service);
            $this->db->where('travel_id', $travel_id);
            $this->db->where('seat_type', 'U');
            $this->db->or_where('seat_type', 'U');
            $sqll = $this->db->get('master_layouts');

            foreach ($sqll->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }
            echo "<span style='font-size:12px; font-weight:bold;'>UpperDeck</span> <br/>";
            echo "<table border='1' cellpadding='0'>";
            for ($k = 1; $k <= $mcol; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mrow; $l++) {
                    $this->db->select('*');
                    $this->db->where('row', $l);
                    $this->db->where('col', $k);
                    $this->db->where('service_num', $service);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where('seat_type', 'U');
                    $this->db->or_where('seat_type', 'U');
                    $sql3 = $this->db->get('master_layouts');

                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $seat_type = $row2->seat_type;
                    }
                    if ($seat_type == 'U')
                        $st = "(B)";
                    else if ($seat_type == 'U')
                        $st = "(S)";


                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else {
                        echo "<td style='background-color: #E4E4E4;'><input type='checkbox' name='c$i$j-$seat_name' id='c$i$j-$seat_name' value='$i$j-$seat_name' onclick='enabledit(this.value)'/><input type='text' size='1' name='seat$i$j-$seat_name' id='seat$i$j-$seat_name' value='$seat_name' disabled><input type='hidden' name='hid$i$j-$seat_name' id='hid$i$j-$seat_name' value=$seat_name></td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo "</table><br/><br/>";


// Lower Deck


            $this->db->select_max('row', 'mroww');
            $this->db->select_max('col', 'mcoll');
            $this->db->where('service_num', $service);
            $this->db->where('travel_id', $travel_id);
            $this->db->where('seat_type', 'L:b');
            $this->db->or_where('seat_type', 'L:s');
            $sql3 = $this->db->get('master_layouts');
            foreach ($sql3->result() as $roww) {
                $mroww = $roww->mroww;
                $mcoll = $roww->mcoll;
            }

            echo "<span style='font-size:12px; font-weight:bold;'>LowerDeck</span><br/>";
            echo "<table border='1' cellpadding='0'>";
            for ($k = 1; $k <= $mcoll; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mroww; $l++) {
                    $this->db->select('*');
                    $this->db->where('row', $l);
                    $this->db->where('col', $k);
                    $this->db->where('service_num', $service);
                    $this->db->where('travel_id', $travel_id);
                    $this->db->where('seat_type', 'L:b');
                    $this->db->or_where('seat_type', 'L:s');
                    $sql3 = $this->db->get('master_layouts');
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $seat_type = $row2->seat_type;
                    }
                    if ($seat_type == 'L:b')
                        $st = "(B)";
                    else if ($seat_type == 'L:s')
                        $st = "(S)";
                    if ($seat_name == '') {
                        echo "<td style='border:none;' align='center'>&nbsp;</td>";
                    } else {
                        echo "<td style='background-color: #E4E4E4;'><input type='checkbox' name='c$i$j-$seat_name' id='c$i$j-$seat_name' value='$i$j-$seat_name' onclick='enabledit(this.value)'/><input type='text' size='1' name='seat$i$j-$seat_name' id='seat$i$j-$seat_name' value='$seat_name' disabled><input type='hidden' name='hid$i$j-$seat_name' id='hid$i$j-$seat_name' value=$seat_name></td>";
                    }
                    $seat_name = '';
                }
                echo "</tr>";
            }
            echo "</table>";
            echo '<table width="100%"><tr>
                       <td align="center">
                       <input type="button" class="newsearchbtn" name="updt" id="updt" value="Save Changes" onClick="seatUpdate(\'' . $service . '\',' . $travel_id . ')"></td>
                      </tr>
                      </table>';
        }
    }

    function save_seatnamedb() {

        $srvno = $this->input->post('srvno');
        $travid = $this->input->post('travid');
        $sname = $this->input->post('sname');
        $nseat = $this->input->post('nseat');
        $oseat = explode("#", $sname);
        $new = explode("#", $nseat);
        for ($i = 0; $i < count($new); $i++) {

            $this->db->set('t1.seat_name', $new[$i]);
            $this->db->where('t1.seat_name', $oseat[$i]);
            $this->db->where('t1.service_num', $srvno);
            $this->db->where('t1.travel_id', $travid);
            $this->db->set('t2.seat_name', $new[$i]);
            $this->db->where('t2.seat_name', $oseat[$i]);
            $this->db->where('t2.service_num', $srvno);
            $this->db->where('t2.travel_id', $travid);
            $query = $this->db->update('master_layouts as t1,layout_list as t2');
        }

        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }

//cancellation agent list 


    function displayServiceRecords_View() {
        $travid = $this->session->userdata('travel_id');
        $newtDate = $this->input->post('date_from');
        $ex1 = explode("/", $newtDate);
        $date = $ex1[2] . "-" . $ex1[1] . "-" . $ex1[0];
        $query1 = $this->db->query("select distinct  agent_id from master_booking where travel_id='$travid' and jdate='$date' and is_buscancel='yes' and (status='cancelled' || status='Cancelled')");
        if ($query1->num_rows() > 0) {
            echo '<table  align="center" id="tbl" style="border:#f2f2f2 solid 0px; border-collapse:collapse; width=70%   ">
 
<tr style="font-size:13px; color:#ffffff; background:#84a3b8;">
<td><input type="checkbox" id="selectck" name="selectck" onClick="selectAll()"></td>
<td width="108" height="21" style="font-size:14px;border:#f2f2f2 solid 1px;"><b >Agent Name</b></td>
<td width="106" style="font-size:14px;border:#f2f2f2 solid 1px;"><b >Payment Type</b></td>
<td width="119" style="font-size:14px;border:#f2f2f2 solid 1px;"><b >Cancelled Seats</b></td>
<td width="115" style="font-size:14px;border:#f2f2f2 solid 1px;"><b >Cancelled Fare</b></td>
<td width="115" style="font-size:14px;border:#f2f2f2 solid 1px;"><b >Refund</b></td>
</tr>';

            foreach ($query1->result() as $value) {
                $agentid = $value->agent_id;
            }

            $query4 = $this->db->query("select sum( pass) as seat,sum(camt) as canfare,sum(paid) 
      as refund from master_booking where travel_id='$travid' and 
          (status='cancelled' || status='Cancelled') and jdate='$date' and agent_id='$agentid'");
// print_r($query4->result());
            $this->db->where('operator_id', $travid);
            $this->db->where('id', $agentid);
            $query2 = $this->db->get('agents_operator');
//checking refunded or not in master_pass_reports

            $query5 = $this->db->query("select * from master_pass_reports where 
            travel_id='$travid' and  status='cancelled' and agent_id='$agentid' and jdate='$date'");
//end checking refunded or not     
            foreach ($query2->result() as $val) {
                $agentname = $val->name;
                $pay_type = $val->pay_type;

                foreach ($query4->result() as $row) {
//$class = ($i%2 == 0)? 'bg': 'bg1';    
                    echo '<tr class="' . $class . '">
<td style="font-size:14px;border:#f2f2f2 solid 1px;">
<input type="checkbox" id="chk' . $i . '" class="chkbox" name="chk' . $i . '" value="' . $agentid . '"></td>
<td width="108"  align="center" style="font-size:14px;border:#f2f2f2 solid 1px;">' . $agentname . '</td>
    <td width="108"  align="center" style="font-size:14px;border:#f2f2f2 solid 1px;">' . $pay_type . '</td>
<td width="106" align="center" style="font-size:14px;border:#f2f2f2 solid 1px;">' . $row->seat . ' </td>
<td width="119" align="center" style="font-size:14px;border:#f2f2f2 solid 1px;">' . $row->canfare . '</td>
    <td width="115" align="center" style="font-size:14px;border:#f2f2f2 solid 1px;">
    <input type="text" value="' . $row->refund . '" size="12"></td><td><table border=0><tr>';
                    if ($query5->num_rows() > 0) {
                        echo '<td style="color:red;">Already Refunded</td>';
                    } else {
                        echo '<td style="">&nbsp;</td>';
                    }
                    echo '</tr></table></td></tr>';
                }
            }


            echo '</table>';
            echo '<table align="center"><tr><td>
      <input type="button" class="newsearchbtn" value="Submit" onClick="Servicecancelrefund()"></td></tr></table>';
        } else
            echo 0;
    }

//for updating refund in agent balance and updating data in master_pass_reports
    function Servicecancel_Records_update_in_db() {
        $travid = $this->session->userdata('travel_id');
//$srvno=$this->input->post('service');
        $agentid = $this->input->post('tot1');
        $newtDate = $this->input->post('dat');
        $ex11 = explode("/", $newtDate);
        $dat = $ex11[2] . "-" . $ex11[1] . "-" . $ex11[0];
        $ex = explode(",", $agentid);
        $n = count($ex);
        $ip = $this->input->ip_address();
        $curdate = date("Y-m-d");
        $cdate = date("YmdHis");
        $ctime = date("His");
        for ($y = 0; $y < $n; $y++) {
            $query = $this->db->query("select * from master_booking where 
           jdate= '" . $dat . "' and travel_id='$travid' 
           and  LOWER(status)='cancelled' and agent_id='$ex[$y]'");
            $query2 = $this->db->query("select sum(refamt) as refund from master_booking where 
           jdate= '" . $dat . "' and travel_id='$travid' 
              and  (status='cancelled' || status='Cancelled') and agent_id='$ex[$y]'");
            print_r($query->result());
            $query3 = $this->db->query("select * from agents_operator where 
            operator_id='$travid' and status='1'  and  id='$ex[$y]'");
            foreach ($query2->result() as $val) {
                $refund = $val->refund;
            }
            if ($refund == '')
                $refund = 0;
            foreach ($query3->result() as $valu) {
                $balance1 = $valu->balance;
            }
            if ($balance1 == '')
                $balance1 = 0;
            $balance = $balance1 + $refund;
//echo $balance1."/".$refund;
            $data3 = array('balance' => $balance);
            $this->db->set($data3);
            $this->db->where('id', $ex[$y]);
            $this->db->where('operator_id', $travid);
            $up = $this->db->update('agents_operator', $data3);

            foreach ($query->result() as $vala) {
                $paid = $vala->refamt;
                $camt = $vala->camt;
                $tkt_no = $vala->tkt_no;
                $pnr = $vala->pnr;
                $pname = $vala->pname;
                $source = $vala->source;
                $dest = $vala->dest;
                $tkt_fare = $vala->tkt_fare;
                $save = $vala->save;
            }
            $in = $this->db->query("insert into  master_pass_reports(tktno,pnr,pass_name,source,destination,date,transtype,tkt_fare
           ,comm,can_fare,refamt,net_amt,bal,txn_id,dat,ip,agent_id,travel_id,status,jdate) 
           values('" . $tkt_no . "','" . $pnr . "','" . $pname . "','" . $source . "',
               '" . $dest . "','" . $curdate . "','Credit','" . $tkt_fare . "',
                   '" . $save . "','" . $camt . "','" . $paid . "','" . $paid . "','" . $balance . "',
                       '" . $cdate . "','" . $ctime . "','" . $ip . "','" . $ex[$y] . "','" . $travid . "','cancelled','" . $dat . "')");
        }

        if ($up && $in)
            echo 1;
        else
            echo 0;
    }

// end for updating refund in agent balance      


    public function modify_model1() {
        $service_num = $this->input->post('srvno');
        $travel_id = $this->session->userdata('travel_id');
        $this->db->distinct();
        $this->db->select("model");
        $this->db->where("service_num", "$service_num");
        $this->db->where("travel_id", "$travel_id");
        $query = $this->db->get("master_buses");

        foreach ($query->result() as $rows) {
            echo'<span style="margin-left:150px;">Update Model : </span><input type="text" name="model" id="model" value="' . $rows->model . '" style="margin-left:50px;margin-right:50px;" size="30" /><input type="button" class="newsearchbtn" name="modify" id="modify" value="Update" onClick="updatemodel()" />';
        }
    }

//close busmodel()

    public function updatemodel1() {
        $service_num = $this->input->post('service_num');
        $model = $this->input->post('model');
        $travel_id = $this->session->userdata('travel_id');

        $query = $this->db->query("update master_buses set model='$model' where service_num='$service_num' and travel_id='$travel_id'");
        $query1 = $this->db->query("update master_booking set bus_model='$model' where service_no='$service_num' and travel_id='$travel_id'");

        if ($query && $query1) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function service_tax1() {
        $service_num = $this->input->post('srvno');
        $travel_id = $this->input->post('opid');
        $this->db->distinct();
        $this->db->select("service_tax");
        $this->db->where("service_num", "$service_num");
        $this->db->where("travel_id", "$travel_id");
        $query = $this->db->get("master_buses");

        foreach ($query->result() as $rows) {
            $service_tax = $rows->service_tax;
        }
        echo'<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="30%" align="right"><span>Update Service </span></td>
    <td width="27%" align="center"><input type="text" name="service_tax" id="service_tax" value="' . $service_tax . '"/></td>
    <td width="34%" align="center"><span style="color:#FF0000">Example: 3.99 or 4</span></td>
    <td width="9%"><input type="button" class="newsearchbtn" name="modify2" id="modify2" value="Update" onClick="updateTax()" /></td>
  </tr>
</table>';
    }

    public function updateTax1() {
        $service_num = $this->input->post('service_num');
        $service_tax = $this->input->post('service_tax');
        $travel_id = $this->input->post('operators');

        $query = $this->db->query("update master_buses set service_tax='$service_tax' where service_num='$service_num' and travel_id='$travel_id'");
        //echo "update master_buses set service_tax='$service_tax' where service_num='$service_num' and travel_id='$travel_id'";

        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function getservic_modify() {

        $travel_id = $this->input->post('opid');
        $this->db->distinct();
        $this->db->select('service_num');
        $this->db->where('travel_id', $travel_id);
        //$this->db->where('status', 1);
        $query = $this->db->get('master_buses');
        $list = '<option value="0">---Select---</option>';
        foreach ($query->result() as $rows) {
            $list = $list . '<option value="' . $rows->service_num . '">' . $rows->service_num . '</option>';
        }
        return $list;
    }

}
