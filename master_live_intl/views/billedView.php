<script src="<?php echo base_url("js/jquery-1.5.2.min.js");?>" type="text/javascript"></script>
<script>
function getBilled(){
   var bill=$('#bill').val();
    $.post('getBilledValue',{bill:bill},function(res){
      
        //alert(res);
        if(res==0)
        {
       $('#nobill').show() ; 
        $('#billed').html("") ;   
        }
       else{
       $('#billed').html(res) ; 
        $('#nobill').hide() ; 
          }
        
    });
    
}



</script>

<script type="text/javascript">

    function getprint(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>my div</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>
 





<style>
.bg {background-color:#ffffff;
font-family: Arial, Helvetica, sans-serif; font-size:12px;
}
.bg1 {background-color:#eff3f5;
font-family: Arial, Helvetica, sans-serif; font-size:12px;
}
</style>
<table align="center">
    <tr><td> Billing Type:<?php 
    $id1='id="bill"';
    $bill=array('all'=>'All','bus'=>'bus','ticket'=>'ticket');
    echo form_dropdown('bill',$bill,'',$id1);?></td><td> <input type='button' value='submit' onclick="getBilled()"></td></tr>
</table>
<table><tr><td id="nobill" style="display:none;color:red" ><span style='padding-left:288px'> No Records Found</span></td></tr></table>
<span id="billed"> </span>
