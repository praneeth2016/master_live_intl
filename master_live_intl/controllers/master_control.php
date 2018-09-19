<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_control extends CI_Controller {

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
        $this->load->helper('path');
        $this->load->model('modellogin'); //calling the model
        $this->load->model('bill_report');
        $this->load->library('pagination');
    }

    public function index() {

        //directs to the login view page
        $this->load->view('login');
    }

    public function loginCheck() {
        //checking the login credentials
        $username = $this->input->post('uname');
        $password = $this->input->post('pwd');
        if ($username == '' || $password == '') {

            $this->load->view('login');
        } else {

            $result = $this->modellogin->login($username, $password);
            //echo "$result";
            if ($result == 1) {//valid operator and status is activated
                $cookie = array(
                    'name' => 'autologin',
                    'value' => 'delete_cookie',
                    'expire' => 0,
                    'path' => 'http://ticketengine/master_panel/',
                );

                set_cookie($cookie);
                $data['title'] = 'home';
                $this->load->view('header.php', $data);
                $this->load->view('sidebar.php', $data);
            } else if ($result == 2) {//valid operator but status is Deactivated
                $data['status'] = "Your Account Not Activated!";
                $this->load->view('login', $data);
            } else {//Invalid operator credentials
                $data['status'] = "Invalid UserName OR Password!";
                $this->load->view('login', $data);
            }
        }
    }

    public function summary_op() {

        //directs to the view summary.php 

        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $this->load->view('summary.php');
        }
    }

    public function sum() {
        //shows the total count of operatots,activated and inactivated operators
        //calling the summary operators method from model
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $dat = $this->modellogin->summary_operators();

            $x = explode('|', $dat);

            $pen = $x[0] - $x[1];
            echo '<table align="center" cellspacing="15px" cellpadding="10px" style="margin: 0px auto;">
               <tr><th style="font-size:14px">Operator Summary</th></tr><tr><td style="font-size:12px">' . anchor("master_control/view_all", "Total Operators:") . '</td>
               <td style="font-size:12px">' . $x[0] . '</td></tr><tr><td style="font-size:12px">' . anchor("master_control/active_operator", "Activated Operators:") . '</td>
               <td style="font-size:12px">' . $x[1] . '</td></tr><tr><td style="font-size:12px">' . anchor("master_control/pend_operator", "Pending Operators:") . '</td>
               <td style="font-size:12px">' . $pen . '</td></tr></table>';
        }
    }

    public function view_all() {
        //show all operators
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->library('pagination');
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $config = array();
            $config['base_url'] = base_url() . '/master_control/view_all/';
            $config['total_rows'] = $this->modellogin->record_count();
            $config['per_page'] = 20;
            $config['uri_segment'] = 3;

            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
            $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);
            $data['query'] = $this->modellogin->all_operators($config['per_page'], $page);
            $data['links'] = $this->pagination->create_links();
            $this->load->view('view_operator', $data);
            //var_dump($data);
        }
    }

    public function active_operator() {
        //show active operators
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->library('pagination');
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $config = array();
            $config['base_url'] = base_url() . 'index.php/master_control/active_operator/';
            $config['total_rows'] = $this->modellogin->record_activecount();
            $config['per_page'] = 20;
            $config['uri_segment'] = 3;
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);

            $data['query'] = $this->modellogin->active_operators($config['per_page'], $page); //calls the active_operators method from model
            $data['links'] = $this->pagination->create_links();

            $this->load->view('view_active.php', $data);
        }
    }

    public function pend_operator() {
        //show pending operators
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->library('pagination');
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $config = array();
            $config['base_url'] = base_url() . 'index.php/master_control/pend_operator/';
            $config['total_rows'] = $this->modellogin->record_pend_count();
            $config['per_page'] = 20;
            $config['uri_segment'] = 3;
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);
            $data['query'] = $this->modellogin->pend_operators($config['per_page'], $page); //calls the pend_operators method from model
            $data['links'] = $this->pagination->create_links();
            $this->load->view('view_pend.php', $data);
        }
    }

    public function active_in() {

        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $uid = $this->input->get('id');
            $data = $this->modellogin->getstatus($uid);

            foreach ($data as $row) {
                $status1 = $row->status;
            }

            $result = $this->modellogin->active($uid, $status1); //calls the active method from model
            //echo " $result";
            if ($result == 1) {
                //echo "sussccful";
                $this->load->library('pagination');
                $this->load->view('header.php');
                $this->load->view('sidebar.php');
                $config = array();
                $config['base_url'] = base_url() . '/master_control/view_all/';
                $config['total_rows'] = $this->modellogin->record_count();
                $config['per_page'] = 10;
                $config['uri_segment'] = 3;
                $config['full_tag_open'] = '<div class="pagination">';
                $config['full_tag_close'] = '</div>';
                $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
                $this->pagination->initialize($config);
                $data['query'] = $this->modellogin->all_operators($config['per_page'], $page);
                $data['links'] = $this->pagination->create_links();
                $this->load->view('view_operator', $data);
            } else {
                echo 'Error!';
            }
        }
    }

    public function active_view() {

        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $uid = $this->input->get('id');
            $data = $this->modellogin->getviewstatus($uid);

            foreach ($data as $row) {
                $status1 = $row->central_agent;
            }

            $result = $this->modellogin->active_view($uid, $status1); //calls the active method from model
            //echo " $result";
            if ($result == 1) {
                //echo "sussccful";
                $this->load->library('pagination');
                $this->load->view('header.php');
                $this->load->view('sidebar.php');
                $config = array();
                $config['base_url'] = base_url() . '/master_control/view_all/';
                $config['total_rows'] = $this->modellogin->record_count();
                $config['per_page'] = 20;
                $config['uri_segment'] = 3;
                $config['full_tag_open'] = '<div class="pagination">';
                $config['full_tag_close'] = '</div>';
                $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
                $this->pagination->initialize($config);
                $data['query'] = $this->modellogin->active_operators($config['per_page'], $page);
                $data['links'] = $this->pagination->create_links();
                $this->load->view('view_operator', $data);
            } else {
                echo 'Error!';
            }
        }
    }

    public function view_detail($uid) {
        //show the details of the operator
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');

            $data['query'] = $this->modellogin->detail_operators($uid); //calls the detail_operators method from model
            $this->load->view('view_operator_detail.php', $data);
        }
    }

    public function operator_detail_update() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $this->modellogin->operator_detail_update_in_db();
        }
    }

    public function bus_model() {
        //show dropdown list of bus model
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['buses_model'] = $this->modellogin->bus(); //calling the bus method from model and storing data in array
            $this->load->view('busmodel.php', $data); //calling the bus model view page
        }
    }

    public function updatemodel() {
        //update and edit bus model
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $new = $this->input->post('n'); //posting the bus model of operator
            $old = $this->input->post('old'); //posting the id of bus model
            $type = $this->input->post('type');

            $result = $this->modellogin->update_model($new, $old, $type); //calls the update_model method from model
            if ($result == 1)
                echo "1";
            else
                echo 'not updated';
        }
    }

    public function addmodel() {
        //add new bus model
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $text = $this->input->post('text'); //posting the new bus model of operator 
            $text1 = $this->input->post('text1');
            $result = $this->modellogin->add_model($text, $text1); //calls the add_model method from model
            if ($result == 1)
                redirect('master_control/bus_model', 'refresh'); //refresh and redirect to bus_model method 
            else
                echo 'not updated';
        }
    }

	 public function load_city_view() {
        //show dropdown list of city
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['country'] = $this->modellogin->listCountryList(); //calling the cityadd method from model and storing data in array
            $this->load->view('cities.php', $data); //calling the cities model view page
        }
    }
	
	
	 public function load_stageorder_view() {
        //show dropdown list of city
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            
			 $data['operators'] = $this->modellogin->get_operator();
			 $data['routes'] = $this->modellogin->get_routes();
			 $data['stops'] = $this->modellogin->get_stops();
            $this->load->view('StageOrder.php', $data); //calling the cities model view page
        }
    }
	
	public function getCitiesListForCountry() {
        $cities = $this->modellogin->getCitiesListForCountryModel();
		print_r($cities);
        
    }
	public function getStageOrder() {
        $cities = $this->modellogin->getStageOrderModel();
		print_r($cities);
        
    }
	
	public function saveStageOrder() {
       if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
           $result = $this->modellogin->saveStageOrderModel(); //calls the add_cities method from model
            if ($result == 1) {
                echo "<script>javascript:alert('Inserted Successfully');</script>";
                print "<script type=\"text/javascript\">window.location = '" . base_url('master_control/load_stageorder_view') . "'</script>";
                //redirect('master_control/add_city', 'refresh');
            }
            if ($result == 2) {
                echo "<script>javascript:alert('This Route Already Exists');</script>";
                print "<script type=\"text/javascript\">window.location = '" . base_url('master_control/load_stageorder_view') . "'</script>";
                //redirect('master_control/add_city', 'refresh');	
            } else {
                echo "<script>javascript:alert('Problem in insertion');</script>";
                print "<script type=\"text/javascript\">window.location = '" . base_url('master_control/load_stageorder_view') . "'</script>";
                //echo 'not updated';
            }
        }
        
    }
	
	
	
    public function add_city() {
        //show dropdown list of city
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['city'] = $this->modellogin->cityadd(); //calling the cityadd method from model and storing data in array
            $this->load->view('cities.php', $data); //calling the cities model view page
        }
    }
	 public function add_country() {
        //show dropdown list of city
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['country'] = $this->modellogin->countryadd(); //calling the cityadd method from model and storing data in array
            $this->load->view('countries.php', $data); //calling the cities model view page
        }
    }

    public function updatecity() {
        //edit and update new city
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
			$country = $this->input->post('country');
            $new = $this->input->post('new'); //post the new city of operator
            $old = $this->input->post('old'); //post the old city
            $result = $this->modellogin->update_city($new, $old,$country); //calls the update_city method from model
            if ($result == 1)
                echo "1";
            else
                echo 'not updated';
        }
    }
	public function updatecountry() {
        //edit and update new city
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $new = $this->input->post('new'); //post the new city of operator
            $old = $this->input->post('old'); //post the old city
            $result = $this->modellogin->update_country($new, $old); //calls the update_city method from model
            if ($result == 1)
                echo "1";
            else
                echo 'not updated';
        }
    }

    public function addcity() {
        //add new city
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $text = $this->input->post('text'); //post the new added city of operator 
			$country_name = $this->input->post('country_name');
			
            $result = $this->modellogin->add_cities($text,$country_name); //calls the add_cities method from model
            if ($result == 1) {
                echo "<script>javascript:alert('City Inserted Successfully');</script>";
                print "<script type=\"text/javascript\">window.location = '" . base_url('master_control/load_city_view') . "'</script>";
                //redirect('master_control/add_city', 'refresh');
            }
            if ($result == 2) {
                echo "<script>javascript:alert('City Name Already Exists');</script>";
                print "<script type=\"text/javascript\">window.location = '" . base_url('master_control/load_city_view') . "'</script>";
                //redirect('master_control/add_city', 'refresh');	
            } else {
                echo "<script>javascript:alert('Not Updated');</script>";
                print "<script type=\"text/javascript\">window.location = '" . base_url('master_control/load_city_view') . "'</script>";
                //echo 'not updated';
            }
        }
    }
	
	 public function addcountry() {
        //add new city
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $text = $this->input->post('text'); //post the new added city of operator 
            $result = $this->modellogin->add_countries($text); //calls the add_cities method from model
            if ($result == 1) {
                echo "<script>javascript:alert('Country Inserted Successfully');</script>";
                print "<script type=\"text/javascript\">window.location = '" . base_url('master_control/add_country') . "'</script>";
                //redirect('master_control/add_country', 'refresh');
            }
            if ($result == 2) {
                echo "<script>javascript:alert('Country Name Already Exists');</script>";
                print "<script type=\"text/javascript\">window.location = '" . base_url('master_control/add_country') . "'</script>";
                //redirect('master_control/add_country', 'refresh');	
            } else {
                echo "<script>javascript:alert('Not Updated');</script>";
                print "<script type=\"text/javascript\">window.location = '" . base_url('master_control/add_country') . "'</script>";
                //echo 'not updated';
            }
        }
    }

    public function bus_type() {
        //show dropdown list of bus type
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['bus_type'] = $this->modellogin->bustypes(); //calling the bustypes method from model and storing data in array
            $this->load->view('bustype.php', $data); //calling the bus type view page
        }
    }

    public function updatebustype() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            //edit and update bus type
            $new = $this->input->post('new'); //post the new bus type of operator
            $old = $this->input->post('old'); //post the old bus type
            $result = $this->modellogin->update_bus($new, $old); //calls the update_bus method from model
            if ($result == 1)
                echo "1";
            else
                echo 'not updated';
        }
    }

    public function addbus() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            //add new bus type
            $text = $this->input->post('text'); //post the new added bus type of operator 
            $result = $this->modellogin->add_bustype($text); //calls the add_bustype method from model
            if ($result == 1)
                redirect('master_control/bus_type', 'refresh'); //refresh and redirects to bus_type method
            else
                echo 'not added';
        }
    }

    public function seat_arr() {
        //show dropdown list of seating arrangement
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['seat'] = $this->modellogin->seatarr(); //calling the seatarr method from model and storing data in array
            $this->load->view('seating.php', $data); //calling the seating arrangement view page
        }
    }

    public function updateseat() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            //edit and update seat arrangement
            $new = $this->input->post('new'); //post the new seat type of operator
            $old = $this->input->post('old'); //post the old seat type
            $result = $this->modellogin->update_seat($new, $old); //calls the update_seat method from model
            if ($result == 1)
                echo "1";
            else
                echo 'not updated';
        }
    }

    public function addseat() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            //add new seat arrangement
            $text = $this->input->post('text'); //post the new added seat of operator 
            $result = $this->modellogin->add_seatarr($text); //calls the add_seatarr method from model
            if ($result == 1)
                redirect('master_control/seat_arr', 'refresh'); //refresh and redirects to seat_arr method
            else
                echo 'not added';
        }
    }

    public function logout() {
        //destroying the session
        $this->session->sess_destroy();
        $this->session->set_userdata(array('logged_in' => FALSE));
        $this->db->cache_delete_all();
        $this->load->view('login');
        delete_cookie('autologin', null, null, $this->config->item('cookie_prefix'));
    }

    public function generateReport() {

        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['operators'] = $this->modellogin->get_operator();
            $this->load->view('reports_view', $data);
        }
    }

    public function generatebillReport() {

        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['operators'] = $this->modellogin->get_operator();
            $this->load->view('billreports_view', $data);
        }
    }

    public function GetReport() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->library('pagination');
            $this->load->library('table');
            $config = array();
            $config['page_query_string'] = 'TRUE';
            if (count($_GET) > 0)
                $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['base_url'] = base_url() . 'index.php/master_control/GetReport/';
            $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
            $config['total_rows'] = $this->modellogin->displayReports(0, 0);
            $config['per_page'] = 25;
            $config['uri_segment'] = 3;
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
            $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);
            $data['query1'] = $this->modellogin->displayReports($page, $config['per_page']);
            $data['links'] = $this->pagination->create_links();
            $this->load->view('booking_total_reports.php', $data);
        }
    }

    public function GetbillReport() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $opid = $this->input->get('opid');
            $from = $this->input->get('from');
            $to = $this->input->get('to');
            $agentype = $this->input->get('agentype');
            $ag_name = $this->input->get('ag_name');
//echo $opid . " - " . $from . " - " . $to . " - " . $ag_name. "-" . $agentype."<br />";
            //echo "$opid";
            //echo "abc";        
            $data1['query'] = $this->bill_report->displayReports($opid, $from, $to, $ag_name, $agentype);
           
            $data1['query1'] = $this->bill_report->displayCanReports($opid, $from, $to, $ag_name, $agentype);
            
            $this->load->view('billing_total_reports.php', $data1);
        }
    }

    function getDownload() {
        $format = $this->input->get('output1');
        $data = $this->modellogin->get_tabledata_from_db();
        if ($format == "csv") {
            $this->load->dbutil();
            $delimiter = "\t";
            $newline = "\r\n";
            $da = $this->dbutil->csv_from_result($data, $delimiter, $newline);
            if ($da)
                echo force_download('file' . date("Y-m-d H:i") . '.csv', $da);
        }
        else if ($format == "xls") {
            $this->load->dbutil();
            $delimiter = "\t";
            $newline = "\r\n";
            $da = $this->dbutil->csv_from_result($data, $delimiter, $newline);
            if ($da)
                echo force_download('export' . date("Y-m-d H:i") . '.xls', $da);
        }
    }

    function exportbillreport() {
        $format = $this->input->get('output1');
        $data = $this->bill_report->billreport_confirm();
        $data1 = $this->bill_report->billreport_cancel();
        if ($format == "csv") {
            $this->load->dbutil();
            $delimiter = "\t";
            $newline = "\r\n";
            $da = $this->dbutil->csv_from_result($data, $delimiter, $newline);
            $da1 = $this->dbutil->csv_from_result($data1, $delimiter, $newline);
            if ($da)
                echo force_download('file' . date("Y-m-d H:i") . '.csv', $da . "\r\n\r\n\r\n" . $da1);
        }
        else if ($format == "xls") {
            $this->load->dbutil();
            $delimiter = "\t";
            $newline = "\r\n";
            $da = $this->dbutil->csv_from_result($data, $delimiter, $newline);
            $da1 = $this->dbutil->csv_from_result($data1, $delimiter, $newline);
            if ($da)
                echo force_download('export' . date("Y-m-d H:i") . '.xls', $da . "\r\n\r\n\r\n" . $da1);
        }
    }

    function summary_records() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $this->load->view('bookingreports');
        }
    }

    function book_summary() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $i = $this->input->post('i');
            $this->modellogin->get_bookings_from_db($i);
        }
    }

    function api_agents() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $this->load->view('apiAgents_view');
        }
    }

    function ShowApioperators() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $list = $this->input->post('list');

            $operator = $this->modellogin->get_operator_from_db($list);
            $op_id = 'id="operator" style="width:150px; font-size:12px" onChange="agentlist()"';
            echo form_dropdown('operator_list', $operator, "", $op_id);
        }
    }

    function ShowOpdetail() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->modellogin->get_operator_agent_from_db();
        }
    }

    function ShowApiData() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->modellogin->get_api_table_from_db();
        }
    }

    function UpdateDet() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $uid = $this->input->get('id');
            $data['query'] = $this->modellogin->get_details_from_db($uid);
            //var_dump($data);
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            //$this->load->view('Edit_details', $data);
            //$this->load->view('Edit_details1', $data);
            $this->load->view('update_api_agents', $data);
        }
    }

    function Updatedetails() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $this->modellogin->update_details_db();
        }
    }

    function addnewagent() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data2['location'] = $this->modellogin->get_citylist_from_db();
            $this->load->view('add_agent.php', $data2);
        }
    }

    public function get_agent_formdetails() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $now = date("Y-m-d");
            $ip = $this->input->ip_address();
            $username = trim($this->input->post('username'));
            $limit = $this->input->post('limit');
            $paytype = $this->input->post('payment_type');
            if ($paytype == 'prepaid') {
                $data = array(
                    'name' => $this->input->post('name'),
                    'uname' => trim($this->input->post('username')),
                    'password' => trim($this->input->post('password')),
                    'email' => $this->input->post('email_address'),
                    'mobile' => $this->input->post('contact'),
                    'city' => $this->input->post('locat'),
                    'address' => $this->input->post('address'),
                    'agent_type' => $this->input->post('agent_type'),
                    'agent_type_name' => $this->input->post('agent_type_name'),
                    'pay_type' => $paytype,
                    'api_key' => 'TE' . $this->input->post('api_key'),
                    'margin' => $this->input->post('margin'),
                    'api_type' => 'te',
                    'bal_limit' => '-' . $limit,
                    'ip' => $ip,
                    'date' => $now,
                    'status' => 1,
                );
            } else if ($paytype == 'postpaid') {
                $data = array(
                    'name' => $this->input->post('name'),
                    'uname' => $this->input->post('user_name'),
                    'password' => $this->input->post('password'),
                    'email' => $this->input->post('email_address'),
                    'mobile' => $this->input->post('contact'),
                    'city' => $this->input->post('locat'),
                    'address' => $this->input->post('address'),
                    'agent_type' => $this->input->post('agent_type'),
                    'agent_type_name' => $this->input->post('agent_type_name'),
                    'pay_type' => $paytype,
                    'margin' => $this->input->post('margin'),
                    'api_type' => 'te',
                    'api_key' => 'TE' . $this->input->post('api_key'),
                    'bal_limit' => $limit,
                    'ip' => $ip,
                    'date' => $now,
                    'status' => 1,
                );
            }
            $result = $this->modellogin->store_agent($data, $username);

            echo $result;
        }
    }

    public function inhouse_agents() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['query'] = $this->modellogin->get_agentslist_db('1');
            $data['operators'] = $this->modellogin->get_operator();
            $this->load->view('inhouse_agents_list', $data);
        }
    }

    public function view_inhouse() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $uid = $this->input->get('uid');
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['query'] = $this->modellogin->detail_agents($uid);
            $this->load->view('view_inhouse_agent.php', $data);
        }
    }

    function update_status() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $status = $this->input->post('status');
            $id = $this->input->post('id');
            $this->modellogin->status_update($id, $status);
        }
    }

    function Apioperators() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $list = $this->input->post('operator');

            $operator = $this->modellogin->get_operator($list);
            $op_id = 'id="operators" style="width:150px; font-size:12px" onChange="ChangeData()"';
            echo form_dropdown('operator_lists', $operator, "", $op_id);
        }
    }

    function ShowSummary() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $i = $this->input->post('i');
            $op = $this->input->post('op');
            $this->modellogin->get_summary_from_db($op, $i);
        }
    }

    function ShowAgent() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $agentn = $this->input->post('agent');
            $agent_type = $this->input->post('agenttype');
            $agent = $this->modellogin->getAgentName($agentn, $agent_type);
            $agentid = 'id="agent" style="width:150px; font-size:12px"';
            $agent_name = 'name="agent"';
            echo form_dropdown($agent_name, $agent, "", $agentid);
        }
    }

    function ShowAgent1() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            //$agentn=  $this->input->post('agent');
            $opid = $this->input->post('id');
            $agent_type = $this->input->post('agenttype');
            $agent = $this->modellogin->getAgentName1($agent_type, $opid);
            $agentid = 'id="agent" style="width:100px; font-size:12px"';
            $agent_name = 'name="agent"';
            echo form_dropdown($agent_name, $agent, "", $agentid);
        }
    }

    function postpaid_agents() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['query'] = $this->modellogin->get_postagentslist_db('2');
            $data['operators'] = $this->modellogin->get_operator();
            $this->load->view('postpaid_agents_list', $data);
        }
    }

    function status_change_postpaid() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $status = $this->input->post('status');
            $id = $this->input->post('id');
            $this->modellogin->status_postpaid($id, $status);
        }
    }

    public function view_postpaid() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $uid = $this->input->get('uid');
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['query'] = $this->modellogin->detail_agents($uid);
            $this->load->view('view_postpaid_agent.php', $data);
        }
    }

    function prepaid_agents() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['query'] = $this->modellogin->get_preagentslist_db('2');
            $data['operators'] = $this->modellogin->get_operator();
            $this->load->view('prepaid_agents_list', $data);
        }
    }

    function prepaid_change_status() {

        $status = $this->input->post('status');
        $id = $this->input->post('id');
        $this->modellogin->status_prepaid($id, $status);
    }

    public function view_prepaid() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $uid = $this->input->get('uid');
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['query'] = $this->modellogin->detail_agents($uid);
            $this->load->view('view_prepaid_agent.php', $data);
        }
    }

    function getPrepaid_db() {
        $this->modellogin->prepaid_agents_db(2);
    }

    function getPostpaid_db() {
        $this->modellogin->postpaid_agents_db(2);
    }

    function getBranch_db() {
        $this->modellogin->Branch_agents_db(1);
    }

//billing amount
    function BillingCollect() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $this->load->view('billedView.php');
    }

    function getBilledValue() {
        $this->modellogin->getBilledValue_detail();
    }

    function updatePayment() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
    }

    function Operator_wise_Data() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $this->load->view('operatorWise_Data.php');
    }

    function display_operatorWise_report() {
        $this->modellogin->getoperatorWise_report();
    }

    function Operator_Service() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $result['opname'] = $this->modellogin->get_operator();
        $this->load->view('operator_services_details.php', $result);
    }

    function Operator_Service_details() {
        $this->modellogin->getOperator_Service_report();
    }

    function Service_bording_details() {
        $this->modellogin->getOperator_Service_bording_details();
    }

    function Service_eminities_details() {
        $this->modellogin->getOperator_Service_eminities_details();
    }

    function Service_Layout_details() {
        $this->modellogin->getOperator_Service_Layout_details();
    }

    function BusType_wise_analysis() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['operators'] = $this->modellogin->get_operator();
        $this->load->view('bustype_analysis.php', $data);
    }

    function display_bustype_report() {

        $this->modellogin->busAnalysis();
    }

    function route_wise_Data() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $result['opname'] = $this->modellogin->get_operator();
        $this->load->view('operator_route_details.php', $result);
    }

    function operator_Route_details() {
        $this->modellogin->getOperator_route_details();
    }

    function refundCancelAmount() {
        $data = $this->input->post("data");
        $cnt = $this->input->post("cnt");

        //print "data is : ".$data." - cnt is : ".$cnt;

        if ($data == '') {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
        }

        $this->load->model('refund_model');
        $this->load->library('pagination');
        $this->load->library('table');
        $config = array();
        $config['base_url'] = base_url() . 'index.php/master_control/refundCancelAmount/';
        $config['total_rows'] = $this->refund_model->get_CancelDetails(0, 0, $data);
        $config['per_page'] = 7;
        $config['uri_segment'] = 3;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);
        $result['query1'] = $this->refund_model->get_CancelDetails($page, $config['per_page'], $data);
        $result['links'] = $this->pagination->create_links();
        $result['data'] = $data;

        if ($cnt != '') {
            $result['k'] = $cnt + 1;
        } else {
            $result['k'] = 0;
        }

        $this->load->view('Refund_view2.php', $result);
    }

    function refundServiceCancel() {
        $data = $this->input->post("data");
        $cnt = $this->input->post("cnt");

        //print "data is : ".$data." - cnt is : ".$cnt;

        if ($data == '') {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
        }

        $this->load->model('refund_model');
        $this->load->library('pagination');
        $this->load->library('table');
        $config = array();
        $config['base_url'] = base_url() . 'index.php/master_control/refundServiceCancel/';
        $config['total_rows'] = $this->refund_model->get_ServiceCancelDetails(0, 0, $data);
        $config['per_page'] = 7;
        $config['uri_segment'] = 3;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);
        $result['query1'] = $this->refund_model->get_ServiceCancelDetails($page, $config['per_page'], $data);
        $result['links'] = $this->pagination->create_links();
        $result['data'] = $data;

        if ($cnt != '') {
            $result['k'] = $cnt + 1;
        } else {
            $result['k'] = 0;
        }

        $this->load->view('Refund_view3.php', $result);
    }

    function do_amountRefund() {
        $this->load->model('refund_model');
        $this->refund_model->do_amountRefundupdate();
    }

    function do_service_amountRefund() {
        $this->load->model('refund_model');
        $this->refund_model->do_Refundupdate();
    }

    function show_ser_RefundFormdata() {
        $this->load->model('refund_model');
        $this->refund_model->show_ser_RefundForm_data();
    }

    function showRefundFormdata() {
        $this->load->model('refund_model');
        $this->refund_model->show_ser_RefundForm_data();
    }

    function Operator_Service_cancelTerm() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $result['opname'] = $this->modellogin->get_operator_from_db();
        $this->load->view('cancellationTerm.php', $result);
    }

    function get_cancelTerm_OfOperator() {
        $this->modellogin->get_cancelTerm_OfOperator_from_db();
    }

    function update_contact_number() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['query'] = $this->modellogin->get_sms_cont();
            $data['operators'] = $this->modellogin->get_operator();

            $this->load->view('update_contact', $data);
        }
    }

    function view_apisms_update() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $uid = $this->input->post(op);

            $this->modellogin->get_sms_cont2($uid);
        }
    }

    function update_api_status() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $status = $this->input->post('status');
            $id = $this->input->post('id');
            $this->modellogin->status_api_update($id, $status);
        }
    }

    function edit_apisms() {
        $uid = $this->input->get('uid');
        $is_api_sms = $this->input->get('is_api_sms');
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['query'] = $this->modellogin->get_sms_cont3($uid);
        $data['status'] = $is_api_sms;
        //var_dump($data);
        $this->load->view(edit_sms, $data);
    }

    function modify_apisms() {
        //echo "comeing";
        $this->modellogin->status_modify_apisms();
    }

    public function proceedDetail() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $data = $this->input->post("data");
            $cnt = $this->input->post("cnt");

            //print "data is : ".$data." - cnt is : ".$cnt;

            if ($data == '') {
                $this->load->view('header.php');
                $this->load->view('sidebar.php');
            }

            $this->load->model('proceeddetails_model');
            $this->load->library('pagination');
            $this->load->library('table');
            $config = array();
            $config['base_url'] = base_url() . 'index.php/master_control/proceedDetail/';
            $config['total_rows'] = $this->proceeddetails_model->get_proceedDetails(0, 0, $data);
            $config['per_page'] = 15;
            $config['uri_segment'] = 3;
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
            $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);
            $result['query1'] = $this->proceeddetails_model->get_proceedDetails($page, $config['per_page'], $data);
            $result['links'] = $this->pagination->create_links();
            $result['data'] = $data;

            if ($cnt != '') {
                $result['k'] = $cnt + 1;
            } else {
                $result['k'] = 0;
            }

            $this->load->view('proceed_detail_view.php', $result);
        }
    }

    public function apiproceedDetail() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $data = $this->input->post("data");
            $cnt = $this->input->post("cnt");

            //print "data is : ".$data." - cnt is : ".$cnt;

            if ($data == '') {
                $this->load->view('header.php');
                $this->load->view('sidebar.php');
            }

            $this->load->model('proceeddetails_model');
            $this->load->library('pagination');
            $this->load->library('table');
            $config = array();
            $config['base_url'] = base_url() . 'index.php/master_control/apiproceedDetail/';
            $config['total_rows'] = $this->proceeddetails_model->get_proceedDetails(0, 0, $data);
            $config['per_page'] = 15;
            $config['uri_segment'] = 3;
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
            $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);
            $result['query1'] = $this->proceeddetails_model->get_apiproceedDetails($page, $config['per_page'], $data);
            $result['links'] = $this->pagination->create_links();
            $result['data'] = $data;

            if ($cnt != '') {
                $result['k'] = $cnt + 1;
            } else {
                $result['k'] = 0;
            }

            $this->load->view('apiproceed_detail_view.php', $result);
        }
    }

    public function show_Passanger_proceedDetail() {
        $this->load->model('proceeddetails_model');
        $result['query1'] = $this->proceeddetails_model->get_show_Passanger_proceedDetails();
        $this->load->view('passanger_detail.php', $result);
    }

    public function show_Passanger_apiproceedDetail() {
        $this->load->model('proceeddetails_model');
        $result['query1'] = $this->proceeddetails_model->get_show_Passanger_apiproceedDetails();
        $this->load->view('apipassanger_detail.php', $result);
    }

    public function bookingDetail() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $data = $this->input->post("data");
            $cnt = $this->input->post("cnt");

            if ($data == '') {
                $this->load->view('header.php');
                $this->load->view('sidebar.php');
            }

            $this->load->model('bookingdetails_model');
            $this->load->library('pagination');
            $this->load->library('table');
            $config = array();
            $config['base_url'] = base_url() . 'index.php/master_control/bookingDetail/';
            $config['total_rows'] = $this->bookingdetails_model->get_bookingDetails(0, 0, $data);
            $config['per_page'] = 15;
            $config['uri_segment'] = 3;
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
            $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);
            $result['query1'] = $this->bookingdetails_model->get_bookingDetails($page, $config['per_page'], $data);
            $result['links'] = $this->pagination->create_links();
            $result['data'] = $data;

            if ($cnt != '') {
                $result['k'] = $cnt + 1;
            } else {
                $result['k'] = 0;
            }

            $this->load->view('booking_detail_view.php', $result);
        }
    }

    public function show_Passanger_bookingDetail() {
        $this->load->model('bookingdetails_model');
        $result['query1'] = $this->bookingdetails_model->get_show_Passanger_bookingDetails();

        $this->load->view('bookingPassanger_details.php', $result);
    }

    public function sendsms() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $result['opname'] = $this->modellogin->get_operator1();
            $this->load->view('sendsms.php', $result);
        }
    }

    function apiwise_report() {
        $this->modellogin->apiwise_report();
    }

    function sendsms_apiagent() {
        $this->modellogin->sms_sent();
    }

    function depositHistory() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $result['query'] = $this->modellogin->depositHistory();
            $this->load->view('depositHistory.php', $result);
        }
    }

    function depositDetail() {
        $this->modellogin->getDepositHistory();
    }

    function depositUpdate() {
        $this->modellogin->depositUpdate();
    }

    function te_agents() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['query'] = $this->modellogin->get_teagentslist_db();
            $this->load->view('te_agent/te_agents_list', $data);
        }
    }

    public function active_new_agent() {

        $status = $this->input->post('status');
        $id = $this->input->post('id');
        $this->modellogin->status_teagent($id, $status);
    }

    public function addteagent() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data2['location'] = $this->modellogin->get_citylist_from_db();
            $data2['branch'] = $this->modellogin->get_branchlist_from_db();
            $this->load->view('te_agent/add_te_agent.php', $data2);
        }
    }

    public function checkUser() {
        $user = $this->input->post('uname');
        $data = $this->modellogin->check_user($user);
        echo $data;
    }

    public function get_postpaid_agent_formdetails() {
        $now = date("Y-m-d");
        $ip = $this->input->ip_address();
        $username = trim($this->input->post('username'));
        $limit = $this->input->post('limit');
        $paytype = $this->input->post('payment_type');

        $data = array(
            'appname' => $this->input->post('bname'),
            'name' => $this->input->post('name'),
            'uname' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'email' => $this->input->post('email_address'),
            'mobile' => $this->input->post('contact'),
            'city' => $this->input->post('locat'),
            'address' => $this->input->post('address'),
            'operator_id' => "all",
            'agent_type' => $this->input->post('agent_type'),
            'agent_type_name' => $this->input->post('agent_type_name'),
            'date' => $now,
            'status' => 1,
            'ip' => $ip,
            'margin' => $this->input->post('margin'),
            'pay_type' => $paytype,
            'bal_limit' => '-' . $limit,
            'api_type' => $this->input->post('api_type'),
            'land_line' => $this->input->post('landline'),
            'allow_cancellation' => $this->input->post('allowcanc'),
            'allow_modification' => $this->input->post('allowmodification'),
            'branch' => $this->input->post('branch'),
            'branch_address' => $this->input->post('branchAddress'),
            'payment_reports' => $this->input->post('payment_reports'),
            'booking_reports' => $this->input->post('booking_reposts'),
            'passenger_reports' => $this->input->post('pass_reports'),
            'vehicle_assignment' => $this->input->post('vehicle_ass'),
            'ticket_booking' => $this->input->post('ticket_booking'),
            'check_fare' => $this->input->post('checkfare'),
            'ticket_status' => $this->input->post('ticket_status'),
            'ticket_cancellation' => $this->input->post('ticket_canc'),
            'ticket_modify' => $this->input->post('ticket_modify'),
            'board_passenger_reports' => $this->input->post('boardpass'),
            'ticket_reschedule' => $this->input->post('ticket_reschedule'),
            'group_boarding_passenger_reports' => $this->input->post('groupboardpass'),
            'margin1' => $this->input->post('margin'),
            'pay_type1' => $paytype,
            'bal_limit1' => '-' . $limit,
        );

        // echo $limit;
        $result = $this->modellogin->store_agent($data, $username);
        echo $result;
    }

    public function edit_te() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $uid = $this->input->get('uid');
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['query'] = $this->modellogin->detail_agents($uid);
            $data['location'] = $this->modellogin->get_citylist_from_db();
            $data['branch'] = $this->modellogin->get_branchlist_from_db();
            $this->load->view('te_agent/edit_te_agent.php', $data);
        }
    }

    public function update_agent_formdetails1() {

        $result = $this->modellogin->update_agent();

        echo $result;
    }

    public function update_agent_formdetails2() {

        $result = $this->modellogin->update_agent2();

        echo $result;
    }

    public function operator_commission() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['agent'] = $this->modellogin->get_te_agent_list();
            $data['operator'] = $this->modellogin->get_operator_list();
            $this->load->view('te_agent/operator_commission.php', $data);
        }
    }

    public function add_commission() {
        $data = $this->modellogin->add_commission1();
        echo $data;
    }

    public function Add_gents() {

        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        //echo "abc";
        $data['operators'] = $this->modellogin->get_operator();
        $this->load->view('add_new_agent', $data);
    }

    public function Add_agents1() {
        //echo "abc";
        $this->modellogin->add_agents_db();
    }

    public function api_sms_history() {

        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $date = date('Y-m-j');
            $newdate = strtotime('-10 day', strtotime($date));
            $newdate = date('Y-m-j', $newdate);


            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $config = array();
            $config["base_url"] = base_url() . "master_control/api_sms_history";
            $config['total_rows'] = $this->modellogin->api_sms_count($newdate, $date);
            //print_r($config);
            $config['per_page'] = 15;
            $config['uri_segment'] = 3;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
            $data["sms_api"] = $this->modellogin->get_api_sms($config['per_page'], $page, $newdate, $date);
            $data["links"] = $this->pagination->create_links();
            $this->load->view('api_sms_status.php', $data);
        }
    }

    public function grab_rels_history() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['operators'] = $this->modellogin->get_operator();
            $this->load->view('Grab_rels_status.php', $data);
        }
    }

    public function get_grab_rels_history() {

        //$opid = $_POST['operators'];
        $opid = $this->input->get('operators');
        $data['data'] = $this->modellogin->get_grab($opid);
        //echo $opid;
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $config = array();
        $config["base_url"] = base_url() . "/master_control/get_grab_rels_history?operators=$opid";
        $config['total_rows'] = $this->modellogin->grab_rels_count($opid);
        //print_r($config);
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
        $data["grab"] = $this->modellogin->get_grab($config['per_page'], $page, $opid);
        $data["links"] = $this->pagination->create_links();
        $this->load->view('Grab_rels_status1.php', $data);
    }

    public function quota_history() {

        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->modellogin->get_quota_res();
        }
    }

    public function citrus_resp() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $date = date('Y-m-j');
            $newdate = strtotime('-10 day', strtotime($date));
            $newdate = date('Y-m-j', $newdate);

            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $config = array();
            $config["base_url"] = base_url() . "master_control/citrus_resp";
            $config['total_rows'] = $this->modellogin->citres_count();
            //print_r($config);
            $config['per_page'] = 40;
            $config['uri_segment'] = 3;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;

            $data['cit_res'] = $this->modellogin->get_citrus_res($config['per_page'], $page);
            $data["links"] = $this->pagination->create_links();
            $this->load->view('citrus_res.php', $data);
        }
    }

    public function agent_topup() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $config = array();
            $config["base_url"] = base_url() . "master_control/agent_topup";
            $config['total_rows'] = $this->modellogin->cnt_top();
            //print_r($config);
            $config['per_page'] = 15;
            $config['uri_segment'] = 3;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
            $data['topup'] = $this->modellogin->get_topup($config['per_page'], $page);
            $data["links"] = $this->pagination->create_links();
            $this->load->view('topup.php', $data);
        }
    }

    public function vihical_asign() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {

            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $config = array();
            $config["base_url"] = base_url() . "master_control/vihical_asign";
            $config['total_rows'] = $this->modellogin->vehical_cnt();
            //print_r($config);
            $config['per_page'] = 15;
            $config['uri_segment'] = 3;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
            $data['data'] = $this->modellogin->get_vehical_asign($config['per_page'], $page);
            $data["links"] = $this->pagination->create_links();
            $this->load->view('vihical_asign.php', $data);
        }
    }

    public function get_dup_city() {

        $res = $this->modellogin->get_dup_citydb();
    }

    function update_cancel_sms_number() {

        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            //$data['query'] = $this->modellogin->get_sms_cont();
            $data['operators'] = $this->modellogin->get_operator();

            $this->load->view('update_cancel_sms_contact', $data);
        }
    }

    function view_api_can_sms_update() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $uid = $this->input->post(op);

            $this->modellogin->get_can_sms_cont_db($uid);
        }
    }

    function edit_api_can_sms() {
        $uid = $this->input->get('uid');
        $api_can_sms = $this->input->get('api_can_sms');
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['query'] = $this->modellogin->get_sms_cont3($uid);
        $data['status'] = $api_can_sms;
        //var_dump($data);
        $this->load->view(edit_api_can_sms, $data);
    }

    function modify_api_can_sms() {
        //echo "comeing";
        $this->modellogin->status_modify_api_can_sms();
    }

    public function active_view_home() {

        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $uid = $this->input->get('id');
            $data = $this->modellogin->getviewstatus($uid);
            //print_r($data);
            foreach ($data as $row) {
                $status1 = $row->home_page;
            }
            //echo "$status1";

            $result = $this->modellogin->active_view_home1($uid, $status1); //calls the active method from model
            //echo " $result";
            if ($result == 1) {
                //echo "sussccful";
                $this->load->library('pagination');
                $this->load->view('header.php');
                $this->load->view('sidebar.php');
                $config = array();
                $config['base_url'] = base_url() . '/master_control/view_all/';
                $config['total_rows'] = $this->modellogin->record_count();
                $config['per_page'] = 20;
                $config['uri_segment'] = 3;
                $config['full_tag_open'] = '<div class="pagination">';
                $config['full_tag_close'] = '</div>';
                $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
                $this->pagination->initialize($config);
                $data['query'] = $this->modellogin->active_operators($config['per_page'], $page);
                $data['links'] = $this->pagination->create_links();
                $this->load->view('view_active', $data);
            } else {
                echo 'Error!';
            }
        }
    }

    public function operator_Special_Service() {
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['operators'] = $this->modellogin->get_operator_from_db();
        $this->load->view('special_service', $data);
    }

    public function getservice() {

        $service = $this->modellogin->getservic_modify();
        echo $service;
    }

    public function servicesListActiveOrDeactive() {
        $this->modellogin->get_special_services_db();
    }

    public function get_special_services() {

        $data = $this->modellogin->get_special_services_db();
        return $data;
    }

    function getForwordBookingDays() {

        $servtype = $this->input->post('servtype');

        $travid = $this->input->post('travid');
        $s = $this->input->post('s');
        $svc = $this->input->post('svc');
        $fromid = $this->input->post('fromid');
        $toid = $this->input->post('toid');
        $stat = $this->input->post('status');
        $data = $this->modellogin->getForwordBookingDaysFromDb($travid);
        $current_date = date('Y-m-d');
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
            $output = "";
            $sql = $this->db->query("SELECT DISTINCT journey_date FROM `buses_list` WHERE travel_id='$travid' and STATUS='1' and service_num='$svc' and journey_date >= '$current_date'");
            if ($sql->num_rows() > 0) {
                foreach ($sql->result() as $row) {
                    $jdate = $row->journey_date;
                    if ($output == "") {
                        $output = $jdate;
                    } else {
                        $output = $output . "," . $jdate;
                    }
                }
            } else {
                $output = "Deactivated";
            }

            echo ' <table width="457" border="0" style="font-size:14px;color:#333333;" align="center">
			<tr>
			<td height="30">Service Activated on : ' . $output . '</td>
			</tr>
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
        $data = $this->modellogin->activeBusStatusDb($travid, $sernum, $s, $fromid, $toid, $status, $fwd, $fdate, $tdate, $servtype);
        echo $data;
    }

    public function mail_farmat() {

        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['description'] = $this->modellogin->get_mail_farmat_db();
        //print_r($data);
        $this->load->view('mail_format.php', $data);
    }

    public function mail_farmat1() {

        $res = $this->modellogin->mail_farmat_db();
        echo "$res";
    }

    public function view_mail_fmt() {

        $id = $this->input->get('id');
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data1[temp] = $this->modellogin->view_mail_farmat_db($id);
        $this->load->view('view_mail_format.php', $data1);
    }

    public function update_mail_fmt() {
        $id = $this->input->get('id');
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data1[temp] = $this->modellogin->view_mail_farmat_db($id);
        $this->load->view('update_mail_format.php', $data1);
    }

    public function update_mail_fmt1() {

        $res = $this->modellogin->update_mail_farmat_db();
        echo "$res";
    }
	public function response_logs(){
	
		if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $date = date('Y-m-j');
            $newdate = strtotime('-10 day', strtotime($date));
            $newdate = date('Y-m-j', $newdate);


            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $config = array();
            $config["base_url"] = base_url() . "master_control/response_logs";
            $config['total_rows'] = $this->modellogin->responce_logs_count($newdate, $date);
            //print_r($config);
            $config['per_page'] = 15;
            $config['uri_segment'] = 3;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3) > 0) ? $this->uri->segment(3) : 0;
            $data["response_logs"] = $this->modellogin->get_responce_logs($config['per_page'], $page, $newdate, $date);
            $data["links"] = $this->pagination->create_links();
            $this->load->view('response_logs.php', $data);
        }
	
	}
	
	function add_service_sms_contact() {
		if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('header.php');
            $this->load->view('sidebar.php');
            $data['query'] = $this->modellogin->add_service_sms_contact1();
            $data['operators'] = $this->modellogin->get_operators();

            $this->load->view('add_service_sms_contact', $data);
        }
	}
	
	function getServices() {
		if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {            
            $data = $this->modellogin->getServices1();
			return $data;            
        }
	}
	
	function save_service_sms_contact() {
		if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {            
            $data = $this->modellogin->save_service_sms_contact1();
			return $data;            
        }
	}		
	
	function edit_service_sms_contact() {
        $uid = $this->input->get('uid');      
        $this->load->view('header.php');
        $this->load->view('sidebar.php');
        $data['query'] = $this->modellogin->edit_service_sms_contact1($uid);        
        //var_dump($data);
        $this->load->view(edit_service_sms_contact, $data);
    }
	
	function update_service_sms_contact() {
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect(base_url());
        } else {
            $data = $this->modellogin->update_service_sms_contact1();
			return $data;
        }
    }
	
}
