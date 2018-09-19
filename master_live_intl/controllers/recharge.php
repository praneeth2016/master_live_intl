<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Home controller class
 * This is only viewable to those members that are logged in
 */
class Recharge extends CI_Controller{
   
    
    public function __construct()
	{	
     parent::__construct();
	 $this->load->helper('form');
         $this->load->helper('cookie');
         $this->load->helper('url');
         $this->load->model('recharge_model');
    }
    public function recharge_type()
    {
        if($this->session->userdata('logged_in')!=TRUE)
        {
          redirect(base_url());  
        }
        else
        {
          $this->load->view('header.php');
          $this->load->view('sidebar.php');
          $this->load->view('recharge_home_view.php');
        }
    }
    public function getagents()
    {
        $agent_title= $this->input->post('agent_title');
        $data=  $this->recharge_model->getListOfAgents($agent_title);
        echo $data;   
        
    }
    function agentDetails()
    {
        $agentid= $this->input->post('agid');
        $data=  $this->recharge_model->getAgentDetails($agentid);
        
        echo $data;
    }
    function update_AgentTopUp()
    {  
        //$travel_id=$this->session->userdata('travel_id');
        //$operator_name=$this->session->userdata('name');
        $agtype= $this->input->post('agtype');
        $agentid= $this->input->post('agentid');
        $agname= $this->input->post('agname');
        $paymode= $this->input->post('paymode');
        $paytype= $this->input->post('paytype');        
        $uname= $this->input->post('uname');
        $comm= $this->input->post('comm');
        $pbal= $this->input->post('pbal');
        $tamt= $this->input->post('tamt');
        $camt= $this->input->post('camt');
        $remarks= $this->input->post('remarks');
          
        $this->recharge_model->updateAgentDetails($agtype,$agentid,$agname,$paymode,$paytype,$uname,$comm,$pbal,$tamt,$camt,$remarks);
        //return $data;       
    }
}
?>
