<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Summary</title>

</style>

        <script src="<?php echo base_url("js/jquery-1.5.2.min.js");?>" type="text/javascript"></script>
       
            <script>
         $(document).ready(function(){
          getDetails();
     });     
        
        
        </script>
           <script>  
         function getDetails(){ 
          var list=$('#list').val();
          //alert(list);
          if(list=='te' || list=='1')
              {
                $.post("ShowApiData",{list:list},function(res)
                  {
                      //alert(res);
                   $('#sp2').html(res);
                   $('#uq1').hide();
                   $('#sp3').hide(); 
                  });  
              }
              
            else if(list=='op')
              {
               
               $.post("ShowApioperators",{list:list},function(res)
               {
               
               $('#uq1').show();
               $('#sp3').html(res);
               $('#sp3').show();
               });
               
               $.post("ShowApiData",{list:list},function(res)
                  {
                   $('#sp2').html(res);
                   $('#uq1').show();
                   $('#sp2').show(); 
                  });
           
         }
         } 
         
         function agentlist(){
           var operator=$('#operator').val();
             var list=$('#list').val();
           
             if(list=='op')
                 {
             $.post("ShowOpdetail",{list:list,operator:operator},function(res)
                  {
                   $('#uq1').show();
                   $('#sp2').html(res);
                   $('#sp2').show();
                  });
               
         }  
         
         }
         
        

        
        </script>
</head>
    <body>
        <h4 align='center'>API Agents</h4>
        
        <table style="margin: 0px auto;" width="650" border="0">
            <tr>
                <td style="font-size: 12px" align="right">API Agent Type:</td>
                <td>
                    <select id="list" onChange="getDetails()">
                        <option value="1">All</option>
                        <option value="te">Ticket Engine</option>
                        <option value="op">Operator</option>
                    </select>
                </td>
            </tr>
            
        </table>
        <table style="margin: 0px auto;" width="650" border="0">
            <tr>
                <td >
 <span style="font-size:12px; font-weight:bold; color:#747474;display:none;" id="uq1" >
             Select Operator Type  :</span><span id="sp3" ></span></td>
            </tr>
            
        </table> 
       
       <span id="sp2"></span>
</body>
</html>