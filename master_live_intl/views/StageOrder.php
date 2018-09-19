<html>
    <head>
        <title>Cities list</title>
        <script src="<?php echo base_url("js/jquery-1.5.2.min.js");?>" type="text/javascript"></script>
        
    </head>
    <script>
  
	 function getStages() {

        var stops = $("#stops").val();
        $.post('getStageOrder', {stops: stops}, function (res) {
            $('#response').html(res);
			document.getElementById('Insert').style.display= "block";
        });
    }
	
	
        function validate()
          {
            var op = $("#operators").val();
			var routes = $("#routes").val();
			var stops = $("#stops").val();

               if(op ==0)
               {
                  alert("Please select Operator name.");
                  $("#operators").focus();
                   return false;
               }
			    if(routes ==0)
               {
                  alert("Please select route.");
                  $("#routes").focus();
                   return false;
               }
			    if(stops ==0)
               {
                  alert("Please select number of stages.");
                  $("#stops").focus();
                   return false;
               }
			   
			   for(var i=1; i<=stops;i++)
			   {
				  if($("#stage"+i).val()==0)
				  {
				  alert("Please select stage");
                  $("#stage"+i).focus();
                   return false;
				  }
			   }
			   
			  return true;
             
          }
        
         
         
		 
               
        </script>
    </head>
    
    
<h1 align="center" style="font-size: 18px;">Define stage  Order</h1>
<body >
     <?php echo form_open("master_control/saveStageOrder",array('onsubmit' => 'return validate()')); ?>
    <table align='center' style='margin: 0px auto;'>
	 <tr>
                <td  height="29" class="space" style="border-bottom:#f2f2f2 solid 1px;"></td>
                <td height="29" align="center" class="label" style="padding-left:15px;font-size:14px">Select Operator : </td>
                <td align="center" ><?php $op_id = 'id="operators" style="width:150px; font-size:12px" ';
                echo form_dropdown('operators', $operators, "", $op_id);
                ?></td>
                <td>&nbsp;</td>
            </tr>
			 <tr>
                <td  height="29" class="space" style="border-bottom:#f2f2f2 solid 1px;"></td>
                <td height="29" align="center" class="label" style="padding-left:15px;font-size:14px">Select Route : </td>
                <td align="center" ><?php $op_id = 'id="routes" style="width:150px; font-size:12px" ';
                echo form_dropdown('routes', $routes, "", $op_id);
                ?></td>
                <td>&nbsp;</td>
            </tr>
			 <tr>
                <td  height="29" class="space" style="border-bottom:#f2f2f2 solid 1px;"></td>
                <td height="29" align="center" class="label" style="padding-left:15px;font-size:14px">Number of stops : </td>
                <td align="center" ><?php $op_id = 'id="stops" style="width:150px; font-size:12px" onchange="getStages();"';
                echo form_dropdown('stops', $stops, "", $op_id);
                ?></td>
                <td>&nbsp;</td>
            </tr>
    
    </table>
  <div id="response" style=" margin-right: auto; margin-left: auto; width: 800px; "> </div>
    <input type='submit' value='Save' name= 'Insert' id='Insert' onClick="display();" style='display:none' />
</body>    
