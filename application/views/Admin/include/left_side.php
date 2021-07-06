<?php include('menuactive.php'); ?>
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
<div class="page-sidebar">
    <!-- START X-NAVIGATION -->
    <ul class="x-navigation">
        <li class="xn-logo">

            <a style="padding-left:0" href="<?php echo base_url('/Dashboard/'); ?>">
                <img width="50px" style="" src="<?php echo base_url('/assets/admin/img/asas_logo.png'); ?>">
                <span style="color:#333365;font-size: 16px;font-weight: bold;">AB-SAS</span>
            </a>
            <a href="#" class="x-navigation-control"></a>
        </li>

<!-------------------------------------- code by invito / rummy ------------------------------------>

        <?php 
        
        if($_SESSION['role'] == 0)
        {
        
        ?>
        <li clas="xn-openable adpro">
            <a href="<?php echo base_url('/sub-admins'); ?>"><span class="fa fa-desktop"></span> <span class="xn-text">Manage sub-admins</span></a>
        </li>
        <?php } ?>

<!-------------------------------------------------------------------------------------------------->

        <li class="active">
            <a href="<?php echo base_url('/Dashboard'); ?>"><span class="fa fa-dashboard"></span> <span class="xn-text">Dashboard</span></a>
        </li>
        
        <li clas="xn-openable adpro">
            <a href="<?php echo base_url('/adminprofile'); ?>"><span class="fa fa-desktop"></span> <span class="xn-text">Profile</span></a>
        </li>

        <li class="xn-openable member1">
            <a href=""><span class="fa fa-user"></span> <span class="xn-text">User management</span></a>
            <ul>
                <li><a href="<?php echo base_url('Registeredusers'); ?>"><span class="fa fa-group"></span>Registered users</a></li>
                <li><a href="<?php echo base_url('Verifiedusers'); ?>"><span class="fa fa-download"></span>Verified users</a></li>
                <!-- <li><a href="<?php //echo base_url('Anonymoususers'); 
                                    ?>"><span class="fa fa-download"></span>Anonymous users</a></li> -->
                <li><a href="<?php echo base_url('Userlog'); ?>"><span class="fa fa-history"></span>User Logs</a></li>
            </ul>
        </li>
        <li class="xn-openable member11">
            <a href=""><span class="fa fa-user"></span> <span class="xn-text">Officer management</span></a>
            <ul>
                <li><a href="<?php echo base_url('RegisteredOfficer'); ?>"><span class="fa fa-group"></span>Registered Officer</a></li>
                <li><a href="<?php echo base_url('VerifiedOfficer'); ?>"><span class="fa fa-download"></span>Verified Officer</a></li>
                <li><a href="<?php echo base_url('Officerlog'); ?>"><span class="fa fa-history"></span>Officer Logs</a></li>
            </ul>
        </li>

<!-------------------------------------- code by invito / rummy ------------------------------------>


        <li class="xn-openable member13">
            <a href="<?php echo base_url('police-unit-type'); ?>"><span class="fa fa-building"></span> <span class="xn-text">Office Unit Types</span></a>
        </li>


<!-------------------------------------------------------------------------------------------------->


        <li class="xn-openable member13">
            <a href=""><span class="fa fa-building"></span> <span class="xn-text">Officer Unit Mgt</span></a>
            <ul>
                <li>
                    <a href="<?php echo base_url('PoliceUnit'); ?>"><span class="fa fa-home"></span> <span class="xn-text">Office Unit</span></a>
                </li>
                <li>
                    <a href="<?php echo base_url('OfficerUnit'); ?>"><span class="fa fa-phone-square"></span> <span class="xn-text">Emergency Numbers</span></a>
                </li>
            </ul>
        </li>
        <!-- <li class=" member13"> -->
        <!-- <a href="<?php echo base_url('PoliceUnit'); ?>"><span class="fa fa-user"></span> <span class="xn-text">NSCDC Unit Management</span></a> -->
        <!--<ul>  -->
        <!--    <li><a href="<?php echo base_url('CreateUnit'); ?>"><span class="fa fa-group"></span>Create Unit</a></li>-->
        <!--    <li><a href="<?php echo base_url('ManageUnit'); ?>"><span class="fa fa-download"></span>Manage Unit</a></li>-->
        <!--</ul>-->
        <!-- </li> -->
        <?php
        $total_ss = $this->beats_model->select_data('count(*) as newsos', 'SOSManagement', 'is_read = 1', '', array('SOS_id', 'DESC'), '', '');
        ?>
        <li class="xn-openable member12">
            <a href="<?php echo base_url('SOSManagement'); ?>" class="notification-m">
                <span class="fa fa-exclamation-triangle"></span>
                <span class="xn-text">SOS Management </span>

                <span class="badge-m" id="sosTotalM">
                    <?php echo $total_ss[0]['newsos']; ?>
                </span>

            </a>
            <!--<ul>  -->
            <!--    <li><a href="<?php echo base_url('CreatePitch'); ?>"><span class="fa fa-group"></span>Create Pitchs</a></li>-->
            <!--    <li><a href="<?php echo base_url('ManagePitch'); ?>"><span class="fa fa-download"></span>Manage Pitchs</a></li>-->
            <!--</ul>-->
        </li>

        <?php
        $data['nsresult0'] = $this->beats_model->select_data('count(*) as total', 'iWitness', 'is_read = 1', '', array('iWitness_id', 'DESC'));
        $data['nsresult1'] = $this->beats_model->select_data('count(*) as total', 'Officer_Abuse', 'is_read = 1', '', array('OfficerAbuse_id', 'DESC'));
        $data['nsresult2'] = $this->beats_model->select_data('count(*) as total', 'Commend_Officer', 'is_read = 1', '', array('CommendOffice_id', 'DESC'));
        $data['nsresult3'] = $this->beats_model->select_data('count(*) as total', 'StolenVehicle_report', 'is_read = 1', '', array('StolenVehicle_report_id', 'DESC'));
        $data['nsresult4'] = $this->beats_model->select_data('count(*) as total', 'Missing_Persons_report', 'is_read = 1', '', array('Missing_Persons_report_id', 'DESC'));
        $data['nsresult5'] = $this->beats_model->select_data('count(*) as total', 'Lodgecomplaint_report', 'is_read = 1', '', array('Lodgecomplaint_report_id', 'DESC'));
        $data['nsresult6'] = $this->beats_model->select_data('count(*) as total', 'Gun_Violence_report', 'is_read = 1', '', array('GunViolence_id', 'DESC'));
        $data['nsresult7'] = $this->beats_model->select_data('count(*) as total', 'Drug_Abuse_report', 'is_read = 1', '', array('DrugAbuse_report_id', 'DESC'));
        $data['nsresult8'] = $this->beats_model->select_data('count(*) as total', 'Domestic_Violence_report', 'is_read = 1', '', array('DomesticViolence_report_id', 'DESC'));
        $data['nsresult9'] = $this->beats_model->select_data('count(*) as total', 'Terrorist_Attack_report', 'is_read = 1', '', array('TerroristAttack_report_id', 'DESC'));
        $data['nsresult10'] = $this->beats_model->select_data('count(*) as total', 'Rape_report', 'is_read = 1', '', array('Rape_report_id', 'DESC'));
        $data['nsresult11'] = $this->beats_model->select_data('count(*) as total', 'Kidnap_report', 'is_read = 1', '', array('Kidnap_report_id', 'DESC'));
        $data['nsresult12'] = $this->beats_model->select_data('count(*) as total', 'Robbery_report', 'is_read = 1', '', array('Robbery_report_id', 'DESC'));
        $data['nsresult13'] = $this->beats_model->select_data('count(*) as total', 'Burglary_report', 'is_read = 1', '', array('Burglary_report_id', 'DESC'));
        $data['nsresult14'] = $this->beats_model->select_data('count(*) as total', 'CybercrimeFraud_report', 'is_read = 1', '', array('CybercrimeFraud_report_id', 'DESC'));
        $data['nsresult15'] = $this->beats_model->select_data('count(*) as total', 'Submit_Tip_report', 'is_read = 1', '', array('Submit_Tip_id', 'DESC'));
        $data['nsresult16'] = $this->beats_model->select_data('count(*) as total', 'Others_report', 'is_read = 1', '', array('Others_report_id', 'DESC'));

        $data['nsresult17'] = $this->beats_model->select_data('count(*) as total', 'Vandalism_report', 'is_read = 1', '', array('Vandalism_report_id', 'DESC'));
        $data['nsresult18'] = $this->beats_model->select_data('count(*) as total', 'Fire_report', 'is_read = 1', '', array('Fire_report_id', 'DESC'));
        $data['nsresult19'] = $this->beats_model->select_data('count(*) as total', 'Accident_report', 'is_read = 1', '', array('Accident_report_id', 'DESC'));
        $data['nsresult20'] = $this->beats_model->select_data('count(*) as total', 'Medical_report', 'is_read = 1', '', array('Medical_report_id', 'DESC'));
        $data['nsresult21'] = $this->beats_model->select_data('count(*) as total', 'Riot_report', 'is_read = 1', '', array('Riot_report_id', 'DESC'));
        $data['nsresult22'] = $this->beats_model->select_data('count(*) as total', 'Environmental_Hazard_report', 'is_read = 1', '', array('Environmental_Hazard_report_id', 'DESC'));
        $data['nsresult23'] = $this->beats_model->select_data('count(*) as total', 'Child_Abuse_report', 'is_read = 1', '', array('Child_Abuse_report_id', 'DESC'));
        $data['nsresult24'] = $this->beats_model->select_data('count(*) as total', 'Human_Trafficking_report', 'is_read = 1', '', array('Human_Trafficking_report_id', 'DESC'));
        $data['nsresult25'] = $this->beats_model->select_data('count(*) as total', 'Blow_Whistle_report', 'is_read = 1', '', array('Blow_Whistle_report_id', 'DESC'));

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

        <li class=" member2">
            <a href="<?php echo base_url('FiledReport'); ?>" class="notification-m">
                <span class="fa fa-archive"></span> <span class="xn-text">Filed Report Mgt</span>

                <span class="badge-m" id="filedTotalM">
                    <?php echo $total; ?>
                </span>

            </a>
            <!--<ul>  -->
            <!--    <li><a href="<?php echo base_url('CreateQuiz'); ?>"><span class="fa fa-group"></span>Create Quiz</a></li>-->
            <!--    <li><a href="<?php echo base_url('ManageQuiz'); ?>"><span class="fa fa-download"></span>Manage Quiz</a></li>-->
            <!--</ul>-->
        </li>

        <li class=" member3">
            <a href="<?php echo base_url('Report'); ?>"><span class="fa fa-file"></span> <span class="xn-text">Report</span></a>
            <!--<ul>  -->
            <!--    <li><a href="<?php echo base_url('CreatePollsPredictions'); ?>"><span class="fa fa-group"></span>Create Polls&Predictions</a></li>-->
            <!--    <li><a href="<?php echo base_url('ManagePollsPredictions'); ?>"><span class="fa fa-download"></span>Manage Polls&Predictions</a></li>-->
            <!--</ul>-->
        </li>
        <li class="xn-openable member4">
            <a href=""><span class="fa fa-bullhorn"></span> <span class="xn-text">eNotices</span></a>
            <ul>
                <li><a href="<?php echo base_url('WantedPersons'); ?>"><span class="fa fa-eye"></span>Wanted Persons</a></li>
                <!--Wanted Persons-->
                <li><a href="<?php echo base_url('MissingPersons'); ?>"><span class="fa fa-group"></span>Missing Persons</a></li>
                <!--Missing Persons-->
                <li><a href="<?php echo base_url('PublicEvents'); ?>"><span class="fa fa-share-alt-square"></span>Public Events</a></li>
                <!--Publics-->
                <li><a href="<?php echo base_url('StolenVehicle'); ?>"><span class="fa fa-car"></span>Stolen vehicle</a></li>
                <!--Stolen-->
                <li><a href="<?php echo base_url('SecurityTips'); ?>"><span class="fa fa-shield"></span>Safety and Security Tips</a></li>
                <!--Traffic -->
                <li><a href="<?php echo base_url('TrafficReports'); ?>"><span class="fa fa-road"></span>Traffic Reports</a></li>
                <!--tips-->
                <li><a href="#"><span class="fa fa-key"></span>Private Security</a></li>
            </ul>
        </li>
        <li class="xn-openable member7">
            <a href=""><span class="fa fa-folder-open"></span> <span class="xn-text">eDirectory</span></a>
            <ul>
                <li><a href="<?php echo base_url('eDirectory'); ?>"><span class="fa fa-briefcase"></span>User Business</a></li>
                <!-- <li><a href="<?php echo base_url('BusinessCategory'); ?>"><span class="fa fa-group"></span>Business Category</a></li> -->
            </ul>
        </li>
        <li class="xn-openable member5">
            <a href=""><span class="fa fa-database"></span> <span class="xn-text">Vehicle/Property Profile</span></a>
            <ul>
                <li><a href="<?php echo base_url('VehicleProfile'); ?>"><span class="fa fa-car"></span>Vehicle Profile</a></li>
                <li><a href="<?php echo base_url('PropertyProfile'); ?>"><span class="fa fa-building"></span>Property Profile</a></li>
            </ul>
        </li>
        <li class="member6">
            <a href="<?php echo base_url('CrimeMap'); ?>"><span class="fa fa-map-marker"></span> <span class="xn-text">Crime Map</span></a>
            <!--<ul>  -->
            <!--    <li><a href="<?php echo base_url('CreateNotification'); ?>"><span class="fa fa-group"></span>Create Notification</a></li>-->
            <!--    <li><a href="<?php echo base_url('ManageNotification'); ?>"><span class="fa fa-download"></span>Manage Notification</a></li>-->
            <!--</ul>-->
        </li>

        <!-------------------------------------- code by invito / rummy ------------------------------------>

        <li class="member6">
            <a href="<?php echo base_url('application-settings'); ?>"><span class="fa fa-gears"></span> <span class="xn-text">Application Settings</span></a>
        </li>
         <li class="member6">
        <!--    <a href="<?php echo base_url('application-agency'); ?>"><span class="fa fa-gears"></span> <span class="xn-text">Agency</span></a>-->
        <!--</li>-->
        
          <li class="xn-openable member1">
          <a href="<?php echo base_url('AgencyList'); ?>"><span class="fa fa-group"></span>Agency List</a>
        </li>

        <?php 
        if($_SESSION['role'] == 0)
        {
        ?>
        <li class="member6">
            <a href="<?php echo base_url('Subadminlogs'); ?>"><span class="fa fa-table"></span> <span class="xn-text">Sub-admin Logs</span></a>
        </li>
        <?php  } ?>

        <!-------------------------------------------------------------------------------------------------->
        <!-- <li class="xn-openable member7">-->
        <!--    <a href=""><span class="fa fa-user"></span> <span class="xn-text">App Slider</span></a>-->
        <!--    <ul>  -->
        <!--        <li><a href="<?php echo base_url('CreateSlider'); ?>"><span class="fa fa-group"></span>Create Slider</a></li>-->
        <!--        <li><a href="<?php echo base_url('ManageSlider'); ?>"><span class="fa fa-download"></span>Manage Slider</a></li>-->
        <!--    </ul>-->
        <!--</li>-->
    </ul>
    <!-- END X-NAVIGATION -->
</div>