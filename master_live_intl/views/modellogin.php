<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modellogin
 *
 * @author Administrator
 */
class modellogin extends CI_Model{
    
              public function __construct()
                 {
                  parent::__construct();
                  $this->db1 = $this->load->database('default', TRUE);
                  $this->db2 = $this->load->database('forum', TRUE);
                 }
 
              function login($email,$password)
                {
                 $this->db1->where("Username",$email);
                  $this->db1->where("Password",$password);
           
                 $query=$this->db1->get("master_login");
                     if($query->num_rows()>0)
                       {
         	           foreach($query->result() as $rows)
                                {
            	                    //add all data to session
                                $session_data = array(
                	                       'name' => $rows->Name,
                    	                       'username'  => $rows->Username,
		                               'password'   => $rows->Password,
                                               'mobile_number'   => $rows->Mobile_number,
	                                       'logged_in' 	=> TRUE,
                                );
			}
            	$this->session->set_userdata($session_data);
                return true;            
		}
		return false; 
               }
             
    
             function summary_operators()
                 {
   
                  $query =$this->db2->query("select count(*) as num_rows from registered_operators");
                  $query1 =$this->db2->query("select count(*) as num_rows from registered_operators where status='1'");
              
                  $results1=$query1->result();
                  foreach($query->result() as $rows)
                    {
                    $results=$rows->num_rows;
                    }
                  foreach($query1->result() as $rows1)
                    {
                    $results1=$rows1->num_rows;
                    }
    
                    if($query && $query1)
                      {
                      return $results."|".$results1;
                      }
                    else 
                      {
                       return false; 
                      }  
                 
                }
                
              public function record_pend_count() 
                 {
               $this->db2->select('id');
               $this->db2->where('status',NULL);
               $this->db2->or_where('status',0);
 
               $query=$this->db2->get('registered_operators');
               
               return $query->num_rows();
                 } 
              
              
              function pend_operators($limit,$page)
                  {
                  //logic for showing all pending operators
    
                  $this->db2->limit($limit,$page);
                  $this->db2->select('*');
                  $this->db2->where('status',0);
                  $this->db2->or_where('status',NULL);
                  $this->db2->order_by('operator_title','desc');
                  $query =$this->db2->get("registered_operators");
                  return $query->result();
        
                 }
               public function record_activecount() 
                 {
               $this->db2->select('*');
               $this->db2->where('status',1);
               $query=$this->db2->get('registered_operators');
               
               return $query->num_rows();
                 } 
               
              function active_operators($limit,$page)
                  {
                 //logic for showing all activated operators
                  $this->db2->limit($limit,$page);
                  $this->db2->select('*');
                  $this->db2->where('status',1);
                  $this->db2->order_by('operator_title','desc');
                  $query =$this->db2->get("registered_operators");
	          return $query->result();
        
                 }
              public function record_count() 
                 {
               return $this->db2->count_all("registered_operators");
                 }  
                
              function all_operators($limit,$page)
                  {
                  //logic for showing all operators
                  
                  $this->db2->limit($limit,$page);
                  $this->db2->order_by('operator_title','desc');
                  $query = $this->db2->get('registered_operators');
                  return $query->result();
                  
                  }
                
              
              function active($uid,$st)
                  {
                   //logic for changing the status of all operators
                   if($st==1)
                   {
                   $st=0;
                   }
                   else if($st==0)
                   {
                   $st=1;
                   }
                   $query=$this->db2->query("UPDATE registered_operators SET status='$st' WHERE id='$uid' ");
                     if($query)
                     {
                       
                       $query=$this->db2->query("select * from registered_operators where id='$uid'");
                       
                       if($query->num_rows()>0)
                       {
         	           foreach($query->result() as $rows)
                                {
            	                    //add all data to session
                                               $name  = $rows->name;
                                               $username  = $rows->user_name;
		                               $password  = $rows->password;
                                               $emailid   = $rows->email_id;
                                               $status = $rows->status;
                                   
                                }
                                $x=$this->mail_send($name,$username,$password,$emailid,$status);
                                if($x){
                               return 1;
}
                       }
                       
                     }
                     else
                       return 0;
                  
                  }
              function mail_send($name,$username,$password,$emailid,$status)
                  {
                 //logic for showing the details of operators
                                $this->load->library('email');
                                if($status==0)
                                {
                                $this->email->from('shivani.u@viveinfoservices.com', 'shivani.u@viveinfoservices.com');
                                $this->email->to($emailid); 
                                $this->email->subject('Email Test');
                                $this->email->message('Dear '  .$name. ',
                                                       Thanks for registration.Your account is activated now.
                                                       Username:'.$username .'
                                                       Password:'.$password);	
                                $this->email->send();
                                echo $this->email->print_debugger();
                                }
                                else if($status==1){
                                 $this->email->from('shivani.u@viveinfoservices.com', 'shivani.u@viveinfoservices.com');
                                $this->email->to($emailid); 
                                $this->email->subject('Email Test');
                                $this->email->message('Dear '  .$name. ',
                                                       Your account is deactivated now.
                                                       Username:'.$username .'
                                                       Password:'.$password);	
                                $this->email->send();
                                echo $this->email->print_debugger();
                                }
                                return 1;
		   }
                    
              function detail_operators($uid)
                  {
                 //logic for showing the details of operators
                   $query = $this->db2->query("SELECT * FROM registered_operators WHERE id='$uid' ");
                   return $query->result();
        
                  }
                
                
              function bus()
                 {
                  //select the id and bus model store as in array
                  $this->db2->select('id,model');
                  $this->db2->order_by("model", "asc");
                  $records = $this->db2->get('buses_model');

                  $data = array();
                    foreach($records->result() as $row) {
                      $data[$row->model] = $row->model;
                      }
                  return ($data);
   
                    
                 }
              
              function update_model($n,$o)
                   {
                  //update the bus model in database
                    $query=$this->db2->query("UPDATE buses_model SET model='$n' WHERE model='$o' ");
                    if($query)
                       return 1;
                    else
                       return 0;
                   }
                   
              
              function add_model($text)
                   {
                  //add new bus model in database
                    $query=$this->db2->query("INSERT INTO buses_model VALUES ('','$text')");
                    if($query)
                       return 1;
                    else
                       return 0;
                   }
                   
                   
              function cityadd()
                   {
                   //select the id and city_name and store as array
                    $this->db2->select('city_id,city_name');
                    $this->db2->order_by("city_name", "asc");
                    $records = $this->db2->get('master_cities');
                    $data = array();
                     foreach($records->result() as $row) {
                     $data[$row->city_name] = $row->city_name;
                     }
                    return ($data);
   
                    
                    }
              
              function update_city($new,$old)
                    {
                  //update the existing city in database
                      $query=$this->db2->query("UPDATE master_cities SET city_name='$new' WHERE city_name='$old' ");
                      if($query)
                        return 1;
                      else
                        return 0;
                   }
              
              function add_cities($text)
                    {
                  //add new city to database
                    $query=$this->db2->query("INSERT INTO master_cities VALUES ('','$text')");
                    if($query)
                       return 1;
                    else
                       return 0;
                    }
              
              function bustypes()
                   {
                  //select the id and bus type and store as array
                 $this->db2->select('id,bus_type');
                  $this->db2->order_by("bus_type", "asc");
                 $records = $this->db2->get('buses_type');
                 $data = array();
                 foreach($records->result() as $row) {
                  $data[$row->bus_type] = $row->bus_type;
                 }
                 return ($data);
   
                    
                  }
              
              function update_bus($new,$old)
                  {
                  //update the existing bus type in database
                    $query=$this->db2->query("UPDATE bus_type SET buses_type='$new' WHERE bus_type='$old' ");
                    if($query)
                       return 1;
                    else
                       return 0;
                  }
                  
              
              function add_bustype($text)
                    {
                  //add new bus type to database
                     $query=$this->db2->query("INSERT INTO buses_type VALUES ('','$text')");
                    if($query)
                       return 1;
                    else
                       return 0;
                    }
                    
                    
              function seatarr()
                    {
                  //select the id and seating arrangement and store as array
                    $this->db2->select('id,seat_arr');
                    $this->db2->order_by("seat_arr", "asc");
                    $records = $this->db->get('seats_arrangement');
                    $data = array();
                      foreach($records->result() as $row) {
                      $data[$row->seat_arr] = $row->seat_arr;
                      }
                     return ($data);
   
                    
                   }
                                
              function update_seat($new,$old)
                    {
                  //update the existing seating arrangement in database
                      $query=$this->db2->query("UPDATE seats_arrangement SET seat_arr='$new' WHERE seat_arr='$old' ");
                      if($query)
                        return 1;
                      else
                       return 0;
                   }
              
              function add_seatarr($text)
                   {
                  //add new seating arrangement in database
                     $query=$this->db2->query("INSERT INTO seats_arrangement VALUES ('','$text')");
                     if($query)
                       return 1;
                     else
                       return 0;
                  }

              function get_data_from_db($limit,$start)
               {

                   
                   if($limit!=0)
                    $this->db2->limit($limit,$start);
                    $this->db2->select('master_booking.id,master_booking.tkt_no,master_booking.pnr,master_booking.source,master_booking.dest,master_booking.jdate,master_booking.bdate,master_booking.tkt_fare,registered_operators.name');       
                    $this->db2->from('master_booking');
                    $this->db2->join('registered_operators','registered_operators.travel_id = master_booking.travel_id');
                    $query=$this->db2->get();
                 

                   if($limit==0)
                     return  $query->num_rows();  
                     if($query->num_rows() > 0)
                     { 
                      foreach ($query->result_array() as $row) {
                            $res[] = $row;
                        }
                        return $res;
                    }
                    return false;


               }

             function get_tabledata_from_db()
                {                 
           $this->db2 = $this->load->database('forum', TRUE);
           $from=$this->input->get('date_from');
          $to=$this->input->get('date_to');
          $opid=$this->input->get('opid');
          $agentype=$this->input->get('agentype'); 
      if($opid!='all' && $agentype=='all')
        { 
       $query = $this->db2->query("SELECT master_booking.id as 'S.No',registered_operators.name as 'Operator name',master_booking.tkt_no as 'Ticket Number',master_booking.pnr as 'PNR number',master_booking.source as 'Source',
           master_booking.dest as 'Destination',master_booking.jdate as 'Journey date',master_booking.bdate as 'Booking date',master_booking.tkt_fare as 'Ticket Fare'
           FROM master_booking INNER JOIN registered_operators ON master_booking.travel_id=registered_operators.travel_id where 
           (master_booking.jdate BETWEEN '".$from."' AND '".$to."' or master_booking.bdate BETWEEN '".$from."' AND '".$to."') and master_booking.travel_id='$opid'");
       }
      else if($opid=='all' && $agentype!='all') {
        $query = $this->db2->query("SELECT master_booking.id as 'S.No',registered_operators.name as 'Operator name',master_booking.tkt_no as 'Ticket Number',master_booking.pnr as 'PNR number',master_booking.source as 'Source',
           master_booking.dest as 'Destination',master_booking.jdate as 'Journey date',master_booking.bdate as 'Booking date',master_booking.tkt_fare as 'Ticket Fare'
           FROM master_booking INNER JOIN registered_operators ON master_booking.travel_id=registered_operators.travel_id where 
           (master_booking.jdate BETWEEN '".$from."' AND '".$to."' or master_booking.bdate BETWEEN '".$from."' AND '".$to."') and master_booking.operator_agent_type='$agentype'");
       }
      else  if($opid=='all' && $agentype=='all'){
              $query = $this->db2->query("SELECT master_booking.id as 'S.No',registered_operators.name as 'Operator name',master_booking.tkt_no as 'Ticket Number',master_booking.pnr as 'PNR number',master_booking.source as 'Source',
           master_booking.dest as 'Destination',master_booking.jdate as 'Journey date',master_booking.bdate as 'Booking date',master_booking.tkt_fare as 'Ticket Fare'
           FROM master_booking INNER JOIN registered_operators ON master_booking.travel_id=registered_operators.travel_id where 
           (master_booking.jdate BETWEEN '".$from."' AND '".$to."' or master_booking.bdate BETWEEN '".$from."' AND '".$to."')");
          }
      else  if($opid!='all' && $agentype!='all'){
              $query = $this->db2->query("SELECT master_booking.id as 'S.No',registered_operators.name as 'Operator name',master_booking.tkt_no as 'Ticket Number',master_booking.pnr as 'PNR number',master_booking.source as 'Source',
           master_booking.dest as 'Destination',master_booking.jdate as 'Journey date',master_booking.bdate as 'Booking date',master_booking.tkt_fare as 'Ticket Fare'
           FROM master_booking INNER JOIN registered_operators ON master_booking.travel_id=registered_operators.travel_id where 
           (master_booking.jdate BETWEEN '".$from."' AND '".$to."' or master_booking.bdate BETWEEN '".$from."' AND '".$to."')  and master_booking.travel_id='$opid' and master_booking.operator_agent_type='$agentype'");
          }
      return  $query;
   
    }
    
   function displayReports($limit,$page) {
              $this->db2 = $this->load->database('forum', TRUE);
              $from=$this->input->get('from');
              $to=$this->input->get('to');
              $opid=$this->input->get('opid');
              $agentype=$this->input->get('agentype');
   if($limit==0 && $page==0)
       {
       //getting the count
   $query= $this->db2->query("select * from master_booking where jdate BETWEEN '".$from."' AND '".$to."'");
     return $query->num_rows();  
       }
   else{
   if($opid!='all' && $agentype=='all')
        { 
       $query=$this->db2->query("select * from master_booking   where 
           (jdate BETWEEN '".$from."' AND '".$to."' or bdate BETWEEN '".$from."' AND '".$to."') and travel_id='$opid' limit $limit,$page");
      }
   else if($opid=='all' && $agentype!='all') {
        $query=$this->db2->query("select * from master_booking  where 
           (jdate BETWEEN '".$from."' AND '".$to."' or bdate BETWEEN '".$from."' AND '".$to."') and operator_agent_type='$agentype' limit $limit,$page");
        }
   else  if($opid=='all' && $agentype=='all'){
        $query=$this->db2->query("select * from master_booking  where 
          ( jdate BETWEEN '".$from."' AND '".$to."' or bdate BETWEEN '".$from."' AND '".$to."') limit $limit,$page");
   }
   else  if($opid!='all' && $agentype!='all'){
        $query=$this->db2->query("select * from master_booking  where 
          (jdate BETWEEN '".$from."' AND '".$to."' or  bdate BETWEEN '".$from."' AND '".$to."') and travel_id='$opid' and operator_agent_type='$agentype' limit $limit,$page");
   }
    
    return $query;      
   }
         
       }
      
    
     function get_booking_from_db()
   {               
         
                  echo '<h4 align="center">Summary</h4>
                       <br />
                       <table align="center" width="500" border="0">
                       <tr ><td style="border-right:#f2f2f2 solid 4px; border-top:#f2f2f2 solid 4px; border-left:#f2f2f2 solid 4px;">';
                       
                  echo "<table align='center'>";             
          $query =$this->db2->query("select count(pass) as num_rows from master_booking");
          $query1 =$this->db2->query("select count(pass) as num_rows from master_booking where status='cancelled'");
             foreach($query->result() as $rows)
                    {
                    $results=$rows->num_rows;
                     }
                  foreach($query1->result() as $rows1)
                    {
                    $results1=$rows1->num_rows;
                    }
                    $total=$results1+$results;
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
                   foreach($sum->result() as $rows)
                    {
                    $book=$rows->tkt_fare;
                    }
                    $this->db2->select_sum('tkt_fare');
                    $this->db2->where('status','cancelled');
                    $sum1 = $this->db2->get('master_booking');
                  $query3 =$this->db2->query("select count(pass) as num_rows from master_booking where status='cancelled'");
                   foreach($query3->result() as $rows1)
                    {
                    $res=$rows1->num_rows;
                    }
                  foreach($sum1->result() as $rows)
                    {
                      
                     if($res==0)
                     {
                      $can= $res;  
                     }
                     else{
                    $can=$rows->tkt_fare;
                    }
                    }
                    $totalval=$book+$can;
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

    function get_api_from_db($list)
			{
          
			$sql=$this->db2->query("select id,name from agents_operator where agent_type='3' and api_type='$list'");
                        $data=array();
                        $data[0]="-----select-----";
                        foreach ($sql->result() as $rows)
                        {
                            $data[$rows->id]=$rows->name;
                        }
		        return $data;
			
         
        }
   
   function get_api_table_from_db() {
     
       $list=$this->input->post('list');
       $this->db2->select('*');
       if($list=='op' || $list=='te')
       {
       $this->db2->where('api_type',$list);
       }
       else
       {
       }
       $this->db2->where('agent_type',3);
       $query=$this->db2->get('agents_operator');
       if($list=='te')
       {
       echo '<table width="700">
       <tr>
		<td></td>
		<td style="font-size:12px" align="right">';
       
       echo anchor("master_control/addnewagent", "Add New Agent", "title='new agent'");   
         echo '</td>
		</tr> 
                </table>';
         }  else {
           
       }
       
       echo '<table id="tbl" width="700" border="0" id="tbl"><tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; 
                       border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; 
                       border-left:#f2f2f2 solid 1px;">
        <th>Name</th>
        <th>Location</th>
        <th>Contact</th>
        <th>Key</th>
        <th>Type</th>
        <th>Action</th>
        </tr>';
       
       foreach ($query->result() as $value) {
           $i=$value->id;
                echo "<tr style='font-size:12'>
                 <td align='center'>$value->name</td>
                 <td align='center'>$value->city</td>
                 <td align='center'>$value->mobile</td>
                 <td align='center'>$value->api_key</td>
                 <td align='center'>$value->api_type</td>
                 <td align='center'><span style='font-weight:bold;text-decoration:underline;cursor:pointer;'>".anchor('master_control/UpdateDet?id='.$i, 'Update', 'EditAgent')."</span></td>
                 </tr>";
       }
       echo '</table>';
   }

   function get_details_from_db($id){
       $this->db2->select('*');
       $this->db2->where('id',$id);
       $query=$this->db2->get('agents_operator');
       return $query->result();
   }
   
   function update_details_db() {
       $id=$this->input->post('id');
       $name=$this->input->post('name');
       $mobile=$this->input->post('mobile');
       $email=$this->input->post('email');
       $address=$this->input->post('address');
       $api_key=$this->input->post('api_key');
       $apitype=$this->input->post('apitype');
       $uname=$this->input->post('uname');
       $pass=$this->input->post('pass');
       $st=$this->input->post('status');
       $ip=$this->input->post('ip');
       $margin=$this->input->post('margin');
       $pay=$this->input->post('pay');
       $limit=$this->input->post('limit');
       $balance=$this->input->post('balance');
       $api_key2=  substr($api_key,0,2);
       if($apitype=='te' && $api_key2!='TE')
       {
           $api='TE'.$api_key;
       }
       else if($apitype=='op' && $api_key2!='OP'){
           $api='OP'.$api_key;
       }
       else{
         $api=$api_key;
       }
       $query=  $this->db2->query("update agents_operator SET name='$name',uname='$uname',email='$email',mobile='$mobile',
                               address='$address',api_key='$api',api_type='$apitype',password='$pass',status='$st',ip='$ip',margin='$margin',pay_type='$pay',bal_limit='$limit',balance='$balance' WHERE id='$id'");
                       if($query)
                       echo 1;
                       else 
                       echo 0;
   }
   

   
   function get_operator_from_db() {
	      $sql=$this->db2->query("select travel_id,operator_title from registered_operators ");
                        $data=array();
                        $data[0]="-----select-----";
                        foreach ($sql->result() as $rows)
                        {
                            $data[$rows->travel_id]=$rows->operator_title;
                        }
		        return $data;
   }
   
   function get_operator_agent_from_db() {
       $list=$this->input->post('list');
       $operator=$this->input->post('operator');
       echo '<table id="tbl" width="700" border="0" id="tbl"><tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; 
                       border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; 
                       border-left:#f2f2f2 solid 1px;">
        <th>Name</th>
        <th>Location</th>
        <th>Contact</th>
        <th>Key</th>
        <th>Type</th>
        <th>Action</th>
        </tr>';
       $this->db2->select('*');
       $this->db2->where('api_type',$list);
       $this->db2->where('operator_id',$operator);
       $this->db2->where('agent_type',3);
       $query=$this->db2->get('agents_operator');
       foreach ($query->result() as $value) {
           $i=$value->id;
           echo "<tr style='font-size:12'>
                 <td align='center'>$value->name</td>
                 <td align='center'>$value->city</td>
                 <td align='center'>$value->mobile</td>
                 <td align='center'>$value->api_key</td>
                 <td align='center'>$value->api_type</td>
                 <td align='center'><span style='font-weight:bold;text-decoration:underline;cursor:pointer;'>".anchor('master_control/UpdateDet?id='.$i, 'Update', 'EditAgent')."</span></td>
                 </tr>";
       }
       echo '</table>';
   }
   
   function get_citylist_from_db(){
               $this->db2->select('*');
               $this->db2->from('master_cities');
               $query = $this->db2->get();
               $location=array();
               $location['0']="--select city--";
               foreach ($query->result() as $value) 
                   {
                $location[$value->city_name] =$value->city_name; 
                
               }
               return $location;
                
            } 
            
            function store_agent($data,$username) 
    {
        $this->db2->select('*');
        if($username==''){
            $rws=0;
        }
        else
        {
         $this->db2->where('uname',$username);
        $query =$this->db2->get("agents_operator");  
        $rws=$query->num_rows();
        }
       
        //if email already exist
        if($rws>0)
            return 2;
        else {//else mail not exist
         $query2=$this->db2->insert('agents_operator',$data);
        if($query2)  
            return 1;
        else 
            return 0;
        }
      
    }//store agent
    function get_postagentslist_db($at) 
    {

        $this->db2->select('*');
        $this->db2->where('agent_type',$at);
        $this->db2->where('pay_type','postpaid');
        $query =$this->db2->get("agents_operator");
	    return $query->result();
    }//all_inhouse_agent()get_postagentslist_db
    
    function get_preagentslist_db($at) 
    {
        $this->db2->select('*');
        $this->db2->where('agent_type',$at);
        $this->db2->where('pay_type','prepaid');
        
        $query =$this->db2->get("agents_operator");
	    return $query->result();
    }//all_inhouse_agent()get_postagentslist_db
           
    function get_agentslist_db($at) 
    {
        $this->db2->select('*');
        $this->db2->where('agent_type',$at);
        
        $query =$this->db2->get("agents_operator");
	    return $query->result();
    }//get all agents list
    
    function detail_agents($uid)
          {
           $query = $this->db2->query("SELECT * FROM agents_operator WHERE id='$uid' ");
           return $query->result();

          }
          
function detail_externalagents($uid)
            {
               $query = $this->db2->query("SELECT * FROM agents_operator WHERE id='$uid' ");
               return $query->result();
        
            }    
    
function get_bookings_from_db($i)

       {
         $now=date('Y-m-d');
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
         $query=$this->db2->get('master_booking');
           
          if($i==1){
        foreach ($query->result()  as $rows) {
      
        $query1 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and bdate ='$now'");

             foreach($query1->result() as $rows)
                    {
                    
                    $results=$rows->num_rows;
                    }
        $query2 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and bdate ='$now'");

             foreach($query2->result() as $rows)
                    {
                    $results1=$rows->num_rows;
                    }
        $query3 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and bdate ='$now'");

             foreach($query3->result() as $rows)
                    {
                    $results2=$rows->num_rows;
                    }
        $query8 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and bdate ='$now'");

             foreach($query8->result() as $rows)
                    {
                    $results7=$rows->num_rows;
                    }            
        $query4 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and status='cancelled' and bdate ='$now'");

             foreach($query4->result() as $rows)
                    {
                    $results3=$rows->num_rows;
                    } 
                    
        $query5 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and status='cancelled' and bdate ='$now'");

             foreach($query5->result() as $rows)
                    {
                    $results4=$rows->num_rows;
                    } 
        $query6 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and status='cancelled' and bdate ='$now'");

             foreach($query6->result() as $rows)
                    {
                    $results5=$rows->num_rows;
                    }
        $query7 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and status='cancelled' and bdate ='$now'");

             foreach($query7->result() as $rows)
                    {
                    $results6=$rows->num_rows;
                    }            
                $net_total=$results-$results5;
                $net_total1=$results2-$results3;
                $net_total2=$results1-$results4;
                $net_total3=$results7-$results6;
                $gross_book=$results+$results2+$results1+$results7;
                $can_book=$results5+$results3+$results4+$results6;
                $net_book=$net_total+$net_total1+$net_total2;
        }  
          }
          if($i==2){
        foreach ($query->result()  as $rows) {
        $res_query =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and bdate like '%$now%'");

             foreach($res_query->result() as $rows)
                    {
                    $tot_res=$rows->num_rows;
                    }
        $query1 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='3' and bdate like '%$now%'");

             foreach($query1->result() as $rows)
                    {
                 if($tot_res==0)
                 {
                  $results= $tot_res;  
                 }
                 else{
                    $results=$rows->num_rows;
                 }
                    }
                    
        $res_query1 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and bdate like '%$now%'");

             foreach($res_query1->result() as $rows)
                    {
                    $tot_res1=$rows->num_rows;
                    }            
        $query2 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='1' and bdate like '%$now%'");

             foreach($query2->result() as $rows)
                    {
                 if($tot_res1==0)
                 {
                  $results1= $tot_res1;  
                 }
                  else{
                    $results1=$rows->num_rows;
                    }
                  }
                  
        $res_query6 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and bdate like '%$now%'");

             foreach($res_query6->result() as $rows)
                    {
                    $tot_res6=$rows->num_rows;
                    }            
        $query7 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='4' and bdate like '%$now%'");

             foreach($query7->result() as $rows)
                    {
                 if($tot_res6==0)
                 {
                  $results7= $tot_res6;  
                 }
                  else{
                    $results7=$rows->num_rows;
                    }
                  }          
        $res_query2 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and bdate like '%$now%'");

             foreach($res_query2->result() as $rows)
                    {
                    $tot_res2=$rows->num_rows;
                    }
        $query3 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='2' and bdate like '%$now%'");

             foreach($query3->result() as $rows)
                    {
                  if($tot_res2==0)
                 {
                  $results2= $tot_res2;  
                 }
                 else{
                    $results2=$rows->num_rows;
                    }
                    }
        $res_query3 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and status='cancelled' and bdate like '%$now%'");

             foreach($res_query3->result() as $rows)
                    {
                    $tot_res3=$rows->num_rows;
                    }            
        $query4 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='2' and status='cancelled' and bdate like '%$now%'");

             foreach($query4->result() as $rows)
                    {
                 if($tot_res3==0)
                 {
                  $results3= $tot_res3;  
                 }
                 else{
                    $results3=$rows->num_rows;
                    }
                    }
        $res_query4 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and status='cancelled' and bdate like '%$now%'");

             foreach($res_query4->result() as $rows)
                    {
                    $tot_res4=$rows->num_rows;
                    }            
        $query5 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='1' and status='cancelled' and bdate like '%$now%'");

             foreach($query5->result() as $rows)
                    {
                 if($tot_res4==0)
                 {
                  $results4= $tot_res4;  
                 }
                 else{
                    $results4=$rows->num_rows;
                    }
                    }
        $res_query5 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and status='cancelled' and bdate like '%$now%'");

             foreach($res_query5->result() as $rows)
                    {
                    $tot_res5=$rows->num_rows;
                    }            
        $query6 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='3' and status='cancelled' and bdate like '%$now%'");

             foreach($query6->result() as $rows)
                    {
                 if($tot_res5==0)
                 {
                  $results5= $tot_res5;  
                 }
                 else{
                    $results5=$rows->num_rows;
                    }
                    }
        $res_query7 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and status='cancelled' and bdate like '%$now%'");

             foreach($res_query7->result() as $rows)
                    {
                    $tot_res7=$rows->num_rows;
                    }            
        $query8 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='4' and status='cancelled' and bdate like '%$now%'");

             foreach($query8->result() as $rows)
                    {
                 if($tot_res7==0)
                 {
                  $results6= $tot_res7;  
                 }
                 else{
                    $results6=$rows->num_rows;
                    }            
                    }
                $net_total=$results-$results5;
                $net_total1=$results2-$results3;
                $net_total2=$results1-$results4;
                $net_total3=$results7-$results6;
                $gross_book=$results+$results2+$results1+$results7;
                $can_book=$results5+$results3+$results4+$results6;
                $net_book=$net_total+$net_total1+$net_total2;
        
          }
          }
               echo '<tr style="font-size:12px">
                    <td id="td">API</td><td id="td">'.$results.'</td><td id="td">'.$results5.'</td><td id="td">'.$net_total.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Agent</td><td id="td">'.$results2.'</td><td id="td">'.$results3.'</td><td id="td">'.$net_total1.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Branch</td><td id="td">'.$results1.'</td><td id="td">'.$results4.'</td><td id="td">'.$net_total2.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Website</td><td id="td">'.$results7.'</td><td id="td">'.$results6.'</td><td id="td">'.$net_total3.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td"><b>Total</b></td><td id="td">'.$gross_book.'</td><td id="td">'.$can_book.'</td><td id="td">'.$net_book.'</td>
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
         $data=$this->db2->get('master_booking');
          $month=date('m');
          
         if($i==1){ 
        foreach ($data->result()  as $rows) {
      
        $data1 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and bdate like '%-$month%'");

             foreach($data1->result() as $rows)
                    {
                    $res=$rows->num_rows;
                    }
        $data2 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and bdate like '%-$month%'");

             foreach($data2->result() as $rows)
                    {
                    $res1=$rows->num_rows;
                    }
        $data8 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and bdate like '%-$month%'");

             foreach($data8->result() as $rows)
                    {
                    $res7=$rows->num_rows;
                    }            
        $data3 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and bdate like '%-$month%'");

             foreach($data3->result() as $rows)
                    {
                    $res2=$rows->num_rows;
                    } 
        $data4 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and status='cancelled' and bdate like '%-$month%'");

             foreach($data4->result() as $rows)
                    {
                    $res3=$rows->num_rows;
                    }   
        $data5 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and status='cancelled' and bdate like '%-$month%'");

             foreach($data5->result() as $rows)
                    {
                    $res4=$rows->num_rows;
                    } 
        $data6 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and status='cancelled' and bdate like '%-$month%'");

             foreach($data6->result() as $rows)
                    {
                    $res5=$rows->num_rows;
                    }
        $data7 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and status='cancelled' and bdate like '%-$month%'");

             foreach($data7->result() as $rows)
                    {
                    $res6=$rows->num_rows;
                    }             
                $net_booktotal=$res-$res5;
                $net_booktotal1=$res2-$res3;
                $net_booktotal2=$res1-$res4;
                $net_booktotal3=$res7-$res6;
                $gross=$res+$res2+$res1+$res7;
                $can=$res5+$res3+$res4+$res6;
                $net=$net_booktotal+$net_booktotal1+$net_booktotal2;
        }
        }  
        if($i==2){ 
        foreach ($data->result()  as $rows) {
        $tot_val =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and bdate like '%-$month%'");

             foreach($tot_val->result() as $rows)
                    {
                    $totres=$rows->num_rows;
                    }
        $data1 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='3' and bdate like '%-$month%'");
                   
             foreach($data1->result() as $rows)
                    {
                 if($totres==0)
                 {
                   $res= $totres; 
                 }
                 else{
                    $res=$rows->num_rows;
                    }
                    }
        $tot_val1 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and bdate like '%-$month%'");

             foreach($tot_val1->result() as $rows)
                    {
                    $totres1=$rows->num_rows;
                    }
        $data2 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='1' and bdate like '%-$month%'");
                   
             foreach($data2->result() as $rows)
                    {
                 if($totres1==0)
                 {
                    $res1=$totres1; 
                 }
                    $res1=$rows->num_rows;
                    }
        $tot_val6 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and bdate like '%-$month%'");

             foreach($tot_val6->result() as $rows)
                    {
                    $totres6=$rows->num_rows;
                    }            
        $data7 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='4' and bdate like '%-$month%'");

             foreach($data7->result() as $rows)
                    {
                 if($totres6==0)
                 {
                  $res7= $totres6;  
                 }
                  else{
                    $res7=$rows->num_rows;
                    }
                  }            
        $tot_val2 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and bdate like '%-$month%'");

             foreach($tot_val2->result() as $rows)
                    {
                    $totres2=$rows->num_rows;
                     }
        $data3 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='2' and bdate like '%-$month%'");
                   
             foreach($data3->result() as $rows)
                    {
                    if($totres2==0)
                    {
                     $res2= $totres2;  
                    }
                    else {
                    $res2=$rows->num_rows;
                    }
                    }
        $tot_val3 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and status='cancelled' and bdate like '%-$month%'");

             foreach($tot_val3->result() as $rows)
                    {
                    $totres3=$rows->num_rows;
                     }
        $data4 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='2' and status='cancelled' and bdate like '%-$month%'");
                    
             foreach($data4->result() as $rows)
                    {
                    if($totres3==0)
                    {
                     $res3=$totres3;   
                    }
                    else{
                    $res3=$rows->num_rows;
                    }
                    }
        $tot_val4 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and status='cancelled' and bdate like '%-$month%'");

             foreach($tot_val4->result() as $rows)
                    {
                    $totres4=$rows->num_rows;
                     }            
        $data5 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='1' and status='cancelled' and bdate like '%-$month%'");
                    
             foreach($data5->result() as $rows)
                    {
                 if($totres4==0)
                 {
                     $res4=$totres4;
                 }
                 else{
                    $res4=$rows->num_rows;
                    }
                    }
         $tot_val5 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and status='cancelled' and bdate like '%-$month%'");

             foreach($tot_val5->result() as $rows)
                    {
                    $totres5=$rows->num_rows;
                     }           
        $data6 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='3' and status='cancelled' and bdate like '%-$month%'");
                    
             foreach($data6->result() as $rows)
                    {
                 if($totres5==0){
                     $res5=$totres5;
                 }
                 else{
                    $res5=$rows->num_rows;
                    }
                    }
         $tot_val7 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and status='cancelled' and bdate like '%-$month%'");

             foreach($tot_val7->result() as $rows)
                    {
                    $totres7=$rows->num_rows;
                    }            
        $data8 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='4' and status='cancelled' and bdate like '%-$month%'");

             foreach($data8->result() as $rows)
                    {
                 if($totres7==0)
                 {
                  $res6= $totres7;  
                 }
                 else{
                    $res6=$rows->num_rows;
                    }            
                    }           
                $net_booktotal=$res-$res5;
                $net_booktotal1=$res2-$res3;
                $net_booktotal2=$res1-$res4;
                $net_booktotal3=$res7-$res6;
                $gross=$res+$res2+$res1+$res7;
                $can=$res5+$res3+$res4+$res6;
                $net=$net_booktotal+$net_booktotal1+$net_booktotal2;
        }
        }
               echo '<tr style="font-size:12px">
                    <td id="td">API </td><td id="td">'.$res.'</td><td id="td">'.$res5.'</td><td id="td">'.$net_booktotal.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Agent </td><td id="td">'.$res2.'</td><td id="td">'.$res3.'</td><td id="td">'.$net_booktotal1.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Branch </td><td id="td">'.$res1.'</td><td id="td">'.$res4.'</td><td id="td">'.$net_booktotal2.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Website </td><td id="td">'.$res7.'</td><td id="td">'.$res6.'</td><td id="td">'.$net_booktotal3.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td"><b>Total</b></td><td id="td">'.$gross.'</td><td id="td">'.$can.'</td><td id="td">'.$net.'</td>
                    </tr>';

               echo '</table>';
       } 
       
       function get_operator() {
			$sql=$this->db2->query("select travel_id,operator_title from registered_operators ");
                        $data=array();
                        $data['all']="All";
                        foreach ($sql->result() as $rows)
                        {
                            $data[$rows->travel_id]=$rows->operator_title;
                        }
		        return $data;
       }
       
       function get_summary_from_db($op,$i)

       {
         
         if($op=='all')
         {
             $this->get_bookings_from_db($i);
         }
         else{
         $now=date('Y-m-d');
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
         $query=$this->db2->get('master_booking');
           
          if($i==1){
        foreach ($query->result()  as $rows) {
      
        $query1 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and  bdate ='$now'");

             foreach($query1->result() as $rows)
                    {
                    
                    $results=$rows->num_rows;
                    }
        $query2 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and bdate ='$now'");

             foreach($query2->result() as $rows)
                    {
                    $results1=$rows->num_rows;
                    }
        $query3 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and bdate ='$now'");

             foreach($query3->result() as $rows)
                    {
                    $results2=$rows->num_rows;
                    }
        $query8 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and bdate ='$now'");

             foreach($query8->result() as $rows)
                    {
                    $results7=$rows->num_rows;
                    }            
        $query4 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and status='cancelled' and bdate ='$now'");

             foreach($query4->result() as $rows)
                    {
                    $results3=$rows->num_rows;
                    } 
                    
        $query5 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and status='cancelled' and bdate ='$now'");

             foreach($query5->result() as $rows)
                    {
                    $results4=$rows->num_rows;
                    } 
        $query6 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and status='cancelled' and bdate ='$now'");

             foreach($query6->result() as $rows)
                    {
                    $results5=$rows->num_rows;
                    }
        $query7 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and status='cancelled' and bdate ='$now'");

             foreach($query7->result() as $rows)
                    {
                    $results6=$rows->num_rows;
                    }            
                $net_total=$results-$results5;
                $net_total1=$results2-$results3;
                $net_total2=$results1-$results4;
                $net_total3=$results7-$results6;
                $gross_book=$results+$results2+$results1+$results7;
                $can_book=$results5+$results3+$results4+$results6;
                $net_book=$net_total+$net_total1+$net_total2;
        }  
          }
          if($i==2){
        foreach ($query->result()  as $rows) {
        $res_query =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and bdate like '%$now%'");

             foreach($res_query->result() as $rows)
                    {
                    $tot_res=$rows->num_rows;
                    }
        $query1 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and bdate like '%$now%'");

             foreach($query1->result() as $rows)
                    {
                 if($tot_res==0)
                 {
                  $results= $tot_res;  
                 }
                 else{
                    $results=$rows->num_rows;
                 }
                    }
                    
        $res_query1 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and bdate like '%$now%'");

             foreach($res_query1->result() as $rows)
                    {
                    $tot_res1=$rows->num_rows;
                    }            
        $query2 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and bdate like '%$now%'");

             foreach($query2->result() as $rows)
                    {
                 if($tot_res1==0)
                 {
                  $results1= $tot_res1;  
                 }
                  else{
                    $results1=$rows->num_rows;
                    }
                  }
                  
        $res_query6 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and bdate like '%$now%'");

             foreach($res_query6->result() as $rows)
                    {
                    $tot_res6=$rows->num_rows;
                    }            
        $query7 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and bdate like '%$now%'");

             foreach($query7->result() as $rows)
                    {
                 if($tot_res6==0)
                 {
                  $results7= $tot_res6;  
                 }
                  else{
                    $results7=$rows->num_rows;
                    }
                  }          
        $res_query2 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and bdate like '%$now%'");

             foreach($res_query2->result() as $rows)
                    {
                    $tot_res2=$rows->num_rows;
                    }
        $query3 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and bdate like '%$now%'");

             foreach($query3->result() as $rows)
                    {
                  if($tot_res2==0)
                 {
                  $results2= $tot_res2;  
                 }
                 else{
                    $results2=$rows->num_rows;
                    }
                    }
        $res_query3 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

             foreach($res_query3->result() as $rows)
                    {
                    $tot_res3=$rows->num_rows;
                    }            
        $query4 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

             foreach($query4->result() as $rows)
                    {
                 if($tot_res3==0)
                 {
                  $results3= $tot_res3;  
                 }
                 else{
                    $results3=$rows->num_rows;
                    }
                    }
        $res_query4 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

             foreach($res_query4->result() as $rows)
                    {
                    $tot_res4=$rows->num_rows;
                    }            
        $query5 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

             foreach($query5->result() as $rows)
                    {
                 if($tot_res4==0)
                 {
                  $results4= $tot_res4;  
                 }
                 else{
                    $results4=$rows->num_rows;
                    }
                    }
        $res_query5 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

             foreach($res_query5->result() as $rows)
                    {
                    $tot_res5=$rows->num_rows;
                    }            
        $query6 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

             foreach($query6->result() as $rows)
                    {
                 if($tot_res5==0)
                 {
                  $results5= $tot_res5;  
                 }
                 else{
                    $results5=$rows->num_rows;
                    }
                    }
        $res_query7 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

             foreach($res_query7->result() as $rows)
                    {
                    $tot_res7=$rows->num_rows;
                    }            
        $query8 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and status='cancelled' and bdate like '%$now%'");

             foreach($query8->result() as $rows)
                    {
                 if($tot_res7==0)
                 {
                  $results6= $tot_res7;  
                 }
                 else{
                    $results6=$rows->num_rows;
                    }            
                    }
                $net_total=$results-$results5;
                $net_total1=$results2-$results3;
                $net_total2=$results1-$results4;
                $net_total3=$results7-$results6;
                $gross_book=$results+$results2+$results1+$results7;
                $can_book=$results5+$results3+$results4+$results6;
                $net_book=$net_total+$net_total1+$net_total2;
        
          }
          }
               echo '<tr style="font-size:12px">
                    <td id="td">API</td><td id="td">'.$results.'</td><td id="td">'.$results5.'</td><td id="td">'.$net_total.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Agent</td><td id="td">'.$results2.'</td><td id="td">'.$results3.'</td><td id="td">'.$net_total1.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Branch</td><td id="td">'.$results1.'</td><td id="td">'.$results4.'</td><td id="td">'.$net_total2.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Website</td><td id="td">'.$results7.'</td><td id="td">'.$results6.'</td><td id="td">'.$net_total3.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td"><b>Total</b></td><td id="td">'.$gross_book.'</td><td id="td">'.$can_book.'</td><td id="td">'.$net_book.'</td>
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
         $data=$this->db2->get('master_booking');
          $month=date('m');
          
         if($i==1){ 
        foreach ($data->result()  as $rows) {
      
        $data1 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and bdate like '%-$month%'");

             foreach($data1->result() as $rows)
                    {
                    $res=$rows->num_rows;
                    }
        $data2 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and bdate like '%-$month%'");

             foreach($data2->result() as $rows)
                    {
                    $res1=$rows->num_rows;
                    }
        $data8 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and bdate like '%-$month%'");

             foreach($data8->result() as $rows)
                    {
                    $res7=$rows->num_rows;
                    }            
        $data3 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and bdate like '%-$month%'");

             foreach($data3->result() as $rows)
                    {
                    $res2=$rows->num_rows;
                    } 
        $data4 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

             foreach($data4->result() as $rows)
                    {
                    $res3=$rows->num_rows;
                    }   
        $data5 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

             foreach($data5->result() as $rows)
                    {
                    $res4=$rows->num_rows;
                    } 
        $data6 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

             foreach($data6->result() as $rows)
                    {
                    $res5=$rows->num_rows;
                    }
        $data7 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

             foreach($data7->result() as $rows)
                    {
                    $res6=$rows->num_rows;
                    }             
                $net_booktotal=$res-$res5;
                $net_booktotal1=$res2-$res3;
                $net_booktotal2=$res1-$res4;
                $net_booktotal3=$res7-$res6;
                $gross=$res+$res2+$res1+$res7;
                $can=$res5+$res3+$res4+$res6;
                $net=$net_booktotal+$net_booktotal1+$net_booktotal2;
        }
        }  
        if($i==2){ 
        foreach ($data->result()  as $rows) {
        $tot_val =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and bdate like '%-$month%'");

             foreach($tot_val->result() as $rows)
                    {
                    $totres=$rows->num_rows;
                    }
        $data1 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and bdate like '%-$month%'");
                   
             foreach($data1->result() as $rows)
                    {
                 if($totres==0)
                 {
                   $res= $totres; 
                 }
                 else{
                    $res=$rows->num_rows;
                    }
                    }
        $tot_val1 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and bdate like '%-$month%'");

             foreach($tot_val1->result() as $rows)
                    {
                    $totres1=$rows->num_rows;
                    }
        $data2 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and bdate like '%-$month%'");
                   
             foreach($data2->result() as $rows)
                    {
                 if($totres1==0)
                 {
                    $res1=$totres1; 
                 }
                    $res1=$rows->num_rows;
                    }
        $tot_val6 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and bdate like '%-$month%'");

             foreach($tot_val6->result() as $rows)
                    {
                    $totres6=$rows->num_rows;
                    }            
        $data7 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and bdate like '%-$month%'");

             foreach($data7->result() as $rows)
                    {
                 if($totres6==0)
                 {
                  $res7= $totres6;  
                 }
                  else{
                    $res7=$rows->num_rows;
                    }
                  }            
        $tot_val2 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and bdate like '%-$month%'");

             foreach($tot_val2->result() as $rows)
                    {
                    $totres2=$rows->num_rows;
                     }
        $data3 =$this->db2->query("select sum(tkt_fare) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and bdate like '%-$month%'");
                   
             foreach($data3->result() as $rows)
                    {
                    if($totres2==0)
                    {
                     $res2= $totres2;  
                    }
                    else {
                    $res2=$rows->num_rows;
                    }
                    }
        $tot_val3 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

             foreach($tot_val3->result() as $rows)
                    {
                    $totres3=$rows->num_rows;
                     }
        $data4 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='2' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");
                    
             foreach($data4->result() as $rows)
                    {
                    if($totres3==0)
                    {
                     $res3=$totres3;   
                    }
                    else{
                    $res3=$rows->num_rows;
                    }
                    }
        $tot_val4 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

             foreach($tot_val4->result() as $rows)
                    {
                    $totres4=$rows->num_rows;
                     }            
        $data5 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='1' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");
                    
             foreach($data5->result() as $rows)
                    {
                 if($totres4==0)
                 {
                     $res4=$totres4;
                 }
                 else{
                    $res4=$rows->num_rows;
                    }
                    }
         $tot_val5 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

             foreach($tot_val5->result() as $rows)
                    {
                    $totres5=$rows->num_rows;
                     }           
        $data6 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='3' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");
                    
             foreach($data6->result() as $rows)
                    {
                 if($totres5==0){
                     $res5=$totres5;
                 }
                 else{
                    $res5=$rows->num_rows;
                    }
                    }
         $tot_val7 =$this->db2->query("select count(pass) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

             foreach($tot_val7->result() as $rows)
                    {
                    $totres7=$rows->num_rows;
                    }            
        $data8 =$this->db2->query("select sum(refamt) as num_rows from master_booking where operator_agent_type='4' and travel_id='$op' and status='cancelled' and bdate like '%-$month%'");

             foreach($data8->result() as $rows)
                    {
                 if($totres7==0)
                 {
                  $res6= $totres7;  
                 }
                 else{
                    $res6=$rows->num_rows;
                    }            
                    }           
                $net_booktotal=$res-$res5;
                $net_booktotal1=$res2-$res3;
                $net_booktotal2=$res1-$res4;
                $net_booktotal3=$res7-$res6;
                $gross=$res+$res2+$res1+$res7;
                $can=$res5+$res3+$res4+$res6;
                $net=$net_booktotal+$net_booktotal1+$net_booktotal2;
        }
        }
               echo '<tr style="font-size:12px">
                    <td id="td">API </td><td id="td">'.$res.'</td><td id="td">'.$res5.'</td><td id="td">'.$net_booktotal.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Agent </td><td id="td">'.$res2.'</td><td id="td">'.$res3.'</td><td id="td">'.$net_booktotal1.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Branch </td><td id="td">'.$res1.'</td><td id="td">'.$res4.'</td><td id="td">'.$net_booktotal2.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td">Website </td><td id="td">'.$res7.'</td><td id="td">'.$res6.'</td><td id="td">'.$net_booktotal3.'</td>
                    </tr>
                    <tr style="font-size:12px">
                    <td id="td"><b>Total</b></td><td id="td">'.$gross.'</td><td id="td">'.$can.'</td><td id="td">'.$net.'</td>
                    </tr>';

               echo '</table>';
       } 
       }
function getAgentName($agentn,$agent_type){
	$this->db2 = $this->load->database('forum', TRUE);		
	if($agent_type==3)
    $sql=$this->db2->query("select name,id from agents_operator where (pay_type='$agentn' and agent_type='$agent_type' and api_type='op')");
   else
	$sql=$this->db2->query("select name,id from agents_operator where (pay_type='$agentn' and agent_type='$agent_type')");
                        $data=array();
                        $data[0]="-----select-----";
                        foreach ($sql->result() as $rows)
                        {
                            $data[$rows->id]=$rows->name;
                        }
		        return $data;
	}
       
       
      
       
       function showOperators()
       {
	
	$sql=$this->db2->query("select name,travel_id from registered_operators");
                        $data=array();
                        $data[0]="-----select-----";
                        foreach ($sql->result() as $rows)
                        {
                            $data[$rows->travel_id]=$rows->name;
                        }
		        return $data; 
       }
       
       function prepaid_agents_db($at) 
    {
        $op=$this->input->post('op');
        $this->db2->select('*');
        $this->db2->where('agent_type',$at);
        $this->db2->where('pay_type','prepaid');
        if($op!='all'){
          $this->db2->where('operator_id',$op);  
        }
         else{
         } 
             
        $query1 =$this->db2->get("agents_operator");
        echo "<table class='gridtable' style='margin: 0px auto; width='550'>";
echo "<tr >";
echo "<th>Name</th>";
echo "<th>Username</th>";
echo "<th>Contact No.</th>";
echo "<th>Email Id</th>";
echo "<th>Balance</th>";
echo "<th>Margin</th>";
echo "<th>Pay Type</th>";
echo "<th>Limit</th>";
echo "<th>Option</th>";
echo "</tr>";
$i=1;
foreach($query1->result() as $row){
       $uid=$row->id;
       $status= $row->status;
       if($status==1)
       {
        $x='Active';   
       }
       else {
           $status=0;
         $x='Inactive';  
       }
	
	echo '<tr  align="center">';
        
	echo "<td style='font-size:12px';>".$row->name."</td>";
         echo "<td style='font-size:12px';>".$row->uname."</td>";
	echo "<td style='font-size:12px;'>".$row->mobile."</td>";
	echo "<td style='font-size:12px;'>".$row->email."</td>";
        echo "<td style='font-size:12px;'>".$row->balance."</td>";
        echo "<td style='font-size:12px;'>".$row->margin."</td>";
        echo "<td style='font-size:12px;'>".$row->pay_type."</td>";
        echo "<td style='font-size:12px;'>".$row->bal_limit."</td>";
	echo "<td>".anchor('master_control/view_prepaid?uid='.$uid, 'View', '')."</td>";
        echo "</tr>";
        $i++;
}
echo "</table>";
    }
    
    function postpaid_agents_db($at) 
    {
        $op=$this->input->post('op');
        $this->db2->select('*');
        $this->db2->where('agent_type',$at);
        $this->db2->where('pay_type','postpaid');
        if($op!='all'){
          $this->db2->where('operator_id',$op);  
        }
         else{
         } 
             
        $query1 =$this->db2->get("agents_operator");
        echo "<table class='gridtable' style='margin: 0px auto; width='550'>";
echo "<tr >";
echo "<th>Name</th>";
echo "<th>Username</th>";
echo "<th>Contact No.</th>";
echo "<th>Email Id</th>";
echo "<th>Balance</th>";
echo "<th>Margin</th>";
echo "<th>Pay Type</th>";
echo "<th>Limit</th>";
echo "<th>Option</th>";
echo "</tr>";
$i=1;
foreach($query1->result() as $row){
       $uid=$row->id;
       
	
	echo '<tr  align="center">';
        
	echo "<td style='font-size:12px';>".$row->name."</td>";
         echo "<td style='font-size:12px';>".$row->uname."</td>";
	echo "<td style='font-size:12px;'>".$row->mobile."</td>";
	echo "<td style='font-size:12px;'>".$row->email."</td>";
        echo "<td style='font-size:12px;'>".$row->balance."</td>";
        echo "<td style='font-size:12px;'>".$row->margin."</td>";
        echo "<td style='font-size:12px;'>".$row->pay_type."</td>";
        echo "<td style='font-size:12px;'>".$row->bal_limit."</td>";
	echo "<td>".anchor('master_control/view_postpaid?uid='.$uid, 'View', '')."</td>";
        echo "</tr>";
        $i++;
}
echo "</table>";

    }
    
    function Branch_agents_db($at) 
    {
        $op=$this->input->post('op');
        $this->db2->select('*');
        $this->db2->where('agent_type',$at);
        if($op!='all'){
          $this->db2->where('operator_id',$op);  
        }
         else{
         } 
             
        $query1 =$this->db2->get("agents_operator");
        
        echo "<table style='margin: 0px auto;' class='gridtable'  width='550'>";
echo "<tr>";
echo "<th>Name</th>";
echo "<th>Username</th>";
echo "<th>Contact No.</th>";
echo "<th>Email Id</th>";
echo "<th>Balance</th>";
echo "<th>Margin</th>";
echo "<th>Pay Type</th>";
echo "<th>Limit</th>";
echo "<th>Option</th>";
echo "</tr>";
$i=1;
foreach($query1->result() as $row){
       $uid=$row->id;
       
	echo "<tr>";
        
	echo "<td style='font-size:12px';>".$row->name."</td>";
        echo "<td style='font-size:12px';>".$row->uname."</td>";
	echo "<td style='font-size:12px;'>".$row->mobile."</td>";
	echo "<td style='font-size:12px;'>".$row->email."</td>";
        echo "<td style='font-size:12px;'>".$row->balance."</td>";
        echo "<td style='font-size:12px;'>".$row->margin."</td>";
        echo "<td style='font-size:12px;'>".$row->pay_type."</td>";
        echo "<td style='font-size:12px;'>".$row->bal_limit."</td>";
        echo "<td>".anchor('master_control/view_inhouse?uid='.$uid, 'View', '')."</td>";
        echo "</tr>";
        $i++;
}
echo "</table>";
    }
 function getBilledValue_detail(){
          $this->db2 = $this->load->database('forum', TRUE);
         $bill=$this->input->post('bill');
          if($bill!='all'){
          $this->db2->where('bill_type',$bill); 
           $this->db2->where('status',1); 
            $query1 =$this->db2->get("registered_operators");
        }
         else{
             $this->db2->where('status',1); 
            $query1 =$this->db2->get("registered_operators");
         } 
             
      
        
       
$i=1;
//print_r($query1->result());
if($query1->num_rows()>0){
 echo '<div id="mydiv"><table style="font-size:13px; background:#84a3b8;"  width="550" align="center">';
echo "<tr>";
echo "<th>operator</th>";
echo "<th>name</th>";
echo "<th> Bill_Type</th>";
echo "<th>Bill_Amount</th>";
echo "<th>Net Fare</th>";
echo "<th>Billed</th>";

echo "</tr>";
foreach($query1->result() as $row){
     $class = ($i%2 == 0)? 'bg': 'bg1';
       $uid=$row->id;
      $bill_amt=$row->bill_amt;
      $billtype=$row->bill_type;
       if($billtype=='' || $billtype=='bus')
          $billtype="bus";
      else
           $billtype= $billtype;  
       $query2= $this->db2->query("select sum(tkt_fare) as netfare from master_booking where agent_id='$uid'");
     
           $query3= $this->db2->query("select sum(pass) as nopass from master_booking where agent_id='$uid'");
        foreach($query2->result() as $row2){
          $netfare=$row2->netfare;  
             }
       foreach($query3->result() as $row3){
          $nopass=$row3->nopass;  
          $billed=$nopass*$bill_amt;
       }
	echo "<tr class='".$class."'>";
        
	echo "<td style='font-size:12px';>".$row->operator_title."</td>";
        echo "<td style='font-size:12px';>".$row->name."</td>";
	echo "<td style='font-size:12px;'>".$billtype."</td>";
	echo "<td style='font-size:12px;'>".$bill_amt."</td>";
        echo "<td style='font-size:12px;'>".$netfare."</td>";
        echo "<td style='font-size:12px;'>".$billed."</td>";
        echo "</tr>";
        $i++;
}
echo "</table></div>";
 echo '<table align="center"><tr><td><input type="button" value="print" onclick="getprint(mydiv)"></td></tr></table>';     
    }
    else{
        echo "0";
        
    }
    
    }

 function operator_detail_update_in_db(){
          $this->db2 = $this->load->database('forum', TRUE);
         $optitle=$this->input->post('optitle');
     $firm_type=$this->input->post('firm_type');
        $name=$this->input->post('name');
         $address=$this->input->post('address');
          $location=$this->input->post('location');
           $contact_no=$this->input->post('contact_no');
            $fax_no=$this->input->post('fax_no');
             $email_id=$this->input->post('email_id');
              $pan_no=$this->input->post('pan_no');
               $bank_name=$this->input->post('bank_name');
                $bank_account_no=$this->input->post('bank_account_no');
                 $branch=$this->input->post('branch');
                  $ifsc_code=$this->input->post('ifsc_code');
                   $travel_id=$this->input->post('travel_id');
                    $user_name=$this->input->post('user_name');
                     $bill_type=$this->input->post('bill_type');
                     $bill_amt=$this->input->post('bill_amt');
                      $id=$this->input->post('id');
   
     $up=$this->db2->query("update registered_operators set  operator_title='$optitle',
         firm_type='$firm_type',name='$name',
             address='$address'
             ,location='$location',contact_no='$contact_no',fax_no='$fax_no',
                 email_id='$email_id',pan_no='$pan_no',bank_name='$bank_name',
             bank_account_no='$bank_account_no',branch='$branch',ifsc_code='$ifsc_code',travel_id='$travel_id',
                 user_name='$user_name',bill_type='$bill_type',bill_amt='$bill_amt' where id='$id'");
     if($up)
         echo 1;
     else
         echo 0;
    }

function getoperatorWise_report(){
         $this->db2 = $this->load->database('forum', TRUE);
         $fdate=$this->input->post('fdate');
         $tdate=$this->input->post('tdate');
          $this->db2->distinct("*");
          $this->db2->select("travel_id");
         $opdata=$this->db2->get("master_buses");
         echo "<table style='font-size:13px;   width='650' align='center'>
                <tr style='font-size:13px; color:#ffffff; background:#84a3b8;'>
                <th width='171'>Operator Name</th>
                <th width='137' height='21'>Total Seats</th>
                <th width='157'>Seat booked</th>
                <th width='165'>Occupancy%</th>
                </tr>";
          $i=1;
         foreach($opdata->result() as $row){
                       $seat_nos_count=0;

               $travel_id=$row->travel_id;
        $this->db2->select("operator_title");
         $this->db2->where("travel_id",$travel_id);
         $opdata1=$this->db2->get("registered_operators");
          foreach($opdata1->result() as $row){
          $name=$row->operator_title;
                }
$resquery=$this->db2->query("select distinct service_num from master_buses where travel_id='$travel_id' and status='1'");
foreach($resquery->result() as $rowsss)
                    { 
      $service_num=$rowsss->service_num;
       //echo $service_num."/";  
     $res_query=$this->db2->query("select seat_nos from master_buses where  status='1' and service_num='$service_num'");
     $res_query1=$this->db2->query("select count(distinct journey_date) as num_rows1 from buses_list where (journey_date BETWEEN '".$fdate."' AND '".$tdate."') and status='1'  and service_num='$service_num'");
                    foreach($res_query->result() as $rows1)
                    {  
                    $seat_nos=$rows1->seat_nos;//total seat of particular service number
                    }
                    foreach ($res_query1->result() as $v2) 
                    {
                   $avail_days=$v2->num_rows1; //available days of particular service number
                    }
                    //getting total seats of particular service number
                   $count=$avail_days*$seat_nos;
                   $seat_nos_count = $seat_nos_count+$count;
                  }
      $query3 =$this->db2->query("select  sum(pass) as bookseat from master_booking where travel_id='$travel_id'   and (bdate BETWEEN '".$fdate."' AND '".$tdate."') and (status='confirmed' || status='Confirmed')"); 
     $query4 =$this->db2->query("select  sum(pass) as canseat from master_booking where  travel_id='$travel_id' and (bdate BETWEEN '".$fdate."' AND '".$tdate."') and (status='cancelled' || status='Cancelled')"); 
            
                 foreach($query3->result() as $rows)
                    { 
                    $bookseat=$rows->bookseat;
                   }
                  foreach($query4->result() as $rowss)
                    { 
                 $canseat=$rowss->canseat;
                    }
                $totbook=$bookseat-$canseat;
                  if($seat_nos_count==0)
                         $da= 0;
                     else
                         $da=$totbook/$seat_nos_count;
                    $oc=($da)*100;
                    $occupancy = sprintf ("%.3f", $oc);
                    $class = ($i%2 == 0)? 'bg': 'bg1'; 
                    echo '<tr class="'.$class.'">';
                    echo '<td height="30">'.$name.'</td>';
                    echo '<td>'.$seat_nos_count.'</td>';
                    echo '<td>'.$totbook.'</td>';
                    echo '<td>'.$occupancy.'</td>';
                    echo '</tr>';
                    $i++;
          }
          echo '</table>';
    }

    
   function getOperator_Service_report(){
         $this->db2 = $this->load->database('forum', TRUE);
        $optravel_id=$this->input->post('opid'); 
        if($optravel_id==0)
          { 
            $query=$this->db2->query("select distinct service_num from master_buses");
          }
       else
         {
$query=$this->db2->query("select distinct service_num from master_buses where travel_id='$optravel_id'");
        }
     
if($query->num_rows()==0){
echo "<table style='font-size:13px;   width='350' align='center'>
                <tr style='font-size:13px; color:red; '>
                <td width='171'>No Records found</td></table>";
}
    else{
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
        $i=1;
        foreach ($query->result() as $val)
            {
           $serno= $val->service_num;
            
$query1=$this->db2->query("select distinct from_name from master_buses where service_num='$serno'");
$query2=$this->db2->query("select distinct to_name from master_buses where service_num='$serno'");
$query3=$this->db2->query("select * from master_buses where service_num='$serno'");
$from='';
$to='';
$j=1;
 foreach ($query1->result() as $val1){
     $from_name=$val1->from_name;
     if($from=='')
      $from=$from_name;
     elseif( $j%4!=0 && $from!='')
       $from=$from.",".$val1->from_name; 
     elseif( $j%4==0 && $from!='')
       $from=$from.",".$val1->from_name."<br/>" ;
     $j++;
     }
     $j=1;
 foreach ($query2->result() as $val2){
     $to_name=$val2->to_name;
     if($to=='')
    $to=$to_name;
    elseif( $j%3!=0 && $to!='')
      $to=$to.",".$val2->to_name;   
      elseif( $j%3==0 && $to!='')
       $to=$to.",".$val2->to_name."<br/>" ;
$j++;
}
  foreach ($query3->result() as $val3)
      {
              $bus_type=$val3->bus_type;
              $fare=0;
             if($bus_type=='seater')
              $fare=$val3->seat_fare; 
              else if($bus_type=='sleeper')
              $fare=$val3->lberth_fare.",".$val3->uberth_fare; 
               else
              $fare=$val3->seat_fare.",".$val3->lberth_fare.",".$val3->uberth_fare; 
              //echo $bus_type;
              $seat_nos=$val3->seat_nos;
              $start_time=$val3->start_time;
             $travel_id= $val3->travel_id;
      
      }              $class = ($i%2 == 0)? 'bg': 'bg1'; 
                    echo '<tr class="'.$class.'">';
                    echo '<td height="30">'.$serno.'</td>';
                    echo '<td width="300">'.$from.' <span style="color:blue;"> To </span>  '.$to.'</td>';
                    echo '<td>'.$fare.'</td>';
                    echo '<td>'.$bus_type.'</td>';
                    echo '<td>'.$seat_nos.'</td>';
                    echo '<td>'.$start_time.'</td>';
                    echo '<td width="200">
                        <a href="#" onclick="layout('.$i.')" class="lay'.$i.'">Layout</a></br>
                        <a href="#" onclick="boarding('.$i.')" class="board'.$i.'">Boarding</a><br>
                        <a href="#" onclick="eminities('.$i.')" class="emi'.$i.'">eminities</a>
                            <input type="hidden" id="hd'.$i.'" value="'.$serno.'">
                            </td>';
                   
                    echo '</tr>';
                    echo  '<tr><td colspan="7" id="sh'.$i.'" > </td></tr>';
    $i++;  
    
            }
         echo '</table>';
         echo '<input type="hidden" id="cnt" value="'.$i.'">';
    }
    }
    
    function getOperator_Service_bording_details(){

         $this->db2 = $this->load->database('forum', TRUE);
     $serviceno=$this->input->post('serviceno'); 
 
     $query=$this->db2->query("select * from boarding_points where service_num='$serviceno' and board_or_drop_type='board'");
     echo '<table  border="1" align="center" cellpadding="0" cellspacing="0">
         <tr style="font-size:13px; color:#ffffff; background:#58a3b8;"><td>Board</td><td>Contact</td></tr>';
     $j=1;
     foreach($query->result() as $val){
         $boardpt=$val->board_drop;
         $contact=$val->contact;
          $class = ($j%2 == 0)? 'bg': 'bg1'; 
       echo "<tr class=$class><td>$boardpt</td><td>$contact</td></tr>";  
    $j++;
    }
    echo '</table>';
    
    }
function getOperator_Service_eminities_details(){
     $this->db2 = $this->load->database('forum', TRUE);
     $serviceno1=$this->input->post('serviceno1');     
     $query=$this->db2->query("select * from eminities where service_num='$serviceno1'");
    
     foreach($query->result() as $val){
         $water=$val->water_bottle;
         $blanket=$val->blanket;
           $cp=$val->charging_point;
            $vedio=$val->video;
    
 }
echo "<table border='1' align='center' cellpadding='0' cellspacing='0' width=200px style='style='border-color:#009999'>
         <tr style='font-family: Arial, Helvetica, sans-serif; font-size:12px;'><td>Water:</td><td>$water</td></tr>
         <tr style='background-color:#eff3f5;font-family: Arial, Helvetica, sans-serif; font-size:12px;'><td>Blanket:</td><td>$blanket</td></tr>
            <tr style='font-family: Arial, Helvetica, sans-serif; font-size:12px;'> <td>Charging Point:</td><td>$cp</td></tr>
                <tr style='background-color:#eff3f5;font-family: Arial, Helvetica, sans-serif; font-size:12px;'> <td>Video:</td><td>$vedio</td></tr></table>";
 
}
function getOperator_Service_Layout_details(){
     $sernum=$this->input->post('serviceno2'); 

    $this->db->select('layout_id,seat_type');
         $this->db2->where('service_num',$sernum);
       $sql=$this->db2->get('master_layouts');
         foreach ($sql->result() as $row) {
                      $layout_id=$row->layout_id;
	    $seat_type=$row->seat_type;
	    $lid=explode("#",$layout_id); 
         }
	 
    echo '<table><tr>
    <td align="center"  style="border-left:#f2f2f2 solid 4px;">';
			if($lid[1]=='seater')
		     {
            //getting max of row and col from mas_layouts
                     $this->db2->select_max('row','mrow');
                     $this->db2->select_max('col','mcol');
                     $this->db2->where('service_num',$sernum);
                     //$this->db2->where('travel_id',$travel_id);
                     $sq11=$this->db2->get('master_layouts');
                     $seat_name='';
                        foreach ($sq11->result() as $row1) {
                            $mrow=$row1->mrow;
                            $mcol=$row1->mcol;   
                         } 
              		  echo "<table border='1' cellpadding='0' align='center' >";
			  for($i=1;$i<=$mcol;$i++)
			   {
				echo "<tr>";
				for($j=1;$j<=$mrow;$j++)
				{
                                        $this->db2->select('*');
                                        $this->db2->where('row',$j);
                                        $this->db2->where('col',$i);
                                        $this->db2->where('service_num',$sernum);
                                        //$this->db2->where('travel_id',$travel_id);
                                        $sql3=$this->db2->get('master_layouts'); 
                                        foreach ($sql3->result() as $row2) {
                                          $seat_name=$row2->seat_name;
		                          $seat_type=$row2->seat_type;
		                          $available=$row2->available;
		                          $available_type=$row2->available_type;  
                                              }
			if($seat_name=='')
			{   
			echo "<td style='border:none;' align='center'>&nbsp;</td>";
			}
			else // if($available==1)
			{
			echo "<td style='background-color: #fff; width:35px'>$seat_name</td>";
                                                        }
                                                       $seat_name='';
			}
                                                       echo "</tr>";        									
			} 
		echo '</table></td></tr></table>
                </td>
                </tr>
              </table>';
                     }       	
	else if($lid[1]=='sleeper')
          {
        //getting max of row and col from mas_layouts
        //UpperDeck
            $this->db2->select_max('row','mrow');
            $this->db2->select_max('col','mcol');
            $this->db2->where('service_num',$sernum);
            //$this->db2->where('travel_id',$travel_id);
            $this->db2->where('seat_type','U');
            $sq1=$this->db2->get('master_layouts');  
            foreach ($sq1->result() as $row1) {
               $mrow=$row1->mrow;
               $mcol=$row1->mcol; 
             }
       
        
		echo "<span style='font-size:14px; font-weight:bold;'>UpperDeck</span> <br/>";
                echo "<table border='1' cellpadding='0'>";
            for($k=1;$k<=$mcol;$k++)
            {
                echo "<tr>";
                for($l=1;$l<=$mrow;$l++)
                {
                    $this->db2->select('*');
                    $this->db2->where('row',$l);
                    $this->db2->where('col',$k);
                    $this->db2->where('service_num',$sernum);
                   // $this->db2->where('travel_id',$travel_id);
                    $this->db2->where('seat_type','U');
                    $sql3=$this->db2->get('master_layouts');
                      foreach ($sql3->result() as $row2) {
                            $seat_name=$row2->seat_name;
                            $available=$row2->available;
                      }
		if($seat_name=='')
                {
		echo "<td style='border:none;' align='center'>&nbsp;</td>";
                }
		else
                {
		echo "<td style='background-color: #fff; width:30px'>$seat_name</td>";	
		}
                 $seat_name='';
               }
              echo "</tr>";                                            
             } 
           echo "</table><br/>" ;
	 // Lower Deck
                  $this->db2->select_max('row','mroww');
                  $this->db2->select_max('col','mcoll');
                  $this->db2->where('service_num',$sernum);
                  //$this->db2->where('travel_id',$travel_id);
                  $this->db2->where('seat_type','L');
                  $sq1l=$this->db->get('master_layouts');  
                  foreach ($sq1l->result() as $roww){
                       $mroww=$roww->mroww;
                       $mcoll=$roww->mcoll;
                  }
		echo "<span style='font-size:14px; font-weight:bold;'>LowerDeck</span><br/>";
        echo "<table border='1' cellpadding='0'>";
            for($k=1;$k<=$mcoll;$k++)
            {
                echo "<tr>";
                for($l=1;$l<=$mroww;$l++)
                {
                    $this->db2->select('*');
                    $this->db2->where('row',$l);
                    $this->db2->where('col',$k);
                    $this->db2->where('service_num',$sernum);
                    //$this->db2->where('travel_id',$travel_id);
                    $this->db2->where('seat_type','L');
                    $sql3=$this->db2->get('master_layouts');
                    foreach ($sql3->result() as $row2){
                        $seat_name=$row2->seat_name;
                        $available=$row2->available;
                    }
			if($seat_name=='')
                        {
			echo "<td style='border:none;' align='center'>&nbsp;</td>";
                        }
			else
                        {
			echo "<td style='background-color: #fff; width:30px'>$seat_name</td>";
			}
                         $seat_name='';
                      }
                    echo "</tr>";                                            
                } 
                echo '</table></td></tr></table>
                </td>
                </tr>
              </table>';
	}// if(sleeper)
	else if($lid[1]=='seatersleeper')
    {
  
        //getting max of row and col from mas_layouts
        //UpperDeck
                  $this->db2->select_max('row','mrow');
                  $this->db2->select_max('col','mcol');
                  $this->db2->where('service_num',$sernum);
                  //$this->db2->where('travel_id',$travel_id);
                  $this->db2->where("(seat_type='U:b' OR seat_type='U:s')");
                  $sqll=$this->db->get('master_layouts');
                  foreach ($sqll->result() as $row1){
                         $mrow=$row1->mrow;
                         $mcol=$row1->mcol;
                  }
	           echo "<span style='font-size:14px; font-weight:bold;'>UpperDeck</span> <br/>";
                             echo "<table border='1' cellpadding='0'>";
                         for($k=1;$k<=$mcol;$k++)
                            {
                                echo "<tr>";
                                for($l=1;$l<=$mrow;$l++)
                                   {
                                      $this->db2->select('*');
                                      $this->db2->where('row',$l);
                                      $this->db2->where('col',$k);
                                      $this->db2->where('service_num',$sernum);
                                      //$this->db2->where('travel_id',$travel_id);
                                      $this->db2->where("(seat_type='U:b' OR seat_type='U:s')");
                                      $sql3=$this->db2->get('master_layouts');
                                      foreach ($sql3->result() as $row2){
                                             $seat_name=$row2->seat_name;
                                             $available=$row2->available;
                                             $available_type=$row2->available_type;
                                             $seat_type=$row2->seat_type;
                                         }
				 if($seat_type=='U:b')
			                    $st="(B)";
			                   else if($seat_type=='U:s')
				 $st="(S)";
					 
                                  if($seat_name=='')
				  {
				echo "<td style='border:none;' align='center'>&nbsp;</td>";
				  }
				  else
				  {
				  echo "<td style='background-color: #E4E4E4; width:35px'>$seat_name$st</td>";
				  }//inner for
                                  $seat_name='';
				  }//else
                                echo "</tr>";                                            
                                 } //outer for
                              echo "</table><br/>" ;
			// Lower Deck
                             
                             $this->db2->select_max('row','mroww');
                             $this->db2->select_max('col','mcoll');
                             $this->db2->where('service_num',$sernum);
                             //$this->db2->where('travel_id',$travel_id);
                             $this->db2->where("(seat_type='L:b' OR seat_type='L:s')");
                             $sq1l=$this->db2->get('master_layouts');
                             foreach ($sq1l->result() as $roww){
                               $mroww=$roww->mroww;
                               $mcoll=$roww->mcoll;
                              }
                              echo "<span style='font-size:14px; font-weight:bold;'>LowerDeck</span><br/>";
                              echo "<table border='1' cellpadding='0'>";
                                for($k=1;$k<=$mcoll;$k++)
                                 {
                                  echo "<tr>";
                                   for($l=1;$l<=$mroww;$l++)
                                     {
                                       $this->db2->select('*');
                                       $this->db2->where('row',$l);
                                       $this->db2->where('col',$k);
                                       $this->db2->where('service_num',$sernum);
                                      //$this->db2->where('travel_id',$travel_id);
                                       $this->db2->where("(seat_type='L:b' OR seat_type='L:s')");
                                       $sql3=$this->db2->get('master_layouts');   
                                         foreach ($sql3->result() as $row2){
                                           $seat_name=$row2->seat_name;
                                           $available=$row2->available;
                                           $available_type=$row2->available_type;
			                   $seat_type=$row2->seat_type;
                                          }
					  if($seat_type=='L:b')
					     $st="(B)";
					  else if($seat_type=='L:s')
					     $st="(S)";
                                          if($seat_name=='')
				           {
				            echo "<td style='border:none;' align='center'>&nbsp;</td>";
				           }
				          else
				           {  
				            echo "<td style='background-color: #fff; width:35px'>$seat_name$st</td>";
                                           }
                                         $seat_name='';
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
        
    
        $fdate=$this->input->post('fdate');
        $tdate=$this->input->post('tdate');
        $travel_id=$this->input->post('op');
        echo "<table align='center'  width='650'>
                <tr style='font-size:13px; color:#ffffff; background:#84a3b8;'>
                <th width='171'>Bus type</th>
                <th width='137' height='21'>Total Tickets</th>
                <th width='157'>Tickets booked</th>
                <th width='165'>Occupancy%</th>
                </tr>";
                 $i=0;
                 $seat_nos_count=0;
                $this->db2->distinct();
                $this->db2->select('model');
                if($travel_id=='all'){
                    
                }
                else{
                $this->db2->where('travel_id',$travel_id); 
                }
                $query=$this->db2->get('master_buses');
                foreach ($query->result() as $value) {//main loop
                $busmodel=$value->model; //getting model
                $this->db2->distinct();    
                $this->db2->select('service_num');
                if($travel_id=='all'){
                    
                }
                else{
                $this->db2->where('travel_id',$travel_id);
                }
                $this->db2->where('model',$busmodel);
                $query11=$this->db2->get('master_buses');
                //gtting distinct service number based on model
                    foreach ($query11->result() as $value) {
                    $srno=$value->service_num;
                //logic for getting total number of seats
                    if($travel_id=='all'){
                $p1=$this->db2->query("select seat_nos from master_buses where  status='1' and service_num='$srno'");  
                    }
                    else{
                $p1=$this->db2->query("select seat_nos from master_buses where  status='1' and travel_id='$travel_id' and service_num='$srno'");  
                    } 
                foreach ($p1->result() as $values) {
                  $seat_nos=$values->seat_nos;
                  //getting available days based on service_number
                  if($travel_id=='all'){
                 $p2=$this->db2->query("select count(distinct journey_date) as num_rows1 from buses_list where (journey_date BETWEEN '$fdate' AND '$tdate') and status='1' and service_num='$srno'");  
                  }
                  else{
                 $p2=$this->db2->query("select count(distinct journey_date) as num_rows1 from buses_list where (journey_date BETWEEN '$fdate' AND '$tdate') and status='1' and travel_id='$travel_id' and service_num='$srno'");  
                  }
                 foreach ($p2->result() as $v2) {
                   $avail_days=$v2->num_rows1; 
                   $count=$avail_days*$seat_nos;
                 }
                 
                 }
                  if($count=='' || $count==0)
                  {
                   $seat_nos_count=$count;   
                  }
                  else{
                     $seat_nos_count=$seat_nos_count+$count;
                  }
                    
                    } //query11   for each
                    //echo $srno;
                    if($travel_id=='all'){
                    $query5 =$this->db2->query("select sum(pass) as num_rows from master_booking where  bus_model ='$busmodel' and (bdate BETWEEN '".$fdate."' AND '".$tdate."') and (status='confirmed' || status='Confirmed')");
                }
                else{
         $query5 =$this->db2->query("select sum(pass) as num_rows from master_booking where  bus_model ='$busmodel' and travel_id='$travel_id' and (bdate BETWEEN '".$fdate."' AND '".$tdate."') and (status='confirmed' || status='Confirmed')"); 
                }                     
              //print_r($query5->result());
                if($travel_id=='all'){
                   $query6 =$this->db2->query("select sum(pass) as num_rowss from master_booking where bus_model ='$busmodel' and (bdate BETWEEN '".$fdate."' AND '".$tdate."') and (status='cancelled' || status='Cancelled')"); 
                }
                else{
                   $query6 =$this->db2->query("select sum(pass) as num_rowss from master_booking where bus_model ='$busmodel' and travel_id='$travel_id' and (bdate BETWEEN '".$fdate."' AND '".$tdate."') and (status='cancelled' || status='Cancelled')"); 
                  //print_r($query6->result());
                }
                   foreach($query5->result() as $rows)
                    {
                       $results_conf=$rows->num_rows;
                    
                    }
                    foreach($query6->result() as $row)
                    {
                    $results_can=$row->num_rowss;
                       
                    }
                     $totalbooked=$results_conf-$results_can;
                   
                    $oc=($totalbooked/$seat_nos_count)*100;
                    $occupancy = sprintf ("%.3f", $oc);
                   
                   $class = ($i%2 == 0)? 'bg': 'bg1'; 
                    echo '<tr class="'.$class.'">';
                    echo '<td height="30">'.$busmodel.'</td>';
                    echo '<td>'.$seat_nos_count.'</td>';
                    echo '<td>'.$totalbooked.'</td>';
                    echo '<td>'.$occupancy.'</td>';
                    echo '</tr>';
                    $i++;
                   
                   }//main loop closed
                  
               
                echo '</table>';
    }

function getOperator_route_details(){

     //$this->db2 = $this->load->database('forum', TRUE);
                $travel_id=$this->input->post('opid');
                $fdate=$this->input->post('fdate');
                $tdate=$this->input->post('tdate');
                $i=1;
                echo "<table align='center'  width='650'>
                <tr style='font-size:13px; color:#ffffff; background:#84a3b8;'>
                <th width='171'>Routes</th>
                <th width='137' height='21'>Total Tickets</th>
                <th width='157'>Tickets booked</th>
                <th width='165'>Occupancy%</th>
                </tr>";
                if($travel_id==0){
                $this->db2->distinct();
                $this->db2->select('service_num');
                $query=$this->db2->get('master_buses');
                }else{
                $this->db2->distinct();
                $this->db2->select('service_num');
                $this->db2->where('travel_id',$travel_id); 
                $query=$this->db2->get('master_buses');
                }
                foreach ($query->result() as $value) {
                    $srno=$value->service_num;
                   // echo $srno;
 $query1=$this->db2->query("select min(start_time) as busstart_time from master_buses where service_num='$srno'");
                
              foreach ($query1->result() as $value1) {
               $busstartime=$value1->busstart_time;
                }
                
                 $query2=$this->db2->query("select max(journey_time) as buslastdrop_time from master_buses where service_num='$srno'");
                foreach ($query2->result() as $value2) {
              $lastbusdroptime=$value2->buslastdrop_time;
                }
                
                $query3=$this->db2->query("select distinct from_name from master_buses where service_num='$srno' and start_time='$busstartime'");
                foreach ($query3->result() as $value3) {
                $from_name=$value3->from_name;
                
                }
              $query4=$this->db2->query("select distinct to_name from master_buses where service_num='$srno' and journey_time='$lastbusdroptime'");
                foreach ($query4->result() as $value4) {
                $to_name=$value4->to_name;
                
                }  
                
                $query5 =$this->db2->query("select  sum(pass) as num_rows from master_booking where  service_no ='$srno'  and (bdate BETWEEN '".$fdate."' AND '".$tdate."') and (status='confirmed' || status='Confirmed')"); 
                 $query6 =$this->db2->query("select  sum(pass) as num_rows from master_booking where  service_no ='$srno'  and (bdate BETWEEN '".$fdate."' AND '".$tdate."') and (status='cancelled' || status='Cancelled')"); 
                foreach($query5->result() as $rows)
                    {
                    $results2=$rows->num_rows;
                    }

                    foreach($query6->result() as $row)
                    {
                    $results3=$row->num_rows;
                    }
                    $totalbooked=$results2-$results3;
                 $res_query1=$this->db2->query("select distinct journey_date from buses_list where service_num='$srno'  and (journey_date BETWEEN '".$fdate."' AND '".$tdate."') and status='1' ");
                   $getcount=$res_query1->num_rows();
                  // echo "count".$getcount;
                 $res_query=$this->db2->query("select seat_nos from master_buses where service_num='$srno' ");
                 foreach($res_query->result() as $rows)
                    {
                    $tot_res1=$rows->seat_nos;
                    //echo $tot_res1;
                    $tot_res=$getcount*$tot_res1;
                    }
                    $oc=($results2/$tot_res)*100;
                    $occupancy = sprintf ("%.3f", $oc);
                    $class = ($i%2 == 0)? 'bg': 'bg1'; 
                    echo '<tr class="'.$class.'">';
                    echo '<td height="30">'.$from_name.'-'.$to_name.'</td>';
                    echo '<td>'.$tot_res.'</td>';
                    echo '<td>'.$totalbooked.'</td>';
                    echo '<td>'.$occupancy.'</td>';
                    echo '</tr>';
                    $i++;
                }
                echo '</table>';
                
 }           
 function get_cancelTerm_OfOperator_from_db(){
                $this->db2 = $this->load->database('forum', TRUE);
                $travel_id=$this->input->post('traid');
                $query=$this->db->query("select * from registered_operators where travel_id='$travel_id'" );
                // echo $travel_id;
                $i=1;
                 if($query->num_rows()>0){
                echo "<table align='center'  width='550'>
                <tr style='font-size:13px; color:#ffffff; background:#84a3b8;'>
                <th width='171'>Cancellation Time(Hours)</th>
                <th width='171' height='21'>Cancellation Charge(%)</th>
                </tr>"; 
                foreach($query->result() as $val){
               $canc_terms1=$val->canc_terms;
             $canc_terms2=  explode('@', $canc_terms1);
              for($i=0;$i<count($canc_terms2);$i++){
                 $canc_terms3=  explode('#', $canc_terms2[$i]);
              //echo $canc_terms3;
                 echo "<tr style='font-size:13px; color:#ffffff; background:#84a3b8;'>
                <td width='171' align='center'>$canc_terms3[0]      -     $canc_terms3[1]</td>
                <td width='171' align='center'>$canc_terms3[2]%</td>
                </tr>";   
                 }
                    }
                    echo "</table>";
                }
                 else{
                     echo 0;
                 }
 }
   
	//put your code here
 	function get_operator1()
 	{
		$sql=$this->db2->query("select travel_id,operator_title from registered_operators ");
        $data=array();                        
        foreach ($sql->result() as $rows)
        {
        	$data[$rows->travel_id]=$rows->operator_title;
        }
		return $data;
    }
 
 public function apiwise_report()
 {
 	$fdate = $this->input->post('fdate');
	$tdate = $this->input->post('tdate');
	$opid = $this->input->post('opid');
	
	echo '<table border="0" align="center">
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
  </tr>
  <tr>
    <td><input type="checkbox" id="selectck" name="selectck" onClick="SelectAll()"/></td>
    <td>&nbsp;</td>
    <td>API Agent </td>
    <td>&nbsp;</td>
    <td>From Date</td>
    <td>&nbsp;</td>
    <td>To Date </td>
    <td>&nbsp;</td>
    <td>Total Amount </td>
    <td>&nbsp;</td>
    <td>Commission</td>
    <td>&nbsp;</td>
    <td>Balance</td>
    <td>&nbsp;</td>
  </tr>';  
	
	$i = 0;
	$agent = mysql_query("select distinct id,name from agents_operator where operator_id='$opid' and agent_type='3'") or die(mysql_error());
	while($rows = mysql_fetch_array($agent))
	{
		$id = $rows['id'];
		$name = $rows['name'];
		
		$sql = mysql_query("select sum(tkt_fare) as tkt_fare,sum(save) as save,sum(paid) as paid from master_booking where operator_agent_type='3' and agent_id='$id' and travel_id='$opid' and jdate between '$fdate' and '$tdate' and status='confirmed'") or die(mysql_error());
		$row = mysql_fetch_array($sql);
			
		$tkt_fare1 = $row['tkt_fare'];
		$save1 = $row['save'];
		$paid1 = $row['paid'];
		$netfare1 = $tkt_fare1 - $paid1;			
			
		$sql1 = mysql_query("select sum(tkt_fare) as tkt_fare,sum(save) as save,sum(paid) as paid,sum(camt) as camt,sum(refamt) as refamt,status as paid from master_booking  where operator_agent_type='3' and travel_id='$opid' and agent_id='$id' and jdate between '$fdate' and '$tdate' and status='cancelled'") or die(mysql_error());
		$row1 = mysql_fetch_array($sql1);
		
		$tkt_fare2 = $row1['tkt_fare'];
		$save2 = $row1['save'];
		$paid2 = $row1['paid'];		
		$camt = $row1['camt'] / 2;
		$refamt = $row1['refamt'];			
		
		$tkt_fare = $tkt_fare1;
		$comm = $comm1 + $camt;
		$netfare2 = $tkt_fare -$comm;	
		$balance = $netfare1 - $netfare2;			
		
		echo '<tr>
    <td height="40"><input type="checkbox" class="chkbox" id="chk'.$i.'" name="chk" value="'.$i.'" onClick="enabledit(this.value)"/></td>
	<td height="40">&nbsp;</td>
    <td height="40">'.$name.'</td>
	<td height="40">&nbsp;</td>
    <td height="40">'.$fdate.'</td>
	<td height="40">&nbsp;</td>
    <td height="40">'.$tdate.'</td>
	<td height="40">&nbsp;</td>
    <td height="40">'.sprintf("%1.2f",$tkt_fare).'</td>
	<td height="40">&nbsp;</td>
    <td height="40">'.sprintf("%1.2f",$comm).'</td>
	<td height="40">&nbsp;</td>
    <td height="40">'.sprintf("%1.2f",$balance).'</td>
	<td height="40">&nbsp;</td>
  </tr>';
  		
		$i++;
	}
	echo '</table>';						
 }

}
?>