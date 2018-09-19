<?php

if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Createbus extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('cookie');
        $this->load->helper('url');
        $this->load->model('createbus_model');
        $this->load->model('modellogin');
    }

    //it will call when operator click on create bus link on view
    public function createbus_types() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(get_cookie('website_url'));
        } else {
            $this->load->view('header_view.php');
            $this->load->view('sidebar_view.php');
            $this->load->view('bus/createbus_home_view.php');
        }
    }

    //method for manual bus creation
    public function manualBC() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(get_cookie('website_url'));
        } else {
            $result1['key'] = "35";
            $result1['key1'] = "3";
            $this->load->view('header_view.php');
            $this->load->view('sidebar_view.php', $result1);
            $data['busmodel'] = $this->createbus_model->busmodel();
            $data['bustypes'] = $this->createbus_model->bustypes();
            $data['sarr'] = $this->createbus_model->seats_arrangement();
            $this->load->view('bus/manual_createbus1_view.php', $data);
            $this->load->view('footer_view.php');
        }
    }

    //method for upload xl for bus creation
    public function uploadBC() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(get_cookie('website_url'));
        } else {
            $this->load->view('header_view.php');
            $this->load->view('sidebar_view.php');
            $this->load->view('bus/upload_createbus1_view.php');
        }
    }

    /* method for dispaying the layout */

    public function setLayout() {
        $btype = $this->input->post('btype');
        $nos = $this->input->post('nos');
        $sarr = $this->input->post('sarr');
        $dc1 = $this->input->post('dc1');
        $dc2 = $this->input->post('dc2');
        $this->createbus_model->setLayoutModel($btype, $nos, $sarr, $dc1, $dc2);
    }

//closing the setLayout()

    public function saveLayout() {
        $svc = $this->input->post('svc');
        $btype = $this->input->post('btype');
        $sarr = $this->input->post('sarr');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $start1 = $this->input->post('start1');
        $end1 = $this->input->post('end1');
        $s = $this->input->post('s');
        $s1 = $this->input->post('s1');
        $result = $this->createbus_model->saveLayoutDb($svc, $btype, $sarr, $start, $end, $start1, $end1, $s, $s1);
        if ($result == 1)
            echo 1;
        else if ($result == 2)
            echo 2;
        else
            echo 0;
    }

    public function getNoOfRoutes() {
        $nstops = $this->input->post('nstops');
        $btype = $this->input->post('btype');
        $getroutes = $this->createbus_model->getroutes();
        if ($btype == 'seater') {//if bus type is seater
            $th = '<td width="114">Seat Price </td>';
        } else if ($btype == 'sleeper') {//if bus type is sleeper
            $th = '<td width="114">Lower Birth Price </td><td width="114">Upper Birth Price </td>';
        } else {
            $th = '<td width="114">Seat Price </td><td width="114">Lower Birth Price </td><td width="114">Upper Birth Price </td>';
        }
        echo '<table width="637" border="0">
          <tr>
            <td width="101"> From </td>
            <td width="101">To</td>
            <td width="101">Start Time </td>
            <td width="101">Journey Time </td>
            <td width="93">Arrival Time</td>
            ' . $th . '
          </tr>';
        for ($i = 1; $i <= $nstops; $i++) {
            //first list box properties i.e from
            $id = 'id="from' . $i . '" style="width:150px; font-size:12px"';
            $name = 'name="from' . $i . '"';
            //second list box properties i.e to
            $id2 = 'id="to' . $i . '" style="width:150px; font-size:12px"';
            $name2 = 'name="to' . $i . '"';
            //based on bustype display the prices
            if ($btype == 'seater')//if bus type is seater
                $td = '<td height="40"><input type="text" style="width:50px;" name="sfare' . $i . '" id="sfare' . $i . '"/></td>';
            else if ($btype == 'sleeper')//if bus type is sleeper
                $td = '<td height="40"><input type="text" style="width:50px;" name="lbfare' . $i . '" id="lbfare' . $i . '"/></td>
			  <td height="40"><input type="text" style="width:50px;" name="ubfare' . $i . '" id="ubfare' . $i . '"/></td>';
            else
                $td = '<td height="40"><input type="text" name="sfare' . $i . '" id="sfare' . $i . '" style="width:50px;"/></td><td><input type="text" name="lbfare' . $i . '" id="lbfare' . $i . '" style="width:50px;"/></td>
			  <td height="40"><input type="text" name="ubfare' . $i . '" id="ubfare' . $i . '" style="width:50px;"/></td>';

            echo'
          <tr>
            <td height="40">' . form_dropdown($name, $getroutes, "", $id) . '</td>
            <td height="40">' . form_dropdown($name2, $getroutes, "", $id2) . '</td>
            <td class="cancelt" height="40"><input type="text" id="start_time' . $i . '" name="start_time' . $i . '"  style="width:50px;" readonly="readonly" onfocus="javascript:canterm(1,' . $nstops . ',' . $i . ')"><div id="canterm' . $i . '" class="cancelt1"></div></td>
            <td class="cancelt" height="40"><input type="text" id="journey_time' . $i . '" name="journey_time' . $i . '" style="width:50px;" readonly="readonly" onfocus="javascript:canterm(2,' . $nstops . ',' . $i . ')"><div id="cantermm' . $i . '"  class="cancelt1"></div></td>
            <td height="40"><input readonly="readonly" type="text" style="width:60px;" id="arrtime' . $i . '"/></td>
            ' . $td . '
          </tr>';
        }//for
        echo '<tr><td colspan="6" align="center" height="40"><input type="button" name="sb" id="sb" class="newsearchbtn" onClick="saveBus()" value="Save Bus Stops"/></td></tr></table>';
    }

    public function getTimeListboxes() {
        $id = $_POST['id'];
        $ck = $_POST['ck'];
        $tim = $_POST['tim'];
        if ($tim != '') {
            $t1 = explode(':', $tim);
            $th = $t1[0];
            $tm = $t1[1];
        } else {
            $th = "00";
            $tm = "00";
        }
        /* calling model method for getting arrival time in hours */
        if ($ck == 1) {
            $getHours = $this->createbus_model->getHours();
            $starttime_hours_id = 'id="sthid' . $id . '"';
            $starttime_hours_name = 'name="sthname' . $id . '"';
            echo "Hours : ";
            echo form_dropdown($starttime_hours_name, $getHours, $th, $starttime_hours_id);

            /* calling model method for getting  Arrival Time in Minutes */
            $getMinutes = $this->createbus_model->getMinutes();
            $starttime_minutes_id = 'id="stmid' . $id . '" style="font-size:12px"';
            $starttime_minutes_name = 'name="stmname' . $id . '"';
            echo "&nbsp;&nbsp;&nbsp; Minutes : ";
            echo form_dropdown($starttime_minutes_name, $getMinutes, $tm, $starttime_minutes_id);
        } else if ($ck == 2) {
            /* calling model method for getting Journey Time in hours */
            $getHoursForJourneyTime = $this->createbus_model->getHoursForJT();
            $jtime_hours_id = 'id="jthid' . $id . '"';
            $jtime_hours_name = 'name="jthname' . $id . '"';
            echo "Hours : ";
            echo form_dropdown($jtime_hours_name, $getHoursForJourneyTime, $th, $jtime_hours_id);

            /* calling model method for getting  Arrival Time in Minutes */
            $getMinutes = $this->createbus_model->getMinutes();
            $jtime_minutes_id = 'id="jtmid' . $id . '" style="font-size:12px"';
            $jtime_minutes_name = 'name="jtmname' . $id . '"';
            echo "&nbsp;&nbsp;&nbsp; Minutes : ";
            echo form_dropdown($jtime_minutes_name, $getMinutes, $tm, $jtime_minutes_id);
        }

        echo '<span style="padding-left:20px;padding-top:15px;">Hide Popup &nbsp;<input class="newsearchbtn" type="button" value="ok" onClick="ok(' . $id . ',' . $ck . ')"/></span>';
    }

//close getTimeListboxes()

    function arrivalTimeCalCon() {
        $stat = $this->input->post('stimeval');
        $journey = $this->input->post('jtimeval');
        $arrtime = $this->createbus_model->arrivalTimCal($stat, $journey);
        echo $arrtime;
    }

    function saveBusController() {
        //getting all values from the view
        $servicetype = $this->input->post('servicetype');
        $nstops = $this->input->post('nstops');
        $srvno = $this->input->post('svc');
        $fid = $this->input->post('fids');
        $from = $this->input->post('froms');
        $tid = $this->input->post('tids');
        $to = $this->input->post('tos');
        $start = $this->input->post('sts');
        $journey = $this->input->post('jts');
        $arrtime = $this->input->post('ats');
        $sfare = $this->input->post('sfares');
        $lbfare = $this->input->post('lbfares');
        $ubfare = $this->input->post('ubfares');
        $model = $this->input->post('model');
        $btype = $this->input->post('btype');
        $nos = $this->input->post('nos');
        $nobl = $this->input->post('nobl');
        $nobu = $this->input->post('nobu');
        //calling the model
        $result = $this->createbus_model->saveBusModel($servicetype, $nstops, $srvno, $fid, $from, $tid, $to, $model, $btype, $nos, $nobl, $nobu, $start, $journey, $arrtime, $sfare, $lbfare, $ubfare);

        echo $result;
    }

    /*     * *******************Boarding Points Related Methods ******************** */

    //method for get the boarding point locations 
    function getBpSources() {
        $this->createbus_model->getBpSourcesDb();
    }

//bpLocations()
    //method for get the boarding point locations 
    //adding row to the boarding point

    function addRowBp() {
        $svc = $this->input->post('svc');
        $travel_id = $this->input->post('travid');
        $fromm = $this->input->post('from');
        $from_id = $this->input->post('fromid');
        $count = $this->input->post('count');
        $s = $this->input->post('s');
        $isvan = $this->input->post('isvan');
        //code for hours
        $data = $this->createbus_model->getHours();
        $bptimehi = 'id="bptimeh' . $isvan . $from_id . $s . '" ';
        $bptimehn = 'id="bptimeh' . $isvan . $from_id . $s . '" ';
        //code for minutes dropdown
        $data2 = $this->createbus_model->getMinutes();
        $bptimemi = 'id="bptimem' . $isvan . $from_id . $s . '" ';
        $bptimemn = 'id="bptimem' . $isvan . $from_id . $s . '" ';
        echo '<tr id="' . $isvan . $from_id . $s . '">
       <td width="10"><input type="hidden" name="servno' . $isvan . $from_id . $s . '" id="servno' . $isvan . $from_id . $s . '" value="' . $svc . '">
      <input type="hidden" name="travid' . $isvan . $from_id . $s . '" id="travid' . $isvan . $from_id . $s . '" value="' . $travel_id . '">
      <input type="hidden" name="from_name' . $isvan . $from_id . $s . '" id="from_name' . $isvan . $from_id . $s . '" value="' . $fromm . '">
      <input type="hidden" name="from_id' . $isvan . $from_id . $s . '" id="from_id' . $isvan . $from_id . $s . '" value="' . $from_id . '">
      <input type="hidden" name="count' . $isvan . $from_id . $s . '" id="count' . $isvan . $from_id . $s . '" value="' . $count . '">  </td> 
      <td width="103">' . $fromm . '
         </td>
      <td width="144"><input type="text" name="bp' . $isvan . $from_id . $s . '" id="bp' . $isvan . $from_id . $s . '"></td>
      <td width="143"><input type="text" name="lm' . $isvan . $from_id . $s . '" id="lm' . $isvan . $from_id . $s . '"></td>
      <td width="98">' . form_dropdown($bptimehn, $data, "", $bptimehi) . '' . form_dropdown($bptimemn, $data2, "", $bptimemi) . '</td>
      <td width="63"><input type="button" class="newsearchbtn" name="bps' . $isvan . $from_id . $s . '" id="bps' . $isvan . $from_id . $s . '" value="+" onclick="bpadd(\'' . $svc . '\',' . $travel_id . ',\'' . $fromm . '\',' . $from_id . ',' . $count . ',' . $s . ',\'' . $isvan . '\')"></td> </tr>';
    }

//bpLocations()
    //method for get the droping point locations 
    function getDestinationsBp() {
        $this->createbus_model->getDestinationsBpDb();
    }

//bpLocations()
    //adding row for dropping points
    function addRowDp() {
        $svc = $this->input->post('svc');
        $travel_id = $this->input->post('travid');
        $too = $this->input->post('to');
        $to_id = $this->input->post('toid');
        $count = $this->input->post('count');
        $s = $this->input->post('s');
        echo '<tr id="' . $to_id . $s . '">
       <td width="15%">&nbsp;</td> 
      <td width="27%">' . $too . '
      <input type="hidden" name="servno' . $to_id . $s . '" id="servno' . $to_id . $s . '" value="' . $svc . '">
      <input type="hidden" name="travid' . $to_id . $s . '" id="travid' . $to_id . $s . '" value="' . $travel_id . '">
      <input type="hidden" name="to_name' . $to_id . $s . '" id="to_name' . $to_id . $s . '" value="' . $too . '">
      <input type="hidden" name="to_id' . $to_id . $s . '" id="to_id' . $to_id . $s . '" value="' . $to_id . '">
      <input type="hidden" name="count' . $to_id . $s . '" id="count' . $to_id . $s . '" value="' . $count . '">  
         </td>
      <td width="43%"><input type="text" name="dp' . $to_id . $s . '" id="dp' . $to_id . $s . '"></td>
      
      <td width="15%"><input type="button" name="dps' . $to_id . $s . '" id="dps' . $to_id . $s . '" value="+" class="newsearchbtn" onclick="dpadd(\'' . $svc . '\',' . $travel_id . ',\'' . $too . '\',' . $to_id . ',' . $count . ',' . $s . ')"></td> </tr>';
    }

    function saveBoardings() {
        $this->createbus_model->saveBoardingsDb();
    }

    function saveDroppings() {
        $this->createbus_model->saveDroppingsDb();
    }

    function getStoredBp() {
        $this->createbus_model->getStoredBpFromDb();
    }

    function deleteBp() {
        $this->createbus_model->deleteBpFromDb();
    }

    function getStoredDp() {
        $this->createbus_model->getStoredDpFromDb();
    }

    function storeEminities() {
        $this->createbus_model->storeEminitiesDb();
    }

    /*     * *******************End Of Boarding Points Related Methods ******************** */


    /*     * *******************Methods related to Activating the Bus******************** */

    function dispServicesList() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['operators'] = $this->modellogin->get_operator();
            //$data['services'] = $this->createbus_model->getServicesListForActiveOrDeactive();
            $data['key'] = 'DeActive';
            $this->load->view('bus/activebus_view.php', $data);
        }
    }

    function dispDeleteServicesList() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['operators'] = $this->modellogin->get_operator();
            $data['services'] = $this->createbus_model->getServicesListForActiveOrDeactive();
            $data['key'] = 'Delete';
            $this->load->view('bus/activebus_view.php', $data);
        }
    }

    public function servicesListActiveOrDeactive() {
        $this->createbus_model->getServicesListActiveOrDeactive();
    }

//servicesListActiveOrDeactive()

    public function deActivateBusPermanent() {
        //echo "deActivateBusPermanent";
        $this->createbus_model->deActivateBusPermanentDb();
    }

//deActivateBusPermanent()

    function getForwordBookingDays() {

        $servtype = $this->input->post('servtype');

        $travid = $this->input->post('travid');
        $s = $this->input->post('s');
        $svc = $this->input->post('svc');
        $fromid = $this->input->post('fromid');
        $toid = $this->input->post('toid');
        $stat = $this->input->post('status');
        $data = $this->createbus_model->getForwordBookingDaysFromDb($travid);
        if ($data == 0) {
            echo '0';
        }
        if ($servtype == "normal") {
            echo '<table width="457" border="0" style="border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; border-left:#f2f2f2 solid 1px; border-bottom:#f2f2f2 solid 1px; font-size:14px;color:#333333;" align="center">
  <tr>
    <td width="449">Forward booking days are:&nbsp;<span style="color:#000066;font-size:12px; font-weight:bold;">' . $data . '</span></td>
  </tr>
  <tr>
    <td>select the start date from datepicker:
 <input name="txtdate' . $s . '" type="text" id="txtdate' . $s . '" style="cursor:pointer;border-radius:3px" value="" 
     onChange="getTodate(' . $data . ',' . $s . ')"/></td>
  </tr>
  <tr>
    <td id="txt' . $s . '"></td>
  </tr>
  <tr>
    <td align="center">
    <input type="button" class="newsearchbtn" name="updt' . $s . '" id="updt' . $s . '" value="Update" 
        onClick="updateStatus(\'' . $svc . '\',' . $travid . ',' . $data . ',' . $stat . ',' . $s . ',' . $fromid . ',' . $toid . ')">
       </td>
  </tr>
  <tr>
    <td align="center"><input type="hidden" name="fwddate" id="fwddate" value="" ><span id="spnmsg' . $s . '" style="font-size:12px; font-weight:bold;"></span> </td>
  </tr>
</table>';
        } else if ($servtype == "special") {

            echo ' <table width="457" border="0" style="border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; border-left:#f2f2f2 solid 1px; border-bottom:#f2f2f2 solid 1px; font-size:14px;color:#333333;" align="center">
  <tr>
    <td>select the start date from datepicker:
 <input name="txtdate' . $s . '" type="text" id="txtdate' . $s . '" style="cursor:pointer;border-radius:3px"
     value=""  /></td>
  </tr>
  <tr>
    <td>select the end date from datepicker:
 <input name="txtdatee' . $s . '" type="text" id="txtdatee' . $s . '" style="cursor:pointer;border-radius:3px" 
     value=""  onChange="getTodateForSpecialService(' . $data . ',' . $s . ')"/></td>
  </tr>
  <tr>
    <td id="txt' . $s . '"></td>
  </tr>
  <tr>
    <td align="center">
    <input type="button" class="newsearchbtn" name="updt' . $s . '" id="updt' . $s . '" value="Update" 
        onClick="updateStatus(\'' . $svc . '\',' . $travid . ',' . $data . ',' . $stat . ',' . $s . ',' . $fromid . ',' . $toid . ')">
       </td>
  </tr>
  <tr>
  
    <span id="spnmsg' . $s . '" style="font-size:12px; font-weight:bold;"></span> </td>
  </tr>
</table>';
        } else if ($servtype == "weekly") {
            echo '<table width="457" border="0" style="border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; border-left:#f2f2f2 solid 1px; border-bottom:#f2f2f2 solid 1px; font-size:14px;color:#333333;" align="center">
  <tr>
    <td width="449">Forward booking days are:&nbsp;<span style="color:#000066;font-size:12px; font-weight:bold;">' . $data . '</span></td>
  </tr>
  <tr>
    <td>select the start date from datepicker:
 <input name="txtdate' . $s . '" type="text" id="txtdate' . $s . '" style="cursor:pointer;border-radius:3px" value="" 
     onChange="getTodate(' . $data . ',' . $s . ')"/></td>
  </tr>
  <tr>
    <td id="txt' . $s . '"></td>
  </tr>
  <tr>
    <td align="center">
    <input type="button" class="newsearchbtn" name="updt' . $s . '" id="updt' . $s . '" value="Update" 
        onClick="updateStatus(\'' . $svc . '\',' . $travid . ',' . $data . ',' . $stat . ',' . $s . ',' . $fromid . ',' . $toid . ')">
       </td>
  </tr>
  <tr>
    <td align="center"><input type="hidden" name="fwddate" id="fwddate" value="" ><span id="spnmsg' . $s . '" style="font-size:12px; font-weight:bold;"></span> </td>
  </tr>
</table>';
        }//else if($servtype=="special")
    }

    function getActivateDates() {
        $sdate = $this->input->post('sdate');
        $fwd = $this->input->post('fwd') - 1;
        $date = new DateTime($sdate);
        $date->modify('+' . $fwd . 'day');
        $max_date = $date->format('Y-m-d');
        echo $max_date;
    }

    function activeBusStatus() {
        $travid = $this->input->post('travid');
        $s = $this->input->post('s');
        $sernum = $this->input->post('sernum');
        $fromid = $this->input->post('fromid');
        $toid = $this->input->post('toid');
        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');
        $status = $this->input->post('status');
        $fwd = $this->input->post('fwd');
        $servtype = $this->input->post('servtype');
        $data = $this->createbus_model->activeBusStatusDb($travid, $sernum, $s, $fromid, $toid, $status, $fwd, $fdate, $tdate, $servtype);
        echo $data;
    }

    /*     * *******************End of Methods related to Activating the Bus******************** */


    /*     * *******************Methods related to Breakdown updation******************** */

    function breakdown_view() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['operators'] = $this->modellogin->get_operator();

            $this->load->view('bus/bus_breakdonw_view.php', $data);
        }
    }

    public function getservice1() {
        $service = $this->createbus_model->getservic_modify();
        print_r($service);
    }

    function deActivateBusDatePickers() {
        $key = $this->input->post('key');
        $travid = $this->input->post('travid');
        $s = $this->input->post('s');
        $svc = $this->input->post('svc');
        $fromid = $this->input->post('fromid');
        $toid = $this->input->post('toid');
        $stat = $this->input->post('status');
        $url = base_url('images/calendar.gif');
        // echo $url;
        echo '<table width="52%">
     <tr>
     <td colspan="2" align="center" class="style2">Select Dates to ' . $key . ' the Bus</td>
     </tr>    
     <tr>
     <td width="84" height="34"> <span style="font-size:16px"> From Date:</span> </td>
     <td width="290"><input name="txtdatee' . $s . '" type="text" id="txtdatee' . $s . '"  value="" onChange="onChge(' . $s . ',\'' . $key . '\')"/></td>
    </tr>
     <tr>
    <td> <span style="font-size:16px">To Date :</span>&nbsp;&nbsp;</td>
    <td><input name="txtdateee' . $s . '"  type="text" id="txtdateee' . $s . '" value=""  onChange="getFromTo(' . $s . ',\'' . $key . '\')"/></td>
   </tr>
     <tr id="radio' . $s . '" style="display:none">
       <td>&nbsp;</td>
       <td><input type="radio" name="ser' . $s . '" id="alternative' . $s . '" value="cancelled">Service Cancelled &nbsp;<input type="radio" name="ser' . $s . '" id="serCancelled' . $s . '" value="alternative">Alternative Arranged</td>
     </tr>
	 <tr id="checkbox' . $s . '" style="display:none">
       <td>&nbsp;</td>
       <td>
	   <input name="release' . $s . '" id="release' . $s . '" value="release" type="checkbox">
       Release All Seats       	</td>
     </tr>
   <tr>
    <td id="txtt' . $s . '"></td>
    <td id="txtt' . $s . '"></td>
   </tr>
   <tr>
    <td colspan="2"  align="center"><input type="button" class="newsearchbtn" name="updt' . $s . '" id="updt' . $s . '" value="Update" onClick="updateStatusAsDeAct(\'' . $key . '\',\'' . $svc . '\',' . $travid . ',' . $stat . ',' . $s . ',' . $fromid . ',' . $toid . ')">       </td>
  </tr>
  <tr>
    <td colspan="2" align="center"><span id="spnmsg' . $s . '" style="font-size:12px; font-weight:bold;"></span> </td>
  </tr>
</table>';
    }

    function mailForBusCancelController() {
        $key = $this->input->post('key');
        $travid = $this->input->post('travid');
        $s = $this->input->post('s');
        $cnt = $this->input->post('cnt');
        $sernum = $this->input->post('sernum');
        $fromid = $this->input->post('fromid');
        $toid = $this->input->post('toid');
        $status = $this->input->post('status');
        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');
        $data = $this->createbus_model->mailForBusCancel($key, $sernum, $travid, $fdate, $tdate, $status, $cnt, $s, $fromid, $toid);
        echo $data;
    }

    function deActivateBus() {
        $key = $this->input->post('key');
        $travid = $this->input->post('travid');
        $s = $this->input->post('s');
        $cnt = $this->input->post('cnt');
        $sernum = $this->input->post('sernum');
        $fromid = $this->input->post('fromid');
        $toid = $this->input->post('toid');
        $status = $this->input->post('status');
        $newfDate1 = $this->input->post('fdate');
        $newtDate1 = $this->input->post('tdate');
        $chkedRadio = $this->input->post('chkRadio');

        $ex1 = explode("/", $newfDate1);
        $ex2 = explode("/", $newtDate1);

        //$fdate=$ex1[2]."-".$ex1[1]."-".$ex1[0];
        //$tdate=$ex2[2]."-".$ex2[1]."-".$ex2[0];

        $fdate = $newfDate1;
        $tdate = $newtDate1;


        $data = $this->createbus_model->deActivateBusDb($key, $sernum, $travid, $fdate, $tdate, $status, $cnt, $s, $fromid, $toid, $chkedRadio);
        //echo $data;   
    }

    public function ViewHistory() {
        //$srvno=$_GET['srvno'];
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $s = $this->input->get('srvno');
            $s1 = explode(".", $s);
            $srvno = $s1[0];
            $this->load->library('pagination');
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $config = array();
            $config['base_url'] = base_url() . "createbus/viewHistory?srvno=$srvno";
            $config['total_rows'] = $this->createbus_model->total_list($srvno);
            $config['per_page'] = 50;
            $config['uri_segment'] = 3;
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $this->pagination->initialize($config);
            $data['query'] = $this->createbus_model->detail_breakdown($config['per_page'], $page, $srvno);
            $data['links'] = $this->pagination->create_links();
            $this->load->view('bus/view_breakdown_updation.php', $data);
        }
    }

    /*     * **
     * *****************************CHANGE PRICING*********************************
     * this method loads by default, list box along with all services************** */

    public function changepricing_home() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['operators'] = $this->modellogin->get_operator();
            //$data['result'] = $this->createbus_model->getSericeNumbers();
            $this->load->view('bus/changepricing_view', $data);
        }
    }

    //to display the selected service or all services 
    function getRoutes() {
        $svc = $this->input->post('svc');
        $opid = $this->input->post('opid');
        $travel_id = $this->input->post('opid');
        $query = $this->createbus_model->getRoutesFromDb($svc,$opid);

        foreach ($query->result() as $row) {
            $srvroute = $row->service_route;
            $srno = explode("To", $srvroute);
            $model = $row->model;
        }

        echo '<style type="text/css">
		.tdborder
		{
			border:#CCCCCC solid 1px;
			padding-left:5px;
		}
		</style>
		<script type="text/javascript">
		$(function() 
		{                                              
			$( "#fdate" ).datepicker({ dateFormat: "yy-mm-dd",numberOfMonths: 1, showButtonPanel: false,minDate: 0
            });
            $( "#tdate" ).datepicker({ dateFormat: "yy-mm-dd",numberOfMonths: 1, showButtonPanel: false,minDate: 0
            });
		});

		</script>
';
        echo '<table width="73%" border="0" align="center"  >
		     <tr >
			 	<td width="90" height="38">From  Date:</td>
				<td width="130"><input type="text" name="fdate" class="inputmedium" id="fdate" value="' . Date("Y-m-d") . '"   />
				</td>
				<td width="29">&nbsp;</td>
				<td width="81">To Date: </td>
				<td width="137"><input type="text" name="tdate" class="inputmedium" id="tdate"   value="' . Date("Y-m-d") . '"/></td>
			</tr>
		</table>';
        echo '<table width="100%" border="0" align="center" style="border:#CCCCCC solid 1px; font-size:14px">
	          <tr>
			  	<td colspan="5" bgcolor="#2FA4E7" style="color:#FFFFFF"><strong>Halts And Fares</strong>*</td>
              </tr>
			  <tr style="background-color:#CCCCCC">
			  	<td width="146" align="center"><strong>Source</strong></td>
				<td width="131" align="center"><strong>Destination</strong></td>';
        if ($row->bus_type == "seater") {
            echo'<td width="167" align="center"><strong>Seat Fare </strong></td>';
        } else if ($row->bus_type == "sleeper") {
            echo'<td width="169" align="center"><strong>Lower Berth Fares</strong></td>
					<td width="185" align="center"><strong>Upper Berth Fares</strong></td>';
        } else {
            echo'<td width="167" align="center"><strong>Seat Fare </strong></td>';
            echo'<td width="169" align="center"><strong>Lower Berth Fares</strong></td>
					<td width="185" align="center"><strong>Upper Berth Fares</strong></td>';
        }
        echo'</tr></thead><tbody>';
        $i = 1;
        $current_date = date('Y-m-d');
        foreach ($query->result() as $row) {
            $from_id = $row->from_id;
            $to_id = $row->to_id;
            $srvno = $row->service_num;

            $sql = mysql_query("select * from buses_list where travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id' and service_num='$srvno' and journey_date='$current_date'");
            $rows = mysql_fetch_assoc($sql);

            $seat_fare = $rows['seat_fare'];
            $lberth_fare = $rows['lberth_fare'];
            $uberth_fare = $rows['uberth_fare'];

            $travid = $row->travel_id;
            $start_time = date("h:i A", strtotime($row->start_time));
            $arr_time = date("H:i A", strtotime($row->arr_time));


            if ($row->bus_type == "seater") {
                if ($seat_fare == "") {
                    $sfare = $row->seat_fare;
                    $lfare = "";
                    $ufare = "";
                } else {
                    $sfare = $seat_fare;
                }
            } else if ($row->bus_type == "sleeper") {
                $sfare = "";
                if ($lberth_fare == "") {
                    $lfare = $row->lberth_fare;
                } else {
                    $lfare = $lberth_fare;
                }
                if ($lberth_fare == "") {
                    $ufare = $row->uberth_fare;
                } else {
                    $ufare = $uberth_fare;
                }
            } else {
                if ($seat_fare == "") {
                    $sfare = $row->seat_fare;
                } else {
                    $sfare = $seat_fare;
                }
                if ($lberth_fare == "") {
                    $lfare = $row->lberth_fare;
                } else {
                    $lfare = $lberth_fare;
                }
                if ($lberth_fare == "") {
                    $ufare = $row->uberth_fare;
                } else {
                    $ufare = $uberth_fare;
                }
            }

            echo '<tr class="' . $class . '" >
								         <td height="30" align="center" width="146">' . $row->from_name . '</td>
										 <input type="hidden" id="fid' . $i . '" value="' . $row->from_id . '" >
										 <input type="hidden" id="tid' . $i . '" value="' . $row->to_id . '" >
										 <td align="center" width="131">' . $row->to_name . '</td>';
            if ($row->bus_type == "seater") {
                echo '<td align="center" width="167"><input type="text" class="inputfield" name="sfare' . $i . '" id="sfare' . $i . '" value="' . $sfare . '"></td>';
            } elseif ($row->bus_type == "sleeper") {
                echo '<td align="center" width="169"><input type="text" class="inputfield" name="lbfare' . $i . '" id="lbfare' . $i . '" value="' . $lfare . '"></td> ';
                echo '<td align="center"><input type="text" class="inputfield" name="ubfare' . $i . '" id="ubfare' . $i . '" value="' . $ufare . '"></td>';
            } else {
                echo '<td align="center" width="167"><input type="text" class="inputfield" name="sfare' . $i . '" id="sfare' . $i . '" value="' . $sfare . '"></td>';
                echo '<td align="center" width="169"><input type="text" class="inputfield" name="lbfare' . $i . '" id="lbfare' . $i . '" value="' . $lfare . '"></td> ';
                echo '<td align="center"><input type="text" class="inputfield" name="ubfare' . $i . '" id="ubfare' . $i . '" value="' . $ufare . '"></td>';
            }
            $i++;
        }//foreach
        $k = $i - 1;
        echo ' </tr>
			<tr class="' . $class . '" >
			<td height="26" colspan="5" align="center"><input type="button" class="newsearchbtn" value="update" name="up" id="up" onClick="updateFare()"></td></tr>  ';
        echo '</table>';
        echo '<input type="hidden" id="hdd" value="' . $k . '" ><input type="hidden" id="btype" value="' . $row->bus_type . '" >';
    }

    function getFares() {
        $this->createbus_model->getFaresDb();
    }

    function updatePrice() {
        $this->createbus_model->updateFareDb();
        // $this->createbus_model->updatePriceDb();     
    }

    /*     * *****************************END OF CHANGE PRICING******************************** */

    /*     * *****************************Service Deletion Code******************************** */

    function delete_service() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(get_cookie('website_url'));
        } else {
            $this->load->view('header_view.php');
            $this->load->view('sidebar_view.php');
            $data['query'] = $this->createbus_model->ShowBusService();
            $this->load->view('bus/deleteService', $data);
        }
    }

    function deleteSelectedService() {
        $sernum = $this->input->post('service_num');
        $travel_id = $this->input->post('travel_id');
        $this->createbus_model->DeleteBusService($sernum, $travel_id);
    }

    /*     * *****************************End of Service Deletion Code******************************** */
    /*     * *****************************View Layouts******************************** */

    function view_layouts() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(get_cookie('website_url'));
        } else {
            $this->load->view('header_view.php');
            $this->load->view('sidebar_view.php');
            $data['bus_service'] = $this->createbus_model->show_service();
            $this->load->view('bus/layout_view.php', $data);
        }
    }

    function LayoutsDisplay() {
        $sernum = $this->input->post('service_num');
        $travel_id = $this->input->post('travel_id');
        $this->createbus_model->display_service_layout($travel_id, $sernum);
    }

    /*     * *****************************End of View Layouts******************************** */
    /*     * *****************************View changed price history******************* */

    function view_Price_history() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(get_cookie('website_url'));
        } else {
            $this->load->view('header_view.php');
            $this->load->view('sidebar_view.php');
            $data['service'] = $this->createbus_model->service_List();
            $this->load->view('bus/price_history.php', $data);
        }
    }

    function Getlist() {

        $this->createbus_model->display_servicelist();
    }

    function get_price_history() {

        $this->createbus_model->display_history();
    }

    /*     * ***************************End of View changed price history**************** */
    /*     * *******************************Modify bus*********************************** */

    function modify_bus() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['operators'] = $this->modellogin->get_operator();

            $this->load->view('bus/modifybus_view.php', $data);
        }
    }

    public function getservice() {

        $service = $this->createbus_model->getservic_modify();
        print_r($service);
    }

    function DoModify() {
        $this->createbus_model->modifyRequirements();
    }

    function modify_saving() {
        $this->createbus_model->SaveModifytoDb();
    }

    function deletebpFromDb() {
        $this->createbus_model->DeleteModifytoDb();
    }

    function getCity() {
        $srvno = $this->input->post('srvno');
        $this->db->select('city_name');
        $this->db->where('service_num', $srvno);
        $query = $this->db->get('boarding_points');
        $data = array();
        $data['0'] = "--select--";
        foreach ($query->result() as $rows) {
            $data[$rows->city_name] = $rows->city_name;
        }

        return $data;
    }

    function getBCity() {
        $srvno = $this->input->post('srvno');


        $data = array();
        $data['0'] = "--select--";

        $this->db->distinct('from_name');
        $this->db->select('from_name');
        $this->db->where('service_num', $srvno);

        $query1 = $this->db->get('master_buses');
        foreach ($query1->result() as $rows1) {
            $data[$rows1->from_name] = $rows1->from_name;
        }

        return $data;
    }

    function addnewbp1() {

        $s = $this->input->post('s');
        $srvno = $this->input->post('srvno');
        $travid = $this->session->userdata('travel_id');
        $hours = $this->createbus_model->getHour();
        $timehr = 'id="timehr' . $s . '" ';
        $timen = 'name="timehr' . $s . '" ';
        $hours1 = $this->createbus_model->getMinutes();
        $timemi = 'id="timem' . $s . '" ';
        $timemn = 'name="timem' . $s . '" ';
        $van1 = $this->createbus_model->vanpick();
        $vani = 'id="vani' . $s . '" ';
        $vann = 'name="vann' . $s . '" ';
        // $loc1= $this->getBCity();
        $loc1 = $this->createbus_model->getAllCity();
        $loci = 'id="loc' . $s . '" ';
        $locn = 'name="loc' . $s . '" ';
        $tfid = 'id="tfm' . $s . '" ';
        $tfname = 'name="tfm' . $s . '" ';
        $tfv = array("0" => "-select-", "AM" => "AM", "PM" => "PM");
        //print_r($loc1);
        if ($s == "1") {

            echo '<table id="mytable">
                <tr>
                <td height="30" class="space">Type</td>
                <td height="30" class="space">Location</td>
                <td height="30" class="space">Boarding Point</td>
                <td height="30" class="space">Landmark</td>
                <td height="30" class="space">Time(in hr&min)</td>
				<td height="30" class="space">Is van pickup?</td>
				<td height="30" class="space"></td>
                </tr>';
            echo '<tr id="tr' . $s . '">
           <td><input type="checkbox" name="ck' . $s . '" id="ck' . $s . '" value="' . $s . '" checked>board</td>
           <td width="100">' . form_dropdown($locn, $loc1, "", $loci) . '<input type="hidden" name="bpid' . $s . '" id="bpid' . $s . '" value="' . $bpdp . '"><input type="hidden" name="cid' . $s . '" id="cid' . $s . '" value="' . $loc_id . '"></td>
           <td width="120"><input type="text" name="bp' . $s . '" id="bp' . $s . '" ></td>
           <td width="143"><input type="text" name="lm' . $s . '" id="lm' . $s . '"></td> 
           <td>' . form_dropdown($timen, $hours, "", $timehr) . '' . form_dropdown($timemn, $hours1, "", $timemi) . '' . form_dropdown($tfname, $tfv, "", $tfid) . '</td>
           <td>' . form_dropdown($vann, $van1, "", $vani) . '</td>
           <td><span style="cursor:pointer; font-weight:bold; color:#81BEF7; text-decoration:underline;" onClick="DeleteBP(' . $s . ')">Delete</span></td>    
           </tr>';
            echo '<tr><td align="center" colspan="6">&nbsp;</td><tr><tr><td align="center" colspan="2"></td><td align="center" colspan="3"><input type="button" class="newsearchbtn" id="save" value="Save" onClick="saveModification(\'' . $srvno . '\',' . $travid . ',' . $s . ')"></td>
		   </tr></table>';
        } else {

            echo '<tr id="tr' . $s . '">
           <td><input type="checkbox" name="ck' . $s . '" id="ck' . $s . '" value="' . $s . '" checked>board</td>
           <td width="100">' . form_dropdown($locn, $loc1, "", $loci) . '<input type="hidden" name="bpid' . $s . '" id="bpid' . $s . '" value="' . $bpdp . '"><input type="hidden" name="cid' . $s . '" id="cid' . $s . '" value="' . $loc_id . '"></td>
           <td width="120"><input type="text" name="bp' . $s . '" id="bp' . $s . '" ></td>
           <td width="143"><input type="text" name="lm' . $s . '" id="lm' . $s . '"></td> 
           <td>' . form_dropdown($timen, $hours, "", $timehr) . '' . form_dropdown($timemn, $hours1, "", $timemi) . '' . form_dropdown($tfname, $tfv, "", $tfid) . '</td>
           <td>' . form_dropdown($vann, $van1, "", $vani) . '</td>
           <td><span style="cursor:pointer; font-weight:bold; color:#81BEF7; text-decoration:underline;" onClick="DeleteBP(' . $s . ')">Delete</span></td>    
           </tr>';
        }
    }

    function ModifyAminity() {
        $this->createbus_model->modify_Aminities();
    }

    function modify_save_aminity() {
        $this->createbus_model->modify_Aminitiesdb();
    }

    function DoModifyDrop() {
        $this->createbus_model->modify_Drop_point();
    }

    function addnewdp1() {

        $s = $this->input->post('s');
        $srvno = $this->input->post('srvno');
        $travid = $this->session->userdata('travel_id');
        // $loc1= $this->getBCity();
        $loc1 = $this->createbus_model->getAllCity();
        $loci = 'id="loc' . $s . '" ';
        $locn = 'name="loc' . $s . '" ';
        if ($s == "1") {
            echo '<table id="dptable" style="margin: 0px auto; border:#CCCCCC;" width="83%">
                <tr >
                  <td width="98" class="space">&nbsp;</td>
                
                <td width="216" height="30" class="space">Type</td>
                <td height="30" class="space">Location</td>
                <td height="30" class="space">Dropping point</td>
				<td width="275" height="30" class="space"></td>
                </tr>';
            echo '<tr id="tr' . $s . '">
              <td>&nbsp;</td>
           <td><input type="checkbox" name="ck' . $s . '" id="ck' . $s . '" value="' . $s . '" checked>drop</td>
           <td width="257">' . form_dropdown($locn, $loc1, "", $loci) . '<input type="hidden" name="bpid' . $s . '" id="bpid' . $s . '" value="' . $bpdp . '"><input type="hidden" name="cid' . $s . '" id="cid' . $s . '" ></td>
           <td width="152"><input type="text" name="dp' . $s . '" id="dp' . $s . '" ></td>
           
           <td><span style="cursor:pointer; font-weight:bold; color:#81BEF7; text-decoration:underline;" onClick="DeleteBP(' . $s . ')">Delete</span></td></tr>
            <tr id="tr' . $s . '">
              <td colspan="5">&nbsp;</td>
            </tr>
            <tr id="tr' . $s . '">
              <td colspan="5" align="center"><input name="button" class="newsearchbtn" type="button" id="save" onClick="saveDP(\'' . $srvno . '\',' . $travid . ',' . $s . ')" value="Save"></td>
            </tr> 
		   </table>
';
        } else {
            echo '<tr id="tr' . $s . '">
           <td><input type="checkbox" name="ck' . $s . '" id="ck' . $s . '" value="' . $s . '" checked>drop</td>
           <td width="100">' . form_dropdown($locn, $loc1, "", $loci) . '<input type="hidden" name="bpid' . $s . '" id="bpid' . $s . '" value="' . $bpdp . '"><input type="hidden" name="cid' . $s . '" id="cid' . $s . '" ></td>
           <td width="120"><input type="text" name="dp' . $s . '" id="dp' . $s . '" ></td>
           <td><span style="cursor:pointer; font-weight:bold; color:#81BEF7; text-decoration:underline;" onClick="DeleteBP(' . $s . ')">Delete</span></td>    
           </tr>';
        }
    }

    function modify_dp() {
        $this->createbus_model->SaveDPtoDb();
    }

    function ModifyRoutes() {
        $this->createbus_model->modify_routes();
    }

    function deleterouteFromDb() {
        $this->createbus_model->delete_routes();
    }

    function save_routes() {
        $this->createbus_model->save_routes_db();
    }

    function addNewRoutesDb() {
        $s = $this->input->post('s');
        $bus_type = $this->input->post('bus');
        $hours = $this->createbus_model->getHour();
        //  $timehr='id="timehr'.$s.'" onChange="arrtime('.$s.')"';
        $timehr = 'id="timehr' . $s . '" ';
        $timen = 'name="timehr' . $s . '" ';
        $hours1 = $this->createbus_model->getMinutes();
        $timemi = 'id="timem' . $s . '" onChange="arrtime(' . $s . ')"';
        $timemn = 'name="timem' . $s . '"';
        /* $hoursj=$this->createbus_model->getHours();
          $timehrj='id="timehrj'.$s.'" onChange="arrtime('.$s.')"';
          $timenj='name="timehrj'.$s.'" ';
          $hoursj1=$this->createbus_model->getMinutes();
          $timemij='id="timemj'.$s.'" onChange="arrtime('.$s.')"';
          $timemnj='name="timemj'.$s.'"'; */
        $cities = $this->createbus_model->getAllCity();
        $cityid = 'id="from' . $s . '" style="width: 130px;" ';
        $cityn = 'name="from' . $s . '"';
        $tocities = $this->createbus_model->getAllCity();
        $tocityid = 'id="to' . $s . '" style="width: 130px;" ';
        $tocityn = 'name="to' . $s . '"';
        $hoursa = $this->createbus_model->getHour();
        $arrth = 'id="arrth' . $s . '"';
        $arrh1 = 'name="arrth' . $s . '" ';
        $arrtm = 'id="arrtm' . $s . '"';
        $arrtm1 = 'name="arrtm' . $i . '" ';
        $hoursa1 = $this->createbus_model->getMinutes();
        $tfid = 'id="tfms' . $s . '" ';
        $tfname = 'name="tfms' . $s . '" ';
        $tfid1 = 'id="tfma' . $s . '" ';
        $tfname1 = 'name="tfma' . $s . '" ';
        $tfv = array("0" => "-select-", "AM" => "AM", "PM" => "PM");
        echo'<tr id="tr' . $s . '">
         <td><input type="checkbox" name="ck' . $s . '" id="ck' . $s . '" value="' . $s . '" checked></td>
         <td>' . form_dropdown($cityn, $cities, "", $cityid) . '<input type="hidden" size="15" name="fromid' . $s . '" id="fromid' . $s . '" value="' . $fromid . '"></td>
         <td>' . form_dropdown($tocityn, $tocities, "", $tocityid) . '<input type="hidden" size="15" name="toid' . $s . '" id="toid' . $s . '" value="' . $toid . '"></td>
         <td>' . form_dropdown($timen, $hours, "", $timehr) . '' . form_dropdown($timemn, $hours1, "", $timemi) . '' . form_dropdown($tfname, $tfv, "", $tfid) . '</td>
         <td>' . form_dropdown($arrh1, $hoursa, "", $arrth) . '' . form_dropdown($arrtm1, $hoursa1, "", $arrtm) . '' . form_dropdown($tfname1, $tfv, "", $tfid1) . '</td>
        ';
        if ($bus_type == 'seater') {
            echo '<td><input type="text" size="8" name="seat_fare' . $s . '" id="seat_fare' . $s . '" ></td>';
        } else if ($bus_type == 'sleeper') {
            echo '<td><input type="text" size="8" name="lowerseat_fare' . $s . '" id="lowerseat_fare' . $s . '" ></td>
               <td><input type="text" size="8" name="upperseat_fare' . $s . '" id="upperseat_fare' . $s . '" ></td>';
        } else if ($bus_type == 'seatersleeper') {
            echo '<td><input type="text" size="8" name="seat_fare' . $s . '" id="seat_fare' . $s . '" ></td>
               <td><input type="text" size="8" name="lowerseat_fare' . $s . '" id="lowerseat_fare' . $s . '" ></td>
               <td><input type="text" size="8" name="upperseat_fare' . $s . '" id="upperseat_fare' . $s . '" ></td>';
        }
        echo '<td><span style="cursor:pointer; font-weight:bold; color:#81BEF7; text-decoration:underline;" onClick="DeleteRoutes(' . $s . ')">Delete</span></td>
          </tr>';
    }

    function seat_layout() {
        $this->createbus_model->modify_seatname();
    }

    function SaveSeatname() {
        $this->createbus_model->save_seatnamedb();
    }

    /*     * ****************************End of Modify bus******************************** */

    function cancelServiceRefund() {


        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(get_cookie('website_url'));
        } else {
            $this->load->view('header_view.php');
            $this->load->view('sidebar_view.php');
            // $this->load->library('pagination');
            //$this->load->library('table');
            //$config = array();
            //$config['base_url'] = ("http://rajdhaniexpressbus.in").'createbus/cancelServiceRefund/';
            //$config['total_rows'] = $this->createbus_model->get_CancelDetails(0,0);
            //$config['per_page'] = 7;
            //$config['uri_segment'] = 3;
            //$config['full_tag_open'] = '<div class="pagination">';
            //$config['full_tag_close'] = '</div>'; 
            //$page = ($this->uri->segment(3)>0) ? $this->uri->segment(3) : 0;
            //$this->pagination->initialize($config);
            $result['query1'] = $this->createbus_model->get_CancelDetails();
            //$result['links'] = $this->pagination->create_links();
            $this->load->view('bus/cancelServicerefund.php', $result);
        }
    }

    function get_remarks() {

        $data = $this->createbus_model->get_remarks_table();
        return $data;
    }

    function do_amountRefund() {
        $this->createbus_model->do_amountRefundupdate();
    }

    function Show_ServiceRecords_View() {
        $this->createbus_model->displayServiceRecords_View();
    }

    function Servicecancel_Records_update() {
        $this->createbus_model->Servicecancel_Records_update_in_db();
    }

    //getting services
    public function GetServiceReport() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->createbus_model->getServicesListDetails();
        }
    }

//GetServiceReport()

    public function modify_model() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(get_cookie('website_url'));
        } else {
            $this->createbus_model->modify_model1();
        }
    }

    public function updatemodel() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(get_cookie('website_url'));
        } else {
            $this->createbus_model->updatemodel1();
        }
    }

    public function service_tax() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(get_cookie('website_url'));
        } else {
            $this->createbus_model->service_tax1();
        }
    }

    public function updateTax() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(get_cookie('website_url'));
        } else {
            $this->createbus_model->updateTax1();
        }
    }

}

//
?>