<html>
    <head>
        <title>Cities list</title>
        <script src="<?php echo base_url("js/jquery-1.5.2.min.js");?>" type="text/javascript"></script>
        
    </head>
    <script>
        
        function validate()
          {
            var text = $("#text").val();
               if(text ==="")
               {
                    alert("Please Provide Your New Country name");
                     $("#text").focus();
                     return false;
               }
              
          }
         function funedit()
         {
            document.getElementById('txt1').style.display= "block"; 
            var li=$('#list').val();
            $('#txt1').val(li);
            document.getElementById('update').style.display= "block";
            
            
         }
         
         $(document).ready(function(){
           $('#list').change(function(){
           document.getElementById('txt1').style.display= "none"; 
           $('#txt1').val('');
           document.getElementById('update').style.display= "none";
           }); 
           document.getElementById("text").style.display= "none"; 
           document.getElementById('Insert').style.display= "none";
         });
          
         function updt()
          {
            var t=$('#txt1').val(); 
            var list=$('#list').val(); 
            if(t =="")
               {
                    alert("Please Provide Your Country name");
                    $("#txt1").focus();
                    return false;
               }
            $.post("updatecountry",{new:t,old:list},function(res){
                 if(res==1)
                  {
                    document.getElementById('txt1').style.display= "none"; 
                    $('#txt1').val('');
                    document.getElementById('update').style.display= "none";
                    $('#spn').html("Successfully Updated.."); 
                    setTimeout('window.location = "add_country"',2000);
                  }
                  else{
                    $('#spn').html("problem while updating..");     
                  }
            });
          }
          
          function funadd()
         {
          
          document.getElementById("text").style.display= "block"; 
          document.getElementById('Insert').style.display= "block";
         }
		 
		 
               
        </script>
    </head>
    
    
<h1 align="center" style="font-size: 18px;">Countries</h1>
<body>
     <?php echo form_open("master_control/addcountry",array('onsubmit' => 'return validate()')); ?>
    <table align='center' style='margin: 0px auto;'>
        <tr>
            <td style="font-size: 12px;">Countries:</td><td style="font-size: 12px;">
                <?php 
                $attributes = 'id="list"';
                //display the array in the model in dropdown list  
                echo form_dropdown('country_name',$country,'',$attributes);?>
                <input type='button' value='Edit' name= 'edit' id='edit'onclick='funedit();' />
                <input type='button' value='Add new country' name= 'add' id='add'onclick='funadd();' />
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type='text' id='txt1' name='txt1' size='40' value='<?php echo set_value("txt1"); ?>' style='display:none'/></td>
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
              <td><input type='submit' value='Insert' name= 'Insert' id='Insert' onClick="display();" style='display:none' />
        </tr>  
        <tr>
            <td colspan='2' align='center' id="spn"></td>
            
        </tr>
    </table>
   
    
</body>    
