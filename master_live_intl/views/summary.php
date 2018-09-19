<html> 
    <head>
        <script src="<?php echo base_url("js/jquery-1.5.2.min.js");?>" type="text/javascript"></script>
        <script>
         $(document).ready(function(){
          $.post("sum",{},function(res)
          {
           $('#sp').html(res);   
          });
        
     });     
        
        
        </script>
    </head>
    <body>
        <span id="sp"> </span>
    </body>
</html>
            