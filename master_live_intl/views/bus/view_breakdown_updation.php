
<link rel="stylesheet" href="<?php echo base_url("css/table_ebs.css") ?>" type="text/css" />

<link rel="stylesheet" href="<?php echo base_url("css/createbus_css.css") ?>" type="text/css" />

<link href="<?php echo base_url("css/datepicker/jquery-ui.css"); ?>" rel="stylesheet" type="text/css"/>
<table width="73%" border="0" align="center" cellspacing="0" cellpadding="0">
    <tr>
        <th  height="40" colspan="5" align="left" style="border-bottom:#f2f2f2 solid 1px; padding-left:10px;">View cancelled services </th>
    </tr>
    <tr>
        <td>&nbsp;</th>
        <td>&nbsp;</th>
        <td>&nbsp;</th>
        <td>&nbsp;</th>
        <td>&nbsp;</th>
    </tr>
    <tr style=" font-weight:bold" >
        <td  width='100' height="30" class="space">Service No.</th>
        <td  width='80' class="space">From</th>
        <td  width='80' class="space">To</th>
        <td  width='130' class="space">Current Date</th>
        <td  width='100' class="space">Breakdown Date</th>
    </tr>



    <?php
    $i = 1;
    foreach ($query as $rows) {
        //$class = ($i%2 == 0)? 'bg': 'bg1';
        echo "<tr class='$class' >
                <td class='space'>$rows->service_num</td>
                <td class='space'>$rows->from_name</td>
                <td class='space'>$rows->to_name</td>
                <td class='space'>$rows->current_date</td>
                <td class='space'>$rows->breakdown_date</td>
                </tr>";
        $i++;
    }

    echo "<div class='pagination' style='text-align:center'>";
    echo $links;
    echo '</div>';
    ?>
</table>