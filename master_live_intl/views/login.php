<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>::Operator Admin Panel::</title>
        <meta name="viewport" content="width=device-width, user-scalable=no">
            <meta name="HandheldFriendly" content="True">
                <script type="text/javascript">
                    function validate() {

                        var username = document.getElementById('uname').value;
                        var password = document.getElementById('pwd').value;
                        if (username == '')
                        {
                            alert('Provide User Name !');
                            document.getElementById('uname').focus();
                            return false;
                        }
                        else if (password == '')
                        {
                            alert('Provide Password !');
                            document.getElementById('pwd').focus();
                            return false;
                        }
                        else {
                            return true;
                        }


                    }

                </script>
                <meta name="HandheldFriendly" content="True">
                    <style>
                        body {
                            font-family:Arial, Helvetica, sans-serif;
                            font-size:14px;
                            margin:0px; padding:0px;
                        }
                    </style>

                    </head>

                    <body>

                        <form action="<?php echo site_url("master_control/loginCheck") ?>" method="post" onsubmit=" return validate()">

                            <table width="53%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top:90px; border:#000 solid 2px;">
                                <tr>
                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" height="235" style="margin-top:0px; border:#a6c1ce solid 5px;">
                                            <tr>
                                                <td height="16" colspan="4" align="center" valign="bottom" style="padding-left:25px;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td height="16" colspan="4" align="center" valign="bottom">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td height="25" colspan="4" align="center" valign="bottom"><span style="font-size:13px; font-weight:bold;"> OPERATOR LOGIN PANEL</span></td>
                                            </tr>
                                            <tr>
                                                <td height="15" colspan="4" align="center" valign="bottom"></td>
                                            </tr>
                                            <tr>
                                                <td height="15" colspan="4" align="right" valign="middle" style="padding-right:10px;"></td>
                                            </tr>
                                            <tr>
                                                <td height="20" align="right" valign="middle" style="padding-right:10px;">&nbsp;</td>
                                                <td width="30" height="20" align="left" valign="middle" style="padding-right:10px;">&nbsp;</td>
                                                <td height="20" align="left" valign="middle"><span style="padding-right:10px;">User Name</span></td>
                                                <td align="left" valign="bottom">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="110" height="25" align="right" valign="middle" style="padding-right:10px;">&nbsp;</td>
                                                <td height="25" align="left" valign="middle" style="padding-right:10px;">&nbsp;</td>
                                                <td width="146" height="25" align="left" valign="bottom"><label>
                                                        <input type="text" name="uname" id="uname"  value="" style="border:#7f9db9 solid 1px"/>
                                                    </label></td>
                                                <td width="174" align="left" valign="middle"><span id="s1" style="color:#BF0000; font-size:12px;"></span></td>
                                            </tr>
                                            <tr>
                                                <td height="10" colspan="2" align="right" valign="middle" style="padding-right:10px;"></td>
                                                <td height="10" colspan="2" align="left" valign="bottom"></td>
                                            </tr>
                                            <tr>
                                                <td height="20" align="right" valign="middle" style="padding-right:10px;">&nbsp;</td>
                                                <td align="left" valign="middle" style="padding-right:10px;">&nbsp;</td>
                                                <td height="20" align="left" valign="middle"><span style="padding-right:10px;">Password</span></td>
                                                <td height="20" align="left" valign="bottom">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td height="25" align="right" valign="middle" style="padding-right:10px;">&nbsp;</td>
                                                <td align="left" valign="middle" style="padding-right:10px;">&nbsp;</td>
                                                <td height="25" align="left" valign="bottom"><input type="password" name="pwd" id="pwd" value=""  style="border:#7f9db9 solid 1px"/></td>
                                                <td height="25" align="left" valign="middle"><span id="s2" style="color:#BF0000; font-size:12px;"></span></td>
                                            </tr>
                                            <tr>
                                                <td height="25" align="right" valign="middle" style="padding-right:10px;">&nbsp;</td>
                                                <td height="25" colspan="3" align="left" valign="bottom" style="padding-right:10px;" ><span id="spnmsg" style="color:#333333; font-size:9pt; font-family:Arial, Helvetica, sans-serif;"><?php echo (isset($status)) ? $status : ''; ?> </span></td>
                                            </tr>

                                            <tr>
                                                <td height="41" colspan="4" align="center" valign="bottom"><label>
                                                        <input type="submit" name="btnLogin" id="btnLogin" value="Login"  style="background-color:#0066CC; font-weight:bold; border:none; padding:3px 16px; color:#FFFFFF; cursor:pointer; border-radius:3px;" />
                                                    </label>        </td>
                                            </tr>
                                            <tr>
                                                <td height="21" colspan="4" align="center" valign="bottom"><span id="s3" style="color:#BF0000; font-size:12px;"></span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="center" valign="bottom">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="center"></td>
                                            </tr>

                                        </table></td>
                                </tr>
                            </table>

                        </form>
                    </body>
                    </html>

