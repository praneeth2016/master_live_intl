<html>
    <head>
        <title>Create bus</title>
        <script src="<?php echo base_url("js/jquery-1.5.2.min.js");?>" type="text/javascript"></script>
        <script>
            function validate()
          {
            var text = $("#text").val();
               if(text ==="")
               {
                    alert("Please Provide Your New Bus type");
                     $("#text").focus();
                     return false;
               }
              
          }
          
          function funedit()
          {
            document.getElementById('bustxt').style.display= "block"; 
            var li=$('#list').val();
            $('#bustxt').val(li);
            document.getElementById('update').style.display= "block";
          }
          
          $(document).ready(function(){
           $('#list').change(function(){
           document.getElementById('bustxt').style.display= "none"; 
           $('#bustxt').val('');
           document.getElementById('update').style.display= "none";
           });   
         });
         
         function funupdate()
          {
            var t=$('#bustxt').val(); 
            var list=$('#list').val(); 
           
               if(t =="")
                  {
                     alert("Please Provide Your Bus type");
                     $("#bustxt").focus();
                     return false;
                  }
            $.post("updatebustype",{new:t,old:list},function(res){
                 if(res==1)
                  {
                    document.getElementById('bustxt').style.display= "none"; 
                    $('#bustxt').val('');
                    document.getElementById('update').style.display= "none";
                    
                    $('#spn').html("Updated..");
                    setTimeout('window.location = "bus_type"',2000);
                  }
                  else{
                    $('#spn').html("problem while updating..");     
                  }
            });
          }
          
          function funadd()
         {
          
          document.getElementById("text").style.display= "block"; 
          document.getElementById('insert').style.display= "block";
         }
          
          </script>
    </head>
    
    
<h1 align="center" style="font-size: 18px;">Bus type</h1>
<body>
     <?php echo form_open("master_control/addbus",array('onsubmit' => 'return validate()')); ?>
      <table align='center' style='margin: 0px auto;'>
        <tr>
            <td style="font-size: 12px;">Bus type:</td><td style="font-size: 12px;">
                <?php 
                $attributes = 'id="list"';
                //display the array in the model in dropdown list  
                echo form_dropdown('bus_type',$bus_type,'',$attributes);?>
                <input type='button' value='Edit' name= 'edit' id='edit' onclick='funedit();' />
                <input type='button' value='Add bus type' name= 'add' id='add' onclick='funadd();' />
             </td>
        </tr>
        <tr>
            <td></td>
            <td><input type='text' id='bustxt' name='bustxt' size='20' value='<?php echo set_value("bustxt"); ?>' style='display:none'/></td>
        </tr>
        <tr>
            <td colspan='1' align='center'></td>
            <td ><input type='button' value='Update' name= 'update' id='update' style='display:none' onclick='funupdate();'/></td>
        </tr>
        <tr>
            <td></td>
            <td><input type='text' id='text' name='text' size='40' value='<?php echo set_value("text"); ?>' style='display:none'/></td>
        </tr>
        <tr>
              <td></td>
              <td><input type='submit' value='Insert' name= 'insert' id='insert' style='display:none' />
        </tr>  
        <tr>
            <td colspan='2' align='center' id="spn"></td>
            
        </tr>
    </table>
   
    
</body> 
<?php echo form_close();?>
</html>