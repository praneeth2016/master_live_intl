<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>operator</title>
<style>
#tbl
{
border-collapse:collapse;
}
#tbl, #td, #tb
{
border:#A4A4A4 solid 1px;
}
</style>
<script type ="text/javascript" src="<?php echo base_url();?>js/datepicker/jquery-1.7.2.min.js"></script>

<script>
   changeSummary(1); 
function changeSummary(i){
   
          $.post("book_summary",{i:i},function(res)
          {
           $('#sp1').html(res);   
          });
    
} 

$(document).ready(function(){
             
          $.post("Apioperators",{},function(res)
          {
           $('#sp').html(res);   
          });
        
     }); 
     
     function ChangeData(){
         
       var op=$('#operators').val();
       var i=$('#book1').val();
       if(op=='all')
           {
           changeSummary(i);  
           }
           else
               {
                $.post("ShowSummary",{op:op,i:i},function(res)
                  {
                   $('#sp1').html(res);   
                  });   
               }
     }
     
</script>

</head>
    
<body>
    <h4 align="center">Booking Summary</h4>
                       <br />
                       <table> 
         <td width="600" align="center" style="font-size:12px;">Select operator:
     <span id="sp"></span></td>
     </table>                  
    <table width="600" align="center">
                       <tr style="font-size:12px"><td width="220" colspan="8"><td>
                           <td><input type="radio" name="book" id="book1" value="1" checked  onclick="changeSummary(this.value)">Ticket</td>
                           <td><input type="radio" name="book" id="book1" value="2" onclick="changeSummary(this.value)">Value</td>
                        </tr>
                        </table>
     
         <div id="sp1">
             
         </div>
</body>
</html>
