<?php 

foreach($temp as $row){
$mid = $row->id;
$description = $row->description;
$solution = $row->solution;


}


?>
<html>
    <head>

        
        <title>Mail Format</title>
		<link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />
        <script>
            function validate() {

                var description = $('#description').val();
                var solution = $('#solution').val();
				var mid = $('#mid').val();
				
                if (description == "")
                {
                    alert("Please Enter description");

                    return false;
                }
                else if (solution == "")
                {
                    alert("Please enter solution");

                    return false;
                }
                else
                {
                    $.post("<?php echo base_url('master_control/update_mail_fmt1'); ?>",
                            {	
								id:mid,
                                description1: description,
                                solution1: solution
                            }, function (res)
                    {
                        //alert(res);
                        if (res == 1)
                        {
                            alert("Successfully updated");
                            window.location = "<?php echo base_url('master_control/mail_farmat'); ?>";
                        }
                        else
                        {
                            //alert(res);
                            alert("Problem in Insertting");
                        }
                    });
                }

            }

        </script>
    </head>
    <body>
        <form  id="mfmt" name="mfmt" method="post">
            <table width="67%" border="0" align="center" bordercolor="#000099">
                <tr>
                    <td height="30" colspan="5" align="center"><u> MAIL FORMAT </u> </td>
					<td width="33%" height="30"><a href="<?php echo base_url('master_control/mail_farmat'); ?>">Go Back </a></td>
                </tr>
                <tr>
                    <td colspan="5" align="right">&nbsp;</td><td colspan="5" align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top">Description</td>
                   
                    <td align="center" valign="top"><strong>:</strong></td>
                    <td><textarea name="description" id="description" cols="45" rows="6"><?php echo htmlspecialchars($description);?></textarea></td>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top">Solution</td>
                   
                    <td align="center" valign="top"><strong>:</strong></td>
                    <td><textarea name="solution" id="solution" cols="45" rows="6"><?php echo htmlspecialchars($solution);?></textarea>
					<input type="hidden" id="mid" name="mid" value="<?php echo "$mid";?>" ></td>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5" align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">&nbsp;</td>
                    
                    <td align="center">&nbsp;</td>
                    <td align="center"><input type="button" name="submit" id="submit" value="update"  onclick="validate();" /></td>
                	<td align="center">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">&nbsp;</td>
                    
                    <td align="center">&nbsp;</td>
                    <td>&nbsp;</td>
                	<td>&nbsp;</td>
                </tr>
            </table>
        </form>

        
</body>
</html>
