<?php 
foreach($temp as $row){
$description = $row->description;
$solution = $row->solution;


}

?>
<html>
    <head>
        <title>Mail Format</title>
		<link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />

    </head>
    <body>
        <form  id="mfmt" name="mfmt" method="post">
            <table width="72%" cellspacing="1" cellpadding="1" align="center">
				<tr>
					<td height="30" colspan="3" align="center"><u>MAIL FORMAT </u></td>
					<td width="33%" height="30"><a href="<?php echo base_url('master_control/mail_farmat'); ?>">Go Back </a></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="17%" height="30">Description</td>
					<td width="2%" height="30"><strong>:</strong></td>
					<td width="48%" height="30"><textarea name="description" id="description" cols="45" rows="6" readonly ><?php echo htmlspecialchars($description);?></textarea></td>
					<td height="30">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td height="30">Solution</td>
					<td height="30"><strong>:</strong></td>
					<td height="30"><textarea name="solution" id="solution" cols="45" rows="6" readonly ><?php echo htmlspecialchars($solution);?></textarea></td>
					<td height="30">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
    </form>        
        
    </body>
</html>
