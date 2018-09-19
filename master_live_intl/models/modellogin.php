<?php

class modellogin extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db1 = $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('forum', TRUE);
    }

    function login($email, $password) {
        $this->db1->where("uname", $email);
        $this->db1->where("password", $password);

        $query = $this->db1->get("login");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                //add all data to session
                $session_data = array(
                    'id' => $rows->id,
                    'name' => $rows->name,
                    'username' => $rows->uname,
                    'password' => $rows->password,
                    'mobile_number' => $rows->mobile,
                    'logged_in' => TRUE,
                    'dashboard' => $rows->dashboard,
                    'mgmt_opr' => $rows->mgmt_opr,
                    'operatons' => $rows->operations,
                    'book_invent' => $rows->book_invent,
                    'mgmt_agents' => $rows->mgmt_agent,
                    'payments' => $rows->payments,
                    'occupancy' => $rows->occupency,
                    'opr_check' => $rows->operator_check,
                    'track' => $rows->track,
                    'deposite' => $rows->deposite,
                    'history' => $rows->history,
                    'super_user' => $rows->super_user,
                );
            }
            $this->session->set_userdata($session_data);
            return true;
        }
        return false;
    }

    function getstatus($uid) {
        $query = $this->db2->query("select status  from registered_operators where id='$uid'");
        return $query->result();
    }

    function getviewstatus($uid) {
        $query = $this->db2->query("select *  from registered_operators where id='$uid'");
        return $query->result();
    }

    function summary_operators() {

        $query = $this->db2->query("select count(*) as num_rows from registered_operators");
        $query1 = $this->db2->query("select count(*) as num_rows from registered_operators where status='1'");

        $results1 = $query1->result();
        foreach ($query->result() as $rows) {
            $results = $rows->num_rows;
        }
        foreach ($query1->result() as $rows1) {
            $results1 = $rows1->num_rows;
        }

        if ($query && $query1) {
            return $results . "|" . $results1;
        } else {
            return false;
        }
    }

    public function record_pend_count() {
        $this->db2->select('id');
        $this->db2->where('status', NULL);
        $this->db2->or_where('status', 0);

        $query = $this->db2->get('registered_operators');

        return $query->num_rows();
    }

    function pend_operators($limit, $page) {
        //logic for showing all pending operators

        $this->db2->limit($limit, $page);
        $this->db2->select('*');
        $this->db2->where('status', 0);
        $this->db2->or_where('status', NULL);
        $this->db2->order_by('id', 'asc');
        $query = $this->db2->get("registered_operators");
        return $query->result();
    }

    public function record_activecount() {
        $this->db2->select('*');
        $this->db2->where('status', 1);
        $query = $this->db2->get('registered_operators');

        return $query->num_rows();
    }

    function active_operators($limit, $page) {
        //logic for showing all activated operators
        $this->db2->limit($limit, $page);
        $this->db2->select('*');
        $this->db2->where('status', 1);
        $this->db2->order_by('id', 'asc');
        $query = $this->db2->get("registered_operators");
        return $query->result();
    }

    public function record_count() {
        return $this->db->count_all("registered_operators");
    }

    function all_operators($limit, $page) {

        //logic for showing all operators function all_operators(),all_operators($limit, $page)

        $this->db->limit($limit, $page);

        $this->db->order_by('id', 'asc');
        $query = $this->db->get('registered_operators');
        return $query->result();
    }

    function active($uid, $st) {
        //logic for changing the status of all operators

        if ($st == 1) {
            $st = 0;
        } else if ($st == 0) {
            $st = 1;
        }
        $query = $this->db->query("UPDATE registered_operators SET status='$st' WHERE id='$uid' ");

        if ($query)
            return 1;
        else
            return 0;

        /* if ($st == 1) {
          $st = 0;
          } else if ($st == 0) {
          $st = 1;
          }
          $query = $this->db2->query("UPDATE registered_operators SET status='$st' WHERE id='$uid' ");
          if ($query) {

          $query = $this->db2->query("select * from registered_operators where id='$uid'");

          if ($query->num_rows() > 0) {
          foreach ($query->result() as $rows) {
          //add all data to session
          $name = $rows->name;
          $username = $rows->user_name;
          $password = $rows->password;
          $emailid = $rows->email_id;
          $status = $rows->status;
          }
          $x = $this->mail_send($name, $username, $password, $emailid, $status);
          if ($x) {
          return 1;
          }
          }
          } else
          return 0; */
    }

    function active_view($uid, $st) {
        //logic for changing the status of all operators

        if ($st == 'yes') {
            $st = 'no';
        } else if ($st == 'no') {
            $st = 'yes';
        }
        $query = $this->db->query("UPDATE registered_operators SET central_agent='$st' WHERE id='$uid' ");

        if ($query)
            return 1;
        else
            return 0;
    }

    function mail_send($name, $username, $password, $emailid, $status) {
        //logic for showing the details of operators
        $this->load->library('email');
        if ($status == 0) {
            $this->email->from('shivani.u@viveinfoservices.com', 'shivani.u@viveinfoservices.com');
            $this->email->to($emailid);
            $this->email->subject('Email Test');
            $this->email->message('Dear ' . $name . ',
                                                       Thanks for registration.Your account is activated now.
                                                       Username:' . $username . '
                                                       Password:' . $password);
            $this->email->send();
            echo $this->email->print_debugger();
        } else if ($status == 1) {
            $this->email->from('shivani.u@viveinfoservices.com', 'shivani.u@viveinfoservices.com');
            $this->email->to($emailid);
            $this->email->subject('Email Test');
            $this->email->message('Dear ' . $name . ',
                                                       Your account is deactivated now.
                                                       Username:' . $username . '
                                                       Password:' . $password);
            $this->email->send();
            echo $this->email->print_debugger();
        }
        return 1;
    }

    function detail_operators($uid) {
        //logic for showing the details of operators
        $query = $this->db2->query("SELECT * FROM registered_operators WHERE id='$uid' ");
        return $query->result();
    }

    function bus() {
        //select the id and bus model store as in array
        $this->db2->select('id,model,s_type');
        $this->db2->order_by("model", "asc");
        $records = $this->db2->get('buses_model');

        $data = array();
        foreach ($records->result() as $row) {
            $data[$row->model] = $row->model;
        }
        return ($data);
    }

    function update_model($new, $old, $type) {
        //update the bus model in database
        $query = $this->db2->query("UPDATE buses_model SET model='$new',s_type='$type',layout_model='$new' WHERE model='$old' ");
        if ($query)
            return 1;
        else
            return 0;
    }

    function add_model($text, $text1) {
        //add new bus model in database
        $query = $this->db2->query("INSERT INTO buses_model(model,s_type,layout_model) VALUES ('$text','$text1','$text')");
        if ($query)
            return 1;
        else
            return 0;
    }

    function cityadd() {
        //select the id and city_name and store as array
        $this->db2->select('city_id,city_name');
        $this->db2->order_by("city_name", "asc");
        $records = $this->db2->get('master_cities');
        $data = array();
        foreach ($records->result() as $row) {
            $data[$row->city_name] = $row->city_name;
        }
        return ($data);
    }
	function listCountryList() {
        //select the id and city_name and store as array
        $this->db2->select('country_id,country_name');
        $this->db2->order_by("country_name", "asc");
        $records = $this->db2->get('master_countries');
        $data = array();
		$data[0] = "-----select-----";
        foreach ($records->result() as $row) {
            $data[$row->country_id] = $row->country_name;
	      }
        return ($data);
    }
	
	public function getCitiesListForCountryModel() {
		$ctid = $this->input->post('countryID');
	$sql2 = $this->db2->query("SELECT *  FROM `master_cities` WHERE `country_id` = '$ctid'");
	$list = '<option value="0">---Select---</option>';
        foreach ($sql2->result() as $rows) {
            $list = $list . '<option value="' . $rows->city_id . '">' . $rows->city_name . '</option>';
        }
        return $list;
     }
	 
	 public function getStageOrderModel() {
		/*$opid = $this->input->post('opid');
		$routeid = $this->input->post('routeid');
		$sql2 = $this->db2->query("SELECT *  FROM `master_operator_stages` WHERE `operator_id` = '$opid' and route_id='$routeid' ");
		$list = '<table>';
        foreach ($sql2->result() as $rows) {
            $list = $list . '<input type="text" value="' . $rows->city_name . '">' . $rows->city_name . '</option>';
        }
        return $list;*/
		 $this->db2->select('*');
        $this->db2->from('master_cities');
        $query = $this->db2->get();
        $location = array();
        $location['0'] = "--select city--";
        foreach ($query->result() as $value) {
            $location[$value->city_id] = $value->city_name;
        }
		
		$stops = $this->input->post('stops');
		
		echo '<table>';
        for ($k=1;$k<=$stops;$k++) {
			$op_id = ' id="stage'.$k.'"  style="width:150px; font-size:12px" ';
            echo '<tr><td>';
			echo form_dropdown('stages[]', $location, "", $op_id);
			echo '</td><td><input id="order'.$k.'"  name="orders[]" readonly= "readonly" type="text" value="'.$k.'"/>';
			if($k==1) echo '<span style="font-size:12px" >first stage should be source</span>';
			else if($k==$stops) echo ' <span style="font-size:12px" >last stage should be destination </span>';
			echo '</td></tr>';
        }
		echo '</table>';
       // return $table;
     }
	
	public function saveStageOrderModel()
	{
		$opid = $this->input->post('operators');
		$routeID = $this->input->post('routes');
		$stopsCount = $this->input->post('stops');
		$stages = $this->input->post('stages');
		$orders = $this->input->post('orders');
		
		$query = $this->db2->query("SELECT *  FROM `master_operator_stages` WHERE `operator_id` = '$opid' and route_id='$routeID' ");
		if ($query->num_rows() > 0) {
			return 2;
		}
		else {
			$order = 1;
		foreach( $stages as $stage ) {
			
			$query1 = $this->db2->query("INSERT INTO master_operator_stages (operator_id,stage_city_id,stage_order,route_id) VALUES
			('$opid','$stage','$order','$routeID')");
            $order = $order+1;
           } 
           if ($query1)
                return 1;
            else
                return 0; 
        
		}
	}
	
 function countryadd() {
        //select the id and city_name and store as array
        $this->db2->select('country_id,country_name');
        $this->db2->order_by("country_name", "asc");
        $records = $this->db2->get('master_countries');
        $data = array();
        foreach ($records->result() as $row) {
            $data[$row->country_id] = $row->country_name;
        }
        return ($data);
    }
	 function update_country($new, $old) {
        //update the existing city in database
        $query = $this->db2->query("UPDATE master_countries SET country_name='$new' WHERE country_name='$old' ");
        if ($query)
            return 1;
        else
            return 0;
    }
    function update_city($new, $old,$country) {
        //update the existing city in database
		  $query = $this->db2->query("UPDATE master_cities SET city_name='$new' WHERE city_id='$old' and country_id=$country ");
        if ($query)
            return 1;
        else
            return 0;
    }

    function add_cities($text,$country_name) {
        //add new city to database

        $query = $this->db2->query("SELECT *  FROM `master_cities` WHERE `city_name` = '$text' and country_id='$country_name' ");


        if ($query->num_rows() > 0) {
            return 2;
        } else {
            $query1 = $this->db2->query("INSERT INTO master_cities (city_name,country_id) VALUES ('$text','$country_name')");
            if ($query1)
                return 1;
            else
                return 0;
        }
    }

	function add_countries($text) {
        //add new city to database

        $query = $this->db2->query("SELECT *  FROM `master_countries` WHERE `country_name` = '$text'");


        if ($query->num_rows() > 0) {
            return 2;
        } else {
            $query1 = $this->db2->query("INSERT INTO master_countries (country_name) VALUES ('$text')");
            if ($query1)
                return 1;
            else
                return 0;
        }
    }
    function bustypes() {
        //select the id and bus type and store as array
        $this->db2->select('id,bus_type');
        $this->db2->order_by("bus_type", "asc");
        $records = $this->db2->get('buses_type');
        $data = array();
        foreach ($records->result() as $row) {
            $data[$row->bus_type] = $row->bus_type;
        }
        return ($data);
    }

    function update_bus($new, $old) {
        //update the existing bus type in database
        $query = $this->db2->query("UPDATE bus_type SET buses_type='$new' WHERE bus_type='$old' ");
        if ($query)
            return 1;
        else
            return 0;
    }

    function add_bustype($text) {
        //add new bus type to database
        $query = $this->db2->query("INSERT INTO buses_type VALUES ('','$text')");
        if ($query)
            return 1;
        else
            return 0;
    }

    function seatarr() {
        //select the id and seating arrangement and store as array
        $this->db2->select('id,seat_arr');
        $this->db2->order_by("seat_arr", "asc");
        $records = $this->db->get('seats_arrangement');
        $data = array();
        foreach ($records->result() as $row) {
            $data[$row->seat_arr] = $row->seat_arr;
        }
        return ($data);
    }

    function update_seat($new, $old) {
        //update the existing seating arrangement in database
        $query = $this->db2->query("UPDATE seats_arrangement SET seat_arr='$new' WHERE seat_arr='$old' ");
        if ($query)
            return 1;
        else
            return 0;
    }

    function add_seatarr($text) {
        //add new seating arrangement in database
        $query = $this->db2->query("INSERT INTO seats_arrangement VALUES ('','$text')");
        if ($query)
            return 1;
        else
            return 0;
    }

    function get_data_from_db($limit, $start) {


        if ($limit != 0)
            $this->db2->limit($limit, $start);
        $this->db2->select('master_booking.id,master_booking.tkt_no,master_booking.pnr,master_booking.source,master_booking.dest,master_booking.jdate,master_booking.bdate,master_booking.tkt_fare,registered_operators.name');
        $this->db2->from('master_booking');
        $this->db2->join('registered_operators', 'registered_operators.travel_id = master_booking.travel_id');
        $query = $this->db2->get();


        if ($limit == 0)
            return $query->num_rows();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $res[] = $row;
            }
            return $res;
        }
        return false;
    }

    function get_tabledata_from_db() {
        $this->db2 = $this->load->database('forum', TRUE);
        $from = $this->input->get('date_from');
        $to = $this->input->get('date_to');
        $opid = $this->input->get('opid');
        $agentype = $this->input->get('agentype');
        if ($opid != 'all' && $agentype == 'all') {
            $query = $this->db2->query("SELECT master_booking.id as 'S.No',registered_operators.name as 'Operator name',master_booking.tkt_no as 'Ticket Number',master_booking.pnr as 'PNR number',master_booking.source as 'Source',
           master_booking.dest as 'Destination',master_booking.jdate as 'Journey date',master_booking.bdate as 'Booking date',master_booking.tkt_fare as 'Ticket Fare'
           FROM master_booking INNER JOIN registered_operators ON master_booking.travel_id=registered_operators.travel_id where 
           (master_booking.jdate BETWEEN '" . $from . "' AND '" . $to . "' or master_booking.bdate BETWEEN '" . $from . "' AND '" . $to . "') and master_booking.travel_id='$opid'");
        } else if ($opid == 'all' && $agentype != 'all') {
            $query = $this->db2->query("SELECT master_booking.id as 'S.No',registered_operators.name as 'Operator name',master_booking.tkt_no as 'Ticket Number',master_booking.pnr as 'PNR number',master_booking.source as 'Source',
           master_booking.dest as 'Destination',master_booking.jdate as 'Journey date',master_booking.bdate as 'Booking date',master_booking.tkt_fare as 'Ticket Fare'
           FROM master_booking INNER JOIN registered_operators ON master_booking.travel_id=registered_operators.travel_id where 
           (master_booking.jdate BETWEEN '" . $from . "' AND '" . $to . "' or master_booking.bdate BETWEEN '" . $from . "' AND '" . $to . "') and master_booking.operator_agent_type='$agentype'");
        } else if ($opid == 'all' && $agentype == 'all') {
            $query = $this->db2->query("SELECT master_booking.id as 'S.No',registered_operators.name as 'Operator name',master_booking.tkt_no as 'Ticket Number',master_booking.pnr as 'PNR number',master_booking.source as 'Source',
           master_booking.dest as 'Destination',master_booking.jdate as 'Journey date',master_booking.bdate as 'Booking date',master_booking.tkt_fare as 'Ticket Fare'
           FROM master_booking INNER JOIN registered_operators ON master_booking.travel_id=registered_operators.travel_id where 
           (master_booking.jdate BETWEEN '" . $from . "' AND '" . $to . "' or master_booking.bdate BETWEEN '" . $from . "' AND '" . $to . "')");
        } else if ($opid != 'all' && $agentype != 'all') {
            $query = $this->db2->query("SELECT master_booking.id as 'S.No',registered_operators.name as 'Operator name',master_booking.tkt_no as 'Ticket Number',master_booking.pnr as 'PNR number',master_booking.source as 'Source',
           master_booking.dest as 'Destination',master_booking.jdate as 'Journey date',master_booking.bdate as 'Booking date',master_booking.tkt_fare as 'Ticket Fare'
           FROM master_booking INNER JOIN registered_operators ON master_booking.travel_id=registered_operators.travel_id where 
           (master_booking.jdate BETWEEN '" . $from . "' AND '" . $to . "' or master_booking.bdate BETWEEN '" . $from . "' AND '" . $to . "')  and master_booking.travel_id='$opid' and master_booking.operator_agent_type='$agentype'");
        }
        return $query;
    }

    function displayReports($limit, $page) {
        $this->db2 = $this->load->database('forum', TRUE);
        $from = $this->input->get('from');
        $to = $this->input->get('to');
        $opid = $this->input->get('opid');
        $agentype = $this->input->get('agentype');

        if ($limit == 0 && $page == 0) {
            //getting the count
            $query = $this->db2->query("select * from master_booking where jdate BETWEEN '" . $from . "' AND '" . $to . "'");
            return $query->num_rows();
        } else {

            if ($opid != 'all' && $agentype == 'all') {

                $query = $this->db2->query("select * from master_booking   where 
           (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$opid' limit $limit,$page");
            } else if ($opid == 'all' && ($agentype != 'all' && $agentype != 'website' && $agentype != 'te')) {

                $query = $this->db2->query("select * from master_booking  where 
           (jdate BETWEEN '" . $from . "' AND '" . $to . "') and operator_agent_type='$agentype' limit $limit,$page");
            } else if ($opid == 'all' && $agentype == 'all') {

                $query = $this->db2->query("select * from master_booking  where 
          ( jdate BETWEEN '" . $from . "' AND '" . $to . "') limit $limit,$page");
            } else if ($opid != 'all' && ($agentype != 'all' && $agentype != 'website' && $agentype != 'te')) {

                $query = $this->db2->query("select * from master_booking  where 
          (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$opid' and operator_agent_type='$agentype' limit $limit,$page");
            } else if ($opid == 'all' && $agentype == 'website') {

                $query = $this->db2->query("select * from master_booking  where 
          (jdate BETWEEN '" . $from . "' AND '" . $to . "') and operator_agent_type='4' limit $limit,$page");
            } else if ($opid != 'all' && $agentype == 'website') {
                $query = $this->db2->query("select * from master_booking  where 
          (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$opid' and operator_agent_type='4' limit $limit,$page");
            } else if ($opid == 'all' && $agentype == 'te') {
                $query = $this->db2->query("select * from master_booking  where 
          (jdate BETWEEN '" . $from . "' AND '" . $to . "') and operator_agent_type='3' and (agent_id='125' or agent_id='161' or agent_id='204') limit $limit,$page");
            } else if ($opid != 'all' && $agentype == 'te') {
                $query = $this->db2->query("select * from master_booking  where 
          (jdate BETWEEN '" . $from . "' AND '" . $to . "') and travel_id='$opid' and operator_agent_type='3' and (agent_id='125' or agent_id='161' or agent_id='204') limit $limit,$page");
            }

            return $query;
        }
    }

    function getAgentName1($agent_type, $opid) {

        $travel_id = $opid;
        if ($agent_type == 3)
            $sql = $this->db->query("select name,id from agents_operator where operator_id='$travel_id' and api_type='op'");
        else if ($agent_type == "te")
            $sql = $this->db->query("select name,id from agents_operator where api_type='te'");
        else if ($agent_type == 'all')
            $sql = $this->db->query("select name,id from agents_operator where operator_id='$travel_id' and (agent_type='$agent_type' || pay_type='$agent_type')");
        else if ($agent_type == 'prepaid' || $agent_type == 'postpaid')
            $sql = $this->db->query("select name,id from agents_operator where operator_id='$travel_id' and agent_type='2' and pay_type='$agent_type'");
        else
            $sql = $this->db->query("select name,id from agents_operator where operator_id='$travel_id' and  agent_type='$agent_type'");
        $data = array();
        $data['all'] = "All";
        foreach ($sql->result() as $rows) {
            $data[$rows->id] = $rows->name;
        }

        return $data;
    }

    function get_booking_from_db() {

        echo '<h4 align="center">Summary</h4>
                       <br />
                       <table align="center" width="500" border="0">
                       <tr ><td style="border-right:#f2f2f2 solid 4px; border-top:#f2f2f2 solid 4px; border-left:#f2f2f2 solid 4px;">';

        echo "<table align='center'>";
        $query = $this->db2->query("select count(pass) as num_rows from master_booking");
        $query1 = $this->db2->query("select count(pass) as num_rows from master_booking where status='cancelled'");
        foreach ($query->result() as $rows) {
            $results = $rows->num_rows;
        }
        foreach ($query1->result() as $rows1) {
            $results1 = $rows1->num_rows;
        }
        $total = $results1 + $results;
        echo "<tr>
                        <td>Total Bookings:</td><td align='center'>$results</td>
                        </tr>
                        <tr>
                        <td>Total Cancellations:</td><td align='center'>$results1</td>
                        </tr>
                        <td><b>Total:</b></td><td align='center'>$total</td>";


        echo '</table></td>';
        echo "<td style='border-right:#f2f2f2 solid 4px; border-top:#f2f2f2 solid 4px; '><table align='center'>";
        $this->db2->select_sum('tkt_fare');
        $sum = $this->db2->get('master_booking');
        foreach ($sum->result() as $rows) {
            $book = $rows->tkt_fare;
        }
        $this->db2->select_sum('tkt_fare');
        $this->db2->where('status', 'cancelled');
        $sum1 = $this->db2->get('master_booking');
        $query3 = $this->db2->query("select count(pass) as num_rows from master_booking where status='cancelled'");
        foreach ($query3->result() as $rows1) {
            $res = $rows1->num_rows;
        }
        foreach ($sum1->result() as $rows) {

            if ($res == 0) {
                $can = $res;
            } else {
                $can = $rows->tkt_fare;
            }
        }
        $totalval = $book + $can;
        echo "<tr>
                  <td>Total booking value:</td><td align='right'>$book</td>
                  </tr>
                  <tr>
                  <td>Total cancellation value:</td><td align='right'>$can</td>
                  <tr>
                  <td><b>Total:</b></td><td align='center'>$totalval</td>
                  </table></td></tr>
                  </table>";
    }

    function get_api_from_db($list) {

        $sql = $this->db2->query("select id,name from agents_operator where agent_type='3' and api_type='$list'");
        $data = array();
        $data[0] = "-----select-----";
        foreach ($sql->result() as $rows) {
            $data[$rows->id] = $rows->name;
        }
        return $data;
    }

    function get_api_table_from_db() {

        $list = $this->input->post('list');
        $this->db2->select('*');
        if ($list == 'op' || $list == 'te') {
            $this->db2->where('api_type', $list);
        } else {
            
        }
        $this->db2->where('agent_type', 3);

        $query = $this->db2->get('agents_operator');
        if ($list == 'te') {

            echo '<table width="700">
       <tr>
		<td></td>
		<td style="font-size:12px" align="right">';

            echo anchor("master_control/addnewagent", "Add New Agent", "title='new agent'");
            echo '</td>
		</tr> 
                </table>';
        } else {
            
        }

        echo '<table id="tbl" width="700" border="0" id="tbl"><tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; 
                       border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; 
                       border-left:#f2f2f2 solid 1px;">
        <th height="30">Name</th>
        
		<th>Operator</th>
		<th>UserName</th>
		<th>Password</th>
        <th>Contact</th>
        <th>Key</th>
		<th>IP</th>
        <th>Type</th>
        <th>Action</th>
        </tr>';

        foreach ($query->result() as $value) {
            $i = $value->id;
            $operator_id = $value->operator_id;
            $sql = $this->db2->query("select operator_title from registered_operators where travel_id='$operator_id'");
            foreach ($sql->result() as $row) {
                $title = $row->operator_title;
            }
            echo "<tr style='font-size:12'>
                 <td align='center' height='30'>$value->name</td>
                 
				 <td align='center'>$title</td>
				 <td align='center'>$value->uname</td>
				 <td align='center'>$value->password</td>
                 <td align='center'>$value->mobile</td>
                 <td align='center'>$value->api_key</td>
				 <td align='center'>$value->ip</td>
                 <td align='center'>$value->api_type</td>
                 <td align='center'><span style='font-weight:bold;text-decoration:underline;cursor:pointer;'>" . anchor('master_control/UpdateDet?id=' . $i, 'Update', 'EditAgent') . "</span></td>
                 </tr>";
        }
        echo '</table>';
    }

    function get_details_from_db($id) {
        $this->db2->select('*');
        $this->db2->where('id', $id);
        $query = $this->db2->get('agents_operator');
        return $query->result();
    }

    function update_details_db() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $mobile = $this->input->post('mobile');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $api_key = $this->input->post('api_key');
        $apitype = $this->input->post('apitype');
        $uname = $this->input->post('uname');
        $pass = $this->input->post('pass');
        $st = $this->input->post('status');
        $ip = $this->input->post('ip');
        $margin = $this->input->post('margin');
        $pay = $this->input->post('pay');
        $limit = $this->input->post('limit');
        $balance = $this->input->post('balance');
        $api_key2 = substr($api_key, 0, 2);
        if ($apitype == 'te' && $api_key2 != 'TE') {
            $api = 'TE' . $api_key;
        } else if ($apitype == 'op' && $api_key2 != 'OP') {
            $api = 'OP' . $api_key;
        } else {
            $api = $api_key;
        }
        $query = $this->db2->query("update agents_operator SET name='$name',uname='$uname',email='$email',mobile='$mobile',
                               address='$address',api_key='$api',api_type='$apitype',password='$pass',status='$st',ip='$ip',margin='$margin',pay_type='$pay',bal_limit='$limit',balance='$balance' WHERE id='$id'");
        if ($query)
            echo 1;
        else
            echo 0;
    }

    function get_operator_from_db() {
        $sql = $this->db2->query("select travel_id,operator_title from registered_operators where status='1' ");
        $data = array();
        $data[0] = "-----select-----";
        foreach ($sql->result() as $rows) {
            $data[$rows->travel_id] = $rows->operator_title;
        }
        return $data;
    }

    function get_operator_agent_from_db() {
        $list = $this->input->post('list');
        $operator = $this->input->post('operator');
        echo '<table id="tbl" width="700" border="0" id="tbl"><tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; 
                       border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; 
                       border-left:#f2f2f2 solid 1px;">
        <th>Name</th>
        
		<th>operator</th>
        <th>Contact</th>
		<th>UserName</th>
		<th>Password</th>
        <th>Key</th>
		<th>IP</th>
        <th>Type</th>
        <th>Action</th>
        </tr>';
        $this->db2->select('*');
        $this->db2->where('api_type', $list);
        $this->db2->where('operator_id', $operator);
        $this->db2->where('agent_type', 3);
        $query = $this->db2->get('agents_operator');
        foreach ($query->result() as $value) {
            $i = $value->id;
            $operator_id = $value->operator_id;
            $sql = $this->db2->query("select operator_title from registered_operators where travel_id='$operator_id'");
            foreach ($sql->result() as $row) {
                $title = $row->operator_title;
            }
            echo "<tr style='font-size:12'>
                 <td align='center'>$value->name</td>
                 
				 <td align='center'>$title</td>
                 <td align='center'>$value->mobile</td>
				 <td align='center'>$value->uname</td>
				 <td align='center'>$value->password</td>
                 <td align='center'>$value->api_key</td>
				 <td align='center'>$value->ip</td>
                 <td align='center'>$value->api_type</td>
                 <td align='center'><span style='font-weight:bold;text-decoration:underline;cursor:pointer;'>" . anchor('master_control/UpdateDet?id=' . $i, 'Update', 'EditAgent') . "</span></td>
                 </tr>";
        }
        echo '</table>';
    }

    function get_citylist_from_db() {
        $this->db2->select('*');
        $this->db2->from('master_cities');
        $query = $this->db2->get();
        $location = array();
        $location['0'] = "--select city--";
        foreach ($query->result() as $value) {
            $location[$value->city_name] = $value->city_name;
        }
        return $location;
    }

    function store_agent($data, $username) {
        $this->db2->select('*');
        if ($username == '') {
            $rws = 0;
        } else {
            $this->db2->where('uname', $username);
            $query = $this->db2->get("agents_operator");
            $rws = $query->num_rows();
        }

        //if email already exist
        if ($rws > 0)
            return 2;
        else {//else mail not exist
            $query2 = $this->db2->insert('agents_operator', $data);
            if ($query2)
                return 1;
            else
                return 0;
        }
    }

//store agent

    function get_postagentslist_db($at) {

        $this->db2->select('*');
        $this->db2->where('agent_type', $at);
        $this->db2->where('pay_type', 'postpaid');
        $query = $this->db2->get("agents_operator");
        return $query->result();
    }

//all_inhouse_agent()get_postagentslist_db

    function get_preagentslist_db($at) {
        $this->db2->select('*');
        $this->db2->where('agent_type', $at);
        $this->db2->where('pay_type', 'prepaid');

        $query = $this->db2->get("agents_operator");
        return $query->result();
    }

//all_inhouse_agent()get_postagentslist_db

    function get_agentslist_db($at) {
        $this->db2->select('*');
        $this->db2->where('agent_type', $at);

        $query = $this->db2->get("agents_operator");
        return $query->result();
    }

    function get_sms_cont() {
        $this->db2->select('*');
        $this->db2->where(status, '1');
        $query = $this->db2->get("registered_operators");
        return $query->result();
    }

    function get_sms_cont2($uid) {

        if ($uid == all) {
            $query = $this->db2->query("select * from registered_operators where status='1'");
        } else {
            $query = $this->db2->query("select * from registered_operators where travel_id='$uid'");
        }
        echo "<table id='tbl' style='margin: 0px auto;' class='gridtable'  width='550'>";
        echo "<tr>";
        echo "<th>Name</th>";
        echo "<th>Travel Id </th>";
        echo "<th>contact No </th>";
        echo "<th>Status</th>";
        echo "<th>Option</th>";
        echo "</tr>";
        $i = 1;
        foreach ($query->result() as $row) {
            $uid = $row->id;
            $is_api_sms = $row->is_api_sms;
            //echo $is_api_sms."is_api_sms";
            if ($is_api_sms == 1) {
                $x = 'Active';
            } else {
                $is_api_sms = 0;
                $x = 'Inactive';
            }
            echo "<tr>";

            echo "<td style='font-size:12px';>" . $row->operator_title . "</td>";
            echo "<td style='font-size:12px';>" . $uid . "</td>";
            echo "<td style='font-size:12px;'>" . $row->contact_no . "</td>";
            echo "<td style='font-size:12px;'>" . $x . "</td>";
            echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;'>" . anchor('master_control/edit_apisms?uid=' . $uid . '&is_api_sms=' . $is_api_sms, 'Update', '') . "</span></td>";

            echo "</tr>";
            $i++;
        }
        echo "</table>";
    }

    function get_sms_cont3($uid) {

        $query = $this->db2->query("select * from registered_operators where travel_id='$uid'");
        return $query->result();
    }

    function status_api_update($uid, $st) {
        if ($st == 1)
            $st = 0;
        else if ($st == 0)
            $st = 1;
        $query = $this->db->query("UPDATE registered_operators SET is_api_sms='$st' WHERE id='$uid' ");
        if ($query)
            echo 1;
        else
            echo 0;
    }

    function status_modify_apisms() {
        $status = $this->input->post('status');
        $id = $this->input->post('id');
        $mobile = $this->input->post('mobile');
        //echo "$mobile";
        $query = $this->db->query("UPDATE registered_operators SET is_api_sms='$status', contact_no='$mobile' WHERE id='$id' ");
        if ($query)
            echo 1;
        else
            echo 0;
    }

//get all agents list

    function detail_agents($uid) {
        $query = $this->db2->query("SELECT * FROM agents_operator WHERE id='$uid' ");
        return $query->result();
    }

    function status_update($uid, $st) {
        if ($st == 1)
            $st = 0;
        else if ($st == 0)
            $st = 1;
        $query = $this->db->query("UPDATE agents_operator SET status='$st' WHERE id='$uid' ");
        if ($query)
            echo 1;
        else
            echo 0;
    }

    function status_prepaid($uid, $st) {

        if ($st == 1)
            $st = 0;
        else if ($st == 0)
            $st = 1;
        $query = $this->db->query("UPDATE agents_operator SET status='$st' WHERE id='$uid' ");
        if ($query)
            echo 1;
        else
            echo 0;
    }

    function status_postpaid($uid, $st) {
        if ($st == 1)
            $st = 0;
        else if ($st == 0)
            $st = 1;
        $query = $this->db->query("UPDATE agents_operator SET status='$st' WHERE id='$uid' ");
        if ($query)
            echo 1;
        else
            echo 0;
    }

    function detail_externalagents($uid) {
        $query = $this->db2->query("SELECT * FROM agents_operator WHERE id='$uid' ");
        return $query->result();
    }

    function get_bookings_from_db($i) {
        $now = date('Y-m-d');
        echo '
             <table id="tbl" align="center" width="600" border="0" style="border:#A4A4A4 solid 2px;">
                       <tr ><th id="tb" colspan="11" align="left" style="background-color:#D8D8D8; color: #000000; font-size:14px;">Summary of today</th></tr>
                       <tr style="font-size:12px">
                        <th id="tb"></th>
                        <th id="tb">Gross Bookings</th>
                        <th id="tb">Cancellations</th>
                        <th id="tb">Net Bookings</th>
                       </tr>';
        $this->db2->select('*');
        $query = $this->db2->get('master_booking');

        if ($i == 1) {
            foreach ($query->result() as $rows) {

                $query1 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and bdate ='$now'");

                foreach ($query1->result() as $rows) {

                    $results = $rows->num_rows;
                }
                $query2 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and bdate ='$now'");

                foreach ($query2->result() as $rows) {
                    $results1 = $rows->num_rows;
                }
                $query3 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and bdate ='$now'");

                foreach ($query3->result() as $rows) {
                    $results2 = $rows->num_rows;
                }
                $query8 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and bdate ='$now'");

                foreach ($query8->result() as $rows) {
                    $results7 = $rows->num_rows;
                }
                $query4 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and status='cancelled' and bdate ='$now'");

                foreach ($query4->result() as $rows) {
                    $results3 = $rows->num_rows;
                }

                $query5 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and status='cancelled' and bdate ='$now'");

                foreach ($query5->result() as $rows) {
                    $results4 = $rows->num_rows;
                }
                $query6 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and status='cancelled' and bdate ='$now'");

                foreach ($query6->result() as $rows) {
                    $results5 = $rows->num_rows;
                }
                $query7 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and status='cancelled' and bdate ='$now'");

                foreach ($query7->result() as $rows) {
                    $results6 = $rows->num_rows;
                }
                $net_total = $results - $results5;
                $net_total1 = $results2 - $results3;
                $net_total2 = $results1 - $results4;
                $net_total3 = $results7 - $results6;
                $gross_book = $results + $results2 + $results1 + $results7;
                $can_book = $results5 + $results3 + $results4 + $results6;
                $net_book = $net_total + $net_total1 + $net_total2;
            }
        }
        if ($i == 2) {
            foreach ($query->result() as $rows) {
                $res_query = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and bdate like '%$now%'");

                foreach ($res_query->result() as $rows) {
                    $tot_res = $rows->num_rows;
                }
                $query1 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='3' and bdate like '%$now%'");

                foreach ($query1->result() as $rows) {
                    if ($tot_res == 0) {
                        $results = $tot_res;
                    } else {
                        $results = $rows->num_rows;
                    }
                }

                $res_query1 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and bdate like '%$now%'");

                foreach ($res_query1->result() as $rows) {
                    $tot_res1 = $rows->num_rows;
                }
                $query2 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='1' and bdate like '%$now%'");

                foreach ($query2->result() as $rows) {
                    if ($tot_res1 == 0) {
                        $results1 = $tot_res1;
                    } else {
                        $results1 = $rows->num_rows;
                    }
                }

                $res_query6 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and bdate like '%$now%'");

                foreach ($res_query6->result() as $rows) {
                    $tot_res6 = $rows->num_rows;
                }
                $query7 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='4' and bdate like '%$now%'");

                foreach ($query7->result() as $rows) {
                    if ($tot_res6 == 0) {
                        $results7 = $tot_res6;
                    } else {
                        $results7 = $rows->num_rows;
                    }
                }
                $res_query2 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and bdate like '%$now%'");

                foreach ($res_query2->result() as $rows) {
                    $tot_res2 = $rows->num_rows;
                }
                $query3 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='2' and bdate like '%$now%'");

                foreach ($query3->result() as $rows) {
                    if ($tot_res2 == 0) {
                        $results2 = $tot_res2;
                    } else {
                        $results2 = $rows->num_rows;
                    }
                }
                $res_query3 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and status='cancelled' and bdate like '%$now%'");

                foreach ($res_query3->result() as $rows) {
                    $tot_res3 = $rows->num_rows;
                }
                $query4 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='2' and status='cancelled' and bdate like '%$now%'");

                foreach ($query4->result() as $rows) {
                    if ($tot_res3 == 0) {
                        $results3 = $tot_res3;
                    } else {
                        $results3 = $rows->num_rows;
                    }
                }
                $res_query4 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and status='cancelled' and bdate like '%$now%'");

                foreach ($res_query4->result() as $rows) {
                    $tot_res4 = $rows->num_rows;
                }
                $query5 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='1' and status='cancelled' and bdate like '%$now%'");

                foreach ($query5->result() as $rows) {
                    if ($tot_res4 == 0) {
                        $results4 = $tot_res4;
                    } else {
                        $results4 = $rows->num_rows;
                    }
                }
                $res_query5 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and status='cancelled' and bdate like '%$now%'");

                foreach ($res_query5->result() as $rows) {
                    $tot_res5 = $rows->num_rows;
                }
                $query6 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='3' and status='cancelled' and bdate like '%$now%'");

                foreach ($query6->result() as $rows) {
                    if ($tot_res5 == 0) {
                        $results5 = $tot_res5;
                    } else {
                        $results5 = $rows->num_rows;
                    }
                }
                $res_query7 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and status='cancelled' and bdate like '%$now%'");

                foreach ($res_query7->result() as $rows) {
                    $tot_res7 = $rows->num_rows;
                }
                $query8 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='4' and status='cancelled' and bdate like '%$now%'");

                foreach ($query8->result() as $rows) {
                    if ($tot_res7 == 0) {
                        $results6 = $tot_res7;
                    } else {
                        $results6 = $rows->num_rows;
                    }
                }
                $net_total = $results - $results5;
                $net_total1 = $results2 - $results3;
                $net_total2 = $results1 - $results4;
                $net_total3 = $results7 - $results6;
                $gross_book = $results + $results2 + $results1 + $results7;
                $can_book = $results5 + $results3 + $results4 + $results6;
                $net_book = $net_total + $net_total1 + $net_total2;
            }
        }
        echo '<tr style="font-size:12px">
                    <td id="td">API</td><td id="td">' . $results . '</td><td id="td">' . $results5 . '</td><td id="td">' . $net_total . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Agent</td><td id="td">' . $results2 . '</td><td id="td">' . $results3 . '</td><td id="td">' . $net_total1 . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Branch</td><td id="td">' . $results1 . '</td><td id="td">' . $results4 . '</td><td id="td">' . $net_total2 . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Website</td><td id="td">' . $results7 . '</td><td id="td">' . $results6 . '</td><td id="td">' . $net_total3 . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td"><b>Total</b></td><td id="td">' . $gross_book . '</td><td id="td">' . $can_book . '</td><td id="td">' . $net_book . '</td>
                    </tr>';

        echo '</table><br /><br />';


        echo '<table id="tbl" align="center" width="600" border="0" style="border:#A4A4A4 solid 2px;">
                       <tr ><th id="tb" colspan="11" align="left" style="background-color:#D8D8D8; color: #000000; font-size:14px;">Summary of Month</th></tr>
                       <tr style="font-size:12px">
                        <th id="tb"></th>
                        <th id="tb">Gross Bookings</th>
                        <th id="tb">Cancellations</th>
                        <th id="tb">Net Bookings</th>
                       </tr>';
        $this->db2->select('*');
        $data = $this->db2->get('master_booking');
        $month = date('m');

        if ($i == 1) {
            foreach ($data->result() as $rows) {

                $data1 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and bdate like '%-$month%'");

                foreach ($data1->result() as $rows) {
                    $res = $rows->num_rows;
                }
                $data2 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and bdate like '%-$month%'");

                foreach ($data2->result() as $rows) {
                    $res1 = $rows->num_rows;
                }
                $data8 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and bdate like '%-$month%'");

                foreach ($data8->result() as $rows) {
                    $res7 = $rows->num_rows;
                }
                $data3 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and bdate like '%-$month%'");

                foreach ($data3->result() as $rows) {
                    $res2 = $rows->num_rows;
                }
                $data4 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and status='cancelled' and bdate like '%-$month%'");

                foreach ($data4->result() as $rows) {
                    $res3 = $rows->num_rows;
                }
                $data5 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and status='cancelled' and bdate like '%-$month%'");

                foreach ($data5->result() as $rows) {
                    $res4 = $rows->num_rows;
                }
                $data6 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and status='cancelled' and bdate like '%-$month%'");

                foreach ($data6->result() as $rows) {
                    $res5 = $rows->num_rows;
                }
                $data7 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and status='cancelled' and bdate like '%-$month%'");

                foreach ($data7->result() as $rows) {
                    $res6 = $rows->num_rows;
                }
                $net_booktotal = $res - $res5;
                $net_booktotal1 = $res2 - $res3;
                $net_booktotal2 = $res1 - $res4;
                $net_booktotal3 = $res7 - $res6;
                $gross = $res + $res2 + $res1 + $res7;
                $can = $res5 + $res3 + $res4 + $res6;
                $net = $net_booktotal + $net_booktotal1 + $net_booktotal2;
            }
        }
        if ($i == 2) {
            foreach ($data->result() as $rows) {
                $tot_val = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and bdate like '%-$month%'");

                foreach ($tot_val->result() as $rows) {
                    $totres = $rows->num_rows;
                }
                $data1 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='3' and bdate like '%-$month%'");

                foreach ($data1->result() as $rows) {
                    if ($totres == 0) {
                        $res = $totres;
                    } else {
                        $res = $rows->num_rows;
                    }
                }
                $tot_val1 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and bdate like '%-$month%'");

                foreach ($tot_val1->result() as $rows) {
                    $totres1 = $rows->num_rows;
                }
                $data2 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='1' and bdate like '%-$month%'");

                foreach ($data2->result() as $rows) {
                    if ($totres1 == 0) {
                        $res1 = $totres1;
                    }
                    $res1 = $rows->num_rows;
                }
                $tot_val6 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and bdate like '%-$month%'");

                foreach ($tot_val6->result() as $rows) {
                    $totres6 = $rows->num_rows;
                }
                $data7 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='4' and bdate like '%-$month%'");

                foreach ($data7->result() as $rows) {
                    if ($totres6 == 0) {
                        $res7 = $totres6;
                    } else {
                        $res7 = $rows->num_rows;
                    }
                }
                $tot_val2 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and bdate like '%-$month%'");

                foreach ($tot_val2->result() as $rows) {
                    $totres2 = $rows->num_rows;
                }
                $data3 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='2' and bdate like '%-$month%'");

                foreach ($data3->result() as $rows) {
                    if ($totres2 == 0) {
                        $res2 = $totres2;
                    } else {
                        $res2 = $rows->num_rows;
                    }
                }
                $tot_val3 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and status='cancelled' and bdate like '%-$month%'");

                foreach ($tot_val3->result() as $rows) {
                    $totres3 = $rows->num_rows;
                }
                $data4 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='2' and status='cancelled' and bdate like '%-$month%'");

                foreach ($data4->result() as $rows) {
                    if ($totres3 == 0) {
                        $res3 = $totres3;
                    } else {
                        $res3 = $rows->num_rows;
                    }
                }
                $tot_val4 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and status='cancelled' and bdate like '%-$month%'");

                foreach ($tot_val4->result() as $rows) {
                    $totres4 = $rows->num_rows;
                }
                $data5 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='1' and status='cancelled' and bdate like '%-$month%'");

                foreach ($data5->result() as $rows) {
                    if ($totres4 == 0) {
                        $res4 = $totres4;
                    } else {
                        $res4 = $rows->num_rows;
                    }
                }
                $tot_val5 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and status='cancelled' and bdate like '%-$month%'");

                foreach ($tot_val5->result() as $rows) {
                    $totres5 = $rows->num_rows;
                }
                $data6 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='3' and status='cancelled' and bdate like '%-$month%'");

                foreach ($data6->result() as $rows) {
                    if ($totres5 == 0) {
                        $res5 = $totres5;
                    } else {
                        $res5 = $rows->num_rows;
                    }
                }
                $tot_val7 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and status='cancelled' and bdate like '%-$month%'");

                foreach ($tot_val7->result() as $rows) {
                    $totres7 = $rows->num_rows;
                }
                $data8 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='4' and status='cancelled' and bdate like '%-$month%'");

                foreach ($data8->result() as $rows) {
                    if ($totres7 == 0) {
                        $res6 = $totres7;
                    } else {
                        $res6 = $rows->num_rows;
                    }
                }
                $net_booktotal = $res - $res5;
                $net_booktotal1 = $res2 - $res3;
                $net_booktotal2 = $res1 - $res4;
                $net_booktotal3 = $res7 - $res6;
                $gross = $res + $res2 + $res1 + $res7;
                $can = $res5 + $res3 + $res4 + $res6;
                $net = $net_booktotal + $net_booktotal1 + $net_booktotal2;
            }
        }
        echo '<tr style="font-size:12px">
                    <td id="td">API </td><td id="td">' . $res . '</td><td id="td">' . $res5 . '</td><td id="td">' . $net_booktotal . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Agent </td><td id="td">' . $res2 . '</td><td id="td">' . $res3 . '</td><td id="td">' . $net_booktotal1 . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Branch </td><td id="td">' . $res1 . '</td><td id="td">' . $res4 . '</td><td id="td">' . $net_booktotal2 . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Website </td><td id="td">' . $res7 . '</td><td id="td">' . $res6 . '</td><td id="td">' . $net_booktotal3 . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td"><b>Total</b></td><td id="td">' . $gross . '</td><td id="td">' . $can . '</td><td id="td">' . $net . '</td>
                    </tr>';

        echo '</table>';
    }

    function get_operator() {
        $sql = $this->db2->query("select travel_id,operator_title from registered_operators where status='1' ");
        $data = array();
        $data['0'] = "--select--";
        foreach ($sql->result() as $rows) {
            $data[$rows->travel_id] = $rows->operator_title;
        }
        return $data;
    }
	 function get_routes() {
        $sql = $this->db2->query("select route_id,source_name,destination_name from master_routes_international ");
        $data = array();
		 $data['0'] = "--select--";
        foreach ($sql->result() as $rows) {
            $data[$rows->route_id] = $rows->source_name.'-'.$rows->destination_name;
        }
        return $data;
    }
	
	 function get_stops() {
         $data = array();
		 $data['0'] = "--select--";
        for($i=1;$i<=20;$i++) {
            $data[$i] = $i;
        }
        return $data;
    }

    function get_summary_from_db($op, $i) {

        if ($op == 'all') {
            $this->get_bookings_from_db($i);
        } else {
            $now = date('Y-m-d');
            echo '
             <table id="tbl" align="center" width="600" border="0" style="border:#A4A4A4 solid 2px;">
                       <tr ><th id="tb" colspan="11" align="left" style="background-color:#D8D8D8; color: #000000; font-size:14px;">Summary of today</th></tr>
                       <tr style="font-size:12px">
                        <th id="tb"></th>
                        <th id="tb">Gross Bookings</th>
                        <th id="tb">Cancellations</th>
                        <th id="tb">Net Bookings</th>
                       </tr>';
            $this->db2->select('*');
            $query = $this->db2->get('master_booking');

            if ($i == 1) {
                foreach ($query->result() as $rows) {

                    $query1 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and  bdate ='$now'");

                    foreach ($query1->result() as $rows) {

                        $results = $rows->num_rows;
                    }
                    $query2 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and bdate ='$now'");

                    foreach ($query2->result() as $rows) {
                        $results1 = $rows->num_rows;
                    }
                    $query3 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and bdate ='$now'");

                    foreach ($query3->result() as $rows) {
                        $results2 = $rows->num_rows;
                    }
                    $query8 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and bdate ='$now'");

                    foreach ($query8->result() as $rows) {
                        $results7 = $rows->num_rows;
                    }
                    $query4 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and status='cancelled' and bdate ='$now'");

                    foreach ($query4->result() as $rows) {
                        $results3 = $rows->num_rows;
                    }

                    $query5 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and status='cancelled' and bdate ='$now'");

                    foreach ($query5->result() as $rows) {
                        $results4 = $rows->num_rows;
                    }
                    $query6 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and status='cancelled' and bdate ='$now'");

                    foreach ($query6->result() as $rows) {
                        $results5 = $rows->num_rows;
                    }
                    $query7 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and status='cancelled' and bdate ='$now'");

                    foreach ($query7->result() as $rows) {
                        $results6 = $rows->num_rows;
                    }
                    $net_total = $results - $results5;
                    $net_total1 = $results2 - $results3;
                    $net_total2 = $results1 - $results4;
                    $net_total3 = $results7 - $results6;
                    $gross_book = $results + $results2 + $results1 + $results7;
                    $can_book = $results5 + $results3 + $results4 + $results6;
                    $net_book = $net_total + $net_total1 + $net_total2;
                }
            }
            if ($i == 2) {
                foreach ($query->result() as $rows) {
                    $res_query = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and bdate like '%$now%'");

                    foreach ($res_query->result() as $rows) {
                        $tot_res = $rows->num_rows;
                    }
                    $query1 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and bdate like '%$now%'");

                    foreach ($query1->result() as $rows) {
                        if ($tot_res == 0) {
                            $results = $tot_res;
                        } else {
                            $results = $rows->num_rows;
                        }
                    }

                    $res_query1 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and bdate like '%$now%'");

                    foreach ($res_query1->result() as $rows) {
                        $tot_res1 = $rows->num_rows;
                    }
                    $query2 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and bdate like '%$now%'");

                    foreach ($query2->result() as $rows) {
                        if ($tot_res1 == 0) {
                            $results1 = $tot_res1;
                        } else {
                            $results1 = $rows->num_rows;
                        }
                    }

                    $res_query6 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and bdate like '%$now%'");

                    foreach ($res_query6->result() as $rows) {
                        $tot_res6 = $rows->num_rows;
                    }
                    $query7 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and bdate like '%$now%'");

                    foreach ($query7->result() as $rows) {
                        if ($tot_res6 == 0) {
                            $results7 = $tot_res6;
                        } else {
                            $results7 = $rows->num_rows;
                        }
                    }
                    $res_query2 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and bdate like '%$now%'");

                    foreach ($res_query2->result() as $rows) {
                        $tot_res2 = $rows->num_rows;
                    }
                    $query3 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and bdate like '%$now%'");

                    foreach ($query3->result() as $rows) {
                        if ($tot_res2 == 0) {
                            $results2 = $tot_res2;
                        } else {
                            $results2 = $rows->num_rows;
                        }
                    }
                    $res_query3 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

                    foreach ($res_query3->result() as $rows) {
                        $tot_res3 = $rows->num_rows;
                    }
                    $query4 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

                    foreach ($query4->result() as $rows) {
                        if ($tot_res3 == 0) {
                            $results3 = $tot_res3;
                        } else {
                            $results3 = $rows->num_rows;
                        }
                    }
                    $res_query4 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

                    foreach ($res_query4->result() as $rows) {
                        $tot_res4 = $rows->num_rows;
                    }
                    $query5 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

                    foreach ($query5->result() as $rows) {
                        if ($tot_res4 == 0) {
                            $results4 = $tot_res4;
                        } else {
                            $results4 = $rows->num_rows;
                        }
                    }
                    $res_query5 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

                    foreach ($res_query5->result() as $rows) {
                        $tot_res5 = $rows->num_rows;
                    }
                    $query6 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

                    foreach ($query6->result() as $rows) {
                        if ($tot_res5 == 0) {
                            $results5 = $tot_res5;
                        } else {
                            $results5 = $rows->num_rows;
                        }
                    }
                    $res_query7 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

                    foreach ($res_query7->result() as $rows) {
                        $tot_res7 = $rows->num_rows;
                    }
                    $query8 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

                    foreach ($query8->result() as $rows) {
                        if ($tot_res7 == 0) {
                            $results6 = $tot_res7;
                        } else {
                            $results6 = $rows->num_rows;
                        }
                    }
                    $net_total = $results - $results5;
                    $net_total1 = $results2 - $results3;
                    $net_total2 = $results1 - $results4;
                    $net_total3 = $results7 - $results6;
                    $gross_book = $results + $results2 + $results1 + $results7;
                    $can_book = $results5 + $results3 + $results4 + $results6;
                    $net_book = $net_total + $net_total1 + $net_total2;
                }
            }
            echo '<tr style="font-size:12px">
                    <td id="td">API</td><td id="td">' . $results . '</td><td id="td">' . $results5 . '</td><td id="td">' . $net_total . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Agent</td><td id="td">' . $results2 . '</td><td id="td">' . $results3 . '</td><td id="td">' . $net_total1 . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Branch</td><td id="td">' . $results1 . '</td><td id="td">' . $results4 . '</td><td id="td">' . $net_total2 . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Website</td><td id="td">' . $results7 . '</td><td id="td">' . $results6 . '</td><td id="td">' . $net_total3 . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td"><b>Total</b></td><td id="td">' . $gross_book . '</td><td id="td">' . $can_book . '</td><td id="td">' . $net_book . '</td>
                    </tr>';

            echo '</table><br /><br />';


            echo '<table id="tbl" align="center" width="600" border="0" style="border:#A4A4A4 solid 2px;">
                       <tr ><th id="tb" colspan="11" align="left" style="background-color:#D8D8D8; color: #000000; font-size:14px;">Summary of Month</th></tr>
                       <tr style="font-size:12px">
                        <th id="tb"></th>
                        <th id="tb">Gross Bookings</th>
                        <th id="tb">Cancellations</th>
                        <th id="tb">Net Bookings</th>
                       </tr>';
            $this->db2->select('*');
            $data = $this->db2->get('master_booking');
            $month = date('m');

            if ($i == 1) {
                foreach ($data->result() as $rows) {

                    $data1 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and bdate like '%-$month%'");

                    foreach ($data1->result() as $rows) {
                        $res = $rows->num_rows;
                    }
                    $data2 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and bdate like '%-$month%'");

                    foreach ($data2->result() as $rows) {
                        $res1 = $rows->num_rows;
                    }
                    $data8 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and bdate like '%-$month%'");

                    foreach ($data8->result() as $rows) {
                        $res7 = $rows->num_rows;
                    }
                    $data3 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and bdate like '%-$month%'");

                    foreach ($data3->result() as $rows) {
                        $res2 = $rows->num_rows;
                    }
                    $data4 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

                    foreach ($data4->result() as $rows) {
                        $res3 = $rows->num_rows;
                    }
                    $data5 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

                    foreach ($data5->result() as $rows) {
                        $res4 = $rows->num_rows;
                    }
                    $data6 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

                    foreach ($data6->result() as $rows) {
                        $res5 = $rows->num_rows;
                    }
                    $data7 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

                    foreach ($data7->result() as $rows) {
                        $res6 = $rows->num_rows;
                    }
                    $net_booktotal = $res - $res5;
                    $net_booktotal1 = $res2 - $res3;
                    $net_booktotal2 = $res1 - $res4;
                    $net_booktotal3 = $res7 - $res6;
                    $gross = $res + $res2 + $res1 + $res7;
                    $can = $res5 + $res3 + $res4 + $res6;
                    $net = $net_booktotal + $net_booktotal1 + $net_booktotal2;
                }
            }
            if ($i == 2) {
                foreach ($data->result() as $rows) {
                    $tot_val = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and bdate like '%-$month%'");

                    foreach ($tot_val->result() as $rows) {
                        $totres = $rows->num_rows;
                    }
                    $data1 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and bdate like '%-$month%'");

                    foreach ($data1->result() as $rows) {
                        if ($totres == 0) {
                            $res = $totres;
                        } else {
                            $res = $rows->num_rows;
                        }
                    }
                    $tot_val1 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and bdate like '%-$month%'");

                    foreach ($tot_val1->result() as $rows) {
                        $totres1 = $rows->num_rows;
                    }
                    $data2 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and bdate like '%-$month%'");

                    foreach ($data2->result() as $rows) {
                        if ($totres1 == 0) {
                            $res1 = $totres1;
                        }
                        $res1 = $rows->num_rows;
                    }
                    $tot_val6 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and bdate like '%-$month%'");

                    foreach ($tot_val6->result() as $rows) {
                        $totres6 = $rows->num_rows;
                    }
                    $data7 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and bdate like '%-$month%'");

                    foreach ($data7->result() as $rows) {
                        if ($totres6 == 0) {
                            $res7 = $totres6;
                        } else {
                            $res7 = $rows->num_rows;
                        }
                    }
                    $tot_val2 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and bdate like '%-$month%'");

                    foreach ($tot_val2->result() as $rows) {
                        $totres2 = $rows->num_rows;
                    }
                    $data3 = $this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and bdate like '%-$month%'");

                    foreach ($data3->result() as $rows) {
                        if ($totres2 == 0) {
                            $res2 = $totres2;
                        } else {
                            $res2 = $rows->num_rows;
                        }
                    }
                    $tot_val3 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

                    foreach ($tot_val3->result() as $rows) {
                        $totres3 = $rows->num_rows;
                    }
                    $data4 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

                    foreach ($data4->result() as $rows) {
                        if ($totres3 == 0) {
                            $res3 = $totres3;
                        } else {
                            $res3 = $rows->num_rows;
                        }
                    }
                    $tot_val4 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

                    foreach ($tot_val4->result() as $rows) {
                        $totres4 = $rows->num_rows;
                    }
                    $data5 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

                    foreach ($data5->result() as $rows) {
                        if ($totres4 == 0) {
                            $res4 = $totres4;
                        } else {
                            $res4 = $rows->num_rows;
                        }
                    }
                    $tot_val5 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

                    foreach ($tot_val5->result() as $rows) {
                        $totres5 = $rows->num_rows;
                    }
                    $data6 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

                    foreach ($data6->result() as $rows) {
                        if ($totres5 == 0) {
                            $res5 = $totres5;
                        } else {
                            $res5 = $rows->num_rows;
                        }
                    }
                    $tot_val7 = $this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

                    foreach ($tot_val7->result() as $rows) {
                        $totres7 = $rows->num_rows;
                    }
                    $data8 = $this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

                    foreach ($data8->result() as $rows) {
                        if ($totres7 == 0) {
                            $res6 = $totres7;
                        } else {
                            $res6 = $rows->num_rows;
                        }
                    }
                    $net_booktotal = $res - $res5;
                    $net_booktotal1 = $res2 - $res3;
                    $net_booktotal2 = $res1 - $res4;
                    $net_booktotal3 = $res7 - $res6;
                    $gross = $res + $res2 + $res1 + $res7;
                    $can = $res5 + $res3 + $res4 + $res6;
                    $net = $net_booktotal + $net_booktotal1 + $net_booktotal2;
                }
            }
            echo '<tr style="font-size:12px">
                    <td id="td">API </td><td id="td">' . $res . '</td><td id="td">' . $res5 . '</td><td id="td">' . $net_booktotal . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Agent </td><td id="td">' . $res2 . '</td><td id="td">' . $res3 . '</td><td id="td">' . $net_booktotal1 . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Branch </td><td id="td">' . $res1 . '</td><td id="td">' . $res4 . '</td><td id="td">' . $net_booktotal2 . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Website </td><td id="td">' . $res7 . '</td><td id="td">' . $res6 . '</td><td id="td">' . $net_booktotal3 . '</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td"><b>Total</b></td><td id="td">' . $gross . '</td><td id="td">' . $can . '</td><td id="td">' . $net . '</td>
                    </tr>';

            echo '</table>';
        }
    }

    function getAgentName($agentn, $agent_type) {
        $this->db2 = $this->load->database('forum', TRUE);
        if ($agent_type == "te")
            $sql = $this->db2->query("select name,id from agents_operator where (pay_type='$agentn' and agent_type='$agent_type' and api_type='te')");
        else if ($agent_type == 3)
            $sql = $this->db2->query("select name,id from agents_operator where (pay_type='$agentn' and agent_type='$agent_type' and api_type='op')");
        else
            $sql = $this->db2->query("select name,id from agents_operator where (pay_type='$agentn' and agent_type='$agent_type')");
        $data = array();
        $data[0] = "-----select-----";
        foreach ($sql->result() as $rows) {
            $data[$rows->id] = $rows->name;
        }
        return $data;
    }

    function showOperators() {

        $sql = $this->db2->query("select name,travel_id from registered_operators");
        $data = array();
        $data[0] = "-----select-----";
        foreach ($sql->result() as $rows) {
            $data[$rows->travel_id] = $rows->name;
        }
        return $data;
    }

    function prepaid_agents_db($at) {
        $op = $this->input->post('op');
        $this->db2->select('*');
        $this->db2->where('agent_type', $at);
        $this->db2->where('pay_type', 'prepaid');
        if ($op != 'all') {
            $this->db2->where('operator_id', $op);
        } else {
            
        }

        $query1 = $this->db2->get("agents_operator");
        echo "<table class='gridtable' style='margin: 0px auto; width='550'>";
        echo "<tr >";
        echo "<th>Name</th>";
        echo "<th>Username</th>";
        echo "<th>Password</th>";
        echo "<th>Contact No.</th>";
        echo "<th>Email Id</th>";
        echo "<th>Balance</th>";
        echo "<th>Margin</th>";
        echo "<th>Pay Type</th>";
        echo "<th>Limit</th>";
        echo "<th>Status</th>";
        echo "<th>Option</th>";
        echo "</tr>";
        $i = 1;
        foreach ($query1->result() as $row) {
            $uid = $row->id;
            $status = $row->status;
            if ($status == 1) {
                $x = 'Active';
            } else {
                $status = 0;
                $x = 'Inactive';
            }

            echo '<tr  align="center">';

            echo "<td style='font-size:12px';>" . $row->name . "</td>";
            echo "<td style='font-size:12px';>" . $row->uname . "</td>";
            echo "<td style='font-size:12px';>" . $row->password . "</td>";
            echo "<td style='font-size:12px;'>" . $row->mobile . "</td>";
            echo "<td style='font-size:12px;'>" . $row->email . "</td>";
            echo "<td style='font-size:12px;'>" . $row->balance . "</td>";
            echo "<td style='font-size:12px;'>" . $row->margin . "</td>";
            echo "<td style='font-size:12px;'>" . $row->pay_type . "</td>";
            echo "<td style='font-size:12px;'>" . $row->bal_limit . "</td>";
            echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;' onclick='status(" . $i . "," . $status . "," . $uid . ")'>" . $x . "</span></td>";
            echo "<td>" . anchor('master_control/UpdateDet?id=' . $uid, 'Update', '') . "</td>";
            echo "</tr>";
            $i++;
        }
        echo "</table>";
    }

    function postpaid_agents_db($at) {
        $op = $this->input->post('op');
        $this->db2->select('*');
        $this->db2->where('agent_type', $at);
        $this->db2->where('pay_type', 'postpaid');
        if ($op != 'all') {
            $this->db2->where('operator_id', $op);
        } else {
            
        }

        $query1 = $this->db2->get("agents_operator");
        echo "<table class='gridtable' style='margin: 0px auto; width='550'>";
        echo "<tr >";
        echo "<th>Name</th>";
        echo "<th>Username</th>";
        echo "<th>Password</th>";
        echo "<th>Contact No.</th>";
        echo "<th>Email Id</th>";
        echo "<th>Balance</th>";
        echo "<th>Margin</th>";
        echo "<th>Pay Type</th>";
        echo "<th>Limit</th>";
        echo "<th>Status</th>";
        echo "<th>Option</th>";
        echo "</tr>";
        $i = 1;
        foreach ($query1->result() as $row) {
            $uid = $row->id;
            $status = $row->status;
            $e = 'Edit';
            if ($status == 1) {
                $x = 'Active';
            } else {
                $status = 0;
                $x = 'Inactive';
            }

            echo '<tr  align="center">';

            echo "<td style='font-size:12px';>" . $row->name . "</td>";
            echo "<td style='font-size:12px';>" . $row->uname . "</td>";
            echo "<td style='font-size:12px';>" . $row->password . "</td>";
            echo "<td style='font-size:12px;'>" . $row->mobile . "</td>";
            echo "<td style='font-size:12px;'>" . $row->email . "</td>";
            echo "<td style='font-size:12px;'>" . $row->balance . "</td>";
            echo "<td style='font-size:12px;'>" . $row->margin . "</td>";
            echo "<td style='font-size:12px;'>" . $row->pay_type . "</td>";
            echo "<td style='font-size:12px;'>" . $row->bal_limit . "</td>";
            echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;' onclick='status(" . $i . "," . $status . "," . $uid . ")'>" . $x . "</span></td>";
            echo "<td>" . anchor('master_control/UpdateDet?id=' . $uid, 'Update', '') . "</td>";
            echo "</tr>";
            $i++;
        }
        echo "</table>";
    }

    function Branch_agents_db($at) {
        $op = $this->input->post('op');
        $this->db2->select('*');
        $this->db2->where('agent_type', $at);
        if ($op != 'all') {
            $this->db2->where('operator_id', $op);
        } else {
            
        }

        $query1 = $this->db2->get("agents_operator");

        echo "<table style='margin: 0px auto;' class='gridtable'  width='550'>";
        echo "<tr>";
        echo "<th>Name</th>";
        echo "<th>Username</th>";
        echo "<th>Password</th>";
        echo "<th>Contact No.</th>";
        echo "<th>Email Id</th>";
        echo "<th>Balance</th>";
        echo "<th>Margin</th>";
        echo "<th>Pay Type</th>";
        echo "<th>Limit</th>";
        echo "<th>Status</th>";
        echo "<th>Option</th>";
        echo "</tr>";
        $i = 1;
        foreach ($query1->result() as $row) {
            $uid = $row->id;
            $status = $row->status;
            if ($status == 1) {
                $x = 'Active';
            } else {
                $status = 0;
                $x = 'Inactive';
            }

            echo "<tr>";

            echo "<td style='font-size:12px';>" . $row->name . "</td>";
            echo "<td style='font-size:12px';>" . $row->uname . "</td>";
            echo "<td style='font-size:12px';>" . $row->password . "</td>";
            echo "<td style='font-size:12px;'>" . $row->mobile . "</td>";
            echo "<td style='font-size:12px;'>" . $row->email . "</td>";
            echo "<td style='font-size:12px;'>" . $row->balance . "</td>";
            echo "<td style='font-size:12px;'>" . $row->margin . "</td>";
            echo "<td style='font-size:12px;'>" . $row->pay_type . "</td>";
            echo "<td style='font-size:12px;'>" . $row->bal_limit . "</td>";
            echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;' onclick='status(" . $i . "," . $status . "," . $uid . ")'>" . $x . "</span></td>";
            echo "<td>" . anchor('master_control/UpdateDet?id=' . $uid, 'Update', '') . "</td>";
            echo "</tr>";
            $i++;
        }
        echo "</table>";
    }

    function getBilledValue_detail() {
        $this->db2 = $this->load->database('forum', TRUE);
        $bill = $this->input->post('bill');
        if ($bill != 'all') {
            $this->db2->where('bill_type', $bill);
            $this->db2->where('status', 1);
            $query1 = $this->db2->get("registered_operators");
        } else {
            $this->db2->where('status', 1);
            $query1 = $this->db2->get("registered_operators");
        }




        $i = 1;
//print_r($query1->result());
        if ($query1->num_rows() > 0) {
            echo '<div id="mydiv"><table style="font-size:13px; background:#84a3b8;"  width="550" align="center">';
            echo "<tr>";
            echo "<th>operator</th>";
            echo "<th>name</th>";
            echo "<th> Bill_Type</th>";
            echo "<th>Bill_Amount</th>";
            echo "<th>Net Fare</th>";
            echo "<th>Billed</th>";

            echo "</tr>";
            foreach ($query1->result() as $row) {
                $class = ($i % 2 == 0) ? 'bg' : 'bg1';
                $uid = $row->id;
                $bill_amt = $row->bill_amt;
                $billtype = $row->bill_type;
                if ($billtype == '' || $billtype == 'bus')
                    $billtype = "bus";
                else
                    $billtype = $billtype;
                $query2 = $this->db2->query("select sum(tkt_fare) as netfare from master_booking where agent_id='$uid'");

                $query3 = $this->db2->query("select sum(pass) as nopass from master_booking where agent_id='$uid'");
                foreach ($query2->result() as $row2) {
                    $netfare = $row2->netfare;
                }
                foreach ($query3->result() as $row3) {
                    $nopass = $row3->nopass;
                    $billed = $nopass * $bill_amt;
                }
                echo "<tr class='" . $class . "'>";

                echo "<td style='font-size:12px';>" . $row->operator_title . "</td>";
                echo "<td style='font-size:12px';>" . $row->name . "</td>";
                echo "<td style='font-size:12px;'>" . $billtype . "</td>";
                echo "<td style='font-size:12px;'>" . $bill_amt . "</td>";
                echo "<td style='font-size:12px;'>" . $netfare . "</td>";
                echo "<td style='font-size:12px;'>" . $billed . "</td>";
                echo "</tr>";
                $i++;
            }
            echo "</table></div>";
            echo '<table align="center"><tr><td><input type="button" value="print" onclick="getprint(mydiv)"></td></tr></table>';
        } else {
            echo "0";
        }
    }

    function operator_detail_update_in_db() {
        $this->db2 = $this->load->database('forum', TRUE);
        $optitle = $this->input->post('optitle');
        $firm_type = $this->input->post('firm_type');
        $name = $this->input->post('name');
        $address = $this->input->post('address');
        $location = $this->input->post('location');
        $contact_no = $this->input->post('contact_no');
        $fax_no = $this->input->post('fax_no');
        $email_id = $this->input->post('email_id');
        $pan_no = $this->input->post('pan_no');
        $bank_name = $this->input->post('bank_name');
        $bank_account_no = $this->input->post('bank_account_no');
        $branch = $this->input->post('branch');
        $ifsc_code = $this->input->post('ifsc_code');
        $travel_id = $this->input->post('travel_id');
        $user_name = $this->input->post('user_name');
        $bill_type = $this->input->post('bill_type');
        $bill_amt = $this->input->post('bill_amt');
        $id = $this->input->post('id');

        $up = $this->db2->query("update registered_operators set  operator_title='$optitle',
         firm_type='$firm_type',name='$name',
             address='$address'
             ,location='$location',contact_no='$contact_no',fax_no='$fax_no',
                 email_id='$email_id',pan_no='$pan_no',bank_name='$bank_name',
             bank_account_no='$bank_account_no',branch='$branch',ifsc_code='$ifsc_code',travel_id='$travel_id',
                 user_name='$user_name',bill_type='$bill_type',bill_amt='$bill_amt' where id='$id'");
        if ($up)
            echo 1;
        else
            echo 0;
    }

    function getoperatorWise_report() {
        $this->db2 = $this->load->database('forum', TRUE);
        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');
        $this->db2->distinct("*");
        $this->db2->select("travel_id");
        $opdata = $this->db2->get("master_buses");
        echo "<table style='font-size:13px;   width='650' align='center'>
                <tr style='font-size:13px; color:#ffffff; background:#84a3b8;'>
                <th width='171'>Operator Name</th>
                <th width='137' height='21'>Total Seats</th>
                <th width='157'>Seat booked</th>
                <th width='165'>Occupancy%</th>
                </tr>";
        $i = 1;
        foreach ($opdata->result() as $row) {
            $seat_nos_count = 0;

            $travel_id = $row->travel_id;
            $this->db2->select("operator_title");
            $this->db2->where("travel_id", $travel_id);
            $opdata1 = $this->db2->get("registered_operators");
            foreach ($opdata1->result() as $row) {
                $name = $row->operator_title;
            }
            $resquery = $this->db2->query("select distinct service_num from master_buses where travel_id='$travel_id' and status='1'");
            foreach ($resquery->result() as $rowsss) {
                $service_num = $rowsss->service_num;
                //echo $service_num."/";  
                $res_query = $this->db2->query("select seat_nos from master_buses where  status='1' and service_num='$service_num'");
                $res_query1 = $this->db2->query("select count(distinct journey_date) as num_rows1 from buses_list where (journey_date BETWEEN '" . $fdate . "' AND '" . $tdate . "') and status='1'  and service_num='$service_num'");
                foreach ($res_query->result() as $rows1) {
                    $seat_nos = $rows1->seat_nos; //total seat of particular service number
                }
                foreach ($res_query1->result() as $v2) {
                    $avail_days = $v2->num_rows1; //available days of particular service number
                }
                //getting total seats of particular service number
                $count = $avail_days * $seat_nos;
                $seat_nos_count = $seat_nos_count + $count;
            }
            $query3 = $this->db2->query("select  sum(pass) as bookseat from master_booking where travel_id='$travel_id'   and (bdate BETWEEN '" . $fdate . "' AND '" . $tdate . "') and (status='confirmed' || status='Confirmed')");
            $query4 = $this->db2->query("select  sum(pass) as canseat from master_booking where  travel_id='$travel_id' and (bdate BETWEEN '" . $fdate . "' AND '" . $tdate . "') and (status='cancelled' || status='Cancelled')");

            foreach ($query3->result() as $rows) {
                $bookseat = $rows->bookseat;
            }
            foreach ($query4->result() as $rowss) {
                $canseat = $rowss->canseat;
            }
            $totbook = $bookseat - $canseat;
            if ($seat_nos_count == 0)
                $da = 0;
            else
                $da = $totbook / $seat_nos_count;
            $oc = ($da) * 100;
            $occupancy = sprintf("%.3f", $oc);
            $class = ($i % 2 == 0) ? 'bg' : 'bg1';
            echo '<tr class="' . $class . '">';
            echo '<td height="30">' . $name . '</td>';
            echo '<td>' . $seat_nos_count . '</td>';
            echo '<td>' . $totbook . '</td>';
            echo '<td>' . $occupancy . '</td>';
            echo '</tr>';
            $i++;
        }
        echo '</table>';
    }

    function getOperator_Service_report() {
        $this->db2 = $this->load->database('forum', TRUE);
        $optravel_id = $this->input->post('opid');
        if ($optravel_id == 0) {
            $query = $this->db2->query("select distinct service_num from master_buses");
        } else {
            $query = $this->db2->query("select distinct service_num from master_buses where travel_id='$optravel_id'");
        }

        if ($query->num_rows() == 0) {
            echo "<table style='font-size:13px;   width='350' align='center'>
                <tr style='font-size:13px; color:red; '>
                <td width='171'>No Records found</td></table>";
        } else {
            echo "<table style='font-size:13px;   width='980' align='center' border='0'>
                <tr style='font-size:13px; color:#ffffff; background:#84a3b8;'>
                <th width='100'>Services No.</th>
                <th width='300' height='21'>Routes</th>
                <th width='37'>Fares</th>
                <th width='60'>Bus Type</th>
                 <th width='55'>No Of Seats</th>
                  <th width='40' align='center'>Start Time</th>
                   <th width='200'>Views</th>
                </tr>";
            $i = 1;
            foreach ($query->result() as $val) {
                $serno = $val->service_num;

                $query1 = $this->db2->query("select distinct from_id,from_name from master_buses where service_num='$serno'");
                $query2 = $this->db2->query("select distinct to_id,to_name from master_buses where service_num='$serno'");
                $query3 = $this->db2->query("select * from master_buses where service_num='$serno'");
                $from = '';
                $from_id = '';
                $to = '';
                $to_id = '';
                $j = 1;
                foreach ($query1->result() as $val1) {
                    $from_name = $val1->from_name;
                    $from_id = $val1->from_id;
                    if ($from == '')
                        $from = "$from_name($from_id)";
                    elseif ($j % 4 != 0 && $from != '')
                        $from = $from . "," . $val1->from_name . "(" . $from_id . ")";
                    elseif ($j % 4 == 0 && $from != '')
                        $from = $from . "," . $val1->from_name . "(" . $from_id . ")<br/>";
                    $j++;
                }
                $j = 1;
                foreach ($query2->result() as $val2) {
                    $to_name = $val2->to_name;
                    $to_id = $val2->to_id;
                    if ($to == '')
                        $to = "$to_name($to_id)";
                    elseif ($j % 3 != 0 && $to != '')
                        $to = $to . "," . $val2->to_name . "(" . $to_id . ")";
                    elseif ($j % 3 == 0 && $to != '')
                        $to = $to . "," . $val2->to_name . "(" . $to_id . ")<br/>";
                    $j++;
                }
                foreach ($query3->result() as $val3) {
                    $bus_type = $val3->bus_type;
                    $fare = 0;
                    if ($bus_type == 'seater')
                        $fare = $val3->seat_fare;
                    else if ($bus_type == 'sleeper')
                        $fare = $val3->lberth_fare . "," . $val3->uberth_fare;
                    else
                        $fare = $val3->seat_fare . "," . $val3->lberth_fare . "," . $val3->uberth_fare;
                    //echo $bus_type;
                    $seat_nos = $val3->seat_nos;
                    $start_time = $val3->start_time;
                    $travel_id = $val3->travel_id;
                } $class = ($i % 2 == 0) ? 'bg' : 'bg1';
                echo '<tr class="' . $class . '">';
                echo '<td height="30">' . $serno . '</td>';
                echo '<td width="300">' . $from . ' <span style="color:blue;"> To </span>  ' . $to . '</td>';
                echo '<td>' . $fare . '</td>';
                echo '<td>' . $bus_type . '</td>';
                echo '<td>' . $seat_nos . '</td>';
                echo '<td>' . $start_time . '</td>';
                echo '<td width="200">
                        <a href="javascript:void()" onclick="layout(' . $i . ')" class="lay' . $i . '">Layout</a></br>
                        <a href="javascript:void()" onclick="boarding(' . $i . ')" class="board' . $i . '">Boarding</a><br>
                        <a href="javascript:void()" onclick="eminities(' . $i . ')" class="emi' . $i . '">eminities</a>
                            <input type="hidden" id="hd' . $i . '" value="' . $serno . '">
                            </td>';

                echo '</tr>';
                echo '<tr><td colspan="7" id="sh' . $i . '" > </td></tr>';
                $i++;
            }
            echo '</table>';
            echo '<input type="hidden" id="cnt" value="' . $i . '">';
        }
    }

    function getOperator_Service_bording_details() {

        $this->db2 = $this->load->database('forum', TRUE);
        $serviceno = $this->input->post('serviceno');

        $query = $this->db2->query("select * from boarding_points where service_num='$serviceno' and board_or_drop_type='board'");
        echo '<table  border="1" align="center" cellpadding="0" cellspacing="0">
         <tr style="font-size:13px; color:#ffffff; background:#58a3b8;"><td>Board</td><td>Contact</td></tr>';
        $j = 1;
        foreach ($query->result() as $val) {
            $boardpt = $val->board_drop;
            $contact = $val->contact;
            $class = ($j % 2 == 0) ? 'bg' : 'bg1';
            echo "<tr class=$class><td>$boardpt</td><td>$contact</td></tr>";
            $j++;
        }
        echo '</table>';
    }

    function getOperator_Service_eminities_details() {
        $this->db2 = $this->load->database('forum', TRUE);
        $serviceno1 = $this->input->post('serviceno1');
        $query = $this->db2->query("select * from eminities where service_num='$serviceno1'");

        foreach ($query->result() as $val) {
            $water = $val->water_bottle;
            $blanket = $val->blanket;
            $cp = $val->charging_point;
            $vedio = $val->video;
        }
        echo "<table border='1' align='center' cellpadding='0' cellspacing='0' width=200px style='style='border-color:#009999'>
         <tr style='font-family: Arial, Helvetica, sans-serif; font-size:12px;'><td>Water:</td><td>$water</td></tr>
         <tr style='background-color:#eff3f5;font-family: Arial, Helvetica, sans-serif; font-size:12px;'><td>Blanket:</td><td>$blanket</td></tr>
            <tr style='font-family: Arial, Helvetica, sans-serif; font-size:12px;'> <td>Charging Point:</td><td>$cp</td></tr>
                <tr style='background-color:#eff3f5;font-family: Arial, Helvetica, sans-serif; font-size:12px;'> <td>Video:</td><td>$vedio</td></tr></table>";
    }

    function getOperator_Service_Layout_details() {
        $sernum = $this->input->post('serviceno2');

        $this->db->select('layout_id,seat_type');
        $this->db2->where('service_num', $sernum);
        $sql = $this->db2->get('master_layouts');
        foreach ($sql->result() as $row) {
            $layout_id = $row->layout_id;
            $seat_type = $row->seat_type;
            $lid = explode("#", $layout_id);
        }

        echo '<table><tr>
    <td align="center"  style="border-left:#f2f2f2 solid 4px;">';
        if ($lid[1] == 'seater') {
            //getting max of row and col from mas_layouts
            $this->db2->select_max('row', 'mrow');
            $this->db2->select_max('col', 'mcol');
            $this->db2->where('service_num', $sernum);
            //$this->db2->where('travel_id',$travel_id);
            $sq11 = $this->db2->get('master_layouts');
            $seat_name = '';
            foreach ($sq11->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }
            echo "<table border='1' cellpadding='0' align='center' >";
            for ($i = 1; $i <= $mcol; $i++) {
                echo "<tr>";
                for ($j = 1; $j <= $mrow; $j++) {
                    $this->db2->select('*');
                    $this->db2->where('row', $j);
                    $this->db2->where('col', $i);
                    $this->db2->where('service_num', $sernum);
                    //$this->db2->where('travel_id',$travel_id);
                    $sql3 = $this->db2->get('master_layouts');
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
            $this->db2->select_max('row', 'mrow');
            $this->db2->select_max('col', 'mcol');
            $this->db2->where('service_num', $sernum);
            //$this->db2->where('travel_id',$travel_id);
            $this->db2->where('seat_type', 'U');
            $sq1 = $this->db2->get('master_layouts');
            foreach ($sq1->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }


            echo "<span style='font-size:14px; font-weight:bold;'>UpperDeck</span> <br/>";
            echo "<table border='1' cellpadding='0'>";
            for ($k = 1; $k <= $mcol; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mrow; $l++) {
                    $this->db2->select('*');
                    $this->db2->where('row', $l);
                    $this->db2->where('col', $k);
                    $this->db2->where('service_num', $sernum);
                    // $this->db2->where('travel_id',$travel_id);
                    $this->db2->where('seat_type', 'U');
                    $sql3 = $this->db2->get('master_layouts');
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
            $this->db2->select_max('row', 'mrow');
            $this->db2->select_max('col', 'mcol');
            $this->db2->where('service_num', $sernum);
            //$this->db2->where('travel_id',$travel_id);
            $this->db2->where('seat_type', 'L');
            $sq1 = $this->db2->get('master_layouts');
            foreach ($sq1->result() as $row1) {
                $mrow = $row1->mrow;
                $mcol = $row1->mcol;
            }
            echo "<span style='font-size:14px; font-weight:bold;'>LowerDeck</span><br/>";
            echo "<table border='1' cellpadding='0'>";
            for ($k = 1; $k <= $mcol; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mrow; $l++) {
                    $this->db2->select('*');
                    $this->db2->where('row', $l);
                    $this->db2->where('col', $k);
                    $this->db2->where('service_num', $sernum);
                    // $this->db2->where('travel_id',$travel_id);
                    $this->db2->where('seat_type', 'L');
                    $sql3 = $this->db2->get('master_layouts');
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
            echo '</table></td></tr></table>
                </td>
                </tr>
              </table>';
        }// if(sleeper)
        else if ($lid[1] == 'seatersleeper') {

            //getting max of row and col from mas_layouts
            //UpperDeck
            $this->db2->select_max('row', 'mrow');
            $this->db2->select_max('col', 'mcol');
            $this->db2->where('service_num', $sernum);
            //$this->db2->where('travel_id',$travel_id);
            $this->db2->where('seat_type', 'U');
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
                    $this->db2->select('*');
                    $this->db2->where('row', $l);
                    $this->db2->where('col', $k);
                    $this->db2->where('service_num', $sernum);
                    //$this->db2->where('travel_id',$travel_id);
                    $this->db2->where('seat_type', 'U');
                    $sql3 = $this->db2->get('master_layouts');
                    foreach ($sql3->result() as $row2) {
                        $seat_name = $row2->seat_name;
                        $available = $row2->available;
                        $available_type = $row2->available_type;
                        $seat_type = $row2->seat_type;
                    }
                    if ($seat_type == 'U:b')
                        $st = "(B)";
                    else if ($seat_type == 'U:s')
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

            $this->db2->select_max('row', 'mroww');
            $this->db2->select_max('col', 'mcoll');
            $this->db2->where('service_num', $sernum);
            //$this->db2->where('travel_id',$travel_id);
            $this->db2->where("(seat_type='L:b' OR seat_type='L:s')");
            $sq1l = $this->db2->get('master_layouts');
            foreach ($sq1l->result() as $roww) {
                $mroww = $roww->mroww;
                $mcoll = $roww->mcoll;
            }
            echo "<span style='font-size:14px; font-weight:bold;'>LowerDeck</span><br/>";
            echo "<table border='1' cellpadding='0'>";
            for ($k = 1; $k <= $mcoll; $k++) {
                echo "<tr>";
                for ($l = 1; $l <= $mroww; $l++) {
                    $this->db2->select('*');
                    $this->db2->where('row', $l);
                    $this->db2->where('col', $k);
                    $this->db2->where('service_num', $sernum);
                    //$this->db2->where('travel_id',$travel_id);
                    $this->db2->where("(seat_type='L:b' OR seat_type='L:s')");
                    $sql3 = $this->db2->get('master_layouts');
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

    function busAnalysis() {


        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');
        $travel_id = $this->input->post('op');
        echo "<table align='center'  width='650'>
                <tr style='font-size:13px; color:#ffffff; background:#84a3b8;'>
                <th width='171'>Bus type</th>
                <th width='137' height='21'>Total Tickets</th>
                <th width='157'>Tickets booked</th>
                <th width='165'>Occupancy%</th>
                </tr>";
        $i = 0;
        $seat_nos_count = 0;
        $this->db2->distinct();
        $this->db2->select('model');
        if ($travel_id == 'all') {
            
        } else {
            $this->db2->where('travel_id', $travel_id);
        }
        $query = $this->db2->get('master_buses');
        foreach ($query->result() as $value) {//main loop
            $busmodel = $value->model; //getting model
            $this->db2->distinct();
            $this->db2->select('service_num');
            if ($travel_id == 'all') {
                
            } else {
                $this->db2->where('travel_id', $travel_id);
            }
            $this->db2->where('model', $busmodel);
            $query11 = $this->db2->get('master_buses');
            //gtting distinct service number based on model
            foreach ($query11->result() as $value) {
                $srno = $value->service_num;
                //logic for getting total number of seats
                if ($travel_id == 'all') {
                    $p1 = $this->db2->query("select seat_nos from master_buses where  status='1' and service_num='$srno'");
                } else {
                    $p1 = $this->db2->query("select seat_nos from master_buses where  status='1' and travel_id='$travel_id' and service_num='$srno'");
                }
                foreach ($p1->result() as $values) {
                    $seat_nos = $values->seat_nos;
                    //getting available days based on service_number
                    if ($travel_id == 'all') {
                        $p2 = $this->db2->query("select count(distinct journey_date) as num_rows1 from buses_list where (journey_date BETWEEN '$fdate' AND '$tdate') and status='1' and service_num='$srno'");
                    } else {
                        $p2 = $this->db2->query("select count(distinct journey_date) as num_rows1 from buses_list where (journey_date BETWEEN '$fdate' AND '$tdate') and status='1' and travel_id='$travel_id' and service_num='$srno'");
                    }
                    foreach ($p2->result() as $v2) {
                        $avail_days = $v2->num_rows1;
                        $count = $avail_days * $seat_nos;
                    }
                }
                if ($count == '' || $count == 0) {
                    $seat_nos_count = $count;
                } else {
                    $seat_nos_count = $seat_nos_count + $count;
                }
            } //query11   for each
            //echo $srno;
            if ($travel_id == 'all') {
                $query5 = $this->db2->query("select sum(pass) as num_rows from master_booking where  bus_model ='$busmodel' and (bdate BETWEEN '" . $fdate . "' AND '" . $tdate . "') and (status='confirmed' || status='Confirmed')");
            } else {
                $query5 = $this->db2->query("select sum(pass) as num_rows from master_booking where  bus_model ='$busmodel' and travel_id='$travel_id' and (bdate BETWEEN '" . $fdate . "' AND '" . $tdate . "') and (status='confirmed' || status='Confirmed')");
            }
            //print_r($query5->result());
            if ($travel_id == 'all') {
                $query6 = $this->db2->query("select sum(pass) as num_rowss from master_booking where bus_model ='$busmodel' and (bdate BETWEEN '" . $fdate . "' AND '" . $tdate . "') and (status='cancelled' || status='Cancelled')");
            } else {
                $query6 = $this->db2->query("select sum(pass) as num_rowss from master_booking where bus_model ='$busmodel' and travel_id='$travel_id' and (bdate BETWEEN '" . $fdate . "' AND '" . $tdate . "') and (status='cancelled' || status='Cancelled')");
                //print_r($query6->result());
            }
            foreach ($query5->result() as $rows) {
                $results_conf = $rows->num_rows;
            }
            foreach ($query6->result() as $row) {
                $results_can = $row->num_rowss;
            }
            $totalbooked = $results_conf - $results_can;

            $oc = ($totalbooked / $seat_nos_count) * 100;
            $occupancy = sprintf("%.3f", $oc);

            $class = ($i % 2 == 0) ? 'bg' : 'bg1';
            echo '<tr class="' . $class . '">';
            echo '<td height="30">' . $busmodel . '</td>';
            echo '<td>' . $seat_nos_count . '</td>';
            echo '<td>' . $totalbooked . '</td>';
            echo '<td>' . $occupancy . '</td>';
            echo '</tr>';
            $i++;
        }//main loop closed


        echo '</table>';
    }

    function getOperator_route_details() {

        //$this->db2 = $this->load->database('forum', TRUE);
        $travel_id = $this->input->post('opid');
        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');
        $i = 1;
        echo "<table align='center'  width='650'>
                <tr style='font-size:13px; color:#ffffff; background:#84a3b8;'>
                <th width='171'>Routes</th>
                <th width='137' height='21'>Total Tickets</th>
                <th width='157'>Tickets booked</th>
                <th width='165'>Occupancy%</th>
                </tr>";
        if ($travel_id == 0) {
            $this->db2->distinct();
            $this->db2->select('service_num');
            $query = $this->db2->get('master_buses');
        } else {
            $this->db2->distinct();
            $this->db2->select('service_num');
            $this->db2->where('travel_id', $travel_id);
            $query = $this->db2->get('master_buses');
        }
        foreach ($query->result() as $value) {
            $srno = $value->service_num;
            // echo $srno;
            $query1 = $this->db2->query("select min(start_time) as busstart_time from master_buses where service_num='$srno'");

            foreach ($query1->result() as $value1) {
                $busstartime = $value1->busstart_time;
            }

            $query2 = $this->db2->query("select max(journey_time) as buslastdrop_time from master_buses where service_num='$srno'");
            foreach ($query2->result() as $value2) {
                $lastbusdroptime = $value2->buslastdrop_time;
            }

            $query3 = $this->db2->query("select distinct from_name from master_buses where service_num='$srno' and start_time='$busstartime'");
            foreach ($query3->result() as $value3) {
                $from_name = $value3->from_name;
            }
            $query4 = $this->db2->query("select distinct to_name from master_buses where service_num='$srno' and journey_time='$lastbusdroptime'");
            foreach ($query4->result() as $value4) {
                $to_name = $value4->to_name;
            }

            $query5 = $this->db2->query("select  sum(pass) as num_rows from master_booking where  service_no ='$srno'  and (bdate BETWEEN '" . $fdate . "' AND '" . $tdate . "') and (status='confirmed' || status='Confirmed')");
            $query6 = $this->db2->query("select  sum(pass) as num_rows from master_booking where  service_no ='$srno'  and (bdate BETWEEN '" . $fdate . "' AND '" . $tdate . "') and (status='cancelled' || status='Cancelled')");
            foreach ($query5->result() as $rows) {
                $results2 = $rows->num_rows;
            }

            foreach ($query6->result() as $row) {
                $results3 = $row->num_rows;
            }
            $totalbooked = $results2 - $results3;
            $res_query1 = $this->db2->query("select distinct journey_date from buses_list where service_num='$srno'  and (journey_date BETWEEN '" . $fdate . "' AND '" . $tdate . "') and status='1' ");
            $getcount = $res_query1->num_rows();
            // echo "count".$getcount;
            $res_query = $this->db2->query("select seat_nos from master_buses where service_num='$srno' ");
            foreach ($res_query->result() as $rows) {
                $tot_res1 = $rows->seat_nos;
                //echo $tot_res1;
                $tot_res = $getcount * $tot_res1;
            }
            $oc = ($results2 / $tot_res) * 100;
            $occupancy = sprintf("%.3f", $oc);
            $class = ($i % 2 == 0) ? 'bg' : 'bg1';
            echo '<tr class="' . $class . '">';
            echo '<td height="30">' . $from_name . '-' . $to_name . '</td>';
            echo '<td>' . $tot_res . '</td>';
            echo '<td>' . $totalbooked . '</td>';
            echo '<td>' . $occupancy . '</td>';
            echo '</tr>';
            $i++;
        }
        echo '</table>';
    }

    function get_cancelTerm_OfOperator_from_db() {
        $this->db2 = $this->load->database('forum', TRUE);
        $travel_id = $this->input->post('traid');
        $query = $this->db->query("select * from registered_operators where travel_id='$travel_id'");
        // echo $travel_id;
        $i = 1;
        if ($query->num_rows() > 0) {
            echo "<table align='center'  width='550'>
                <tr style='font-size:13px; color:#ffffff; background:#84a3b8;'>
                <th width='171'>Cancellation Time(Hours)</th>
                <th width='171' height='21'>Cancellation Charge(%)</th>
                </tr>";
            foreach ($query->result() as $val) {
                $canc_terms1 = $val->canc_terms;
                $canc_terms2 = explode('@', $canc_terms1);
                for ($i = 0; $i < count($canc_terms2); $i++) {
                    $canc_terms3 = explode('#', $canc_terms2[$i]);
                    //echo $canc_terms3;
                    echo "<tr style='font-size:13px; color:#ffffff; background:#84a3b8;'>
                <td width='171' align='center'>$canc_terms3[0]      -     $canc_terms3[1]</td>
                <td width='171' align='center'>$canc_terms3[2]%</td>
                </tr>";
                }
            }
            echo "</table>";
        } else {
            echo 0;
        }
    }

    //put your code here
    function get_operator1() {
        $sql = $this->db2->query("select travel_id,operator_title from registered_operators where status='1' ");
        $data = array();
        foreach ($sql->result() as $rows) {
            $data[$rows->travel_id] = $rows->operator_title;
        }
        return $data;
    }

    public function apiwise_report() {
        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');
        $opid = $this->input->post('opid');

        echo '<table border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="18">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="18">From Date : ' . $fdate . ' &nbsp;&nbsp;&nbsp;&nbsp;To Date : ' . $tdate . '</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" align="center">Booking</td>
    <td>&nbsp;</td>
    <td colspan="3" align="center">Cancellation</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="checkbox" id="selectck" name="selectck" onClick="SelectAll()"/></td>
    <td>&nbsp;</td>
    <td>API Agent </td>
    <td>&nbsp;</td>    
    <td>Total Amount </td>
    <td>&nbsp;</td>
    <td>Comm</td>
    <td>&nbsp;</td>
    <td>Total Amount </td>
    <td>&nbsp;</td>
    <td> Comm</td>
    <td>&nbsp;</td>
    <td>Cancellation Amount</td>
    <td>&nbsp;</td>
    <td>Balance</td>
    <td>&nbsp;</td>
  </tr>';

        $i = 0;

        $agent = mysql_query("select distinct id,name,margin from agents_operator where operator_id='$opid' and agent_type='3' and api_type='op'") or die(mysql_error());
        while ($rows = mysql_fetch_array($agent)) {
            $id = $rows['id'];
            $name = $rows['name'];
            $margin = $rows['margin'];
            
            
            $sql = mysql_query("select sum(tkt_fare) as tkt_fare,sum(save) as save,sum(paid) as paid from master_booking where operator_agent_type='3' and agent_id='$id' and travel_id='$opid' and jdate between '$fdate' and '$tdate' and status='confirmed'") or die(mysql_error());
            $row = mysql_fetch_array($sql);
            $tkt_fare = $row['tkt_fare'];
            
            /* $save = $row['save'];
              $paid = $row['paid']; */
            $save = ($margin * $tkt_fare) / 100;            
            $paid = $tkt_fare - $save;

            $sql1 = mysql_query("select sum(tkt_fare) as tkt_fare,sum(save) as save,sum(paid) as paid,sum(camt) as camt,sum(refamt) as refamt from master_booking  where operator_agent_type='3' and travel_id='$opid' and agent_id='$id' and jdate between '$fdate' and '$tdate' and status='cancelled'") or die(mysql_error());
            $row1 = mysql_fetch_array($sql1);

            $tkt_fare1 = $row1['tkt_fare'];
            /* $save1 = $row1['save'];
              $paid1 = $row1['paid']; */
            $save1 = ($margin * $tkt_fare1) / 100;
            $paid1 = $tkt_fare1 - $save1;

            if ($id == 125 || $id == 161 || $id == 204) {
                $camt1 = $row1['camt'];
            } else {
                $camt1 = $row1['camt'] / 2;
            }

            $refamt1 = $row1['refamt'];

            $balance = $paid - ($tkt_fare1 - ($save1 + $camt1));

            echo '<tr>
    <td height="40"><input type="checkbox" class="chkbox" id="chk' . $i . '" name="chk" value="' . $i . '" /></td>
	<td height="40">&nbsp;</td>
    <td height="40">' . $name . '</td>	
	<td height="40">&nbsp;</td>
    <td height="40">' . sprintf("%1.0f", $tkt_fare) . '</td>
	<td height="40">&nbsp;</td>
    <td height="40">' . sprintf("%1.2f", $save) . '</td>
	<td height="40">&nbsp;</td>
    <td height="40">' . sprintf("%1.2f", $tkt_fare1) . '</td>
    <td height="40">&nbsp;</td>
    <td height="40">' . sprintf("%1.2f", $save1) . '</td>
    <td height="40">&nbsp;</td>
    <td height="40">' . sprintf("%1.2f", $camt1) . '</td>
	<td height="40">&nbsp;</td>
	<td height="40">' . sprintf("%1.2f", $balance) . '</td>
	<td height="40">&nbsp;<input type="hidden" name="balance' . $i . '" id="balance' . $i . '" value="' . sprintf("%1.2f", $balance) . '">
	<input type="hidden" name="name' . $i . '" id="name' . $i . '" value="' . $name . '">	</td>
  </tr>';

            $i++;
        }
        $j = $i;
        $ticket_fare = 0;
        $ticket_fare1 = 0;
        $commission = 0;
        $commission1 = 0;
        $canc_amt1 = 0;
        $balance = 0;
        $balance1 = 0;
        $saves = 0;
        $paids = 0;
        $save = 0;
        $save1 = 0;
        $paid = 0;
        $paid1 = 0;

        $agent1 = mysql_query("select distinct id,name from agents_operator where api_type='te' and agent_type='3'") or die(mysql_error());
        while ($rows = mysql_fetch_array($agent1)) {
            $id = $rows['id'];
            $name = $rows['name'];

            $cnt = mysql_query("select * from master_booking where operator_agent_type='3' and agent_id='$id' and travel_id='$opid' and jdate between '$fdate' and '$tdate' and status='confirmed'") or die(mysql_error());
            if (mysql_num_rows($cnt) > 0) {
                $sql = mysql_query("select sum(tkt_fare) as tkt_fare,sum(save) as save,sum(paid) as paid,status from master_booking where operator_agent_type='3' and agent_id='$id' and travel_id='$opid' and jdate between '$fdate' and '$tdate' and status='confirmed'") or die(mysql_error());

                $row = mysql_fetch_array($sql);

                $tkt_fare = $row['tkt_fare'];
                //$save = $row['save'];
                //$paid = $row['paid'];  
                $comm = (12 * $tkt_fare) / 100;
                $paid = $tkt_fare - $comm;
                $status = $row['status'];

                $sql1 = mysql_query("select sum(tkt_fare) as tkt_fare,sum(save) as save,sum(paid) as paid,sum(camt) as camt,sum(refamt) as refamt,status from master_booking  where operator_agent_type='3' and travel_id='$opid' and agent_id='$id' and jdate between '$fdate' and '$tdate' and status='cancelled'") or die(mysql_error());
                $row1 = mysql_fetch_array($sql1);

                $tkt_fare1 = $row1['tkt_fare'];
                //$save1 = $row1['save'];
                //$paid1 = $row1['paid'];

                if ($id == 125 || $id == 161 || $id == 204) {
                    $camt1 = $row1['camt'];
                    $save1 = (12 * $tkt_fare1) / 100;
                } else {
                    $camt1 = $row1['camt'] / 2;
                }

                $refamt1 = $row1['refamt'];
                $comm1 = (12 * $tkt_fare1) / 100;
                $paid1 = $tkt_fare1 - $comm1;
                $status1 = $row1['status'];

                if ($ticket_fare == "" && $ticket_fare1 == "" && $commission == "" && $commission1 == "" && $canc_amt1 == "") {
                    $ticket_fare = $tkt_fare;
                    $commission = $comm;
                    $ticket_fare1 = $tkt_fare1;
                    $commission1 = $comm1;
                    $canc_amt1 = $camt1;
                } else {
                    $ticket_fare = $ticket_fare + $tkt_fare;
                    $commission = $commission + $comm;
                    $ticket_fare1 = $ticket_fare1 + $tkt_fare1;
                    $commission1 = $commission1 + $comm1;
                    $canc_amt1 = $canc_amt1 + $camt1;
                }

                //$balance1 = $tkt_fare - ($comm - ($tkt_fare1 - ($save1 + $camt1)));
                if ($status == "confirmed") {
                    $balance1 = $tkt_fare - $comm;
                    /* echo "$tkt_fare - $comm";
                      echo "<br />"; */
                }
                if ($status1 == "cancelled") {
                    $balance1 = $paid - ($tkt_fare1 - ($save1 + $camt1));
                    /* echo "$paid - ($tkt_fare1 - ($save1 + $camt1))";
                      echo "<br />"; */
                }

//$balance1 = $tkt_fare - ($tkt_fare1 + $camt1);
//echo "$tkt_fare - ($tkt_fare1 + $camt1)";
//echo $balance1." - ".$id."<br />";
//echo $paids." - (".$tkt_fare1." - (".$saves." + ".$camt1."))<br />";

                if ($balance == "") {
                    $balance = $balance1;
                } else {
                    $balance = $balance + $balance1;
                }
            }
        }
        echo '<tr>
    <td height="40"><input type="checkbox" class="chkbox" id="chk' . $j . '" name="chk" value="' . $j . '" /></td>
	<td height="40">&nbsp;</td>
    <td height="40">Ticket Engine</td>	
	<td height="40">&nbsp;</td>
    <td height="40">' . sprintf("%1.0f", $ticket_fare) . '</td>
	<td height="40">&nbsp;</td>
    <td height="40">' . sprintf("%1.2f", $commission) . '</td>
	<td height="40">&nbsp;</td>
    <td height="40">' . sprintf("%1.2f", $ticket_fare1) . '</td>
    <td height="40">&nbsp;</td>
    <td height="40">' . sprintf("%1.2f", $commission1) . '</td>
    <td height="40">&nbsp;</td>
    <td height="40">' . sprintf("%1.2f", $canc_amt1) . '</td>
	<td height="40">&nbsp;</td>
	<td height="40">' . sprintf("%1.2f", $balance) . '</td>
	<td height="40">&nbsp;<input type="hidden" name="balance' . $j . '" id="balance' . $j . '" value="' . sprintf("%1.2f", $balance) . '">
	<input type="hidden" name="name' . $j . '" id="name' . $j . '" value="' . $name . '">	</td>
  </tr>
       <tr>
    <td height="40">&nbsp;</td>
    <td height="40">&nbsp;</td>
    <td height="40" colspan="14" align="center"><input type="button" id="sendsms" name="Submit" value="Send SMS" onclick="submitData()">  </tr>
	</table>
';
    }

    function sms_sent() {
        $fdate1 = $this->input->post('fdate');
        $tdate1 = $this->input->post('tdate');
        $opid = $this->input->post('opid');
        $tot = $this->input->post('tot');
        $name1 = $this->input->post('name');
        $balance1 = $this->input->post('balance');

        $tot1 = explode('#', $tot);
        $name = explode('#', $name1);
        $balance = explode('#', $balance1);

        $user = "pridhvi@msn.com:activa1525@";
        $senderID = "TKTENG";
        $book = "API Booking";

        for ($i = 0; $i < count($tot1); $i++) {
            $api_agent[] = $name[$i] . " - Rs." . $balance[$i] . "/-";
        }
        $send = implode(' , ', $api_agent);
        //print_r($api_agent);
        /* (if($balance[$i] != "0.00")
          { */
        $sql = mysql_query("select distinct name,contact_no from registered_operators where travel_id='$opid'") or die(mysql_error());
        $row = mysql_fetch_array($sql);

        $mobile = $row['contact_no'];
        $name = $row['name'];
        $fdate = date("d-m-Y", strtotime($fdate1));
        $tdate = date("d-m-Y", strtotime($tdate1));
        //echo $mobile;

        $receipientno = $mobile; //customer mobile number	

        $text = "FROM " . $fdate . " TO " . $tdate . " PENDING PAYMENT - " . $send . " for " . $name;

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

        if ($stat == 0) {
            $msg = "sent";
        } else {
            $msg = "notsent";
        }
        curl_close($ch);
        //}			
        if ($msg == "sent") {
            echo 1;
        } else {
            echo 0;
        }
    }

    function depositHistory() {

        $this->db2->select('*');
        $this->db2->where("status", "pending");
        $query = $this->db2->get('deposit');
        return $query;
    }

    function depositUpdate() {
        $travelid = $this->input->post('travelid');
        $agentid = $this->input->post('agentid');
        $jrno = $this->input->post('jrno');
        $amt = $this->input->post('amt');
        $cdate = date("Y-m-d");

        $sql = mysql_query("select * from agents_operator where operator_id='$travelid' and id='$agentid'") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)) {
            $bal1 = $row['balance1'];
        }
        $tamt = $bal1 + $amt;
        $sql1 = mysql_query("update agents_operator set balance1='$tamt' where id='$agentid' and operator_id='$travelid'") or die(mysql_error());
        $sql2 = mysql_query("update deposit set status='paid',receive_date='$cdate' where agent_id='$agentid' and journal_no='$jrno' and travel_id='$travelid'") or die(mysql_error());

        if ($sql && $sql2) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function getDepositHistory() {
        $from1 = $this->input->post('from1');
        $to1 = $this->input->post('to1');
        $f1 = explode("/", $from1);
        $from = $f1[0] . "-" . $f1[1] . "-" . $f1[2];
        $t1 = explode("/", $to1);
        $to = $t1[0] . "-" . $t1[1] . "-" . $t1[2];

        $query = mysql_query("select * from deposit where status='pending' and deposit_date between '$from' and '$to' ") or die(mysql_error());

        if (mysql_num_rows($query) == 0) {
            echo '<table width="960px" border="0" id="tbl"><tr style="color:red; font-weight:bold; font-size:14px;" align="center">
        <td>No Records Found</td></tr></table>';
        } else {
            echo'<style type="text/css">
.sp
{
	padding-left:5px;
}	
</style>
<table width="960" border="0" align="center" >
  <tr>
    <td class="sp">S.No</td>
    <td class="sp">Agent name</td>
    <td class="sp">A/C No</td>
    <td class="sp">Deposit Date</td>
    <td class="sp">Reference No</td>
    <td class="sp">Payment Type</td>
    <td class="sp">Amount</td>
    <td class="sp">Status</td>
    <td class="sp">Received Date</td>
    <td class="sp">&nbsp;</td>
  </tr>';

            $i = 1;
            while ($value = mysql_fetch_array($query)) {
                $agent_id = $value['agent_id'];
                $travel_id = $value['travel_id'];
                $acno = $value['ac_no'];
                $depdate = $value['deposit_date'];
                $journal_no = $value['journal_no'];
                $agname = $value['agent_name'];
                $deptype = $value['deposit_type'];
                $recdate = $value['curr_date'];
                $receivedate = $value['receive_date'];
                $depref = $value['deposit_ref'];
                $amt = $value['amount'];
                $status = $value['status'];
                $class = ($i % 2 == 0) ? 'bg' : 'bg1';
                echo'
  <tr class=' . $class . '>
    <td class="sp">' . $i . '</td>
    <td class="sp">' . $agname . '</td>
    <td class="sp">' . $acno . '</td>
    <td class="sp">' . $depdate . '</td>
    <td class="sp">' . $journal_no . '</td>
    <td class="sp">' . $deptype . '</td>
    <td class="sp">' . $amt . '</td>
    <td class="sp" id="st' . $i . '">' . $status . '</td>
    <td class="sp">' . $recdate . '</td>
    <td class="sp" id="up' . $i . '"><input type="button" value="update"  onclick="getUpdatebox(' . $i . ')" ></td>
  </tr>
  <tr>
    <td colspan="10">
	<table width="600" border="0" align="center" id="netr' . $i . '" style="display:none">
      <tr>
        <td align="right">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="206" align="right">Amount</td>
        <td width="161"><input type="text" value="' . $amt . '" id="amt' . $i . '" name="amt' . $i . '" ></td>
        <td width="219"><input type="button" value="submit"  onclick="updateBal(' . $i . ')">
		<input type="hidden" name="agentid' . $i . '" id="agentid' . $i . '" value="' . $agent_id . '"> 
		<input type="hidden" name="travelid' . $i . '" id="travelid' . $i . '" value="' . $travel_id . '"> 
		<input type="hidden" name="jrno' . $i . '" id="jrno' . $i . '" value="' . $journal_no . '">
		</td>
      </tr>
    </table></td>
  </tr>';
                $i++;
            }
            echo'<input type="hidden" id="cc" value="' . $i . '">';
            echo '</table>';
        }
    }

    function get_teagentslist_db() {
        $this->db->select('*');
        $this->db->where('api_type', 'te');
        $query = $this->db->get("agents_operator");
        return $query->result();
    }

    function status_teagent($uid, $st) {

        if ($st == 1)
            $st = 0;
        else if ($st == 0)
            $st = 1;
        $query = $this->db->query("UPDATE agents_operator SET status='$st' WHERE id='$uid' ");
        if ($query)
            echo 1;
        else
            echo 0;
    }

//all_te_agent		

    function get_branchlist_from_db() {
        $query = $this->db->query("select distinct branch from branch_address");
        $branch = array();
        $branch['0'] = "--select branch--";
        foreach ($query->result() as $value) {
            $branch[$value->branch] = $value->branch;
        }
        return $branch;
    }

    public function check_user($user) {
        $this->db->where('uname', $user);
        $query = $this->db->get("agents_operator");
        $rws = $query->num_rows();
        if ($rws > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function update_agent() {
        $now = date("Y-m-d");
        $ip = $this->input->ip_address();
        $username = trim($this->input->post('username'));
        $limit = $this->input->post('limit');
        $paytype = $this->input->post('payment_type');

        $uid = $this->input->post('uid');
        $appname = $this->input->post('bname');
        $name = $this->input->post('name');
        $uname = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email_address');
        $mobile = $this->input->post('contact');
        $city = $this->input->post('locat');
        $address = $this->input->post('address');
        $operator_id = $this->session->userdata('jyt_travel_id');
        $agent_type = $this->input->post('agent_type');
        $agent_type_name = $this->input->post('agent_type_name');
        $date = $now;
        $status = 1;
        $ip = $ip;
        $margin = $this->input->post('margin');
        $pay_type = $paytype;
        $bal_limit = "-" . $limit;
        $api_type = $this->input->post('api_type');
        $land_line = $this->input->post('landline');
        $allow_cancellation = $this->input->post('allowcanc');
        $allow_modification = $this->input->post('allowmodification');
        $branch = $this->input->post('branch');
        $branch_address = $this->input->post('branch_address');
        $payment_reports = $this->input->post('payment_reports');
        $booking_reports = $this->input->post('booking_reports');
        $passenger_reports = $this->input->post('passenger_reports');
        $vehicle_assignment = $this->input->post('vehicle_assignment');
        $ticket_booking = $this->input->post('ticket_booking');
        $check_fare = $this->input->post('check_fare');
        $ticket_status = $this->input->post('ticket_status');
        $ticket_cancellation = $this->input->post('ticket_cancellation');
        $ticket_modify = $this->input->post('ticket_modify');
        $board_passenger_reports = $this->input->post('board_passenger_reports');
        $ticket_reschedule = $this->input->post('ticket_reschedule');
        $group_boarding_passenger_reports = $this->input->post('group_boarding_passenger_reports');
        $margin1 = $this->input->post('margin');
        $pay_type1 = $paytype;
        $bal_limit1 = "-" . $limit;

        $sql = mysql_query("update agents_operator set password = '$password',email = '$email',mobile = '$mobile',city = '$city',address = '$address',agent_type = '$agent_type',agent_type_name = '$agent_type_name',bal_limit = '$bal_limit',margin = '$margin',pay_type = '$pay_type',api_type = '$api_type',land_line = '$land_line',allow_cancellation = '$allow_cancellation',allow_modification = '$allow_modification',branch = '$branch',branch_address = '$branch_address',payment_reports = '$payment_reports',booking_reports = '$booking_reports',passenger_reports = '$passenger_reports',vehicle_assignment = '$vehicle_assignment',ticket_booking = '$ticket_booking',check_fare = '$check_fare',ticket_status = '$ticket_status',ticket_cancellation = '$ticket_cancellation',ticket_modify = '$ticket_modify',board_passenger_reports = '$board_passenger_reports',ticket_reschedule = '$ticket_reschedule',group_boarding_passenger_reports = '$group_boarding_passenger_reports',bal_limit1='$bal_limit1',margin1='$margin1',pay_type1='$pay_type1' where id='$uid'");

        //echo "update agents_operator set password = '$password',email = '$email',mobile = '$mobile',city = '$city',address = '$address',agent_type = '$agent_type',agent_type_name = '$agent_type_name',bal_limit = '$bal_limit',margin = '$margin',pay_type = '$pay_type',api_type = '$api_type',land_line = '$land_line',allow_cancellation = '$allow_cancellation',allow_modification = '$allow_modification',branch = '$branch',branch_address = '$branch_address',payment_reports = '$payment_reports',booking_reports = '$booking_reports',passenger_reports = '$passenger_reports',vehicle_assignment = '$vehicle_assignment',ticket_booking = '$ticket_booking',check_fare = '$check_fare',ticket_status = '$ticket_status',ticket_cancellation = '$ticket_cancellation',ticket_modify = '$ticket_modify',board_passenger_reports = '$board_passenger_reports',ticket_reschedule = '$ticket_reschedule',group_boarding_passenger_reports = '$group_boarding_passenger_reports' where id='$uid'";

        if ($sql) {
            return 1;
        } else {
            return 0;
        }
    }

    public function update_agent2() {

        $uid = $_POST['uid']; //echo "$uid";
        $appname = $_POST['appname']; //echo "$appname";
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email_address = $_POST['email_address'];
        $contact = $_POST['contact'];
        $locat = $_POST['locat'];
        $state = $_POST['state'];
        $address = $_POST['address'];
        $opid = $_POST['opid']; //echo "$opid";
        $agent_type = $_POST['agent_type'];

        $agent_type_name = $_POST['agent_type_name'];
        $date = $_POST['date'];
        $status = $_POST['status'];
        $ip = $_POST['ip'];
        $blnc = $_POST['blnc'];
        $blnclmt = $_POST['blnclmt'];
        $comm_type = $_POST['comm_type'];
        $margin = $_POST['margin'];
        $paytype = $_POST['paytype'];
        $blnc1 = $_POST['blnc1'];
        $blnclmt1 = $_POST['blnclmt1'];
        $margin1 = $_POST['margin1'];
        $paytype1 = $_POST['paytype1'];
        $apikey = $_POST['apikey'];
        $apitype = $_POST['apitype'];
        $execu = $_POST['execu'];

        $lmap = $_POST['lmap'];
        $landline = $_POST['landline'];
        $branch = $_POST['branch'];
        $branch_address = $_POST['branch_address'];
        $op_comm = $_POST['op_comm'];
        $by_cash = $_POST['by_cash'];
        $by_phone = $_POST['by_phone'];
        $by_agent = $_POST['by_agent'];
        $by_phone_agent = $_POST['by_phone_agent'];
        $by_employee = $_POST['by_employee'];
        $allowcanc = $_POST['allowcanc'];
        $allowmodification = $_POST['allowmodification'];
        $payment_reports = $_POST['payment_reports'];

        $booking_reports = $_POST['booking_reports'];
        $passenger_reports = $_POST['passenger_reports'];
        $vehicle_assignment = $_POST['vehicle_assignment'];
        $ticket_booking = $_POST['ticket_booking'];
        $check_fare = $_POST['check_fare'];
        $ticket_status = $_POST['ticket_status'];
        $ticket_cancellation = $_POST['ticket_cancellation'];
        $ticket_modify = $_POST['ticket_modify'];
        $board_passenger_reports = $_POST['board_passenger_reports'];
        $ticket_reschedule = $_POST['ticket_reschedule'];
        $group_boarding_passenger_reports = $_POST['group_boarding_passenger_reports'];

        $ispay = $_POST['ispay'];
        $ishover = $_POST['ishover'];
        $isip = $_POST['isip'];
        $headoff = $_POST['headoff'];
        $show_avil_seat = $_POST['show_avil_seat'];
        $bus_mgmt = $_POST['bus_mgmt'];
        $seat_mgmt = $_POST['seat_mgmt'];
        $login_mgmt = $_POST['login_mgmt'];
		$branchlogins = $_POST['branchlogins'];
        $ind_seat_fare = $_POST['ind_seat_fare'];
        $agent_charge = $_POST['agent_charge'];
        $other_service = $_POST['other_service'];
        $price_edit = $_POST['price_edit'];
        $delaysms = $_POST['delaysms'];
        $createlayout = $_POST['createlayout'];



        $sql = mysql_query("update agents_operator set appname = '$appname',name = '$name',uname = '$username', password = '$password',email = '$email_address', mobile = '$contact',city = '$locat',state = '$state',address = '$address',agent_type = '$agent_type',agent_type_name = '$agent_type_name',status = '$status',ip = '$ip',balance = '$blnc',bal_limit = '$blnclmt',margin = '$margin',comm_type = '$comm_type',pay_type = '$paytype',api_key = '$apikey',api_type = '$apitype',is_pay = '$ispay',is_hover = '$ishover',executive = '$execu',location_mapped = '$lmap',land_line = '$landline',allow_cancellation = '$allowcanc',allow_modification = '$allowmodification',branch = '$branch',branch_address = '$branch_address',payment_reports = '$payment_reports',booking_reports = '$booking_reports',passenger_reports = '$passenger_reports',vehicle_assignment = '$vehicle_assignment',ticket_booking = '$ticket_booking',check_fare = '$check_fare',ticket_status = '$ticket_status',ticket_cancellation = '$ticket_cancellation',ticket_modify = '$ticket_modify',board_passenger_reports = '$board_passenger_reports',ticket_reschedule = '$ticket_reschedule',group_boarding_passenger_reports = '$group_boarding_passenger_reports',by_cash = '$by_cash',by_phone = '$by_phone',by_agent = '$by_agent',by_phone_agent = '$by_phone_agent',by_employee = '$by_employee',isip = '$isip',head_office = '$headoff',show_avail_seat = '$show_avil_seat',bus_mgmt = '$bus_mgmt',seat_mgmt = '$seat_mgmt',login_mgmt = '$login_mgmt',individual_seatfare = '$ind_seat_fare',agent_charge = '$agent_charge',balance1 = '$blnc1',bal_limit1 = '$blnclmt1',margin1 = '$margin1',pay_type1 = '$paytype1',other_services = '$other_service',op_comm = '$op_comm',price_edit ='$price_edit',delaysms = '$delaysms',createlayout = '$createlayout',branchlogins='$branchlogins'  where id='$uid'");

        if ($sql) {
            return 1;
        } else {
            return mysql_error();
        }
    }

    function get_te_agent_list() {
        $location = array();
        $location['0'] = "--select agent--";
        $query = mysql_query("select distinct id,name from agents_operator where status='1' and agent_type='te_agent'") or die(mysql_error());
        while ($row = mysql_fetch_array($query)) {
            $id = $row['id'];
            $name = $row['name'];

            $location[$id] = $name;
        }
        return $location;
    }

    function get_operator_list() {
        $location = array();
        $location[''] = "--select operator--";
        $location['all'] = "all";
        $query = mysql_query("select distinct travel_id from master_buses where status='1'") or die(mysql_error());
        while ($row = mysql_fetch_array($query)) {
            $travel_id = $row['travel_id'];
            $query1 = mysql_query("select operator_title from registered_operators where travel_id='$travel_id'") or die(mysql_error());
            while ($row1 = mysql_fetch_array($query1)) {
                $operator_title = $row1['operator_title'];

                $location[$travel_id] = $operator_title;
            }
        }
        return $location;
    }

    public function add_commission1() {
        $agent = $this->input->post('agent');
        $agent_name = $this->input->post('agent_name');
        $operator = $this->input->post('operator');
        $operator_name = $this->input->post('operator_name');
        $commission = $this->input->post('commission');
        $stat = "";
        if ($operator == "all") {
            $quer = mysql_query("select distinct travel_id from master_buses where status='1'") or die(mysql_error());
            $quer1 = mysql_query("select distinct travel_id from operator_commission where agent_id='$agent'") or die(mysql_error());


            if (mysql_num_rows($quer) != mysql_num_rows($quer1)) {
                $query = mysql_query("select distinct travel_id from master_buses where status='1'") or die(mysql_error());
                while ($row = mysql_fetch_array($query)) {
                    $travel_id = $row['travel_id'];
                    $query1 = mysql_query("select operator_title from registered_operators where travel_id='$travel_id'") or die(mysql_error());
                    while ($row1 = mysql_fetch_array($query1)) {
                        $operator_title = $row1['operator_title'];

                        $sql1 = mysql_query("insert into operator_commission(agent_id,agent_name,travel_id,operator_name,commission) values ('$agent','$agent_name','$travel_id','$operator_title','$commission')") or die(mysql_error());
                    }
                }
            } else {
                $stat = 2;
            }
        } else {
            $query = mysql_query("select distinct travel_id from operator_commission where agent_id='$agent' and travel_id='$operator'") or die(mysql_error());
            if (mysql_num_rows($query) > 0) {
                $sql1 = mysql_query("update operator_commission set commission='$commission' where agent_id='$agent' and travel_id='$operator'") or die(mysql_error());
            } else {
                $sql1 = mysql_query("insert into operator_commission(agent_id,agent_name,travel_id,operator_name,commission) values ('$agent','$agent_name','$operator','$operator_name','$commission')") or die(mysql_error());
            }
        }

        if ($stat == 2) {
            return 2;
        } else if ($sql1) {
            return 1;
        } else {
            return 0;
        }
    }

    public function add_agents_db() {

        //echo "abc";
        $appname = $_POST['appname'];
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email_address = $_POST['email_address'];
        $contact = $_POST['contact'];
        $locat = $_POST['locat'];
        $state = $_POST['state'];
        $address = $_POST['address'];
        $opid = $_POST['opid']; //echo "$opid";
        $agent_type = $_POST['agent_type'];

        $agent_type_name = $_POST['agent_type_name'];
        $date = $_POST['date'];
        $status = $_POST['status'];
        $ip = $_POST['ip'];
        $blnc = $_POST['blnc'];
        $blnclmt = $_POST['blnclmt'];
        $comm_type = $_POST['comm_type'];
        //echo "$comm_type";
        $margin = $_POST['margin'];
        $paytype = $_POST['paytype'];
        $blnc1 = $_POST['blnc1'];
        $blnclmt1 = $_POST['blnclmt1'];
        $margin1 = $_POST['margin1'];
        $paytype1 = $_POST['paytype1'];
        $apikey = $_POST['apikey'];
        $apitype = $_POST['apitype'];
        $execu = $_POST['execu'];

        $lmap = $_POST['lmap'];
        $landline = $_POST['landline'];
        $branch = $_POST['branch'];
        $branch_address = $_POST['branch_address'];
        $op_comm = $_POST['op_comm'];
        $by_cash = $_POST['by_cash'];
        $by_phone = $_POST['by_phone'];
        $by_agent = $_POST['by_agent'];
        $by_phone_agent = $_POST['by_phone_agent'];
        $by_employee = $_POST['by_employee'];
        $allowcanc = $_POST['allowcanc'];
        $allowmodification = $_POST['allowmodification'];
        $payment_reports = $_POST['payment_reports'];

        $booking_reports = $_POST['booking_reports'];
        $passenger_reports = $_POST['passenger_reports'];
        $vehicle_assignment = $_POST['vehicle_assignment'];
        $ticket_booking = $_POST['ticket_booking'];
        $check_fare = $_POST['check_fare'];
        $ticket_status = $_POST['ticket_status'];
        $ticket_cancellation = $_POST['ticket_cancellation'];
        $ticket_modify = $_POST['ticket_modify'];
        $board_passenger_reports = $_POST['board_passenger_reports'];
        $ticket_reschedule = $_POST['ticket_reschedule'];
        $group_boarding_passenger_reports = $_POST['group_boarding_passenger_reports'];

        $ispay = $_POST['ispay'];
        $ishover = $_POST['ishover'];
        $isip = $_POST['isip'];
        $headoff = $_POST['headoff'];
        $show_avil_seat = $_POST['show_avil_seat'];
        $bus_mgmt = $_POST['bus_mgmt'];
        $seat_mgmt = $_POST['seat_mgmt'];
        $login_mgmt = $_POST['login_mgmt'];
		$branchlogins = $_POST['branchlogins'];
        $ind_seat_fare = $_POST['ind_seat_fare'];
        $agent_charge = $_POST['agent_charge'];
        $other_service = $_POST['other_service'];
        $price_edit = $_POST['price_edit'];


        $sql = mysql_query("INSERT INTO agents_operator (`appname`, `name`, `uname`, `password`, `email`, `mobile`, `city`, `state`, `address`, `operator_id`, `agent_type`, `agent_type_name`, `date`, `status`, `ip`, `balance`, `bal_limit`, `margin`,`comm_type`, `pay_type`, `api_key`, `api_type`, `is_pay`, `is_hover`, `executive`, `location_mapped`, `land_line`, `allow_cancellation`, `allow_modification`, `branch`, `branch_address`, `payment_reports`, `booking_reports`, `passenger_reports`, `vehicle_assignment`, `ticket_booking`, `check_fare`, `ticket_status`, `ticket_cancellation`, `ticket_modify`, `board_passenger_reports`, `ticket_reschedule`, `group_boarding_passenger_reports`, `by_cash`, `by_phone`, `by_agent`, `by_phone_agent`, `by_employee`, `isip`, `head_office`, `show_avail_seat`, `bus_mgmt`, `seat_mgmt`, `login_mgmt`, `individual_seatfare`, `agent_charge`, `balance1`, `bal_limit1`, `margin1`, `pay_type1`, `other_services`, `op_comm`, `price_edit`,`branchlogins`) values('$appname','$name','$username','$password','$email_address','$contact','$locat','$state','$address','$opid','$agent_type','$agent_type_name','$date','$status','$ip','$blnc','$blnclmt','$margin','$comm_type','$paytype','$apikey','$apitype','$ispay','$ishover','$execu','$lmap','$landline','$allowcanc','$allowmodification','$branch','$branch_address','$payment_reports','$booking_reports','$passenger_reports','$vehicle_assignment','$ticket_booking','$check_fare','$ticket_status','$ticket_cancellation','$ticket_modify','$board_passenger_reports','$ticket_reschedule','$group_boarding_passenger_reports','$by_cash','$by_phone','$by_agent','$by_phone_agent','$by_employee','$isip','$headoff','$show_avil_seat','$bus_mgmt','$seat_mgmt','$login_mgmt','$ind_seat_fare','$agent_charge','$blnc1','$blnclmt1','$margin1','$paytype1','$other_service','$op_comm','$price_edit','$branchlogins')") or die(mysql_error());

        if ($sql) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function api_sms_count($newdate, $date) {

        $query = $this->db2->query("SELECT count(*) as cnt FROM `sms_api` where `date` between '$newdate' and '$date'");
        foreach ($query->result() as $row) {
            $cnt = $row->cnt;
        }
        return $cnt;
    }

    public function get_api_sms($limit, $page, $newdate, $date) {

        //$sql = mysql_query("SELECT * FROM `sms_api` where `date` between '$newdate' and '$date'  ORDER BY `date_time` desc ");
        //$query = $this->db2->query("SELECT * FROM `sms_api` where `date` between '$newdate' and '$date'  ORDER BY `date_time` desc  LIMIT 15");
        //return $query->result();

        $this->db2->limit($limit, $page);
        $this->db2->select('*');
        $this->db2->where('date >=', $newdate);
        $this->db2->where('date <=', $date);
        $this->db2->order_by('date_time', 'desc');
        $query = $this->db2->get("sms_api");
        return $query->result();
    }

    public function grab_rels_count($opid) {

        $query = $this->db2->query("select count(*) as cnt  from grabandreleasehistory where travel_id='$opid'");
        foreach ($query->result() as $row) {
            $cnt = $row->cnt;
        }
        return $cnt;
    }

    public function get_grab($limit, $page, $opid) {
//echo "$opid";
        //$query = $this->db2->query("select * from grabandreleasehistory where travel_id='$opid'");
        //return $query->result();

        $this->db2->limit($limit, $page);
        $this->db2->select('*');
        $this->db2->where('travel_id', $opid);
        $query = $this->db2->get("grabandreleasehistory");
        return $query->result();
    }

    public function citres_count() {

        $query = $this->db2->query("SELECT count(*) as cnt FROM `citrus_response`");
        foreach ($query->result() as $row) {
            $cnt = $row->cnt;
        }
        return $cnt;
    }

    public function get_citrus_res($limit, $page) {

        //$query = $this->db2->query("SELECT * FROM `citrus_response` ORDER BY `today` DESC");
        //return $query->result();

        $this->db2->limit($limit, $page);
        $this->db2->select('*');
        //$this->db2->where('today >=',$newdate);
        //$this->db2->where('today <=',$date);
        $this->db2->order_by('today', 'desc');
        $query = $this->db2->get("citrus_response");
        return $query->result();
    }

    public function cnt_top() {

        $query = $this->db2->query("SELECT count(*) as cnt FROM `agents_topup`");
        foreach ($query->result() as $row) {
            $cnt = $row->cnt;
        }
        return $cnt;
    }

    public function get_topup($limit, $page) {

        //$query = $this->db2->query("SELECT * FROM `agents_topup` ORDER BY `txn_date` DESC");
        //return $query->result();

        $this->db2->limit($limit, $page);
        $this->db2->select('*');
        $this->db2->order_by('txn_date', 'desc');
        $query = $this->db2->get("agents_topup");
        return $query->result();
    }

    public function vehical_cnt() {

        $query = $this->db2->query("SELECT count(*) as cnt FROM `vechile_assignment`");
        foreach ($query->result() as $row) {
            $cnt = $row->cnt;
        }
        return $cnt;
    }

    public function get_vehical_asign($limit, $page) {

        //$query = $this->db2->query("SELECT * FROM `vechile_assignment` ORDER BY `journey_date` DESC");
        //return $query->result();
        $this->db2->limit($limit, $page);
        $this->db2->select('*');
        $this->db2->order_by('journey_date', 'desc');
        $query = $this->db2->get("vechile_assignment");
        return $query->result();
    }

    public function get_quota_res() {



        $start = 0;
        $limit = 10;

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $start = ($id - 1) * $limit;
        }

        $query = $this->db2->query("SELECT distinct service_num,tim FROM quota_update_history order by id desc limit $start,$limit");

        echo '<style type="text/css">
#content
{
	width: 900px;
	margin: 0 auto;
	font-family:Arial, Helvetica, sans-serif;
}
.page
{
float: right;
margin: 0;
padding: 0;
}
.page li
{
	list-style: none;
	display:inline-block;
}
.page li a, .current
{
display: block;
padding: 5px;
text-decoration: none;
color: #8A8A8A;
}
.current
{
	font-weight:bold;
	color: #000;
}
.button
{
padding: 5px 15px;
text-decoration: none;
background: #333;
color: #F3F3F3;
font-size: 13PX;
border-radius: 2PX;
margin: 0 4PX;
display: block;
float: left;
}
</style>
<div id="content">
<table id="tbl" width="100%" border="0" id="tbl"><tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; border:1px">
        <th height="30">service_num</th>
        <th>travel_id</th>
        <th>seat_name</th>
        <th>available</th>
        <th>available_type</th>
        <th>ip</th>
        <th>tim</th>
        <th>updated_by_id</th>
        <th>updated_by</th>
        </tr>';

        foreach ($query->result() as $value) {

            echo "<tr style='font-size:12'>
                 <td align='center' height='30' style='vertical-align:top'>$value->service_num</td> 
                 <td align='center' style='vertical-align:top'>$value->travel_id</td> 
                 <td align='justify' style='vertical-align:top'>";
            $seat_name = '';
            $sql = $this->db2->query("SELECT * FROM  quota_update_history WHERE service_num='$value->service_num' order by id desc");
            foreach ($sql->result() as $seat) {
                $seat_name = $seat_name . " " . $seat->seat_name;
            }


            echo $seat_name . "</td>
                 <td align='center' style='vertical-align:top'>$seat->available</td>
                 <td align='center' style='vertical-align:top'>$seat->available_type</td>
                 <td align='center' style='vertical-align:top'>$seat->ip</td>
                 <td align='center' style='vertical-align:top'>$seat->tim</td>
                 <td align='center' style='vertical-align:top'>$seat->updated_by_id</td>
                 <td align='center' style='vertical-align:top'>$seat->updated_by</td>
                 </tr>";
        }
        echo '</table>';


        $rows = mysql_num_rows(mysql_query("SELECT seat_name FROM  quota_update_history WHERE service_num='$value->service_num' order by id desc"));
        $total = ceil($rows / $limit);

        if ($id > 1) {
            echo "<a href='?id=" . ($id - 1) . "' class='button'>PREVIOUS</a>";
        }
        if ($id != $total) {
            echo "<a href='?id=" . ($id + 1) . "' class='button'>NEXT</a>";
        }

        echo "<ul class='page'>";
        for ($i = 1; $i <= $total; $i++) {
            if ($i == $id) {
                echo "<li class='current'>" . $i . "</li>";
            } else {
                echo "<li><a href='?id=" . $i . "'>" . $i . "</a></li>";
            }
        }
        echo "</ul></div>";
        /* $query = $this->db2->query("SELECT * FROM quota_update_history group by service_num order by tim desc");

          echo '<table id="tbl" width="100%" border="0" id="tbl"><tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; border:1px">
          <th height="30">service_num</th>
          <th>travel_id</th>
          <th>seat_name</th>
          <th>available</th>
          <th>available_type</th>
          <th>ip</th>
          <th>tim</th>
          <th>updated_by_id</th>
          <th>updated_by</th>
          </tr>';

          foreach ($query->result() as $value) {

          echo "<tr style='font-size:12'>
          <td align='center' height='30' style='vertical-align:top'>$value->service_num</td>
          <td align='center' style='vertical-align:top'>$value->travel_id</td>
          <td align='justify' style='vertical-align:top'>";
          $seat_name = '';
          $sql = $this->db2->query("SELECT seat_name FROM  quota_update_history WHERE service_num='$value->service_num'");
          foreach ($sql->result() as $seat) {
          $seat_name = $seat_name . " " . $seat->seat_name;
          }


          echo $seat_name . "</td>
          <td align='center' style='vertical-align:top'>$value->available</td>
          <td align='center' style='vertical-align:top'>$value->available_type</td>
          <td align='center' style='vertical-align:top'>$value->ip</td>
          <td align='center' style='vertical-align:top'>$value->tim</td>
          <td align='center' style='vertical-align:top'>$value->updated_by_id</td>
          <td align='center' style='vertical-align:top'>$value->updated_by</td>
          </tr>";
          }
          echo '</table>'; */
    }

    function get_can_sms_cont_db($uid) {


        if ($uid == all) {
            $query = $this->db2->query("select * from registered_operators where status='1'");
        } else {
            $query = $this->db2->query("select * from registered_operators where travel_id='$uid'");
        }
        echo "<table id='tbl' style='margin: 0px auto;' class='gridtable'  width='550'>";
        echo "<tr>";
        echo "<th>Name</th>";
        echo "<th>Travel Id </th>";
        echo "<th>contact No </th>";
        echo "<th>Status</th>";
        echo "<th>Option</th>";
        echo "</tr>";
        $i = 1;
        foreach ($query->result() as $row) {
            $uid = $row->id;
            $api_can_sms = $row->api_can_sms;
            //echo $is_api_sms."is_api_sms";
            if ($api_can_sms == 1) {
                $x = 'Active';
            } else {
                $api_can_sms = 0;
                $x = 'Inactive';
            }
            echo "<tr>";

            echo "<td style='font-size:12px';>" . $row->operator_title . "</td>";
            echo "<td style='font-size:12px';>" . $uid . "</td>";
            echo "<td style='font-size:12px;'>" . $row->contact_no . "</td>";
            echo "<td style='font-size:12px;'>" . $x . "</td>";
            echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;'>" . anchor('master_control/edit_api_can_sms?uid=' . $uid . '&api_can_sms=' . $api_can_sms, 'Update', '') . "</span></td>";

            echo "</tr>";
            $i++;
        }
        echo "</table>";
    }

    function status_modify_api_can_sms() {
        $status = $this->input->post('status');
        $id = $this->input->post('id');
        $mobile = $this->input->post('mobile');
        //echo "$mobile";
        $query = $this->db->query("UPDATE registered_operators SET api_can_sms='$status', contact_no='$mobile' WHERE id='$id' ");
        if ($query)
            echo 1;
        else
            echo 0;
    }

    function active_view_home1($uid, $st) {
        //logic for changing the status of all operators

        if ($st == 'yes') {
            $st = 'no';
        } else if ($st == 'no') {
            $st = 'yes';
        }
        $query = $this->db->query("UPDATE registered_operators SET home_page='$st' WHERE id='$uid' ");

        if ($query)
            return 1;
        else
            return 0;
    }

    public function getservic_modify() {

        $travel_id = $this->input->post('opid');
        $this->db->distinct();
        $this->db->select('service_num');
        $this->db->select('service_name');
        $this->db->where('travel_id', $travel_id);
        $this->db->where('serviceType', 'special');
        //$this->db->where('status', 1);
        $query = $this->db->get('master_buses');
        $list = '<option value="0">---Select---</option>';
        foreach ($query->result() as $rows) {
            $list = $list . '<option value="' . $rows->service_num . '">' . $rows->service_name . '(' . $rows->service_num . ')' . '</option>';
        }
        return $list;
    }

    public function get_special_services_db() {
        $opid = $this->input->post('opid');
        $srvno = $this->input->post('service');
        $res = mysql_query("SELECT distinct serviceType,service_num,service_name,model,status,from_id,to_id FROM `master_buses` WHERE `serviceType`='special' AND `travel_id` ='$opid' and service_num='$srvno'");

        echo '<table width="99%" border="0" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<td height="43" colspan="2" ><strong>Service Type</strong></td>
			<td height="43" align="center" class="space" ><strong>Service Number</strong></td>
			<td height="43" align="center" class="space"><strong>Service Name</strong></td>
			<td height="43" align="center" class="space"><strong>Bus Type</strong></td>
			<!--td height="43" align="center" class="space"><strong>Status</strong></td-->
			<td align="center" class="space"><strong>Action</strong></td>
		</tr>
	<thead>
	<tbody>';
        $i = 1;
        while ($row = mysql_fetch_array($res)) {
            if ($row['status'] == 0) {
                $status = "DeActivated";
            } else {
                $status = "Activated";
            }
            $edit = '<input type="button" class="newsearchbtn" name="act' . $opid . $s . '" id="act' . $opid . $i . '" value="Active" 
             onclick="activateBus(\'' . $row['service_num'] . '\',' . $opid . ',' . $i . ',' . $row['status'] . ',' . $row['from_id'] . ',
                  ' . $row['to_id'] . ')">';
            echo'<tr >
			<td height="38" colspan="2" align="center" class="space">' . $row['serviceType'] . '</td>
			<input type="hidden"  value="' . $row['serviceType'] . '" id="sertype' . $i . '" name="sertype' . $i . '">
			<td height="38" align="center" class="space">' . $row['service_num'] . '</td>
			<td height="38" align="center" class="space">' . $row['service_name'] . '</td>
			<td height="38" align="center" class="space">' . $row['model'] . '</td>
			<!--td height="38" align="center" class="space">' . $status . ' </td-->
			<td align="center" class="space">' . $edit . ' </td>
		</tr>
		<tr  style="display:none;" >
			<td  colspan="7"  align="center" height="30" class="space" ></td>
		</tr>
		<tr id="tr' . $i . '"  style="display:none;">
			<td  colspan="7" id="dp' . $i . '" align="center" height="30" class="space" ></td>
		</tr>';
            $i++;
        }
        echo '<input type="hidden" id="hdd" value="' . $i . '" >
	     <tbody>
</table>';
    }

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

    public function mail_farmat_db() {

        $description = $this->input->post('description1');
        $solution = $this->input->post('solution1');

        $sql = $this->db->query("insert into mail_format(reason, description, solution)values('','$description','$solution')")or die(mysql_error());
        if ($sql) {
            return 1;
        } else {
            return 2;
        }
    }

    public function get_mail_farmat_db() {
        $sql = $this->db->query("select * from  mail_format");
        $result = $sql->result();
        return $result;
    }

    public function view_mail_farmat_db($id) {
        $sql = $this->db->query("select * from  mail_format where id='$id'");
        $result = $sql->result();
        return $result;
    }

    public function update_mail_farmat_db() {

        $id = $this->input->post('id');
        $description = $this->input->post('description1');
        $solution = $this->input->post('solution1');

        $sql = $this->db->query("UPDATE mail_format SET description='$description', solution='$solution' WHERE id='$id'")or die(mysql_error());
        if ($sql) {
            return 1;
        } else {
            return 2;
        }
    }

    public function responce_logs_count($newdate, $date) {

        $query = $this->db2->query("SELECT count(*) as cnt FROM `response_logs` where `date` between '$newdate' and '$date'");
        foreach ($query->result() as $row) {
            $cnt = $row->cnt;
        }
        return $cnt;
    }

    public function get_responce_logs($limit, $page, $newdate, $date) {

        $this->db2->limit($limit, $page);
        $this->db2->select('*');
        $this->db2->where('date >=', $newdate);
        $this->db2->where('date <=', $date);
        $this->db2->order_by('date_time', 'desc');
        $query = $this->db2->get("response_logs");
        return $query->result();
    }

    public function getservic_pkg() {

        $travel_id = $this->input->post('opid');
        $this->db->distinct();
        $this->db->select('service_num');
        $this->db->select('service_name');
        $this->db->where('travel_id', $travel_id);
        $this->db->where('trip_type', 'pkg');
        //$this->db->where('status', 1);
        $query = $this->db->get('master_buses');
        $list = '<option value="0">---Select---</option>';
        foreach ($query->result() as $rows) {
            $list = $list . '<option value="' . $rows->service_num . '">' . $rows->service_name . '(' . $rows->service_num . ')' . '</option>';
        }
        return $list;
    }
	
	function get_operators() {
        $sql = $this->db2->query("select travel_id,operator_title from registered_operators where status='1' ");
        $data = array();        
        foreach ($sql->result() as $rows) {
            $data[$rows->travel_id] = $rows->operator_title;
        }
        return $data;
    }
	
	function add_service_sms_contact1() {
        $query = $this->db2->query("SELECT distinct ro.operator_title,ssc.id,ssc.travel_id,ssc.service_num,ssc.contact,ssc.status FROM registered_operators ro,service_sms_contact ssc where ssc.travel_id=ro.travel_id");        
        return $query->result();
    }
	
	function getServices1() {
        $travel_id = $this->input->post('op');
		
        $this->db->distinct();
        $this->db->select('service_num');
        $this->db->where('travel_id', $travel_id);
        //$this->db->where('status', 1);
        $query = $this->db->get('master_buses');
        echo '<option value="0">select</option>';
        foreach ($query->result() as $rows) {
            echo '<option value="'.$rows->service_num.'">'.$rows->service_num.'</option>';
        }       
    }
	
	function save_service_sms_contact1() {
		$travel_id = $this->input->post('travel_id');
		$service_num = $this->input->post('service_num');
		$contact = $this->input->post('contact');
		
		$stmt1 = "select * from service_sms_contact where travel_id='$travel_id' and service_num='$service_num'";
		$query1 = $this->db2->query($stmt1);
		
		if($query1->num_rows() <= 0) {
			$stmt = "insert into service_sms_contact(travel_id,service_num,contact) values('$travel_id','$service_num','$contact')";
			$query = $this->db2->query($stmt);
			
			if($query) {
			    echo 1;
			} else {
				echo 0;
			}
		} else {
			echo 'Contact already exists';
		}	
	}
	
	function edit_service_sms_contact1($uid) {
        $query = $this->db2->query("SELECT distinct ro.operator_title,ssc.id,ssc.travel_id,ssc.service_num,ssc.contact,ssc.status FROM registered_operators ro,service_sms_contact ssc where ssc.travel_id=ro.travel_id and ssc.id='$uid'");        
        return $query->result();
    }
	
	function update_service_sms_contact1() {
        $status = $this->input->post('status');
        $id = $this->input->post('id');
        $contact = $this->input->post('contact');
        //echo "$contact";
        $query = $this->db->query("UPDATE service_sms_contact SET status='$status', contact='$contact' WHERE id='$id' ");
        if ($query)
            echo 1;
        else
            echo 0;
    }

}

?>