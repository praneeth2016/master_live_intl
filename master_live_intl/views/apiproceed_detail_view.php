<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>operator</title>
        <script type ="text/javascript" src="<?php echo base_url(); ?>js/datepicker/jquery-1.7.2.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" media="screen" />
       <style>
            .bg {background-color:#ffffff;
                 font-family: Arial, Helvetica, sans-serif; font-size:12px;
            }
            .bg1 {background-color:#eff3f5;
                  font-family: Arial, Helvetica, sans-serif; font-size:12px;
            }

            .bg:hover {background-color:#cfeeff;
                       font-family: Arial, Helvetica, sans-serif; font-size:12px;
            }
            .bg1:hover {background-color:#cfeeff;
                        font-family: Arial, Helvetica, sans-serif; font-size:12px;
            }
            #fixed { table-layout:fixed; width:90px; word-break:break-all;
            }
        </style>

        <script>
            function searchData()
			{
            	var data1 = $('#search').val();
                var data=data1.trim();
                var cnt = $('#cnt').val();
                
				if (data == "")
				{
                    alert("enter search data");
                    $('#search').focus();
                    return false;
                }

                else
				{
                	// alert(cnt);
                    $.post('apiproceedDetail', {data: data, cnt: cnt}, function(res)
					{
                    	//alert(res);
                        $('#result').html(res);
                        $('#tbl').hide();
                        $('.pagination').hide();
                    });
                }
            }
           
        </script>
        <script>
            function apishowPassangerDetail(j)
			{
            	var pnr=$('#cnt'+j).val();
               	// alert(refno);
                window.open('<?php echo base_url();?>index.php/master_control/show_Passanger_apiproceedDetail?pnr='+pnr);
            }
        </script>
    </head>
</html>
<?php
echo '<table width="76%" border=""  >';
if ($data == '')
{
    echo ' <tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px; 
                       border-right:#f2f2f2 solid 1px; border-top:#f2f2f2 solid 1px; 
                       border-left:#f2f2f2 solid 1px;">
        <td>Search :<input type="text" id="search" name="search" style=""><input type="button" value="Search" onclick="searchData()" id="bt"></td></tr></table>';
}
if ($query1->num_rows() == 0)
{
	echo '<table border="0" id="tbl" align="center">
        <tr style="color:red; font-weight:bold; font-size:14px;" align="center">
        <td>No Records Found </td></table>';
}
else
{
	echo '<table width="76%"  id="tbl">
    <tr style="background-color:#c2c2c2; color:#000; font-weight:bold; font-size:14px;">
       <th>Booking / Blocking Time</th>
       <!--th>API Key</th-->
       <th>IP</th>
       <th>Service Num</th>
       <th>From - To</th>
       <th>Journey Date</th>
	   <th>Seats</th>
	   <th>PNR</th>
	   <th>Booked By</th>
       <th>Status</th>
        </tr>';
    
	if ($k == 0)
        $i = 1;
    else
        $i = $k;
   
    foreach ($query1->result() as $value)
	{
    	$this->load->database();
      	$pnr=$value->pnr;
		$agent_id=$value->agent_id;
        
		$sql = $this->db->query("select name from agents_operator where id='$agent_id'")or die(mysql_error());
		$row = $sql->row();
		$name = $row->name;
     	
    	$res= $this->db->query("select * from master_booking where pnr='$pnr'")or die(mysql_error());
       		
		if($res->num_rows() > 0)
		{
        	$rows = $res->row();
			$status=$rows->status; 
			$time = $rows->time;          
		}
		else
		{
			$status = "Blocked";
			$time = $value->blocked_time;
		}	
    	
		$class = ($i % 2 == 0) ? 'bg' : 'bg1';
        echo '<tr class="'.$class.'" id="fixed">
     
       <td height="30"> '.$time.'</td>
       <!--td> '.$value->api_key.'</td-->
       <td> '.$value->ip.'</td>
	   <td> '.$value->service_num.'</td>
	   <td> '. $value->from_name.' - '.$value->to_name.'</td>
	   <td> '. $value->journey_date.'</td>
	   <td> '. $value->seats.'</td>
       <td> 
       <a href="#" onClick="apishowPassangerDetail('.$i.')" style="color:blue;text-decoration:underline">'.$value->pnr.'</a></td>
       <input type="hidden" id="cnt'.$i.'" value="'.$pnr.'">
       <td>'. $name.'</td>       
       <td>'.$status.'</td>
    </tr>';
        //echo "<tr><td id='sh$i' colspan='10'></td></tr>";
        $i++;
    }

    echo "</table>";
    echo "<input type='hidden' id='cnt' value=$i>";
    echo "<span id='result'> </span>";
    echo "<div class='pagination' style='text-align:center'>";
    echo $links;
    echo '</div>';
}
?>