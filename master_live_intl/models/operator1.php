<?php

class Operator1 extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db2 = $this->load->database('forum', TRUE);
    }

    public function opr_reg1() {
        include "connect.php";
        include('SMTPconfig.php');
        include('SMTPclass.php');
        $optitle = $_POST['optitle'];
        echo "$optitle";
        $uname = $_POST['uname'];
        $pwd = $_POST['pwd'];
        $firmtype = $_POST['firmtype'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $location = $_POST['location'];
        $contactno = $_POST['contactno'];
        $faxno = $_POST['faxno'];
        $emailid = $_POST['emailid'];
        $panno = $_POST['panno'];
        $bankname = $_POST['bankname'];
        $bankacno = $_POST['bankacno'];
        $branch = $_POST['branch'];
        $ifsccode = $_POST['ifsccode'];
        $package = $_POST['package'];

        date_default_timezone_set("Asia/Calcutta");
        $date = date('Y/m/d h:i:s a', time());
        $dt = explode(' ', $date);
        $dat = $dt[0];
        $time = $dt[1] . " " . $dt[2];

        $ip = $_SERVER['REMOTE_ADDR'];

        $sql = mysql_query("select max(id) as id  from registered_operators ") or die(mysql_error());
        $res = mysql_fetch_array($sql);
        $id = $res['id'];
        $travel_id = $id + 1;

        mysql_query("insert into registered_operators(operator_title,firm_type,name,address,location,contact_no,fax_no,email_id,pan_no,bank_name,bank_account_no,branch,ifsc_code,mode,status,travel_id,tim,date,ip,fwd,canc_terms,user_name,password,rid,package) values ('$optitle','$firmtype','$name','$address','$location','$contactno','$faxno','$emailid','$panno','$bankname','$bankacno','$branch','$ifsccode','','0','$travel_id','$time','$dat','$ip','','','$uname','$pwd','0','$package')") or die(mysql_error());

        $from = 'info@ticketengine.in';
        $to = $emailid;
        $subject = "Operator Registration Details";
        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="408" border="1" cellpadding="0" cellspacing="0" align="center" bgcolor="#CCCCCC">
  <tr>
    <td height="35" colspan="2" align="center"><b><font size="+1">Thank You for choosing Ticketengine.in</font></b></td>
  </tr>
  <tr>
    <td height="35" colspan="2" align="center"> Your Login Details </td>
  </tr>
  <tr>
    <td width="179" height="35">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;User Name : </td>
    <td width="229">' . $uname . '</td>
  </tr>
  <tr>
    <td height="35">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password : </td>
    <td>' . $pwd . '</td>
  </tr>
  <tr>
    <td height="35" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kindly contact us for other Details. </td>
  </tr>
</table>

</body>
</html>

';

        $SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $subject, $message);
        $SMTPChat = $SMTPMail->SendMail();

        if ($SMTPChat) {
            1;
        } else {
            echo 0;
        }
    }

    public function opr_reg1_db() {


        $optitle = $_POST['optitle']; //echo "$optitle";
        $uname = $_POST['uname'];
        $pwd = $_POST['pwd'];
        $firmtype = $_POST['firmtype'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $location = $_POST['location'];
        $contactno = $_POST['contactno'];
        $emailid = $_POST['emailid'];
        $panno = $_POST['panno'];
        $bankname = $_POST['bankname'];
        $bankacno = $_POST['bankacno'];
        $branch = $_POST['branch'];
        $ifsccode = $_POST['ifsccode'];
        $mode = $_POST['mode'];
        $status = $_POST['status']; //echo "$status";
        $travelid = $_POST['travelid'];
        $date = $_POST['date'];
        $ip = $_POST['ip'];
        $fbd = $_POST['fbd'];
        $cancleterms = $_POST['cancleterms'];
        $rid = $_POST['rid'];
        $Auname = $_POST['Auname'];
        $Apwd = $_POST['Apwd'];
        $acesstype = $_POST['acesstype'];
        $Acancleterms = $_POST['Acancleterms'];
        $billtype = $_POST['billtype'];
        $billamt = $_POST['billamt'];
        $senderid = $_POST['senderid'];
        $apisms = $_POST['apisms'];
        $othercantact = $_POST['othercantact'];
        $tktno = $_POST['tktno'];
        $opurl = $_POST['opurl'];
        $opmail = $_POST['opmail'];
        $livedate = $_POST['livedate'];
        $central_agent = $_POST['central_agent'];

        $sql = mysql_query("insert into registered_operators(operator_title,firm_type,name,address,location,contact_no,fax_no,email_id,pan_no,bank_name,bank_account_no,branch,ifsc_code,mode,status,travel_id,tim,date,ip,fwd,canc_terms,user_name,password,rid,admin_username,admin_password,access_type,bill_type,bill_amt,agent_canc_terms,sender_id,is_api_sms,other_contact,tkt_no,op_url,op_email,live_date,central_agent) values
	 ('$optitle','$firmtype','$name','$address','$location','$contactno','','$emailid','$panno','$bankname','$bankacno','$branch','$ifsccode','$mode','$status','$travelid','','$date','$ip','$fbd','$cancleterms','$uname','$pwd','$rid','$Auname','$Apwd','$acesstype','$billtype','$billamt','$Acancleterms','$senderid','$apisms','$othercantact','$tktno','$opurl','$opmail','$livedate','$central_agent')") or die(mysql_error());
        if ($sql) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function opr_regedit_db() {

        $uid = $_POST['uid']; //echo "$uid";
        $optitle = $_POST['optitle']; //echo "$optitle";
        $uname = $_POST['uname'];
        $pwd = $_POST['pwd'];
        $firmtype = $_POST['firmtype'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $location = $_POST['location'];
        $contactno = $_POST['contactno'];
        $emailid = $_POST['emailid'];
        $panno = $_POST['panno'];
        $bankname = $_POST['bankname'];
        $bankacno = $_POST['bankacno'];
        $branch = $_POST['branch'];
        $ifsccode = $_POST['ifsccode'];
        $mode = $_POST['mode'];
        $status = $_POST['status']; //echo "$status";
        $travelid = $_POST['travelid'];
        $date = $_POST['date'];
        $ip = $_POST['ip'];
        $fbd = $_POST['fbd'];
        $cancleterms = $_POST['cancleterms'];
        $rid = $_POST['rid'];
        $Auname = $_POST['Auname'];
        $Apwd = $_POST['Apwd'];
        $acesstype = $_POST['acesstype'];
        $Acancleterms = $_POST['Acancleterms'];
        $billtype = $_POST['billtype'];
        $billamt = $_POST['billamt'];
        $senderid = $_POST['senderid'];
        $apisms = $_POST['apisms'];
        $othercantact = $_POST['othercantact'];
        $tktno = $_POST['tktno'];
        $opurl = $_POST['opurl'];
        $opmail = $_POST['opmail'];
        $livedate = $_POST['livedate'];
        $central_agent = $_POST['central_agent'];
        $lts = $_POST['lts'];
		$sms_gateway = $_POST['sms_gateway'];

        $sql = mysql_query("UPDATE registered_operators SET operator_title = '$optitle',firm_type = '$firmtype',name = '$name',address = '$address',location = '$location',contact_no = '$contactno',fax_no = '',email_id = '$emailid',pan_no = '$panno',bank_name = '$bankname',bank_account_no = '$bankacno',branch = '$branch',ifsc_code = '$ifsccode',mode = '$mode',status = '$status',tim = '',date = '$date',ip = '$ip',fwd = '$fbd',canc_terms = '$cancleterms',user_name = '$uname',password = '$pwd',rid = '$rid', admin_username = '$Auname',admin_password = '$Apwd',access_type = '$acesstype',bill_type = '$billtype',bill_amt = '$billamt',agent_canc_terms = '$Acancleterms',sender_id = '$senderid',is_api_sms = '$apisms',other_contact = '$othercantact',tkt_no = '$tktno',op_url = '$opurl',op_email = '$opmail',live_date = '$livedate',central_agent = '$central_agent',lts='$lts',sms_gateway='$sms_gateway' WHERE id = '$uid'") or die(mysql_error());



        /* $sql = mysql_query("insert into registered_operators(operator_title,firm_type,name,address,location,contact_no,fax_no,email_id,pan_no,bank_name,bank_account_no,branch,ifsc_code,mode,status,travel_id,tim,date,ip,fwd,canc_terms,user_name,password,rid,admin_username,admin_password,access_type,bill_type,bill_amt,agent_canc_terms,sender_id,is_api_sms,other_contact,tkt_no,op_url,op_email,live_date,central_agent) values
          ('$optitle','$firmtype','$name','$address','$location','$contactno','','$emailid','$panno','$bankname','$bankacno','$branch','$ifsccode','$mode','$status','$travelid','','$date','$ip','$fbd','$cancleterms','$uname','$pwd','$rid','$Auname','$Apwd','$acesstype','$billtype','$billamt','$Acancleterms','$senderid','$apisms','$othercantact','$tktno','$opurl','$opmail','$livedate','$central_agent')") or die(mysql_error()) ; */

        if ($sql) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function chkuser_db() {
        $uname = $_POST['uname'];

        $sql = mysql_query("select * from registered_operators where user_name='$uname'") or die(mysql_error());
        $cnt = mysql_num_rows($sql);

        if ($cnt == 0) {
            echo "0";
        } else {
            echo "1";
        }
    }

    public function operators() {
        $query = $this->db->query("select distinct operator_title,travel_id from registered_operators where status='1'");
        $list = array();
        $list['0'] = '- - - Select - - -';
        foreach ($query->result() as $rows) {
            $list[$rows->travel_id] = $rows->operator_title;
        }
        return $list;
    }

    public function get_opr($opid) {
        $query = $this->db->query("select * from registered_operators where travel_id='$opid'");

        return $query->result();
    }

    public function bustype() {
        $query = $this->db->query("select distinct id,bus_type from buses_type");
        $list = array();
        $list['0'] = '- - - Select - - -';
        foreach ($query->result() as $rows) {
            $list[$rows->id] = $rows->bus_type;
        }
        return $list;
    }

    public function models_db() {
        $id = $this->input->post('id');

        $query = $this->db->query("select * from buses_model where s_type='$id'");

        if ($query->num_rows() > 0) {
            echo '<select name="model" id="model">
                <option value="0">select</option>';

            foreach ($query->result() as $rows) {
                echo'<option value="' . $rows->id . '">' . $rows->model . '</option>';
            }
            echo'</select>';
        } else {
            echo 0;
        }
    }

    public function seats_arrangement() {
        $query = $this->db->query("select distinct id,seat_arr from seats_arrangement");
        $list = array();
        $list['0'] = '- - - Select - - -';
        foreach ($query->result() as $rows) {
            $list[$rows->id] = $rows->seat_arr;
        }
        return $list;
    }

    public function getlayout_db() {
        //$operator = $this->input->post('operator');
        $bustype = $this->input->post('bustype');
        //$model = $this->input->post('model');
        //$seats = $this->input->post('seats');
        $rows = $this->input->post('rows');
        $cols = $this->input->post('cols');
        $lower_rows = $this->input->post('lower_rows');
        $lower_cols = $this->input->post('lower_cols');
        $upper_rows = $this->input->post('upper_rows');
        $upper_cols = $this->input->post('upper_cols');
        $grow = $this->input->post('grow');

        echo '<form method="post" id="Checkform">';
        if ($bustype == 1) {
            echo '<table border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td colspan="' . $lower_cols . '">Lower Deck</td>
                    </tr>  
                 ';
            for ($i = 1; $i <= $lower_rows; $i++) {
                echo '<tr>';
                for ($j = 1; $j <= $lower_cols; $j++) {
                    /*if ($i == $grow && $j != $lower_cols) {
                        echo '<td>&nbsp;</td>';
                    } else {*/
                        echo '<td><input onchange="document.getElementById(\'ltxt' . $i . '-' . $j . '\').disabled=!this.checked;" class="chkbox" type="checkbox" name="lchk' . $i . '-' . $j . '" id="lchk' . $i . '-' . $j . '" checked="checked"/><input type="text" name="ltxt' . $i . '-' . $j . '" id="ltxt' . $i . '-' . $j . '" value="" size="1"></td>';
                    //}
                }
                echo "</tr>";
            }
            echo "</table><br /> <br />";
            echo '<table border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td colspan="' . $upper_cols . '">Upper Deck</td>
                    </tr>  
                 ';
            for ($i = 1; $i <= $upper_rows; $i++) {
                echo '<tr>';
                for ($j = 1; $j <= $upper_cols; $j++) {
                   /* if ($i == $grow && $j != $upper_cols) {
                        echo '<td>&nbsp;</td>';
                    } else {*/
                        echo '<td><input onchange="document.getElementById(\'utxt' . $i . '-' . $j . '\').disabled=!this.checked;" class="chkbox" type="checkbox" name="uchk' . $i . '-' . $j . '" id="uchk' . $i . '-' . $j . '" checked="checked"/><input type="text" name="utxt' . $i . '-' . $j . '" id="utxt' . $i . '-' . $j . '" value="" size="1"></td>';
                   // }
                }
                echo "</tr>";
            }
            echo "</table>";
        } else if ($bustype == 2) {
            echo '<table border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td colspan="' . $cols . '">Lower Deck</td>
                    </tr>  
                 ';
            for ($i = 1; $i <= $rows; $i++) {
                echo '<tr>';
                for ($j = 1; $j <= $cols; $j++) {
                    /*if ($i == $grow && $j == $cols) {
                        echo '<td>&nbsp;</td>';
                    } else {*/
                        echo '<td><input onchange="document.getElementById(\'ltxt' . $i . '-' . $j . '\').disabled=!this.checked;" class="chkbox" type="checkbox" name="lchk' . $i . '-' . $j . '" id="lchk' . $i . '-' . $j . '" checked="checked"/><input type="text" name="ltxt' . $i . '-' . $j . '" id="ltxt' . $i . '-' . $j . '" value="" size="1"></td>';
                   // }
                }
                echo "</tr>";
            }
            echo "</table>";
        } else if ($bustype == 3) {
            echo '<table border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td colspan="' . $lower_cols . '">Lower Deck</td>
                    </tr>  
                 ';
            /* for($i = 1;$i <= $rows;$i++)
              {
              echo '<tr>';
              for($j = 1;$j <= $cols;$j++)
              {
              if($i == 3 && $j != $cols)
              {
              echo '<td>&nbsp;</td>';
              }
              else
              {
              echo '<td><input onchange="document.getElementById(\'ltxt'.$i.'-'.$j.'\').disabled=!this.checked;" class="chkbox" type="checkbox" name="lchk'.$i.'-'.$j.'" id="lchk'.$i.'-'.$j.'" checked="checked"/><input type="text" name="ltxt'.$i.'-'.$j.'" id="ltxt'.$i.'-'.$j.'" value="" size="1"></td>';
              }
              }
              echo "</tr>";
              }
              echo '<tr>
              <td colspan="'.$cols.'">
              <table border="0" cellspacing="1" cellpadding="1">'; */
            for ($k = 1; $k <= $lower_rows; $k++) {
                echo '<tr>';
                for ($l = 1; $l <= $lower_cols; $l++) {
                   /* if ($k == $grow && $l != $lower_cols) {
                        echo '<td>&nbsp;</td>';
                    } else {*/
                        echo '<td><input class="lchkbox" type="checkbox" name="slchk' . $k . '-' . $l . '" id="slchk' . $k . '-' . $l . '" value="L:s"/> S <input class="lchkbox" type="checkbox" name="blchk' . $k . '-' . $l . '" id="blchk' . $k . '-' . $l . '" value="L:b"/> B <br /><input onchange="document.getElementById(\'ltxt' . $k . '-' . $l . '\').disabled=!this.checked;" class="chkbox" type="checkbox" name="lchk' . $k . '-' . $l . '" id="lchk' . $k . '-' . $l . '" checked="checked"/><input type="text" name="ltxt' . $k . '-' . $l . '" id="ltxt' . $k . '-' . $l . '" value="" size="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
                    //}
                }
                //$i++;
                echo "</tr>";
            }
            echo "</table><!--/td></tr></table--><br /> <br />";
            echo '<table border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td colspan="' . $upper_cols . '">Upper Deck</td>
                    </tr>  
                 ';
            for ($i = 1; $i <= $upper_rows; $i++) {
                echo '<tr>';
                for ($j = 1; $j <= $upper_cols; $j++) {
                    /*if ($i == $grow && $j != $upper_cols) {
                        echo '<td>&nbsp;</td>';
                    } else {*/
                        echo '<td><input onchange="document.getElementById(\'utxt' . $i . '-' . $j . '\').disabled=!this.checked;" class="chkbox" type="checkbox" name="uchk' . $i . '-' . $j . '" id="uchk' . $i . '-' . $j . '" checked="checked"/><input type="text" name="utxt' . $i . '-' . $j . '" id="utxt' . $i . '-' . $j . '" value="" size="1"></td>';
                    //}
                }
                echo "</tr>";
            }
            echo "</table>";
        }
        echo '</form>';
        echo '<br /><input type="button" name="Save" id="save" value="Save Layout" onclick="return checkdata()" style="padding:5px 15px;" />';
    }

    public function insertlayout_db() {
        $operator = $this->input->post('operator');
        $bustype = $this->input->post('bustype');
        $model = $this->input->post('model');
        $seats = $this->input->post('seats');
        $rows = $this->input->post('rows');
        $cols = $this->input->post('cols');
        $lower_rows = $this->input->post('lower_rows');
        $lower_cols = $this->input->post('lower_cols');
        $upper_rows = $this->input->post('upper_rows');
        $upper_cols = $this->input->post('upper_cols');
        $chkcnt = $this->input->post('chkcnt');
        $lower_seat_no1 = $this->input->post('lower_seat_no');
        $lower_rowcols1 = $this->input->post('lower_rowcols');
        $upper_seat_no1 = $this->input->post('upper_seat_no');
        $upper_rowcols1 = $this->input->post('upper_rowcols');
        $lower_type1 = $this->input->post('lower_type');

        $lower_seat_no2 = explode('#', $lower_seat_no1);
        $lower_rowcols2 = explode('#', $lower_rowcols1);
        $upper_seat_no2 = explode('#', $upper_seat_no1);
        $upper_rowcols2 = explode('#', $upper_rowcols1);
        $lower_type2 = explode('#', $lower_type1);

        $sql = $this->db->query("select distinct bus_type from buses_type where id='$bustype'");
        foreach ($sql->result() as $row) {
            $bus_type = $row->bus_type;
        }

        $sql1 = $this->db->query("select distinct model from buses_model where id='$model'");
        foreach ($sql1->result() as $row1) {
            $model = $row1->model;
        }

        if ($bustype == 1) {
            for ($l = 0; $l < count($lower_seat_no2); $l++) {
                $lower_seat_no = $lower_seat_no2[$l];

                $lower_rowcols = explode('-', $lower_rowcols2[$l]);

                $lower_row = $lower_rowcols[0];
                $lower_col = $lower_rowcols[1];

                if ($lower_rows == 1 || $lower_rows == 2) {
                    $window = 1;
                } else if ($lower_rows == 4) {
                    if ($lower_row == 1 || $lower_row == 4) {
                        $window = 1;
                    } else {
                        $window = 0;
                    }
                } else if ($lower_rows == 5) {
                    if ($lower_row == 1 || $lower_row == 5) {
                        $window = 1;
                    } else {
                        $window = 0;
                    }
                }

                $seat_type = "L";
                $is_ladies = 0;
                $layout_id = $operator . "#" . $bus_type;

                //echo "lower_rows".$lower_rows." # window".$window;

                $sql2 = $this->db->query("insert into operator_layouts(travel_id,layout_id,seat_name,row,col,seat_type,window,is_ladies,status,model,seats) values('$operator','$layout_id','$lower_seat_no','$lower_row','$lower_col','$seat_type','$window','$is_ladies','1','$model','$seats')");
            }

            for ($u = 0; $u < count($upper_seat_no2); $u++) {
                $upper_seat_no = $upper_seat_no2[$u];

                $upper_rowcols = explode('-', $upper_rowcols2[$u]);

                $upper_row = $upper_rowcols[0];
                $upper_col = $upper_rowcols[1];

                if ($upper_rows == 1 || $upper_rows == 2) {
                    $window = 1;
                } else if ($upper_rows == 4) {
                    if ($upper_row == 1 || $upper_row == 4) {
                        $window = 1;
                    } else {
                        $window = 0;
                    }
                } else if ($upper_rows == 5) {
                    if ($upper_row == 1 || $upper_row == 5) {
                        $window = 1;
                    } else {
                        $window = 0;
                    }
                }

                $seat_type = "U";
                $is_ladies = 0;
                $layout_id = $operator . "#" . $bus_type;

                $sql3 = $this->db->query("insert into operator_layouts(travel_id,layout_id,seat_name,row,col,seat_type,window,is_ladies,status,model,seats) values('$operator','$layout_id','$upper_seat_no','$upper_row','$upper_col','$seat_type','$window','$is_ladies','1','$model','$seats')");
            }
        } else if ($bustype == 2) {
            for ($l = 0; $l < $chkcnt; $l++) {
                $lower_seat_no = $lower_seat_no2[$l];

                $lower_rowcols = explode('-', $lower_rowcols2[$l]);

                $lower_row = $lower_rowcols[0];
                $lower_col = $lower_rowcols[1];

                if ($rows == 1) {
                    $window = 1;
                }
                if ($rows == 2 || $rows == 3) {
                    if ($lower_row == 1) {
                        $window = 1;
                    } else {
                        $window = 0;
                    }
                } else if ($rows == 4) {
                    if ($lower_row == 1 || $lower_row == 4) {
                        $window = 1;
                    } else {
                        $window = 0;
                    }
                } else if ($rows == 5) {
                    if ($lower_row == 1 || $lower_row == 5) {
                        $window = 1;
                    } else {
                        $window = 0;
                    }
                } else {
                    $window = 0;
                }

                $seat_type = "s";
                $is_ladies = 0;
                $layout_id = $operator . "#" . $bus_type;

                $sql2 = $this->db->query("insert into operator_layouts(travel_id,layout_id,seat_name,row,col,seat_type,window,is_ladies,status,model,seats) values('$operator','$layout_id','$lower_seat_no','$lower_row','$lower_col','$seat_type','$window','$is_ladies','1','$model','$seats')");
            }
        } else if ($bustype == 3) {
            /* for($l = 0;$l < count($lower_seat_no2);$l++)
              {
              $lower_seat_no = $lower_seat_no2[$l];

              $lower_rowcols = explode('-', $lower_rowcols2[$l]);

              $lower_row = $lower_rowcols[0];
              $lower_col = $lower_rowcols[1];

              if($rows == 3)
              {
              if($lower_row == 1)
              {
              $window = 1;
              }
              else
              {
              $window = 0;
              }
              $seat_type = "s";
              }
              else if($lower_rows == 1)
              {
              $window = 1;
              }
              else if($lower_rows == 2)
              {
              if($lower_row == 5)
              {
              $window = 1;
              }
              else
              {
              $window = 0;
              }
              $seat_type = "L";
              }

              $is_ladies = 0;
              $layout_id = $operator."#".$bus_type;

              $sql2 = $this->db->query("insert into operator_layouts(travel_id,layout_id,seat_name,row,col,seat_type,window,is_ladies,status,model,seats) values('$operator','$layout_id','$lower_seat_no','$lower_row','$lower_col','$seat_type','$window','$is_ladies','1','$model','$seats')");
              } */

            for ($l = 0; $l < count($lower_seat_no2); $l++) {
                $lower_seat_no = $lower_seat_no2[$l];

                $lower_rowcols = explode('-', $lower_rowcols2[$l]);

                $lower_row = $lower_rowcols[0];
                $lower_col = $lower_rowcols[1];

                if ($lower_rows == 1 || $lower_rows == 2) {
                    $window = 1;
                } else if ($lower_rows == 4) {
                    if ($lower_row == 1 || $lower_row == 4) {
                        $window = 1;
                    } else {
                        $window = 0;
                    }
                } else if ($lower_rows == 5) {
                    if ($lower_row == 1 || $lower_row == 5) {
                        $window = 1;
                    } else {
                        $window = 0;
                    }
                }

                $seat_type = $lower_type2[$l];
                $is_ladies = 0;
                $layout_id = $operator . "#" . $bus_type;

                $sql3 = $this->db->query("insert into operator_layouts(travel_id,layout_id,seat_name,row,col,seat_type,window,is_ladies,status,model,seats) values('$operator','$layout_id','$lower_seat_no','$lower_row','$lower_col','$seat_type','$window','$is_ladies','1','$model','$seats')");
            }

            for ($u = 0; $u < count($upper_seat_no2); $u++) {
                $upper_seat_no = $upper_seat_no2[$u];

                $upper_rowcols = explode('-', $upper_rowcols2[$u]);

                $upper_row = $upper_rowcols[0];
                $upper_col = $upper_rowcols[1];

                if ($upper_rows == 1 || $upper_rows == 2) {
                    $window = 1;
                } else if ($upper_rows == 4) {
                    if ($upper_row == 1 || $upper_row == 4) {
                        $window = 1;
                    } else {
                        $window = 0;
                    }
                } else if ($upper_rows == 5) {
                    if ($upper_row == 1 || $upper_row == 5) {
                        $window = 1;
                    } else {
                        $window = 0;
                    }
                }

                $seat_type = "U";
                $is_ladies = 0;
                $layout_id = $operator . "#" . $bus_type;

                $sql3 = $this->db->query("insert into operator_layouts(travel_id,layout_id,seat_name,row,col,seat_type,window,is_ladies,status,model,seats) values('$operator','$layout_id','$upper_seat_no','$upper_row','$upper_col','$seat_type','$window','$is_ladies','1','$model','$seats')");
            }
        }
        if ($sql || $sql3) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function cities() {
        $query = $this->db->query("select distinct city_id,city_name from master_cities order by city_name");
        $list = array();
        $list['0'] = '- - - Select - - -';
        foreach ($query->result() as $rows) {
            $list[$rows->city_id] = $rows->city_name;
        }
        return $list;
    }

    public function board_drop_db1() {
        $city_id = $this->input->post('city_id');
        $city_name = $this->input->post('city_name');
        $board_drop = $this->input->post('board_drop');
        $board_drop_type = $this->input->post('board_drop_type');

        $sql = $this->db->query("select * from board_drop_points where board_drop='$board_drop' and board_or_drop_type='$board_drop_type' and city_id='$city_id'");
        if ($sql->num_rows <= 0) {
            $sql2 = $this->db->query("insert into board_drop_points(city_id,city_name,board_drop,board_or_drop_type) values('$city_id','$city_name','$board_drop','$board_drop_type')");

            if ($sql2) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 2;
        }
    }

    public function dashboard2() {
        $today = date('Y-m-d');

        $sql = mysql_query("select distinct travel_id,operator_title from registered_operators where status='1'") or die(mysql_error());

        echo'<table width="70%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" colspan="6" class="space" align="center">Dashboard</td>
    <td height="30">&nbsp;</td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" class="space">Operator</td>
    <td class="space">Branch</td>
    <td height="30" class="space">Agent</td>
    <td class="space" height="30">API</td>
    <td class="space">Website</td>
    <td class="space">Total</td>
    <td height="30">&nbsp;</td>
  </tr>';
        while ($row = mysql_fetch_array($sql)) {
            $travel_id = $row['travel_id'];
            $operator_title = $row['operator_title'];

            $sql2 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='1' and bdate='$today' and status='confirmed'") or die(mysql_error());
            $row2 = mysql_fetch_array($sql2);

            $sql3 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='2' and bdate='$today' and status='confirmed'") or die(mysql_error());
            $row3 = mysql_fetch_array($sql3);

            $sql4 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='3' and bdate='$today' and status='confirmed'") or die(mysql_error());
            $row4 = mysql_fetch_array($sql4);

            $sql5 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='4' and bdate='$today' and status='confirmed'") or die(mysql_error());
            $row5 = mysql_fetch_array($sql5);

            $sql6 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='1' and bdate='$today' and status='cancelled'") or die(mysql_error());
            $row6 = mysql_fetch_array($sql6);

            $sql7 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='2' and bdate='$today' and status='cancelled'") or die(mysql_error());
            $row7 = mysql_fetch_array($sql7);

            $sql8 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='3' and bdate='$today' and status='cancelled'") or die(mysql_error());
            $row8 = mysql_fetch_array($sql8);

            $sql9 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='4' and bdate='$today' and status='cancelled'") or die(mysql_error());
            $row9 = mysql_fetch_array($sql9);

            $branch = $row2['pass'] - $row6['pass'];
            $agent = $row3['pass'] - $row7['pass'];
            $api = $row4['pass'] - $row8['pass'];
            $website = $row5['pass'] - $row9['pass'];

            $total = $branch + $agent + $api + $website;
            echo'<tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="left" class="space">' . $operator_title . '</td>
    <td align="left" class="space"><span style="cursor:pointer; color:#CC0000" onClick="TicketReport(\'' . $travel_id . '\',1);">' . $branch . '</span></td>
    <td height="30" class="space"><span style="cursor:pointer; color:#CC0000" onClick="TicketReport(\'' . $travel_id . '\',2);">' . $agent . '</span></td>
    <td height="30" class="space"><span style="cursor:pointer; color:#CC0000" onClick="TicketReport(\'' . $travel_id . '\',3);">' . $api . '</span></td>
    <td class="space"><span style="cursor:pointer; color:#CC0000" onClick="TicketReport(\'' . $travel_id . '\',4);">' . $website . '</span></td>
    <td class="space">' . $total . '</td>
    <td height="30">&nbsp;</td>
  </tr>';
        }

        echo'<tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="left" class="space">&nbsp;</td>
    <td align="left" class="space">&nbsp;</td>
    <td height="30" align="center">&nbsp;</td>
    <td height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td height="30">&nbsp;</td>
  </tr>
</table>
';
    }

    public function month_booking2() {
        $today = date('Y-m');

        $sql = mysql_query("select distinct travel_id,operator_title from registered_operators where status='1'") or die(mysql_error());

        echo'<table width="70%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" colspan="6" class="space" align="center">Monthly Bookings</td>
    <td height="30">&nbsp;</td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" class="space">Operator</td>
    <td class="space">Branch</td>
    <td height="30" class="space">Agent</td>
    <td class="space" height="30">API</td>
    <td class="space">Website</td>
    <td class="space">Total</td>
    <td height="30">&nbsp;</td>
  </tr>';
        while ($row = mysql_fetch_array($sql)) {
            $travel_id = $row['travel_id'];
            $operator_title = $row['operator_title'];

            $sql2 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='1' and bdate like '%$today%' and status='confirmed'") or die(mysql_error());
            $row2 = mysql_fetch_array($sql2);

            $sql3 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='2' and bdate like '%$today%' and status='confirmed'") or die(mysql_error());
            $row3 = mysql_fetch_array($sql3);

            $sql4 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='3' and bdate like '%$today%' and status='confirmed'") or die(mysql_error());
            $row4 = mysql_fetch_array($sql4);

            $sql5 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='4' and bdate like '%$today%' and status='confirmed'") or die(mysql_error());
            $row5 = mysql_fetch_array($sql5);

            $sql6 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='1' and bdate like '%$today%' and status='cancelled'") or die(mysql_error());
            $row6 = mysql_fetch_array($sql6);

            $sql7 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='2' and bdate like '%$today%' and status='cancelled'") or die(mysql_error());
            $row7 = mysql_fetch_array($sql7);

            $sql8 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='3' and bdate like '%$today%' and status='cancelled'") or die(mysql_error());
            $row8 = mysql_fetch_array($sql8);

            $sql9 = mysql_query("select sum(pass) as pass from master_booking where travel_id='$travel_id' and operator_agent_type='4' and bdate like '%$today%' and status='cancelled'") or die(mysql_error());
            $row9 = mysql_fetch_array($sql9);

            $branch = $row2['pass'] - $row6['pass'];
            $agent = $row3['pass'] - $row7['pass'];
            $api = $row4['pass'] - $row8['pass'];
            $website = $row5['pass'] - $row9['pass'];

            $total = $branch + $agent + $api + $website;
            echo'<tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="left" class="space">' . $operator_title . '</td>
    <td align="left" class="space"><span style="cursor:pointer; color:#CC0000" onClick="TicketReport(\'' . $travel_id . '\',1);">' . $branch . '</span></td>
    <td height="30" class="space"><span style="cursor:pointer; color:#CC0000" onClick="TicketReport(\'' . $travel_id . '\',2);">' . $agent . '</span></td>
    <td height="30" class="space"><span style="cursor:pointer; color:#CC0000" onClick="TicketReport(\'' . $travel_id . '\',3);">' . $api . '</span></td>
    <td class="space"><span style="cursor:pointer; color:#CC0000" onClick="TicketReport(\'' . $travel_id . '\',4);">' . $website . '</span></td>
    <td class="space">' . $total . '</td>
    <td height="30">&nbsp;</td>
  </tr>';
            unset($branch);
            unset($agent);
            unset($api);
            unset($website);
        }

        echo'<tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="left" class="space">&nbsp;</td>
    <td align="left" class="space">&nbsp;</td>
    <td height="30" align="center">&nbsp;</td>
    <td height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td height="30">&nbsp;</td>
  </tr>
</table>
';
    }

    public function TicketReport1() {
        $today = date('Y-m-d');
        $travel_id = $this->input->get('travel_id');
        $operator_agent_type = $this->input->get('operator_agent_type');

        $query = mysql_query("select distinct operator_title from registered_operators where travel_id='$travel_id'") or die(mysql_error());
        $data = mysql_fetch_array($query);

        $operator_title = $data['operator_title'];

        echo'<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" colspan="7" class="space" align="left" style="background-color:#666666; color:#FFFFFF">Operator : ' . $operator_title . '</td>
    <td height="30">&nbsp;</td>
  </tr>';

        if ($operator_agent_type != 4) {
            $sql = mysql_query("select distinct agent_id from master_booking where travel_id='$travel_id' and operator_agent_type='$operator_agent_type'") or die(mysql_error());
//echo "select distinct agent_id from master_booking where travel_id='$travel_id' and operator_agent_type='$operator_agent_type'";
            if (mysql_num_rows($sql) > 0) {
                while ($row = mysql_fetch_array($sql)) {
                    $agent_id = $row['agent_id'];
//echo $agent_id;

                    $sql1 = mysql_query("select distinct name from agents_operator where operator_id='$travel_id' and id='$agent_id'") or die(mysql_error());
                    if (mysql_num_rows($sql1) > 0) {
                        $row1 = mysql_fetch_array($sql1);

                        $name = $row1['name'];
                        //echo $name;
                        $sql2 = mysql_query("select distinct tkt_no,pnr,service_no,source,dest,jdate,tkt_fare,status from master_booking where travel_id='$travel_id' and agent_id='$agent_id' and status='confirmed' and bdate='$today'") or die(mysql_error());
//echo "select distinct tkt_no,pnr,service_no,source,dest,jdate,tkt_fare,status from master_booking where travel_id='$travel_id' and agent_id='$agent_id' and status='confirmed' and bdate='$today'";
                        if (mysql_num_rows($sql2) > 0) {
                            echo '<tr>
    <td height="30">&nbsp;</td>
    <td height="30" colspan="7" class="space" align="left">Booked By  : ' . $name . ' </td>
    <td height="30">&nbsp;</td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" colspan="7" class="space" align="left">Status : Confirmed </td>
    <td height="30">&nbsp;</td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" class="space">Ticket No </td>
    <td class="space">PNR</td>
    <td height="30" class="space">Service No </td>
    <td class="space" height="30">Source</td>
    <td class="space">Destination</td>
    <td class="space">Journey Date</td>
    <td class="space">Fare</td>
    <td height="30">&nbsp;</td>
  </tr>';
                            while ($row2 = mysql_fetch_array($sql2)) {
                                $tkt_no = $row2['tkt_no'];
                                $pnr = $row2['pnr'];
                                $service_no = $row2['service_no'];
                                $source = $row2['source'];
                                $dest = $row2['dest'];
                                $jdate = $row2['jdate'];
                                $tkt_fare = $row2['tkt_fare'];
                                $status = $row2['status'];

                                echo'<tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="left" class="space">' . $tkt_no . '</td>
    <td align="left" class="space">' . $pnr . '</td>
    <td height="30" class="space">' . $service_no . '</td>
    <td height="30" class="space">' . $source . '</td>
    <td class="space">' . $dest . '</td>
    <td class="space">' . $jdate . '</td>
    <td class="space">' . $tkt_fare . '</td>
    <td height="30">&nbsp;</td>
  </tr>';
                            }
                            echo '<tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="left" class="space">&nbsp;</td>
    <td align="left" class="space">&nbsp;</td>
    <td height="30" align="center">&nbsp;</td>
    <td height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td height="30">&nbsp;</td>
  </tr>';
                        }
                        $sql3 = mysql_query("select distinct tkt_no,pnr,service_no,source,dest,jdate,tkt_fare,status from master_booking where travel_id='$travel_id' and agent_id='$agent_id' and status='cancelled' and jdate='$today'") or die(mysql_error());
                        if (mysql_num_rows($sql3) > 0) {
                            echo'<tr>
  <td height="30">&nbsp;</td>
  <td height="30" colspan="7" align="left" class="space">Status : Cancelled </td>
  <td height="30">&nbsp;</td>
</tr>
<tr>
    <td height="30">&nbsp;</td>
    <td height="30" class="space">Ticket No </td>
    <td class="space">PNR</td>
    <td height="30" class="space">Service No </td>
    <td class="space" height="30">Source</td>
    <td class="space">Destination</td>
    <td class="space">Journey Date</td>
    <td class="space">Fare</td>
    <td height="30">&nbsp;</td>
  </tr>';
                            while ($row3 = mysql_fetch_array($sql3)) {
                                $tkt_no = $row3['tkt_no'];
                                $pnr = $row3['pnr'];
                                $service_no = $row3['service_no'];
                                $source = $row3['source'];
                                $dest = $row3['dest'];
                                $jdate = $row3['jdate'];
                                $tkt_fare = $row3['tkt_fare'];
                                $status = $row3['status'];

                                echo'<tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="left" class="space">' . $tkt_no . '</td>
    <td align="left" class="space">' . $pnr . '</td>
    <td height="30" class="space">' . $service_no . '</td>
    <td height="30" class="space">' . $source . '</td>
    <td class="space">' . $dest . '</td>
    <td class="space">' . $jdate . '</td>
    <td class="space">' . $tkt_fare . '</td>
    <td height="30">&nbsp;</td>
  </tr>';
                            }
                            echo '<tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="left" class="space">&nbsp;</td>
    <td align="left" class="space">&nbsp;</td>
    <td height="30" align="center">&nbsp;</td>
    <td height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td height="30">&nbsp;</td>
  </tr>';
                        }
                    }
                }
            } else {
                echo "No Results Found";
            }
            //echo'</table>';		
        } else if ($operator_agent_type != "all") {
            echo '<tr>
    <td height="30">&nbsp;</td>
    <td height="30" colspan="7" class="space" align="left">Booked In  : Website </td>
    <td height="30">&nbsp;</td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" colspan="7" class="space" align="left">Status : Confirmed </td>
    <td height="30">&nbsp;</td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" class="space">Ticket No </td>
    <td class="space">PNR</td>
    <td height="30" class="space">Service No </td>
    <td class="space" height="30">Source</td>
    <td class="space">Destination</td>
    <td class="space">Journey Date</td>
    <td class="space">Fare</td>
    <td height="30">&nbsp;</td>
  </tr>';

            $sql2 = mysql_query("select distinct tkt_no,pnr,service_no,source,dest,jdate,tkt_fare,status from master_booking where travel_id='$travel_id' and status='confirmed' and bdate='$today' and operator_agent_type='$operator_agent_type'") or die(mysql_error());
            if (mysql_num_rows($sql2) > 0) {
                while ($row2 = mysql_fetch_array($sql2)) {
                    $tkt_no = $row2['tkt_no'];
                    $pnr = $row2['pnr'];
                    $service_no = $row2['service_no'];
                    $source = $row2['source'];
                    $dest = $row2['dest'];
                    $jdate = $row2['jdate'];
                    $tkt_fare = $row2['tkt_fare'];
                    $status = $row2['status'];

                    echo'<tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="left" class="space">' . $tkt_no . '</td>
    <td align="left" class="space">' . $pnr . '</td>
    <td height="30" class="space">' . $service_no . '</td>
    <td height="30" class="space">' . $source . '</td>
    <td class="space">' . $dest . '</td>
    <td class="space">' . $jdate . '</td>
    <td class="space">' . $tkt_fare . '</td>
    <td height="30">&nbsp;</td>
  </tr>';
                }
                echo '<tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="left" class="space">&nbsp;</td>
    <td align="left" class="space">&nbsp;</td>
    <td height="30" align="center">&nbsp;</td>
    <td height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td height="30">&nbsp;</td>
  </tr>';
            }
            $sql3 = mysql_query("select distinct tkt_no,pnr,service_no,source,dest,jdate,tkt_fare,status from master_booking where travel_id='$travel_id' and status='cancelled' and jdate='$today' and operator_agent_type='$operator_agent_type'") or die(mysql_error());
            if (mysql_num_rows($sql3) > 0) {
                echo'<tr>
  <td height="30">&nbsp;</td>
  <td height="30" colspan="7" align="left" class="space">Status : Cancelled </td>
  <td height="30">&nbsp;</td>
</tr>
<tr>
    <td height="30">&nbsp;</td>
    <td height="30" class="space">Ticket No </td>
    <td class="space">PNR</td>
    <td height="30" class="space">Service No </td>
    <td class="space" height="30">Source</td>
    <td class="space">Destination</td>
    <td class="space">Journey Date</td>
    <td class="space">Fare</td>
    <td height="30">&nbsp;</td>
  </tr>';
                while ($row3 = mysql_fetch_array($sql3)) {
                    $tkt_no = $row3['tkt_no'];
                    $pnr = $row3['pnr'];
                    $service_no = $row3['service_no'];
                    $source = $row3['source'];
                    $dest = $row3['dest'];
                    $jdate = $row3['jdate'];
                    $tkt_fare = $row3['tkt_fare'];
                    $status = $row3['status'];

                    echo'<tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="left" class="space">' . $tkt_no . '</td>
    <td align="left" class="space">' . $pnr . '</td>
    <td height="30" class="space">' . $service_no . '</td>
    <td height="30" class="space">' . $source . '</td>
    <td class="space">' . $dest . '</td>
    <td class="space">' . $jdate . '</td>
    <td class="space">' . $tkt_fare . '</td>
    <td height="30">&nbsp;</td>
  </tr>';
                }
                echo '<tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="left" class="space">&nbsp;</td>
    <td align="left" class="space">&nbsp;</td>
    <td height="30" align="center">&nbsp;</td>
    <td height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td height="30">&nbsp;</td>
  </tr>';
            }
        }
        echo'</table>';
    }

    public function max_travelid() {
        $sql = mysql_query("select max(travel_id) as travel_id from registered_operators");
        $row = mysql_fetch_array($sql);

        return $row['travel_id'] + 1;
    }

    public function board_drop_list_cnt() {

        $query = $this->db2->query("SELECT count(*) as cnt FROM `board_drop_points`");
        foreach ($query->result() as $row) {
            $cnt = $row->cnt;
        }
        return $cnt;
    }

    public function board_drop_list_db($limit, $page) {

        $this->db2->limit($limit, $page);
        $this->db2->select('*');
        $query = $this->db2->get("board_drop_points");
        return $query->result();
    }

    public function board_drop_edit_db($id) {

        $this->db2->select('*');
        $this->db2->where('id', $id);
        $query = $this->db2->get("board_drop_points");
        return $query->result();
    }

    public function board_drop_edit_db1() {

        $id = $this->input->post('id');
        $city_id = $this->input->post('city_id');
        $city_name = $this->input->post('city_name');
        $board_drop = $this->input->post('board_drop');
        $board_drop_type = $this->input->post('board_drop_type');

        $sql2 = $this->db->query("update board_drop_points set city_id = '$city_id',city_name = '$city_name',board_drop = '$board_drop',board_or_drop_type = '$board_drop_type' where id = '$id'");

        if ($sql2) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function board_drop_delete_db($id) {

        $sql2 = $this->db->query("delete  from  board_drop_points  where id = '$id'");
    }

    public function getser_num($opid) {

        $key = $this->input->post('key');
        if ($key == "terms" || $key == "discount") {
            $sql2 = $this->db->query("select distinct service_num,service_name from  master_buses  where travel_id = '$opid' and status='1'");
        } else {
            $sql2 = $this->db->query("select distinct service_num,service_name from  master_buses  where travel_id = '$opid'");
        }
        echo '<select id="service_num" name="service_num" style="width:236px">
				<option value="all">All</option>';
        foreach ($sql2->result() as $row) {
            echo'<option value="' . $row->service_num . '">' . $row->service_name . '(' . $row->service_num . ')</option>';
        }
        echo'</select>';
    }

    public function getbplist1($opid, $service_num) {

        $sql2 = $this->db->query("select * from  boarding_points  where travel_id = '$opid' and service_num = '$service_num'");
        echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30">service_num</td>
    <td height="30">travel_id</td>
    <td height="30">city_id</td>
    <td height="30">city_name</td>
    <td height="30">board_or_drop_type</td>
    <td height="30">board_drop</td>
    <td height="30">board_time</td>
    <td height="30">bpdp_id</td>
    <td height="30">Actions</td>
  </tr>';
        foreach ($sql2->result() as $rows) {

            echo'<tr>
    <td height="30">' . $rows->service_num . '</td>
    <td height="30">' . $rows->travel_id . '</td>
    <td height="30">' . $rows->city_id . '</td>
    <td height="30">' . $rows->city_name . '</td>
    <td height="30">' . $rows->board_or_drop_type . '</td>
    <td height="30">' . $rows->board_drop . '</td>
    <td height="30">' . $rows->board_time . '</td>
    <td height="30">' . $rows->bpdp_id . '</td>
	<td height="30">' . anchor('operator/getbplist_edit?id=' . $rows->id, 'Update', '') . '' . anchor('operator/getbplist_delete?id=' . $rows->id, 'delete', '') . '</td>
    <td>&nbsp;</td>
  </tr>';
        }
        echo'</table>';
    }

    public function getbplist_delete_db($id) {

        $this->db2->query("delete  from  boarding_points  where id = '$id'");
    }

    public function get_board_edit($id) {

        $this->db2->select('*');
        $this->db2->where('id', $id);
        $query = $this->db2->get("boarding_points");
        return $query->result();
    }

    public function getbplist_edit_db1() {

        $id = $_POST['id'];
        //echo "$id";
        $is_van = $_POST['is_van'];
        $service_num = $_POST['ser_num'];
        $travel_id = $_POST['trav_id'];
        $city_id = $_POST['cty_id'];
        $city_name = $_POST['cty_nam'];
        $board_or_drop_type = $_POST['bdtyp'];
        $board_drop = $_POST['bodp'];
        $board_time = $_POST['bordtim'];
        $bpdp_id = $_POST['bpdp_id'];
        $contact = $_POST['contact'];
        $bus_no = $_POST['bus_no'];
        $timing = $_POST['timing'];

        $this->db2->query("update boarding_points set is_van = '$is_van',service_num = '$service_num',travel_id = '$travel_id',city_id = '$city_id',city_name = '$city_name',board_or_drop_type = '$board_or_drop_type',board_drop = '$board_drop',board_time = '$board_time',bpdp_id = '$bpdp_id',contact = '$contact',bus_no = '$bus_no',timing = '$timing'  where id = '$id'");
    }

    public function discount_db() {
        $travel_id = $this->input->post('opid');
        $discount_type = $this->input->post('discount_type');
        $discount_for = $this->input->post('discount_for');
        $service_num = $this->input->post('service_num');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $discount = $this->input->post('discount');
        $dtype = $this->input->post('dtype');

        //echo "discount ".$discount." / dtype".$dtype;

        if ($discount_type == "permanent") {
            if ($discount_for == "all") {
                if ($service_num == "all") {
                    mysql_query("delete from master_discount where travel_id='$travel_id'");

                    $sql = mysql_query("select distinct service_num from master_buses where travel_id='$travel_id' and status='1'") or die(mysql_error());
                    while ($res = mysql_fetch_array($sql)) {
                        $service_no = $res['service_num'];
                        $sql1 = mysql_query("insert into master_discount(service_num,travel_id,discount,discount_type,discount_for) values ('$service_no','$travel_id','$discount','$dtype','$discount_for')") or die(mysql_error());
                    }
                } else {
                    mysql_query("delete from master_discount where travel_id='$travel_id' and service_num='$service_num'");
                    $sql1 = mysql_query("insert into master_discount(service_num,travel_id,discount,discount_type,discount_for) values ('$service_num','$travel_id','$discount','$dtype','$discount_for')") or die(mysql_error());
                }
            } else if ($discount_for == "web") {
                if ($service_num == "all") {
                    mysql_query("delete from master_discount where travel_id='$travel_id'");

                    $sql = mysql_query("select distinct service_num from master_buses where travel_id='$travel_id' and status='1'") or die(mysql_error());
                    while ($res = mysql_fetch_array($sql)) {
                        $service_no = $res['service_num'];
                        $sql1 = mysql_query("insert into master_discount(service_num,travel_id,discount,discount_type,discount_for) values ('$service_no','$travel_id','$discount','$dtype','$discount_for')") or die(mysql_error());
                    }
                } else {
                    mysql_query("delete from master_discount where travel_id='$travel_id' and service_num='$service_num'");
                    $sql1 = mysql_query("insert into master_discount(service_num,travel_id,discount,discount_type,discount_for) values ('$service_num','$travel_id','$discount','$dtype','$discount_for')") or die(mysql_error());
                }
            } else if ($discount_for == "api") {
                if ($service_num == "all") {
                    mysql_query("delete from master_discount where travel_id='$travel_id'");

                    $sql = mysql_query("select distinct service_num from master_buses where travel_id='$travel_id' and status='1'") or die(mysql_error());
                    while ($res = mysql_fetch_array($sql)) {
                        $service_no = $res['service_num'];
                        $sql1 = mysql_query("insert into master_discount(service_num,travel_id,discount,discount_type,discount_for) values ('$service_no','$travel_id','$discount','$dtype','$discount_for')") or die(mysql_error());
                    }
                } else {
                    mysql_query("delete from master_discount where travel_id='$travel_id' and service_num='$service_num'");
                    $sql1 = mysql_query("insert into master_discount(service_num,travel_id,discount,discount_type,discount_for) values ('$service_num','$travel_id','$discount','$dtype','$discount_for')") or die(mysql_error());
                }
            }
        } else { //temp
            if ($discount_for == "all") {
                if ($service_num == "all") {
                    mysql_query("delete from master_discount where travel_id='$travel_id' and discount_date between '$from_date' and '$to_date'");
                    $sql = mysql_query("select distinct service_num from master_buses where travel_id='$travel_id' and status='1'") or die(mysql_error());
                    while ($res = mysql_fetch_array($sql)) {
                        $service_no = $res['service_num'];
                        $from_date1 = $from_date;
                        $to_date1 = $to_date;

                        while ($from_date1 <= $to_date1) {
                            $sql1 = mysql_query("insert into master_discount(service_num,travel_id,discount_date,discount,discount_type,discount_for) values ('$service_no','$travel_id','$from_date1','$discount','$dtype','$discount_for')") or die(mysql_error());

                            $date1 = strtotime("+1 day", strtotime($from_date1));
                            $from_date1 = date("Y-m-d", $date1);
                        }
                    }
                } else {
                    mysql_query("delete from master_discount where travel_id='$travel_id' and service_num='$service_num' and discount_date between '$from_date' and '$to_date'");
                    $from_date1 = $from_date;
                    $to_date1 = $to_date;

                    while ($from_date1 <= $to_date1) {
                        $sql1 = mysql_query("insert into master_discount(service_num,travel_id,discount_date,discount,discount_type,discount_for) values ('$service_num','$travel_id','$from_date1','$discount','$dtype','$discount_for')") or die(mysql_error());

                        $date1 = strtotime("+1 day", strtotime($from_date1));
                        $from_date1 = date("Y-m-d", $date1);
                    }
                }
            } else if ($discount_for == "web") {
                if ($service_num == "all") {
                    mysql_query("delete from master_discount where travel_id='$travel_id' and discount_date between '$from_date' and '$to_date'");
                    $sql = mysql_query("select distinct service_num from master_buses where travel_id='$travel_id' and status='1'") or die(mysql_error());
                    while ($res = mysql_fetch_array($sql)) {
                        $service_no = $res['service_num'];
                        $from_date1 = $from_date;
                        $to_date1 = $to_date;

                        while ($from_date1 <= $to_date1) {
                            $sql1 = mysql_query("insert into master_discount(service_num,travel_id,discount_date,discount,discount_type,discount_for) values ('$service_no','$travel_id','$from_date1','$discount','$dtype','$discount_for')") or die(mysql_error());

                            $date1 = strtotime("+1 day", strtotime($from_date1));
                            $from_date1 = date("Y-m-d", $date1);
                        }
                    }
                } else {
                    mysql_query("delete from master_discount where travel_id='$travel_id' and service_num='$service_num' and discount_date between '$from_date' and '$to_date'");
                    $from_date1 = $from_date;
                    $to_date1 = $to_date;

                    while ($from_date1 <= $to_date1) {
                        $sql1 = mysql_query("insert into master_discount(service_num,travel_id,discount_date,discount,discount_type,discount_for) values ('$service_num','$travel_id','$from_date1','$discount','$dtype','$discount_for')") or die(mysql_error());

                        $date1 = strtotime("+1 day", strtotime($from_date1));
                        $from_date1 = date("Y-m-d", $date1);
                    }
                }
            } else if ($discount_for == "api") {
                if ($service_num == "all") {
                    mysql_query("delete from master_discount where travel_id='$travel_id' and discount_date between '$from_date' and '$to_date'");
                    $sql = mysql_query("select distinct service_num from master_buses where travel_id='$travel_id' and status='1'") or die(mysql_error());
                    while ($res = mysql_fetch_array($sql)) {
                        $service_no = $res['service_num'];
                        $from_date1 = $from_date;
                        $to_date1 = $to_date;

                        while ($from_date1 <= $to_date1) {
                            $sql1 = mysql_query("insert into master_discount(service_num,travel_id,discount_date,discount,discount_type,discount_for) values ('$service_no','$travel_id','$from_date1','$discount','$dtype','$discount_for')") or die(mysql_error());

                            $date1 = strtotime("+1 day", strtotime($from_date1));
                            $from_date1 = date("Y-m-d", $date1);
                        }
                    }
                } else {
                    mysql_query("delete from master_discount where travel_id='$travel_id' and service_num='$service_num' and discount_date between '$from_date' and '$to_date'");
                    $from_date1 = $from_date;
                    $to_date1 = $to_date;

                    while ($from_date1 <= $to_date1) {
                        $sql1 = mysql_query("insert into master_discount(service_num,travel_id,discount_date,discount,discount_type,discount_for) values ('$service_num','$travel_id','$from_date1','$discount','$dtype','$discount_for')") or die(mysql_error());

                        $date1 = strtotime("+1 day", strtotime($from_date1));
                        $from_date1 = date("Y-m-d", $date1);
                    }
                }
            }
        }

        if ($sql1) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function get_conv() {

        $opid = $this->input->post('opid');
        //echo "$opid";
        $res = $this->db->query("select convenience_charge from registered_operators where travel_id='$opid'");
        foreach ($res->result() as $row) {
            echo $row->convenience_charge;
        }
    }

    public function conv_give_db() {
        $opid = $this->input->post('opid');
        $conv = $this->input->post('conv');
        $sql = mysql_query("update registered_operators set convenience_charge='$conv' where travel_id='$opid'");

        if ($sql) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function terms_add1() {
        $travel_id = $this->input->post('opid');
        $term_type = $this->input->post('term_type');
        $service_num = $this->input->post('service_num');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $terms = $this->input->post('terms');

        //echo "terms ".$terms." / dtype".$dtype;

        if ($term_type == "permanent") {
            if ($service_num == "all") {
                mysql_query("delete from master_terms where travel_id='$travel_id'");
                $sql = mysql_query("select distinct service_num from master_buses where travel_id='$travel_id' and status='1'") or die(mysql_error());
                while ($res = mysql_fetch_array($sql)) {
                    $service_no = $res['service_num'];
                    $sql1 = mysql_query("insert into master_terms(service_num,travel_id,canc_terms) values ('$service_no','$travel_id','$terms')") or die(mysql_error());
                }
                mysql_query("update registered_operators set canc_terms='$terms' where travel_id='$travel_id'");
            } else {
                mysql_query("delete from master_terms where travel_id='$travel_id' and service_num='$service_num'");
                $sql1 = mysql_query("insert into master_terms(service_num,travel_id,canc_terms) values ('$service_num','$travel_id','$terms')") or die(mysql_error());
            }
        } else { //temp
            if ($service_num == "all") {
                mysql_query("delete from master_terms where travel_id='$travel_id' and terms_date between '$from_date' and '$to_date'");
                $sql = mysql_query("select distinct service_num from master_buses where travel_id='$travel_id' and status='1'") or die(mysql_error());
                while ($res = mysql_fetch_array($sql)) {
                    $service_no = $res['service_num'];
                    $from_date1 = $from_date;
                    $to_date1 = $to_date;

                    while ($from_date1 <= $to_date1) {
                        $sql1 = mysql_query("insert into master_terms(service_num,travel_id,terms_date,canc_terms) values ('$service_no','$travel_id','$from_date1','$terms')") or die(mysql_error());

                        $date1 = strtotime("+1 day", strtotime($from_date1));
                        $from_date1 = date("Y-m-d", $date1);
                    }
                }
            } else {
                mysql_query("delete from master_terms where travel_id='$travel_id' and service_num='$service_num' and terms_date between '$from_date' and '$to_date'");

                $from_date1 = $from_date;
                $to_date1 = $to_date;

                while ($from_date1 <= $to_date1) {
                    $sql1 = mysql_query("insert into master_terms(service_num,travel_id,terms_date,canc_terms) values ('$service_num','$travel_id','$from_date1','$terms')") or die(mysql_error());

                    $date1 = strtotime("+1 day", strtotime($from_date1));
                    $from_date1 = date("Y-m-d", $date1);
                }
            }
        }

        /* if ($term_type == "permanent") {
          if ($service_num == "all") {
          $sql = mysql_query("select * from master_terms where travel_id='$travel_id'") or die(mysql_error());
          } else {
          $sql = mysql_query("select * from master_terms where travel_id='$travel_id' and service_num='$service_num'") or die(mysql_error());
          }
          } else { //temp
          if ($service_num == "all") {
          $sql = mysql_query("select * from master_terms where travel_id='$travel_id' and terms_date between '$from_date' and '$to_date' ") or die(mysql_error());
          } else {
          $sql = mysql_query("select * from master_terms where travel_id='$travel_id' and service_num='$service_num' and terms_date between '$from_date' and '$to_date'") or die(mysql_error());
          }
          }

          //echo mysql_num_rows($sql)."count<br/>";

          $sql1 = mysql_query("select distinct service_num from master_buses where travel_id='$travel_id' and status='1'") or die(mysql_error());

          //echo mysql_num_rows($sql1)."countt";

          if ($term_type == "permanent") {
          if ($service_num == "all") {
          if ((mysql_num_rows($sql) == mysql_num_rows($sql1))) {
          while ($res = mysql_fetch_array($sql1)) {
          $service_no = $res['service_num'];
          $sql2 = mysql_query("update master_terms set canc_terms='$terms' where travel_id='$travel_id' and service_num='$service_no'") or die(mysql_error());
          }
          } else {
          mysql_query("delete from master_terms where travel_id='$travel_id'");
          while ($res = mysql_fetch_array($sql1)) {
          $service_no = $res['service_num'];
          $sql2 = mysql_query("insert into master_terms(service_num,travel_id,canc_terms) values ('$service_no','$travel_id','$terms')") or die(mysql_error());
          }
          }
          } else {
          if (mysql_num_rows($sql) > 0) {
          $sql2 = mysql_query("update master_terms set canc_terms='$terms' where travel_id='$travel_id' and service_num='$service_num'") or die(mysql_error());
          } else {
          //mysql_query("delete from master_terms where travel_id='$travel_id' and service_num='$service_num'");
          $sql2 = mysql_query("insert into master_terms(service_num,travel_id,canc_terms) values ('$service_num','$travel_id','$terms')") or die(mysql_error());
          }
          }
          } else { //Temporary
          if ($service_num == "all") {
          if ((mysql_num_rows($sql) == mysql_num_rows($sql1))) {
          while ($res = mysql_fetch_array($sql1)) {
          $service_no = $res['service_num'];
          $sql2 = mysql_query("update master_terms set canc_terms='$terms' where travel_id='$travel_id' and service_num='$service_no' and terms_date between '$from_date' and '$to_date'") or die(mysql_error());
          }
          } else {
          mysql_query("delete from master_terms where travel_id='$travel_id' and terms_date between '$from_date' and '$to_date'");

          while ($res = mysql_fetch_array($sql1)) {
          $service_no = $res['service_num'];
          $from_date1 = $from_date;
          $to_date1 = $to_date;

          while ($from_date1 <= $to_date1) {
          $sql2 = mysql_query("insert into master_terms(service_num,travel_id,terms_date,canc_terms) values ('$service_no','$travel_id','$from_date1','$terms')") or die(mysql_error());

          $date1 = strtotime("+1 day", strtotime($from_date1));
          $from_date1 = date("Y-m-d", $date1);
          }
          }
          }
          } else {
          if (mysql_num_rows($sql) > 0 && (mysql_num_rows($sql) == mysql_num_rows($sql1))) {
          $sql2 = mysql_query("update master_terms set canc_terms='$terms' where travel_id='$travel_id' and service_num='$service_num' and terms_date between '$from_date' and '$to_date'") or die(mysql_error());
          } else {
          mysql_query("delete from master_terms where travel_id='$travel_id' and service_num='$service_num' and terms_date between '$from_date' and '$to_date'");

          $from_date1 = $from_date;
          $to_date1 = $to_date;

          while ($from_date1 <= $to_date1) {
          $sql2 = mysql_query("insert into master_terms(service_num,travel_id,terms_date,canc_terms) values ('$service_num','$travel_id','$from_date1','$terms')") or die(mysql_error());

          $date1 = strtotime("+1 day", strtotime($from_date1));
          $from_date1 = date("Y-m-d", $date1);
          }
          }
          }
          } */

        if ($sql1) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function urls() {

        $this->db2->select('*');
        $query = $this->db2->get("te_url");
        return $query->result();
    }

    public function url_routing_db() {

        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($status == 1) {
            $x = 0;
        } else if ($status == 0) {
            $x = 1;
        }

        $sql1 = mysql_query("update te_url set status='$x' where id='$id'");
        $sql2 = mysql_query("update te_url set status='$status' where id <>'$id'");

        if ($sql1 and $sql2) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function getpromo2() {
        $travel_id = $this->input->post('opid');
        $query = $this->db->query("select * from promocodes where travel_id='$travel_id'");
        echo "<table style='margin: 0px auto;' class='gridtable'  width='550'>
        <tr>
        <th>Promo code</th>
        <th>Value</th>
        <th>Value type</th>       
        <th>From Date</th>
        <th>To Date</th>
        <th>Option</th>
        </tr>";
        $i = 1;
        foreach ($query->result() as $row) {
            $uid = $row->id;
            echo "<tr>";
            echo "<td style='font-size:12px';>" . $row->promocode . "</td>";
            echo "<td style='font-size:12px';>" . $row->value . "</td>";
            echo "<td style='font-size:12px';>" . $row->value_type . "</td>";
            echo "<td style='font-size:12px;'>" . $row->from_date . "</td>";
            echo "<td style='font-size:12px;'>" . $row->to_date . "</td>";
            echo "<td>" . anchor('Operator/promocodes_update?id=' . $uid, 'Update', '') . "</td>";
            echo "</tr>";
            $i++;
        }
        echo "</table>";
    }

    public function promocodes_add1() {
        $travel_id = $this->input->post('opid');
        $promocode = $this->input->post('promocode');
        $promovalue = $this->input->post('promovalue');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $promovalue_type = $this->input->post('promovalue_type');
        $query = $this->db->query("insert into promocodes (travel_id,promocode,value,value_type,from_date,to_date) values ('$travel_id','$promocode','$promovalue','$promovalue_type','$from_date','$to_date')");
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function promocodes_update1($id) {
        $query = $this->db->query("select * from promocodes where id='$id'");
        return $query->result();
    }

    public function promocodes_update3() {
        $id = $this->input->post('id');
        $promocode = $this->input->post('promocode');
        $promovalue = $this->input->post('promovalue');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $promovalue_type = $this->input->post('promovalue_type');
        $query = $this->db->query("Update promocodes set promocode='$promocode',value='$promovalue',value_type='$promovalue_type',from_date='$from_date',to_date='$to_date' where id='$id'");
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }
    public function getser_num_vehi($opid) {
        
        $sql2 = $this->db->query("select distinct service_num,service_name from  master_buses  where travel_id = '$opid' and status='1'");
        echo '<select id="service_num" name="service_num" style="width:236px">
				<option value="0">---select---</option>';
        foreach ($sql2->result() as $row) {
            echo'<option value="' . $row->service_num . '">' . $row->service_name . '(' . $row->service_num . ')</option>';
        }
        echo'</select>';
    }
    public function update_vehicalasign2(){
        $travel_id = $this->input->post('opid');
        $service_num = $this->input->post('service_num');
        $set = $this->input->post('set');
        $cdate = date('Y-m-d');
        $sql = $this->db->query("update buses_list set vehicleassigned='no' where travel_id='$travel_id' and service_num='$service_num' and journey_date='$cdate'");
        if($sql){
           echo 1; 
        }else{
            echo 0;
        }
        
    }
	
	 public function getTermsConditions_model($travel_id) {
        $query = $this->db->query("select distinct terms_condition from operator_terms_conditions where operator_id='$travel_id'");
		foreach ($query->result() as $row) {  
		echo $row->terms_condition;
		}		
    }
	
	 public function saveTerms_model($travel_id,$terms) {
		 $i=0;
        $query = $this->db->query("select distinct terms_condition from operator_terms_conditions where operator_id='$travel_id'");
		foreach ($query->result() as $row) {  
		  $i=1;
		}		
		
		if($i==1)
		$sql = $this->db->query("update operator_terms_conditions set terms_condition='$terms' where operator_id='$travel_id' ");
        else if($i==0)
		$sql = $this->db->query("insert into operator_terms_conditions (operator_id,terms_condition) values('$travel_id','$terms') ");
        
		if($sql){
           echo 1; 
        }else{
            echo 0;
        }
		
    }

}

?>