<table width="730" style="font-size:13px">
    <tr>
        <td height="30" colspan="2" align="center">Boarding And Dropping Points</td>
    </tr>
    <tr>
        <td height="30" align="left">&nbsp;</td>
        <td height="30" align="right"><?php echo anchor('operator/board_drop', 'ADD', ''); ?></td>
    </tr>
    <tr>
        <td height="30" colspan="2" align="left">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:13px">
                <tr>
                    <td>&nbsp;</td>
                    <td height="30">City Id </td>
                    <td>City Name </td>
                    <td>Point Name </td>
                    <td>Point Type </td>
                    <td>Options</td>
                    <td>&nbsp;</td>
                </tr>
                <?php
                $i = 1;
                foreach ($list as $row) {
                    ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td height="30"><?php echo $row->city_id; ?></td>
                        <td><?php echo $row->city_name; ?></td>
                        <td><?php echo $row->board_drop; ?></td>
                        <td><?php echo $row->board_or_drop_type; ?></td>
                        <td><?php echo anchor('operator/board_drop_edit?id=' . $row->id, 'Edit', ''); ?>&nbsp;<?php echo anchor('operator/board_drop_delete?id=' . $row->id, 'Delete', ''); ?></td>
                        <td>&nbsp;</td>
                    </tr>      
                    <?php
                }
                ?>
                <tr>
                    <td>&nbsp;</td>
                    <td height="30">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td height="30" colspan="7" align="center">
                        <div class="pagination"><?php echo $links; ?></div>		</td>
                </tr>
            </table>
        </td>
    </tr>
</table>