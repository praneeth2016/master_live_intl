<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Home controller class
 * This is only viewable to those members that are logged in
 */

class Quota_updation_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->model('quota_update_model');
        $this->load->model('modellogin');
        $this->load->model('createbus_model');
    }

    public function quota_update() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $this->load->model('createbus_model');
            $data['operators'] = $this->modellogin->get_operator();
            $data['services'] = $this->createbus_model->getServicesList();
            // $data['query']=$this->quota_update_model->getServicesList();
            $this->load->view('bus/quota_update_view.php', $data);
        }
    }

    //getting services detail
    public function GetServiceReport() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->quota_update_model->getServicesListDetails();
        }
    }

//GetServiceReport()

    function getLayoutForQuota() {
        $sernum = $this->input->post('sernum');
        $travel_id = $this->input->post('travel_id');
        $s = $this->input->post('s');
        $this->quota_update_model->getLayoutForQuotaDb($sernum, $travel_id, $s);
    }

    function SelectAgentType() {
        $s = $this->input->post('s');
        $id = $this->input->post('id');
        $travel_id = $this->input->post('opid');
        //echo $id;
        $agent = $this->quota_update_model->geAgentName($id,$travel_id);
        $agentid = 'id="ag' . $s . '" class="inputfield"';
        $agent_name = 'ag' . $s;
        if ($agent[0] == '--select--')
            echo form_dropdown($agent_name, $agent, "", $agentid) . 'No Agents are Created !';
        else
            echo form_dropdown($agent_name, $agent, "", $agentid);
    }

    function UpdateAndValidate() {
        $sernum = $this->input->post('service_num');
        $travel_id = $this->input->post('travel_id');
        $seats = $this->input->post('seat_names');
        $agent_type = $this->input->post('agent_type');
        $agent_id = $this->input->post('agent_id');
        $c = $this->input->post('c');
        $this->quota_update_model->updateQuota($sernum, $travel_id, $seats, $agent_id, $agent_type, $c);
    }

    function grabAndRelease() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $this->load->model('createbus_model');
            $data['operators'] = $this->modellogin->get_operator();
            //$data['services'] = $this->createbus_model->getServicesList();
            $this->load->view('bus/grab_release.php', $data);
        }
    }

    function GetServiceList() {
        $date = $this->input->post('txtdate');
        $serno = $this->input->post('serno');
        $opid = $this->input->post('opid');
        // $ex1=  explode("/", $newDate);
        //$date=$ex1[2]."-".$ex1[1]."-".$ex1[0];
        $this->quota_update_model->ListOfService($date, $serno, $opid);
    }

    function GrabReleaseLayout() {
        $sernum = $this->input->post('sernum');
        $travel_id = $this->input->post('travel_id');
        $s = $this->input->post('s');
        $date = $this->input->post('txtdate');
        $this->quota_update_model->getLayoutOfGrabRelease($sernum, $travel_id, $s, $date);
    }

    function SaveGrabRelease() {
        $sernum = $this->input->post('service_num');
        $travel_id = $this->input->post('travel_id');
        $seats = $this->input->post('seat_names');
        $agent_type = $this->input->post('agent_type');
        $agent_id = $this->input->post('agent_id');
        $date = $this->input->post('date');
        $c = $this->input->post('c');
        // $ex1=  explode("/", $exdate);
        //$date=$ex1[2]."-".$ex1[1]."-".$ex1[0];
        if ($agent_type == 0) {
            $agent_id = 0;
        } else {
            $agent_id = $agent_id;
        }
        $this->quota_update_model->updateGrabRelease($sernum, $seats, $travel_id, $agent_type, $agent_id, $date, $c);
    }

    function DisplayLayoutForQuota() {
        $sernum = $this->input->post('sernum');
        $travel_id = $this->input->post('travel_id');
        $this->quota_update_model->display_LayoutOfQuota($sernum, $travel_id);
    }

    function GrabReleaseUpdatedLayout() {
        $sernum = $this->input->post('service_num');
        $travel_id = $this->input->post('travel_id');
        $date = $this->input->post('journey_date');

        $this->quota_update_model->display_LayoutOfGrabRelease($sernum, $travel_id, $date);
    }

    public function getservice() {
        $service = $this->createbus_model->getservic_modify();
        print_r($service);
    }

}

?>