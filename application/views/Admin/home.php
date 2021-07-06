<?php include('include/header.php'); ?>
<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- START PAGE SIDEBAR -->
    <?php include('include/left_side.php'); ?>
    <!-- END PAGE SIDEBAR -->

    <!-- PAGE CONTENT -->
    <div class="page-content">

        <?php include('include/top_nav.php'); ?>
        <!-- END X-NAVIGATION VERTICAL -->

        <!-- START BREADCRUMB -->
        <ul class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">Dashboard</li>
        </ul>
        <!-- END BREADCRUMB -->

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">

            <!-- START WIDGETS -->
            <div class="row" style="margin-bottom:30px">
                <?php
                    $user_ss = $this->beats_model->select_data('count(*) as newsos', 'user_signup', '', '', array('user_id', 'DESC'), '', '');
                    $officer_id_ss = $this->beats_model->select_data('count(*) as newsos', 'Officer', '', '', array('Officer_id', 'DESC'), '', '');
                ?>
                <div class="col-md-3">
                    <a href="Registeredusers">
                    <!-- START WIDGET MESSAGES -->
                    <div class="widget widget-default widget-item-icon">
                        <div class="widget-item-left">
                            <span class="fa fa-user"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count"><?php echo $user_ss[0]['newsos'] + $officer_id_ss[0]['newsos']; ?></div>
                            <div class="widget-title">Total Users</div>
                            <div class="widget-subtitle">of AB-SAS</div>
                        </div>
                    </div>
                    <!-- END WIDGET MESSAGES -->
                    </a>
                </div>
                <?php
                $total_ss = $this->beats_model->select_data('count(*) as newsos', 'SOSManagement', '', '', array('SOS_id', 'DESC'), '', '');
                ?>
                <div class="col-md-3">
                    <a href="SOSManagement">
                    <!-- START WIDGET MESSAGES -->
                    <div class="widget widget-default widget-item-icon">
                        <div class="widget-item-left">
                            <span class="fa fa-list"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count"><?php echo $total_ss[0]['newsos']; ?></div>
                            <div class="widget-title">Total SOS Reported</div>
                            <div class="widget-subtitle">Till now</div>
                        </div>
                    </div>
                    <!-- END WIDGET MESSAGES -->
                    </a>
                </div>

                <?php
                $data['nsresult0'] = $this->beats_model->select_data('count(*) as total', 'iWitness', '', '', array('iWitness_id', 'DESC'));
                $data['nsresult1'] = $this->beats_model->select_data('count(*) as total', 'Officer_Abuse', '', '', array('OfficerAbuse_id', 'DESC'));
                $data['nsresult2'] = $this->beats_model->select_data('count(*) as total', 'Commend_Officer', '', '', array('CommendOffice_id', 'DESC'));
                $data['nsresult3'] = $this->beats_model->select_data('count(*) as total', 'StolenVehicle_report', '', '', array('StolenVehicle_report_id', 'DESC'));
                $data['nsresult4'] = $this->beats_model->select_data('count(*) as total', 'Missing_Persons_report', '', '', array('Missing_Persons_report_id', 'DESC'));
                $data['nsresult5'] = $this->beats_model->select_data('count(*) as total', 'Lodgecomplaint_report', '', '', array('Lodgecomplaint_report_id', 'DESC'));
                $data['nsresult6'] = $this->beats_model->select_data('count(*) as total', 'Gun_Violence_report', '', '', array('GunViolence_id', 'DESC'));
                $data['nsresult7'] = $this->beats_model->select_data('count(*) as total', 'Drug_Abuse_report', '', '', array('DrugAbuse_report_id', 'DESC'));
                $data['nsresult8'] = $this->beats_model->select_data('count(*) as total', 'Domestic_Violence_report', '', '', array('DomesticViolence_report_id', 'DESC'));
                $data['nsresult9'] = $this->beats_model->select_data('count(*) as total', 'Terrorist_Attack_report', '', '', array('TerroristAttack_report_id', 'DESC'));
                $data['nsresult10'] = $this->beats_model->select_data('count(*) as total', 'Rape_report', '', '', array('Rape_report_id', 'DESC'));
                $data['nsresult11'] = $this->beats_model->select_data('count(*) as total', 'Kidnap_report', '', '', array('Kidnap_report_id', 'DESC'));
                $data['nsresult12'] = $this->beats_model->select_data('count(*) as total', 'Robbery_report', '', '', array('Robbery_report_id', 'DESC'));
                $data['nsresult13'] = $this->beats_model->select_data('count(*) as total', 'Burglary_report', '', '', array('Burglary_report_id', 'DESC'));
                $data['nsresult14'] = $this->beats_model->select_data('count(*) as total', 'CybercrimeFraud_report', '', '', array('CybercrimeFraud_report_id', 'DESC'));
                $data['nsresult15'] = $this->beats_model->select_data('count(*) as total', 'Submit_Tip_report', '', '', array('Submit_Tip_id', 'DESC'));
                $data['nsresult16'] = $this->beats_model->select_data('count(*) as total', 'Others_report', '', '', array('Others_report_id', 'DESC'));

                $data['nsresult17'] = $this->beats_model->select_data('count(*) as total', 'Vandalism_report', '', '', array('Vandalism_report_id', 'DESC'));
                $data['nsresult18'] = $this->beats_model->select_data('count(*) as total', 'Fire_report', '', '', array('Fire_report_id', 'DESC'));
                $data['nsresult19'] = $this->beats_model->select_data('count(*) as total', 'Accident_report', '', '', array('Accident_report_id', 'DESC'));
                $data['nsresult20'] = $this->beats_model->select_data('count(*) as total', 'Medical_report', '', '', array('Medical_report_id', 'DESC'));
                $data['nsresult21'] = $this->beats_model->select_data('count(*) as total', 'Riot_report', '', '', array('Riot_report_id', 'DESC'));
                $data['nsresult22'] = $this->beats_model->select_data('count(*) as total', 'Environmental_Hazard_report', '', '', array('Environmental_Hazard_report_id', 'DESC'));
                $data['nsresult23'] = $this->beats_model->select_data('count(*) as total', 'Child_Abuse_report', '', '', array('Child_Abuse_report_id', 'DESC'));
                $data['nsresult24'] = $this->beats_model->select_data('count(*) as total', 'Human_Trafficking_report', '', '', array('Human_Trafficking_report_id', 'DESC'));
                $data['nsresult25'] = $this->beats_model->select_data('count(*) as total', 'Blow_Whistle_report', '', '', array('Blow_Whistle_report_id', 'DESC'));

                $data['filedcategory'] = $this->beats_model->select_data('*', 'FiledReports_category');
                $rsdata = array();
                $total = 0;
                $i = 0;
                foreach ($data['filedcategory'] as $catr) {
                    $r = 'nsresult' . $i;
                    $ds = array(
                        'FiledReport_name' => $catr['FiledReport_name'],
                        'FiledReports_tablename' => $catr['FiledReports_tablename'],
                        'total' => $data[$r][0]['total']
                    );
                    array_push($rsdata, $ds);
                    $total = $total + $data[$r][0]['total'];

                    $i++;
                }
                // print_r($rsdata);
                // $data['total'] = $total;
                ?>
                <div class="col-md-3">
                    <a href="Report">
                    <!-- START WIDGET REGISTRED -->
                    <div class="widget widget-default widget-item-icon">
                        <div class="widget-item-left">
                            <span class="fa fa-fire"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count"><?php echo $total; ?></div>
                            <div class="widget-title">Total Incident Reports</div>
                            <div class="widget-subtitle"></div>
                        </div>
                    </div>
                    <!-- END WIDGET REGISTRED -->
                    </a>
                </div>
                <div class="col-md-3">

                    <!-- START WIDGET CLOCK -->
                    <div class="widget widget-info widget-padding-sm">
                        <div class="widget-big-int plugin-clock">00:00</div>
                        <div class="widget-subtitle plugin-date">Loading...</div>

                    </div>
                    <!-- END WIDGET CLOCK -->

                </div>
            </div>
            <div class="row" style="margin-bottom:30px">
                <?php
                    $cur_date = getCurrentDate();
                    $crt_date = date('Y/m/d');
                    //$cur_date = "2020/12/21";
                   //$total_sos = $this->beats_model->select_data('count(*) as newsos', 'SOSManagement', '', '', '', array('created_at', $cur_date), '');
                  $todays_sos = $this->beats_model->get_today_sos('created_at', $crt_date);
                  $tso = $todays_sos->num_rows();
                ?>
                <div class="col-md-3">
                    <a href="SOSManagement">
                    <!-- START WIDGET MESSAGES -->
                    <div class="widget widget-default widget-item-icon">
                        <div class="widget-item-left">
                            <span class="fa fa-exclamation-triangle"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count"><?php echo $tso; //$total_sos[0]['newsos']; ?></div>
                            <div class="widget-title">Today's SOS</div>
                            <div class="widget-subtitle"></div>
                        </div>
                    </div>
                    <!-- END WIDGET MESSAGES -->
                    </a>
                </div>
                
                <?php
                $cur_date = getCurrentDate();
                $data = $this->beats_model->select_data('count(*) as total', 'iWitness', '', '', '', array('update_at', $cur_date), '');
                $data1 = $this->beats_model->select_data('count(*) as total', 'Officer_Abuse', '', '', '', array('update_at', $cur_date), '');
                $data2 = $this->beats_model->select_data('count(*) as total', 'Commend_Officer', '', '', '', array('update_at', $cur_date), '');
                $data3 = $this->beats_model->select_data('count(*) as total', 'StolenVehicle_report', '', '', '', array('update_at', $cur_date), '');
                $data4 = $this->beats_model->select_data('count(*) as total', 'Missing_Persons_report', '', '', '', array('update_at', $cur_date), '');
                $data5 = $this->beats_model->select_data('count(*) as total', 'Lodgecomplaint_report', '', '', '', array('update_at', $cur_date), '');
                $data6 = $this->beats_model->select_data('count(*) as total', 'Gun_Violence_report', '', '', '', array('update_at', $cur_date), '');
                $data7 = $this->beats_model->select_data('count(*) as total', 'Drug_Abuse_report', '', '', '', array('update_at', $cur_date), '');
                $data8 = $this->beats_model->select_data('count(*) as total', 'Domestic_Violence_report', '', '', '', array('update_at', $cur_date), '');
                $data9 = $this->beats_model->select_data('count(*) as total', 'Terrorist_Attack_report', '', '', '', array('update_at', $cur_date), '');
                $data10 = $this->beats_model->select_data('count(*) as total', 'Rape_report', '', '', '', array('update_at', $cur_date), '');
                $data11 = $this->beats_model->select_data('count(*) as total', 'Kidnap_report', '', '', '', array('update_at', $cur_date), '');
                $data12 = $this->beats_model->select_data('count(*) as total', 'Robbery_report', '', '', '', array('update_at', $cur_date), '');
                $data13 = $this->beats_model->select_data('count(*) as total', 'Burglary_report', '', '', '', array('update_at', $cur_date), '');
                $data14 = $this->beats_model->select_data('count(*) as total', 'CybercrimeFraud_report', '', '', '', array('update_at', $cur_date), '');
                $data15 = $this->beats_model->select_data('count(*) as total', 'Submit_Tip_report', '', '', '', array('update_at', $cur_date), '');
                $data16 = $this->beats_model->select_data('count(*) as total', 'Others_report', '', '', '', array('update_at', $cur_date), '');

                $data17 = $this->beats_model->select_data('count(*) as total', 'Vandalism_report', '', '', '', array('update_at', $cur_date), '');
                $data18 = $this->beats_model->select_data('count(*) as total', 'Fire_report', '', '', '', array('update_at', $cur_date), '');
                $data19 = $this->beats_model->select_data('count(*) as total', 'Accident_report', '', '', '', array('update_at', $cur_date), '');
                $data20 = $this->beats_model->select_data('count(*) as total', 'Medical_report', '', '', '', array('update_at', $cur_date), '');
                $data21 = $this->beats_model->select_data('count(*) as total', 'Riot_report', '', '', '', array('update_at', $cur_date), '');
                $data22 = $this->beats_model->select_data('count(*) as total', 'Environmental_Hazard_report', '', '', '', array('update_at', $cur_date), '');
                $data23 = $this->beats_model->select_data('count(*) as total', 'Child_Abuse_report', '', '', '', array('update_at', $cur_date), '');
                $data24 = $this->beats_model->select_data('count(*) as total', 'Human_Trafficking_report', '', '', '', array('update_at', $cur_date), '');
                $data25 = $this->beats_model->select_data('count(*) as total', 'Blow_Whistle_report', '', '', '', array('update_at', $cur_date), '');
                
                $count_data = $data[0]['total'] + $data1[0]['total'] + $data2[0]['total'] + $data3[0]['total'] + $data4[0]['total'] + $data5[0]['total'] + $data6[0]['total'] 
                            + $data7[0]['total'] + $data8[0]['total'] + $data9[0]['total'] + $data10[0]['total'] + $data11[0]['total'] + $data12[0]['total'] + $data13[0]['total'] 
                            + $data14[0]['total'] + $data15[0]['total'] + $data16[0]['total'] + $data17[0]['total'] + $data18[0]['total'] + $data19[0]['total']
                            + $data20[0]['total'] + $data21[0]['total'] + $data22[0]['total'] + $data23[0]['total'] + $data24[0]['total'] + $data25[0]['total'];

                /*$data['filedcategory'] = $this->beats_model->select_data('*', 'FiledReports_category');
                $rsdata = array();
                $total = 0;
                $i = 0;
                foreach ($data['filedcategory'] as $catr) {
                    $r = 'nsresult' . $i;
                    $ds = array(
                        'FiledReport_name' => $catr['FiledReport_name'],
                        'FiledReports_tablename' => $catr['FiledReports_tablename'],
                        'total' => $data[$r][0]['total']
                    );
                    array_push($rsdata, $ds);
                    $total = $total + $data[$r][0]['total'];

                    $i++;
                }*/
                ?>
                 <div class="col-md-3">
                    <a href="Report">
                    <!-- START WIDGET MESSAGES -->
                    <div class="widget widget-default widget-item-icon">
                        <div class="widget-item-left">
                            <span class="fa fa-fire"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count"><?php echo $count_data; ?></div>
                            <div class="widget-title">Today's Incident Report</div>
                            <div class="widget-subtitle"></div>
                        </div>
                    </div>
                    <!-- END WIDGET MESSAGES -->
                    </a>
                </div>
                
                <?php
                    $total_citizen = $this->beats_model->select_data('count(*) as newsos', 'Officer', '', '', '', '', '');
                ?>    
                 <div class="col-md-3">
                    <a href="RegisteredOfficer">
                    <!-- START WIDGET MESSAGES -->
                    <div class="widget widget-default widget-item-icon">
                        <div class="widget-item-left">
                            <span class="fa fa-users"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count"><?php echo $total_citizen[0]['newsos']; ?></div>
                            <div class="widget-title">Total Officers</div>
                            <div class="widget-subtitle"></div>
                        </div>
                    </div>
                    <!-- END WIDGET MESSAGES -->
                    </a>
                </div>
                
                <?php
                    $total_citizen = $this->beats_model->select_data('count(*) as newsos', 'user_signup', '', '', '', '', '');
                ?>    
                <div class="col-md-3">
                    <a href="Registeredusers">
                    <!-- START WIDGET MESSAGES -->
                    <div class="widget widget-default widget-item-icon">
                        <div class="widget-item-left">
                            <span class="fa fa-user"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count"><?php echo $total_citizen[0]['newsos']; ?></div>
                            <div class="widget-title">Total Citizens</div>
                            <div class="widget-subtitle"></div>
                        </div>
                    </div>
                    <!-- END WIDGET MESSAGES -->
                    </a>
                </div>
            </div>
            
            <div class="row" style="margin-bottom:30px">
                <?php
                    $total_edirectory = $this->beats_model->select_data('count(*) as newsos', 'user_directories_old_8_6_2020', '', '', '', '', '');
                ?>
                <div class="col-md-3">
                    <a href="eDirectory">
                    <!-- START WIDGET MESSAGES -->
                    <div class="widget widget-default widget-item-icon">
                        <div class="widget-item-left">
                            <span class="fa fa-briefcase"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count"><?php echo $total_edirectory[0]['newsos']; ?></div>
                            <div class="widget-title">Total eDirectory</div>
                            <div class="widget-subtitle"></div>
                        </div>
                    </div>
                    <!-- END WIDGET MESSAGES -->
                    </a>
                </div>
                
                <?php
                    $total_vehicle_profile = $this->beats_model->select_data('count(*) as newsos', 'Vehicle_Profile', '', '', '', '', '');
                ?>
                <div class="col-md-3">
                    <a href="VehicleProfile">
                    <!-- START WIDGET MESSAGES -->
                    <div class="widget widget-default widget-item-icon">
                        <div class="widget-item-left">
                            <span class="fa fa-car"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count"><?php echo $total_vehicle_profile[0]['newsos']; ?></div>
                            <div class="widget-title">Total Vehicle Profile</div>
                            <div class="widget-subtitle"></div>
                        </div>
                    </div>
                    <!-- END WIDGET MESSAGES -->
                    </a>
                </div>
                
                <?php
                    $total_property_profile = $this->beats_model->select_data('count(*) as newsos', 'Property_Profile', '', '', '', '', '');
                ?>
                <div class="col-md-3">
                    <a href="PropertyProfile">
                    <!-- START WIDGET MESSAGES -->
                    <div class="widget widget-default widget-item-icon">
                        <div class="widget-item-left">
                            <span class="fa fa-home"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count"><?php echo $total_property_profile[0]['newsos']; ?></div>
                            <div class="widget-title">Total Property Profile</div>
                            <div class="widget-subtitle"></div>
                        </div>
                    </div>
                    <!-- END WIDGET MESSAGES -->
                    </a>
                </div>
                
                <?php
                    $public_event = $this->beats_model->select_data('count(*) as newsos', 'Public_Events', '', '', '', '', '');
                    $security_tip = $this->beats_model->select_data('count(*) as newsos', 'Security_Tips', '', '', '', '', '');
                    $traffic_report = $this->beats_model->select_data('count(*) as newsos', 'Traffic_Reports', '', '', '', '', '');
                    $wanted_person = $this->beats_model->select_data('count(*) as newsos', 'Wanted_Persons', '', '', '', '', '');
                    $missing_person = $this->beats_model->select_data('count(*) as newsos', 'Missing_Persons', '', '', '', '', '');
                    $stolen_vehicle = $this->beats_model->select_data('count(*) as newsos', 'Stolen_Vehicle', '', '', '', '', '');
                    
                    $total_enotice = $public_event[0]['newsos'] + $security_tip[0]['newsos'] + $traffic_report[0]['newsos'] + $wanted_person[0]['newsos'] +
                                    $missing_person[0]['newsos'] + $stolen_vehicle[0]['newsos'];
                ?>    
                 <div class="col-md-3">
                    <a href="WantedPersons">
                    <!-- START WIDGET MESSAGES -->
                    <div class="widget widget-default widget-item-icon">
                        <div class="widget-item-left">
                            <span class="fa fa-bullhorn"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count"><?php echo $total_enotice; ?></div>
                            <div class="widget-title">Total eNotice</div>
                            <div class="widget-subtitle"></div>
                        </div>
                    </div>
                    <!-- END WIDGET MESSAGES -->
                    </a>
                </div>
                
            </div>
            
            <!-- END WIDGETS -->

            <div class="row">
                
                <?php
                    $total_police_unit_type = $this->beats_model->select_all_template('PoliceUnitType')->num_rows();
                ?>
                <div class="col-md-3">
                    <a href="police-unit-type">
                    <!-- START WIDGET MESSAGES -->
                    <div class="widget widget-default widget-item-icon">
                        <div class="widget-item-left">
                            <span class="fa fa-building"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count"><?php echo $total_police_unit_type; ?></div>
                            <div class="widget-title">Total Unit Type</div>
                            <div class="widget-subtitle">Officer locator</div>
                        </div>
                    </div>
                    <!-- END WIDGET MESSAGES -->
                    </a>
                </div>
                
                <?php
                    $total_unit_type = $this->beats_model->select_data('count(*) as newsos', 'PoliceUnit', '', '', '', '', '');
                ?>
                <div class="col-md-3">
                    <a href="PoliceUnit">
                    <!-- START WIDGET MESSAGES -->
                    <div class="widget widget-default widget-item-icon">
                        <div class="widget-item-left">
                            <span class="fa fa-building"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count"><?php echo $total_unit_type[0]['newsos']; ?></div>
                            <div class="widget-title">Total Unit</div>
                            <div class="widget-subtitle">Officer locator</div>
                        </div>
                    </div>
                    <!-- END WIDGET MESSAGES -->
                    </a>
                </div>
                
                <?php
                    $total_admin = $this->beats_model->select_data('count(*) as newsos', 'admin', '', '', '', '', '');
                ?>
                <div class="col-md-3">
                    <a href="sub-admins">
                    <!-- START WIDGET MESSAGES -->
                    <div class="widget widget-default widget-item-icon">
                        <div class="widget-item-left">
                            <span class="fa fa-lock"></span>
                        </div>
                        <div class="widget-data">
                            <div class="widget-int num-count"><?php echo $total_admin[0]['newsos']; ?></div>
                            <div class="widget-title">Total Admin</div>
                            <div class="widget-subtitle"></div>
                        </div>
                    </div>
                    <!-- END WIDGET MESSAGES -->
                    </a>
                </div>
            </div>


            <!-- START DASHBOARD CHART -->

            <!-- END DASHBOARD CHART -->

        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->