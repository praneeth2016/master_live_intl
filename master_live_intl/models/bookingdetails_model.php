<?php 

class Bookingdetails_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
                     
    public function get_bookingDetails($limit,$page,$sedata)
    {
        if($sedata=='')
        {
            if($limit==0 && $page==0)
            {
                $query=$this->db->query("select * from master_booking ORDER BY time DESC");
                return $query->num_rows();
            }
            else
            {
                $query=$this->db->query("select * from master_booking ORDER BY time DESC limit $limit,$page ");
                return $query;   
            }
        }
        else
        { 
            if($limit==0 && $page==0)
            {
                //echo $sedata;
                $query=$this->db->query("select * from master_booking where tkt_no like '%$sedata%' or pnr like '%$sedata%' or  pmobile like '%$sedata%' ORDER BY time DESC");
                return $query->num_rows();
            }
            else
            {
                $query= $this->db->query("select * from  master_booking where tkt_no like '%$sedata%' or pnr like '%$sedata%' or  pmobile like '%$sedata%' ORDER BY time DESC limit $limit,$page");
                     
                return $query;
            }
        }
    }
    
    public function get_show_Passanger_bookingDetails()
    {
        $refno=$this->input->get('refno');
        //echo $refno;
        $query= $this->db->query("select * from  master_booking where pnr='$refno'");
        return $query;
    }
}