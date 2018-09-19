<html> 
    <head>
	<style type="text/css">
	a
	{
		text-decoration:none;
		color:#CC0000;
	}
	space
	{
		padding-left:10px;
	}
	</style>		
        <script src="<?php echo base_url("js/jquery-1.5.2.min.js");?>" type="text/javascript"></script>
        <script>
        	$(document).ready(function()
			{
          		$.post("dashboard1",{},function(res)
          		{           			
					$('#sp').html(res);   
          		});        
	     	});
			
			function TicketReport(travel_id,operator_agent_type)
        	{         		         
          		window.open('TicketReport?travel_id='+travel_id+'&operator_agent_type='+operator_agent_type);
          	}                     
        </script>
    </head>
    <body>
        <span id="sp"> </span>
    </body>
</html>

