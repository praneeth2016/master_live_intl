<script type ="text/javascript" src="<?php echo base_url();?>js/datepicker/jquery-1.7.2.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" media="screen" />
<script>
function cancelTerm_OfOperator()
{
    var traid=$("#opname").val();
    $.post('get_cancelTerm_OfOperator',{traid:traid},function(res){
      if(res==0)
         $("#canterms").html("<span style='color:red' align='center'> No Cancellation Terms for selected operator</span>");   
      else
       $("#canterms").html(res);       
    });
}
</script>
<table align="center"><tr><td>
            Select operator Name:<?php 
            $id1='id="opname"';
            echo form_dropdown('opname',$opname,'',$id1);?>
        </td><td><input type="button" value="submit" onclick="cancelTerm_OfOperator()"></td></tr></table>
<br><br/>
<span id="canterms"> </span>