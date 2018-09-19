<style type="text/css">
.space
{
	padding-left:10px;
	font-size:14px;
}	
</style>
<script type="text/javascript">
$("#document").ready(function()
{
	$("#bustype").change(function()
	{
		var bustype = $("#bustype").val();			
		
		if(bustype == 1)//sleeper
		{			
			$("#ld_rows").show();
			$("#ld_cols").show();
			$("#ud_rows").show();
			$("#ud_cols").show();
			$("#ros").hide();
			$("#cos").hide();
		}
		if(bustype == 2)//seater
		{			
			$("#ld_rows").hide();
			$("#ld_cols").hide();
			$("#ud_rows").hide();
			$("#ud_cols").hide();
			$("#ros").show();
			$("#cos").show();
		}
		if(bustype == 3)//seater/sleeper
		{			
			$("#ld_rows").show();
			$("#ld_cols").show();
			$("#ud_rows").show();
			$("#ud_cols").show();
			$("#ros").hide();
			$("#cos").hide();
		}
						
		$.post("<?php echo base_url('index.php/operator/models');?>",{id:bustype},function(res)
		{									
			if(res != 0)
			{
				$("#mode").show();
				$("#mod").html(res);
			}
			else
			{
				$("#mode").hide();
				$("#mod").html('');								
			}	
		});		
	});
});

/*$("#document").ready(function()
{	
	$("#seats_arrangement").change(function()
	{
		var bustype = $("#bustype").val();
		var seats_arrangement = $("#seats_arrangement").val();				
		
		if(bustype == 1 && seats_arrangement == 1)
		{						
			$("#ld_rows").show();
			$("#ld_cols").show();
			$("#ud_rows").show();
			$("#ud_cols").show();
		}		
		else
		{			
			$("#ld").show();
			$("#ud").show();
		}
	});
});*/
</script>
<script type="text/javascript">
function validate()
{
	var operator = $("#operator").val();
	var bustype = $("#bustype").val();
	var model = $("#model").val();
	//var seats_arrangement = $("#seats_arrangement").val();
	var seats = $("#seats").val();
	var rows = $("#rows").val();
	var cols = $("#cols").val();
	var lower_rows = $("#lower_rows").val();
	var lower_cols = $("#lower_cols").val();
	var upper_rows = $("#upper_rows").val();
	var upper_cols = $("#upper_cols").val();
	var grow = $("#grow").val();
	
	if(operator == 0)
	{
		alert("Please Select Operator");
		$("#operator").focus();
		return false;
	}
	if(bustype == 0)
	{
		alert("Please Select Bus Type");
		$("#bustype").focus();
		return false;
	}
	if(model == 0)
	{
		alert("Please Select Model");
		$("#model").focus();
		return false;
	}
	if(seats_arrangement == 0)
	{
		alert("Please Select Seat Type");
		$("#seats_arrangement").focus();
		return false;
	}
	if(seats == 0)
	{
		alert("Please Select Seats");
		$("#seats").focus();
		return false;
	}
	/*if(seats_arrangement == "1+1" && bustype == 1)
	{
		alert("Please Select Number of Rows");
		$("#rows").focus();
		return false;
	}*/
	if(bustype == 1 && lower_rows == 0)
	{
		alert("Please Select Lower Deck Rows");
		$("#lower_rows").focus();
		return false;
	}
	if(bustype == 1 && lower_cols == 0)
	{
		alert("Please Select Lower Deck Cols");
		$("#lower_cols").focus();
		return false;
	}
	if(bustype == 1 && upper_rows == 0)
	{
		alert("Please Select Upper Deck Rows");
		$("#upper_rows").focus();
		return false;
	}
	if(bustype == 1 && upper_cols == 0)
	{
		alert("Please Select Upper Deck Cols");
		$("#upper_cols").focus();
		return false;
	}	
	if(bustype == 2 && rows == 0)
	{
		alert("Please Select Rows");
		$("#rows").focus();
		return false;
	}	
	if(bustype == 2 && cols == 0)
	{
		alert("Please Select Cols");
		$("#cols").focus();
		return false;
	}
	/*if(bustype == 3 && rows == 0)
	{
		alert("Please Select Rows");
		$("#rows").focus();
		return false;
	}
	if(bustype == 3 && cols == 0)
	{
		alert("Please Select Rows");
		$("#cols").focus();
		return false;
	}*/
	if(bustype == 3 && lower_rows == 0)
	{
		alert("Please Select Lower Deck Rows");
		$("#lower_rows").focus();
		return false;
	}
	if(bustype == 3 && lower_cols == 0)
	{
		alert("Please Select Lower Deck Cols");
		$("#lower_cols").focus();
		return false;
	}
	if(bustype == 3 && upper_rows == 0)
	{
		alert("Please Select Upper Deck Rows");
		$("#upper_rows").focus();
		return false;
	}
	if(bustype == 3 && upper_cols == 0)
	{
		alert("Please Select Upper Deck Cols");
		$("#upper_cols").focus();
		return false;
	}
	if(grow == 0)
	{
		alert("Please Select Gangway Row");
		$("#grow").focus();
		return false;
	}
	else
	{
		$.post("<?php echo base_url('index.php/operator/getlayout');?>",
		{
			operator : $("#operator").val(),
			bustype : $("#bustype").val(),
			model : $("#model").val(),
			//seats_arrangement : $("#seats_arrangement").val(),
			seats : $("#seats").val(),
			rows : $("#rows").val(),
			cols : $("#cols").val(),
			lower_rows : $("#lower_rows").val(),
			lower_cols : $("#lower_cols").val(),
			upper_rows : $("#upper_rows").val(),
			upper_cols : $("#upper_cols").val(),
			grow : grow
		},function(res)
		{			
			$("#layout_db").html(res);
		});
	}
}
function checkdata()
{
	var operator = $("#operator").val();
	var bustype = $("#bustype").val();
	var model = $("#model").val();
	//var seats_arrangement = $("#seats_arrangement").val();
	var seats = $("#seats").val();
	var rows = $("#rows").val();
	var cols = $("#cols").val();
	var lower_rows = $("#lower_rows").val();
	var lower_cols = $("#lower_cols").val();
	var upper_rows = $("#upper_rows").val();
	var upper_cols = $("#upper_cols").val();
	var chkcnt = $('.chkbox:checked').length;
	var isValid = true;
	var i = 1;
	var j = 1;
	var lower_seat_no = "";
	var upper_seat_no = "";
	var lower_rowcols = "";
	var upper_rowcols = "";
	var lower_type = "";
	
	if(operator == 0)
	{
		alert("Please Select Operator");
		$("#operator").focus();
		return false;
	}
	if(bustype == 0)
	{
		alert("Please Select Bus Type");
		$("#bustype").focus();
		return false;
	}
	if(model == 0)
	{
		alert("Please Select Model");
		$("#model").focus();
		return false;
	}
	if(seats_arrangement == 0)
	{
		alert("Please Select Seat Type");
		$("#seats_arrangement").focus();
		return false;
	}
	if(seats == 0)
	{
		alert("Please Select Seats");
		$("#seats").focus();
		return false;
	}
	/*if(seats_arrangement == "1+1" && bustype == 1)
	{
		alert("Please Select Number of Rows");
		$("#rows").focus();
		return false;
	}*/
	if(bustype == 1 && lower_rows == 0)
	{
		alert("Please Select Lower Deck Rows");
		$("#lower_rows").focus();
		return false;
	}
	if(bustype == 1 && lower_cols == 0)
	{
		alert("Please Select Lower Deck Cols");
		$("#lower_cols").focus();
		return false;
	}
	if(bustype == 1 && upper_rows == 0)
	{
		alert("Please Select Upper Deck Rows");
		$("#upper_rows").focus();
		return false;
	}
	if(bustype == 1 && upper_cols == 0)
	{
		alert("Please Select Upper Deck Cols");
		$("#upper_cols").focus();
		return false;
	}	
	if(bustype == 2 && rows == 0)
	{
		alert("Please Select Rows");
		$("#rows").focus();
		return false;
	}	
	if(bustype == 2 && cols == 0)
	{
		alert("Please Select Cols");
		$("#cols").focus();
		return false;
	}
	/*if(bustype == 3 && rows == 0)
	{
		alert("Please Select Rows");
		$("#rows").focus();
		return false;
	}
	if(bustype == 3 && cols == 0)
	{
		alert("Please Select Rows");
		$("#cols").focus();
		return false;
	}*/
	if(bustype == 3 && lower_rows == 0)
	{
		alert("Please Select Lower Deck Rows");
		$("#lower_rows").focus();
		return false;
	}
	if(bustype == 3 && lower_cols == 0)
	{
		alert("Please Select Lower Deck Cols");
		$("#lower_cols").focus();
		return false;
	}
	if(bustype == 3 && upper_rows == 0)
	{
		alert("Please Select Upper Deck Rows");
		$("#upper_rows").focus();
		return false;
	}
	if(bustype == 3 && upper_cols == 0)
	{
		alert("Please Select Upper Deck Cols");
		$("#upper_cols").focus();
		return false;
	}
	if(chkcnt < seats)
	{				
		alert("Seats Count Mismatch in the layout");
		$("#seats").focus();
		return false;
	}
	/*if(chkcnt != seats)
	{
		var cnt = chkcnt - seats;
		
		alert("Please Deselect "+cnt+" checkboxes in the layout");
		$("#seats").focus();
		return false;
	}*/	
	/*if(isValid == true)
	{
		/*$('input[type="text"]').each(function()
		{
	    	if ($.trim($(this).val()) == '')
			{
	        	isValid = false;
				alert("Please fill the textbox values");
				$("#seats").focus();
				return false;
	        }			
		});*/
					 
	else
	{
		if(bustype == 1)
		{
			for(i = 1;i <= lower_rows;i++)
			{
				for(j = 1;j <= lower_cols;j++)
				{				
					if($('#lchk'+i+'-'+j).is(":checked"))
					{
						$('#ltxt'+i+'-'+j).removeAttr("disabled");
						if($('#ltxt'+i+'-'+j).val() == "")
						{
							alert("Please Provide values for Lower Deck Textboxes");
							$('#ltxt'+i+'-'+j).focus();
							return false;
						}
						else
						{
							if(lower_seat_no == "")
							{
								lower_seat_no = $('#ltxt'+i+'-'+j).val();
								lower_rowcols = i+'-'+j;
							}
							else
							{
								lower_seat_no = lower_seat_no +'#'+ $('#ltxt'+i+'-'+j).val();
								lower_rowcols = lower_rowcols +'#'+ i+'-'+j;
							}
						}
					}
					else
					{
						$('#ltxt'+i+'-'+j).attr("disabled" , "disabled");
					}									
				}
			}
		
			for(i = 1;i <= upper_rows;i++)
			{
				for(j = 1;j <= upper_cols;j++)
				{				
					if($('#uchk'+i+'-'+j).is(":checked"))
					{
						$('#utxt'+i+'-'+j).removeAttr("disabled");
						if($('#utxt'+i+'-'+j).val() == "")
						{
							alert("Please Provide values for Upper Deck Textboxes");
							$('#utxt'+i+'-'+j).focus();
							return false;
						}
						else
						{
							if(upper_seat_no == "")
							{
								upper_seat_no = $('#utxt'+i+'-'+j).val();
								upper_rowcols = i+'-'+j;
							}
							else
							{
								upper_seat_no = upper_seat_no +'#'+ $('#utxt'+i+'-'+j).val();
								upper_rowcols = upper_rowcols +'#'+ i+'-'+j;
							}
						}
					}	
					00
					{
						$('#utxt'+i+'-'+j).attr("disabled" , "disabled");
					}
				}	
			}	
		}
		
		if(bustype == 2)
		{
			for(i = 1;i <= rows;i++)
			{
				for(j = 1;j <= cols;j++)
				{				
					if($('#lchk'+i+'-'+j).is(":checked"))
					{
						$('#ltxt'+i+'-'+j).removeAttr("disabled");
						if($('#ltxt'+i+'-'+j).val() == "")
						{
							alert("Please Provide values for Lower Deck Textboxes");
							$('#ltxt'+i+'-'+j).focus();
							return false;
						}
						else
						{
							if(lower_seat_no == "")
							{
								lower_seat_no = $('#ltxt'+i+'-'+j).val();
								lower_rowcols = i+'-'+j;
							}
							else
							{
								lower_seat_no = lower_seat_no +'#'+ $('#ltxt'+i+'-'+j).val();
								lower_rowcols = lower_rowcols +'#'+ i+'-'+j;
							}
						}
					}
					else
					{
						$('#ltxt'+i+'-'+j).attr("disabled" , "disabled");
					}					
				}
			}
		}
		
		if(bustype == 3)
		{
			/*var total_rows = parseInt(lower_rows) + parseInt(rows);
			
			for(i = 1;i <= total_rows;i++)
			{
				for(j = 1;j <= cols;j++)
				{				
					if($('#lchk'+i+'-'+j).is(":checked"))
					{
						$('#ltxt'+i+'-'+j).removeAttr("disabled");
						if($('#ltxt'+i+'-'+j).val() == "")
						{
							alert("Please Provide values for Lower Deck Textboxes");
							$('#ltxt'+i+'-'+j).focus();
							return false;
						}
						else
						{
							if(lower_seat_no == "")
							{
								lower_seat_no = $('#ltxt'+i+'-'+j).val();
								lower_rowcols = i+'-'+j;
							}
							else
							{
								lower_seat_no = lower_seat_no +'#'+ $('#ltxt'+i+'-'+j).val();
								lower_rowcols = lower_rowcols +'#'+ i+'-'+j;
							}
						}
					}
					else
					{
						$('#ltxt'+i+'-'+j).attr("disabled" , "disabled");
					}					
				}
			}*/
			
			for(i = 1;i <= lower_rows;i++)
			{
				for(j = 1;j <= lower_cols;j++)
				{				
					if($('#lchk'+i+'-'+j).is(":checked"))
					{
						$('#ltxt'+i+'-'+j).removeAttr("disabled");
						//$('#slchk'+i+'-'+j).prop('checked', true);
						//$('#blchk'+i+'-'+j).prop('checked', true);
																		
						if($('#ltxt'+i+'-'+j).val() == "")
						{
							alert("Please Provide values for Lower Deck Textboxes");
							$('#ltxt'+i+'-'+j).focus();
							return false;
						}
						else
						{
							var ltxt = $('#ltxt'+i+'-'+j).val();
							
							if($('#slchk'+i+'-'+j).is(":checked") && $('#blchk'+i+'-'+j).is(":checked"))
							{
								alert("Please Select either Seat or Berth for "+ltxt+" value");							
								return false;
							}						
							else if($('#slchk'+i+'-'+j).is(":checked") || $('#blchk'+i+'-'+j).is(":checked"))
							{
								if(lower_type == "")
								{
									if($('#slchk'+i+'-'+j).is(":checked"))
									{
										lower_type = $('#slchk'+i+'-'+j).val();
									}
									else
									{
										lower_type = $('#blchk'+i+'-'+j).val();
									}		
								}
								else
								{
									if($('#slchk'+i+'-'+j).is(":checked"))
									{
										lower_type = lower_type +'#'+ $('#slchk'+i+'-'+j).val();
									}
									else
									{
										lower_type = lower_type +'#'+ $('#blchk'+i+'-'+j).val();
									}					
								}
								
								if(lower_seat_no == "")
								{
									lower_seat_no = $('#ltxt'+i+'-'+j).val();
									lower_rowcols = i+'-'+j;
								}
								else
								{
									lower_seat_no = lower_seat_no +'#'+ $('#ltxt'+i+'-'+j).val();
									lower_rowcols = lower_rowcols +'#'+ i+'-'+j;
								}
							}
							else
							{
								alert("Please Select either Seat or Berth for "+ltxt+" value");							
								return false;
							}								
						}
					}	
					else
					{
						$('#ltxt'+i+'-'+j).attr("disabled" , "disabled");
						//$('#slchk'+i+'-'+j).prop('checked', false);
						//$('#blchk'+i+'-'+j).prop('checked', false);
					}
				}	
			}
			
			for(i = 1;i <= upper_rows;i++)
			{
				for(j = 1;j <= upper_cols;j++)
				{				
					if($('#uchk'+i+'-'+j).is(":checked"))
					{
						$('#utxt'+i+'-'+j).removeAttr("disabled");
						if($('#utxt'+i+'-'+j).val() == "")
						{
							alert("Please Provide values for Upper Deck Textboxes");
							$('#utxt'+i+'-'+j).focus();
							return false;
						}
						else
						{
							if(upper_seat_no == "")
							{
								upper_seat_no = $('#utxt'+i+'-'+j).val();
								upper_rowcols = i+'-'+j;
							}
							else
							{
								upper_seat_no = upper_seat_no +'#'+ $('#utxt'+i+'-'+j).val();
								upper_rowcols = upper_rowcols +'#'+ i+'-'+j;
							}
						}
					}	
					else
					{
						$('#utxt'+i+'-'+j).attr("disabled" , "disabled");
					}
				}	
			}	
		}
		/*alert(lower_seat_no);
		alert(lower_rowcols);
		alert(upper_seat_no);
		alert(upper_rowcols);*/
		
		if(bustype == 2)
  		{
	  		var return_val = checkTextBoxes(lower_seat_no); //checks duplicate seat names
  		}
  		else
  		{
  			var return_val = checkTextBoxes(lower_seat_no); //checks duplicate seat names
			if(return_val != 'duplicate')
			{
  				var return_val2 = checkTextBoxes(upper_seat_no); //checks duplicate seat names
			}	
  		}
		
		//alert(return_val);
		//alert(return_val2);
		
		if((return_val != 'duplicate' && bustype == 2) || (return_val != 'duplicate' && bustype != 2 && return_val2 != 'duplicate'))//no duplications
  		{						
			if(bustype != 2)
			{
				var lower = new Array();
        		var upper = new Array();
				
				lower = lower_seat_no.split("#");
        		upper = upper_seat_no.split("#");
		        
				for(var i = 0; i<lower.length; i++)
				{					
            		for(var j=0; j<upper.length; j++)
					{
						if(lower[i]!='gy')
						{						
							if(lower[i] === upper[j])
							{
								alert('Lowedeck seat ('+lower[i]+') and Upperdeck seat ('+upper[j]+') names should not be same!');
								i=0;
								j=0;
								return false;
							}	
						}
       				}
     			}
			}
			
			$.post("<?php echo base_url('index.php/operator/insertlayout');?>",
			{
				operator : $("#operator").val(),
				bustype : $("#bustype").val(),
				model : $("#model").val(),
				//seats_arrangement : $("#seats_arrangement").val(),
				seats : $("#seats").val(),
				rows : $("#rows").val(),
				cols : $("#cols").val(),
				lower_rows : $("#lower_rows").val(),
				lower_cols : $("#lower_cols").val(),
				upper_rows : $("#upper_rows").val(),
				upper_cols : $("#upper_cols").val(),
				chkcnt : chkcnt,
				lower_seat_no : lower_seat_no,
				lower_rowcols : lower_rowcols,
				upper_seat_no : upper_seat_no,
				upper_rowcols : upper_rowcols,
				lower_type : lower_type
			},function(res)
			{			
				//alert(res);
				if(res == 1)
				{
					alert("Layout Inserted Successfully");
					window.location = "<?php echo base_url('index.php/operator/layout');?>";
				}	
				else 
				{
					alert("Layout Not Inserted");
				}		
			});
		}
		else
		{
			alert('Seat names should not be same!');
			return false;
		}								
	}	
}

function checkTextBoxes(seat_no)
{
	//alert(seat_no);
	var lower = new Array();
	var i, j, n;
	
	lower = seat_no.split("#");
	
	n = lower.length;
	//alert(n);
	// to ensure the fewest possible comparisons
	for (i=0; i<n; i++)
	{ // outer loop uses each item i at 0 through n
		//alert(i);
		if(lower[i]=='gy')
		{
			
		}
		else
		{
			for (j=i+1; j<=n; j++)
			{ // inner loop only compares items j at i+1 to n			
				//alert(j);
				//alert("i : "+lower[i]);
				//alert("j : "+lower[j]);
				if (lower[i] == lower[j])
				{ 
					if(lower[i].toUpperCase()=='GY' && lower[j].toUpperCase()=='GY') return "";
					return "duplicate";
					break;
				}				
			}
		}		
	}			
}
</script>
<table width="70%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td height="30">&nbsp;</td>
		<td height="30" colspan="3" class="space" align="center">Add Operator Bus Layout </td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr>
		<td height="30">&nbsp;</td>
		<td height="30" class="space">&nbsp;</td>
		<td height="30" align="center">&nbsp;</td>
		<td height="30">&nbsp;</td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr>
		<td height="30">&nbsp;</td>
		<td height="30" class="space">Operator</td>
		<td height="30" align="center"><strong>:</strong></td>
		<td height="30"><?php
		$js = 'id="operator" style="width:135px"';
        echo form_dropdown('operator', $operators, '', $js);
	?></td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr>
		<td height="30">&nbsp;</td>
		<td height="30" class="space">Bus Type</td>
		<td height="30" align="center"><strong>:</strong></td>
		<td height="30"><?php
		$js = 'id="bustype" style="width:135px"';
        echo form_dropdown('bustype', $bustypes, '', $js);
	?></td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr id="mode" style="display:none">
		<td height="30">&nbsp;</td>
		<td height="30" class="space">Model</td>
		<td height="30" align="center"><strong>:</strong></td>
		<td height="30" id="mod"></td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr id="st" style="display:none">
		<td height="30">&nbsp;</td>
		<td height="30" class="space">Seat Type</td>
		<td height="30" align="center"><strong>:</strong></td>
		<td height="30"><?php
		$js = 'id="seats_arrangement" style="width:135px"';
        echo form_dropdown('seats_arrangement', $seats_arrangement, '', $js);
	?></td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr>
		<td height="30">&nbsp;</td>
		<td height="30" class="space">N.o.Seats</td>
		<td height="30" align="center"><strong>:</strong></td>
		<td height="30"><select name="seats" id="seats">
				<option value="0">select</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
				<option value="32">32</option>
				<option value="33">33</option>
				<option value="34">34</option>
				<option value="35">35</option>
				<option value="36">36</option>
				<option value="37">37</option>
				<option value="38">38</option>
				<option value="39">39</option>
				<option value="40">40</option>
				<option value="41">41</option>
				<option value="42">42</option>
				<option value="43">43</option>
				<option value="44">44</option>
				<option value="45">45</option>
				<option value="46">46</option>
				<option value="47">47</option>
				<option value="48">48</option>
				<option value="49">49</option>
				<option value="50">50</option>
				<option value="51">51</option>
				<option value="52">52</option>
				<option value="53">53</option>
				<option value="54">54</option>
				<option value="55">55</option>
				<option value="56">56</option>
				<option value="57">57</option>
				<option value="58">58</option>
				<option value="59">59</option>
				<option value="60">60</option>
				<option value="61">61</option>
				<option value="62">62</option>
				<option value="63">63</option>
				<option value="64">64</option>
				<option value="65">65</option>
				<option value="66">66</option>
				<option value="67">67</option>
				<option value="68">68</option>
				<option value="69">69</option>
				<option value="70">70</option>
				<option value="71">71</option>
				<option value="72">72</option>
				<option value="73">73</option>
				<option value="74">74</option>
				<option value="75">75</option>
			</select>		</td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr id="ros" style="display:none">
		<td height="30">&nbsp;</td>
		<td height="30" class="space">N.o.Rows</td>
		<td height="30" align="center"><strong>:</strong></td>
		<td height="30"><select name="rows" id="rows">
				<option value="0">select</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
			</select>		</td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr id="cos" style="display:none">
		<td height="30">&nbsp;</td>
		<td height="30" class="space">N.o Columns</td>
		<td height="30" align="center"><strong>:</strong></td>
		<td height="30"><select name="cols" id="cols">
				<option value="0">select</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				
			</select>		</td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr id="ld_rows" style="display:none">
		<td height="30">&nbsp;</td>
		<td height="30" class="space">Lower Deck Rows</td>
		<td height="30" align="center"><strong>:</strong></td>
		<td height="30"><select name="lower_rows" id="lower_rows">
				<option value="0">select</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>		</td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr id="ld_cols" style="display:none">
		<td height="30">&nbsp;</td>
		<td height="30" class="space">Lower Deck Columns</td>
		<td height="30" align="center"><strong>:</strong></td>
		<td height="30"><select name="lower_cols" id="lower_cols">
				<option value="0">select</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
			</select>		</td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr id="ud_rows" style="display:none">
		<td height="30">&nbsp;</td>
		<td height="30" class="space">Upper Deck Rows</td>
		<td height="30" align="center"><strong>:</strong></td>
		<td height="30"><select name="upper_rows" id="upper_rows">
				<option value="0">select</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select></td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr id="ud_cols" style="display:none">
		<td height="30">&nbsp;</td>
		<td height="30" class="space">Upper Deck Columns</td>
		<td height="30" align="center"><strong>:</strong></td>
		<td height="30"><select name="upper_cols" id="upper_cols">
				<option value="0">select</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
			</select>		</td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr>
		<td height="30">&nbsp;</td>
		<td height="30" class="space">Gangway Row </td>
		<td height="30" align="center"><strong>:</strong></td>
		<td height="30" valign="middle"><select name="grow" id="grow">
			<option value="0">select</option>			
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>			
		</select></td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr>
		<td height="30">&nbsp;</td>
		<td height="30" class="space">&nbsp;</td>
		<td height="30" align="center">&nbsp;</td>
		<td height="30" valign="middle"><input type="button" name="Submit" value="Get Layout" onclick="return validate();" style="padding:5px 15px;" /></td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr>
		<td height="30">&nbsp;</td>
		<td height="30" colspan="3" class="space" id="layout_db">&nbsp;</td>
		<td height="30">&nbsp;</td>
	</tr>
	<tr>
		<td height="30">&nbsp;</td>
		<td height="30" colspan="3" class="space" id="layout_db">&nbsp;</td>
		<td height="30">&nbsp;</td>
	</tr>
</table>
