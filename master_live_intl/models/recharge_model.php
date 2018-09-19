<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Home controller class
 * This is only viewable to those members that are logged in
 */
 class Recharge_model extends CI_Model{
 		
	public function __construct()
	{
         parent::__construct();
         $this->load->helper('form');
         $this->load->helper('url');
         $this->load->helper('date');
	 $this->load->database();
        }
        function getListOfAgents($agent_title)
        { 
          $travel_id=$this->session->userdata('travel_id');
          $sql=mysql_query("select * from agents_operator where agent_type='$agent_title' and pay_type='prepaid'")or die(mysql_error());
          echo '<select name="agentname" id="agentname" style="width:145px"  onchange="getAgentVal()">
	            <option value="">--select--</option>';
	  while($res=mysql_fetch_array($sql))
	  {
	   $agname=$res['name'];
	   $agid=$res['id'];
	   echo '<option value="'.$agid.'">'.$agname.'</option>';	
	  }
	   echo '</select>';
	}
        function getAgentDetails($agentid)
        {
           
        $this->db->select('*');
        $array=array('id'=>$agentid);
        $this->db->where($array);
        $query= $this->db->get('agents_operator');
              
        foreach ($query->result() as $rows)
        {
          echo  $rows->uname."#".$rows->margin."#".$rows->balance."#".$rows->pay_type."#".$rows->name;
                   
        }
        }
        function updateAgentDetails($agtype,$agentid,$agname,$paymode,$paytype,$uname,$comm,$pbal,$tamt,$camt,$remarks)
        {
             $this->db->select('*');
        $array=array('id'=>$agentid);
        $this->db->where($array);
        $opdata= $this->db->get('agents_operator');
        foreach ($opdata->result() as $val){
            $travel_id=$val->operator_id;
        }
        $this->db->select('*');
        $array1=array('travel_id'=>$travel_id);
        $this->db->where($array1);
        $opdata= $this->db->get('registered_operators');
        foreach ($opdata->result() as $val)
            {
            $operator_title=$val->operator_title;
            }
            $ip=$this->input->ip_address();
            $tx=number_format(time()*1000,0,'','');
            $time=date('Y-m-d H:m:s');
            $date=date('Y-m-d');      
            if($paymode=='credit'){
             $comm_amt=$camt-$tamt;  
             $bal=$pbal+$camt; 
             $stat='topup';
            }else{
              $comm_amt=-($camt-$tamt);  
              $bal=$pbal-$camt; 
              $camt=-$camt;
              $tamt=-$tamt;
              $stat='subtraction';
            }
$data=array('Operator_Name'=>$operator_title,'travel_id'=>$travel_id,'agent_id'=>$agentid ,'agent_type'=>$agtype,
                'agent_name'=>$agname,'pay_mode'=>$paymode,'user_name'=>$uname,'bal_before_txn'=>$pbal,'net_amt'=>$tamt,
                'comm'=>$comm_amt ,'bal_after_txn'=>$bal,'top_up_amt'=>$camt ,'remarks'=>$remarks,'txn_id'=>$tx,'txn_date'=>$date,
                'date_time'=>$time,'ip'=>$ip);
            $query2=$this->db->insert('agents_topup',$data);
            $data1=array(
                'tktno'=>$tx,
                'transtype'=>$paymode,
                'comm'=>$comm_amt,
                'net_amt'=>$tamt,
                'topup_amt'=>$camt,
                'bal'=>$bal,
                'dat'=>$date,
                'ip'=>$ip,
                'agent_id'=>$agentid,
                'travel_id'=>$travel_id,
                'status'=>$stat,
                'remarks'=>$remarks,
                );
            $query3=$this->db->insert('master_pass_reports',$data1);
            
            //Updating agent balence
            $this->db->set('balance',$bal);
            $array3=array('id'=>$agentid,'name'=>$agname);
            $this->db->where($array3);
            $this->db->update('agents_operator');
            //$sql=  mysql_query("update agents_operator set  balance='$bal' where id='$agentid' and name='$agname' ")or die(mysql_error());
             if($query2 && $query3)
            {
                echo 1;
            }
           else {
                 echo 0;
             }
        }

 }
?>