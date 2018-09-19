<?php

class changedfare1 extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->database();
    }

    public function getSericeNumbers() {
        $travel_id = $this->session->userdata('travel_id');

        $sql = mysql_query("select distinct service_num,service_name  from  master_buses where travel_id='$travel_id' and status='1'") or die(mysql_error());
        return $sql;
    }

    public function getRoutesFromDb($travel_id, $service_num, $service_name, $service_route, $city_id) {
        $city_id1 = explode("-", $city_id);

        $this->db->distinct();
        $this->db->where('travel_id', $travel_id);
        $this->db->where('service_num', $service_num);
        $this->db->where('from_id', $city_id1[0]);
        $this->db->where('to_id', $city_id1[1]);
        $query = $this->db->get('master_buses');

        return $query;
    }

    public function getfaresFromDb($travel_id, $service_num, $service_route, $current_date, $from_id, $to_id) {
        $service_route1 = explode(" To ", $service_route);

        $this->db->distinct();
        $this->db->where('travel_id', $travel_id);
        $this->db->where('service_num', $service_num);
        $this->db->where('from_id', $from_id);
        $this->db->where('to_id', $to_id);
        $this->db->where('journey_date', $current_date);
        $query = $this->db->get('buses_list');

        return $query;
    }

    public function getroute1($service_num,$opid) {
        $travel_id = $opid;


        $this->db->distinct();
        $this->db->where('travel_id', $travel_id);
        $this->db->where('service_num', $service_num);
        $query = $this->db->get('master_buses');
        echo '<select id="service_route" class="inputfield">
	      <option value="">-- Select Service Route --</option>';

        foreach ($query->result() as $rows) {
            echo '<option value="' . $rows->from_id . '-' . $rows->to_id . '">' . $rows->service_route . '</option>';
        }
        echo '</select>';
    }

    public function getroute2($service_num, $city_id,$travel_id) {
        $travel_id = $travel_id;
        $city_id1 = explode('-', $city_id);
        $this->db->distinct();
        $this->db->where('travel_id', $travel_id);
        $this->db->where('from_id', $city_id1[0]);
        $this->db->where('to_id', $city_id1[1]);
        $this->db->where('service_num', $service_num);
        $query = $this->db->get('master_buses');
        echo '<select id="service_route2" class="inputfield">
	      <option value="">-- Select Service Route --</option>
		<option value="all">All</option>';

        foreach ($query->result() as $rows) {
            echo '<option value="' . $rows->from_id . '-' . $rows->to_id . '">' . $rows->service_route . '</option>';
        }
        echo '</select>';
    }

    public function addnewfare1() {
        $bus_type = $this->input->post('bus_type');
        $service_num = $this->input->post('service_num');
        $travel_id = $this->input->post('travel_id');
        $lower_seat_no = $this->input->post('lower_seat_no');
        $upper_seat_no = $this->input->post('upper_seat_no');
        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');
        $price_mode = $this->input->post('price_mode');
        $from_id = $this->input->post('from_id');
        $from_name = $this->input->post('from_name');
        $to_id = $this->input->post('to_id');
        $to_name = $this->input->post('to_name');
        $service_route2 = $this->input->post('service_route2');
        $city_id = $this->input->post('city_id');

        //echo $from_id."".$from_name."".$to_id."".$to_name."".$service_route2."".$city_id;
        //echo $fdate."#".$tdate;
        //echo $bus_type."&".$service_num."&".$travel_id."&".$sfare."&".$lfare."&".$ufare."&".$lower_rows."&".$lower_cols."&".$upper_rows."&".$upper_cols."&".$lower_seat_no."&".$upper_seat_no;						

        if ($service_route2 == "all") {
            $sql = mysql_query("select * from master_price where service_num='$service_num' and travel_id='$travel_id' and journey_date is NULL");
            $count = mysql_num_rows($sql);
            $row = mysql_fetch_array($sql);

            $seat_fare = $row['seat_fare'];
            $lberth_fare = $row['lberth_fare'];
            $uberth_fare = $row['uberth_fare'];


            $sql3 = mysql_query("select * from master_buses where service_num='$service_num' and travel_id='$travel_id' and status='1'");
            while ($row3 = mysql_fetch_array($sql3)) {
                $from_id = $row3['from_id'];
                $from_name = $row3['from_name'];
                $to_id = $row3['to_id'];
                $to_name = $row3['to_name'];
                $service_route = $row3['service_route'];
                $service_name = $row3['service_name'];

                if ($bus_type == "seater") {
                    if ($price_mode == "permanently") {
                        if ($count > 0) {
                            $query = $this->db->query("update master_price set seat_fare_changed='$lower_seat_no' where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id'");
                        } else {
                            $sql5 = mysql_query("select * from master_buses where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id'");
                            $row5 = mysql_fetch_array($sql5);

                            $seat_fare = $row5['seat_fare'];



                            $query = mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,seat_fare,seat_fare_changed) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$seat_fare','$lower_seat_no')");
                        }
                    } else {
                        $query = $this->db->query("update buses_list set seat_fare_changed='$lower_seat_no' where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id' and journey_date between '$fdate' and '$tdate'");

                        while ($fdate <= $tdate) {
                            $sql4 = mysql_query("select * from master_price where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate' and from_id='$from_id' and to_id='$to_id'");
                            $count4 = mysql_num_rows($sql4);

                            if ($count4 > 0) {
                                $this->db->query("update master_price set seat_fare_changed='$lower_seat_no' where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate' and from_id='$from_id' and to_id='$to_id'");
                            } else {
                                if ($count > 0) {
                                    mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,seat_fare,seat_fare_changed,journey_date) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$seat_fare','$lower_seat_no','$fdate')");
                                } else {
                                    $sql5 = mysql_query("select * from buses_list where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate' and from_id='$from_id' and to_id='$to_id'");
                                    $row5 = mysql_fetch_array($sql5);

                                    $seat_fare = $row5['seat_fare'];
                                    $lberth_fare = $row5['lberth_fare'];
                                    $uberth_fare = $row5['uberth_fare'];

                                    mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,seat_fare,seat_fare_changed,journey_date) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$seat_fare','$lower_seat_no','$fdate')");
                                }
                            }
                            $date1 = strtotime("+1 day", strtotime($fdate));
                            $fdate = date("Y-m-d", $date1);
                        }
                    }
                } else { //sleeper or seater sleeper
                    $fdate1 = $fdate;
                    $tdate1 = $tdate;
                    /* if($lower_seat_no != "")
                      { */
                    if ($price_mode == "permanently") {
                        if ($count > 0) {
                            $query = $this->db->query("update master_price set lberth_fare_changed='$lower_seat_no',uberth_fare_changed='$upper_seat_no' where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id'");
                        } else {
                            $sql5 = mysql_query("select * from master_buses where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id'");
                            $row5 = mysql_fetch_array($sql5);

                            $seat_fare = $row5['seat_fare'];
                            $lberth_fare = $row5['lberth_fare'];
                            $uberth_fare = $row5['uberth_fare'];
                            $query = mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,lberth_fare,uberth_fare,lberth_fare_changed,uberth_fare_changed) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$lberth_fare','$uberth_fare','$lower_seat_no','$upper_seat_no')");
                        }
                    } else {
                        $query = $this->db->query("update buses_list set lberth_fare_changed='$lower_seat_no',uberth_fare_changed='$upper_seat_no' where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id' and journey_date between '$fdate' and '$tdate'");

                        while ($fdate1 <= $tdate1) {
                            $sql4 = mysql_query("select * from master_price where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate1' and from_id='$from_id' and to_id='$to_id'");
                            $count4 = mysql_num_rows($sql4);

                            if ($count4 > 0) {
                                $this->db->query("update master_price set lberth_fare_changed='$lower_seat_no',uberth_fare_changed='$upper_seat_no' where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate1' and from_id='$from_id' and to_id='$to_id'");
                            } else {
                                if ($count > 0) {
                                    mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,lberth_fare,uberth_fare,lberth_fare_changed,uberth_fare_changed,journey_date) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$lberth_fare','$uberth_fare','$lower_seat_no','$upper_seat_no','$fdate1')");
                                } else {
                                    $sql5 = mysql_query("select * from buses_list where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate1' and from_id='$from_id' and to_id='$to_id'");
                                    $row5 = mysql_fetch_array($sql5);

                                    $seat_fare = $row5['seat_fare'];
                                    $lberth_fare = $row5['lberth_fare'];
                                    $uberth_fare = $row5['uberth_fare'];

                                    mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,lberth_fare,uberth_fare,lberth_fare_changed,uberth_fare_changed,journey_date) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$lberth_fare','$uberth_fare','$lower_seat_no','$upper_seat_no','$fdate1')");
                                }
                            }
                            $date1 = strtotime("+1 day", strtotime($fdate1));
                            $fdate1 = date("Y-m-d", $date1);
                        }
                    }
                    /* }
                      if($upper_seat_no != "")
                      {
                      if($price_mode == "permanently")
                      {
                      if($count > 0)
                      {
                      $query = $this->db->query("update master_price set uberth_fare_changed='$upper_seat_no' where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id'");
                      }
                      else
                      {
                      $query = mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,uberth_fare_changed) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$upper_seat_no')");
                      }
                      }
                      else
                      {
                      $query = $this->db->query("update buses_list set uberth_fare_changed='$upper_seat_no' where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id' and journey_date between '$fdate' and '$tdate'");

                      $fdate2 = $fdate;
                      $tdate2 = $tdate;

                      while($fdate2 <= $tdate2)
                      {
                      $sql4 = mysql_query("select * from master_price where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate2' and from_id='$from_id' and to_id='$to_id'");
                      $count4 = mysql_num_rows($sql4);

                      if($count4 > 0)
                      {
                      $this->db->query("update master_price set uberth_fare_changed='$upper_seat_no' where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate2' and from_id='$from_id' and to_id='$to_id'");
                      }
                      else
                      {
                      if($count > 0)
                      {
                      mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,lberth_fare,uberth_fare,uberth_fare_changed,journey_date) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$lberth_fare','$uberth_fare','$upper_seat_no','$fdate2')");
                      }
                      else
                      {
                      $sql5 = mysql_query("select * from buses_list where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate2' and from_id='$from_id' and to_id='$to_id'");
                      $row5 = mysql_fetch_array($sql5);

                      $seat_fare = $row5['seat_fare'];
                      $lberth_fare = $row5['lberth_fare'];
                      $uberth_fare = $row5['uberth_fare'];

                      mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,lberth_fare,uberth_fare,uberth_fare_changed,journey_date) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$lberth_fare','$uberth_fare','$upper_seat_no','$fdate2')");
                      }
                      }
                      $date1 = strtotime("+1 day", strtotime($fdate2));
                      $fdate2 = date("Y-m-d", $date1);
                      }
                      }
                      } */
                }
            }
        } else { // update with individual route
            $sql = mysql_query("select * from master_price where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id'");
            $count = mysql_num_rows($sql);
            $row = mysql_fetch_array($sql);

            $seat_fare = $row['seat_fare'];
            $lberth_fare = $row['lberth_fare'];
            $uberth_fare = $row['uberth_fare'];

            $sql2 = mysql_query("select * from master_buses where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id'");
            $row2 = mysql_fetch_array($sql2);

            $service_route = $row2['service_route'];
            $service_name = $row2['service_name'];
            if ($bus_type == "seater") {
                if ($price_mode == "permanently") {
                    if ($count > 0) {
                        $query = $this->db->query("update master_price set seat_fare_changed='$lower_seat_no' where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id'");
                    } else {
                        $query = mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,seat_fare_changed) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$lower_seat_no')");
                    }
                } else {
                    $query = $this->db->query("update buses_list set seat_fare_changed='$lower_seat_no' where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id' and journey_date between '$fdate' and '$tdate'");

                    while ($fdate <= $tdate) {
                        $sql4 = mysql_query("select * from master_price where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate' and from_id='$from_id' and to_id='$to_id'");
                        $count4 = mysql_num_rows($sql4);

                        if ($count4 > 0) {
                            $this->db->query("update master_price set seat_fare_changed='$lower_seat_no' where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate' and from_id='$from_id' and to_id='$to_id'");
                        } else {
                            if ($count > 0) {
                                mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,seat_fare,seat_fare_changed,journey_date) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$seat_fare','$lower_seat_no','$fdate')");
                            } else {
                                $sql5 = mysql_query("select * from buses_list where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate' and from_id='$from_id' and to_id='$to_id'");
                                $row5 = mysql_fetch_array($sql5);

                                $seat_fare = $row5['seat_fare'];
                                $lberth_fare = $row5['lberth_fare'];
                                $uberth_fare = $row5['uberth_fare'];

                                mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,seat_fare,seat_fare_changed,journey_date) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$seat_fare','$lower_seat_no','$fdate')");
                            }
                        }
                        $date1 = strtotime("+1 day", strtotime($fdate));
                        $fdate = date("Y-m-d", $date1);
                    }
                }
            } else { // sleeper or sleeper seater
                if ($lower_seat_no != "") {
                    if ($price_mode == "permanently") {
                        if ($count > 0) {
                            $query = $this->db->query("update master_price set lberth_fare_changed='$lower_seat_no' where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id'");
                        } else {
                            $query = mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,lberth_fare_changed) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$lower_seat_no')");
                        }
                    } else {
                        $query = $this->db->query("update buses_list set lberth_fare_changed='$lower_seat_no' where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id' and journey_date between '$fdate' and '$tdate'");

                        $fdate1 = $fdate;
                        $tdate1 = $tdate;
                        while ($fdate1 <= $tdate1) {
                            $sql4 = mysql_query("select * from master_price where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate1' and from_id='$from_id' and to_id='$to_id'");
                            $count4 = mysql_num_rows($sql4);

                            if ($count4 > 0) {
                                $this->db->query("update master_price set lberth_fare_changed='$lower_seat_no' where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate1' and from_id='$from_id' and to_id='$to_id'");
                            } else {
                                if ($count > 0) {
                                    mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,lberth_fare,uberth_fare,lberth_fare_changed,journey_date) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$lberth_fare','$uberth_fare','$lower_seat_no','$fdate1')");
                                } else {
                                    $sql5 = mysql_query("select * from buses_list where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate1' and from_id='$from_id' and to_id='$to_id'");
                                    $row5 = mysql_fetch_array($sql5);

                                    $seat_fare = $row5['seat_fare'];
                                    $lberth_fare = $row5['lberth_fare'];
                                    $uberth_fare = $row5['uberth_fare'];

                                    mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,lberth_fare,uberth_fare,lberth_fare_changed,journey_date) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$lberth_fare','$uberth_fare','$lower_seat_no','$fdate1')");
                                }
                            }
                            $date1 = strtotime("+1 day", strtotime($fdate1));
                            $fdate1 = date("Y-m-d", $date1);
                        }
                    }
                }

                if ($upper_seat_no != "") {
                    if ($price_mode == "permanently") {
                        if ($count > 0) {
                            $query = $this->db->query("update master_price set uberth_fare_changed='$upper_seat_no' where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id'");
                        } else {
                            $query = mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,uberth_fare_changed) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$upper_seat_no')");
                        }
                    } else {
                        $query = $this->db->query("update buses_list set uberth_fare_changed='$upper_seat_no' where service_num='$service_num' and travel_id='$travel_id' and from_id='$from_id' and to_id='$to_id' and journey_date between '$fdate' and '$tdate'");

                        $fdate2 = $fdate;
                        $tdate2 = $tdate;
                        while ($fdate2 <= $tdate2) {
                            $sql4 = mysql_query("select * from master_price where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate2' and from_id='$from_id' and to_id='$to_id'");
                            $count4 = mysql_num_rows($sql4);

                            if ($count4 > 0) {
                                $this->db->query("update master_price set uberth_fare_changed='$upper_seat_no' where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate2' and from_id='$from_id' and to_id='$to_id'");
                            } else {
                                if ($count > 0) {
                                    mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,lberth_fare,uberth_fare,uberth_fare_changed,journey_date) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$lberth_fare','$uberth_fare','$upper_seat_no','$fdate2')");
                                } else {
                                    $sql5 = mysql_query("select * from buses_list where service_num='$service_num' and travel_id='$travel_id' and journey_date='$fdate2' and from_id='$from_id' and to_id='$to_id'");
                                    $row5 = mysql_fetch_array($sql5);

                                    $seat_fare = $row5['seat_fare'];
                                    $lberth_fare = $row5['lberth_fare'];
                                    $uberth_fare = $row5['uberth_fare'];

                                    mysql_query("insert into master_price(service_num,travel_id,from_id,from_name,to_id,to_name,service_route,service_name,lberth_fare,uberth_fare,uberth_fare_changed,journey_date) values('$service_num','$travel_id','$from_id','$from_name','$to_id','$to_name','$service_route','$service_name','$lberth_fare','$uberth_fare','$upper_seat_no','$fdate2')");
                                }
                            }
                            $date1 = strtotime("+1 day", strtotime($fdate2));
                            $fdate2 = date("Y-m-d", $date1);
                        }
                    }
                }
            }
        }
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function getservic_modify() {

        $travel_id = $this->input->post('opid');
        $this->db->distinct();
        $this->db->select('service_num');
		$this->db->select('service_name');
        $this->db->where('travel_id', $travel_id);
        $this->db->where('status', 1);
        $query = $this->db->get('master_buses');
        $list = '<option value="0">---Select---</option>';
        foreach ($query->result() as $res) {
         
            $list = $list . '<option value='.$res->service_num.'>'.$res->service_name.'('.$res->service_num.')</option>';
        
            
        }
        return $list;
    }

}
