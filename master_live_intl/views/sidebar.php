<?php
$id = $this->session->userdata('id');
/* $name=$this->session->userdata('name');
  $username=$this->session->userdata('username');
  $password=$this->session->userdata('password');
  $mobile_number=$this->session->userdata('mobile_number');
  $logged_in=$this->session->userdata('logged_in'); */
$dashboard = $this->session->userdata('dashboard');
$mgmt_opr = $this->session->userdata('mgmt_opr');
$operatons = $this->session->userdata('operatons');
$book_invent = $this->session->userdata('book_invent');
$mgmt_agents = $this->session->userdata('mgmt_agents');
$payments = $this->session->userdata('payments');
$occupancy = $this->session->userdata('occupancy');
$opr_check = $this->session->userdata('opr_check');
$track = $this->session->userdata('track');
$deposite = $this->session->userdata('deposite');
$history = $this->session->userdata('history');
$super_user = $this->session->userdata('super_user');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8"/>
        <title>Admin Panel</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/layout.css" type="text/css" media="screen" />
        <!--[if lt IE 9]>
                <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
                <![endif]-->
        <script src="<?php echo base_url("js/jquery-1.5.2.min.js"); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url("js/jquery.tablesorter.min.js"); ?>" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url("js/jquery.equalHeight.js"); ?>" ></script>
        <script type="text/javascript">
            $(document).ready(function ()
            {
                $(".tablesorter").tablesorter();
            }
            );
            $(document).ready(function () {

                //When page loads...
                $(".tab_content").hide(); //Hide all content
                $("ul.tabs li:first").addClass("active").show(); //Activate first tab
                $(".tab_content:first").show(); //Show first tab content

                //On Click Event
                $("ul.tabs li").click(function () {

                    $("ul.tabs li").removeClass("active"); //Remove any "active" class
                    $(this).addClass("active"); //Add "active" class to selected tab
                    $(".tab_content").hide(); //Hide all tab content

                    var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
                    $(activeTab).fadeIn(); //Fade in the active ID content
                    return false;
                });

            });
        </script>
        <script type="text/javascript">
            $(function () {
                $('.column').equalHeight();
            });
        </script>
    </head>
    <body>
        <aside id="sidebar" class="column">
            <?php
            if ($dashboard == '1') {
                ?>
                <h3>Dashboard</h3>
                <ul class="toggle">
                    <li class="icn_categories"><?php echo anchor('operator/dashboard', 'Dashboard'); ?></li>
                    <li class="icn_categories"><?php echo anchor('operator/month_booking', 'Month Booking'); ?></li>
                </ul>
                <?php
            }
            if ($mgmt_opr == '1') {
                ?>
                <h3>Manage Operators</h3>
                <ul class="toggle">
                    <li class="icn_categories"><?php echo anchor('master_control/summary_op', 'Summary'); ?></li>
                    <li class="icn_view_users"><?php echo anchor('master_control/view_all', 'View All'); ?></li>
                    <li class="icn_profile"><?php echo anchor('master_control/active_operator', 'Active'); ?></li>
                    <li class="icn_add_user"><?php echo anchor('master_control/Pend_operator', 'Inactive'); ?></li>
                </ul>
                <?php
            }
            if ($operatons == '1') {
                ?>
                <h3>Operations</h3>
                <ul class="toggle">
                    <li class="icn_settings"><?php echo anchor('operator/opr_reg', 'Operator Registration'); ?></li>
                    <li class="icn_settings"><?php echo anchor('operator/opr_edit', 'UPDATE Operator'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/bus_model', 'Bus model'); ?></li>
					<li class="icn_settings"><?php echo anchor('master_control/add_country', 'Country'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/load_city_view', 'Cities'); ?></li>
					<li class="icn_settings"><?php //echo anchor('master_control/load_stageorder_view', 'Stage Order'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/bus_type', 'Bus type'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/seat_arr', 'Seating arrangement'); ?></li>
                    <li class="icn_settings"><?php echo anchor('operator/layout', 'New Layout'); ?></li>
                    <li class="icn_settings"><?php echo anchor('operator/board_drop_list', 'Board_Drop Point(Master)'); ?></li>
                    <li class="icn_settings"><?php echo anchor('operator/boardpoint_edit', 'boarding points'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/operator_commission', 'Operator Commission'); ?></li>
					<li class="icn_settings"><?php echo anchor('operator/terms_conditions', 'Operator Terms & Conditions'); ?></li>
                </ul>
                <?php
            }
            if ($super_user == '1') {
                ?>
                <h3>Bus Management</h3>
                <ul class="toggle">
                    <li class="icn_settings"><?php echo anchor('createbus_new/createBus', 'Create Bus'); ?></li>
                    <li class="icn_settings"><?php echo anchor('createbus/dispServicesList', 'Active/Deactive'); ?></li>
                    <li class="icn_settings"><?php echo anchor('createbus/modify_bus', 'Modify Bus'); ?></li>
                    <li class="icn_settings"><?php echo anchor('createbus/dispDeleteServicesList', 'Delete Bus'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/operator_Special_Service', 'Special Service'); ?></li>
                    <li class="icn_settings"><?php echo anchor('createbus_new/pakage', 'Update Pkg Details'); ?></li>
                </ul>
                <h3>Seat Management</h3>
                <ul class="toggle">
                    <li class="icn_settings"><?php echo anchor('createbus/changepricing_home', 'Change Pricing'); ?></li>
                    <li class="icn_settings"><?php echo anchor('quota_updation_controller/grabAndRelease', 'Grab Release'); ?></li>
                    <li class="icn_settings"><?php echo anchor('changedfare/changefare', 'Individual Seat Fare'); ?></li>
                    <li class="icn_settings"><?php echo anchor('quota_updation_controller/quota_update', 'Quota Updation'); ?></li>
                    <li class="icn_settings"><?php echo anchor('createbus/breakdown_view', 'Cancel Service'); ?></li>
                </ul>
                <h3> MISCELLANEOUS </h3>
                <ul class="toggle">
                    <li class="icn_settings"><?php echo anchor('operator/discount', 'Discount'); ?></li>
                    <li class="icn_settings"><?php echo anchor('operator/convenience_charge', 'Convenience Charge'); ?></li>
                    <li class="icn_settings"><?php echo anchor('operator/cancellation_sms', 'Cancellation SMS'); ?></li>
                    <li class="icn_settings"><?php echo anchor('operator/reactive_bus', 'Reactive Bus'); ?></li>
                    <li class="icn_settings"><?php echo anchor('operator/terms', 'Cancellation Terms'); ?></li>
                    <li class="icn_settings"><?php echo anchor('operator/url_routing', 'URL Routing'); ?></li>
                    <li class="icn_settings"><?php echo anchor('operator/promocode', 'Promo Codes'); ?></li>
                    <li class="icn_settings"><?php echo anchor('operator/update_vehicalasign', 'Update Vehical Asign'); ?></li>
                </ul>
                <?php
            }
            if ($book_invent == '1') {
                ?>
                <h3>Booking inventory</h3>
                <ul class="toggle">
                    <li class="icn_settings"><?php echo anchor('master_control/summary_records', 'Summary'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/generateReport', 'Detail reports'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/generatebillReport', 'Billing reports'); ?></li>
                </ul>
                <?php
            }
            if ($mgmt_agents == '1') {
                ?>
                <h3>Manage Agents</h3>
                <ul class="toggle">
                    <li class="icn_settings"><?php echo anchor('master_control/Add_gents', 'ADD Agents'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/api_agents', 'API Agents'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/inhouse_agents', 'Branch'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/prepaid_agents', 'Prepaid agents'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/postpaid_agents', 'Postpaid agents'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/te_agents', 'Ticket Engine agents'); ?></li>
                </ul>
                <?php
            }
            if ($payments == '1') {
                ?>
                <h3>Payments</h3>
                <ul class="toggle">
                    <li class="icn_settings"><?php echo anchor('master_control/BillingCollect', 'Billing'); ?></li>
                    <li class="icn_settings"><?php echo anchor('recharge/recharge_type', 'Recharge'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/updatePayment', 'Update Payment'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/refundCancelAmount', 'Online Refund'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/refundServiceCancel', 'Service Cancellation Refund'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/sendsms', 'Send SMS'); ?></li>
                </ul>
                <?php
            }
            if ($occupancy == '1') {
                ?>
                <h3>Occupancy</h3>
                <ul class="toggle">
                    <li class="icn_settings"><?php echo anchor('master_control/Operator_wise_Data', 'Operator wise Analysis'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/route_wise_Data', 'Route wise Analysis'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/BusType_wise_analysis', 'Bustype wise Analysis'); ?></li>
                </ul>
                <?php
            }
            if ($opr_check == '1') {
                ?>
                <h3>Operator Checkout</h3>
                <ul class="toggle">
                    <li class="icn_settings"><?php echo anchor('master_control/Operator_Service', 'Service'); ?></li>

                    <li class="icn_settings"><?php echo anchor('master_control/Operator_Service_cancelTerm', 'Cancellation Terms'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/update_contact_number', 'Update API SMS Contact Number'); ?></li>
					<li class="icn_settings"><?php echo anchor('master_control/add_service_sms_contact', 'Add Service Contact Number'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/update_cancel_sms_number', 'Update Cancel SMS Contact Number'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/mail_farmat', 'Mail Format'); ?></li>
                </ul>
                <?php
            }
            if ($track == '1') {
                ?>
                <h3>Tracking</h3>
                <ul class="toggle">
                    <li class="icn_settings"><?php echo anchor('master_control/apiproceedDetail', 'API Proceed Details'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/proceedDetail', 'Proceed Details'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/bookingDetail', 'Booking Details'); ?></li>
                    <li class="icn_settings"><?php echo anchor('master_control/response_logs', 'response_logs'); ?></li>
                    <?php
                }
                if ($deposite == '1') {
                    ?>
                    <h3>Deposit</h3>
                    <ul class="toggle">
                        <li class="icn_settings"><?php echo anchor('master_control/depositHistory', 'Deposit History'); ?></li>
                    </ul>
                    <?php
                }
                if ($history == '1') {
                    ?>
                    <h3>History</h3>
                    <ul class="toggle">
                        <li class="icn_settings"><?php echo anchor('master_control/api_sms_history', 'API SMS'); ?></li>
                        <li class="icn_settings"><?php echo anchor('master_control/grab_rels_history', 'Grab And Release'); ?></li>
                        <li class="icn_settings"><a href="<?php echo base_url('master_control/quota_history'); ?>" target="_blank">Quota Updation</a></li>
                        <li class="icn_settings"><?php echo anchor('master_control/citrus_resp', 'Citrus responce'); ?></li>
                        <li class="icn_settings"><?php echo anchor('master_control/agent_topup', 'Agent Top-up'); ?></li>
                        <li class="icn_settings"><?php echo anchor('master_control/vihical_asign', 'Vehical Assignment'); ?></li>
                    </ul>
                    <?php
                }
                ?>
                <footer>
                    <hr />
                    <p><strong>Copyright &copy; 2011 Ticket Engine</strong></p>
                </footer>
        </aside>
    </body>
</html>
