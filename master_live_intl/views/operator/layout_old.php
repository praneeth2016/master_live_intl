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
		
		if(bustype != 1)
		{
			$("#ros").hide();
			$("#ld").hide();
			$("#ud").hide();
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

$("#document").ready(function()
{	
	$("#seats_arrangement").change(function()
	{
		var bustype = $("#bustype").val();
		var seats_arrangement = $("#seats_arrangement").val();				
		
		if(bustype == 1 && seats_arrangement == 1)
		{			
			$("#ros").show();
			$("#ld").show();
			$("#ud").show();
		}		
		else
		{
			$("#ros").hide();
			$("#ld").show();
			$("#ud").show();
		}
	});
});
</script>
<script type="text/javascript">
function validate()
{
	var operator = $("#operator").val();
	var bustype = $("#bustype").val();
	var model = $("#model").val();
	var seats_arrangement = $("#seats_arrangement").val();
	var seats = $("#seats").val();
	var rows = $("#rows").val();
	var lower = $("#lower").val();
	var upper = $("#upper").val();
	
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
	if(seats_arrangement == "1+1" && bustype == 1)
	{
		alert("Please Select Number of Rows");
		$("#rows").focus();
		return false;
	}
	if(bustype == 1 && lower == 0)
	{
		alert("Please Select Lower Deck Seats");
		$("#lower").focus();
		return false;
	}
	if(bustype == 1 && upper == 0)
	{
		alert("Please Select Upper Deck Seats");
		$("#upper").focus();
		return false;
	}
	else
	{
		
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
    <td height="30" id="mod">	
	</td>
    <td height="30">&nbsp;</td>
  </tr>
  <tr>
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
    <td height="30" class="space">Seats</td>
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
    </select>    </td>
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
    </select>    </td>	
    <td height="30">&nbsp;</td>
  </tr> 
  <tr id="ld" style="display:none">
    <td height="30">&nbsp;</td>
    <td height="30" class="space">Lower Deck Seats </td>
    <td height="30" align="center"><strong>:</strong></td>
    <td height="30">
      <select name="lower" id="lower">
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
      </select>
    </td>
    <td height="30">&nbsp;</td>
  </tr>    
  <tr id="ud" style="display:none">
    <td height="30">&nbsp;</td>	
    <td height="30" class="space">Upper Deck Seats </td>
    <td height="30" align="center"><strong>:</strong></td>	
    <td height="30"><select name="upper" id="upper">
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
    </select></td>
    <td height="30">&nbsp;</td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" class="space">&nbsp;</td>
    <td height="30" align="center">&nbsp;</td>
    <td height="30">&nbsp;</td>
    <td height="30">&nbsp;</td>
  </tr>  
</table>

