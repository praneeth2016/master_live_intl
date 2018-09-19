<?php error_reporting(0); ?>

<html>
    <head>
        <title>terms & conditions</title>
<style type="text/css">
textarea {
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
    font-size: 16px;
    resize: none;
}
</style>
         <meta charset="utf-8"/>
	<script src="<?php echo base_url("js/jquery.min.js");?>" type="text/javascript"></script>

<script type="text/javascript">
function validate()
{

	var opid = $("#operators").val();
	
	if(opid == 0 || opid=='')
	{
		alert("Kindly select operator !!");
		$("#operators").focus();
		return false
	}
	else
	{
		$.post("<?php echo base_url('operator/getTermsConditions');?>",
		{
			opid:opid
		},function(res)
		{
			//alert(res);
			$("#sp").show();
			$("#terms").val(res);
			
			
		});
	}
}

function save()
{

	var terms = $("#terms").val();
	var opid = $("#operators").val();
	
	if(opid == 0 || opid=='')
	{
		alert("Kindly select operator !!");
		$("#operators").focus();
		return false
	}
	if(terms == 0 || terms=='')
	{
		alert("Please Enter terms & conditions.");
		$("#terms").focus();
		return false
	}
	else
	{
		$.post("<?php echo base_url('operator/saveTerms');?>",
		{
			opid:opid,
			terms:terms
		},function(res)
		{
			if(res==1)
			{
				alert(" Saved successfully!!");
			}
			
			
		});
	}
}
</script>
	</head>
        <h2 align='center'>Update Operator Terms & Conditions</h2>
<form name="edit_opr" id="edit_opr" action="" method="post">		
<table align="center"  cellspacing="0" width="572">
		<tr>
                    <td width="227" align="right" style='font-size:12px;'>Select operator:</td>
		  <td width="77">
                     <?php $op_id = 'id="operators" name="operators" style="width:150px; font-size:12px" onchange="validate()" ';
                     echo form_dropdown('operators',$operators,"",$op_id);?>          </td>
		  <td width="260"></td>
		 
  </tr>
		    
    </table>
</form>                 
</html>


<div id="sp" style="display: none; alin:center;" align="center">
Terms & Conditions:
<br />
<textarea rows="35" cols="70" id="terms" ></textarea>
<input type="button" id="save" name="save" value="Save" onClick="save()" />
    
</div>