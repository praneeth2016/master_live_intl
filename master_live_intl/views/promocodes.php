<link href="<?php echo base_url('css/jquery-ui.css'); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url('js/jquery-ui.js'); ?>"></script>
<script>
    function getpromos() {
        var opid = $('#operator').val();		
        $.post('getpromo1', {opid: opid}, function (res) {
            //alert(res);
            $('#promo_list').html(res);

        });

    }



</script>
<table  border="0" cellpadding="0" cellspacing="0" align="center" width="60%">
	<tr>
		<td height="30" class="space" style="border-bottom:#f2f2f2 solid 1px;"><strong>Promo codes </strong></td>
	</tr>
	<tr>
		<td height="30" align="right" valign="middle"><a href="<?php echo base_url('operator/add_promocode');?>">Add New Promo code</a></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td height="35" align="right" class="size">Operator</td>
					<td align="center"><strong>:</strong></td>
					<td><?php
                        $js = 'id="operator" onchange="getpromos()"';
                        echo form_dropdown('operator', $operators, '', $js);
                        ?>
					</td>
				</tr>
			</table></td>
	</tr>
	<tr>
		<td id="promo_list">&nbsp;</td>
	</tr>
</table>
