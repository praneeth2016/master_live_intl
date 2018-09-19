<?php error_reporting(0); ?>


<link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />

<link rel="stylesheet" href="<?php echo base_url("css/table_ebs.css") ?>" type="text/css" />

<link href="<?php echo base_url('css/jquery-ui.css');?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url('js/jquery-1.10.2.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery-ui.js');?>"></script>

<script type="text/javascript" src="<?php echo base_url('js/onlinescript.js');?>"></script>

<script type="text/javascript">

$(function() 
{                                              
	$( "#fdate" ).datepicker({ dateFormat: 'yy-mm-dd',numberOfMonths: 1, showButtonPanel: false});
});

</script>

<script type="text/javascript">

function getservices() {

        var opid = $("#operators").val();

        $.post('getservice', {opid: opid}, function (res) {

            $('#service').html(res);
        });
    }
function getRoutes()
{
	$('#ress').html("");
	
	var opid = $("#operators").val();
	var service_num=$('#service').val();
    var service_name=$('#service option:selected').text();
	var city_id=$('#service_route').val();
    var service_route=$('#service_route option:selected').text();
	
    
	$('#hid').val('');

	if(service_num=="")
	{
		alert('select service number');

		return false;
	}
	if(city_id=="")
	{
		alert('select service route');

		return false;
	}
	else
	{
		$.post("getRoutes",{service_num:service_num,service_name:service_name,city_id:city_id,service_route:service_route,opid:opid},function(res)
		{
			//alert(res);
			
			$('#resp').html(res);
		});
    }//else
}//getRoutes()

function getroute()
{
	$('#route').html("");

	var opid = $("#operators").val();
	var service_num=$('#service').val();
    var service_name=$('#service option:selected').text();
	//alert(service_name);   	

	if(service_num == 0)
	{
		alert('select service number');

		return false;
	}
	else
	{
		$.post("getroute",{service_num:service_num,service_name:service_name,opid:opid},function(res)
		{
			//alert(res);
			
			$('#route').html(res);
		});
    }//else
}//getRoutes()

function updateFare()
{
	var bus_type = $("#bus_type").val();
	var service_num = $("#service_num").val();
	var travel_id = $("#operators").val();	
	var sfare = $("#sfare").val();
	var lfare = $("#lfare").val();
	var ufare = $("#ufare").val();
	var lower_rows = $("#lower_rows").val();
	var lower_cols = $("#lower_cols").val();
	var upper_rows = $("#upper_rows").val();
	var upper_cols = $("#upper_cols").val();
	var lower_seat_no = "";
	var upper_seat_no = "";
	var fdate = $("#fdate").val();
	var tdate = $("#tdate").val();
	var price_mode = $("#price_mode").val();
	
	var from_id = $("#from_id").val();
	var from_name = $("#from_name").val();
	var to_id = $("#to_id").val();
	var to_name = $("#to_name").val();
	var service_route2 = $("#service_route2").val();
	var city_id = $("#service_route").val();
	var seats_count = $("#seats_count").val();
	var max_rows = $("#max_rows").val();
	var max_cols = $("#max_cols").val();
	var double_berth = $("#double_berth").val();
	var single_berth = $("#single_berth").val();	
	var i = 1;
	var j = 1;
	//alert(lfare);
	
	
	var t=$.datepicker.formatDate('yy-mm-dd', new Date());
	
	if(price_mode =='')
	{
		alert("Please Select Fare Saving  Mode");
		$("#price_mode").focus();
		return false;
	}
	
	if(service_route2 == "")
	{
		alert("Please Select service route to update fare");
		$("#service_route2").focus();
		return false;
	}
	
	if(bus_type == "seater")
	{
		for(i = 1;i <= lower_cols;i++)
		{
			for(j = 1;j <= lower_rows;j++)
			{
				if(typeof $('#ltxt'+j+'-'+i).val() != "undefined")
				{
					if($('#sfare'+j+'-'+i).val() == "" || $('#sfare'+j+'-'+i).val() == 0)
					{
						lower_seat_no = "";
					}
					else if(sfare != $('#sfare'+j+'-'+i).val())
					{
						if(lower_seat_no == "")
						{
							lower_seat_no = $('#ltxt'+j+'-'+i).val() +"#"+ $('#sfare'+j+'-'+i).val();
						}
						else
						{
							lower_seat_no = lower_seat_no +'@'+ $('#ltxt'+j+'-'+i).val() +"#"+ $('#sfare'+j+'-'+i).val();
						}
					}				
				}
			}
		}	
	}
	if(bus_type == "sleeper" || bus_type == "seatersleeper")
	{		
		if(bus_type == "sleeper" && (seats_count >= 30 || seats_count <= 40))
		{
			if(double_berth == "")
			{
				alert("Please Provide Fare for Double Berth");
				$("#double_berth").focus();
				return false;
			}
			if(single_berth == "")
			{	
				alert("Please Provide Fare for Single Berth");
				$("#single_berth").focus();
				return false;
			}
			if(double_berth <= 0)
			{
				alert("Please Provide Fare greater than zero for Double Berth");
				$("#double_berth").focus();
				return false;
			}
			if(single_berth <= 0)
			{	
				alert("Please Provide Fare greater than zero for Single Berth");
				$("#single_berth").focus();
				return false;
			}
			if(double_berth % 1 != 0)
			{
				alert("Double Berth Fare should be an Integer");
				$("#double_berth").focus();
				return false;
			}
			if(single_berth % 1 != 0)
			{	
				alert("Single Berth Fare should be an Integer");
				$("#single_berth").focus();
				return false;
			}
			else
			{
				for(i = 1;i <= upper_cols;i++)
				{
					for(j = 1;j <= upper_rows;j++)
					{				
						if(typeof $('#utxt'+j+'-'+i).val() != "undefined")
						{						
							if(($('#double_berth').val() == "" || $('#double_berth').val() == 0) && ($('#single_berth').val() == "" || $('#single_berth').val() == 0))
							{
								upper_seat_no = "";
							}
							else
							{
								if(upper_seat_no == "")
								{
									if(max_cols != $('#lcol'+j+'-'+i).val())
									{
										upper_seat_no = $('#utxt'+j+'-'+i).val() +"#"+ $('#double_berth').val();
									}
									else
									{
										upper_seat_no = $('#utxt'+j+'-'+i).val() +"#"+ $('#single_berth').val();
									}	
								}
								else
								{
									if(max_cols != $('#lcol'+j+'-'+i).val())
									{
										upper_seat_no = upper_seat_no +'@'+ $('#utxt'+j+'-'+i).val() +"#"+ $('#double_berth').val();	
									}
									else
									{
										upper_seat_no = upper_seat_no +'@'+ $('#utxt'+j+'-'+i).val() +"#"+ $('#single_berth').val();	
									}	
								}							
							}					
						}	
					}
				}			
				//alert(upper_seat_no);
				
				for(i = 1;i <= lower_cols;i++)
				{
					for(j = 1;j <= lower_rows;j++)
					{
						if(typeof $('#ltxt'+j+'-'+i).val() != "undefined")
						{						
							if(($('#double_berth').val() == "" || $('#double_berth').val() == 0) && ($('#single_berth').val() == "" || $('#single_berth').val() == 0))
							{
								lower_seat_no = "";
							}
							else
							{													
								if(lower_seat_no == "")
								{
									if(max_cols != $('#lcol'+j+'-'+i).val())
									{
										lower_seat_no = $('#ltxt'+j+'-'+i).val() +"#"+ $('#double_berth').val();
									}
									else
									{
									lower_seat_no = $('#ltxt'+j+'-'+i).val() +"#"+ $('#single_berth').val();
									}	
								}
								else
								{
									if(max_cols != $('#lcol'+j+'-'+i).val())
									{
										lower_seat_no = lower_seat_no +'@'+ $('#ltxt'+j+'-'+i).val() +"#"+ $('#double_berth').val();
									}
									else
									{
										lower_seat_no = lower_seat_no +'@'+ $('#ltxt'+j+'-'+i).val() +"#"+ $('#single_berth').val();	
									}	
								}
							}					
						}
					}
				}	
				//alert(lower_seat_no);	
			}	
		}
		else
		{
			for(i = 1;i <= upper_cols;i++)
			{
				for(j = 1;j <= upper_rows;j++)
				{				
					if(typeof $('#utxt'+j+'-'+i).val() != "undefined")
					{
						//alert($('#utxt'+j+'-'+i).val());
						//alert($('#ufare'+j+'-'+i).val());
						if($('#ufare'+j+'-'+i).val() == "" || $('#ufare'+j+'-'+i).val() == 0)
						{
							upper_seat_no = "";
						}
						else if(ufare != $('#ufare'+j+'-'+i).val())
						{
							if(upper_seat_no == "")
							{
								upper_seat_no = $('#utxt'+j+'-'+i).val() +"#"+ $('#ufare'+j+'-'+i).val();
							}
							else
							{
								upper_seat_no = upper_seat_no +'@'+ $('#utxt'+j+'-'+i).val() +"#"+ $('#ufare'+j+'-'+i).val();
							}
						}					
					}	
				}
			}
			
			//alert(upper_seat_no);
			
			for(i = 1;i <= lower_cols;i++)
			{
				for(j = 1;j <= lower_rows;j++)
				{
					if(typeof $('#ltxt'+j+'-'+i).val() != "undefined")
					{
						//alert($('#ltxt'+j+'-'+i).val());
						//alert(lfare);
						//alert($('#lfare'+j+'-'+i).val());
						if($('#lfare'+j+'-'+i).val() == "" || $('#lfare'+j+'-'+i).val() == 0)
						{
							lower_seat_no = "";
						}
						else if(lfare != $('#lfare'+j+'-'+i).val())
						{						
							//alert("elseif");
							if(lower_seat_no == "")
							{
								lower_seat_no = $('#ltxt'+j+'-'+i).val() +"#"+ $('#lfare'+j+'-'+i).val();
							}
							else
							{
								lower_seat_no = lower_seat_no +'@'+ $('#ltxt'+j+'-'+i).val() +"#"+ $('#lfare'+j+'-'+i).val();
							}
						}					
					}
				}
			}
		}
		//alert(lower_seat_no);	
	}
	if(lower_seat_no != "" || upper_seat_no != "")
	{	
		if(fdate < t || tdate < t)
		{
			alert("Date shoud not less than today date");
		}
		else if(tdate < fdate)
		{
			alert("To date shoud not less than From date");
		}
	else
	{	
		var r = confirm("Are You Sure, change price "+price_mode+" for selected route");
		if(r == true)
		{
			//alert("if");
			$.post("<?php echo base_url('changedfare/addnewfare');?>",
			{
				bus_type:$("#bus_type").val(),
				service_num:$("#service_num").val(),
				travel_id:$("#operators").val(),
				sfare:$("#sfare").val(),
				lfare:$("#lfare").val(),
				ufare:$("#ufare").val(),
				lower_rows:$("#lower_rows").val(),
				lower_cols:$("#lower_cols").val(),
				upper_rows:$("#upper_rows").val(),
				upper_cols:$("#upper_cols").val(),
				lower_seat_no:lower_seat_no,
				upper_seat_no:upper_seat_no,
				fdate:fdate,
				tdate:tdate,
				price_mode:price_mode,
				from_id:from_id,
				from_name:from_name,
				to_id:to_id,
				to_name:to_name,
				service_route2:service_route2,
				city_id:city_id,
				seats_count:seats_count,
				max_rows:max_rows,
				max_cols:max_cols,
				double_berth:double_berth,
				single_berth:single_berth
			},function(res)
			{			
				//alert(res);
				if(res == 1)
				{
					alert("Fare Updated Successfully");
					window.location = "<?php echo base_url('changedfare/changefare');?>";
				}	
				else 
				{
					alert("Error");
				}		
			});
		}
	  }
	}
	else
	{
		alert("Base fare and Changed fare are equal,Please change Fare and Update");
		return false;
	}
}
</script>
<table width="73%" border="0" cellpadding="0" cellspacing="0" style="font-size:14px">

     <tr>

		<td height="40" colspan="4" style="padding-left:10px; border-bottom:#999999 solid 1px"><strong>Individual Seat Pricing</strong> </td>

      </tr>

      <tr>

        <td height="41" valign="top">
          <table width="100%" border="0" style="font-size:14px">
            <tr>
              <td height="30">&nbsp;</td>
              <td height="30" align="center" class="label"><span class="label" style="padding-left:15px">Select Operator :</span></td>
              <td height="30"><?php $op_id = 'id="operators" style="width:150px; font-size:12px" onchange="getservices();"';
                     echo form_dropdown('operators',$operators,"",$op_id);?></td>
              <td height="30">&nbsp;</td>
              <td height="30">&nbsp;</td>
              <td height="30" align="center">&nbsp;</td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td height="30" align="center" class="label">Service Name:</td>
              <td height="30"><select name="service" id="service" class="inputfield" style="width:150px;" onchange="getroute();">
                        <option value="0">---Select---</option>
              </select></td>
              <td height="30">Service Route</td>
              <td height="30" id="route">&nbsp;</td>
              <td height="30" align="center"><input  type="button" class="newsearchbtn" name="btn" id='btn' value="Submit" onclick="getRoutes()"/></td>
            </tr>
          </table></td>

      </tr>

      <tr>

        <td height="5" ><input type="hidden" name="hid" id='hid' value=''/>

            <input type='hidden' name='fromto' id='fromto' val=''/>

          <input type='hidden' name='sequence' id='sequence' val=''/>        </td>

      </tr>

      <tr>

        <td  align="center">&nbsp;</td>

      </tr>

      <tr>

        <td id="resp" align="center">&nbsp;</td>

      </tr>

                  <tr>

        <td id="ress" align="center">&nbsp;</td>

      </tr>

    </table>

