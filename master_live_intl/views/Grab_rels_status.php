<?php error_reporting(0); ?>

<html>
    <head>
     <link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />
        <title>Inhouse agents</title>
<style type="text/css">
table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:12px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}
</style>
         <meta charset="utf-8"/>
	<script src="<?php echo base_url("js/jquery.min.js");?>" type="text/javascript"></script>
        <script>
            function ChangeData(){
                var op=$('#operators').val();
                $.post('grab_rels_history',{op:op},function(res){
                 <!--$('#sp').html(res); 
                 $('#tbl').hide();--> 
                });
            }
            </script>
			
	</head>
       
<form name="grab" id="grab" action="<?php echo base_url("master_control/get_grab_rels_history");?>" method="get">		
<table align="center"  cellspacing="0" width="572">
		<tr>
                    <td width="227" align="right" style='font-size:12px;'>Select operator:</td>
		  <td width="77">
                     <?php $op_id = 'id="operators" name="operators" style="width:150px; font-size:12px" ';
                     echo form_dropdown('operators',$operators,"",$op_id);?>          </td>
		  <td width="260"><input type="submit" id="edit" name="edit" value="View" /> </td>
		 
  </tr>
		    
    </table>
</form>                 
</html>
