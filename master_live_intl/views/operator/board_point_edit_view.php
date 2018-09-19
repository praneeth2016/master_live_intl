<?php 
foreach ($board as $row){
$id = $row->id;
$is_van = $row->is_van;
$service_num = $row->service_num;
$travel_id = $row->travel_id;
$city_id = $row->city_id;
$city_name = $row->city_name;
$board_or_drop_type = $row->board_or_drop_type;
$board_drop = $row->board_drop;
$board_time = $row->board_time;
$bpdp_id = $row->bpdp_id;
$contact = $row->contact;
$bus_no = $row->bus_no;
$timing = $row->timing;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
</head>

<body>
<form name="form1" method="post" action="<?php echo base_url('operator/getbplist_edit1/'); ?>">
<table width="50" border="0" cellspacing="1" cellpadding="1" align="center">
  <tr>
    <td colspan="2" align="center">Edit Boarding Points</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>is_van</td>
    <td align="center"><input type="text" name="is_van" id="is_van" value="<?php echo $is_van;?>"><input type="hidden" name="id" id="id" value="<?php echo $id;?>"></td>
  </tr>
  <tr>
    <td>service_num</td>
    <td><input type="text" name="ser_num" id="ser_num" value="<?php echo $service_num;?>"></td>
  </tr>
  <tr>
    <td>travel_id</td>
    <td><input type="text" name="trav_id" id="trav_id" value="<?php echo $travel_id;?>"></td>
  </tr>
  <tr>
    <td>city_id</td>
    <td><input type="text" name="cty_id" id="cty_id" value="<?php echo $city_id;?>"></td>
  </tr>
  <tr>
    <td>city_name</td>
    <td><input type="text" name="cty_nam" id="cty_nam" value="<?php echo $city_name;?>"></td>
  </tr>
  <tr>
    <td>board_or_drop_type</td>
    <td><input type="text" name="bdtyp" id="bdtyp" value="<?php echo $board_or_drop_type;?>"></td>
  </tr>
  <tr>
    <td>board_drop</td>
    <td><input type="text" name="bodp" id="bodp" value="<?php echo $board_drop;?>"></td>
  </tr>
  <tr>
    <td>board_time</td>
    <td><input type="text" name="bordtim" id="bordtim" value="<?php echo $board_time;?>"></td>
  </tr>
  <tr>
    <td>bpdp_id</td>
    <td><input type="text" name="bpdp_id" id="bpdp_id" value="<?php echo $bpdp_id;?>"></td>
  </tr>
  <tr>
    <td>contact</td>
    <td><input type="text" name="contact" id="contact" value="<?php echo $contact;?>"></td>
  </tr>
  <tr>
    <td>bus_no</td>
    <td><input type="text" name="bus_no" id="bus_no" value="<?php echo $bus_no;?>"></td>
  </tr>
  <tr>
    <td>timing</td>
    <td><input type="text" name="timing" id="timing" value="<?php echo $timing;?>"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  <td align="center"><input type="submit" name="update" id="update" value="Update"></td>
  </tr>
</table>
</form>
</body>
</html>
