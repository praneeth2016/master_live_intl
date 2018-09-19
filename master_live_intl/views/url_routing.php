
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
<script>
            
        function status(i,s,uid)
        {
            var r;
            if(s===1){
               r="Inactive";
			   }else {
			   r = "active";
			   }
           
          var con=confirm("Are you sure you want to " +r);
          if(con===true)
              {
              $.post("url_routing1",{status:s,id:uid},function(res){
                 //alert(res);
                 if(res ==1){
                     alert('status has been changed');
                     setTimeout('window.location = "url_routing"',100);
                 }
                 else
                     {
                     alert('status has not been changed');
                     setTimeout('window.location = "url_routing"',100);
                    
                     }
               }); 
              }
              else
                  {
                   return false; 
                  }
        }
        </script>
        
	</head>
                
<body>
</body>
</html>
<?php

echo "<table id='tbl' style='margin: 0px auto;' class='gridtable'  width='60%'>";
echo "<tr>";

echo "<th style='font-size:14px'>url</th>";
echo "<th style='font-size:14px'>Action</th>";

echo "</tr>";
$i=1;
foreach($urls as $row){
       $uid= $row->id;	
       $status= $row->status;
       if($status==1)
       {
        $x='Active';   
       }
       else if($status==0){
           
         $x='Inactive';  
       }
      
	echo "<tr>";     
	
	echo "<td style='font-size:12px';>". $row->url."</td>";		
        echo "<td class='space'><span style='cursor:pointer; font-weight:bold; font-size:12px; text-decoration:underline;' onclick='status(".$i.",".$status.",".$uid.")'>".$x."</span></td>";		
	echo "</tr>";
        $i++;
}
echo "</table>";

?>