<html>
    <head>
        <title>Create bus</title>
        <script src="<?php echo base_url("js/jquery-1.5.2.min.js");?>" type="text/javascript"></script>
        <script>
            
            function validate()
          {
            var text = $("#text").val();
			var text1 = $("#text1").val();
               if(text ==="")
               {
                    alert("Please Provide Your New Bus model name");
                     $("#text").focus();
                     return false;
               }
			   else if(text1==0){
			   alert("Please select Your New Seat type");
                     $("#text1").focus();
                     return false;
			   }
              
          }
         function funedit()
         {
            document.getElementById('txt1').style.display= "block"; 
            var li=$('#list').val();
            $('#txt1').val(li);
			document.getElementById('txt2').style.display= "block";
			$('#txt2').val();
            document.getElementById('update').style.display= "block";
            
         }
         
         $(document).ready(function(){
           $('#list').change(function(){
           document.getElementById('txt1').style.display= "none";	    
           $('#txt1').val('');
		   
           document.getElementById('update').style.display= "none";
           });   
         });
          
         function updt()
          {
            var t1=$('#txt1').val(); 
			var t2=$('#txt2').val();
            var list=$('#list').val(); 
           
               if(t1 =="")
                  {
                     alert("Please Provide Your Bus model name");
                     $("#txt1").focus();
                     return false;
                  }
				  else if(t2==0){
			   alert("Please select Your New Seat type");
                     $("#txt2").focus();
                     return false;
			        }
			   
				 else { 
            $.post('updatemodel',{n:t1,old:list,type:t2},function(res)
			{
			
                 if(res==1)
                  {
                    document.getElementById('txt1').style.display= "none"; 
                    $('#txt1').val('');
                    document.getElementById('update').style.display= "none";
                    
                    $('#spn').html("Updated..");
                    setTimeout('window.location = "bus_model"',2000);
                  }
                  else{
                    $('#spn').html("problem while updating..");     
                  }
            });
			}
          }
          
          function funadd()
         {
          
          document.getElementById("text").style.display= "block";
		  document.getElementById("text1").style.display= "block"; 
          document.getElementById('Insert').style.display= "block";
         }
         
          
          
                  
        </script>
    </head>
    
    
<h1 align="center" style="font-size: 18px;">Bus models</h1>
<body>
     <?php echo form_open("master_control/addmodel",array('onsubmit' => 'return validate()')); ?>
    <table align='center' style='margin: 0px auto;'>
        <tr>
            <td style="font-size: 12px;">Bus model:</td><td style="font-size: 12px;">
                <?php 
                $attributes = 'id="list"';
				//display the array in the model in dropdown list  
                echo form_dropdown('model',$buses_model,'',$attributes);
				
				?>
                <input type='button' value='Edit' name= 'edit' id='edit'onclick='funedit();' />
                <input type='button' value='Add bus model' name= 'add' id='add'onclick='funadd();' />
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type='text' id='txt1' name='txt1' size='40' value='<?php echo set_value("txt1"); ?>' style='display:none'/></td>
        </tr>
		<tr>
            <td></td>
            <td><select name="txt2" id="txt2" style='display:none'>
			    <option value='0'>--select--</option>
			    <option value='1'>sleeper</option>
                <option value='2'>seater</option>
				<option value='3'>seatersleeper</option>
				</select></td>
        </tr>
		
        <tr>
            <td colspan='1' align='center'></td>
            <td ><input type='button' value='Update' name= 'update' id='update' style='display:none' onClick="updt();"/></td>
        </tr>
        <tr>
            <td></td>
            <td><input type='text' id='text' name='text' size='40' value='<?php echo set_value("text"); ?>' style='display:none'/></td>
        </tr>
		<tr>
            <td></td>
            <td><select name="text1" id="text1" style='display:none'>
			    <option value='0'>--select--</option>
			    <option value='1'>sleeper</option>
                <option value='2'>seater</option>
				<option value='3'>seatersleeper</option>
				</select></td>
        </tr>
		
        <tr>
              <td></td>
              <td><input type='submit' value='Insert' name= 'Insert' id='Insert' style='display:none' />
        </tr>  
        <tr>
            <td colspan='2' align='center' id="spn"></td>
            
        </tr>
    </table>
 
    
</body>    
</html>