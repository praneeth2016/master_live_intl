<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Home controller class
 * This is only viewable to those members that are logged in
 */
 class Login_model extends CI_Model{
     
     function login($email,$password)
    {
        $this->db->where("user_name",$email);
        $this->db->where("password",$password);
            
        $query=$this->db->get("registered_operators");
        if($query->num_rows()>0)
        {
         	foreach($query->result() as $rows)
            {
            	//add all data to session
                $newdata = array(
                	'user_id'    => $rows->id,
                    	'user_name'  => $rows->user_name,
		        'email_id'   => $rows->email_id,
                        'password'   => $rows->password,
                        'operator_title'   => $rows->operator_title,
                        'firm_type'   => $rows->firm_type,
                        'name'   => $rows->name,
                        'address'   => $rows->address,
                        'location'   => $rows->location,
                        'contact_no'   => $rows->contact_no,
                        'fax_no'   => $rows->fax_no,
                        'pan_no'   => $rows->pan_no,
                        'bank_name'   => $rows->bank_name,
                        'bank_account_no'   => $rows->bank_account_no,
                        'branch'   => $rows->branch,
                        'ifsc_code'   => $rows->ifsc_code,
                        'fwd'  =>  $rows->fwd,
	                'logged_in' 	=> TRUE,
                   );
			}
            	$this->session->set_userdata($newdata);
                return true;            
		}
		return false;
    }
 
 
 function edit_user($operator_title,$firm_type,$name,$address,$location,$contact_no,
                           $fax_no,$email,$pan_no,$bank_name,$bank_account_no,$branch,$ifsc_code)
 {
         $this->load->database();
         $user_id=  $this->session->userdata('user_id');
         $query=  $this->db->query("UPDATE registered_operators SET operator_title='$operator_title',firm_type='$firm_type',name='$name',address='$address',location='$location',contact_no='$contact_no',
                           fax_no='$fax_no',email_id='$email',pan_no='$pan_no',bank_name='$bank_name',bank_account_no='$bank_account_no',branch='$branch',ifsc_code='$ifsc_code' WHERE id='$user_id'");
                  if($query)
                  {
                      $this->session->set_userdata('operator_title',$operator_title);
                      $this->session->set_userdata('firm_type',$firm_type);
                      $this->session->set_userdata('name',$name);
                      $this->session->set_userdata('address',$address);
                      $this->session->set_userdata('location',$location);
                      $this->session->set_userdata('contact_no',$contact_no);
                      $this->session->set_userdata('fax_no',$fax_no);
                      $this->session->set_userdata('email_id',$email);
                      $this->session->set_userdata('pan_no',$pan_no);
                      $this->session->set_userdata('bank_name',$bank_name);
                      $this->session->set_userdata('bank_account_no',$bank_account_no);
                      $this->session->set_userdata('branch',$branch);
                      $this->session->set_userdata('ifsc_code',$ifsc_code);
                    return 0;  
                  }
        
     else {
        return 1; 
     }
         
    
 }
  function update_pass($password)
 {
         $this->load->database();
         $user_id=  $this->session->userdata('user_id');
         $query=  $this->db->query("UPDATE registered_operators SET  password='$password' WHERE id='$user_id'");
                  if($query)
                  {
                      $this->session->set_userdata('password',$password);
                    return 0;  
                  }
        
     else {
        return 1; 
     }
         
    
 }
   function fwd_day($fwd)
 {
         $this->load->database();
         $user_id=  $this->session->userdata('user_id');
         $query=  $this->db->query("UPDATE registered_operators SET  fwd='$fwd' WHERE id='$user_id'");
                  if($query)
                  {
                      $this->session->set_userdata('fwd',$fwd);
                    return 0;  
                  }
        
     else {
        return 1; 
     }
         
    
 }
 }
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>