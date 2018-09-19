<?php
class Refund_model extends CI_Model{
    
              public function __construct()
                 {
                  parent::__construct();
                  $this->db1 = $this->load->database('default', TRUE);
                  $this->db2 = $this->load->database('forum', TRUE);
}

function get_CancelDetails($limit,$page,$sedata){
    //echo "search".$sedata;
    if($sedata=='')
        {
            if($limit==0 && $page==0)
            {
              
		$query=$this->db->query("select * from master_booking where (status='Cancelled' || status='cancelled' || status='service cancelled') and is_refunded is NULL and  operator_agent_type='4' ORDER BY time DESC")or die(mysql_error());
                return $query->num_rows();
            }
            else
            {
				//echo "ifelse";
                $query=$this->db->query("select * from master_booking where (status='Cancelled' || status='cancelled' || status='service cancelled') and is_refunded is NULL and  operator_agent_type='4' ORDER BY time DESC limit $limit,$page ")or die(mysql_error());
                return $query;   
            }
        }
        else
        { 
            if($limit==0 && $page==0)
            {
                //echo "elseif";
				$query=$this->db->query("select * from master_booking where ( tkt_no like '%$sedata%' ||  pemail like '%$sedata% ||  pmobile like '%$sedata%') and (status='Cancelled' || status='cancelled' || status='service cancelled') and  operator_agent_type='4' ORDER BY time DESC")or die(mysql_error());
                return $query->num_rows();
            }
            else
            {
                //echo "elseelse";
				$query= $this->db->query("select * from  master_booking where ( tkt_no like '%$sedata%' ||  pemail like '%$sedata% ||  pmobile like '%$sedata%') and (status='Cancelled' || status='cancelled' || status='service cancelled') and  operator_agent_type='4' ORDER BY time DESC limit $limit,$page")or die(mysql_error());
                return $query;
            }
        }
    
   
}

function get_ServiceCancelDetails($limit,$page,$sedata){
    //echo "search".$sedata;
    if($sedata=='')
        {
            if($limit==0 && $page==0)
            {
              
		$query=$this->db->query("select * from master_booking where (status='service cancelled' || status='service cancelled' ) and (operator_agent_type='3' || operator_agent_type='3' || operator_agent_type='3') ORDER BY time DESC")or die(mysql_error());
                return $query->num_rows();
            }
            else
            {
				//echo "ifelse";
                $query=$this->db->query("select * from master_booking where (status='service cancelled' || status='service cancelled' ) and (operator_agent_type='3' || operator_agent_type='3' || operator_agent_type='3') ORDER BY time DESC limit $limit,$page ")or die(mysql_error());
                return $query;   
            }
        }
        else
        { 
            if($limit==0 && $page==0)
            {
                //echo "elseif";
				$query=$this->db->query("select * from master_booking where ( tkt_no like '%$sedata%' ||  pemail like '%$sedata% ||  pmobile like '%$sedata%') and (status='service cancelled' || status='service cancelled') and  (operator_agent_type='3' || operator_agent_type='3' || operator_agent_type='3') ORDER BY time DESC ")or die(mysql_error());
                return $query->num_rows();
            }
            else
            {
                //echo "elseelse";
				$query= $this->db->query("select * from  master_booking where ( tkt_no like '%$sedata%' ||  pemail like '%$sedata% ||  pmobile like '%$sedata%') and (status='service cancelled' || status='service cancelled') and (operator_agent_type='3' || operator_agent_type='3' || operator_agent_type='3') ORDER BY time DESC limit $limit,$page")or die(mysql_error());
                return $query;
            }
        }
    
   
}
function do_amountRefundupdate(){
       $ramt=$this->input->post('amt');
       $serno=$this->input->post('ser');
       $traid=$this->input->post('tra');
       $tkt_no=$this->input->post('ticket');
       $agid=$this->input->post('agid');
       $pnr=$this->input->post('pnr');
       //echo $ramt."#".$serno."#".$traid."#".$tkt_no."#".$agid."#".$pnr;
       $query=$this->db->query("select * from agents_operator where id='$agid'");
          foreach($query->result() as $rows){
              $pay_type= $rows->pay_type;
          }
         // echo "pay:".$pay_type;
      $ip=$this->input->ip_address();
        $refunddate=date("Y-m-d");
        $reftime=date("Y-m-d H:i:s");
        $query1=$this->db->query("select * from master_pass_reports where agent_id='$agid' and tktno='$tkt_no' and travel_id='$traid' and pnr='$pnr'");
        foreach($query1->result() as $rows){
              $tkt_num= $rows->tktno;
              $tktpnr= $rows->pnr;
              $pname= $rows->pass_name;
              $source= $rows->source;
              $dest= $rows->destination;
              $trans= $rows->transtype;
              $ticket_fare= $rows->tkt_fare;
              $comm= $rows->comm;
              $com_amt= $rows->comm_amt;
              $top_up= $rows->topup_amt;
              $bal= $rows->bal;
              $can_fare= $rows->can_fare;
              $txnid= $rows->txn_id;
              $namt= $rows->net_amt;
              $agent= $rows->agent_id;
              $trv= $rows->travel_id;
              $jdate= $rows->jdate;
              $book_pay_type= $rows->book_pay_type;
              $book_pay_agent= $rows->book_pay_agent;
              
        }
        
        if($pay_type=='prepaid'){
            
           $data = array(
               
                   'tktno'=> $tkt_num,
                   'pnr'=>$tktpnr,
                   'pass_name'=>$pname,
                   'source'=>$source,
                   'destination'=>$dest,
                   'transtype'=>$trans,
                   'tkt_fare'=> $ticket_fare,
                   'comm'=>$comm,
                   'date'=>$reftime,
                   'comm_amt'=>$com_amt,
                   'topup_amt'=>$top_up,
                   'bal'=>$bal+$ticket_fare,
                   'can_fare'=>$can_fare,
                   'txn_id'=>$txnid,
                   'refamt'=>$ticket_fare,
                   'dat'=>$refunddate,
                   'net_amt'=>$namt,
                   'ip'=>$ip,
                   'agent_id'=>$agent,
                   'travel_id'=>$trv,
                   'status'=>'cancelled',
                   'jdate'=>$jdate,
                   'is_refunded'=>1,
                   'book_pay_type'=>$book_pay_type,
                   'book_pay_agent'=>$book_pay_agent,
                 
               );
        
         }
          else if($pay_type=='postpaid'){
              
             $net=$ramt-$com_amt;
           $data = array(
                   'tktno'=> $tkt_num,
                   'pnr'=>$tktpnr,
                   'pass_name'=>$pname,
                   'source'=>$source,
                   'destination'=>$dest,
                   'transtype'=>$trans,
                   'tkt_fare'=> $ticket_fare,
                   'comm'=>$comm,
                   'date'=>$reftime,
                   'comm_amt'=>$com_amt,
                   'topup_amt'=>$top_up,
                   'bal'=>$bal+$net,
                   'can_fare'=>$can_fare,
                   'txn_id'=>$txnid,
                   'refamt'=>$net,
                   'dat'=>$refunddate,
                   'net_amt'=>$namt,
                   'ip'=>$ip,
                   'agent_id'=>$agent,
                   'travel_id'=>$trv,
                   'status'=>'cancelled',
                   'jdate'=>$jdate,
                   'is_refunded'=>1,
                   'book_pay_type'=>$book_pay_type,
                   'book_pay_agent'=>$book_pay_agent,
               );
          
          }
          
         $query11=$this->db->insert('master_pass_reports', $data); 
          
         $query2=$this->db->query("update master_booking set status='cancelled' where agent_id='$agid' and travel_id='$traid' and tkt_no='$tkt_no' and pnr='$pnr' and status='service cancelled'");
         
         
        
         

         if($query11 && $query2){
             echo 1;
         }
         else{
             echo 0;
         }
}

function do_Refundupdate(){
       $ramt=$this->input->post('amt');
       $serno=$this->input->post('ser');
       $traid=$this->input->post('tra');
       $tkt_no=$this->input->post('ticket');
       $agid=$this->input->post('agid');
       $pnr=$this->input->post('pnr');
       //echo $ramt."#".$serno."#".$traid."#".$tkt_no."#".$agid."#".$pnr;
       $query=$this->db->query("select * from agents_operator where id='$agid'");
          foreach($query->result() as $rows){
              $pay_type= $rows->pay_type;
          }
         // echo "pay:".$pay_type;
      $ip=$this->input->ip_address();
        $refunddate=date("Y-m-d");
        $reftime=date("Y-m-d H:i:s");
        $query1=$this->db->query("select * from master_pass_reports where agent_id='$agid' and tktno='$tkt_no' and travel_id='$traid' and pnr='$pnr'");
        foreach($query1->result() as $rows){
              $tkt_num= $rows->tktno;
              $tktpnr= $rows->pnr;
              $pname= $rows->pass_name;
              $source= $rows->source;
              $dest= $rows->destination;
              $trans= $rows->transtype;
              $ticket_fare= $rows->tkt_fare;
              $comm= $rows->comm;
              $com_amt= $rows->comm_amt;
              $top_up= $rows->topup_amt;
              $bal= $rows->bal;
              $can_fare= $rows->can_fare;
              $txnid= $rows->txn_id;
              $namt= $rows->net_amt;
              $agent= $rows->agent_id;
              $trv= $rows->travel_id;
              $jdate= $rows->jdate;
              $book_pay_type= $rows->book_pay_type;
              $book_pay_agent= $rows->book_pay_agent;
              
        }
        
        if($pay_type=='prepaid'){
            
           $data = array(
               
                   'tktno'=> $tkt_num,
                   'pnr'=>$tktpnr,
                   'pass_name'=>$pname,
                   'source'=>$source,
                   'destination'=>$dest,
                   'transtype'=>$trans,
                   'tkt_fare'=> $ticket_fare,
                   'comm'=>$comm,
                   'date'=>$reftime,
                   'comm_amt'=>$com_amt,
                   'topup_amt'=>$top_up,
                   'bal'=>$bal+$ticket_fare,
                   'can_fare'=>$can_fare,
                   'txn_id'=>$txnid,
                   'refamt'=>$ticket_fare,
                   'dat'=>$refunddate,
                   'net_amt'=>$namt,
                   'ip'=>$ip,
                   'agent_id'=>$agent,
                   'travel_id'=>$trv,
                   'status'=>'cancelled',
                   'jdate'=>$jdate,
                   'is_refunded'=>1,
                   'book_pay_type'=>$book_pay_type,
                   'book_pay_agent'=>$book_pay_agent,
                 
               );
        
         }
          else if($pay_type=='postpaid'){
              
             $net=$ramt-$com_amt;
           $data = array(
                   'tktno'=> $tkt_num,
                   'pnr'=>$tktpnr,
                   'pass_name'=>$pname,
                   'source'=>$source,
                   'destination'=>$dest,
                   'transtype'=>$trans,
                   'tkt_fare'=> $ticket_fare,
                   'comm'=>$comm,
                   'date'=>$reftime,
                   'comm_amt'=>$com_amt,
                   'topup_amt'=>$top_up,
                   'bal'=>$bal+$net,
                   'can_fare'=>$can_fare,
                   'txn_id'=>$txnid,
                   'refamt'=>$net,
                   'dat'=>$refunddate,
                   'net_amt'=>$namt,
                   'ip'=>$ip,
                   'agent_id'=>$agent,
                   'travel_id'=>$trv,
                   'status'=>'cancelled',
                   'jdate'=>$jdate,
                   'is_refunded'=>1,
                   'book_pay_type'=>$book_pay_type,
                   'book_pay_agent'=>$book_pay_agent,
               );
          
          }
          
         $query11=$this->db->insert('master_pass_reports', $data); 
          
         $query2=$this->db->query("update master_booking set status='cancelled' where agent_id='$agid' and travel_id='$traid' and tkt_no='$tkt_no' and pnr='$pnr' and status='service cancelled'");
         
         
         $sql1=$this->db->query("select * from master_pass_reports where agent_id='$agid' and travel_id='$traid' and tktno='$tkt_no' and pnr='$pnr'and status='cancelled'");
         foreach($sql1->result() as $row){
         $blnc=$row->bal;
             
         }
         //echo $blnc;
         $query3=$this->db->query("update agents_operator set balance='$blnc' where id='$agid' and operator_id='$traid'") or die(mysql_error());
         
         

         if($query11 && $query2 && $query3){
             echo 1;
         }
         else{
             echo 0;
         }
         
}

function show_RefundForm_data(){
      $j=$this->input->post('j');
        echo "<table align='center' style='font-size:12px'><tr>
            <td>Refund Amount:</td><td><input type='text' id='amt$j' name='amt$j'></td></tr>
            <tr align='center'>
            <td >Remarks:</td><td><textarea id='rem$j' name='rem$j' size='20px' ></textarea></td></tr>
            <tr align='center'>
            <td colspan='2'><input type='button' value='Submit' onclick='doRefund($j)'></td></tr></table>";
    }
    
function show_ser_RefundForm_data(){
      $j=$this->input->post('j');
      $paid=$this->input->post('paid');
      $charge=$this->input->post('ccharge');
      $camt=$this->input->post('camt');
      $refamt=$this->input->post('refamt');
      
      echo "<table align='center' style='font-size:12px' width='80%'><tr>
            <th width='28px'>Type</th>
            <th width='28px'>Paid</th>
            <th width='28px'>Cancellation Charge</th>
            <th width='28px'>Cancelled amt</th>
            <th width='28px'>Refund</th>
            </tr>
            <tr>
            <td width='28px' align='center'></td>
            <td width='28px' align='center'>$paid</td>
            <td width='28px' align='center'>$charge</td>
            <td width='28px' align='center'>$camt</td>
            <td width='28px' align='center'>$refamt <input type='hidden' id='amtx$j' name='amtx$j' value='$refamt'/></td>
            
            </tr>
            <tr>
            <td height='15px'>&nbsp;</th>
            <td >&nbsp;</th>
            <td >&nbsp;</th>
            
            </tr>
            <tr align='center'>
            <td colspan='6'><input type='button' value='Submit' onclick='doServiceRefund($j)'></td></tr></table>";
    }
       }
?>