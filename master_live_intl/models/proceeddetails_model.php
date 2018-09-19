<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Proceeddetails_model extends CI_Model
{    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->database();
    }
                              
    function get_proceedDetails($limit,$page,$sedata)
    {
        if($sedata=='')
        {
            if($limit==0 && $page==0)
            {
              
		$query=$this->db->query("select * from master_proceed_details ORDER BY tim DESC")or die(mysql_error());
                return $query->num_rows();
            }
            else
            {
				//echo "ifelse";
                $query=$this->db->query("select * from master_proceed_details ORDER BY tim DESC limit $limit,$page ")or die(mysql_error());
                return $query;   
            }
        }
        else
        { 
            if($limit==0 && $page==0)
            {
                //echo "elseif";
				$query=$this->db->query("select * from master_proceed_details where ( pnr like '%$sedata%' ||  mobile like '%$sedata%') ORDER BY tim DESC")or die(mysql_error());
                return $query->num_rows();
            }
            else
            {
                //echo "elseelse";
				$query= $this->db->query("select * from  master_proceed_details where ( pnr like '%$sedata%' ||  mobile like '%$sedata%') ORDER BY tim DESC limit $limit,$page")or die(mysql_error());
                return $query;
            }
        }
    }
	
	function get_apiproceedDetails($limit,$page,$sedata)
    {
        if($sedata=='')
        {
            if($limit==0 && $page==0)
            {
              
		$query=$this->db->query("select * from seat_blocking_det ORDER BY blocked_time DESC")or die(mysql_error());
                return $query->num_rows();
            }
            else
            {
				//echo "ifelse";
                $query=$this->db->query("select * from seat_blocking_det ORDER BY blocked_time DESC limit $limit,$page ")or die(mysql_error());
                return $query;   
            }
        }
        else
        { 
            if($limit==0 && $page==0)
            {
                //echo "elseif";
				$query=$this->db->query("select * from seat_blocking_det where ( pnr like '%$sedata%' ||  agent_id like '%$sedata%') ORDER BY blocked_time DESC")or die(mysql_error());
                return $query->num_rows();
            }
            else
            {
                //echo "elseelse";
				$query= $this->db->query("select * from  seat_blocking_det where ( pnr like '%$sedata%' ||  agent_id like '%$sedata%') ORDER BY blocked_time DESC limit $limit,$page")or die(mysql_error());
                return $query;
            }
        }
    }
    
    function get_show_Passanger_proceedDetails()
    {
        $refno=$this->input->get('refno');
        //echo $refno;
        $query= $this->db->query("select * from  master_proceed_details where refno='$refno'")or die(mysql_error());
        return $query;
    }
	
	function get_show_Passanger_apiproceedDetails()
    {
        $pnr = $this->input->get('pnr');
        //echo $refno;
        $query= $this->db->query("select * from  seat_blocking_det where pnr='$pnr'")or die(mysql_error());
        return $query;
    }
}