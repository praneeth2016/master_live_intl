
<html>
    <head>

        
        <title>Mail Format</title>
		<link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />
        <script>
            function validate() {

                var description = $('#description').val();
                var solution = $('#solution').val();

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
                    $.post("<?php echo base_url('master_control/mail_farmat1'); ?>",
                            {
                                description1: description,
                                solution1: solution
                            }, function (res)
                    {
                        //alert(res);
                        if (res == 1)
                        {
                            alert("Successfully Inserted");
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
                    <td height="30" colspan="4" align="center"><u> MAIL FORMAT </u> </td>
                </tr>
                <tr>
                    <td colspan="3" align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top">Description</td>
                    <td align="center" valign="top"><strong>:</strong></td>
                    <td><textarea name="description" id="description" cols="45" rows="6"></textarea></td>
                </tr>
                <tr>
                    <td valign="top">Solution</td>
                    <td align="center" valign="top"><strong>:</strong></td>
                    <td><textarea name="solution" id="solution" cols="45" rows="6"></textarea></td>
                </tr>
                <tr>
                    <td colspan="3" align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="center"><input type="button" name="submit" id="submit" value="ADD"  onclick="validate();" /></td>
                </tr>
                <tr>
                    <td align="right">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </form>

        
        <table id='tbl' style='margin: 0px auto;' class='gridtable'  width='72%' border="0" align="center">
        <tr>
        <th>description</th>             
        <th>Option</th>
        </tr>
		<?php
        
        foreach ($description as $row) {
            $id = $row->id;
            $description = $row->description;
            $solution = $row->solution;
			?>
            <tr>
            	<td align="center" style='font-size:12px';><?php echo anchor('master_control/view_mail_fmt?id='.$id, "$description", ''); ?></td>            	
            <td align="center"><?php echo anchor('master_control/update_mail_fmt?id='.$id, 'Update', ''); ?></td>
            </tr>
			<?php           
        }
		?>
        </table>
    </body>
</html>
