<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Operator extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('operator1'); //calling the model
        $this->load->model('modellogin');
        $this->load->library('pagination');
        $this->load->library('table');
    }

    public function opr_reg() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['travel_id'] = $this->operator1->max_travelid();
            $this->load->view('operator/addoperator.php', $data);
        }
    }

    public function opr_reg1() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->operator1->opr_reg1_db();
        }
    }

    public function opr_regedit() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $this->operator1->opr_regedit_db();
        }
    }

    public function chkuser() {
        $this->operator1->chkuser_db();
    }

    public function layout() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['operators'] = $this->operator1->operators();
            $data['bustypes'] = $this->operator1->bustype();
            $data['seats_arrangement'] = $this->operator1->seats_arrangement();
            $this->load->view('operator/layout.php', $data);
        }
    }

    public function models() {
        $data = $this->operator1->models_db();
        return $data;
    }

    public function getlayout() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $data = $this->operator1->getlayout_db();
            return $data;
        }
    }

    public function insertlayout() {
        $data = $this->operator1->insertlayout_db();
        return $data;
    }

    public function board_drop_list() {

        $this->load->library('pagination');
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $config = array();
        $config["base_url"] = base_url() . "operator/board_drop_list";
        $config['total_rows'] = $this->operator1->board_drop_list_cnt();
        //print_r($config);
        $config['per_page'] = 25;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
        $data['list'] = $this->operator1->board_drop_list_db($config['per_page'], $page);
        $data["links"] = $this->pagination->create_links();
        $this->load->view('operator/board_drop_list.php', $data);
    }

    public function board_drop() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['cities'] = $this->operator1->cities();
        $this->load->view('operator/board_drop.php', $data);
    }

    public function board_drop_db() {
        $data = $this->operator1->board_drop_db1();
        return $data;
    }

    public function board_drop_edit() {
        $id = $this->input->get('id');
        //echo "$id";
        $data['cities'] = $this->operator1->cities();
        $data['getdata'] = $this->operator1->board_drop_edit_db($id);
        print_r($getdata);
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $this->load->view('operator/board_drop_edit.php', $data);

        return $data;
    }

    public function board_drop_edit1() {

        $data = $this->operator1->board_drop_edit_db1();
        return $data;
    }

    public function board_drop_delete() {
        $id = $this->input->get('id');
        $data = $this->operator1->board_drop_delete_db($id);
        $this->board_drop_list();
    }

    public function dashboard() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $this->load->view('operator/dashboard.php');
        }
    }

    public function dashboard1() {
        $data = $this->operator1->dashboard2();
        return $data;
    }

    public function month_booking() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $this->load->view('operator/month_booking.php');
        }
    }

    public function month_booking1() {
        $data = $this->operator1->month_booking2();
        return $data;
    }

    public function TicketReport() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $data = $this->operator1->TicketReport1();
            return $data;
        }
    }

    public function opr_edit() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['operators'] = $this->modellogin->get_operator();
            //$data['operators'] = $this->operator1->operators();
            $this->load->view('operator/editoperator_view.php', $data);
            //$this->load->view('operator/editoperator.php');
        }
    }

    public function opr_edit1() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $opid = $_POST['operators'];
            //echo "$opid";
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['data'] = $this->operator1->get_opr($opid);
            //var_dump($data);
            $this->load->view('operator/editoperator.php', $data);
        }
    }

    public function boardpoint_edit() {

        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['operators'] = $this->operator1->operators();
        $this->load->view('operator/board_point_edit.php', $data);
    }

    public function getservices() {

        $opid = $this->input->post('id');
        $service = $this->operator1->getser_num($opid);
        return $service;
    }

    public function getbplist() {

        $opid = $this->input->post('id');
        $service_num = $this->input->post('service_num');
        $service = $this->operator1->getbplist1($opid, $service_num);
        return $service;
    }

    public function getbplist_edit() {

        $id = $this->input->get('id');
        $data['board'] = $this->operator1->get_board_edit($id);
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $this->load->view('operator/board_point_edit_view.php', $data);
    }

    public function getbplist_delete() {

        $id = $this->input->get('id');
        $this->operator1->getbplist_delete_db($id);
        $this->boardpoint_edit();
    }

    public function getbplist_edit1() {


        $this->operator1->getbplist_edit_db1();
        $this->boardpoint_edit();
    }

    public function discount() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['operators'] = $this->operator1->operators();
        $this->load->view('discount_view', $data);
    }

    public function discount_con() {
        $this->operator1->discount_db();
    }

    public function convenience_charge() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['operators'] = $this->operator1->operators();
        $this->load->view('Convenience_Charge', $data);
    }

    public function getconv() {
        $data = $this->operator1->get_conv();
        return $data;
    }

    public function conv_give() {
        $data = $this->operator1->conv_give_db();
        return $data;
    }

    public function cancellation_sms() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
    }

    public function reactive_bus() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
    }

    public function terms() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['operators'] = $this->operator1->operators();
        $this->load->view('terms', $data);
    }

    public function terms_add() {
        $this->operator1->terms_add1();
    }

    public function url_routing() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['urls'] = $this->operator1->urls();
        $this->load->view('url_routing.php', $data);
    }

    public function url_routing1() {
        $res = $this->operator1->url_routing_db();
        return $res;
    }

    public function promocode() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['operators'] = $this->operator1->operators();
        $this->load->view('promocodes', $data);
    }

    public function getpromo1() {
        $res = $this->operator1->getpromo2();
        return $res;
    }

    public function add_promocode() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['operators'] = $this->operator1->operators();
        $this->load->view('add_promocode', $data);
    }

    public function promocodes_add() {
        $res = $this->operator1->promocodes_add1();
        return $res;
    }

    public function promocodes_update() {
        $id = $this->input->get('id');
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['details'] = $this->operator1->promocodes_update1($id);
        $data['operators'] = $this->operator1->operators();
        $this->load->view('update_promocode', $data);
    }

    public function promocodes_update2() {
        $res = $this->operator1->promocodes_update3();
        return $res;
    }
    public function update_vehicalasign(){
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['operators'] = $this->operator1->operators();
        $this->load->view('vehicalasign_update', $data);
        
    }
    public function getservices_vehi() {

        $opid = $this->input->post('id');
        $service = $this->operator1->getser_num_vehi($opid);
        return $service;
    }
    public function update_vehicalasign1(){
        $service = $this->operator1->update_vehicalasign2();
        return $service;
    }
	
	 public function terms_conditions() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['operators'] = $this->modellogin->get_operator();
            //$data['operators'] = $this->operator1->operators();
            $this->load->view('operator/terms_conditions_view.php', $data);
            //$this->load->view('operator/editoperator.php');
        }
    }
	
	 public function getTermsConditions() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $opid = $_POST['opid'];
			$data = $this->operator1->getTermsConditions_model($opid);
			echo $data;
        }
    }
	
	 public function saveTerms() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $opid = $_POST['opid'];
			$terms = $_POST['terms'];
			$data = $this->operator1->saveTerms_model($opid,$terms);
			echo $data;
        }
    }

}
